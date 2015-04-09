<?php
class tutorModel extends model
{
	/**
     * 学生获取自己的导师
     */
    public function getTutorByStudent($user = '')
    {
        if(!$user) $user = $this->session->user->account;
        $teacher = $this->dao
                    ->select('t2.account, t2.realname, t1.team, t1.team')
                    ->from(TABLE_RELATIONS)->alias(t1)
                    ->leftJoin(TABLE_USER)->alias(t2)
                    ->on('t1.tea_ID=t2.account')
                    ->where('t1.stu_ID')->eq($user)
                    ->andWhere('t1.deleted')->eq(0)
                    ->fetchAll();
        return array_filter($teacher);
    }

    /**
     * 获取特定学院内的所有导师信息
     */
    public function getTutorByCollege($collegeID = '', $name = '', $account = '', $pager = null, $orderBy = '', $paramresearch = '')
    {
        $this->loadModel('statistics');

        if (!$collegeID) $collegeID = $this->session->userinfo->collegeid;
        if (!$orderBy) $orderBy = 'realname_asc';

        $tutors = $this->dao
                    ->select('account, realname, gender, department, email, research, title, college_id')
                    ->from(TABLE_USER)
                    ->where('deleted')->eq(0)
                    ->andWhere('status')->ne(-1)
                    ->andWhere('college_id')->eq($collegeID)
                    ->andWhere('roleid')->eq('teacher') 
                    ->andWhere('realname')->like('%' . $name . '%')
                    ->andWhere('account')->like('%' . $account . '%')
                    ->beginIF($paramresearch != '')->andWhere('research')->like('%' . $paramresearch . '%')->fi()
                    //->beginIF(strpos($orderBy, 'realname') === false)->orderBy($orderBy)->page($pager)->fi()         
                    ->fetchAll();

        $tutors = $this->statistics->getOrderedObject($tutors, $orderBy);
        $tutors = $this->statistics->setPage($tutors, $pager);

        return $tutors;
    }

    public function getGroupFile($orderBy = '', $pager = null, $paramtitle = '', $paramcreator = '')
    {
        if (!$orderBy) $orderBy = 'id_desc';
        if ($paramcreator != '') $paramcreator = $this->loadModel('user')->getAccountByName($paramcreator);

        $cur_account = $this->session->user->account;

        $members = $this->loadModel('common')->getTeamByStudent($cur_account);
        $lists = implode(',', array_keys($members)) . ',' . $cur_account;

        $teachers = $this->getTutorByStudent($cur_account);
        foreach ($teachers as $teacher) 
        {
            $lists .= ',' . $teacher->account;
        }

        $files = $this->dao->select('*')
                ->from(TABLE_FILE)
                ->where('addedBy')->in($lists)
                ->andWhere('acl')->in('2,3')
                ->andWhere('deleted')->eq(0)
                ->beginIF($paramtitle != '')->andWhere('title')->like('%' . $paramtitle . '%')->fi()
                ->beginIF($paramcreator != '')->andWhere('addedBy')->in($paramcreator)->fi()
                ->orderBy($orderBy)
                ->page($pager)
                ->fetchAll();
        return $files;
    }
}    
