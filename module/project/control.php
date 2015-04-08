<?php
class project extends control
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('workspace');
        $this->loadModel('task');
        $this->loadModel('tutor');
        $this->loadModel('student');
        $this->loadModel('user');
        $this->loadModel('common');
        $this->loadModel('project');
        $this->loadModel('action');
        $this->loadModel('tutorial');
    }


    /**
     * View a product.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function viewProject($orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramname = '', $paramstu = '', $paramtea = '')
    { 
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('projectTaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        
        $cur_role = $this->session->userinfo->roleid;

        if ($cur_role == 'student')
        {
            $projects = $this->project->getProjectByStudent($this->session->user->account, $pager, $orderBy, $paramname, $paramstu, $paramtea);
        }
        elseif ($cur_role == 'teacher')
        {
            $projects = $this->project->getProjectBytutor($this->session->user->account, $pager, $orderBy, $paramname, $paramstu, $paramtea);
        }
        elseif ($cur_role == 'admin') 
        {
            $projects = $this->project->getAllProject($orderBy, $pager, $paramname, $paramstu, $paramtea);
        }
        else
        {
            $projects = $this->project->getProjectByManager('', $pager, $orderBy, '', $paramname, $paramstu, $paramtea);
        }
   
        $this->view->projects = array();
        foreach ($projects as $value) 
        {   
            $this->view->projects[$i] = $value;
            $this->view->projects[$i]->creator_name = $this->user->getByAccount($value->creator_ID)->realname;
            $this->view->projects[$i]->status = $this->project->checkStatus($value);
            $this->view->projects[$i]->tea_name = $this->user->getByAccount($value->tea_ID)->realname;
            $this->view->projects[$i]->priv = $this->project->checkPriv($value->id);
            $i++;                
        }

        $this->view->searchname = $paramname;
        $this->view->searchtea = $paramtea;
        $this->view->searchstu = $paramstu;
        $this->view->pager       = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID    = $pager->pageID;
        $this->view->orderBy   = $orderBy;
        $this->display();
    }

    public function create($recreate = 0)
    {
        $cur_account = $this->session->user->account;
        if (!empty($_POST))
        { 
            $project = fixer::input('post')->get();
            $project->members = implode(',', $project->members);
            if (!( $project->teacher && $project->title && $project->content && $project->deadline))
            {
                echo js::alert($this->lang->project->noImportantInformation);
                $this->session->set('createProject', $project);
                die(js::locate($this->createLink('project', 'create', "recreate=1"), 'parent'));
            }
            $projectID = $this->project->create();
            $this->action->create('project', $projectID, 'created');
            echo js::alert($this->lang->project->createsucceed);                    
            die(js::locate($this->createLink('project', 'viewProject'), 'parent'));
        }

        $teachers = $this->tutor->getTutorByStudent($cur_account);
        $this->view->teachers = array();

        foreach ($teachers as $key => $value) 
        {
            $this->view->teachers[$value->account] = $value->realname;
            $this->view->teachers[$value->account] .= (strstr($value->team, 'G')) ? '(指导老师)' : '';
            $this->view->teachers[$value->account] .= (strstr($value->team, 'P')) ? '(毕业设计)' : '';
        }

        $this->view->project =  $recreate ? $this->session->createProject : null;
        $this->view->memberLists = $this->common->getTeamByStudent($cur_account);
        
        $this->display();
    }
    
    public function view($projectID, $is_onlybody = 'no')
    {
        if(!empty($_POST))
        { 
            $this->task->makeComment($projectID,'P');
            die(js::locate($this->createLink('project', 'view', "projectID=$projectID"), 'parent'));
        }
        
        $project = $this->project->getProjectByPID($projectID,$is_onlybody);

        if (!$this->project->checkViewPriv($project)) die();
        $project->relation = $this->tutorial->tsRelation($project->tea_ID, $project->creator_ID);     
        $this->view->project = $project;
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->comments = $this->task->getComments('project',$projectID);
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('project', $projectID);
        $this->display();
    }

    public function edit($projectID)
    {
        if (!$this->project->checkPriv($projectID)) die();

        if (!empty($_POST))
        {  
            if (!$this->post->teacher)
            {
                echo js::alert($this->lang->project->noTeacher);
                die(js::locate($this->createLink('project', 'edit', "projectID=$projectID"), 'parent')); 
            }
            $this->project->update($projectID);
            $this->action->create('project', $projectID, 'edited');
            echo js::alert($this->lang->project->editsucceed);
            die(js::locate($this->createLink('project', 'view', "projectID=$projectID"), 'parent'));
        }

        $cur_account = $this->session->user->account;
        $this->view->menberLists = $this->common->getTeamByStudent($cur_account);
              
        $teachers = $this->tutor->getTutorByStudent($cur_account);
        if ($teachers)
        {
            $this->view->teachers = array();

            foreach ($teachers as $key => $value) 
            {
                $this->view->teachers[$value->account] = $value->realname;
                $this->view->teachers[$value->account] .= (strstr($value->team, 'G')) ? '(指导老师)' : '';
                $this->view->teachers[$value->account] .= (strstr($value->team, 'P')) ? '(毕业设计)' : '';
            }
        }
        else
        {
            $this->view->teachers = array('' => $this->lang->project->noteacher);
        }
        
        $this->view->project = $this->project->getProjectByPID($projectID);

        $this->display();
    }

    public function delete($projectID, $confirm = 'no')
    {
        if (!$this->project->checkPriv($projectID))  die();

        if($confirm == 'no')
        {
            echo js::confirm($this->lang->project->confirmDelete, $this->createLink('project', 'delete', "projectID=$projectID&confirm=yes"), '');
            exit;
        }
        else
        {
            $this->project->delete($projectID);
            $this->action->create('project', $projectID, 'deleted');
            echo js::alert($this->lang->project->deletesucceed);
            die(js::locate($this->createLink('project', 'viewProject'), 'parent'));
        }
    }

    public function finish($projectID, $confirm = 'no')
    {
        if (!$this->project->checkPriv($projectID))  die();

        if ($confirm == 'no')
        {
            echo js::confirm($this->lang->project->confirmFinish, $this->createLink('project', 'finish', "projectID=$projectID&confirm=yes"), '');
            exit;
        }
        else
        {
            $this->project->finish($projectID);
            $this->action->create('project', $projectID, 'finished');
            echo js::alert($this->lang->project->finishsucceed);
            die(js::locate($this->createLink('project', 'viewProject'), 'parent'));
        }
    }

    public function search()
    {
        $get_data = fixer::input('post')->get();
        die(js::locate($this->createLink('project', 'viewProject', array('orderBy' => 'id_desc', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramname' => $get_data->name, 'paramstu' => $get_data->creator_ID, 'paramtea' => $get_data->tea_ID)), 'parent'));
    } 
}
