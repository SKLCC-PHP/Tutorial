<?php
/**
 * The control file of user module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id: control.php 5005 2013-07-03 08:39:11Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
class user extends control
{
	public $referer;

	/**
	 * Construct 
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('company')->setMenu();
		$this->loadModel('personalinfo');
	}


	/**
	 * @author iat
	 * @date 20140824
	 * index view to show the users, not company-setUser before, and modify the infomation which shows in the view
	 */
	public function index($param = 0 , $orderBy = 'account_asc', $recTotal = 0, $recPerPage = 20, $pageID = 1, 
		$paramaccount = '', $paramrealname = '', $paramcollege = '', $paramrole = '')
	{
		/* Save session. */
		$this->session->set('userList', $this->app->getURI(true));

		/* Set the pager. */
		$this->app->loadClass('pager', $static = true);
		$pager = pager::init($recTotal, $recPerPage, $pageID);
		if($this->session->user->roleid == 'counselor')
		{
			$users = $this->user->getUsers($pager, $orderBy, $paramaccount, $paramrealname, $paramcollege, $paramrole, 0, $this->session->user->grade);
		}
		else
			$users = $this->user->getUsers($pager, $orderBy, $paramaccount, $paramrealname, $paramcollege, $paramrole);

		$colleges = $this->dao->select('college_id, college_name')->from(TABLE_COLLEGE)->where('status')->eq(1)->fetchAll();

		$collegeList = array();
		foreach ($colleges as $college) 
		{
			$collegeList[$college->college_id] = $college->college_name;
		}
	
		$groups = $this->dao->select('name, role')->from(TABLE_GROUP)->where('status')->eq(1)->fetchAll();
		$groupList = array();
		foreach($groups as $group)
		{
			$groupList[$group->role] = $group->name;
		}

		$this->view->users       = $users;
		$this->view->orderBy     = $orderBy;
		$this->view->pager       = $pager;
		$this->view->param       = $param;
		$this->view->searchaccount = $paramaccount;
		$this->view->searchrealname = $paramrealname;
		$this->view->searchcollege = $paramcollege;
		$this->view->searchrole = $paramrole;
		$this->view->type        = $type;
		$this->view->collegeList = $collegeList;
		$this->view->groupList = $groupList;
		$this->display();
	}
	/**
	 * View a user.
	 * 
	 * @param  string $account 
	 * @access public
	 * @return void
	 */
	public function view($account)
	{
		$this->locate($this->createLink('user', 'todo', "account=$account"));
	}

	/**
	 * Todos of a user. 
	 * 
	 * @param  string $account 
	 * @param  string $type         the todo type, today|lastweek|thisweek|all|undone, or a date.
	 * @param  string $status 
	 * @param  string $orderBy 
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function todo($account, $type = 'today', $status = 'all', $orderBy='date,status,begin', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		/* Set thie url to session. */
		$uri = $this->app->getURI(true);
		$this->session->set('todoList', $uri);
		$this->session->set('bugList',  $uri);
		$this->session->set('taskList', $uri);

		/* Load pager. */
		$this->app->loadClass('pager', $static = true);
		$pager = pager::init($recTotal, $recPerPage, $pageID);

		/* Get user, totos. */
		$user    = $this->user->getByAccount($account);
		$account = $user->account;
		//@Greem delete one line.
		$date    = (int)$type == 0 ? helper::today() : $type;

		/* set menus. */
		$this->lang->set('menugroup.user', 'company');
		$this->user->setMenu($this->user->getPairs('noempty|noclosed|nodeleted'), $account);
		$this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

		$this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->todo;
		$this->view->position[] = $this->lang->user->todo;
		$this->view->tabID      = 'todo';
		$this->view->date       = $date;
		$this->view->todos      = $todos;
		$this->view->user       = $user;
		$this->view->account    = $account;
		$this->view->type       = $type;
		$this->view->status     = $status;
		$this->view->orderBy    = $orderBy;
		$this->view->pager      = $pager;

		$this->display();
	}

	/**
	 * Story of a user.
	 * 
	 * @param  string $account 
	 * @param  string $type 
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function story($account, $type = 'assignedTo', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		/* Save session. */
		$this->session->set('storyList', $this->app->getURI(true));

		/* Load pager. */
		$this->app->loadClass('pager', $static = true);
		$pager = pager::init($recTotal, $recPerPage, $pageID);

		/* Set menu. */
		$this->lang->set('menugroup.user', 'company');
		$this->user->setMenu($this->user->getPairs('noempty|noclosed|nodeleted'), $account);
		$this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

		/* Assign. */
		$this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->story;
		$this->view->position[] = $this->lang->user->story;
		$this->view->stories    = $this->loadModel('story')->getUserStories($account, $type, 'id_desc', $pager);
		$this->view->users      = $this->user->getPairs('noletter');
		$this->view->type       = $type;
		$this->view->account    = $account;
		$this->view->pager      = $pager;

		$this->display();
	}

	/**
	 * Tasks of a user. 
	 * 
	 * @param  string $account 
	 * @param  string $type
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function task($account, $type = 'assignedTo', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		/* Save the session. */
		$this->session->set('taskList', $this->app->getURI(true));

		/* Load pager. */
		$this->app->loadClass('pager', $static = true);
		$pager = pager::init($recTotal, $recPerPage, $pageID);

		/* Set the menu. */
		$this->lang->set('menugroup.user', 'company');
		$this->user->setMenu($this->user->getPairs('noempty|noclosed|nodeleted'), $account);
		$this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

		/* Assign. */
		$this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->task;
		$this->view->position[] = $this->lang->user->task;
		$this->view->tabID      = 'task';
		$this->view->tasks      = $this->loadModel('task')->getTasks($account, $type, 0, $pager);
		$this->view->type       = $type;
		$this->view->account    = $account;
		$this->view->user       = $this->dao->findByAccount($account)->from(TABLE_USER)->fetch();
		$this->view->pager      = $pager;

		$this->display();
	}

	/**
	 * User projects. 
	 * 
	 * @param  string $account 
	 * @access public
	 * @return void
	 */
	public function project($account)
	{
		/* Set the menus. */
		$this->loadModel('project');
		$this->lang->set('menugroup.user', 'company');
		$this->user->setMenu($this->user->getPairs('noempty|noclosed|nodeleted'), $account);
		$this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclose|nodeleted'), $account);

		$this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->project;
		$this->view->position[] = $this->lang->user->project;
		$this->view->tabID      = 'project';
		$this->view->projects   = $this->user->getProjects($account);
		$this->view->account    = $account;
		$this->view->user       = $this->dao->findByAccount($account)->from(TABLE_USER)->fetch();

		$this->display();
	}

	/**
	 * The profile of a user.
	 * 
	 * @param  string $account 
	 * @access public
	 * @return void
	 */
	public function profile($account)
	{
		/* Set menu. */
		$this->user->setMenu($this->user->getPairs('noempty|noclosed|nodeleted'), $account);
		$this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclose|nodeleted'), $account);

		$user = $this->user->getByAccount($account);
	   
		$this->view->title      = "USER #$user->id $user->account/" . $this->lang->user->profile;
		$this->view->position[] = $this->lang->user->common;
		$this->view->position[] = $this->lang->user->profile;
		$this->view->account    = $account;
		$this->view->user       = $user;
		$this->view->groups     = $this->loadModel('group')->getByAccount($account);

		$this->display();
	}

	/**
	 * Set the rerferer.
	 * 
	 * @param  string   $referer 
	 * @access public
	 * @return void
	 */
	public function setReferer($referer = '')
	{
		if(!empty($referer))
		{
			$this->referer = helper::safe64Decode($referer);
		}
		else
		{
			$this->referer = $this->server->http_referer ? $this->server->http_referer: '';
		}
	}

	/**
	 * @author iat
	 * @date 20140824
	 * @modify create function, use only group
	 */
	public function create()
	{
		if(!empty($_POST))
		{
			$creator_ID = $this->user->create();
			if(dao::isError()) die(js::error(dao::getError()));
			$this->loadModel('action')->create('user', $creator_ID, 'created');
			die(js::locate($this->createLink('user', 'index', array('param' => 0 , 'orderBy' => 'createtime_desc')), 'parent'));
		}

		//@iat select groups which status is nomal, and rank is used to ensure the account which has low ranks can not create higher rank account
		$groups = $this->dao->select('id, name, role, rank')->from(TABLE_GROUP)->where('status')->eq(1)->fetchAll();
		$groupList = array();
		$role_id = $this->session->userinfo->roleid;
		$rank = $this->user->getRankByGroup($role_id);

		foreach($groups as $group)
		{
			if($rank >= $group->rank)
			{
				$groupList[$group->role] = $group->name;
			}
		}

		//@iat if the creator's role is admin ,then he can create users by selecting different colleges, otherwise, he can only create users in his college
		$colleges = $this->dao->select('college_id, college_name')->from(TABLE_COLLEGE)->where('status')->eq(1)->fetchAll();

		$collegeList = array();
		foreach ($colleges as $college) 
		{

			$collegeList[$college->college_id] = $college->college_name;
		}

		//init the years
		for($i = 0;$i < 6;$i++)
		{
			$years[date('Y')-$i] = date('Y')-$i;
		}

		//$title = $this->lang->company->common . $this->lang->colon . $this->lang->user->create;
		//$this->view->title = $title;
		$this->view->groupList = $groupList;
		$this->view->years = $years;
		$this->view->collegeList = $collegeList;
		$this->view->creatorcollege = $collegeList[$this->session->user->college_id];
		$this->view->role_id = $role_id;
		$this->display();
	}


	/**
	 * Batch create users.
	 * 
	 * @access public
	 * @return void
	 */
	public function batchCreate()
	{

		$groups = $this->dao->select('id, name, role, rank')->from(TABLE_GROUP)->where('status')->eq(1)->fetchAll();
		$groupList = array();
		$role_id = $this->session->userinfo->roleid;
		$rank = $this->user->getRankByGroup($role_id);

		foreach($groups as $group)
		{
			if($rank >= $group->rank)
			{
				$groupList[$group->role] = $group->name;
			}
		}

		//@iat if the creator's role is admin ,then he can create users by selecting different colleges, otherwise, he can only create users in his college
		$colleges = $this->dao->select('college_id, college_name')->from(TABLE_COLLEGE)->where('status')->eq(1)->fetchAll();

		$collegeList = array();
		foreach ($colleges as $college) 
		{

			$collegeList[$college->college_id] = $college->college_name;
		}

		if(!empty($_POST))
		{
			$this->user->batchCreate();
			die(js::locate($this->createLink('user', 'index', array('param' => 0 , 'orderBy' => 'createtime_desc')), 'parent'));
		}

		$this->view->creatorcollege_id = $this->session->user->college_id;
		$this->view->collegeList = $collegeList;
		$this->view->groupList = $groupList;
		$this->view->role_id = $role_id;
		$this->display();
	}

	/**
	 * Edit a user.
	 * 
	 * @param  string|int $user_account   the int user id or account
	 * @access public
	 * @return void
	 * @author iat
	 * @date 20140824
	 * deal with group
	 */
	public function edit($user_account)
	{
		if(!empty($_POST))
		{
			$id = $this->user->update($user_account);
			if(dao::isError()) die(js::error(dao::getError()));
			$this->loadModel('action')->create('user', $id, 'edited');
			die(js::locate($this->createLink('user', 'index', array('param' => 0 , 'orderBy' => 'updatetime_desc')), 'parent'));
		}

		$title = $this->lang->company->common . $this->lang->colon . $this->lang->user->edit;
		$user = $this->user->getByAccount($user_account);
		$groups = $this->dao->select('id, name, role, rank')->from(TABLE_GROUP)->where('status')->eq(1)->fetchAll();
		$groupList = array();
		$role_id = $this->session->userinfo->roleid;
		$rank = $this->user->getRankByGroup($role_id);

		//the same rank account can not edit the same rank account
		$can_edit = (($rank > $this->user->getRankByGroup($user->roleid)) || ($this->session->user->roleid == 'admin'));
		
		//if the manager is not admin, he can not edit the other college students
		if($role_id != 'admin')
		{
			if ($user->college_id != $this->session->user->college_id) 
			{
				die(js::locate($this->createLink('user', 'index', array('param' => 0 , 'orderBy' => 'updatetime_desc')), 'parent'));
			}
		}
		foreach($groups as $group)
		{
			if($rank >= $group->rank)
			{
				$groupList[$group->role] = $group->name;
			}
		}
		
		$colleges = $this->dao->select('college_id, college_name')->from(TABLE_COLLEGE)->where('status')->eq(1)->fetchAll();

		$collegeList = array();
		foreach ($colleges as $college) 
		{

			$collegeList[$college->college_id] = $college->college_name;
		}
		//init the years
		for($i = 0;$i < 6;$i++)
		{
			$years[date('Y')-$i] = date('Y')-$i;
		}
		$this->view->title = $title;
		$this->view->user = $user;
		$this->view->years = $years;
		$this->view->can_edit = $can_edit;
		$this->view->groupList = $groupList;
		$this->view->collegeList = $collegeList;
		$this->view->creatorcollege = $collegeList[$this->session->user->college_id];
		$this->display();
	}

	/**
	 * Batch edit user.
	 * 
	 * @access public
	 * @return void
	 */
	public function batchEdit()
	{
		if(isset($_POST['users']))
		{
			$this->view->users = $this->dao->select('*')->from(TABLE_USER)->where('account')->in($this->post->users)->orderBy('id')->fetchAll('id');
		}
		elseif($_POST)
		{
			if($this->post->account) $this->user->batchEdit();
			die(js::locate($this->createLink('company', 'setUser'), 'parent'));
		}
		$this->lang->set('menugroup.user', 'company');
		$this->lang->user->menu      = $this->lang->company->menu;
		$this->lang->user->menuOrder = $this->lang->company->menuOrder;

		$this->view->title      = $this->lang->company->common . $this->lang->colon . $this->lang->user->batchEdit;
		$this->view->position[] = $this->lang->user->batchEdit;
		$this->display();
	}

	/**
	 * Delete a user.
	 * 
	 * @param  int    $user_account 
	 * @param  string $confirm  yes|no
	 * @access public
	 * @return void
	 */
	public function delete($user_account, $confirm = 'no')
	{
		$user = $this->user->getByAccount($user_account);
		if(strpos($this->app->company->admins, ",{$this->app->user->account},") !== false and $this->app->user->account == $user->account) return;
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->user->confirmDelete, $this->createLink('user', 'delete', "user_account=$user_account&confirm=yes")));
		}
		else
		{
			$id = $this->user->delete($user_account);
			$this->loadModel('action')->create('user', $user->id, 'erased');
			/* if ajax request, send result. */
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
			die(js::locate($this->session->userList, 'parent'));
		}
	}

	/**
	 * Unlock a user.
	 * 
	 * @param  int    $account 
	 * @param  string $confirm 
	 * @access public
	 * @return void
	 */
	public function unlock($account, $confirm = 'no')
	{
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->user->confirmUnlock, $this->createLink('user', 'unlock', "account=$account&confirm=yes")));
		}
		else
		{
			$this->user->cleanLocked($account);
			die(js::locate($this->createLink('company', 'browse'), 'parent'));
		}
	}

	/**
	 * User login, identify him and authorize him.
	 * 
	 * @access public
	 * @return void
	 */
	public function login($referer = '', $from = '')
	{
		$this->setReferer($referer);

		$loginLink = $this->createLink('user', 'login');
		$denyLink  = $this->createLink('user', 'deny');

		//@iat 20140824 sad to find the missing judge
		/* If user is logon, back to the rerferer. */
        if($this->user->isLogon())
        {
            if(strpos($this->referer, $loginLink) === false and 
               strpos($this->referer, $denyLink)  === false 
            )
            {
                $this->locate($this->referer);
            }
            else
            {
                $this->locate($this->createLink($this->config->default->module));
            }
        }
        
		/* Passed account and password by post or get. */
		if(!empty($_POST))
		{
			if(strtolower($this->post->captcha) != $this->session->captcha)//@Green use the captcha 2015
				die(js::error($this->lang->user->wrong_captcha));
			if($this->post->hidden && $this->post->hidden === 'forget')
			{
				$this->forgetPassword($_POST);
			}
			else if($this->post->hidden && $this->post->hidden === 'reset')
			{
				$this->resetPassword($_POST);
			}

			$account  = '';
			$password = '';

			if($this->post->account)  $account  = $this->post->account;
			if($this->post->password) $password = $this->post->password;



			//@iat 20140824 This is important, the users are sad that they can not login in and even with no givn messages
			if($this->user->checkLocked($account)) die(js::error(sprintf($this->lang->user->loginLocked, $this->config->user->lockMinutes)));
			$user = $this->user->identify($account, $password);

			if($user)
			{
				$this->user->cleanLocked($account);
				/* Authorize him and save to session. */
				$user->rights = $this->user->authorize($account);
				$user->groups = $this->user->getGroups($account);
				$this->session->set('user', $user);

				/**
				 * @author iat
				 * @date 20140827
				 * add some relation info into session userinfo for later user directly instead of selecting from the database
				 */
				$this->session->set('userinfo', $this->user->getUserInfo($user->account, $user->college_id));
				
				$this->app->user = $this->session->user;
				$this->app->userinfo = $this->session->userinfo;
				$this->app->user->rolename = $this->session->userinfo->rolename;
				$this->app->user->collegename = $this->session->userinfo->collegename;
				$this->loadModel('action')->create('user', $user->id, 'login');

				/* Keep login. */
				if($this->post->keepLogin) $this->user->keepLogin($user);

				/* Go to the referer. */
				if($this->post->referer and 
				   strpos($this->post->referer, $loginLink) === false and 
				   strpos($this->post->referer, $denyLink)  === false 
				)
				{
					if($this->app->getViewType() == 'json') die(json_encode(array('status' => 'success')));

					/* Get the module and method of the referer. */
					if($this->config->requestType == 'PATH_INFO')
					{
						$path = substr($this->post->referer, strrpos($this->post->referer, '/') + 1);
						$path = rtrim($path, '.html');
						if(empty($path)) $path = $this->config->requestFix;
						list($module, $method) = explode($this->config->requestFix, $path);
					}
					else
					{
						$url   = html_entity_decode($this->post->referer);
						$param = substr($url, strrpos($url, '?') + 1);
						list($module, $method) = explode('&', $param);
						$module = str_replace('m=', '', $module);
						$method = str_replace('f=', '', $method);
					}

					if(common::hasPriv($module, $method))
					{
						die(js::locate($this->post->referer, 'parent'));
					}
					else
					{
						die(js::locate($this->createLink($this->config->default->module), 'parent'));
					}
				}
				else
				{
					if($this->app->getViewType() == 'json') die(json_encode(array('status' => 'success')));
					die(js::locate($this->createLink($this->config->default->module), 'parent'));
				}
			}
			else
			{
				if($this->app->getViewType() == 'json') die(json_encode(array('status' => 'failed')));
				$fails       = $this->user->failPlus($account);
				$remainTimes = $this->config->user->failTimes - $fails;
				if($remainTimes <= 0)
				{
					die(js::error(sprintf($this->lang->user->loginLocked, $this->config->user->lockMinutes)));
				}
				else if($remainTimes <= 3)
				{
					die(js::error(sprintf($this->lang->user->lockWarning, $remainTimes)));
				}
				die(js::error($this->lang->user->loginFailed));
			}
		}
		else
		{ 
			/*if(!empty($this->config->global->showDemoUsers))
			{
				$demoUsers = $this->user->getPairs('nodeleted, noletter, noempty, noclosed');
				$this->view->demoUsers = $demoUsers;
			}*/

			$this->app->loadLang('misc');
			//$this->view->noGDLib   = sprintf($this->lang->misc->noGDLib, common::getSysURL() . $this->config->webRoot);
			$this->view->title     = $this->lang->user->login;
			$this->view->referer   = $this->referer;
			$this->view->s         = zget($this->config->global, 'sn');
			$this->view->keepLogin = $this->cookie->keepLogin ? $this->cookie->keepLogin : 'off';
			$this->display();
		}
	}

	/**
	 * Deny page.
	 * 
	 * @param  string $module
	 * @param  string $method 
	 * @param  string $refererBeforeDeny    the referer of the denied page.
	 * @access public
	 * @return void
	 */
	public function deny($module, $method, $refererBeforeDeny = '')
	{
		$this->setReferer();
		$this->view->title             = $this->lang->user->deny;
		$this->view->module            = $module;
		$this->view->method            = $method;
		$this->view->denyPage          = $this->referer;        // The denied page.
		$this->view->refererBeforeDeny = $refererBeforeDeny;    // The referer of the denied page.
		$this->app->loadLang($module);
		$this->app->loadLang('my');
		$this->display();
		exit;
	}

	/**
	 * Logout.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout($referer = 0)
	{
		if(isset($this->app->user->id)) $this->loadModel('action')->create('user', $this->app->user->id, 'logout');
		session_destroy();
		setcookie('za', false);
		setcookie('zp', false);
		$vars = !empty($referer) ? "referer=$referer" : '';
		$this->locate($this->createLink('user', 'login', $vars));
	}
	
	/**
	 * User dynamic.
	 * 
	 * @param  string $period 
	 * @param  string $account 
	 * @param  string $orderBy 
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function dynamic($period = 'today', $account = '', $orderBy = 'date_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		/* set menus. */
		$this->lang->set('menugroup.user', 'company');
		$this->user->setMenu($this->user->getPairs('noempty|noclosed|nodeleted'), $account);
		$this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

		/* Save session. */
		$uri   = $this->app->getURI(true);
		$this->session->set('productList',     $uri);
		$this->session->set('productPlanList', $uri);
		$this->session->set('releaseList',     $uri);
		$this->session->set('storyList',       $uri);
		$this->session->set('projectList',     $uri);
		$this->session->set('taskList',        $uri);
		$this->session->set('buildList',       $uri);
		$this->session->set('bugList',         $uri);
		$this->session->set('caseList',        $uri);
		$this->session->set('testtaskList',    $uri);

		/* Set the pager. */
		$this->app->loadClass('pager', $static = true);
		$pager = pager::init($recTotal, $recPerPage, $pageID);
		$this->view->orderBy = $orderBy;
		$this->view->pager   = $pager;

		$this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->dynamic;
		$this->view->position[] = $this->lang->user->dynamic;

		/* Assign. */
		$this->view->period  = $period;
		$this->view->users   = $this->loadModel('user')->getPairs('nodeleted|noletter');
		$this->view->account = $account;
		$this->view->user    = $this->dao->findByAccount($account)->from(TABLE_USER)->fetch();
		$this->view->actions = $this->loadModel('action')->getDynamic($account, $period, $orderBy, $pager);
		$this->display();
	}

	/**
	 * Manage contacts.
	 * 
	 * @param  int    $listID 
	 * @access public
	 * @return void
	 */
	public function manageContacts($listID = 0)
	{
		// $lists = $this->user->getContactLists($this->app->user->account);@Green

		/* If set $mode, need to update database. */
		if($this->post->mode)
		{
			/* The mode is new: append or new a list. */
			if($this->post->mode == 'new')
			{
				if($this->post->list2Append)
				{
					$this->user->append2ContactList($this->post->list2Append, $this->post->users);
					die(js::locate(inlink('manageContacts', "listID={$this->post->list2Append}"), 'parent'));
				}
				elseif($this->post->newList)
				{
					$listID = $this->user->createContactList($this->post->newList, $this->post->users);
					die(js::locate(inlink('manageContacts', "listID=$listID"), 'parent'));
				}
			}
			elseif($this->post->mode == 'edit')
			{
				$this->user->updateContactList($this->post->listID, $this->post->listName, $this->post->users);
				die(js::locate(inlink('manageContacts', "listID={$this->post->listID}"), 'parent'));
			}
		}
		if($this->post->users) 
		{
			$mode  = 'new';
			$users = $this->user->getContactUserPairs($this->post->users);
		}
		else
		{
			$mode  = 'edit';
			$listID= $listID ? $listID : key($lists);
			if(!$listID) die(js::alert($this->lang->user->contacts->noListYet) . js::locate($this->createLink('company', 'browse'), 'parent'));

			$list  = $this->user->getContactListByID($listID);
			$users = explode(',', $list->userList);
			$users = $this->user->getContactUserPairs($users);
			$this->view->list = $list;
		}

		$this->view->title      = $this->lang->company->common . $this->lang->colon . $this->lang->user->manageContacts;
		$this->view->position[] = $this->lang->company->common;
		$this->view->position[] = $this->lang->user->manageContacts;
		// $this->view->lists      = $this->user->getContactLists($this->app->user->account);@Green
		$this->view->users      = $users;
		$this->view->listID     = $listID;
		$this->view->mode       = $mode;
		$this->display();
	}

	/**
	 * Delete a contact list.
	 * 
	 * @param  int    $listID 
	 * @param  string $confirm 
	 * @access public
	 * @return void
	 */
	public function deleteContacts($listID, $confirm = 'no')
	{
		if($confirm == 'no')
		{
			echo js::confirm($this->lang->user->contacts->confirmDelete, inlink('deleteContacts', "listID=$listID&confirm=yes"));
			exit;
		}
		else
		{
			$this->user->deleteContactList($listID);
			echo js::locate(inlink('manageContacts'), 'parent');
			exit;
		}
	}

	/**
	 * Get user for ajax
	 *
	 * @param  string $requestID
	 * @param  string $assignedTo
	 * @access public
	 * @return void
	 */
	public function ajaxGetUser($taskID = '', $assignedTo = '')
	{
		$users = $this->user->getPairs('noletter, noclosed');
		$html = "<form method='post' target='hiddenwin' action='" . $this->createLink('task', 'assignedTo', "taskID=$taskID&assignedTo=$assignedTo") . "'>";
		$html .= html::select('assignedTo', $users, $assignedTo);
		$html .= html::submitButton();
		$html .= '</form>';
		echo $html;
	}

	/**
	 * AJAX: get users from a contact list.
	 * 
	 * @param  int    $contactListID 
	 * @access public
	 * @return string
	 */
	public function ajaxGetContactUsers($contactListID)
	{
		$users = $this->user->getPairs('nodeleted,devfirst');
		if(!$contactListID) return print(html::select('mailto[]', $users, '', "class='form-control' multiple data-placeholder='{$this->lang->chooseUsersToMail}'"));
		$list = $this->user->getContactListByID($contactListID);
		return print(html::select('mailto[]', $users, $list->userList, "class='form-control' multiple data-placeholder='{$this->lang->chooseUsersToMail}'"));
	}
	
	/**
	 * @author iat
	 * @date 20140831
	 * 
	 */
	private function forgetPassword($post)
	{
		$account = $post['account'];
		$email = $post['email'];
		if($account != '' && $email != '')
		{
			if($this->user->checkEmail($account, $email))
			{
				if($this->loadModel('mail')->sendVerificationCode($account, $email))
				{
					die(js::error(sprintf("发送成功，请检查邮箱，注意是否在垃圾箱中")));
				}
				die(js::error(sprintf("Sorry, 发送失败，再次尝试或联系管理员")));
			}
			die(js::error(sprintf("用户名和邮箱不匹配")));
		}
		die(js::error(sprintf("请填写用户名和邮箱")));
	}

	/**
	 * @author iat
	 * @date 20140831
	 */
	private function resetPassword($post)
	{
		$account = $post['account'];
		$verification_code = $post['verification_code'];
		$password1 = $post['password1'];
		$password2 = $post['password2'];

		if($account == '' || $verification_code == '' || $password1 == '' || $password2 == '')
		{
			die(js::error(sprintf("请填写好所有栏目！")));
		}

		$user = $this->dao
			->select('verification_code')->from(TABLE_USER)
			->where('account')->eq($account)
			->andwhere('deleted')->eq(0)
			->fetch();
		if($user && $user->verification_code && $user->verification_code == $verification_code)
		{
			if($this->validatePassword($password1, $password2))
			{
				$user = $this->dao->update(TABLE_USER)
					->set('password')->eq(md5($password1))
					->where('account')->eq($account)
					->exec();
				die(js::error(sprintf("密码重置成功，请返回登陆")));
			}
		}
		else
		{
			die(js::error(sprintf("验证码不正确，重新输入或重新获取，或者联系管理员")));
		}
		die(js::error(sprintf("验证码不正确，3分钟后再获取，或者联系管理员")));
	}

	/**
	 * @author iat
	 * @date 20140831
	 */
	private function validatePassword($password1, $password2)
	{
		if($password1 != $password2)
		{
			die(js::error(sprintf("两次密码不一致，请重新输入！")));
		}
		if(!validater::checkReg($password1, '|(.){6,}|'))
		{
			die(js::error(sprintf($this->lang->error->passwordrule)));
		}
		return true;
	}

	/**
	 * @author Green
	 * @date 20141025
	 */
	public function search()
    {
    	$get_data = fixer::input('post')->get();
																													
        die(js::locate($this->createLink('user', 'index', 
        	array('param' => 0, 'orderBy' => 'account_asc', 'recTotal' => 0, 'recPerPage' => 20, 'pageID' => 1, 
        		'paramaccount' => $get_data->account, 'paramrealname' => $get_data->realname, 'paramcollege' => $get_data->college, 
        		'paramrole' => $get_data->role)), 'parent'));
    }

    /**
	 * @author green
	 * @date 201412-22
	 */
	public function captcha()
	{
		unset($captch_code);
		$image = imagecreatetruecolor(100, 30);//create a picture
		$bgcolor = imagecolorallocate($image, 255, 245, 245);//get a color
		imagefill($image, 0, 0, $bgcolor);//fill the bgcolor to the image   

		$captch_code = '';

		for ($i=0; $i < 4; $i++) 
		{	
			$fontsize = 6;//set tje size of the numbers
		 	$fontcolor = imagecolorallocate($image, rand(0,80), rand(0,80), rand(0,80));//get random color
			$data = 'abcdefghijkmnpqrstuvwxy3456789';
			$fontcontent = substr($data, rand(0,strlen($data)-1),1);
			$captch_code .= $fontcontent;
			$x = ($i*100/4)+rand(5,10);//the location of the number
		 	$y = rand(5,10);

			imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);//fill the number onto the image
		}

		$this->session->set('captcha',$captch_code);
		for ($i=0; $i < 500; $i++) 
		{ 
			$pointcolor = imagecolorallocate($image, rand(100,200), rand(100,200), rand(100,200));//set the color of the point
			imagesetpixel($image, rand(1,199), rand(1,59), $pointcolor);//fill the point to the image
		}
		
		for ($i=0; $i < 4; $i++) 
		{ 
			$linecolor = imagecolorallocate($image, rand(80,200), rand(80,200), rand(80,200));
			imageline($image, rand(1,199), rand(1,59), rand(1,199), rand(1,59), $linecolor);
		}

		header('content-type:image/png');
		imagepng($image);
		
		//end
		imagedestroy($image); 

		$this->display();
	}
}
