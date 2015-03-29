<?php
class tutorial extends control
{
    const NEW_COUNT = 10;

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
        $this->loadModel('tutor');
        $this->loadModel('student');
        $this->loadModel('personalinfo');
        $this->loadModel('workspace');
        $this->loadModel('action');
    }
    
    /**
     * The index of student, goto project deviation.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('viewTutorialSystem')); 
    }
    
    public function viewTutorialSystem($paramname = '', $paramaccount = '', $tea_account = 0, $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $tutors = $this->tutor->getTutorByCollege('', $paramname, $paramaccount, $pager, 'realname');
        if (!$tea_account) $tea_account = $tutors[0]->account;

        foreach ($tutors as $key => $tutor) 
        {      
            $students = $this->student->getStudents($tutor->account, '', null, null, null, $this->session->user->grade);
            $tutor->stu_number = count($students);
            if ($tutor->account == $tea_account)
            {
                $name = array();
                foreach ($students as $k => $student) 
                {
                    $name[$k]->realname = $student->realname;
                    $name[$k]->account = $student->account;
                    $name[$k]->relation = $student->team;
                }
                $tutor->student = $name;
                $this->view->students = $name;
                $this->view->teaid = $key;
            }
        }
        
        $this->view->studentList = ($this->session->user->roleid == 'counselor') ? $this->tutorial->getList('student', $this->session->user->college_id, $this->session->user->grade) : $this->tutorial->getList('student');
        $this->view->tutors = $tutors;
        $this->view->tea_account = $tea_account;
        $this->view->searchname = $paramname;
        $this->view->searchaccount = $paramaccount;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->tutorialList = ($this->session->user->roleid == 'counselor') ? array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewSomeStudent') : array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewAllStudent');
        $this->view->active = 'viewTutorialSystem';
        $this->display();
    }

    public function viewStudentSystem($paramname = '', $paramaccount = '', $stu_account = 0, $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $students = $this->student->getStudentByCollege('', $paramname, $paramaccount, $pager, 'account', $this->session->user->grade);
        
        if (!$stu_account)  $stu_account = $students[0]->account;

        foreach ($students as $key => $student) 
        {
            $teachers = $this->tutor->getTutorByStudent($student->account);
            $student->tea_number = count($teachers);
            if ($student->account == $stu_account)
            {
                $name = array();
                foreach ($teachers as $k => $teacher) 
                {
                    $name[$k]->realname = $teacher->realname;
                    $name[$k]->account = $teacher->account;
                    $name[$k]->relation = $teacher->team;
                }

                $student->teacher = $name;  
                $this->view->teachers = $name;
                $this->view->stuid = $key;
            }
        }
   
        $this->view->teacherList = $this->tutorial->getList('teacher');
        $this->view->stu_account = $stu_account;
        $this->view->students = $students;
        $this->view->searchname = $paramname;
        $this->view->searchaccount = $paramaccount;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->tutorialList = ($this->session->user->roleid == 'counselor') ? array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewSomeStudent') : array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewAllStudent');
        $this->view->active = 'viewStudentSystem';
        $this->display();
    }

    public function viewAllTutor($paramname = '', $paramaccount = '', $orderBy = 'realname_asc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $tutors = $this->tutor->getTutorByCollege('', $paramname, $paramaccount, $pager, $orderBy);

        foreach ($tutors as $tutor) 
        {
            $students = $this->student->getStudents($tutor->account);

            $tutor->stu_number = count($students);
            $name = array();
            foreach ($students as $key => $student) 
            {   
                if (strstr($student->team, 'P'))
                {
                    $name[P][] = $student->realname;
                }
                else
                {
                    if ($student->team)
                    {
                        $name[R] = (strstr($student->team, 'R')) ? 1 : -1;

                        if (strstr($student->team, 'T'))
                            $name[T][] = $student->realname;
                        if (strstr($student->team, 'G'))
                            $name[G][] = $student->realname;
                    }
                    else
                        $name[I][] = $student->realname;
                }     
            }
            $tutor->student = $name;
        }
  
        $this->view->tutors = $tutors;
        $this->view->searchname = $paramname;
        $this->view->searchaccount = $paramaccount;
        $this->view->pager = $pager;
        $this->view->orderBy = $orderBy;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->tutorialList = ($this->session->user->roleid == 'counselor') ? array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewSomeStudent') : array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewAllStudent');
        $this->view->active = 'viewAllTutor';
        $this->display();
    }

    public function viewAllStudent($paramname = '', $paramaccount = '', $orderBy = 'account_asc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
          
        $students = $this->student->getStudentByCollege('', $paramname, $paramaccount, $pager, $orderBy);
        
        foreach ($students as $student) 
        {
            $tutors = $this->tutor->getTutorByStudent($student->account);
            $name = array();
            foreach ($tutors as $key => $tutor) 
            {
                $name[$key] = $tutor->realname;
                if (strstr($tutor->team, 'G'))
                    $name[$key] .= '(' . $this->lang->tutorial->relation2[G] . ')';
                if (strstr($tutor->team, 'T'))
                    $name[$key] .= '(' . $this->lang->tutorial->relation2[T] . ')';
                if (strstr($tutor->team, 'R'))
                    $name[$key] .= '(' . $this->lang->tutorial->relation2[R] . ')';
                if (strstr($tutor->team, 'P'))
                    $name[$key] .= '(' . $this->lang->tutorial->relation2[P] . ')';
            }

            $student->tutor = $name;
        }

        $this->view->students = $students;
        $this->view->searchname = $paramname;
        $this->view->searchaccount = $paramaccount;
        $this->view->orderBy = $orderBy;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->tutorialList = ($this->session->user->roleid == 'counselor') ? array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewSomeStudent') : array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewAllStudent');
        $this->view->active = 'viewAllStudent';
        $this->display();
    }
    
    public function viewSomeStudent($paramname = '', $paramaccount = '', $orderBy = 'account_asc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
          
        $students = $this->student->getStudentByCollege('', $paramname, $paramaccount, $pager, $orderBy, $this->session->user->grade);
        
        foreach ($students as $student) 
        {
            $tutors = $this->tutor->getTutorByStudent($student->account);
            $name = array();
            foreach ($tutors as $key => $tutor) 
            {
                $name[$key] = $tutor->realname;
                if (strstr($tutor->team, 'G'))
                    $name[$key] .= '(' . $this->lang->tutorial->relation2[G] . ')';
                if (strstr($tutor->team, 'T'))
                    $name[$key] .= '(' . $this->lang->tutorial->relation2[T] . ')';
                if (strstr($tutor->team, 'R'))
                    $name[$key] .= '(' . $this->lang->tutorial->relation2[R] . ')';
                if (strstr($tutor->team, 'P'))
                    $name[$key] .= '(' . $this->lang->tutorial->relation2[P] . ')';
            }

            $student->tutor = $name;
        }

        $this->view->students = $students;
        $this->view->searchname = $paramname;
        $this->view->searchaccount = $paramaccount;
        $this->view->orderBy = $orderBy;
        $this->view->pager = $pager;
        $this->view->recTotal = $pager->recTotal;
        $this->view->recPerPage = $pager->recPerPage;
        $this->view->pageID = $pager->pageID;
        $this->view->tutorialList = ($this->session->user->roleid == 'counselor') ? array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewSomeStudent') : array('viewTutorialSystem', 'viewStudentSystem', 'viewAllTutor', 'viewAllStudent');
        $this->view->active = 'viewSomeStudent';
        $this->display();
    }
    public function saveStudents()
    {   
        $get_data = fixer::input('post')->get();
        if (!$get_data->tutoraccount)
        {
            echo js::alert("请选择导师！");
            die(js::reload('parent'));        
        }
        $this->tutorial->saveStudents($get_data->tutoraccount, array_unique($get_data->newStudent), $get_data->relation);
        die(js::reload('parent'));
    }

    public function saveTeachers()
    {
        $get_data = fixer::input('post')->get();
        if (!$get_data->studentaccount)
        {
            echo js::alert("请选择学生！");
            die(js::reload('parent'));        
        }
        $this->tutorial->saveTeachers($get_data->studentaccount, array_unique($get_data->newTeacher), $get_data->relation);
        die(js::reload('parent'));
    }

    public function search()
    {
        $method = $this->post->method;

        $get_data = fixer::input('post')->remove('method')->get();
   
        die(js::locate($this->createLink('tutorial', $method, array('paramname' => $get_data->name, 'paramaccount' => $get_data->account)), 'parent'));
    }
}