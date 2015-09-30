<?php

class projectModel extends model
{ 
    /**
     * 新增一个项目
     */
    public function create()
    {
    	$project = fixer::input('post')->get();
    	$cha_proj = array();  
    	$cha_proj['creator_ID'] = $this->session->user->account;
    	$cha_proj['name'] = $project->name;
    	$cha_proj['description'] = $project->description;
    	$cha_proj['other_account'] = implode('|', $project->members);
    	$cha_proj['starttime'] = $project->starttime;
    	$cha_proj['updatetime'] = date('Y-m-d H:i:s');
    	$cha_proj['tea_ID'] = $project->teacher;
    	$cha_proj['ACL'] = $project->ACL;
    	$cha_proj['deadline'] = $project->deadline;
        $cha_proj['createtime'] = date("Y-m-d H:i:s");

    	$this->dao->insert(TABLE_PROJECT)
    		->data($cha_proj)
            ->autoCheck()
    		->exec();

        $projectID = $this->dao->lastInsertID();
        $this->loadModel('file')->saveUpload('project', $projectID, '', $cha_proj['ACL']);

        if (dao::isError())
        {
            echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
        }

        /*send mail to inform the receiver*/
        $subject = $this->lang->project->mail->subject;
        $body = sprintf($this->lang->project->mail->body, $this->app->user->realname, common::getSysURL().helper::createLink('project', 'view', "projectID=".$projectID));
        $this->loadModel('mail')->send($project->teacher, $subject, $body, '', true);
        $this->loadModel('action')->create('project', $projectID, 'created');

        return $projectID;
    }

    /**
     * 修改数据库中某条记录
     */
    public function update($projectID)
    {
        $project = fixer::input('post')->get();

        $cha_proj['name'] = $project->name;
        $cha_proj['description'] = $project->description;
        $cha_proj['other_account'] = implode("|", $project->mailto);
        $cha_proj['starttime'] = $project->starttime;
        $cha_proj['updatetime'] = date('Y-m-d H:i:s');
        $cha_proj['tea_ID'] = $project->teacher;
        $cha_proj['ACL'] = $project->ACL;
        $cha_proj['deadline'] = $project->deadline;
        $cha_proj['type'] = $project->type;
        $cha_proj['kind'] = $project->kind;
        $cha_proj['PID'] = $project->PID;
        
        
        $this->dao->update(TABLE_PROJECT)
            ->data($cha_proj)
            ->autoCheck()
            ->where('id')->eq($projectID)
            ->exec();
        
        $this->dao->update(TABLE_FILE)->set('acl')->eq($cha_proj['ACL'])->where('objectType')->eq('project')->andWhere('objectID')->eq($projectID)->andWhere('deleted')->eq(0)->exec();
        $this->loadModel('file')->saveUpload('project', $projectID, '', $cha_proj['ACL']);

        if (dao::isError())
        {
            echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
        }

        /*send mail to inform the receiver*/
        $editsubject = $this->lang->project->mail->editsubject;
        $editbody = sprintf($this->lang->project->mail->editbody, $this->app->user->realname, common::getSysURL().helper::createLink('project', 'view', "projectID=".$projectID));
        $this->loadModel('mail')->send($project->teacher, $editsubject, $editbody, '', true);
        $this->loadModel('action')->create('project', $projectID, 'created');
    }

    /**
     * 完成项目
     */
    public function finish($projectID)
    {
        $project = $this->getProjectByPID($projectID);
        $data->finishtime = date('Y-m-d H:i:s');
        $data->updatetime = $date->finishtime;

        $this->dao->update(TABLE_PROJECT)
            ->data($data)
            ->where('id')->eq($projectID)
            ->exec();

        /*send mail to inform the receiver*/
        $finishsubject = $this->lang->project->mail->finishsubject;
        $finishbody = sprintf($this->lang->project->mail->finishbody, $this->app->user->realname, common::getSysURL().helper::createLink('project', 'view', "projectID=".$projectID));
        $this->loadModel('mail')->send($project->tea_ID, $finishsubject, $finishbody, '', true);
        $this->loadModel('action')->create('project', $projectID, 'created');

        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }
    }

    public function delete($id)
    {
        $data->deleted = 1;
        $data->updatetime = date('Y-m-d H:i:s');

        $this->dao->update(TABLE_PROJECT)
            ->data($data)
            ->where('id')->eq($id)
            ->exec();
        $this->dao->update(TABLE_FILE)->set('deleted')->eq(1)->where('objectType')->eq('project')->andWhere('objectID')->eq($id)->andWhere('deleted')->eq(0)->exec();
        $this->loadModel('task')->deleteComment($id, 'P');
        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }
    }

    /**
     * 学生获取项目的所有信息
     */
    public function getProjectByStudent($account = '', $pager = null, $orderBy = '', $paramname = '', $paramstu = '', $paramtea = '')
    {
        if(!$account) $account = $this->session->user->account;
        if(!$orderBy) $orderBy = 'id_desc';
        $paramtea = $this->loadModel('user')->getAccountByName($paramtea);
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);
        $projects = $this->dao
                        ->select('*')
                        ->from(TABLE_PROJECT)
                        ->where('deleted')->eq(0)
                        ->addand()->markLeft(1)
                        ->addfield(creator_ID)->eq($account)            
                        ->orwhere('other_account')->like('%' . $account . '%') 
                        ->markRight(1)
                        ->andWhere('name')->like('%' . $paramname . '%')
                        ->andWhere('creator_ID')->in($paramstu)
                        ->andWhere('tea_ID')->in($paramtea)  
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'project');
        
        return $projects;
    }

    /**
     * 导师获取项目的所有信息
     */
    public function getProjectBytutor($account = '', $pager = null, $orderBy = '', $paramname = '', $paramstu = '', $paramtea = '')
    {
        if(!$account) $account = $this->session->user->account;
        if(!$orderBy) $orderBy = 'id_desc';
        $paramtea = $this->loadModel('user')->getAccountByName($paramtea);
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);

        $projects = $this->dao
                        ->select('*')
                        ->from(TABLE_PROJECT)
                        ->where('deleted')->eq(0)
                        ->andwhere('tea_ID')->eq($account)  
                        ->andWhere('name')->like('%' . $paramname . '%')
                        ->andWhere('creator_ID')->in($paramstu)
                        ->andWhere('tea_ID')->in($paramtea)
                        ->orderBy($orderBy)          
                        ->page($pager)                  
                        ->fetchAll();
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'project');
        
        return $projects;
    }

    public function getProjectByManager($account = '', $pager = null, $orderBy = '', $field = '', $paramname = '', $paramstu = '', $paramtea = '')
    {
        if(!$account) $account = $this->session->user->account;
        if(!$orderBy) $orderBy = 'id_desc';
        if (!$field) $field = 't1.creator_ID=t2.account';
        $paramtea = $this->loadModel('user')->getAccountByName($paramtea);
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);
        $grade = $this->session->user->grade;
        $projects = $this->dao->select('t1.*')
                        ->from(TABLE_PROJECT)->alias(t1)
                        ->leftJoin(TABLE_USER)->alias(t2)
                        ->on($field)
                        ->where('t1.deleted')->eq(0)
                        ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                        ->andWhere('t1.ACL')->eq(3)
                        ->andWhere('t1.name')->like('%' . $paramname . '%')
                        ->andWhere('t1.creator_ID')->in($paramstu)
                        ->andWhere('t1.tea_ID')->in($paramtea)
                        ->beginIF($grade != '')->andWhere('t2.grade')->in($grade)->fi()
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'project');
        
        return $projects;
    }

    public function getAllProject($orderBy = '', $pager = null, $paramname = '', $paramstu = '', $paramtea = '')
    {
        if(!$orderBy) $orderBy = 'id_desc';
        $paramtea = $this->loadModel('user')->getAccountByName($paramtea);
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);

        $projects =  $this->dao->select('*')
                    ->from(TABLE_PROJECT)
                    ->where('ACL')->eq(3)
                    ->andWhere('deleted')->eq(0)
                    ->andWhere('name')->like('%' . $paramname . '%')
                    ->andWhere('creator_ID')->in($paramstu)
                    ->andWhere('tea_ID')->in($paramtea)
                    ->orderBy($orderBy)
                    ->page($pager)
                    ->fetchAll();
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'project');
        
        return $projects;
    }
    /**
     * 根据项目id获取项目信息
     */
    public function getProjectByPID($ID, $is_onlybody = 'no', $setImgSize = true)
    {
        if(strtolower($is_onlybody) == 'yes')
            $imgsize = 300;
        else
            $imgsize = 800;

        $project = $this->dao
                ->select('*')
                ->from(TABLE_PROJECT)
                ->where('id')->eq($ID)
                ->fetch();
        $project->status = $this->checkStatus($project);
        $project->files = $this->loadModel('file')->getByObject('project', $ID);
        if($setImgSize) $project->description = $this->loadModel('file')->setImgSize($project->description,$imgsize);
        return $project;
    }

    /**
     * 确定项目状态
     * 0-未开始 1-正在进行 2-已超时 3-已完成
     */
    public function checkStatus($project)
    {      
        $cur_time = helper::now();
        if ($project->finishtime != null)
        {
            return 3;
        }
        else
        {
            if ($project->deadline < $cur_time)
            {
                return 2;
            }
            else
            {
                if ($cur_time >= $project->starttime)
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
        }
    }
    
    /**
     * 判断修改删除完成的权限
     */
    public function checkPriv($projectID)
    {
        $cur_account = $this->session->user->account;
        $creator_ID = $this->dao->select('creator_ID')
                        ->from(TABLE_PROJECT)
                        ->where('id')->eq($projectID)
                        ->fetch()->creator_ID;
        if ($creator_ID == $cur_account)
        { 
            return 1;      //可以进行删除修改
        }
        else
        { 
            return 0;      //不可以进行删除修改
        }
    }

    public function checkViewPriv($project)
    {
        $cur_account = $this->session->user->account;

        foreach (explode('|', $project->other_account) as $key => $member) 
        {
            if ($member == $cur_account)
                return 1;
        }

        if (($project->creator_ID == $cur_account) || ($project->tea_ID == $cur_account))
            return 1;

        $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($project->tea_ID)->andWhere('deleted')->eq(0)->fetch()->college_id;
 
        if (($collegeid != $this->session->userinfo->collegeid) && ($this->session->userinfo->roleid != 'admin')) 
            return 0;

        if ($project->ACL == 3) return 1;

        if ($this->session->userinfo->roleid == 'manager') return 0;

        if ($this->checkRelation($project->tea_ID, $cur_account))
        {
            if (($project->ACL == 2) || ($project->ACL == 3))
                return 1;
            else
                return 0;
        }
        else
        {
            if ($project->ACL == 3)
                return 1;
            else
                return 0;
        }
    }

    public function getOtherProject($account, $orderBy = '', $pager = null, $paramname = '', $paramstu = '')
    {
        $cur_account = $this->session->user->account;
        $cur_role = $this->session->userinfo->roleid;
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);
        if (!$orderBy) $orderBy = 'id_desc';

        if ($this->dao->select('roleid')->from(TABLE_USER)->where('account')->eq($account)->fetch()->roleid == 'teacher')
        { 
            $field = 'tea_ID';
        }
        else
        {  
            $field = 'creator_ID';
        }

        if ($cur_role == 'admin')
        {
            return $this->getAllProject($orderBy, $pager);
        }

        if (($cur_role != 'student') && ($cur_role != 'teacher'))
        {
            //return $this->getProjectByManager($account, $orderBy, $pager, 't1.'. $field .'=t2.account');
            return $this->dao->select('t1.*')
                        ->from(TABLE_PROJECT)->alias(t1)
                        ->leftJoin(TABLE_USER)->alias(t2)
                        ->on('t1.creator_ID=t2.account')
                        ->where('t1.ACL')->eq(3)
                        ->andWhere('t1.' . $field)->eq($account)
                        ->andWhere('t1.deleted')->eq(0)
                        ->andWhere('t2.deleted')->eq(0)
                        ->beginIF($this->session->user->grade != '')->andWhere('t2.grade')->in($this->session->user->grade)->fi()
                        ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        }
       
        if ($this->checkRelation($account, $cur_account))
        {            
            return $this->dao->select('*')
                        ->from(TABLE_PROJECT)
                        ->where('ACL')->in('2, 3')
                        ->andWhere('deleted')->eq(0)
                        ->andWhere($field)->eq($account)
                        ->andWhere('name')->like('%' . $paramname . '%')
                        ->andWhere('creator_ID')->in($paramstu)
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        }
        else
        {
            return $this->dao->select('*')
                        ->from(TABLE_PROJECT)
                        ->where('ACL')->eq(3)
                        ->andWhere('deleted')->eq(0)
                        ->andWhere($field)->eq($account)
                        ->andWhere('name')->like('%' . $paramname . '%')
                        ->andWhere('creator_ID')->in($paramstu)
                        ->orderBy($orderBy)
                        ->page($pager)
                        ->fetchAll();
        }
    }

    public function checkRelation($account1, $account2)
    {
        if ($account1 == $account2) return 1;
        $role1 = $this->dao->select('roleid')->from(TABLE_USER)->where('account')->eq($account1)->fetch()->roleid;
        $role2 = $this->dao->select('roleid')->from(TABLE_USER)->where('account')->eq($account2)->fetch()->roleid;
        if ($role1 == 'teacher')
        {
            if ($role2 == 'teacher')
            {
                return 0;
            }
            else
            {
                $res = $this->dao->select('*')
                        ->from(TABLE_RELATIONS)
                        ->where('tea_ID')->eq($account1)
                        ->andWhere('stu_ID')->eq($account2)
                        ->andWhere('deleted')->eq(0)
                        ->fetch();
            }        
        }
        else
        {
            if ($role2 == 'teacher')
            {
                $res = $this->dao->select('*')
                        ->from(TABLE_RELATIONS)
                        ->where('tea_ID')->eq($account2)
                        ->andWhere('stu_ID')->eq($account1)
                        ->andWhere('deleted')->eq(0)
                        ->fetch();
            }
            else
            {
                $students = $this->loadModel('common')->getTeamByStudent($account1);
                foreach ($students as $account => $name) 
                {
                    if ($account == $account2)
                        return 1;
                }
                return 0;
            }
        }
        
        if ($res != null)  return 1;
        else   return 0;
    }
}    
