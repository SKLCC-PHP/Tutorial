<?php
class resources extends control
{
    /**
     * Construct function, load some modules auto.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
        $this->loadModel('tutor');
        $this->loadModel('personalinfo');
        $this->loadModel('task');
        $this->loadModel('student');
        $this->loadModel('achievement');
        $this->loadModel('project');
        $this->loadModel('problem');
    }

    /**
     * The index page, locate to browse.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate($this->createLink('resources', 'viewTeachers'));
    }

    /**
     * Browse bugs.
     * 
     * @param  int    $productID 
     * @param  string $browseType 
     * @param  int    $param 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function viewTeachers($recTotal = 0, $recPerPage = 15, $pageID = 1, $paramrealname = '', $paramresearch = '') 
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $teachers = $this->tutor->getTutorByCollege($this->session->userinfo->collegeid, $paramrealname, '', $pager, '', $paramresearch);
        $collegelist = $this->personalinfo->getCollegeList();

        $this->view->position     = $position;
        $this->view->teachers     = $teachers;
        $this->view->collegelist     = $collegelist;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->searchrealname = $paramrealname;
        $this->view->searchresearch = $paramresearch;
        $this->display();
    }

    /**
     * view the details of a teacher. 
     * 
     * @param  int    $studentID 
     * @access public
     * @return void
     */
    public function viewTeacherDetails($teacher_account)
    {
        $students = $this->task->getTeamMembers($teacher_account);
        $teacher = $this->user->getByAccount($teacher_account);
        $userpairs = $this->user->getPairs('noletter');
        $achievements = $this->achievement->getOtherAchievements($teacher_account, '', null, 'teaID');
        $tasks = $this->task->getOtherTask($teacher_account, '', null, 'asgID');
        $projects = $this->project->getOtherProject($teacher_account);
        $collegelist = $this->personalinfo->getCollegeList(); 
        $problems = $this->problem->getOtherProblem($teacher_account, '', null, 'acpID');
        
        if (count($students) >= 8) $breakStuNum = 6;
        else  $breakStuNum = 7;

        if (count($achievements) >= 8) $breakAchNum = 6;
        else  $breakAchNum = 7;

        $this->view->breakStuNum = $breakStuNum;
        $this->view->breakAchNum = $breakAchNum;
        $this->view->achievements    = $achievements;
        $this->view->projects = $projects;
        $this->view->tasks = $tasks;
        $this->view->problems = $problems;
        $this->view->user = $teacher;
        $this->view->userpairs = $userpairs;
        $this->view->students = $students;
        $this->view->collegelist     = $collegelist;
        $this->view->teacher_account = $teacher_account;
        $this->view->teacher_name  = $userpairs[$teacher_account];
        $this->display();
    }

     /**
     * Browse bugs.
     * 
     * @param  int    $productID 
     * @param  string $browseType 
     * @param  int    $param 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function sharing($orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1, 
        $paramtitle = '', $paramaddedBy = '')
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('TaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

        $files = $this->resources->getFilesByACL(3, $orderBy, $pager, $paramtitle, $paramaddedBy);
        $userpairs = $this->user->getPairs('noletter');

        $this->view->files = $files;
        $this->view->userpairs = $userpairs;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->view->searchtitle = $paramtitle;
        $this->view->searchextension = $paramextension;
        $this->view->searchaddedBy = $paramaddedBy;
        $this->view->searchextra = $paramextra;
        $this->display();
    }

    /**
     * upload files.
     * 
     * @access public
     * @return void
     */
    public function upload()
    {
         if(!empty($_POST))
        {
            $this->resources->upload();
 
            die(js::locate($this->createLink('tutor', 'Sharing'), 'parent'));
        }

        $this->display();
    }

    public function viewMoreTask($teacher_account, $orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('TaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        
        $this->view->tasks = $this->task->getOtherTask($teacher_account, $orderBy, $pager, 'asgID');
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->view->teacher_account = $teacher_account;
        $this->display();
    }

    public function viewMoreAchievement($teacher_account, $orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('achievementOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        
        $this->view->achievements = $this->achievement->getOtherAchievements($teacher_account, $orderBy, $pager, 'teaID');
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->view->teacher_account = $teacher_account;
        $this->display();
    }

    public function viewMoreProblem($teacher_account, $orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('problemOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        
        $this->view->problems = $this->problem->getOtherProblem($teacher_account, $orderBy, $pager, 'acpID');
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->view->teacher_account = $teacher_account;
        $this->display();
    }

    public function viewMoreProject($teacher_account, $orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('projectOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        
        $this->view->projects = $this->project->getOtherProject($teacher_account, $orderBy, $pager);
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->view->teacher_account = $teacher_account;
        $this->display();
    }

    public function viewMoreStudent($teacher_account)
    {
        $this->view->students = $this->task->getTeamMembers($teacher_account);
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->teacher_account = $teacher_account;
        $this->display();
    }

    public function search($searchobject = 'teachers')
    {
        if($searchobject == 'teachers')
        {
            $get_data = fixer::input('post')->get();
            die(js::locate($this->createLink('resources', 'viewTeachers', array('recTotal' => 0, 'recPerPage' => 15, 
                    'pageID' => 1, 'paramrealname' => $get_data->realname, 'paramresearch' => $get_data->research)), 'parent'));
        }
        elseif($searchobject == 'sharing')
        {
            $get_data = fixer::input('post')->get();
            die(js::locate($this->createLink('resources', 'sharing', array('orderBy' => 'id_desc', 'recTotal' => 0, 'recPerPage' => 15, 
                    'pageID' => 1, 'paramtitle' => $get_data->title, 'paramaddedBy' => $get_data->addedBy)), 'parent'));
        }
    }
}
