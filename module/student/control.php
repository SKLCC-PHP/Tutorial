<?php
class student extends control
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
        $this->loadModel('task');
        $this->loadModel('tutor');
        $this->loadModel('project');
        $this->loadModel('achievement');
        $this->loadModel('personalinfo');
        $this->loadModel('problem');
    }
    /**
     * The index of student, goto project deviation.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('viewAll')); 
    }
    
    public function viewAll($orderBy = 'account', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramaccount = '', $paramname = '')
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = $this->cookie->tutorialOrder ? $this->cookie->tutorialOrder : 'account';
        setcookie('tutorialOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

        $this->view->students = $this->student->getAll('', $orderBy, $pager, $paramaccount, $paramname);
        $this->view->searchaccount = $paramaccount;
        $this->view->searchname = $paramname;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->display();
    }
    /**
     * Product information student.
     * 
     * @access public
     * @return void
     */
    public function viewUndergraduate($orderBy = 'account', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramaccount = '', $paramname = '')
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = $this->cookie->tutorialOrder ? $this->cookie->tutorialOrder : 'account';
        setcookie('tutorialOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

        $this->view->students = $this->student->getUndergraduate('', $orderBy, $pager, $paramaccount, $paramname);
        $this->view->searchaccount = $paramaccount;
        $this->view->searchname = $paramname;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->display();
    }


    /**
     * Project deviation student.
     * 
     * @access public
     * @return void
     */
    public function viewGraduate($orderBy = 'account', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramaccount = '', $paramname = '')
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = $this->cookie->tutorialOrder ? $this->cookie->tutorialOrder : 'account';
        setcookie('tutorialOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

        $this->view->students = $this->student->getgraduate('', $orderBy, $pager, $paramaccount, $paramname);
        $this->view->searchaccount = $paramaccount;
        $this->view->searchname = $paramname;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->display();
    }

    /**
     * viewPostgraduate student.
     * 
     * @param  int    $begin 
     * @param  int    $end 
     * @access public
     * @return void
     */
    public function viewPostgraduate($orderBy = 'account', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramaccount = '', $paramname = '')
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = $this->cookie->tutorialOrder ? $this->cookie->tutorialOrder : 'account';
        setcookie('tutorialOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

        $this->view->students = $this->student->getpostgraduate('', $orderBy, $pager, $paramaccount, $paramname);
        $this->view->searchaccount = $paramaccount;
        $this->view->searchname = $paramname;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->display(); 
    }

     public function viewStudentDetails($student_account)
    {
        $student = $this->user->getByAccount($student_account);
        $tasks = $this->task->getOtherTask($student_account);
        $userpairs = $this->user->getPairs('noletter');
        $achievements = $this->achievement->getOtherAchievements($student_account);
        $tutors = $this->tutor->getTutorByStudent($student_account);
        $problems = $this->problem->getOtherProblem($student_account);
        $colleges = $this->dao->select('college_id, college_name')->from(TABLE_COLLEGE)->where('status')->eq(1)->fetchAll();

        $collegelist = array();
        foreach ($colleges as $college) 
        {
            $collegelist[$college->college_id] = $college->college_name;
        }

        if (count($tasks) >= 7)  $breakTaskNum = 5;
        else  $breakTaskNum = 6;

        if (count($achievements) >= 7) $breakAchNum = 5;
        else  $breakAchNum = 6;
        
        if (count($problems) >= 7) $breakPromNum = 5;
        else  $breakPromNum = 6;

        $this->view->module = 'student';
        $this->view->achievements = $achievements;
        $this->view->student = $student;
        $this->view->collegelist = $collegelist;
        $this->view->tasks = $tasks;
        $this->view->problems = $problems;
        $this->view->breakTaskNum = $breakTaskNum;
        $this->view->breakAchNum = $breakAchNum;
        $this->view->breakPromNum = $breakPromNum;
        $this->view->userpairs = $userpairs;
        $this->view->tutors = $tutors;
        $this->view->student_account = $student_account;
        $this->display();
    }

    public function viewMoreTask($student_account, $orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('projectTaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        
        $this->view->tasks = $this->task->getOtherTask($student_account, $orderBy, $pager);
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->view->student_account = $student_account;
        $this->display();
    }

    public function viewMoreAchievement($student_account, $orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('projectTaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        
        $this->view->achievements = $this->achievement->getOtherAchievements($student_account, $orderBy, $pager);
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->view->student_account = $student_account;
        $this->display();
    }

    public function viewMoreProblem($student_account, $orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        if(!$orderBy) $orderBy = 'id_desc';
        setcookie('projectTaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        
        $this->view->problems = $this->problem->getOtherProblem($student_account, $orderBy, $pager);
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->orderBy = $orderBy;
        $this->view->student_account = $student_account;
        $this->display();
    }

    public function search()
    {
        $get_data = fixer::input('post')->get();
        switch ($get_data->method)
        {
            case 'viewAll':
                die(js::locate($this->createLink('student', 'viewAll', array('orderBy' => 'account', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramaccount' => $get_data->account, 'paramname' => $get_data->name)), 'parent'));
                break;
            case 'viewPostgraduate':
                die(js::locate($this->createLink('student', 'viewPostgraduate', array('orderBy' => 'account', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramaccount' => $get_data->account, 'paramname' => $get_data->name)), 'parent'));
                break;
            case 'viewGraduate':
                die(js::locate($this->createLink('student', 'viewGraduate', array('orderBy' => 'account', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramaccount' => $get_data->account, 'paramname' => $get_data->name)), 'parent'));
                break;
            case 'viewUndergraduate':
                die(js::locate($this->createLink('student', 'viewUndergraduate', array('orderBy' => 'account', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramaccount' => $get_data->account, 'paramname' => $get_data->name)), 'parent'));
                break;    
        }
    }
}