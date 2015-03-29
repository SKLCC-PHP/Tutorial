<?php
/**
 * The model file of user module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id: model.php 5005 2013-07-03 08:39:11Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class userModel extends model
{
	/**
	 * Set the menu.
	 * 
	 * @param  array  $users    user pairs
	 * @param  string $account  current account
	 * @access public
	 * @return void
	 */
	public function setMenu($users, $account)
	{
		$methodName = $this->app->getMethodName();
		$selectHtml = html::select('account', $users, $account, "onchange=\"switchAccount(this.value, '$methodName')\"");
		foreach($this->lang->user->menu as $key => $value)
		{
			$replace = ($key == 'account') ? $selectHtml : $account;
			common::setMenuVars($this->lang->user->menu, $key, $replace);
		}
	}

	/**
	 * Set users list.
	 * 
	 * @param  array    $users 
	 * @param  string   $account 
	 * @access public
	 * @return html 
	 */
	public function setUserList($users, $account)
	{
		return html::select('account', $users, $account, "onchange=\"switchAccount(this.value, '{$this->app->getMethodName()}')\" class='form-control'");
	}

	/**
	 * Get users list of current company.
	 * 
	 * @access public
	 * @return void
	 */
	public function getList()
	{
		return $this->dao->select('*')->from(TABLE_USER)
				->where('status')->eq(1)
				->andWhere('deleted')->eq(0)
				->orderBy('account')->fetchAll();
	}

	/**
	 * Get the account=>relaname pairs.
	 * 
	 * @param  string $params   noletter|noempty|noclosed|nodeleted|withguest|pofirst|devfirst|qafirst|pmfirst, can be sets of theme
	 * @param  string $usersToAppended  account1,account2 
	 * @access public
	 * @return array
	 */
	public function getPairs($params = '', $usersToAppended = '')
	{
		/* Set the query fields and orderBy condition.
		 *
		 * If there's xxfirst in the params, use INSTR function to get the position of role fields in a order string,
		 * thus to make sure users of this role at first.
		 */
		$fields = 'account, realname';
		if(strpos($params, 'pofirst') !== false) $fields .= ", INSTR(',pd,po,', role) AS roleOrder";
		if(strpos($params, 'pdfirst') !== false) $fields .= ", INSTR(',po,pd,', role) AS roleOrder";
		if(strpos($params, 'qafirst') !== false) $fields .= ", INSTR(',qd,qa,', role) AS roleOrder";
		if(strpos($params, 'qdfirst') !== false) $fields .= ", INSTR(',qa,qd,', role) AS roleOrder";
		if(strpos($params, 'pmfirst') !== false) $fields .= ", INSTR(',td,pm,', role) AS roleOrder";
		if(strpos($params, 'devfirst')!== false) $fields .= ", INSTR(',td,pm,qd,qa,dev,', role) AS roleOrder";
		$orderBy = strpos($params, 'first') !== false ? 'roleOrder DESC, account' : 'account';

		/* Get raw records. */
		$users = $this->dao->select($fields)->from(TABLE_USER)
			->beginIF(strpos($params, 'nodeleted') !== false)->where('status')->eq(1)->andWhere('deleted')->eq(0)->fi()  
			->orderBy($orderBy)
			->fetchAll('account');
		if($usersToAppended) $users += $this->dao->select($fields)->from(TABLE_USER)->where('account')->in($usersToAppended)->fetchAll('account');

		/* Cycle the user records to append the first letter of his account. */
		foreach($users as $account => $user)
		{
			$firstLetter = ucfirst(substr($account, 0, 1)) . ':';
			if(strpos($params, 'noletter') !== false) $firstLetter =  '';
			$users[$account] =  $firstLetter . ($user->realname ? $user->realname : $account);
		}

		/* Append empty, closed, and guest users. */
		if(strpos($params, 'noempty')   === false) $users = array('' => '') + $users;
		if(strpos($params, 'noclosed')  === false) $users = $users + array('closed' => 'Closed');
		if(strpos($params, 'withguest') !== false) $users = $users + array('guest' => 'Guest');

		return $users;
	}
	//@Green delete function about committers
	
	/**
	 * Get user list with email and real name.
	 * 
	 * @param  string|array $users 
	 * @access public
	 * @return array
	 */
	public function getRealNameAndEmails($users)
	{
		$users = $this->dao->select('account, email, realname')->from(TABLE_USER)->where('account')->in($users)->fetchAll('account');
		if(!$users) return array();
		foreach($users as $account => $user) if($user->realname == '') $user->realname = $account;
		return $users;
	}

	/**
	 * Get roles for some users.@Green has updated.
	 * 
	 * @param  string    $users 
	 * @access public
	 * @return array
	 */
	public function getUserRoles($users)
	{
		if(!is_array($users)) $users = (array)$users;

		foreach ($users as $user) 
		{
			$user_role = $this->dao->select('account,roleid')->from(TABLE_USER)->where('account')->eq($user)->fetch();
			$users_role[$user_role->account] = $user_role->roleid;
		}
		
		if(!$users_role) return array();

		return $users_role;
	}

	/**
	 * Get user info by user_account.
	 * 
	 * @param  int    $user_account 
	 * @access public
	 * @return object|bool
	 */
	public function getByAccount($user_account)
	{
		$user = $this->dao->select('id, account, roleid, college_id, realname, avatar, gender, email, qq, mobile, phone, `join`, visits, ip, last, department, administrativeclass, grade, specialty, polical_status, dormitory, research, title, education, status, deleted, createtime, updatetime, fails, locked')
		        ->from(TABLE_USER)->where('account')->eq($user_account)->fetch();
		
		return $user;
	}

	/**
	 * Get users by sql.
	 * 
	 * @param  int    $query 
	 * @param  int    $pager 
	 * @access public
	 * @return void
	 */
	public function getByQuery($query, $pager = null, $orderBy = 'id')
	{
		return $this->dao->select('*')->from(TABLE_USER)
			->where($query)
			->andWhere('status')->eq(1)
			->andWhere('deleted')->eq(0)
			->orderBy($orderBy)
			->page($pager)
			->fetchAll();
	}

	/**
	 * Create a user.
	 * @author iat
	 * @date 20140824
	 * @access public
	 * @return void
	 */
	public function create()
	{
		if(!$this->checkPassword()) return;

		$user = fixer::input('post')
			->setIF($this->post->password1 != false, 'password', md5($this->post->password1))
			->setIF($this->post->password1 == false, 'password', '')
			->remove('grade, group, college, password1, password2')
			->get();
		$user->roleid = $this->post->group;
		if($this->post->grade)
		{
			foreach ($this->post->grade as $year)
			{
				$user->grade = $user->grade.$year.",";

			}
			$user->grade = substr($user->grade, 0, strlen($user->grade)-1);
		}
		
		if($this->session->userinfo->roleid != 'admin')
		{
			$user->college_id = $this->session->user->college_id;
		}
		$user->createtime = helper::now();
		$this->dao->insert(TABLE_USER)->data($user)
			->autoCheck()
			->batchCheck($this->config->user->create->requiredFields, 'notempty')
			->check('account', 'unique')
			->check('account', 'account')
			->checkIF($this->post->email != false, 'email', 'email')
			->exec();
		$id = $this->dao->lastInsertID();
		// if($this->post->group)
		// {
		// 	$data = new stdClass();
		// 	$data->account = $this->post->account;
		// 	$data->group   = $this->post->group;
		// 	$this->dao->insert(TABLE_USERGROUP)->data($data)->exec();
		// }
		return $id;
	}

	/**
	 * Batch create users. 
	 * 
	 * @param  int    $users 
	 * @access public
	 * @return void
	 */
	public function batchCreate()
	{
		$users    = fixer::input('post')->get(); 
		$data     = array();
		$accounts = array();
		for($i = 0; $i < $this->config->user->batchCreate; $i++)
		{
			if($users->account[$i] != '')  
			{
				$account = $this->dao->select('account')->from(TABLE_USER)->where('account')->eq($users->account[$i])->fetch();
				if($account) die(js::error(sprintf($this->lang->user->error->accountDupl, $i+1)));
				if(in_array($users->account[$i], $accounts)) die(js::error(sprintf($this->lang->user->error->accountDupl, $i+1)));
				if(!validater::checkAccount($users->account[$i])) die(js::error(sprintf($this->lang->user->error->account, $i+1)));
				if($users->realname[$i] == '') die(js::error(sprintf($this->lang->user->error->realname, $i+1)));
				$users->password[$i] = (isset($prev['password']) and $users->ditto[$i] == 'on' and empty($users->password[$i])) ? $prev['password'] : $users->password[$i];
				if(!validater::checkReg($users->password[$i], '|(.){6,}|')) die(js::error(sprintf($this->lang->user->error->password, $i+1)));


				$data[$i] = new stdclass();
				$data[$i]->account  = $users->account[$i];
				$data[$i]->realname = $users->realname[$i];
				
				//$data[$i]->group    = $users->group[$i] == 'ditto' ? (isset($prev['group']) ? $prev['group'] : 'student') : $users->group[$i];
				$data[$i]->roleid = $users->group[$i] == 'ditto' ? (isset($prev['group']) ? $prev['group'] : 'student') : $users->group[$i];
				$data[$i]->password = md5($users->password[$i]);
				$data[$i]->college_id = $users->college_id[$i] == 'ditto' ? (isset($prev['college_id']) ? $prev['college_id'] : '') : $users->college_id[$i];
				$data[$i]->createtime = helper::now();
				$accounts[$i]     = $data[$i]->account;
				
				$prev['group']    = $data[$i]->group;
				$prev['college_id']    = $data[$i]->college_id;
				$prev['password'] = $users->password[$i];
			}
		}

		foreach($data as $user)
		{
			// if($user->group)
			// {
			// 	$group = new stdClass();
			// 	$group->account = $user->account;
			// 	$group->group   = $user->group;
			// 	$this->dao->insert(TABLE_USERGROUP)->data($group)->exec();
			// }
			unset($user->group);
			$this->dao->insert(TABLE_USER)->data($user)->autoCheck()->exec();
			$id = $this->dao->lastInsertID();
			$this->loadModel('action')->create('user', $id, 'created');
			if(dao::isError()) 
			{
				echo js::error(dao::getError());
				die(js::reload('parent'));
			}
		}
	}

	/**
	 * Update a user.
	 * 
	 * @param  int    $user_account
	 * @access public
	 * @return void
	 * @author iat
	 * @date 20140824
	 */
	public function update($user_account)
	{
		if(!$this->checkPassword()) return;

		$oldUser = $this->getByAccount($user_account);

		$user = fixer::input('post')
			->setIF($this->post->password1 != false, 'password', md5($this->post->password1))
			->remove('grade, password1, password2, groups, college_name, role_name')
			->get();
		if($this->post->groups)
		{
			$user->roleid = $this->post->groups;
		}

		if($this->post->grade)
		{
			foreach ($this->post->grade as $year) 
			{
				$user->grade = $user->grade.$year.",";
			}
			$user->grade = substr($user->grade, 0, strlen($user->grade)-1);
		}
		$user->updatetime = helper::now();
		$this->dao->update(TABLE_USER)->data($user)
			->autoCheck()
			->batchCheck($this->config->user->edit->requiredFields, 'notempty')
			->check('account', 'unique')
			->checkIF($this->post->email != false, 'email', 'email')
			->where('account')->eq($oldUser->account)
			->exec();

		// if($this->post->groups)
		// {
		// 	$this->dao->delete()->from(TABLE_USERGROUP)->where('account')->eq($oldUser->account)->exec();
			
		// 		$data          = new stdclass();
		// 		$data->account = $oldUser->account;
		// 		$data->group   = $this->post->groups;
		// 		$this->dao->insert(TABLE_USERGROUP)->data($data)->exec();
			
		// }
		return $oldUser->id;
	}

	/**
	 * Batch edit user.
	 * 
	 * @access public
	 * @return void
	 */
	public function batchEdit()
	{
		$oldUsers     = $this->dao->select('id, account')->from(TABLE_USER)->where('id')->in(array_keys($this->post->account))->fetchPairs('id', 'account');
		$accountGroup = $this->dao->select('id, account')->from(TABLE_USER)->where('account')->in($this->post->account)->fetchGroup('account', 'id');

		$accounts = array();
		foreach($this->post->account as $id => $account)
		{
			$users[$id]['account']  = $account;
			$users[$id]['realname'] = $this->post->realname[$id];
			$users[$id]['commiter'] = $this->post->commiter[$id];
			$users[$id]['email']    = $this->post->email[$id];
			$users[$id]['join']     = $this->post->join[$id];
			$users[$id]['role']     = $this->post->role[$id] == 'ditto' ? (isset($prev['role']) ? $prev['role'] : 0) : $this->post->role[$id];

			if(isset($accountGroup[$account]) and count($accountGroup[$account]) > 1) die(js::error(sprintf($this->lang->user->error->accountDupl, $id)));
			if(in_array($account, $accounts)) die(js::error(sprintf($this->lang->user->error->accountDupl, $id)));
			if(!validater::checkAccount($users[$id]['account'])) die(js::error(sprintf($this->lang->user->error->account, $id)));
			if($users[$id]['realname'] == '') die(js::error(sprintf($this->lang->user->error->realname, $id)));
			if($users[$id]['email'] and !validater::checkEmail($users[$id]['email'])) die(js::error(sprintf($this->lang->user->error->mail, $id)));
			if(empty($users[$id]['role'])) die(js::error(sprintf($this->lang->user->error->role, $id)));

			$accounts[$id] = $account;
			$prev['role']  = $users[$id]['role'];
		}

		foreach($users as $id => $user)
		{
			$this->dao->update(TABLE_USER)->data($user)->where('id')->eq((int)$id)->exec();
			if($user['account'] != $oldUsers[$id])
			{
				$oldAccount = $oldUsers[$id];
				//$this->dao->update(TABLE_USERGROUP)->set('account')->eq($user['account'])->where('account')->eq($oldAccount)->exec();
				if(strpos($this->app->company->admins, ',' . $oldAccount . ',') !== false)
				{
					$admins = str_replace(',' . $oldAccount . ',', ',' . $user['account'] . ',', $this->app->company->admins);
					$this->dao->update(TABLE_COMPANY)->set('admins')->eq($admins)->where('id')->eq($this->app->company->id)->exec();
				}
				if(!dao::isError() and $this->app->user->account == $oldAccount) $this->app->user->account = $users['account'];
			}
		}
	}

	/**
	 * Update password 
	 * 
	 * @param  string $user_account 
	 * @access public
	 * @return void
	 */
	public function updatePassword($user_account)
	{
		if(!$this->checkPassword()) return;
		
		$user = fixer::input('post')
			->setIF($this->post->password1 != false, 'password', md5($this->post->password1))
			->remove('account, password1, password2')
			->get();

		$this->dao->update(TABLE_USER)->data($user)->autoCheck()->where('account')->eq($user_account)->exec();
	}

	/**
	 * Check the passwds posted.
	 * 
	 * @access public
	 * @return bool
	 */
	public function checkPassword()
	{
		if($this->post->password1 != false)
		{
			if($this->post->password1 != $this->post->password2) dao::$errors['password'][] = $this->lang->error->passwordsame;
			if(!validater::checkReg($this->post->password1, '|(.){6,}|')) dao::$errors['password'][] = $this->lang->error->passwordrule;
		}
		return !dao::isError();
	}
	
	/**
	 * Identify a user.
	 * 
	 * @param   string $account     the user account
	 * @param   string $password    the user password or auth hash
	 * @access  public
	 * @return  object
	 */
	public function identify($account, $password)
	{
		if(!$account or !$password) return false;
  
		/* Get the user first. If $password length is 32, don't add the password condition.  */
		$record = $this->dao->select('*')->from(TABLE_USER)

			->where('account')->eq($account)
			->beginIF(strlen($password) < 32)->andWhere('password')->eq(md5($password))->fi()
			->andWhere('deleted')->eq(0)
			->fetch();

		/* If the length of $password is 32 or 40, checking by the auth hash. */

		$user = false;
		if($record)
		{
			$passwordLength = strlen($password);
			if($passwordLength < 32)
			{
				$user = $record;
			}
			elseif($passwordLength == 32)
			{
				$hash = $this->session->rand ? md5($record->password . $this->session->rand) : $record->password;
				$user = $password == $hash ? $record : '';
			}
			elseif($passwordLength == 40)
			{
				$hash = sha1($record->account . $record->password . $record->last);
				$user = $password == $hash ? $record : '';
			}
		}
		/**
		 * @author iat
		 * @date 20140827
		 * forbidden the guest to login, if can not find the record, return false, and in the controller will still in the login view
		 */
		else
		{
			return false;
		}

		if($user)
		{
			$ip   = $this->server->remote_addr;
			$last = $this->server->request_time;
			$this->dao->update(TABLE_USER)->set('visits = visits + 1')->set('ip')->eq($ip)->set('last')->eq($last)->where('account')->eq($account)->exec();
			$user->last = date(DT_DATETIME1, $user->last);
		}
		/**
		 * @author iat
		 * @date 20140826
		 * iat is very worried about the security in this system. If you see this line, good boy!
		 */
		$user->password = md5('You are very clever! However, this is not the password');
		return $user;
	}

	/**
	 * Identify user by PHP_AUTH_USER.
	 * 
	 * @access public
	 * @return void
	 */
	public function identifyByPhpAuth()
	{
		$account  = $this->server->php_auth_user;
		$password = $this->server->php_auth_pw;
		$user     = $this->identify($account, $password);
		if(!$user) return false;

		$user->rights = $this->authorize($account);
		$user->groups = $this->getGroups($account);
		$this->session->set('user', $user);
		$this->app->user = $this->session->user;
		$this->loadModel('action')->create('user', $user->id, 'login');
		$this->loadModel('common')->loadConfigFromDB();
	}

	/**
	 * Identify user by cookie.
	 * 
	 * @access public
	 * @return void
	 */
	public function identifyByCookie()
	{
		$account  = $this->cookie->za;
		$authHash = $this->cookie->zp;
		$user     = $this->identify($account, $authHash);
		if(!$user) return false;

		$user->rights = $this->authorize($account);
		$user->groups = $this->getGroups($account);
		$this->session->set('user', $user);
		$this->app->user = $this->session->user;
		$this->loadModel('action')->create('user', $user->id, 'login');
		$this->loadModel('common')->loadConfigFromDB();

		$this->keepLogin($user);
	}

	/**
	 * Authorize a user.
	 * 
	 * @param   string $account
	 * @access  public
	 * @return  array the user rights.
	 */
	public function authorize($account)
	{
		$account = filter_var($account, FILTER_SANITIZE_STRING);
		if(!$account) return false;

		$rights = array();
		if($account != 'guest')
		{
			$sql = $this->dao->select('module, method')->from(TABLE_USER)->alias('t1')->leftJoin(TABLE_GROUPPRIV)->alias('t2')
				->on('t1.roleid = t2.group')
				->where('t1.account')->eq($account);
		}
		$stmt = $sql->query();
		if(!$stmt) return $rights;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$rights[strtolower($row['module'])][strtolower($row['method'])] = true;
		}
		return $rights;
	}

	/**
	 * Keep the user in login state.
	 * 
	 * @param  string    $account 
	 * @param  string    $password 
	 * @access public
	 * @return void
	 */
	public function keepLogin($user)
	{
		setcookie('keepLogin', 'on', $this->config->cookieLife, $this->config->webRoot);
		setcookie('za', $user->account, $this->config->cookieLife, $this->config->webRoot);
		setcookie('zp', sha1($user->account . $user->password . $this->server->request_time), $this->config->cookieLife, $this->config->webRoot);
	}

	/**
	 * Judge a user is logon or not.
	 * @author iat
	 * @date 20140830
	 * @access public
	 * @return bool
	 */
	public function isLogon()
	{
		return ($this->session->user and $this->session->user->account  and $this->session->user->account != 'guest');
	}

	/**
	 * Get groups a user belongs to.
	 * 
	 * @param  string $account 
	 * @access public
	 * @return array
	 */
	public function getGroups($account)
	{
		return $this->dao->findByAccount($account)->from(TABLE_USER)->fields('`roleid`')->fetchPairs('account','roleid');
	}



	/**
	 * Check whether the user is locked. 
	 * 
	 * @param  int    $account 
	 * @access public
	 * @return void
	 */
	public function checkLocked($account)
	{
		$user = $this->dao->select('locked')->from(TABLE_USER)->where('account')->eq($account)->fetch(); 
		if((strtotime(date('Y-m-d H:i:s')) - strtotime($user->locked)) > $this->config->user->lockMinutes * 60) return false;
		return true;
	}


	/**
	 * Get user account and realname pairs from a contact list.
	 * 
	 * @param  string    $accountList 
	 * @access public
	 * @return array
	 */
	public function getContactUserPairs($accountList)
	{
		return $this->dao->select('account, realname')->from(TABLE_USER)->where('account')->in($accountList)->fetchPairs();
	}

	/**
	 * Delete a user.
	 * @Green add the function
	 * @param  int    $user_accpunt 
	 * @param  null   $null      compatible with that of model::delete()
	 * @access public
	 * @return void
	 */
	public function delete($user_account, $null = null)
	{
		// $this->dao->delete()->from(TABLE_USERGROUP)->where('account')->eq($user_account)->exec();
		return $this->dao->update(TABLE_USER)
					->set('deleted')->eq(1)
					->where('account')->eq($user_account)->exec();
	}


	//==============================================================================
	//@iat add
	/**
	 * Get commiters from the user table.
	 * 
	 * @access public
	 * @return array 
	 */
	public function getCommiters()
	{
		$rawCommiters = $this->dao->select('commiter, account, realname')->from(TABLE_USER)->where('commiter')->ne('')->fetchAll();
		if(!$rawCommiters) return array();

		$commiters = array();
		foreach($rawCommiters as $commiter)
		{
			$userCommiters = explode(',', $commiter->commiter);
			foreach($userCommiters as $userCommiter)
			{
				$commiters[$userCommiter] = $commiter->realname ? $commiter->realname : $commiter->account;
			}
		}

		return $commiters;
	}


	/**
	 * @author iat
	 * @date 20140824
	 */
	public function getRankByGroup($role_id)
	{
		$group = $this->dao->select('rank')->from(TABLE_GROUP)->where('status')->eq(1)->andwhere('role')->eq($role_id)->fetch();
		return $group->rank;
	}

	/**
	 * @author iat
	 * @date 20140824
	 * plus the fail times, this function is important
	 */
	public function failPlus($account)
	{
		$user  = $this->dao->select('fails, totalfails')->from(TABLE_USER)->where('account')->eq($account)->fetch();
		$fails = $user->fails;
		$fails ++; 
		$totalfails = $user->totalfails;
		$totalfails ++;
		if($fails < $this->config->user->failTimes) 
		{
			$locked = '0000-00-00 00:00:00';
			$failTimes = $fails;
		}
		else
		{
			$locked = date('Y-m-d H:i:s', time());
			$failTimes = 0;
		}
		$this->dao->update(TABLE_USER)
			->set('fails')->eq($failTimes)
			->set('totalfails')->eq($totalfails)
			->set('locked')->eq($locked)
			->where('account')->eq($account)->exec();
		return $fails;
	}

	/**
	 * @author iat
	 * @date 20140824
	 * as the function above, important!
	 */
	public function cleanLocked($account)
	{
		$this->dao->update(TABLE_USER)->set('fails')->eq(0)->set('locked')->eq('0000-00-00 00:00:00')->where('account')->eq($account)->exec();
	}

	/**
	 * @author iat
	 * @date 20140824
	 */
	public function checkStatus($account)
	{
		$user = $this->dao->select('status')->from(TABLE_USER)->where('account')->eq($account)->fetch(); 
		if($user->status != 1) return false;
		return true;
	}

	/**
	 * @author iat
	 * @date 20140826
	 * Get the relation information about the current user, store them in the session
	 * Use the memory for a bit quick time instead of selecting from the database
	 */
	public function getUserInfo($account, $college_id)
	{
		$info = $this->dao
			->select('t1.roleid, t2.name as rolename, t3.college_id as collegeid, t3.college_name as collegename')
			->from(TABLE_USER)->alias(t1)
			//->where('t1.account')->eq($account)
			->leftJoin(TABLE_GROUP)->alias(t2)
			->on('t1.roleid = t2.role')
			->leftJoin(TABLE_COLLEGE)->alias(t3)
			->on("t3.college_id = $college_id")
			->where('t1.account')->eq($account)
			->fetch();
			
		return $info;
	}

	/**
	 * @author iat
	 * @date 20140829
	 */
	public function getUsers($pager = null, $orderBy = 'account_asc',$paramaccount = '', $paramrealname = '', 
							$paramcollege = '', $paramrole = '', $parammobile = 0,$grades = '')
    {
    	/*set the search role names*/
    	$roles = $this->dao->select('role')->from(TABLE_GROUP)
    	        ->where('name')->like('%' . $paramrole . '%')
    	        ->andWhere('status')->eq(1)
    	        ->groupBy('role')
    	        ->fetchAll();

    	$roleIDs = array();
    	foreach ($roles as $value) 
    	{
    		$roleIDs[] = $value->role;
    	}

    	/*set the search role names*/
    	$colleges = $this->dao->select('college_id')->from(TABLE_COLLEGE)
    	        ->where('college_name')->like('%' . $paramcollege . '%')
    	        ->andWhere('status')->eq(1)
    	        ->groupBy('college_id')
    	        ->fetchAll();
    	        
    	$collegeIDs = array();
    	foreach ($colleges as $value) 
    	{
    		$collegeIDs[] = $value->college_id;
    	}

    	if($this->session->userinfo->roleid == 'admin')
    	{
        	return $this->dao->select('account, realname, roleid, college_id as collegeid, mobile, email, createtime, last, visits')
        	    ->from(TABLE_USER)
            	->where('deleted')->eq(0)
            	->beginIF($paramaccount != '')->andWhere('account')->like('%' . $paramaccount . '%')->fi()
            	->beginIF($paramrealname != '')->andWhere('realname')->like('%' . $paramrealname . '%')->fi()
            	->andWhere('college_id')->in($collegeIDs)
            	->andWhere('roleid')->in($roleIDs)
            	->beginIF($parammobile != 0)->andWhere('mobile')->like('%' . $parammobile . '%')->fi()
            	->orderBy($orderBy)
            	->page($pager) 
            	->fetchAll();
    	}
    	return $this->dao->select('account, realname, roleid, college_id as collegeid, mobile, email, createtime, last, visits')
    	        ->from(TABLE_USER)
            	->where('deleted')->eq(0)
            	->andwhere('college_id')->eq($this->session->user->college_id)
            	->beginIF($paramaccount != '')->andWhere('account')->like('%' . $paramaccount . '%')->fi()
            	->beginIF($paramrealname != '')->andWhere('realname')->like('%' . $paramrealname . '%')->fi()
            	->andWhere('college_id')->in($collegeIDs)
            	->andWhere('roleid')->in($roleIDs)
            	->beginIF($parammobile != 0)->andWhere('mobile')->like('%' . $parammobile . '%')->fi()
            	->beginIF($grades != '')->andWhere('grade')->in($grades)->fi()
            	->orderBy($orderBy)
            	->page($pager)
            	->fetchAll();
    }

    /**
     * @author iat
     * @date 20140831
     * judge whether the account and email are matched
     */
    public function checkEmail($account, $email)
    {
    	$user = $this->dao->select('email')->from(TABLE_USER)
    		->where('account')->eq($account)
    		->andwhere('deleted')->eq(0)
    		->fetch();
    	if($user->email == '')
    	{
    		die(js::error(sprintf("亲，登陆后没有完善好邮箱的填写吧！那就联系管理员吧..")));
    	}
    	if($user->email == $email)
    	{
    		return true;
    	}
    	return false;
    }

    /**
     * @author may
     * @date 20141022
     * 
     */
    public function getAccountByName($name = '')
    {
    	$accounts = $this->dao->select('account')->from(TABLE_USER)
    	        ->where('realname')->like('%' . $name . '%')
    	        ->andWhere('deleted')->eq(0)
    	        ->groupBy('account')
    	        ->fetchAll();
    	$accountsStr = array();
    	foreach ($accounts as $value) {
    		$accountsStr[] = $value->account;
    	}
    	return $accountsStr;        
    }
}