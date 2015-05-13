<?php
class taskModel extends model
{

	/**
	 * Create a task.
	 * 
	 * @access public
	 * @return void
	 */
	public function create()
	{
		$tasksID = array();
		$taskFile = '';
		$now = helper::now();

		$assignedToList = $this->post->assignedTo;        

		foreach ($assignedToList as $assignedTo) 
		{
			if (!$assignedTo) continue;
			$task = fixer::input('post')
				->striptags('title')
				->setForce('acpID',  $assignedTo)
				->setDefault('asgID',   $this->app->user->account)
				->add('createtime', $now)
				->remove('files,labels,assignedTo, days')
				->get();

			/*chang date to datetime*/
			if($task->deadline and $task->deadline !='0000-00-00 00:00:00')
			{
				$task->deadline .= ' 23:59:59';
				$task->begintime .= ' '. date('H:i:s');
			}

			$this->dao->insert(TABLE_TASK)->data($task)
				->autoCheck()
				->batchCheck($this->config->task->create->requiredFields, 'notempty')
				->exec();

			if(!dao::isError())
			{   
				$taskID = $this->dao->lastInsertID();
				$this->loadModel('file')->saveUpload('task', $taskID, '', $task->acl);
			}
			else
			{
				echo js::error(dao::getError());
            	die(js::locate($this->server->http_referer, 'parent'));
			}

			/*send mail to inform the receiver*/
			$subject = $this->lang->task->mail->subject;
			$body = sprintf($this->lang->task->mail->body, $this->app->user->realname, common::getSysURL().helper::createLink('task', 'view', "taskID=".$taskID));
			$this->loadModel('mail')->send($assignedTo, $subject, $body, '', true);
			$this->loadModel('action')->create('task', $taskID, 'created');
		}
	}

	/**
	 * Update a task.
	 * 
	 * @param  int    $taskID 
	 * @access public
	 * @return void
	 */
	public function update($taskID)
	{      
		$time = date('Y-m-d H:i:s');
		$task = fixer::input('post')
			->striptags('title')
			->add('updatetime', $time)
			->remove('files,labels,days,assignedTo')
			->get();

		if($task->deadline and $task->deadline !='0000-00-00 00:00:00')
		{
			$task->deadline .= ' 23:59:59';
			$task->begintime .= ' '. date('H:i:s');
		}

		$this->dao->update(TABLE_TASK)->data($task)
			->autoCheck()
			->batchCheckIF($this->config->task->edit->requiredFields, 'notempty')
			->where('id')->eq((int)$taskID)->exec();
        if(!dao::isError())
		{   
		    $this->dao->update(TABLE_FILE)->set('acl')->eq($task->ACL)->where('objectType')->eq('task')->andWhere('objectID')->eq($taskID)->andWhere('deleted')->eq(0)->exec();
			$this->loadModel('file')->saveUpload('task', $taskID, '', $task->ACL);

			$editsubject = $this->lang->task->mail->editsubject;
			$editbody = sprintf($this->lang->task->mail->editbody, $this->app->user->realname, common::getSysURL().helper::createLink('task', 'view', "taskID=".$taskID));
			$this->loadModel('mail')->send($this->post->assignedTo, $editsubject, $editbody, '', true);
		}
		else
		{
			echo js::error(dao::getError());
            die(js::locate($this->server->http_referer, 'parent'));
		}
	}

    public function checkSubmit($taskID, $type = 'submit')
    {
    	foreach ($_FILES['files']['error'] as $error) 
    	{
    		if ($error == 0)
    		{
    			$this->$type($taskID);
    			return;
    		}
    	}

    	if (fixer::input('post')->get()->submitcontent == null)
    	{
    		echo js::alert($this->lang->task->nosubmit);

    		if ($type == 'submit')
                die(js::locate(helper::createLink('task', 'submit', "taskID=$taskID"), 'parent'));
    	    else
    	    	die(js::closeModel('parent.parent', 'this'));
    	}
    	else
    	{
    		$this->$type($taskID);
    	}
    }
	/**
	 * Submit a task.
	 * 
	 * @param  int      $taskID 
	 * @access public
	 * @return void
	 */
	public function submit($taskID)
	{   
		/*update the task*/
		$task = fixer::input('post')
			->add('submittime', date('Y-m-d H:i:s'))
			->remove('labels, files')
			->get();

		$this->dao->update(TABLE_TASK)
			->data($task)
			->where('id')->eq($taskID)
			->exec();

		/*set the upload file*/
		if(!dao::isError())
		{
			$this->loadModel('file')->saveUpload('submittask', $taskID);
			$old_Task = $this->getById($taskID);

			$subsubject = $this->lang->task->mail->subsubject;
			$subbody = sprintf($this->lang->task->mail->subbody, $this->app->user->realname, common::getSysURL().helper::createLink('task', 'view', "taskID=".$old_Task->id));
			$this->loadModel('mail')->send($old_Task->asgID, $subsubject, $subbody, '', true);
			return common::createChanges($old_Task, $task);
		}
		else
		{
			die(js::error(dao::getError()));
		}
	}

	public function editsubmit($taskID)
	{
		$task = fixer::input('post')
			->add('submittime', date('Y-m-d H:i:s'))
			->remove('labels,files')
			->get();
		$this->dao->update(TABLE_TASK)
			->data($task)
			->where('id')->eq($taskID)
			->exec();

		/*set the upload file*/
		if(!dao::isError())
		{
			$this->loadModel('file')->saveUpload('submittask', $taskID);
			$old_Task = $this->getById($taskID);

			$editsubsubject = $this->lang->task->mail->editsubsubject;
			$editsubbody = sprintf($this->lang->task->mail->editsubbody, $this->app->user->realname, common::getSysURL().helper::createLink('task', 'view', "taskID=".$old_Task->id));
			$this->loadModel('mail')->send($old_Task->asgID, $editsubsubject, $editsubbody, '', true);
		}
		else
		{
			die(js::error(dao::getError()));
		}
	}

	/**
	 * delete a task.
	 * 
	 * @param  int    $taskID 
	 * @access public
	 * @return void
	 */
	public function delete($taskID)
	{
		$now     = helper::now();

		$task = $this->getById($taskID);
		
		$this->deleteComment($taskID,'T');
		$this->dao->update(TABLE_TASK)
				->set('deleted')->eq(1)
				->where('id')->eq((int)$taskID)->exec(); 
        $this->dao->update(TABLE_FILE)->set('deleted')->eq(1)->where('objectType')->eq('task')->andWhere('objectID')->eq($taskID)->andWhere('deleted')->eq(0)->exec();
	    if (dao::isError())
	    {
	    	die(js::error(dao::getError()));
	    }
	}

    public function deleteGroup($taskID)
    {
    	$now = helper::now();

        $createtime = $this->dao->select('createtime')->from(TABLE_TASK)
    	                ->where('id')->eq($taskID)->fetch()->createtime;print_r($createtime);
    	$tasks = $this->dao->select('id')->from(TABLE_TASK)
    	        ->where('createtime')->eq($createtime)
    	        ->andWhere('deleted')->eq(0)
    	        ->fetchAll();
    	foreach ($tasks as $task) {
    		$this->delete($task->id);
    		$this->loadModel('action')->create('task', $taskID, 'deleted');
    	}
    }
	/**
	 * finish a task.
	 * 
	 * @param  int    $taskID 
	 * @access public
	 * @return void
	 */
	public function finish($taskID)
	{
		$now     = helper::now();
	
		$this->dao->update(TABLE_TASK)
			->set('completetime')->eq($now)
			->where('id')->eq((int)$taskID)
			->exec();

		if (dao::isError())
	    {
	    	die(js::error(dao::getError()));
	    }
	}

	/**
	 * Set the begin of the task
	 * 
	 * @param  int    $taskID 
	 * @access public
	 * @return void
	 */
	public function setBeginning($taskID)
	{
		$now     = helper::now();
		
		$task = $this->getById($taskID);

		if(!$task->begintime or $task->begintime == '0000-00-00 00:00:00')                   
			$this->dao->update(TABLE_TASK)
				->set('begintime')->eq($now)
				->where('id')->eq((int)$taskID)
				->exec();

		if (dao::isError())
	    {
	    	die(js::error(dao::getError()));
	    }
	}

	/**
	 * Get task info by Id.
	 * 
	 * @param  int    $taskID 
	 * @param  bool   $setImgSize
	 * @access public
	 * @return object|bool
	 */
	public function getById($taskID, $is_onlybody = 'no', $setImgSize = true)
	{
		if(strtolower($is_onlybody) == 'yes')
            $imgsize = 300;
        else
            $imgsize = 800;

		$task = $this->dao->select('*')
			->from(TABLE_TASK)
			->where('id')->eq((int)$taskID)
			->andWhere('deleted')->eq(0)
			->fetch();
		if(!$task) return false;
		if($setImgSize) 
			{
				$task->content = $this->loadModel('file')->setImgSize($task->content,$imgsize);
				$task->submitcontent = $this->loadModel('file')->setImgSize($task->submitcontent,$imgsize);
			}
		$task->files = $this->loadModel('file')->getByObject('task', $taskID);
		$task->submitfiles = $this->loadModel('file')->getByObject('submittask', $taskID);
		
		return $task;
	}

    public function getTasksByID($taskid, $is_onlybody = 'no')
    {
    	$createtime = $this->dao->select('createtime')->from(TABLE_TASK)
    	                ->where('id')->eq($taskid)->fetch()->createtime;
    	$tasks = $this->dao->select('*')->from(TABLE_TASK)
    	        ->where('createtime')->eq($createtime)
    	        ->andWhere('deleted')->eq(0)
    	        ->fetchAll();
    	if(!$tasks) return false;
    	if(strtolower($is_onlybody) == 'yes')
            $imgsize = 300;
        else
            $imgsize = 800;

		if($setImgSize) 
		{
			$tasks[$taskid]->content = $this->loadModel('file')->setImgSize($tasks[$taskid]->content,$imgsize);
			$tasks[$taskid]->submitcontent = $this->loadModel('file')->setImgSize($tasks[$taskid]->submitcontent,$imgsize);
		}
		$tasks[$taskid]->files = $this->loadModel('file')->getByObject('task', $taskid);
		$tasks[$taskid]->submitfiles = $this->loadModel('file')->getByObject('submittask', $taskid);
		
		return $tasks;
    }
	/**
	 * Get task list.
	 * 
	 * @param  int|array|string    $taskIDList 
	 * @access public
	 * @return array
	 */
	public function getByList($taskIDList = 0)
	{
		return $this->dao->select('*')->from(TABLE_TASK)
			->where('deleted')->eq(0)
			->beginIF($taskIDList)->andWhere('id')->in($taskIDList)->fi()
			->fetchAll('id');
	}

	/**
	 * get the members of the team.
	 * 
	 * @access public
	 * @return void
	 */
	public function getTeamMembers($account = '', $paramaccount = '', $paramname = '')
	{
		if(!$account) $account = $this->app->user->account;
		return $this->dao->select('t2.*, t1.team')
		            ->from(TABLE_RELATIONS)->alias(t1)
		            ->leftJoin(TABLE_USER)->alias(t2)
		            ->on('t1.stu_ID=t2.account')
		            ->where('t1.tea_ID')->eq($account)
		            ->andWhere('t1.deleted')->eq(0)
		            ->andWhere('t2.deleted')->eq(0)
		            ->andWhere('t2.status')->eq(1)
		            ->beginIF($paramname != '')->andWhere('t2.realname')->like('%' . $paramname . '%')->fi()
		            ->beginIF($paramaccount != '')->andWhere('t1.stu_ID')->like('%' . $paramaccount . '%')->fi()
		            ->fetchAll();
	}

	/**
	 * Batch process tasks.
	 * 
	 * @param  int    $tasks 
	 * @access private
	 * @return void
	 */
	public function processTasks($tasks)
	{
		foreach($tasks as $task)
		{
			$task = $this->processTask($task);
		}
		return $tasks;
	}

	/**
	 * Process a task, judge it's status.
	 * 
	 * @param  object    $task 
	 * @access private
	 * @return object
	 */
	public function processTask($task)
	{
		$today = helper::today();
	   
		/* Delayed or not?. */
		if($task->completetime == NULL or $task->completetime == '0000-00-00 00:00:00')
		{
			$task->is_completed = 'undone';
			if($task->deadline != '0000-00-00')
			{
				$delay = helper::diffDate($today, $task->deadline);
				if($delay > 0) 
				{
					$task->delay = $delay;   
				}         
			}
		}
		else
		{
			$task->is_completed = 'done';
		}

		if($task->assesstime == NULL or $task->assesstime == '0000-00-00 00:00:00')
		{
			$task->is_assessed = 'unassessed';
		}
		else
		{
			$task->is_assessed = 'assessed';
		}

		return $task;
	}

	/**
	 * Get tasks of a user.
	 * 
	 * @param  string $account 
	 * @param  string $type     the query type 
	 * @param  int    $limit   
	 * @param  object $pager   
	 * @access public
	 * @return array
	 */
	public function getTasks($viewtype = '', $account = 0, $pager = null, $orderBy="id_desc", $paramtitle = '', $paramstu = '', $paramtea = '')
	{
		$cur_role = $this->session->userinfo->roleid;
		if ($cur_role == 'student') $field = 'acpID';
		else  $field = 'asgID';
		if (!$account)   $account = $this->session->user->account;
		if (!$viewtype)  $viewtype = 'all';
		$paramtea = $this->loadModel('user')->getAccountByName($paramtea);
		$paramstu = $this->loadModel('user')->getAccountByName($paramstu);

        if ($this->session->userinfo->roleid == 'admin')
        {
            $tasks = $this->dao->select('*')
		                ->from (TABLE_TASK)
		                ->where('ACL')->eq(3)
		                ->andWhere('deleted')->eq(0)
		                ->andWhere('title')->like('%' . $paramtitle . '%')
		                ->andWhere('asgID')->in($paramtea)
		                ->andWhere('acpID')->in($paramstu)
		                ->orderBy($orderBy)
		                ->page($pager)
		                ->fetchAll();   

		    $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'task');

		    return $tasks;
        }

		if ($cur_role != 'student' && $cur_role != 'teacher')
		{
			$grade = $this->session->user->grade;
			$tasks = $this->dao->select('t1.asgID,count(t1.acpID) as acpNum,t1.title,t1.createtime,t1.deadline,t1.begintime,t1.ACL,t1.id')
					->from(TABLE_TASK)->alias(t1)
					->leftJoin(TABLE_USER)->alias(t2)
					->on('t1.acpID=t2.account')
					->where('t1.ACL')->eq(3)
					->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
					->andwhere('t1.deleted')->eq(0)
					->andWhere('t1.title')->like('%' . $paramtitle . '%')
		            ->beginIF($grade != '')->andWhere('t2.grade')->in($grade)->fi()
		            ->groupBy('t1.createtime')
					->orderBy('t1.' . $orderBy)
					->fetchAll();

			$this->loadModel('common')->saveQueryCondition($this->dao->get(), 'task');
			return $tasks = $this->loadModel('statistics')->setPage($tasks, $pager);;
		}
		
		if ($viewtype == 'all')
		{
			if ($cur_role == 'teacher')
			{
				$tasks = $this->dao->select('asgID,count(acpID) as acpNum,title,createtime,deadline,begintime,id')
						->from(TABLE_TASK)
						->where($field)->eq($account)
						->andwhere('deleted')->eq(0)
						->andWhere('title')->like('%' . $paramtitle . '%')
		                ->andWhere('asgID')->in($paramtea)
		                ->groupBy('createtime')
						->orderBy($orderBy)
						->fetchAll();
						$tasks = $this->loadModel('statistics')->setPage($tasks, $pager);
			}
			else
			{
				$tasks = $this->dao->select('*')
						->from(TABLE_TASK)
						->where($field)->eq($account)
						->andwhere('deleted')->eq(0)
						->andWhere('title')->like('%' . $paramtitle . '%')
		                ->andWhere('asgID')->in($paramtea)
						->orderBy($orderBy)
						->page($pager)
						->fetchAll();
			}
			
		}

		if ($viewtype == 'undone')
		{
			$tasks = $this->dao->select('*')
						->from(TABLE_TASK)
						->where($field)->eq($account)
						->andWhere('deleted')->eq(0)
						->andWhere('completetime')->eqnull()
						->andWhere('title')->like('%' . $paramtitle . '%')
		                ->andWhere('asgID')->in($paramtea)
		                ->andWhere('acpID')->in($paramstu)
						->orderBy($orderBy)
						->page($pager)
						->fetchAll();
		}

		if ($viewtype == 'done')
		{
			$tasks = $this->dao->select('*')
						->from(TABLE_TASK)
						->where($field)->eq($account)
						->andWhere('deleted')->eq(0)
						->andWhere('completetime')->neqnull()
						->andWhere('title')->like('%' . $paramtitle . '%')
		                ->andWhere('asgID')->in($paramtea)
		                ->andWhere('acpID')->in($paramstu)
						->orderBy($orderBy)
						->page($pager)
						->fetchAll();
		}

		if ($viewtype == 'unassessed')
		{
			$tasks = $this->dao->select('*')
						->from(TABLE_TASK)
						->where('asgID')->eq($account)
						->andWhere('deleted')->eq(0)
						->andWhere('assesstime')->eqnull()
						->andWhere('title')->like('%' . $paramtitle . '%')
		                ->andWhere('asgID')->in($paramtea)
		                ->andWhere('acpID')->in($paramstu)
						->orderBy($orderBy)
						->page($pager)
						->fetchAll();
		}

		if ($viewtype == 'assessed')
		{
			$tasks = $this->dao->select('*')
						->from(TABLE_TASK)
						->where('asgID')->eq($account)
						->andWhere('deleted')->eq(0)
						->andWhere('assesstime')->neqnull()
						->andWhere('title')->like('%' . $paramtitle . '%')
		                ->andWhere('asgID')->in($paramtea)
		                ->andWhere('acpID')->in($paramstu)
						->orderBy($orderBy)
						->page($pager)
						->fetchAll();
		}
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'task');
      
		return $tasks;
	}

	 /**
	 * set the list of a user's task.
	 * 
	 * @param  string $account 
	 * @access public
	 * @return array
	 */
	public function setTaskList($roleid = '', $account = '')
	{	
		if (!$roleid)  
		{
			if (!$account)   $account = $this->session->user->account;
			$roleid = $this->dao->select('roleid')->from(TABLE_USER)->where('account')->eq($account)->fetch()->roleid;
        }

	    switch ($roleid)
	    {
	    	case 'student':
	    	    return array('all', 'undone', 'done');
	    	    break;
	    	case 'teacher':
	    	    return array('all', 'undone', 'done', 'unassessed', 'assessed');
	    	    break;
	    	default:
	    	    return array('all');
	    }
	}
	/**
	 * save a comment.
	 * 
	 * @param  int      $ID 
	 * @access public
	 * @return void
	 */
	public function saveComment($object, $ID, $type)
	{
		/*insert a comment*/
		$now  = helper::now();

		$comment = new stdclass();
		$comment->content = $object->comment;
		$comment->pid     = $ID;
		$comment->com_ID  = $this->app->user->account;
		$comment->create_time = $now;
		$comment->type = $type;

		if($comment->content)
			$this->dao->insert(TABLE_COMMENT)->data($comment)
				->autoCheck()
				->exec();

		if (dao::isError())
	    {
	    	die(js::error(dao::getError()));
	    }
	}

	/**
	 * delete a comment.
	 * 
	 * @param  int    $taskID 
	 * @access public
	 * @return void
	 */
	public function deleteComment($ID, $type)
	{
		$this->dao->update(TABLE_COMMENT)
				->set('deleted')->eq(1)
				->where('pid')->eq($ID)
				->andWhere('type')->eq($type)
				->exec();   

		if (dao::isError())
	    {
	    	die(js::error(dao::getError()));
	    } 
	}

	/**
	 * get the comments of a $type(task，question，conclusion).
	 * 
	 * @param  int      $ID 
	 * @access public
	 * @return void
	 */
	public function getComments($objecttype, $ID, $setImgSize = true)
	{
		$type = $this->lang->commentList[$objecttype];
		$comments = $this->dao->select('*')->from(TABLE_COMMENT)
						->where('pid')->eq($ID)
						->andWhere('type')->eq($type)
						->andWhere('deleted')->eq(0)
						->fetchAll();

		$userpairs = $this->loadModel('user')->getPairs('noletter');
		
		foreach ($comments as $comment) 
		{
			$comment->realname = $userpairs[$comment->com_ID];
			if($setImgSize) $comment->content = $this->loadModel('file')->setImgSize($comment->content, 300);
		}

		if($comments) return $comments;

		return array();
	}

	/**
	 * make a comment.
	 * 
	 * @param  int      $ID 
	 * @access public
	 * @return void
	 */
	public function makeComment($ID, $type)
	{
		$object = fixer::input('post')
			->get();
		if($type == 'Q')
		{
			$this->loadModel('problem');
			$answersubject = $this->lang->problem->mail->answersubject;
            $answerbody = sprintf($this->lang->problem->mail->answerbody, $this->app->user->realname, common::getSysURL().helper::createLink('problem', 'view', "problemID=".$taskID));
            $this->loadModel('mail')->send($teacher, $answersubject, $answerbody, '', true);
		}
		$this->saveComment($object, $ID, $type);
	}

	public function saveRead($task)
	{
		$data = new stdclass();
		$cur_account = $this->session->user->account;
		if (($cur_account == $task->acpID) && (($task->readtime == null) || ($task->readtime == '0000-00-00 00:00:00')))
		{
			$data->readtime = date('Y-m-d H:i:s');
		}
		$data->readtimes = $task->readtimes + 1;
		$this->dao->update(TABLE_TASK)->data($data)
			->where('id')->eq($task->id)
			->exec();

		if (dao::isError())
	    {
	    	die(js::error(dao::getError()));
	    }
	}

	public function getOtherTask($account, $orderBy = '', $pager = null, $field = '')
	{
		$cur_account = $this->session->user->account;
		$cur_role = $this->session->userinfo->roleid;
        if (!$orderBy) $orderBy = 'id_desc';
        if (!$field) $field = 'acpID';

        if ($cur_role == 'admin')
        {  
            return $this->dao->select('*')
			            ->from(TABLE_TASK)
			            ->where('ACL')->eq(3)
			            ->andWhere('deleted')->eq(0)
			            ->andWhere($field)->eq($account)
			            ->orderBy($orderBy)
			            ->page($pager)
			            ->fetchAll();
        }
        
        if (($cur_role != 'student') && ($cur_role != 'teacher'))
        {   
        	return $this->dao->select('t1.*')
        	            ->from(TABLE_TASK)->alias(t1)
        	            ->leftJoin(TABLE_USER)->alias(t2)
        	            ->on('t1.'.$field.'=t2.account')
        	            ->where('t1.'.$field)->eq($account)
        	            ->andWhere('t1.ACL')->eq(3)
        	            ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
        	            ->andWhere('t1.deleted')->eq(0)
        	            ->orderBy($orderBy)
        	            ->page($pager)
        	            ->fetchAll();
        }

		if ($this->loadModel('project')->checkRelation($cur_account, $account))
		{  
			return $this->dao->select('*')
			            ->from(TABLE_TASK)
			            ->where('ACL')->in('2, 3')
			            ->andWhere('deleted')->eq(0)
			            ->andWhere($field)->eq($account)
			            ->orderBy($orderBy)
			            ->page($pager)
			            ->fetchAll();
		}
		else
		{   
			return $this->dao->select('*')
			            ->from(TABLE_TASK)
			            ->where('ACL')->eq(3)
			            ->andWhere('deleted')->eq(0)
			            ->andWhere($field)->eq($account)
			            ->orderBy($orderBy)
			            ->page($pager)
			            ->fetchAll();
		}
	}

    /**
     * chech the authority of the method to different roles
     * @may
     */
    public function checkPriv($task, $method)
    {
    	$cur_role = $this->session->user->roleid;

    	switch ($cur_role)
    	{
		case 'student':
			return $this->checkStudentPriv($task, $method);
		    break;
		case 'teacher':
			return $this->checkTeacherPriv($task, $method);
			break;
		case 'counselor':
			return $this->checkCouncelorPriv($task, $method);
			break;
		case 'manager':
			return $this->checkManagerPriv($task, $method);
			break;
		default: return 1;
    	}   		
    }

    public function checkStudentPriv($task, $method)
    {
    	$cur_account = $this->session->user->account;
    	$curtime = helper::now();
    	switch ($method)
    	{
    		case 'view':{
    			if ($task->deleted == 1) return 0; 
    			if ($task->acpID == $cur_account) return 1;
    			$collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($task->asgID)->andWhere('deleted')->eq(0)->fetch()->college_id;
    			if ($collegeid != $this->session->user->college_id) return 0;
    			if ($task->ACL == 3) return 1;
    			if ($this->loadModel('project')->checkRelation($cur_account, $task->asgID))
    			{
    				if ($task->ACL == 2) return 1;
    			}
    			return 0;
    			break;
    		}
            case 'submit':{
            	if (($task->acpID == $cur_account) && ($task->deleted == 0) && ($task->completetime == null))
            	{
                    if (($task->begintime <= $curtime) && ($task->submittime == null))    
                        return 1;
	            }
            	return 0;
            	break;
            }
            case 'editsubmit':{
            	if (($task->acpID == $cur_account) && ($task->deleted == 0) && ($task->completetime == null))
            	{
                    if (($task->begintime <= $curtime) && ($task->submittime != null))    
                        return 1;
	            }
            	return 0;
                break;
            }
            default:
            	return 0;
    	}
    }

    public function checkTeacherPriv($task, $method)
    {
    	$cur_account = $this->session->user->account;
    	$curtime = helper::now();
    	switch ($method)
    	{
    		case 'view':{
    			if ($task->deleted == 1) return 0; 
                if ($task->asgID == $cur_account) return 1;
                $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($task->asgID)->andWhere('deleted')->eq(0)->fetch()->college_id;
    			if ($collegeid != $this->session->user->college_id) return 0;
    			if ($task->ACL == 3) return 1;
    			return 0;
    			break;
    		}
    		case 'edit':{
    			if (($task->asgID == $cur_account) && ($task->deleted == 0) && ($task->completetime == null))
    			    return 1;
    			return 0;
    			break;
    		}
    		case 'assess':{
    			if (($task->asgID == $cur_account) && ($task->deleted == 0) && ($task->completetime == null))
    			{
    				if ($task->submittime != null)
    					return 1;
    			}
    			return 0;
    			break;
    		}
    		case 'delete':{
    			if (($task->asgID == $cur_account) && ($task->deleted == 0) && ($task->completetime == null))
    			    return 1;
    			return 0;
    			break;
    		}
    		case 'finish':{
    			if (($task->asgID == $cur_account) && ($task->deleted == 0) && ($task->completetime == null))
    			{
    				if ($task->assesstime != null)
    					return 1;
    			}
                break;
    		}
    		default:
    			return 0;
    	}
    }

    public function checkCouncelorPriv($task, $method)
    {
    	if ($method == 'view')
    	{
            if ($task->ACL == 3)
            {
                $collegeid = $this->dao->select('college_id')->from(TABLE_USER)->where('account')->eq($task->asgID)->andWhere('deleted')->eq(0)->fetch()->college_id;
    			if ($collegeid == $this->session->user->college_id) return 1;
    			return 0;
            }
    	}
    	else
    	{
    		return 0;
    	}
    }

    public function checkManagerPriv($task, $method)
    {
    	if ($method == 'view')
    	{
    		if ($task->deleted == 1) return 0; 
            if ($task->ACL == 3)
            	return 1;
            else
            	return 0;
    	}
    	else
    	{
    		return 0;
    	}
    }

    public function getTaskColumns($role, $type = 'all')
    {
        switch ($role)
        {
        	case 'student':{
        		switch ($type)
        		{
        			case 'all': return 8;
        			case 'undone': return 7;
        			case 'done': return 7;
        		}
        	}
        	case 'teacher':{
                switch ($type)
                {
                	case 'all': return 6;
                	case 'undone': return 7;
                	case 'done': return 6;
                	case 'unassessed': return 7;
                	case 'assessed': return 6;
                }
        	}
        	default: return 6;
        }
    }
}
