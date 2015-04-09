<?php
class achievement extends control
{
    /**
     * Construct function, load model of project and story modules.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('tree');
        $this->loadModel('user');
        $this->loadModel('workspace');
        $this->loadModel('task');
        $this->loadModel('tutor');
        $this->loadModel('action');
        $this->loadModel('tutorial');
    }

    /**
     * view all achievements.
     * 
     * @param  string    $viewtype 
     * @access public
     * @return void
     */
    public function viewAchievement($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramtitle = '', $paramtype = '', $paramstu = '', $paramtea = '')
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $this->session->set('achievementOrderBy', $orderBy);
        /*根据权限设置成果列表*/
        $achievements          = $this->achievement->getUserAchievements('', $orderBy, $pager, $paramtitle, $paramtype, $paramtea, $paramstu);
        $userpairs      = $this->user->getPairs('noletter');

        $typeList = array('' => '');
        $typeList += $this->lang->achievement->typeList;
        $this->view->typeList = $typeList;
        $this->view->searchtitle    = $paramtitle;
        $this->view->searchtype     = $paramtype;
        $this->view->searchtea      = $paramtea;
        $thsi->view->searchstu      = $paramstu;
        $this->view->achievements   = $achievements;
        $this->view->userpairs      = $userpairs;
        $this->view->pager       = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID   = $pager->pageID;
        $this->view->orderBy  = $orderBy;
        $this->display();
    }

    /**
     * Create a achievement.
     * 
     * @param  int    $moduleID 
     * @param  int    $achievementID
     * @access public
     * @return void
     */
    public function create($achievementID = 0)
    {
        if($achievementID > 0)
        {
            $achievement = $this->achievement->getByID($achievementID);
        }

        if(!empty($_POST))
        {   
            $this->achievement->create();
            $this->action->create('achievement', $achievementID, 'created');
            echo js::alert($this->lang->achievement->createsucceed);
            die(js::locate($this->createLink('achievement', 'viewAchievement'), 'parent'));
        }
       
        $teachers = $this->tutor->getTutorByStudent();
        $this->view->teachers = array('' => '');
        foreach ($teachers as $key => $teacher) 
        {
            if (strstr($teacher->team, 'G')) 
                $this->view->teachers[$teacher->account] = $teacher->realname . '(指导老师)';
            else
                $this->view->teachers[$teacher->account] = $teacher->realname;
        }
        $this->view->achievement             = $achievement;
        $this->display();
    }

    /**
     * Edit a achievement.
     * 
     * @param  int    $achievementID 
     * @access public
     * @return void
     */
    public function edit($achievementID, $comment = false)
    {
        if(!empty($_POST))
        {  
            $this->loadModel('action');
            $changes = array();
            $files   = array();
            if($comment == false)
            {
                $changes = $this->achievement->update($achievementID);
                if(dao::isError()) die(js::error(dao::getError()));
                $this->action->create('achievement', $achievementID, 'edited');
                $files = $this->loadModel('file')->saveUpload('achievement', $achievementID);
            }

            $achievement = $this->achievement->getById($achievementID);
            if(!empty($changes) or !empty($files))
            {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $fileAction = '';
                if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
            }
            echo js::alert($this->lang->achievement->editsucceed);
            die(js::locate($this->createLink('achievement', 'view', "achievementID=$achievementID"), 'parent'));
        }

        $teachers = $this->tutor->getTutorByStudent();
        $this->view->teachers = array();
        foreach ($teachers as $key => $teacher) 
        {
            if (strstr($teacher->team, 'G')) 
                $this->view->teachers[$teacher->account] = $teacher->realname . '(指导老师)';
            else
                $this->view->teachers[$teacher->account] = $teacher->realname;
        }

        $this->view->achievement    = $this->achievement->getByID($achievementID);

        if (!$this->achievement->checkPriv($this->view->achievement, 'edit')) die(js::locate($this->createLink('system', 'error404'), 'parent'));
        $this->view->achievement->members = explode(',', $this->view->achievement->othername);
        $this->display();
    }

    /**
     * Delete a achievement.
     * 
     * @param  int    $projectID 
     * @param  int    $achievementID 
     * @param  string $confirm yes|no
     * @access public
     * @return void
     */
    public function delete($achievementID, $confirm = 'no')
    {
        if (!$this->achievement->checkPriv($this->achievement->getById($achievementID), 'delete')) die(js::locate($this->createLink('system', 'error404'), 'parent'));
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->achievement->confirmDelete, $this->createLink('achievement', 'delete', "achievementID=$achievementID&confirm=yes"));
            exit;
        }
        else
        {
            $this->achievement->delete($achievementID);       
            $this->action->create('achievement', $achievementID, 'deleted');
            echo js::alert($this->lang->achievement->deletesucceed);
            die(js::locate($this->createLink('achievement', 'viewAchievement'), 'parent'));     
        }
    }

    /**
     * view a achievement.
     * 
     * @access public
     * @return void
     */
    public function view($achievementID = 0, $is_onlybody = 'no')
    {
        /*根据权限设置任务列表*/
        $achievementList = array();
        $achievement = $this->achievement->getById($achievementID,$is_onlybody);

        if (!$this->achievement->checkPriv($achievement, 'view')) die(js::locate($this->createLink('system', 'error404'), 'parent'));

        $user_role = $this->user->getUserRoles($this->app->user->account);
        $userpairs      = $this->user->getPairs('noletter');
        $achievement->isG = $this->tutorial->isGuidance($achievement->teaID, $achievement->creatorID);     
        $comments = $this->task->getComments('achievement',$achievementID);

        $this->view->user_role = $user_role;
        $this->view->comments = $comments;
        $this->view->achievement = $achievement;
        $this->view->userpairs = $userpairs;
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('achievement', $achievementID);
        $this->display();
    }

    public function check($achievementID)
    {
        if (!empty($_POST))
        {
            $this->achievement->saveChecked($achievementID);
            $this->task->makeComment($achievementID,'A');
            $this->action->create('achievement', $achievementID, 'reviewed');
            echo js::alert($this->lang->achievement->checksucceed);
            die(js::closeModal('parent.parent', 'this'));
        }
        $this->view->achievement = $this->achievement->getById($achievementID);

        if (!$this->achievement->checkPriv($this->view->achievement, 'check')) die(js::locate($this->createLink('system', 'error404'), 'parent'));
        
        if (!$this->view->achievement->checked) $this->view->achievement->checked = 1;
        $this->display();
    } 

    public function search()
    {
        $get_data = fixer::input('post')->get();
        die(js::locate($this->createLink('achievement', 'viewAchievement', array('orderBy' => 'id_desc', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramtitle' => $get_data->title, 'paramtype' => $get_data->type, 'paramstu' => $get_data->acpID, 'paramtea' => $get_data->asgID)), 'parent'));
    }
}
