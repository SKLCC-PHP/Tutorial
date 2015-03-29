<?php
class studentModel extends model
{
	/**
     * 老师获取自己名下的学生
     */
    public function getStudents($account = 0, $orderBy = '', $pager = null, $status = null, $education = null, $grades = '', $paramaccount = '', $paramname = '')
    {
        if (!$account) $account = $this->session->user->account;
        if (!$education) $education = 'all';
        if (!$status) $status = array(1, 0);
        if (!$orderBy) $orderBy = 'account';
        
        if ($this->session->user->roleid == 'counselor')
        {
            return $this->dao->select('t2.stu_ID, t2.team, t1.account, t1.realname, t1.avatar, t1.gender, t1.email, t1.qq, t1.mobile, t1.phone, t1.`join`, t1.department, t1.specialty, t1.polical_status, t1.title, t1.education, t1.status, t1.deleted, t3.college_name')
                    ->from(TABLE_USER)->alias(t1) 
                    ->leftJoin(TABLE_RELATIONS)->alias(t2)
                    ->on('t1.account=t2.stu_ID')
                    ->leftJoin(TABLE_COLLEGE)->alias(t3)
                    ->on('t3.college_id=t1.college_id')
                    ->where('t2.tea_ID')->eq($account)
                    ->andWhere('t1.status')->in($status)
                    ->andWhere('t1.deleted')->eq(0)
                    ->andWhere('t2.deleted')->eq(0)
                    ->andWhere('t3.status')->eq(1)
                    ->beginIF($grades != '')->andWhere('t1.grade')->in($grades)->fi()
                    ->beginIF($paramaccount != '')->andWhere('t1.account')->like('%' . $paramaccount . '%')->fi()
                    ->beginIF($paramname != '')->andWhere('t1.realname')->like('%' . $paramname . '%')->fi()
                    ->orderBy($orderBy)
                    ->page($pager)
                    ->fetchAll();
        }
        if (($this->session->userinfo->roleid == 'manager') || ($education == 'all'))
        {
            return $this->dao->select('t2.stu_ID, t2.team, t1.account, t1.realname, t1.avatar, t1.gender, t1.email, t1.qq, t1.mobile, t1.phone, t1.`join`, t1.department, t1.specialty, t1.polical_status, t1.title, t1.education, t1.status, t1.deleted, t3.college_name')
                    ->from(TABLE_USER)->alias(t1) 
                    ->leftJoin(TABLE_RELATIONS)->alias(t2)
                    ->on('t1.account=t2.stu_ID')
                    ->leftJoin(TABLE_COLLEGE)->alias(t3)
                    ->on('t3.college_id=t1.college_id')
                    ->where('t2.tea_ID')->eq($account)
                    ->andWhere('t1.status')->in($status)
                    ->andWhere('t1.deleted')->eq(0)
                    ->andWhere('t2.deleted')->eq(0)
                    ->andWhere('t3.status')->eq(1)
                    ->beginIF($paramaccount != '')->andWhere('t1.account')->like('%' . $paramaccount . '%')->fi()
                    ->beginIF($paramname != '')->andWhere('t1.realname')->like('%' . $paramname . '%')->fi()
                    ->orderBy($orderBy)
                    ->page($pager)
                    ->fetchAll();
        }

        $students = $this->dao->select('t2.stu_ID, t2.team, t1.account, t1.realname, t1.avatar, t1.gender, t1.email, t1.qq, t1.mobile, t1.phone, t1.`join`, t1.department, t1.specialty, t1.polical_status, t1.title, t1.education, t1.status, t1.deleted, t3.college_name')
                    ->from(TABLE_USER)->alias(t1) 
                    ->leftJoin(TABLE_RELATIONS)->alias(t2)
                    ->on('t1.account=t2.stu_ID')
                    ->leftJoin(TABLE_COLLEGE)->alias(t3)
                    ->on('t3.college_id=t1.college_id')
                    ->where('t2.tea_ID')->eq($account)
                    ->andWhere('t2.stu_ID')->like($education)
                    ->andWhere('t1.status')->in($status)
                    ->andWhere('t1.deleted')->eq(0)
                    ->andWhere('t2.deleted')->eq(0)
                    ->andWhere('t3.status')->eq(1)
                    ->beginIF($paramaccount != '')->andWhere('t1.account')->like('%' . $paramaccount . '%')->fi()
                    ->beginIF($paramname != '')->andWhere('t1.realname')->like('%' . $paramname . '%')->fi()
                    ->orderBy($orderBy)
                    ->page($pager)
                    ->fetchAll();
        return $students;
    }
    public function getAll($account = '', $orderBy, $pager, $paramaccount = '', $paramname = '')
    {
        if (!$account) $account = $this->session->user->account;
        return $this->getStudents($account, $orderBy, $pager, array(1,0), 'all', '', $paramaccount, $paramname);
    }
    /**
     * 获取本科生列表
     */
    public function getUnderGraduate($account = '', $orderBy, $pager, $paramaccount = '', $paramname = '')
    {    
        if (!$account)  $account = $this->session->user->account;
        return $this->getStudents($account, $orderBy, $pager, array(1, 0), $this->lang->student->studentList[0], '', $paramaccount, $paramname);     
    }

    /**
     * 获取研究生列表
     */
    public function getpostgraduate($account = '', $orderBy, $pager, $paramaccount = '', $paramname = '')
    {      
        if (!$account) $account = $this->session->user->account;
        return $this->getStudents($account, $orderBy, $pager, array(1, 0), $this->lang->student->studentList[1], '', $paramaccount, $paramname);
    }

    /**
     * 获取毕业生列表
     */
    public function getgraduate($account = '', $orderBy, $pager, $paramaccount = '', $paramname = '')
    {
        if (!$account) $account = $this->session->user->account;

        return $this->getStudents($account, $orderBy, $pager, -1, null, '', $paramaccount, $paramname);
    }

    /**
     * 根据学院id获取所有学生
     */
    public function getStudentByCollege($collegeID = '', $name = '', $account = '', $pager = null, $orderBy = 'account', $grades = '')
    {
        if (!$collegeID) $collegeID = $this->session->user->college_id;
        return $this->dao
                   ->select('account, realname, gender, specialty, education')
                   ->from(TABLE_USER)
                   ->where('deleted')->eq(0)
                   ->andWhere('status')->ne(-1)
                   ->andWhere('college_id')->eq($collegeID)
                   ->andWhere('roleid')->eq('student')
                   ->beginIF($grades != '')->andWhere('grade')->in($grades)->fi()
                   ->andWhere('realname')->like('%' . $name . '%')
                   ->andWhere('account')->like('%' . $account . '%')
                   ->orderBy($orderBy)
                   ->page($pager)
                   ->fetchAll();     
    }
}    
