<?php
class conclusion extends control
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
        $this->loadModel('action');
        $this->loadModel('task');
    }

    /**
     * view all conclusions.
     * 
     * @param  string    $viewtype 
     * @access public
     * @return void
     */
    public function viewConclusion($orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramtitle = '', $paramstu = '')
    {
        $cur_role = $this->session->userinfo->roleid;
        /* Process the order by field. */
        if(!$orderBy) $orderBy = $this->cookie->problemOrder ? $this->cookie->problemOrder : 'createtime|desc';
        setcookie('problemOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

        /* Load pager and get problems. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        /*根据权限设置任务列表*/
        if ($cur_role == 'student')
        {
            $conclusions = $this->conclusion->getUserConclusions('', $orderBy, $pager, $paramtitle, $paramstu);
        }
        elseif($cur_role == 'teacher')
        {
            $conclusions = $this->conclusion->getStudentConclusions('', $orderBy, $pager, $paramtitle, $paramstu);
        }
        elseif($cur_role == 'admin')
        {
            $conclusions = $this->conclusion->getAllConclusions($orderBy, $pager, $paramtitle, $paramstu);
        }
        else
        {
            $conclusions = $this->conclusion->getCollegeConclusions('', $orderBy, $pager, $paramtitle, $paramstu);
        }
        
        $userpairs      = $this->user->getPairs('noletter');

        $this->view->searchtitle    = $paramtitle;
        $this->view->searchstu      = $paramstu;
        $this->view->conclusions    = $conclusions;
        $this->view->userpairs      = $userpairs;
        $this->view->pager              = $pager;
        $this->view->recTotal           = $pager->recTotal;
        $this->view->recPerPage         = $pager->recPerPage;
        $this->view->pageID             = $pager->pageID;
        $this->view->orderBy            = $orderBy;
        $this->display();
    }

    /**
     * Create a conclusion.
     * 
     * @param  int    $moduleID 
     * @param  int    $conclusionID
     * @access public
     * @return void
     */
    public function create($recreate = 0)
    {
        $conclusion = new stdClass();
        $conclusion->creatorID      = '';
        $conclusion->title       = '';
        $conclusion->content     = '';
        $conclusion->createtime = '';
        $conclusion->updatetime = '';

        if(!empty($_POST))
        {
            $conclusion = fixer::input('post')
                            ->remove('labels')->get();
            if (!(trim($conclusion->title) && trim($conclusion->content))) {
                echo js::alert($this->lang->conclusion->noImportantInformation);      
                $this->session->set('createConclusion', $conclusion);
                die(js::locate($this->createLink('conclusion', 'create', "recreate=1"), 'parent'));
            }
            $this->conclusion->create();
            $this->action->create('conclusion', $conclusionID, 'created');
            echo js::alert($this->lang->conclusion->createsucceed);
            die(js::locate($this->createLink('conclusion', 'viewConclusion'), 'parent'));
        }
        
        $this->view->conclusion = $recreate ? $this->session->createConclusion : null;
        $this->display();
    }

    /**
     * Edit a conclusion.
     * 
     * @param  int    $conclusionID 
     * @access public
     * @return void
     */
    public function edit($conclusionID, $comment = false)
    {
        if(!empty($_POST))
        {
            $this->loadModel('action');
            $changes = array();
            $files   = array();
            if($comment == false)
            {
                $changes = $this->conclusion->update($conclusionID);
                if(dao::isError()) die(js::error(dao::getError()));
                $this->action->create('conclusion', $conclusionID, 'edited');
                $files = $this->loadModel('file')->saveUpload('conclusion', $conclusionID);
            }

            $conclusion = $this->conclusion->getById($conclusionID);
            if(!empty($changes) or !empty($files))
            {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $fileAction = '';
                if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
            }
            echo js::alert($this->lang->conclusion->editsucceed);
            die(js::locate($this->createLink('conclusion', 'view', "conclusionID=$conclusionID"), 'parent'));
        }

        $this->view->conclusion    = $this->conclusion->getByID($conclusionID);

        if (!$this->conclusion->checkPriv($this->view->conclusion, 'edit')) die();
        $this->view->actions = $this->loadModel('action')->getList('conclusion', $conclusionID);
        $this->display();
    }

    /**
     * Delete a conclusion.
     * 
     * @param  int    $projectID 
     * @param  int    $conclusionID 
     * @param  string $confirm yes|no
     * @access public
     * @return void
     */
    public function delete($conclusionID, $confirm = 'no')
    {
        $conclusion = $this->conclusion->getById($conclusionID);
        $this->view->conclusion = $conclusion;

        if (!$this->conclusion->checkPriv($conclusion, 'delete')) die();
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->conclusion->confirmDelete, inlink('delete', "conclusionID=$conclusionID&confirm=yes")));
        }
        else
        {
            $this->conclusion->delete($conclusionID);
            $this->action->create('conclusion', $conclusionID, 'deleted');
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
            echo js::alert($this->lang->conclusion->deletesucceed);
            die(js::locate($this->createLink('conclusion', 'viewConclusion'), 'parent'));
        }
    }

    /**
     * view a conclusion.
     * 
     * @access public
     * @return void
     */
    public function view($conclusionID = 0)
    {
        /*根据权限设置任务列表*/
        $conclusionList = array();
        $conclusion = $this->conclusion->getById($conclusionID);

        if (!$this->conclusion->checkPriv($conclusion, 'view')) die();
        
        $userpairs    = $this->user->getPairs('noletter');
        
        $this->conclusion->saveRead($conclusion);
        if(!empty($_POST))
        {
            $this->task->makeComment($conclusionID,'C');
            die(js::locate($this->createLink('conclusion', 'view', "conclusionID=$conclusionID"), 'parent'));
        }

       $comments = $this->task->getComments('conclusion',$conclusionID);

        $this->view->conclusion  = $conclusion;
        $this->view->comments    = $comments;
        $this->view->userpairs   = $userpairs;
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('conclusion', $conclusionID);
        $this->display();
    } 

    public function search()
    { 
        $get_data = fixer::input('post')->get();
        die(js::locate($this->createLink('conclusion', 'viewConclusion', array('orderBy' => 'id_desc', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramtitle' => $get_data->title, 'paramstu' => $get_data->creator)), 'parent'));
    }
}