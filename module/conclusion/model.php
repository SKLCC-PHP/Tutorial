<?php
class conclusionModel extends model
{

    /**
     * Create a conclusion.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $conclusionFile = '';


        $conclusion = fixer::input('post')
            ->striptags('title')
            ->setForce('creatorID',  $this->app->user->account)
            ->add('createtime', helper::now())
            ->remove('files,labels')
            ->get();

        $this->dao->insert(TABLE_CONCLUSION)->data($conclusion)
            ->autoCheck()
            ->batchCheck($this->config->conclusion->create->requiredFields, 'notempty')
            ->exec();

        if(!dao::isError())
        {
            $conclusionID = $this->dao->lastInsertID();
            if(!empty($conclusionFile))
            {
                $conclusionFile->objectID = $conclusionID;
                $this->dao->insert(TABLE_FILE)->data($conclusionFile)->exec();
            }
            else
            {
                $conclusionFileTitle = $this->loadModel('file')->saveUpload('conclusion', $conclusionID);
                $conclusionFile = $this->dao->select('*')->from(TABLE_FILE)->where('id')->eq(key($conclusionFileTitle))->fetch();
                unset($conclusionFile->id);
            }
            $conclusionsID[$assignedTo] = $conclusionID;
        }
        else
        {
            echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
        }
    }

    /**
     * Update a conclusion.
     * 
     * @param  int    $conclusionID 
     * @access public
     * @return void
     */
    public function update($conclusionID)
    {
        $oldconclusion = $this->getById($conclusionID);
        $now     = helper::now();

        $conclusion    = fixer::input('post')
            ->striptags('title')
            ->setForce('updatetime',  $now)
            ->remove('files,labels')
            ->get();

        $this->dao->update(TABLE_CONCLUSION)->data($conclusion)
            ->autoCheck()
            ->batchCheckIF($this->config->conclusion->edit->requiredFields, 'notempty')
            ->where('id')->eq((int)$conclusionID)->exec();

        if(dao::isError())
        {
            echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
        }
    }

    /**
     * delete a conclusion.
     * 
     * @param  int    $conclusionID 
     * @access public
     * @return void
     */
    public function delete($conclusionID)
    {
        $this->dao->update(TABLE_FILE)->set('deleted')->eq(1)->where('objectType')->eq('conclusion')->andWhere('objectID')->eq($conclusionID)->andWhere('deleted')->eq(0)->exec();
      
        $this->loadModel('task')->deleteComment($conclusionID,'C');

        return $this->dao->update(TABLE_CONCLUSION)
                    ->set('deleted')->eq(1)
                    ->where('id')->eq((int)$conclusionID)->exec(); 
    }

    /**
     * Get conclusion info by Id.
     * 
     * @param  int    $conclusionID 
     * @param  bool   $setImgSize
     * @access public
     * @return object|bool
     */
    public function getById($conclusionID, $setImgSize = true)
    {
        $conclusion = $this->dao->select('t1.*, t2.realname AS assignedToRealName')
            ->from(TABLE_CONCLUSION)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')
            ->on('t1.creatorID = t2.account')
            ->where('t1.id')->eq((int)$conclusionID)
            ->andWhere('t1.deleted')->eq(0)
            ->fetch();

        if(!$conclusion) return false;
        if($setImgSize) $conclusion->content = $this->loadModel('file')->setImgSize($conclusion->content);
        foreach($conclusion as $key => $value) if(strpos($key, 'Date') !== false and !(int)substr($value, 0, 4)) $conclusion->$key = '';
        $conclusion->files = $this->loadModel('file')->getByObject('conclusion', $conclusionID);
        return $conclusion;
    }

    /**
     * Get conclusions of a user.
     * 
     * @param  string $account 
     * @param  string $type     the query type 
     * @param  int    $limit   
     * @param  object $pager   
     * @access public
     * @return array
     */
    public function getUserConclusions($account = 0, $orderBy = '', $pager = null, $paramtitle = '', $paramstu = '')
    {
        if(!$account)   $account = $this->app->user->account;
        if (!$orderBy) $orderBy = 'id_desc';
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);

        $conclusions = $this->dao->select('*')
            ->from(TABLE_CONCLUSION)
            ->where('creatorID')->eq($account)
            ->andWhere('deleted')->eq(0)    
            ->andWhere('title')->like('%' . $paramtitle . '%')
            ->andWhere('creatorID')->in($paramstu)      
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();

        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'conclusion');

        if($conclusions) return $conclusions;
        else return array();
    }

    public function getStudentConclusions($account = '', $orderBy = '', $pager = null, $paramtitle = '', $paramstu = '')
    {
        if (!$account) $account = $this->session->user->account;
        if (!$orderBy) $orderBy = 'createtime_desc';
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);

        $conclusions = $this->dao->select('t1.*')
                            ->from(TABLE_CONCLUSION)->alias(t1)
                            ->leftJoin(TABLE_RELATIONS)->alias(t2)
                            ->on('t1.creatorID=t2.stu_ID')
                            ->where('t2.deleted')->eq(0)
                            ->andWhere('t2.tea_ID')->eq($account)
                            ->andWhere('t1.deleted')->eq(0)
                            ->andWhere('title')->like('%' . $paramtitle . '%')
                            ->andWhere('creatorID')->in($paramstu)
                            ->orderBy($orderBy)
                            ->page($pager)
                            ->fetchAll();
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'conclusion');

        if($conclusions) return $conclusions;
        else return array();
    }

    public function getAllConclusions($orderBy = '', $pager = null, $paramtitle = '', $paramstu = '')
    {
        if (!$orderBy) $orderBy = 'createtime_desc';
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);

        $conclusions = $this->dao->select('*')
                            ->from(TABLE_CONCLUSION)
                            ->where('deleted')->eq(0)
                            ->andWhere('title')->like('%' . $paramtitle . '%')
                            ->andWhere('creatorID')->in($paramstu)
                            ->orderBy($orderBy)
                            ->page($pager)
                            ->fetchAll();
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'conclusion');

        if($conclusions) return $conclusions;
        else return array();
    }

    public function getCollegeConclusions($account = '', $orderBy = '', $pager = null, $paramtitle = '', $paramstu = '')
    {
        $cur_collegeid = $this->session->userinfo->collegeid;
        if (!$orderBy) $orderBy = 'createtime_desc';
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);
        
        $conclusions = $this->dao->select('t1.*')
                            ->from(TABLE_CONCLUSION)->alias(t1)
                            ->leftJoin(TABLE_USER)->alias(t2)
                            ->on('t1.creatorID=t2.account')
                            ->where('t1.deleted')->eq(0)
                            ->andWhere('t2.college_id')->eq($cur_collegeid)
                            ->andWhere('title')->like('%' . $paramtitle . '%')
                            ->andWhere('creatorID')->in($paramstu)
                            ->orderBy($orderBy)
                            ->page($pager)
                            ->fetchAll();
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'conclusion');

        if($conclusions) return $conclusions;
        else return array();
    }

    public function saveRead($conclusion)
    {
        if ($this->session->userinfo->roleid == 'teacher')
        {
            $accounts = $this->dao->select('viewaccounts')
                        ->from(TABLE_CONCLUSION)
                        ->where('id')->eq($conclusion->id)
                        ->fetch()->viewaccounts;

            if (strstr($accounts, $this->session->user->account))
            {
                $this->dao->update(TABLE_CONCLUSION)
                        ->set('viewtime')->eq(date('Y-m-d H:i:s'))
                        ->where('id')->eq($conclusion->id)
                        ->exec();
            }
            else
            {
                $this->dao->update(TABLE_CONCLUSION)
                        ->set('viewtime')->eq(date('Y-m-d H:i:s'))
                        ->set('viewaccounts')->eq($accounts . '|' . $this->session->user->account)
                        ->where('id')->eq($conclusion->id)
                        ->exec();
            }               
        }

        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }
    }

    public function checkPriv($conclusion, $method)
    {
        $cur_role= $this->session->user->roleid;
        if($cur_role == 'admin') return 1;

        $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($conclusion->creatorID)->andWhere('deleted')->eq(0)->fetch()->college_id;
   
        if ($collegeid != $this->session->userinfo->collegeid ) return 0;
        switch ($cur_role) {
            case 'student':
                return $this->checkStudentPriv($conclusion,$method);
                break;

            case 'teacher':
                return $this->checkTeacherPriv($conclusion,$method);
                break;

            case 'counselor':
                return $this->checkCounselorPriv($conclusion,$method);
                break;

            case 'manager':
                return $this->checkManagerPriv($conclusion, $method);
                break;
            default:
                return 0;
                break;
        }
        if ($method != 'view') return 0;

        if ($this->session->userinfo->roleid == 'admin') return 1;

        $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($conclusion->creatorID)->andWhere('deleted')->eq(0)->fetch()->college_id;
   
        if ($collegeid != $this->session->userinfo->collegeid) return 0;

        if ($this->session->userinfo->roleid == 'manager') return 1;
    }

    private function checkStudentPriv($conclusion, $method){
        $cur_account = $this->session->user->account;

        if ($cur_account == $conclusion->creatorID) return 1;
        else return 0;

    }

    private function checkTeacherPriv($conclusion, $method){
        $cur_account = $this->session->user->account;

        if($method != 'view') return 0;
        else if($this->loadModel('project')->checkRelation($cur_account, $conclusion->creatorID))
            return 1;
        else
            return 0;

        
    }

    private function checkCounselorPriv($conclusion, $method){
        $cur_account = $this->session->user->account;
        
        if($method != 'view') return 0;

        $grade = $this->dao->select('grade')->from(TABLE_USER)->where('account')->eq($conclusion->creatorID)->andWhere('deleted')->eq(0)->fetch()->grade;
        if(strstr($this->session->user->grade, $grade)) return 1;
        else return 0;
    }

    private function checkManagerPriv($conclusion, $method){
        if($method != 'view') return 0;
        return 1;
    }
}
