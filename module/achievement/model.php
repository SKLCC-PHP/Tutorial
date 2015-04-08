<?php
class achievementModel extends model
{

    /**
     * Create a achievement.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $achievementFile = '';

        $achievement = fixer::input('post')
            ->striptags('title')
            ->setForce('creatorID',  $this->session->user->account)
            ->add('createtime', helper::now())
            ->remove('files,labels,members')
            ->get();
        
        $achievement->othername = '';
        foreach ($this->post->member as $member) 
        {
            if ($member == null) continue;
            $achievement->othername .= $member . ',';
        }

        $this->dao->insert(TABLE_ACHIEVEMENT)->data($achievement)->autoCheck()->exec();

        if(!dao::isError())
        {
            $achievementID = $this->dao->lastInsertID();
            if(!empty($achievementFile))
            {
                $achievementFile->objectID = $achievementID;
                $this->dao->insert(TABLE_FILE)->data($achievementFile)->exec();
            }
            else
            {
                $achievementFileTitle = $this->loadModel('file')->saveUpload('achievement', $achievementID);
                $achievementFile = $this->dao->select('*')->from(TABLE_FILE)->where('id')->eq(key($achievementFileTitle))->fetch();
                unset($achievementFile->id);
            }
        }
        else
        {
            echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
        }
    }

    /**
     * Update a achievement.
     * 
     * @param  int    $achievementID 
     * @access public
     * @return void
     */
    public function update($achievementID)
    {
        $now     = helper::now();

        $achievement    = fixer::input('post')
            ->striptags('title')
            ->setForce('updatetime',  $now)
            ->remove('files,labels,member')
            ->get();
        
        $achievement->othername = '';
        foreach ($this->post->member as $member) 
        {
            if ($member == null) continue;
            $achievement->othername .= $member . ',';
        }

        $this->dao->update(TABLE_ACHIEVEMENT)->data($achievement)
            ->autoCheck()
            ->batchCheckIF($this->config->achievement->edit->requiredFields, 'notempty')
            ->where('id')->eq((int)$achievementID)->exec();
        if(dao::isError())
        {
            echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
        }
            
    }

    /**
     * delete a achievement.
     * 
     * @param  int    $achievementID 
     * @access public
     * @return void
     */
    public function delete($achievementID)
    {
       $this->dao->update(TABLE_ACHIEVEMENT)->set('deleted')->eq(1)->where('id')->eq((int)$achievementID)->exec(); 
       $this->dao->update(TABLE_FILE)->set('deleted')->eq(1)->where('objectType')->eq('achievement')->andWhere('objectID')->eq($achievementID)->andWhere('deleted')->eq(0)->exec();
    
    }

    /**
     * Get achievement info by Id.
     * 
     * @param  int    $achievementID 
     * @param  bool   $setImgSize
     * @access public
     * @return object|bool
     */
    public function getById($achievementID, $is_onlybody = 'no',$setImgSize = true)
    {
        if(strtolower($is_onlybody) == 'yes')
            $imgsize = 300;
        else
            $imgsize = 800;

        $achievement = $this->dao->select('t1.*, t2.realname AS assignedToRealName')
            ->from(TABLE_ACHIEVEMENT)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')
            ->on('t1.creatorID = t2.account')
            ->where('t1.id')->eq((int)$achievementID)
            ->andWhere('t1.deleted')->eq(0)
            ->fetch();

        if(!$achievement) return false;
        if($setImgSize) $achievement->description = $this->loadModel('file')->setImgSize($achievement->description,$imgsize);
        foreach($achievement as $key => $value) if(strpos($key, 'Date') !== false and !(int)substr($value, 0, 4)) $achievement->$key = '';
        $achievement->files = $this->loadModel('file')->getByObject('achievement', $achievementID);
        return $achievement;
    }

    /**
     * Get achievements of a user.
     * 
     * @param  string $account 
     * @param  string $type     the query type 
     * @param  int    $limit   
     * @param  object $pager   
     * @access public
     * @return array
     */
    public function getUserAchievements($account = null, $orderBy = "id_desc", $pager = '', $paramtitle = '', $paramtype = '', $paramstu = '', $paramtea = '')
    {
        $cur_role = $this->session->userinfo->roleid;
        if (!$account)   $account = $this->app->user->account;
        if (!$paramtype) $paramtype = array('thesis', 'copyright', 'patent', 'research', 'awards');
        $paramstu = $this->loadModel('user')->getAccountByName($paramstu);
        $paramtea = $this->loadModel('user')->getAccountByName($paramtea);

        if ($cur_role == 'student')
        {
            $field = 'creatorID';
        }
        elseif ($cur_role == 'teacher')
        {
            $field = 'teaID';
        }
        
        if ($cur_role == 'admin')
        {
            $achievements = $this->dao->select('*')
                            ->from(TABLE_ACHIEVEMENT)
                            ->where('deleted')->eq(0)
                            ->andWhere('title')->like('%' . $paramtitle . '%')
                            ->andWhere('type')->in($paramtype)
                            ->andWhere('creatorID')->in($paramstu)
                            ->andWhere('teaID')->in($paramtea)
                            ->orderBy($orderBy)
                            ->page($pager)
                            ->fetchAll();
            $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'achievement');
            return $achievements;
        }

        if (($cur_role != 'student')&&($cur_role != 'teacher'))
        {
            $grade = $this->session->user->grade;
            $achievements = $this->dao->select('t1.*')
                    ->from(TABLE_ACHIEVEMENT)->alias(t1)
                    ->leftJoin(TABLE_USER)->alias(t2)
                    ->on('t1.creatorID=t2.account')
                    ->where('t1.deleted')->eq(0)
                    ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                    ->andWhere('t1.title')->like('%' . $paramtitle . '%')
                    ->andWhere('t1.type')->in($paramtype)
                    ->andWhere('t1.creatorID')->in($paramstu)
                    ->andWhere('t1.teaID')->in($paramtea)
                    ->beginIF($grade != '')->andWhere('t2.grade')->in($grade)->fi()
                    ->orderBy($orderBy)
                    ->page($pager)
                    ->fetchAll();
            $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'achievement');
            return $achievements;
        }

        $achievements = $this->dao->select('*')
            ->from(TABLE_ACHIEVEMENT)
            ->where($field)->eq($account)
            ->andWhere('deleted')->eq(0) 
            ->andWhere('title')->like('%' . $paramtitle . '%')
            ->andWhere('type')->in($paramtype)
            ->andWhere('creatorID')->in($paramstu)
            ->andWhere('teaID')->in($paramtea)     
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'achievement');
        return $achievements;
    }

    public function saveChecked($achievementID)
    {
        $data =  fixer::input('post')
                    ->add('checkID', $this->session->user->account)
                    ->add('checktime', date('Y-m-d H:i:s'))
                    ->remove('comment')
                    ->get();

        $this->dao->update(TABLE_ACHIEVEMENT)
            ->data($data)
            ->where('id')->eq($achievementID)
            ->exec();
        
        if ($data->checked == 1) 
            $acl = 3;
        elseif($data->checked == -1) 
            $acl = 1;

        $this->dao->update(TABLE_FILE)
                ->set('acl')->eq($acl)
                ->where('objectType')->eq('achievement')
                ->andWhere('objectID')->eq($achievementID)
                ->exec();
        if(dao::isError())
        {
            die(js::error(dao::getError()));
        }
    }

    public function getOtherAchievements($account, $orderBy = '', $pager = null, $field = '')
    {
        if (!$orderBy) $orderBy = 'id_desc';
        if (!$field) $field = 'creatorID';

        return $this->dao->select('*')
                ->from(TABLE_ACHIEVEMENT)
                ->where($field)->eq($account)
                ->andWhere('checked')->eq(1)
                ->andWhere('deleted')->eq(0)
                ->orderBy($orderBy)
                ->page($pager)
                ->fetchAll();
    }

    public function checkPriv($achievement, $method){
        $cur_role = $this->session->user->roleid;
        if (strstr('student|teacher|manager|counselor',$cur_role)){
            $function = 'check' . $cur_role . 'Priv';
            return $this->$function($achievement, $method);
        }else
            return 1;   
    }

    private function checkStudentPriv($achievement, $method){
        $cur_account = $this->session->user->account;
        switch ($method){
            case 'view':{
                if ($cur_account == $achievement->creatorID) return 1;
                $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($achievement->creatorID)->andWhere('deleted')->eq(0)->fetch()->college_id;
                if (($achievement->checked == 1) && ($this->session->user->roleid == $collegeid)) return 1;
                else return 0;
            }
            case 'edit':
            case 'delete':{
                if ($cur_account == $achievement->creatorID) return 1;
                else return 0;
            }
            default :return 0;
        }
    }

    private function checkTeacherPriv($achievement, $method){
        $cur_account = $this->session->user->account;
        if (($method == 'view') && ($achievement->teaID == $cur_account)) return 1;
        else return 0;
    }

    private function checkManagerPriv($achievement, $method){
        if (strstr('view|check', $method)){
            $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($achievement->creatorID)->andWhere('deleted')->eq(0)->fetch()->college_id;
            if ($this->session->user->collegeid == $collegeid) return 1;
            else return 0;
        }else{
            return 0;
        }
    }

    private function checkCounselorPriv($achievement, $method){
        if (strstr('view|check', $method)){
            $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($achievement->creatorID)->andWhere('deleted')->eq(0)->fetch()->college_id;
            $grade = $this->dao->select('grade')->from(TABLE_USER)->where('account')->eq($achievement->creatorID)->andWhere('deleted')->eq(0)->fetch()->grade;
            if ($this->session->user->collegeid == $collegeid && strstr($this->session->user->grade, $grade)) return 1;
            else return 0;
        }else{
            return 0;
        }
    }
}
