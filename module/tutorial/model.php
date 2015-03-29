<?php
class tutorialModel extends model
{
    public function saveStudents($tutoraccount, $students, $relation)
    {  	
        $time = date("Y-m-d H:i:s");
        $d_data['deleted'] = 1;
        $d_data['updatetime'] = $time;
        $this->dao->update(TABLE_RELATIONS)
        	->data($d_data)
            ->where('tea_ID')->eq($tutoraccount)
            ->andWhere('deleted')->eq(0)
            ->exec();
       
        foreach ($students as $key => $student) 
        {
        	if (!$student) continue;
        	$c_data['createtime'] = $time;
            $c_data['updatetime'] = $time;
            $c_data['tea_ID'] = $tutoraccount;
            $c_data['stu_ID'] = $student;
            $c_data['team'] = implode('|', $relation[$key]);
            $this->dao->insert(TABLE_RELATIONS)
                ->data($c_data)
                ->exec();
        }
        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }   
    }

    public function saveTeachers($studentaccount, $teachers, $relation)
    {
        $time = date("Y-m-d H:i:s");
        $d_data['deleted'] = 1;
        $d_data['updatetime'] = $time;

        $this->dao->update(TABLE_RELATIONS)
            ->data($d_data)
            ->where('stu_ID')->eq($studentaccount)
            ->andWhere('deleted')->eq(0)
            ->exec();

        foreach ($teachers as $key => $teacher) 
        {
            if (!$teacher) continue;
            $c_data['createtime'] = $time;
            $c_data['updatetime'] = $time;
            $c_data['tea_ID'] = $teacher;
            $c_data['stu_ID'] = $studentaccount;
            $c_data['team'] = implode('|', $relation[$key]);

            $this->dao->insert(TABLE_RELATIONS)
                ->data($c_data)
                ->exec();
        }

        if (dao::isError())
        {
            die(js::error(dao::getError()));
        }
    }

    public function getList($role, $collegeID = '', $grade = '')
    {
        if (!$collegeID) $collegeID = $this->session->user->college_id;

        $members = $this->dao->select('account, realname')
                        ->from(TABLE_USER)
                        ->where('deleted')->eq(0)
                        ->andWhere('status')->ne(-1)
                        ->andWhere('college_id')->eq($collegeID)
                        ->andWhere('roleid')->eq($role)
                        ->beginIF($grade != '')->andWhere('grade')->in($grade)->fi()
                        ->orderby('account')
                        ->fetchAll();
        $memberList = array('' => '');

        foreach ($members as $key => $member) 
        {
            $memberList[$member->account] = $member->account . "(" . $member->realname . ")";
        }

        return $memberList;
    }

    public function isGuidance($teaID, $stuID)
    {
        $relation = $this->dao->select('team')
                    ->from(TABLE_RELATIONS)
                    ->where('tea_ID')->eq($teaID)
                    ->andWhere('stu_ID')->eq($stuID)
                    ->andWhere('deleted')->eq(0)
                    ->fetch()->team;
        if (strstr($relation, 'G'))
            return 1;
        else
            return 0;
    }

    public function tsRelation($teaID, $stuID){
        $relation = $this->dao->select('team')
                    ->from(TABLE_RELATIONS)
                    ->where('tea_ID')->eq($teaID)
                    ->andWhere('stu_ID')->eq($stuID)
                    ->andWhere('deleted')->eq(0)
                    ->fetch()->team;
        return $relation;
    }
}    
