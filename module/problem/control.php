<?php

class problem extends control
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
        $this->loadModel('tutor');
        $this->loadModel('task');
        $this->loadModel('action');
        $this->loadModel('tutorial');
    }

    /**
     * 查看所有问题
     * 
     * @param  string    $viewtype 
     * @access public
     * @return void
     */
    public function viewProblem($viewtype = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramtitle = '', $paramstu = '', $paramtea = '')
    {
        $this->session->set('problemOrderBy', $orderBy);
        /* Load pager and get problems. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->problems = $this->problem->getProblems($viewtype, '', '', $orderBy, $pager, $paramtitle, $paramstu, $paramtea);
        $this->view->users    = $this->user->getPairs('noletter');
        $this->view->searchtitle        = $paramtitle;
        $this->view->searchtea          = $paramtea;
        $this->view->searchstu          = $paramstu;
        $this->view->pager              = $pager;
        $this->view->recTotal           = $pager->recTotal;
        $this->view->recPerPage         = $pager->recPerPage;
        $this->view->pageID             = $pager->pageID;
        $this->view->orderBy            = $orderBy;
        $this->view->viewtype           = $viewtype;
        $this->display();
    }

    /**
     * 我要提问按钮
     * 
     * @param  int    $moduleID 
     * @param  int    $problemID
     * @access public
     * @return void
     */
    public function create($recreate = 0)
    {
        if(!empty($_POST))
        {   
            $problem = fixer::input('post')->get();
            $problem->teachers = implode(',', $problem->teachers);
            if (!( $problem->teachers && $problem->title && $problem->content))
            {
                echo js::alert($this->lang->problem->noImportantInformation);
                $this->session->set('createProblem', $problem);
                die(js::locate($this->createLink('problem', 'create', "recreate=1"), 'parent'));
            }
            $this->problem->create();
            echo js::alert($this->lang->problem->createsucceed);
            die(js::locate($this->createLink('problem', 'viewProblem', "viewtype=all"), 'parent'));
        }
        
        $teachers = $this->tutor->getTutorByStudent();
        
        $this->view->teachers = array('' => '');
        foreach ($teachers as $key => $teacher) 
        {
            $this->view->teachers[$teacher->account] = $teacher->realname;
            $this->view->teachers[$teacher->account] .= (strstr($teacher->team, 'G')) ? '(指导老师)' : '';
            $this->view->teachers[$teacher->account] .= (strstr($teacher->team, 'P')) ? '(毕业设计)' : '';
        }
        $this->view->problem = $recreate ? $this->session->createProblem : null;
        $this->display();
    }

    public function view($problemID, $is_onlybody = 'no')
    {
        $problem = $this->problem->getProblemById($problemID,$is_onlybody);
        
        if (!$this->problem->checkPriv($problem, 'view')) die();
        
        $this->problem->saveRead($problem);

        if(!empty($_POST))
        {   
            $this->problem->savesolve($problem);
            $this->task->makeComment($problemID,'Q');
            die(js::locate($this->createLink('problem', 'view', "problemID=$problemID"), 'parent'));
        }
        $problem->relation = $this->tutorial->tsRelation($problem->acpID, $problem->asgID);

        $this->view->problem = $problem;
        $this->view->comments    = $this->task->getComments('problem',$problemID);
        $this->view->users    = $this->user->getPairs('noletter');
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('problem', $problemID);
        $this->display();
    }

    public function viewGroup($ID, $is_onlybody = 'no', $isDeleted = false)
    {
        $problems = $this->problem->getProblemsById($ID,$is_onlybody);
        if ($isDeleted) 
        {
            $ID = $problems[0]->id;       
            if (count($problems) == 1) die(js::locate($this->createLink('problem', 'viewProblem'), 'parent'));
        }
        foreach ($problems as $key => $problem)
        {
            if ($problem->id == $ID)
            {
                if (!$this->problem->checkPriv($problem, 'view')) die();
                $this->problem->saveRead($problem);
                if(!empty($_POST))
                {
                    $this->problem->savesolve($problem);
                    $this->task->makeComment($problem->id,'Q');
                    die(js::locate($this->createLink('problem', 'viewgroup', "ID=$problem->id"), 'parent'));
                }
                $this->view->comments = $this->task->getComments('problem', $problem->id);
                $problem->relation = $this->tutorial->tsRelation($problem->acpID, $problem->asgID);
                $this->view->problem = $problem;
                break;
            }
        }
        $this->view->ID = $ID;
        $this->view->users = $this->user->getPairs('noletter');
        $this->view->problems = $problems;
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('problem', $ID);
        $this->display();
    }

    public function edit($problemID)
    {
        if (!empty($_POST))
        {  
            $this->problem->update($problemID);
            $this->action->create('problem', $problemID, 'edited');
            echo js::alert($this->lang->problem->editsucceed);
            die(js::locate($this->createLink('problem', 'view', "problemID=$problemID"), 'parent'));
        }

        $this->view->problem = $this->problem->getProblemById($problemID);
        if (!$this->problem->checkPriv($this->view->problem, 'edit')) die();
        $this->display();
    }

    public function delete($problemID, $group = false, $confirm = 'no')
    {
        if (!$this->problem->checkPriv($this->problem->getProblemById($problemID), 'delete')) die();
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->problem->confirmDelete, $this->createLink('problem', 'delete', "problemID=$problemID&group=$group&confirm=yes"));
            exit;
        }
        else
        {
            $this->problem->delete($problemID);
            $this->action->create('problem', $problemID, 'deleted');
            echo js::alert($this->lang->problem->deletesucceed);
            if ($group)
            {
                die(js::locate($this->createLink('problem', 'viewGroup', "problemID=$problemID&is_onlybody=no&isDeleted=$group"), 'parent'));                
            }
            else
                die(js::locate($this->createLink('problem', 'viewProblem'), 'parent'));
        }
    }

    public function batchDelete($problemID, $confirm = 'no')
    {
        $problem = $this->problem->getProblemById($problemID);
        if (!$this->problem->checkPriv($problem, 'delete')) die();
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->problem->confirmDelete, inlink('batchDelete', "problemID=$problemID&confirm=yes")));
        }
        else
        {
            $this->problem->deleteGroup($problem);
            echo js::alert($this->lang->problem->deletesucceed);
            die(js::reload('parent'));
        }
    }

    public function complete($problemID, $confirm = 'no')
    {
        if (!$this->problem->checkPriv($this->problem->getProblemById($problemID), 'complete')) die();
        if ($confirm == 'no')
        {
            echo js::confirm($this->lang->problem->confirmComplete, $this->createLink('problem', 'complete', "problemID=$problemID&confirm=yes"));
            exit;
        }
        else
        {
            $this->problem->complete($problemID);
            $this->action->create('problem', $problemID, 'finished');
            echo js::alert($this->lang->problem->completesucceed);
            die(js::locate($this->createLink('problem', 'viewProblem'), 'parent'));
        }
    }

    public function search()
    {
        $get_data = fixer::input('post')->get();
        die(js::locate($this->createLink('problem', 'viewProblem', array('viewtype' => $get_data->viewtype, 'orderBy' => 'id_desc', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramtitle' => $get_data->title, 'paramstu' => $get_data->acpID, 'paramtea' => $get_data->asgID)), 'parent'));
    }
}
