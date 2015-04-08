<?php
class task extends control
{
    private $curAccount;
    private $curRole; 
    /**
     * Construct function, load model of project and story modules.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->curAccount = $this->session->user->account;
        $this->curRole = $this->session->user->roleid;
        $this->loadModel('user');
        $this->loadModel('workspace');
        $this->loadModel('mail');
        $this->loadModel('action');
        $this->loadModel('tutorial');
    }

    /**
     * view all tasks.
     * 
     * @param $viewtype   the type of the task view
     * @param 
     */
    public function viewTask($viewtype = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramtitle = '', $paramstu = '', $paramtea = '')
    {
        $this->session->set('taskOrderBy', $orderBy);
        /* Load pager and get tasks. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
       
        $tasks = $this->task->getTasks($viewtype, 0, $pager, $orderBy, $paramtitle, $paramstu, $paramtea);
        
        $ids = '';
        if (($viewtype == 'all') && ($curRole != 'student')){
            foreach ($tasks as $key => $task) {
               $ids .= $task->id . 'a';
            }
        }
        $this->view->searchtitle    = $paramtitle;
        $this->view->searchstu      = $paramstu;
        $this->view->searchtea      = $paramtea;
        $this->view->tasks          = $tasks;
        $this->view->pager          = $pager;
        $this->view->recTotal       = $pager->recTotal;
        $this->view->recPerPage     = $pager->recPerPage;
        $this->view->pageID         = $pager->pageID;
        $this->view->orderBy        = $orderBy;
        $this->view->userpairs      = $this->user->getPairs('noletter');
        $this->view->taskList       = $this->task->setTaskList($this->curRole);
        $this->view->viewtype       = $viewtype;
        $this->view->curRole        = $this->curRole;
        $this->view->columns        = $this->task->getTaskColumns($this->curRole, $viewtype);
        $this->view->ids = $ids;
        $this->display();
    }

    /**
     * Create a task.
     *
     * @access public
     */
    public function create($recreate = 0) { 
        if(!empty($_POST)){
            $task = fixer::input('post')->get();
            $task->acp_ID = implode(',', $task->assignedTo);
            if (!($task->acp_ID && $task->title && $task->deadline && $task->content)) {
                echo js::alert($this->lang->task->noImportantInformation);      
                $this->session->set('createTask', $task);
                die(js::locate($this->createLink('task', 'create', "recreate=1"), 'parent'));
            }
            $this->task->create();
            echo js::alert($this->lang->task->createsucceed);
            die(js::locate($this->createLink('task', 'viewTask', "viewtype=all"), 'parent'));
        }

        foreach ($this->task->getTeamMembers() as $student) {
            $members[$student->account] = $student->realname;
            $members[$student->account] .= strstr($student->team, 'P') ? '(毕业论文)' : '';
            $members[$student->account] .= strstr($student->team, 'G') ? '(指导学生)' : '';
        }

        $this->view->task = $recreate ? $this->session->createTask : null;
        $this->view->members = $members;
        $this->display();
    }

    /**
     * Edit a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function edit($taskID, $comment = false)
    {
        $task = $this->task->getById($taskID);

        if (!$this->task->checkPriv($task, 'edit')) die();
        /*can assess or not*/
        $can_edit = (!$task->begin_time or $task->begin_time == '0000-00-00 00:00:00');

        if(!$can_edit)
        {
            echo js::alert($this->lang->task->can_not_edit);
            die(js::locate($this->createLink('task', 'viewTask'), 'parent'));
        }

        if(!empty($_POST))
        {
            
            $changes = array();
            $files   = array();
            if($comment == false)
            {  
                $changes = $this->task->update($taskID);
                $this->action->create('task', $taskID, 'edited');
                if(dao::isError()) die(js::error(dao::getError()));
            }

            $task = $this->task->getById($taskID);
            if(!empty($changes) or !empty($files))
            {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $fileAction = '';
                if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
                $actionID = $this->action->create('task', $taskID, $action, $fileAction . $this->post->comment);
                if(!empty($changes)) $this->action->logHistory($actionID, $changes);
            }
            echo js::alert($this->lang->task->editsucceed);
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }
        
        foreach ($this->task->getTeamMembers() as $student) 
        {
            $members[$student->account] = $student->realname;
        }

        $this->view->task    = $this->task->getByID($taskID);
        $this->view->members          = $members;
        $this->view->actions = $this->loadModel('action')->getList('task', $taskID);    
        if(!isset($members[$this->view->task->assignedTo])) $members[$this->view->task->assignedTo] = $this->view->task->assignedTo;
        $this->display();
    }

    /**
     * assess a task.
     * 
     * @access public
     * @return void
     */
    public function assess($taskID = 0)
    {
        $task = $this->task->getById($taskID);
        $time = date('Y-m-d H:i:s');
        /*can assess or not*/
        $can_assess = ($task->submittime != null);
        
        if (!$this->task->checkPriv($task, 'assess')) die();
        if(!$can_assess)
        {
            echo js::alert($this->lang->task->can_not_assess);
            die(js::locate($this->createLink('task', 'viewTask'), 'parent'));
        }
       
        if(!empty($_POST))
        {
            $this->task->makeComment($taskID,'AT');
            $this->dao->update(TABLE_TASK)
                ->set('assesstime')->eq($time)
                ->where('id')->eq($taskID)
                ->exec();
            $this->action->create('task', $taskID, 'assessed');
            echo js::alert($this->lang->task->assesssucceed);
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }
        $assess_comments = $this->task->getComments('assessTask', $taskID);
        $comments = $this->task->getComments('task',$taskID);

        $this->view->task           = $task;
        $this->view->comments    = $comments;
        $this->view->assess_comments  = $assess_comments;
        $this->display();
    }

    /**
     * Delete a task.
     * 
     * @param  int    $projectID 
     * @param  int    $taskID 
     * @param  string $confirm yes|no
     * @access public
     * @return void
     */
    public function delete($taskID, $group = false, $confirm = 'no')
    {
        $task = $this->task->getById($taskID);
        if (!$this->task->checkPriv($task, 'delete')) die();
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->task->confirmDelete, inlink('delete', "taskID=$taskID&group=$group&confirm=yes")));
        }
        else
        {
            $this->task->delete($taskID);
            $this->action->create('task', $taskID, 'deleted');
            echo js::alert($this->lang->task->deletesucceed);
            if ($group)
                die(js::locate($this->createLink('task', 'viewGroup', "taskID=$taskID&is_onlybody=no&isDeleted=$group"),'parent'));
            else 
                die(js::locate($this->createLink('task', 'viewTask'), 'parent'));
        }
    }

    /**
     * Batch delete tasks.
     * 
     * @access public
     * @return void
     */
    public function batchDelete($taskID, $confirm = 'no')
    {
        $task = $this->task->getById($taskID);
        if (!$this->task->checkPriv($task, 'delete')) die();
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->task->confirmDelete, inlink('batchDelete', "taskID=$taskID&confirm=yes")));
        }
        else
        {
            $this->task->deleteGroup($taskID);
            echo js::alert($this->lang->task->deletesucceed);
            die(js::reload('parent'));
        }
    }

    /**
     * Finish a task.
     * 
     * @param  int    $projectID 
     * @param  int    $taskID 
     * @param  string $confirm yes|no
     * @access public
     * @return void
     */
    public function finish($taskID, $confirm = 'no')
    {
        $task = $this->task->getById($taskID);

        if (!$this->task->checkPriv($task, 'finish')) die();
        
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->task->confirmFinish, inlink('finish', "taskID=$taskID&confirm=yes"), $this->createLink('task', 'viewTask')));
        }
        else
        {
            $this->task->finish($taskID);
            $this->action->create('task', $taskID, 'closed');
            if($this->server->ajax)
            {
                if(dao::isError())
                {
                    $response['result']  = 'fail';
                    $response['message'] = dao::getError();
                }
                else
                {
                    $response['result']  = 'success';
                    $response['message'] = '';
                }
                $this->send($response);
            }
            
            echo js::alert($this->lang->task->finishsucceed);
            die(js::locate(inlink('viewTask', 'viewtype=done')));
        }
    }

    /**
     * view a task.
     * 
     * @access public
     * @return void
     */
    public function view($taskID = 0, $viewtype = 'all', $is_onlybody = 'no')
    {
        $task = $this->task->getById($taskID,$is_onlybody);
        
        if (!$this->task->checkPriv($task, 'view')) die();
        $this->task->saveRead($task);
        if(!empty($_POST))
        {
            $this->task->makeComment($taskID,'T');
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }
        $assess_comments = $this->task->getComments('assessTask', $taskID);
        $comments = $this->task->getComments('task',$taskID);
        
        $task->relation = $this->tutorial->tsRelation($task->asgID, $task->acpID);
        $this->view->viewtype = $viewtype;
        $this->view->task           = $task;
        $this->view->comments       = $comments;
        $this->view->assess_comments= $assess_comments;
        $this->view->userpairs      = $this->user->getPairs('noletter');
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('task', $taskID);
        $this->display();
    }

    public function viewGroup($ID, $is_onlybody = 'no', $isDeleted = false)
    {
        $tasks = $this->task->getTasksByID($ID);
        if ($isDeleted) 
        {
            $ID = $tasks[0]->id;           
            if (count($tasks) == 1) die(js::locate($this->createLink('task', 'viewTask'), 'parent'));
        }

        foreach ($tasks as $key => $task)
        {
            if ($task->id == $ID)
            {
                if (!$this->task->checkPriv($task, 'view')) die();
                $this->task->saveRead($task);
                if(!empty($_POST))
                {
                    $this->task->makeComment($task->id,'T');
                    die(js::locate($this->createLink('task', 'viewgroup', "ID=$task->id"), 'parent'));
                }
                $assess_comments = $this->task->getComments('assessTask', $task->id);
                $comments = $this->task->getComments('task', $task->id);
                $task->relation = $this->tutorial->tsRelation($task->asgID, $task->acpID);
                $this->view->task = $task;
                break;
            }
        }
        
        $this->view->group = $group;
        $this->view->groupIndex = $groupIndex;
        $this->view->tasks = $tasks;
        $this->view->taskID = $ID;
        $this->view->comments = $comments;
        $this->view->assess_comments = $assess_comments;
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('task', $tasks[0]->id);
        $this->display();
    }
    /**
     * Submit a task.
     * 
     * @param  int    $projectID 
     * @param  int    $taskID 
     * @param  string $confirm yes|no
     * @access public
     * @return void
     */
    public function submit($taskID)
    {
        $task = $this->task->getById($taskID);
        if (!$this->task->checkPriv($task, 'submit')) die();
        $this->view->task = $task;
        $cur_time = date('Y-m-d H:i:s');
        /*can submit or not*/
        $can_submit = ($cur_time >= $task->begintime) && ($task->completetime == null || $task->completetime == '0000-00-00 00:00:00');

        if(!$can_submit)
        {
            echo js::alert($this->lang->task->can_not_submit);
            die(js::locate($this->createLink('task', 'viewTask'), 'parent'));
        }

        if(!empty($_POST))
        {
            $this->task->checkSubmit($taskID);
            $this->action->create('task', $taskID, 'submited');
            if(dao::isError()) die(js::error(dao::getError()));

            if(isonlybody()) die(js::closeModal('parent.parent', 'this'));
            echo js::alert($this->lang->task->submitsucceed);
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }
        $this->view->date = strftime("%Y-%m-%d %X", strtotime('now'));
       
        $this->display();
    }

    public function editsubmit($taskID)
    {
        if (!empty($_POST))
        {
            $this->task->editSubmit($taskID);
            if(dao::isError()) die(js::error(dao::getError()));
            $this->action->create('task', $taskID, 'changed');
            echo js::alert($this->lang->task->submitsucceed);
            die(js::closeModal('parent.parent', 'this'));
        }

        $this->view->task = $this->task->getById($taskID);
        if (!$this->task->checkPriv($this->view->task, 'editsubmit')) die();
        if ($this->view->task->acpID != $this->curAccount) die();

        $this->display();
    } 

    public function search()
    {
        $get_data = fixer::input('post')->get();
        die(js::locate($this->createLink('task', 'viewTask', array('viewtype' => $get_data->viewtype, 'orderBy' => 'id_desc', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramtitle' => $get_data->title, 'paramstu' => $get_data->acpID, 'paramtea' => $get_data->asgID)), 'parent'));
    } 
}
