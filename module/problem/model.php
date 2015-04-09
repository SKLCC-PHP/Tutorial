<?php

class problemModel extends model
{ 

    public function create()
    {
        $problem = fixer::input('post')->get();
        $now = helper::now();  
        $teachers = $this->post->teachers;

        foreach ($teachers as $teacher) 
        {   
            if (!$teacher) continue;
            $data = fixer::input('post')
                        ->add('asgID', $this->session->user->account)
                        ->add('acpID', $teacher)
                        ->add('createtime', $now)
                        ->remove('labels, teachers')->get();

            $this->dao->insert(TABLE_QUESTION)
                ->data($data)
                ->autoCheck()
                ->exec();

            $problemID = $this->dao->lastInsertID();
            $this->loadModel('file')->saveUpload('problem', $problemID, '', $data->ACL);

            if (dao::isError())
            {
                echo js::error(dao::getError());
                die(js::locate($this->server->http_referer, 'parent'));
            }
            $this->loadModel('action')->create('problem', $problemID, 'created');

            $subject = $this->lang->problem->mail->subject;
            $body = sprintf($this->lang->problem->mail->body, $this->app->user->realname, common::getSysURL().helper::createLink('problem', 'view', "problemID=".$problemID));
            $this->loadModel('mail')->send($teacher, $subject, $body, '', true);
        }
    }

    public function update($problemID)
    {
        $data = fixer::input('post')
            ->add('updatetime', date('Y-m-d H:i:s'))
            ->remove('labels,files')
            ->get();

        $this->dao->update(TABLE_QUESTION)
            ->data($data)
            ->autoCheck()
            ->where('id')->eq($problemID)
            ->exec();

        if(!dao::isError())
        {   
            $this->dao->update(TABLE_FILE)->set('acl')->eq($data->ACL)->where('objectType')->eq('problem')->andWhere('objectID')->eq($problemID)->andWhere('deleted')->eq(0)->exec();
            $this->loadModel('file')->saveUpload('problem', $problemID, '', $data->ACL);
            $editsubject = $this->lang->problem->mail->editsubject;
            $editbody = sprintf($this->lang->problem->mail->editbody, $this->app->user->realname, common::getSysURL().helper::createLink('problem', 'view', "problemID=".$taskID));
            $this->loadModel('mail')->send($teacher, $editsubject, $editbody, '', true);
        }
        else
        {
            echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
        }
    }

    public function delete($problemID)
    {
        $this->dao->update(TABLE_QUESTION)
               ->set('deleted')->eq(1)
               ->where('id')->eq($problemID)
               ->exec();
        $this->dao->update(TABLE_FILE)->set('deleted')->eq(1)->where('objectType')->eq('problem')->andWhere('objectID')->eq($problemID)->andWhere('deleted')->eq(0)->exec();
        
        $this->loadModel('task')->deleteComment($problemID, 'Q');
        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }       
    }

    public function complete($problemID)
    {
        $this->dao->update(TABLE_QUESTION)
               ->set('completetime')->eq(date('Y-m-d H:i:s'))
               ->where('id')->eq($problemID)
               ->exec();
               
        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }
    }

    /**
     * get problem list
     *
     * @param  string  $viewtype  see the type of question
     *         string  $field     the role of search object    
     */
    public function getProblems($viewtype = '', $account = '', $limit = null, $orderBy = '', $pager = null, $paramtitle = '',$paramstu = '', $paramtea = '')
    {
        $cur_role = $this->session->userinfo->roleid;

        if (!$viewtype) $viewtype = 'all';
        if (!$account) $account = $this->session->user->account;
        if (!$orderBy) $orderBy = 'createtime|desc';
        if ($cur_role == 'student') $field = 'asgID';
        else $field = 'acpID';
        $paramtea = $this->loadModel('user')->getAccountByName($paramtea);
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);
        
        if ($cur_role == 'admin')
        {
            return $this->dao->select('*')
                ->from (TABLE_QUESTION)
                ->where('ACL')->eq(3)
                ->andWhere('deleted')->eq(0)
                ->andWhere('title')->like('%' . $paramtitle . '%')
                ->andWhere('asgID')->in($paramstu)
                ->andWhere('acpID')->in($paramtea)
                ->orderBy($orderBy)
                ->page($pager)
                ->fetchAll();
        }

        if (($cur_role != 'teacher')&&($cur_role != 'student'))
        {
            $grade = $this->session->user->grade;
            $problems = $this->dao->select('t1.asgID, count(t1.acpID) as acpNum, t1.acpID, t1.title, t1.createtime, t1.ACL, t1.id, t1.solvetime')
                ->from (TABLE_QUESTION)->alias(t1)
                ->leftJoin(TABLE_USER)->alias(t2)
                ->on('t1.asgID=t2.account')
                ->where('t2.college_id')->eq($this->session->userinfo->collegeid)
                ->andWhere('t1.ACL')->eq(3)
                ->andWhere('t1.deleted')->eq(0)
                ->andWhere('t1.title')->like('%' . $paramtitle . '%')
                ->andWhere('t1.asgID')->in($paramstu)
                ->andWhere('t1.acpID')->in($paramtea)
                ->beginIF($grade != '')->andWhere('t2.grade')->in($grade)->fi()
                ->groupBy('t1.createtime')
                ->orderBy($orderBy)
                ->fetchAll();
            $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'problem');
            return $problems = $this->loadModel('statistics')->setPage($problems, $pager);

        }       
        
        if ($viewtype == 'all')
        {
            $problems = $this->dao->select('asgID, count(acpID) as acpNum, acpID, title, createtime, ACL, id, solvetime')
                ->from(TABLE_QUESTION)
                ->where($field)->eq($account)
                ->andWhere('deleted')->eq(0)
                ->andWhere('title')->like('%' . $paramtitle . '%')
                ->andWhere('asgID')->in($paramstu)
                ->andWhere('acpID')->in($paramtea)
                ->groupBy('createtime')
                ->orderBy($orderBy)
                ->limit($limit)
                ->fetchAll();
            $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'problem');
            return $problems = $this->loadModel('statistics')->setPage($problems, $pager);
        }

        if ($viewtype == 'isRead')
        {
            $problems = $this->dao->select('*')
                ->from(TABLE_QUESTION)
                ->where($field)->eq($account)
                ->andWhere('deleted')->eq(0)
                ->andWhere('readtime')->neqnull()
                ->andWhere('title')->like('%' . $paramtitle . '%')
                ->andWhere('asgID')->in($paramstu)
                ->andWhere('acpID')->in($paramtea)
                ->orderBy($orderBy)
                ->page($pager)
                ->limit($limit)
                ->fetchAll();
            $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'problem');
            return $problems;
        }

        if ($viewtype == 'unRead')
        {
            $problems = $this->dao->select('*')
                ->from(TABLE_QUESTION)
                ->where($field)->eq($account)
                ->andWhere('deleted')->eq(0)
                ->andWhere('readtime')->eqnull()
                ->andWhere('title')->like('%' . $paramtitle . '%')
                ->andWhere('asgID')->in($paramstu)
                ->andWhere('acpID')->in($paramtea)
                ->orderBy($orderBy)
                ->page($pager)
                ->limit($limit)
                ->fetchAll();
            $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'problem');
            return $problems;
        }

        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }

        return false;
    }

    
    public function getProblemById($problemID , $is_onlybody = 'no',$setImgSize = true)
    {
        if(strtolower($is_onlybody) == 'yes')
            $imgsize = 300;
        else
            $imgsize = 800;
        $problem =  $this->dao->select('*')
                    ->from(TABLE_QUESTION)
                    ->where('id')->eq($problemID)
                    ->andWhere('deleted')->eq(0)
                    ->fetch();
        $problem->files = $this->loadModel('file')->getByObject('problem', $problemID);

        if($setImgSize) $problem->content = $this->loadModel('file')->setImgSize($problem->content,$imgsize);
        return $problem;
    }

    public function getProblemsById($problemID, $is_onlybody = 'no', $setImgSize = true)
    {
        $createtime = $this->dao->select('createtime')->from(TABLE_QUESTION)
                        ->where('id')->eq($problemID)->fetch()->createtime;
        $problems = $this->dao->select('*')->from(TABLE_QUESTION)
                ->where('createtime')->eq($createtime)
                ->andWhere('deleted')->eq(0)
                ->fetchAll();
        if(!$problems) return false;
        if(strtolower($is_onlybody) == 'yes')
            $imgsize = 300;
        else
            $imgsize = 800;

        if($setImgSize) 
        {
            $problems['now']->content = $this->loadModel('file')->setImgSize($problems[$problemID]->content,$imgsize);
            $problems['now']->submitcontent = $this->loadModel('file')->setImgSize($problems[$problemID]->submitcontent,$imgsize);
        }
        $problems['now']->files = $this->loadModel('file')->getByObject('problem', $problemID);
        $problems['now']->submitfiles = $this->loadModel('file')->getByObject('submittask', $problemID);
        
        return $problems;
    }

    public function saveRead($problem)
    {
        $cur_account = $this->session->user->account;

        $account = $this->dao->select('readaccount')->from(TABLE_QUESTION)->where('id')->eq($problem->id)->fetch();
        if (strstr($account->readaccount, $cur_account) == false) 
        {
            $data = new stdclass();
            if (($cur_account == $problem->acpID) && ($problem->readtime == null))
            {
                $data->readtime = helper::now();
            }
            $data->readaccount = $account->readaccount . '|' . $cur_account;
            $this->dao->update(TABLE_QUESTION)->data($data)->where('id')->eq($problem->id)->exec();
        }

        if(dao::isError())
        {
            die(js::error(dao::getError()));
        }
    }

    

    public function savesolve($problem)
    {
        $cur_account = $this->session->user->account;
        if ($problem->asgID != $cur_account) 
        {
            $data['solvetime'] = date('Y-m-d H:i:s');
            $data['solID'] = $cur_account;

            $this->dao->update(TABLE_QUESTION)
                   ->data($data)
                   ->where('id')->eq($problem->id)
                   ->exec();

            if (dao::isError())
            {
                die(js::error(dao::getError()));
            }
        }
    }  

    public function deleteGroup($problem)
    {
        $problems = $this->dao->select('id')->from(TABLE_QUESTION)
                ->where('createtime')->eq($problem->createtime)
                ->andWhere('deleted')->eq(0)
                ->fetchAll();
        foreach ($problems as $value) {
            $this->delete($value->id);
            $this->loadModel('action')->create('problem', $value->id, 'deleted');
        }
    }

    public function getOtherProblem($account, $orderBy = '', $pager = null, $field = '')
    {
        $cur_account = $this->session->user->account;
        $cur_role = $this->session->userinfo->roleid;
        if (!$orderBy) $orderBy = 'id_desc';
        
        if (!$field) $field = 'asgID';

        if ($cur_role == 'admin')
        {
            return $this->dao->select('*')
                        ->from(TABLE_QUESTION)
                        ->where('ACL')->eq(3)
                        ->andWhere('deleted')->eq(0)
                        ->andWhere($field)->eq($account)
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        }

        if (($cur_role != 'teacher') && ($cur_role != 'student'))
        {
            return $this->dao->select('t1.*')
                        ->from(TABLE_QUESTION)->alias(t1)
                        ->leftJoin(TABLE_USER)->alias(t2)
                        ->on('t1.'.$field.'=t2.account')
                        ->where('t1.ACL')->eq(3)
                        ->andWhere('t1.' . $field)->eq($account)
                        ->andWhere('t1.deleted')->eq(0)
                        ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        }

        if ($this->loadModel('project')->checkRelation($cur_account, $account))
        {
            return $this->dao->select('*')
                        ->from(TABLE_QUESTION)
                        ->where('ACL')->in('2, 3')
                        ->andWhere('deleted')->eq(0)
                        ->andWhere($field)->eq($account)
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        }
        else
        {  
            return $this->dao->select('*')
                        ->from(TABLE_QUESTION)
                        ->where('ACL')->eq(3)
                        ->andWhere('deleted')->eq(0)
                        ->andWhere($field)->eq($account)
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        }
    }

    public function checkPriv($problem, $method)
    {
        $cur_role = $this->session->user->roleid;

        switch ($cur_role)
        {
        case 'student':
            return $this->checkStudentPriv($problem, $method);
            break;
        case 'teacher':
            return $this->checkTeacherPriv($problem, $method);
            break;
        case 'counselor':
            return $this->checkCouncelorPriv($problem, $method);
            break;
        case 'manager':
            return $this->checkManagerPriv($problem, $method);
            break;
        default: return 1;
        }           
    }

    private function checkStudentPriv($problem, $method)
    {
        $cur_account = $this->session->user->account;
        switch ($method)
        {
        case 'view':
            if ($problem->deleted == 1) return 0; 
            if ($problem->asgID == $cur_account) return 1;
            if ($this->loadModel('project')->checkRelation($cur_account, $problem->acpID))
            {
                if ($problem->ACL == 2) return 1;
            }
            $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($problem->asgID)->andWhere('deleted')->eq(0)->fetch()->college_id;
            if ($collegeid != $this->session->user->college_id) return 0;
            if ($problem->ACL == 3) return 1;  
            return 0;
            break;
        case 'edit':
            if ($problem->asgID == $cur_account)
            {
                if ($problem->completetime == null)
                    return 1;
            }
            return 0;
            break;
        case 'delete':
            if ($problem->asgID == $cur_account)
            {
                if ($problem->completetime == null)
                    return 1;
            }
            return 0;
            break;
        case 'complete':
            if ($problem->asgID == $cur_account)
            {
                if ($problem->completetime == null && $problem->solvetime)
                    return 1;
            }
            return 0;
            break;
        default:
            return 0;
        }
    }

    private function checkTeacherPriv($problem, $method)
    {
        $cur_account = $this->session->user->account;
        if ($method == 'view')
        {
            if ($problem->deleted == 1) return 0; 
            if ($problem->acpID == $cur_account) return 1;
            $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($problem->asgID)->andWhere('deleted')->eq(0)->fetch()->college_id;
            if ($collegeid != $this->session->user->college_id) return 0;
            if ($problem->ACL == 3) return 1;
            return 0;
        }
        else
            return 0;
    }

    private function checkManagerPriv($problem, $method)
    {
        if ($method == 'view')
        {
            if ($problem->deleted == 1) return 0; 
            if ($problem->ACL == 3)
                return 1;
            else
                return 0;
        }
        else
            return 0;
    }

    private function checkCouncelorPriv($problem, $method)
    {
        if ($method == 'view')
        {
            if ($problem->ACL == 3)
            {
                $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($problem->asgID)->andWhere('deleted')->eq(0)->fetch()->college_id;
                if ($collegeid == $this->session->user->college_id) return 1;
                return 0;
            }
        }
        else
            return 0;
    }
}    
