<?php
class statisticsModel extends model
{
    /**
     * get the task number.
     * @access public
     * @return void
     */
    public function getTaskNumber($accounts = 0, $viewtype = 'student', $field = 'acpID')
    {
        if(!is_array($accounts)) $accounts = (array)$accounts;
        if($viewtype == 'teacher') $field = 'asgID';

        $tasks = $this->dao->select('t1.account, t1.realname, t2.id, t2.completetime, t2.deadline, t2.assesstime, t2.ACL')
                            ->from(TABLE_USER)->alias(t1)
                            ->leftJoin(TABLE_TASK)->alias(t2)
                            ->on('t1.account=t2.'.$field)
                            ->where('t2.'.$field)->in($accounts)
                            ->andWhere('t2.deleted')->eq(0)
                            ->orderBy('account')
                            ->fetchAll();
        $tasks = $this->loadModel('task')->processTasks($tasks);

        foreach ($accounts as $account) 
        {
            /*init the array*/
            $result = array('account' => '', 'realname' => '', 'AcceptNumber_sum' => 0, 'AcceptNumber_public' => 0, 'AcceptNumber_protected' => 0, 
                        'AcceptNumber_private' => 0, 'CompleteNumber_sum' => 0, 'CompleteNumber_undelayed' => 0, 'CompleteNumber_delayed' => 0, 'UncompleteNumber' => 0);
            $realname = $this->loadModel('user')->getRealNameAndEmails($account);
            $result['realname'] = $realname[$account]->realname; 
            $result['account'] = $account;
            foreach ($tasks as $task) 
            {
                if($task->account != $account) continue;
                $result['AcceptNumber_sum'] += 1;

                if($task->ACL == '1')
                {
                    $result['AcceptNumber_private'] += 1;
                }
                elseif ($task->ACL == '2') 
                {
                    $result['AcceptNumber_protected'] += 1;
                }
                elseif ($task->ACL == '3') 
                {
                    $result['AcceptNumber_public'] += 1;
                }

                if($task->completetime != null and $task->completetime != '0000-00-00 00:00:00')
                {
                    if($task->delay > 0)
                    {
                        $result['CompleteNumber_delayed'] += 1;
                    }
                    else
                    {
                        $result['CompleteNumber_undelayed'] += 1;
                    }
                }
                else
                {
                    $result['UncompleteNumber'] += 1;
                }
                $result['CompleteNumber_sum'] = $result['CompleteNumber_delayed']+$result['CompleteNumber_undelayed'];
            }

            if(!empty($result))
                $results[] = (object)$result;
        }

        return $results;
    }

    /**
     * get the problem number.
     * @access public
     * @return void
     */
    public function getProblemNumber($accounts = 0, $viewtype = 'student', $field = 'asgID')
    {
        if(!is_array($accounts)) $accounts = (array)$accounts;
        if($viewtype == 'teacher') $field = 'acpID';

        $problems = $this->dao->select('t1.account, t1.realname, t2.id, t2.asgID, t2.acpID, t2.solvetime, t2.solID, t2.ACL')
                            ->from(TABLE_USER)->alias(t1)
                            ->leftJoin(TABLE_QUESTION)->alias(t2)
                            ->on('t1.account=t2.'.$field)
                            ->where('t1.account')->in($accounts)
                            ->beginIF($viewtype == 'teacher')->orWhere('t2.solID')->in($accounts)->fi()
                            ->andWhere('t2.deleted')->eq(0)
                            ->orderBy('account')
                            ->fetchAll();

        foreach ($accounts as $account) 
        {
            /*init the array*/
            $result = array('account' => '', 'realname' => '', 'AskNumber_sum' => 0, 'AskNumber_public' => 0, 'AskNumber_protected' => 0, 
                        'AskNumber_private' => 0, 'AnsweredNumber' => 0, 'UnansweredNumber' => 0);
            $realname = $this->loadModel('user')->getRealNameAndEmails($account);
            $result['realname'] = $realname[$account]->realname;
            $result['account'] = $account;
            foreach ($problems as $problem) 
            {
                if($viewtype == 'student')
                {
                    if($problem->account != $account) continue;
                    if(!empty($problem->id))
                        $result['AskNumber_sum'] += 1;

                    if($problem->ACL == '1')
                    {
                        $result['AskNumber_private'] += 1;
                    }
                    elseif ($problem->ACL == '2') 
                    {
                        $result['AskNumber_protected'] += 1;
                    }
                    elseif ($problem->ACL == '3') 
                    {
                        $result['AskNumber_public'] += 1;
                    }

                    if($problem->solvetime != null and $problem->solvetime != '0000-00-00 00:00:00')
                    {
                        $result['AnsweredNumber'] += 1;
                    }
                    else
                    {
                        $result['UnansweredNumber'] += 1;
                    }
                }
                else
                {
                    if($problem->account != $account and $problem->solID != $account) continue;

                    if($problem->account == $account)
                    {
                        $result['AskNumber_sum'] += 1;
                        if($problem->ACL == '1')
                        {
                            $result['AskNumber_private'] += 1;
                        }
                        elseif ($problem->ACL == '2') 
                        {
                            $result['AskNumber_protected'] += 1;
                        }
                        elseif ($problem->ACL == '3') 
                        {
                            $result['AskNumber_public'] += 1;
                        }

                        if($problem->solvetime == null or $problem->solvetime == '0000-00-00 00:00:00' or $problem->solID != $account)
                        {
                            $result['UnansweredNumber'] += 1;
                        }
                    }

                    if($problem->solID == $account)
                    {
                        $result['AnsweredNumber'] += 1;
                    }
                }
            }

            if(!empty($result))
                $results[] = (object)$result;
        }

        return $results;
    }

    /**
     * get the project number.
     * @access public
     * @return void
     */
    public function getProjectNumber($accounts = 0)
    {
        if(!is_array($accounts)) $accounts = (array)$accounts;

        $projects = $this->dao->select('t1.realname, t2.id, t2.creator_ID, t2.starttime, t2.finishtime, t2.ACL')
                            ->from(TABLE_USER)->alias(t1)
                            ->leftJoin(TABLE_PROJECT)->alias(t2)
                            ->on('t1.account=t2.creator_ID')
                            ->where('t1.account')->in($accounts)
                            ->andWhere('t2.deleted')->eq(0)
                            ->orderBy('account')
                            ->fetchAll();

        foreach ($accounts as $account) 
        {
            /*init the array*/
            $result = array('account' => '', 'realname' => '', 'Number_sum' => 0, 'Number_public' => 0, 'Number_protected' => 0, 
                        'Number_private' => 0, 'UnderwayNumber' => 0, 'FinishedNumber' => 0);
            $realname = $this->loadModel('user')->getRealNameAndEmails($account);
            $result['realname'] = $realname[$account]->realname;
            $result['account'] = $account;
            foreach ($projects as $project) 
            {
                if($project->creator_ID != $account) continue;
                $result['Number_sum'] += 1;

                if($project->ACL == '1')
                {
                    $result['Number_private'] += 1;
                }
                elseif ($project->ACL == '2') 
                {
                    $result['Number_protected'] += 1;
                }
                elseif ($project->ACL == '3') 
                {
                    $result['Number_public'] += 1;
                }

                if($project->starttime != null and $project->starttime != '0000-00-00 00:00:00')
                {
                    if($project->finishtime != null and $project->finishtime != '0000-00-00 00:00:00')
                        $result['FinishedNumber'] += 1;
                    else
                        $result['UnderwayNumber'] += 1;
                }
            }

            if(!empty($result))
                $results[] = (object)$result;
        }

        return $results;
    }

    /**
     * get the achievement number.
     * @access public
     * @return void
     */
    public function getAchievementNumber($accounts = 0)
    {
        if(!is_array($accounts)) $accounts = (array)$accounts;

        $achievements = $this->dao->select('t1.realname, t2.id, t2.creatorID, t2.type')
                            ->from(TABLE_USER)->alias(t1)
                            ->leftJoin(TABLE_ACHIEVEMENT)->alias(t2)
                            ->on('t1.account=t2.creatorID')
                            ->where('t2.creatorID')->in($accounts)
                            ->andWhere('t2.deleted')->eq(0)
                            ->andWhere('t2.checked')->eq(1)
                            ->orderBy('account')
                            ->fetchAll();

        foreach ($accounts as $account) 
        {
            /*init the array*/
            $result = array('account' => '', 'realname' => '', 'TotalNumber' => 0, 'ThesisNumber' => 0, 'CopyrightNumber' => 0, 
                            'PatentNumber' => 0, 'ResearchNumber' => 0, 'AwardsNumber' => 0);
            $realname = $this->loadModel('user')->getRealNameAndEmails($account);
            $result['realname'] = $realname[$account]->realname;
            $result['account'] = $account;
            foreach ($achievements as $achievement) 
            {
                if($achievement->creatorID != $account) continue;
                $result['TotalNumber'] += 1;

                if($achievement->type == 'thesis')
                {
                    $result['ThesisNumber'] += 1;
                }
                elseif ($achievement->type == 'copyright') 
                {
                    $result['CopyrightNumber'] += 1;
                }
                elseif ($achievement->type == 'patent') 
                {
                    $result['PatentNumber'] += 1;
                }elseif ($achievement->type == 'research')      
                {
                    $result['ResearchNumber'] += 1;
                }elseif ($achievement->type == 'awards') 
                {
                    $result['AwardsNumber'] += 1;
                }
            }

            if(!empty($result))
                $results[] = (object)$result;
        }

        return $results;
    }

    /**
     * get the conclusion number.
     * @access public
     * @return void
     */
    public function getConclusionNumber($accounts = 0)
    {
        if(!is_array($accounts)) $accounts = (array)$accounts;

        $achievements = $this->dao->select('t1.realname, t2.id, t2.creatorID, t2.viewtime')
                            ->from(TABLE_USER)->alias(t1)
                            ->leftJoin(TABLE_CONCLUSION)->alias(t2)
                            ->on('t1.account=t2.creatorID')
                            ->where('t2.creatorID')->in($accounts)
                            ->andWhere('t2.deleted')->eq(0)
                            ->orderBy('account')
                            ->fetchAll();

        foreach ($accounts as $account) 
        {
            /*init the array*/
            $result = array('account' => '', 'realname' => '', 'TotalNumber' => 0, 'AssessedNumber' => 0, 'UnassessedNumber' => 0);
            $realname = $this->loadModel('user')->getRealNameAndEmails($account);
            $result['realname'] = $realname[$account]->realname;
            $result['account'] = $account;
            foreach ($achievements as $achievement) 
            {
                if($achievement->creatorID != $account) continue;
                $result['TotalNumber'] += 1;

                if($achievement->viewtime != null and $achievement->viewtime != '0000-00-00 00:00:00')
                {
                    $result['AssessedNumber'] += 1;
                }
                else
                {
                    $result['UnassessedNumber'] += 1;
                }
            }

            if(!empty($result))
                $results[] = (object)$result;
        }

        return $results;
    }

    /**
     * get the details.
     * @access public
     * @return void
     */
    public function getDetails($browsetype = 'task', $viewtype = 'student', $orderBy = 'account_asc', $pager = null)
    {
        $this->loadModel('student');
        $this->loadModel('tutor');
        $accounts = array();

        if($browsetype == 'task' or $browsetype == 'problem')
        {
            if ($this->session->userinfo->roleid == 'student')
            {
                if($viewtype == 'student')
                {                 
                    $accounts[] = $this->session->user->account;
                }
                elseif ($viewtype == 'teacher') 
                {
                    $subjects = $this->tutor->getTutorByStudent();
                }
            }
            elseif ($this->session->userinfo->roleid == 'teacher') 
            {
                if($viewtype == 'student')
                {
                    $subjects = $this->student->getAll();
                }
                elseif ($viewtype == 'teacher') 
                {
                    $accounts[] = $this->session->user->account;
                }
            }
            elseif ($this->session->userinfo->roleid == 'manager') 
            {
                if($viewtype == 'student')
                {
                    $subjects = $this->student->getStudentByCollege($this->session->userinfo->collegeid);
                }
                elseif ($viewtype == 'teacher') 
                {
                    $subjects = $this->dao->select('DISTINCT(t1.tea_ID), t2.account')
                                    ->from(TABLE_RELATIONS)->alias(t1)
                                    ->leftJoin(TABLE_USER)->alias(t2)
                                    ->on('t1.tea_ID=t2.account')
                                    ->where('t2.college_id')->eq($this->session->userinfo->collegeid)
                                    ->fetchAll();
                }
            }
            elseif ($this->session->userinfo->roleid == 'counselor') 
            {
                if($viewtype == 'student')
                {
                    $subjects = $this->student->getStudentByCollege($this->session->userinfo->collegeid, '', '', null, 'account', $this->session->user->grade);
                }
                elseif ($viewtype == 'teacher') 
                {
                    $subjects = $this->dao->select('DISTINCT(t1.tea_ID), t2.*')
                                    ->from(TABLE_RELATIONS)->alias(t1)
                                    ->leftJoin(TABLE_USER)->alias(t2)
                                    ->on('t1.tea_ID=t2.account')
                                    ->where('t2.college_id')->eq($this->session->userinfo->collegeid)
                                    ->fetchAll();
                }
            }
            elseif ($this->session->userinfo->roleid == 'admin') 
            {
                if($viewtype == 'student')
                {
                    $subjects = $this->getAllStudents();
                }
                elseif ($viewtype == 'teacher') 
                {
                    $subjects = $this->getAllTeachers();
                }
            }

            if(!empty($subjects))
            {
                foreach ($subjects as $subject)
                {
                   $accounts[] = $subject->account;
                }
            }
        }
        else
        {
            switch ($this->session->userinfo->roleid) 
            {
                case 'student':
                    $accounts[] = $this->session->user->account;
                    break;
                case 'teacher':
                    $subjects = $this->student->getAll($this->session->user->account);
                    break;
                case 'manager':
                    $subjects = $this->student->getStudentByCollege($this->session->userinfo->collegeid);
                    break;
                case 'counselor':
                    $subjects = $this->student->getStudentByCollege($this->session->userinfo->collegeid, '', '', null, 'account', $this->session->user->grade);
                    break;
                case 'admin':
                    $subjects = $this->getAllStudents();
                    break;

                default:
                    $subjects = array();
                    break;
            }
            if(!empty($subjects))
            {
                foreach ($subjects as $subject)
                {
                   $accounts[] = $subject->account;
                }
            }
        }

        switch ($browsetype) 
        {
             case 'task':
                $details = $this->getTaskNumber($accounts,$viewtype);
                break;
             case 'problem':
                $details = $this->getProblemNumber($accounts,$viewtype);
                break;
            case 'project':
                $details = $this->getProjectNumber($accounts);
                break;
            case 'achievement':
                $details = $this->getAchievementNumber($accounts);
                break;
            case 'conclusion':
                $details = $this->getConclusionNumber($accounts);
                break;
             default:
                 $details = array();
                 break;
        }

        $results = $this->getOrderedObject($details,$orderBy);

        if($pager)
            return $this->setPage($results,$pager);
        else
            return $results;
    }

	/**
     * get the statistics.
     * @access public
     * @return void
     */
    public function getStatisticsByList($accounts = 0, $viewtype = 'student', $orderBy = 'account_asc', $pager = null)
    {
        if(!is_array($accounts)) $accounts = (array)$accounts;
        $statistics = array();
        $userpairs      = $this->loadModel('user')->getPairs('noletter');

        if($viewtype == 'student')
    	{
            $TaskNumber = $this->dao->select('acpID AS account, count(distinct id) AS TaskNumber')
                            ->from(TABLE_TASK)
                            ->where('acpID')->in($accounts)
                            ->andWhere('deleted')->eq(0)
                            ->groupBy('acpID')
                            ->fetchAll('account');

            $ProblemNumber = $this->dao->select('asgID AS account, count(distinct id) AS ProblemNumber')
                                ->from(TABLE_QUESTION)
                                ->where('asgID')->in($accounts)
                                ->andWhere('deleted')->eq(0)
                                ->groupBy('asgID')
                                ->fetchAll('account');

            $ProjectNumber = $this->dao->select('creator_ID AS account, count(distinct id) AS ProjectNumber')
                                ->from(TABLE_PROJECT)
                                ->where('creator_ID')->in($accounts)
                                ->andWhere('deleted')->eq(0)
                                ->groupBy('creator_ID')
                                ->fetchAll('account');

            $AchievementNumber = $this->dao->select('creatorID AS account, count(distinct id) AS AchievementNumber')
                                    ->from(TABLE_ACHIEVEMENT)
                                    ->where('creatorID')->in($accounts)
                                    ->andWhere('deleted')->eq(0)
                                    ->andWhere('checked')->eq(1)
                                    ->groupBy('creatorID')
                                    ->fetchAll('account');

            $ConclusionNumber = $this->dao->select('creatorID AS account, count(distinct id) AS ConclusionNumber')
                                    ->from(TABLE_CONCLUSION)
                                    ->where('creatorID')->in($accounts)
                                    ->andWhere('deleted')->eq(0)
                                    ->groupBy('creatorID')
                                    ->fetchAll('account');
        }
        elseif ($viewtype == 'teacher') 
        {
            $TaskNumber = $this->dao->select('asgID AS account, count(distinct id) AS TaskNumber')
                            ->from(TABLE_TASK)
                            ->where('asgID')->in($accounts)
                            ->andWhere('deleted')->eq(0)
                            ->groupBy('asgID')
                            ->fetchAll('account');

            $ProblemNumber = $this->dao->select('acpID AS account, count(distinct id) AS ProblemNumber')
                                ->from(TABLE_QUESTION)
                                ->where('acpID')->in($accounts)
                                ->andWhere('deleted')->eq(0)
                                ->groupBy('acpID')
                                ->fetchAll('account');

            $ProjectNumber = $this->dao->select('tea_ID AS account, count(distinct id) AS ProjectNumber')
                                ->from(TABLE_PROJECT)
                                ->where('tea_ID')->in($accounts)
                                ->andWhere('deleted')->eq(0)
                                ->groupBy('tea_ID')
                                ->fetchAll('account');

            $AchievementNumber = $this->dao->select('teaID AS account, count(distinct id) AS AchievementNumber')
                                    ->from(TABLE_ACHIEVEMENT)
                                    ->where('teaID')->in($accounts)
                                    ->andWhere('deleted')->eq(0)
                                    ->andWhere('checked')->eq(1)
                                    ->groupBy('teaID')
                                    ->fetchAll('account'); 
                                        
            $viewaccounts = $this->dao->select('viewaccounts')
                                    ->from(TABLE_CONCLUSION)
                                    ->where('viewtime')->neqnull()
                                    ->fetchAll();
        }

        foreach ($accounts as $account) 
        {
            /*init the $statistic*/
            $statistic = new stdclass();
            $statistic->account = '';
            $statistic->realname = '';
            $statistic->TaskNumber = 0;
            $statistic->ProblemNumber = 0;
            $statistic->ProjectNumber = 0;
            $statistic->AchievementNumber = 0;
            $statistic->ConclusionNumber = 0;

            $statistic->account = $account;
            $statistic->realname = $userpairs[$account];
            $statistic->TaskNumber = !empty($TaskNumber[$account]->TaskNumber) ? $TaskNumber[$account]->TaskNumber : 0 ;
            $statistic->ProblemNumber = !empty($ProblemNumber[$account]->ProblemNumber) ? $ProblemNumber[$account]->ProblemNumber : 0 ;
            $statistic->ProjectNumber = !empty($ProjectNumber[$account]->ProjectNumber) ? $ProjectNumber[$account]->ProjectNumber : 0 ;
            $statistic->AchievementNumber = !empty($AchievementNumber[$account]->AchievementNumber) ? $AchievementNumber[$account]->AchievementNumber : 0 ;
            $statistic->ConclusionNumber = !empty($ConclusionNumber[$account]->ConclusionNumber) ? $ConclusionNumber[$account]->ConclusionNumber : 0 ;

            $statistics[] = $statistic;
        }

        if(!empty($viewaccounts))
        {
            foreach ($viewaccounts as $viewaccount) 
            {
                foreach ($statistics as $statistic) 
                {
                    if(strstr($viewaccount->viewaccounts, $statistic->account))
                    {
                        $statistic->ConclusionNumber += 1;
                    }
                }
            }
        }
        $statistics = $this->getOrderedObject($statistics,$orderBy);

        return $statistics;
    }

    /**
     * get the statistics.
     * @access public
     * @return void
     */
    public function getStatistics($viewtype = 'student', $orderBy = 'account_asc', $pager = null)
    {
        $this->loadModel('student');
        $this->loadModel('tutor');
        $accounts = array();
        $results = array();

        if ($this->session->user->roleid == 'student')
        {
            if($viewtype == 'student')
            {                
                $results = $this->getStatisticsByList($this->session->user->account,$viewtype,$orderBy,$pager);

                if($pager)
                    return $this->setPage($results,$pager);
                else
                    return $results;
            }
            elseif ($viewtype == 'teacher') 
            {
                $subjects = $this->tutor->getTutorByStudent();
                foreach ($subjects as $subject) 
                {
                    $accounts[] = $subject->account;
                }
                $results = $this->getStatisticsByList($accounts,$viewtype,$orderBy,$pager);

                if($pager)
                    return $this->setPage($results,$pager);
                else
                    return $results;
            }
        }
        elseif ($this->session->user->roleid == 'teacher') 
        {
            if($viewtype == 'student')
            {
                $subjects = $this->student->getAll($this->session->user->account);
            }
            elseif ($viewtype == 'teacher') 
            {
                $accounts[] = $this->session->user->account;
            }
            
            foreach ($subjects as $subject) 
            {
                $accounts[] = $subject->account;
            }
            $results = $this->getStatisticsByList($accounts,$viewtype,$orderBy,$pager);

            if($pager)
                return $this->setPage($results,$pager);
            else
                return $results;
        }
        elseif ($this->session->user->roleid == 'counselor') 
        {
            if($viewtype == 'student')
            {
                $subjects = $this->student->getStudentByCollege($this->session->userinfo->collegeid, '', '', null, 'account', $this->session->user->grade);
            }
            elseif ($viewtype == 'teacher') 
            {
                $subjects = $this->dao->select('DISTINCT(t1.tea_ID), t2.account')
                                    ->from(TABLE_RELATIONS)->alias(t1)
                                    ->leftJoin(TABLE_USER)->alias(t2)
                                    ->on('t1.tea_ID=t2.account')
                                    ->where('t2.college_id')->eq($this->session->userinfo->collegeid)
                                    ->fetchAll();
            }

            foreach ($subjects as $subject) 
            {
                $accounts[] = $subject->account;
            }
            $results = $this->getStatisticsByList($accounts,$viewtype,$orderBy,$pager);

            if($pager)
                return $this->setPage($results,$pager);
            else
                return $results;
        }
        elseif ($this->session->user->roleid == 'manager') 
        {
            if($viewtype == 'student')
            {
                $subjects = $this->student->getStudentByCollege($this->session->userinfo->collegeid, '', '', null);
            }
            elseif ($viewtype == 'teacher') 
            {
                $subjects = $this->dao->select('DISTINCT(t1.tea_ID), t2.account')
                                    ->from(TABLE_RELATIONS)->alias(t1)
                                    ->leftJoin(TABLE_USER)->alias(t2)
                                    ->on('t1.tea_ID=t2.account')
                                    ->where('t2.college_id')->eq($this->session->userinfo->collegeid)
                                    ->fetchAll();
            }
            
            foreach ($subjects as $subject) 
            {
                $accounts[] = $subject->account;
            }
            $results = $this->getStatisticsByList($accounts,$viewtype,$orderBy,$pager);

            if($pager)
                return $this->setPage($results,$pager);
            else
                return $results;
        }
        elseif ($this->session->user->roleid == 'admin') 
        {
            if($viewtype == 'student')
            {
                $subjects = $this->getAllStudents();
            }
            elseif ($viewtype == 'teacher') 
            {
                $subjects = $this->getAllTeachers();
            }
            
            foreach ($subjects as $subject)
            {
               $accounts[] = $subject->account;
            }
            $results = $this->getStatisticsByList($accounts,$viewtype,$orderBy,$pager);

            if($pager)
                return $this->setPage($results,$pager);
            else
                return $results;
        }

        if($pager)
            return $this->setPage($results,$pager);
        else
            return $results;
    }

    /**
     * set the pager.
     * 
     * @param  int      $ID 
     * @access public
     * @return void
     */
    public function setPage($object, $pager)
    {
        if($pager == null)
        {   
            return $object;
        }

        if($pager->recTotal == 0)
        {
            $pager->setrecTotal(count($object));
            $pager->setPageTotal();
        }

        for($i = 0; $i < $pager->recPerPage; $i++)
        {
            if(!empty($object[$i+($pager->pageID-1)*$pager->recPerPage]))
                $results[] = $object[$i+($pager->pageID-1)*$pager->recPerPage];
        }

        return $results;
    }

    /**
     * quicksort.
     * 
     * @param  int      $ID 
     * @access public
     * @return void
     */
    public function getOrderedObject($object, $orderBy)
    {
        if(strrpos($orderBy, '_'))
        {
            $method = substr($orderBy, strrpos($orderBy, '_')+1);
            $order = substr($orderBy, 0, strrpos($orderBy, '_'));
        }
        else
        {
            $order = substr($orderBy, strrpos($orderBy, '_'));
        }
        $method = empty($method) ? 'asc' : $method;
        $oldObject = $object;

        $object = $this->quicksort($object, $order);

        if($method == 'desc')
        {
            for($i = count($object)-1; $i >= 0; $i--)
            {
                $results[] = $object[$i];
            }
        }
        else
            $results = $object;

        return $results;
    }

    /**
     * quicksort.
     * 
     * @param  int      $ID 
     * @access public
     * @return void
     */
    public function quicksort($object, $orderBy)
    {
        if(empty($orderBy)) $orderBy = 'account';
        if(count($object)>1)
        {
            $k=$object[0];
            $x=array();
            $y=array();
            $_size=count($object);

            for($i = 1;$i < $_size;$i++)
            {
                if(is_object($object[$i]))
                {
                    if($orderBy == 'realname')
                    {
                        $object[$i]->$orderBy = iconv('UTF-8', 'GBK//IGNORE',$object[$i]->$orderBy);
                        $k->$orderBy = iconv('UTF-8', 'GBK//IGNORE',$k->$orderBy);
                    }
                    if(strtolower($object[$i]->$orderBy)<strtolower($k->$orderBy))
                    {
                        $x[]=$object[$i];
                    }
                    else
                    {
                        $y[]=$object[$i];
                    }
                    if($orderBy == 'realname')
                    {
                        $object[$i]->$orderBy = iconv('GBK', 'UTF-8//IGNORE',$object[$i]->$orderBy);
                        $k->$orderBy = iconv('GBK', 'UTF-8//IGNORE',$k->$orderBy);
                    }
                }
                else
                {
                    if($orderBy == 'realname')
                    {
                        $object[$i][$orderBy] = iconv('UTF-8', 'GBK//IGNORE',$object[$i][$orderBy]);
                        $k[$orderBy] = iconv('UTF-8', 'GBK//IGNORE',$k[$orderBy]);
                    }
                    if(strtolower($object[$i][$orderBy])<strtolower($k[$orderBy]))
                    {
                        $x[]=$object[$i];
                    }
                    else
                    {
                        $y[]=$object[$i];
                    }
                    if($orderBy == 'realname')
                    {
                        $object[$i][$orderBy] = iconv('GBK', 'UTF-8//IGNORE',$object[$i][$orderBy]);
                        $k[$orderBy] = iconv('GBK', 'UTF-8//IGNORE',$k[$orderBy]);
                    }
                } 
            }

            if(is_array($x)) $x = $this->quicksort($x, $orderBy);
            if(is_array($y)) $y = $this->quicksort($y, $orderBy);

            $k = array(0 => $k);
            return array_merge($x,$k,$y);
        }
        else
        {
            return $object;
        }

    }

        /**
     * get the thesis.
     * 
     * @param  int      $ID 
     * @access public
     * @return void
     */
     public function getThesises($tutors = 'all', $orderBy = 'id_desc', $pager = null)
     {
        $tutors_list = $this->getThesisTutors();
        if(empty($tutors_list)) return $results;

        if($tutors == 'all')
        {
            if($this->session->userinfo->roleid == 'manager' or $this->session->userinfo->roleid == 'admin')
            {
                $accounts = array();
                foreach ($tutors_list as $tutor)
                {
                    $accounts[] = $tutor->account;
                }
            }
            elseif($this->session->userinfo->roleid == 'teacher')
            {
                $accounts = $tutors_list[0]->account;
            }
        }
        else
        {
            $accounts = (array)$tutors;
        }
        if(!empty($accounts))
        {
            $thesises = $this->getThesisesByAccount($accounts,$orderBy,$pager);
            $results = array($tutors_list , $thesises);
        }

        return $results;
     }

    /**
     * get the thesis by account.
     * 
     * @param  int      $ID 
     * @access public
     * @return void
     */
    public function getThesisesByAccount($accounts, $orderBy = 'id_desc', $pager = null)
    {
        if(empty($accounts)) $accounts = $this->session->user->account;

        return $this->dao->select('t1.account, t1.realname, t2.*')
                    ->from(TABLE_USER)->alias(t1)
                    ->leftJoin(TABLE_ACHIEVEMENT)->alias(t2)
                    ->on('t1.account=t2.teaID')
                    ->where('t2.type')->eq('thesis')
                    ->andWhere('t2.teaID')->in($accounts)
                    ->andWhere('t2.deleted')->eq(0)
                    ->orderBy($orderBy)
                    ->page($pager)
                    ->fetchAll();
    }

     /**
     * get the thesis by account.
     * 
     * @param  int      $ID 
     * @access public
     * @return void
     */
    public function getThesisTutors()
    {
        $this->loadModel('tutor');

        switch ($this->session->userinfo->roleid) 
        {
            case 'student':
                $tutors = array();
                break;
            
            case 'teacher':
                $tutors = array(0 => (object)array('account' => $this->session->user->account, 'realname' => $this->session->user->realname));
                break;

            case 'manager':
                $tutors = $this->tutor->getTutorByCollege($this->session->userinfo->collegeid);
                break;

            case 'admin':
                $tutors = $this->getAllTeachers();
                break;

            default:
                break;
        }

        return $tutors;
    }

    /**
     * get all the students.
     * 
     * @param  int      $ID 
     * @access public
     * @return void
     */
    public function getAllStudents()
    {
        return $this->dao->select('account, realname')
                                ->from(TABLE_USER)->alias(t1)
                                ->where('roleid')->eq('student')
                                ->andWhere('deleted')->eq(0)
                                ->andWhere('status')->ne(-1)
                                ->fetchAll();
    }

    /**
     * get all the teahcers.
     * 
     * @param  int      $ID 
     * @access public
     * @return void
     */
    public function getAllTeachers()
    {
        return $this->dao->select('account,realname')
                                ->from(TABLE_USER)->alias(t1)
                                ->where('roleid')->eq('teacher')
                                ->andWhere('deleted')->eq(0)
                                ->andWhere('status')->ne(-1)
                                ->fetchAll();
    }
}
 