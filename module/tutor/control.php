<?php
class tutor extends control
{
    /**
     * Construct function, load user, tree, action auto.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
        $this->loadModel('personalinfo');
        $this->loadModel('task');
        $this->loadModel('project');
        $this->loadModel('achievement');
        $this->loadModel('resources');
        $this->loadModel('file');
        $this->loadModel('group');
        $this->loadModel('student');
        $this->loadModel('problem');
    }

    /**
     * The index of system, goto project deviation.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('viewBasicInformation')); 
    }


    /**
     * Tasks of a project.
     * 
     * @param  int    $projectID 
     * @param  string $status 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function viewBasicInformation($tutor_account = 0)
    {
        $collegelist = $this->personalinfo->getCollegeList();
        $tutors = $this->tutor->getTutorByStudent();
        $this->personalinfo->setMenu();

        /*point the tutor of the student*/
        foreach ($tutors as $tutor) 
        {
            if(strstr($tutor->team,'G'))
                $tutor->realname .= '(指导老师)';
            if (strstr($tutor->team, 'P'))
                $tutor->realname .= '(毕业设计)';
        }

        /*set the tutor*/
        if(!$tutor_account)
        {
            $tutor_account = $tutors[0]->account;
            $user = $this->user->getByAccount($tutor_account);
        }
        else
            $user = $this->user->getByAccount($tutor_account);

        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->viewBasicInformation;
        $this->view->position[] = $this->lang->my->viewBasicInformation;
        $this->view->collegelist= $collegelist;
        $this->view->user       = $user;
        $this->view->tutors     = $tutors;
        $this->view->tutor_account     = $tutor_account;
        $this->view->groups     = $this->loadModel('group')->getByAccount($this->app->user->account);

        $this->display();
    }

    /**
     * Browse stories of a project.
     * 
     * @param  int    $projectID 
     * @param  string $orderBy 
     * @access public
     * @return void
     */
    public function viewProject($tutor_account = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramname = '', $paramstu = '')
    { 
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);
       
        $tutors = $this->tutor->getTutorByStudent();
        if(!$tutor_account)
        {
            $tutor_account = $tutors[0]->account;
            $user = $this->user->getByAccount($tutor_account);
        }
        else
            $user = $this->user->getByAccount($tutor_account);

        $this->view->projects = $this->project->getOtherProject($tutor_account, $orderBy, $pager, $paramname, $paramstu);
        $this->view->searchname = $paramname;
        $this->view->searchstu = $paramstu;
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->pager       = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID     = $pager->pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->tutors     = $tutors;
        $this->view->tutor_account     = $tutor_account;
        $this->display();
    }

    public function viewProjectDetail($projectID)
    {
        $this->view->project = $this->project->getProjectByPID($projectID);
        $this->display();
    }
    /**
     * Browse bugs of a project. 
     * 
     * @param  int    $projectID 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function viewStudent($tutor_account = 0, $paramaccount = '', $paramname = '')
    {
        $tutors = $this->tutor->getTutorByStudent();
        $collegelist = $this->personalinfo->getCollegeList();
        /*set the tutor*/
        if(!$tutor_account) $tutor_account = $tutors[0]->account;
       
        $students = $this->task->getTeamMembers($tutor_account, $paramaccount, $paramname); 
        $this->view->searchaccount = $paramaccount;
        $this->view->searchname = $paramname;
        $this->view->students = $students;
        $this->view->collegelist = $collegelist;
        $this->view->tutors = $tutors;
        $this->view->tutor_account = $tutor_account;
        $this->display();
    }

    /**
     * view the details of a student. 
     * 
     * @param  int    $studentID 
     * @access public
     * @return void
     */
    public function viewStudentDetails($student_account)
    {
        $student = $this->user->getByAccount($student_account);
        $tasks = $this->task->getOtherTask($student_account);
        $userpairs = $this->user->getPairs('noletter');
        $achievements = $this->achievement->getOtherAchievements($student_account);
        $tutors = $this->tutor->getTutorByStudent($student_account);
        $problems = $this->problem->getOtherProblem($student_account);

        if (count($tasks) >= 7)  $breakTaskNum = 5;
        else  $breakTaskNum = 6;

        if (count($achievements) >= 7) $breakAchNum = 5;
        else  $breakAchNum = 6;
        
        if (count($problems) >= 7) $breakPromNum = 5;
        else  $breakPromNum = 6;

        $this->view->module = 'tutor';
        $this->view->achievements    = $achievements;
        $this->view->student = $student;
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



    /**
     * View a project.
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function sharing($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramtitle = '', $paramcreator = '')
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);
        
        $this->view->searchtitle = $paramtitle;
        $this->view->searchcreator = $paramcreator;
        $this->view->files = $this->tutor->getGroupFile($orderBy, $pager, $paramtitle, $paramcreator);
        $this->view->userpairs = $this->user->getPairs('noletter');
        $this->view->orderBy = $orderBy;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->display();
    }

    public function viewMoreTask($student_account, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);
       
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

    public function viewMoreAchievement($student_account, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);
     
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

    public function viewMoreProblem($student_account, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

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
            case 'viewProject':
                die(js::locate($this->createLink('tutor', 'viewProject', array('tutor_account' => $get_data->teaAccount, 'orderBy' => '', 'recTatal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramname' => $get_data->name, 'paramstu' => $get_data->creator_ID)), 'parent'));
                break;
            case 'viewStudent':
                die(js::locate($this->createLink('tutor', 'viewStudent', array('tutor_account' => $get_data->teaAccount, 'paramaccount' => $get_data->account, 'paramname' => $get_data->name)), 'parent'));
                break;
            case 'sharing':
                die(js::locate($this->createLink('tutor', 'sharing', array('orderBy' => '', 'recTotal' => 0, 'recPerPage' => 15, 'pageID' => 1, 'paramtitle' => $get_data->title, 'paramcreator' => $get_data->creator)), 'parent'));
                break;
        }
    }
}
