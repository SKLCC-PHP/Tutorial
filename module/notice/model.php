<?php
class noticeModel extends model
{
    /**
     * Set menu.
     * 
     * @param  int    $dept 
     * @access public
     * @return void
     */
    public function setMenu($dept = 0)
    {
        common::setMenuVars($this->lang->notice->menu, 'name', array($this->app->company->name));
        common::setMenuVars($this->lang->notice->menu, 'addUser', array($dept));
        common::setMenuVars($this->lang->notice->menu, 'batchAddUser', array($dept));
    }

    /**
     * Get company list.
     * 
     * @access public
     * @return void
     */
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_COMPANY)->fetchAll();
    }

    /**
     * Get the first company.
     * 
     * @access public
     * @return void
     */
    public function getFirst()
    {
        return $this->dao->select('*')->from(TABLE_COMPANY)->orderBy('id')->limit(1)->fetch();
    }
    
    /**
     * Get company info by id.
     * 
     * @param  int    $companyID 
     * @access public
     * @return object
     */
    public function getByID($companyID = '')
    {
        return $this->dao->findById((int)$companyID)->from(TABLE_COMPANY)->fetch();
    }

    /**
     * Update a company.
     * 
     * @access public
     * @return void
     */
    public function update()
    {
        $company   = fixer::input('post')->stripTags('name')->get();        
        if($company->website  == 'http://') $company->website  = '';
        if($company->backyard == 'http://') $company->backyard = '';
        $companyID = $this->app->company->id;
        $this->dao->update(TABLE_COMPANY)
            ->data($company)
            ->autoCheck()
            ->batchCheck($this->config->company->edit->requiredFields, 'notempty')
            ->batchCheck('name', 'unique', "id != '$companyID'")
            ->where('id')->eq($companyID)
            ->exec();
    }

    /**
     * create a notice.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $now = helper::now();
        $notice = fixer::input('post')
                    ->striptags('title')
                    ->remove('files,labels')
                    ->get();
        $notice->createtime = $now;
        $notice->creatorID = $this->session->user->account;

        $this->dao->insert(TABLE_NOTICE)->data($notice)
                ->autoCheck()
                //->batchCheck($this->config->notice->create->requiredFields, 'notempty')
                ->exec();

        if(!dao::isError())
        {   
            $noticeID = $this->dao->lastInsertID();
            $this->loadModel('file')->saveUpload('notice', $noticeID);
        }
        else
        {
            echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
        }

        /*send mail to inform the receiver*/
        $this->loadModel('action')->create('notice', $noticeID, 'created');
    }

    /**
     * get notices.
     * 
     * @access public
     * @return void
     */
    public function getNotices($orderBy = 'createtime_desc', $pager = null, $paramtitle = '', $paramcreator = '')
    {
        $paramcreatorIDs = $this->loadModel('user')->getAccountByName($paramcreator);
        switch ($this->session->userinfo->roleid) 
        {
            case 'student':
                $tutors = $this->loadModel('tutor')->getTutorByStudent();
                foreach ($tutors as $tutor) 
                {
                    $accounts[] = $tutor->account;
                }
                return $this->dao->select('t1.*, t2.realname, t2.college_id')
                            ->from(TABLE_NOTICE)->alias(t1)
                            ->leftJoin(TABLE_USER)->alias(t2)
                            ->on('t2.account=t1.creatorID')
                            ->where('t1.deleted')->eq(0)
                            ->andWhere('t1.creatorID')->in($accounts)
                            ->beginIF($paramtitle != '')->andWhere('t1.title')->like('%' . $paramtitle . '%')->fi()
                            ->andWhere('t1.creatorID')->in($paramcreatorIDs)
                            ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                            ->orWhere('t2.roleid')->in('admin,manager,counselor')
                            ->markLeft()->andWhere('t1.deleted')->eq(0)
                            ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                            ->beginIF($paramtitle != '')->andWhere('t1.title')->like('%' . $paramtitle . '%')->fi()
                            ->andWhere('t1.creatorID')->in($paramcreatorIDs)->markRight()
                            ->orderBy('t1.' . $orderBy)
                            ->page($pager)
                            ->fetchAll();
                break;
            
            case 'teacher':
                return $this->dao->select('t1.*, t2.realname, t2.college_id')
                            ->from(TABLE_NOTICE)->alias(t1)
                            ->leftJoin(TABLE_USER)->alias(t2)
                            ->on('t2.account=t1.creatorID')
                            ->where('t1.deleted')->eq(0)
                            ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                            ->andWhere('t2.roleid')->eq('teacher')
                            ->andWhere('t1.creatorID')->eq($this->session->user->account)
                            ->beginIF($paramtitle != '')->andWhere('t1.title')->like('%' . $paramtitle . '%')->fi()
                            ->andWhere('t1.creatorID')->in($paramcreatorIDs)
                            ->orWhere('t2.roleid')->in('admin,manager,counselor')
                            ->markLeft()->andWhere('t1.deleted')->eq(0)
                            ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                            ->beginIF($paramtitle != '')->andWhere('t1.title')->like('%' . $paramtitle . '%')->fi()
                            ->andWhere('t1.creatorID')->in($paramcreatorIDs)->markRight()
                            ->orderBy('t1.' . $orderBy)
                            ->page($pager)
                            ->fetchAll();
                break;
            case 'counselor':
            case 'manager':
                return $this->dao->select('t1.*, t2.realname, t2.college_id')
                            ->from(TABLE_NOTICE)->alias(t1)
                            ->leftJoin(TABLE_USER)->alias(t2)
                            ->on('t2.account=t1.creatorID')
                            ->where('t1.deleted')->eq(0)
                            ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                            ->beginIF($paramtitle != '')->andWhere('t1.title')->like('%' . $paramtitle . '%')->fi()
                            ->andWhere('t1.creatorID')->in($paramcreatorIDs)
                            ->orderBy('t1.' . $orderBy)
                            ->page($pager)
                            ->fetchAll();
                break;

            case 'admin':
                return $this->dao->select('t1.*, t2.realname, t2.college_id')
                            ->from(TABLE_NOTICE)->alias(t1)
                            ->leftJoin(TABLE_USER)->alias(t2)
                            ->on('t2.account=t1.creatorID')
                            ->where('t1.deleted')->eq(0)
                            ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
                            ->beginIF($paramtitle != '')->andWhere('t1.title')->like('%' . $paramtitle . '%')->fi()
                            ->andWhere('t1.creatorID')->in($paramcreatorIDs)
                            ->orderBy('t1.' . $orderBy)
                            ->page($pager)
                            ->fetchAll();
                break;
            default:
                return array();
                break;
        }
    }

    /**
     * get notice by ID.
     * 
     * @access public
     * @return void
     */
    public function getNoticeByID($noticeID,$setImgSize = true)
    {
        $notice = $this->dao->select('t1.*, t2.college_id')
                            ->from(TABLE_NOTICE)->alias(t1)
                            ->leftJoin(TABLE_USER)->alias(t2)
                            ->on('t1.creatorID=t2.account')
                            ->where('t1.deleted')->eq(0)
                            ->andWhere('t1.id')->eq($noticeID)
                            ->fetch();

        if(!empty($notice)) $notice->files = $this->loadModel('file')->getByObject('notice', $noticeID);
        if($setImgSize) $notice->content = $this->loadModel('file')->setImgSize($notice->content);
        return $notice;
    }

    /**
     * check the prive.
     * 
     * @access public
     * @return void
     */
    public function checkPriv($noticeID, $type = 'view')
    {
        $creator = $this->dao->select('t1.account, t1.roleid,t1.college_id')
                    ->from(TABLE_USER)->alias(t1)
                    ->leftJoin(TABLE_NOTICE)->alias(t2)
                    ->on('t1.account=t2.creatorID')
                    ->where('t2.id')->eq($noticeID)
                    ->fetch();

        if($creator->account == $this->session->user->account) return true;
        if($type == 'delete') return false;
        switch ($creator->roleid) 
        {
            case 'admin':
                return true;
                break;
            
            case 'counselor':
            case 'manager':
                if($this->session->userinfo->collegeid == $creator->college_id or $this->session->userinfo->roleid == 'admin')
                {
                    return true;
                }
                return false;
                break;

            case 'teacher':
                if($this->session->userinfo->roleid == 'admin')
                    return true;
                if($this->session->userinfo->collegeid == $creator->college_id or $this->session->userinfo->roleid == 'student')
                {
                    if($this->session->userinfo->roleid == 'manager' or $this->session->userinfo->roleid == 'counselor')
                        return true;
                    $students = $this->loadModel('student')->getAll($creator->account);
                    foreach ($students as $student) 
                    {
                        if($student->account == $this->session->user->account)
                        {
                            return true;
                        }
                    }
                }
                return false;
                break;

            default:
                return false;
                break;
        }
    }

    /**
     * @Green
     * @function: designed by group
     */
    static public function printRPNs($backLink, $preAndNext = '', $orderBy = 'createtime_desc')
    {
        echo html::a($backLink, '<i class="icon-goback icon-level-up icon-large icon-rotate-270"></i>', '', "class='btn' title={$lang->goback}");

        if(isset($preAndNext->pre) and $preAndNext->pre) 
            echo html::a(inLink('view', "noticeID=$preAndNext->pre&orderBy=$orderBy"), '<i class="icon-pre icon-chevron-left"></i>', '', "id='pre' class='btn'");

        if(isset($preAndNext->next) and $preAndNext->next) 
            echo html::a(inLink('view', "noticeID=$preAndNext->next&orderBy=$orderBy"), '<i class="icon-pre icon-chevron-right"></i>', '', "id='next' class='btn'");
    }

    /**
     * delete the notice.
     * 
     * @access public
     * @return void
     */
    public function delete($noticeID)
    {
        // $oldnotice = $this->getById($noticeID);
        // $now     = helper::now();

        $notice = $this->getNoticeByID($noticeID);
        
        $this->dao->update(TABLE_NOTICE)
                ->set('deleted')->eq(1)
                ->where('id')->eq((int)$noticeID)->exec();
        $this->dao->update(TABLE_FILE)->set('deleted')->eq(1)->where('objectType')->eq('notice')->andWhere('objectID')->eq($noticeID)->andWhere('deleted')->eq(0)->exec();
        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }
    }
}
