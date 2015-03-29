<?php
class commonModel extends model
{
	/**
	 * Start the session.
	 * 
	 * @access public
	 * @return void
	 */
	public function startSession()
	{
		session_name($this->config->sessionVar);
		if(isset($_GET[$this->config->sessionVar])) session_id($_GET[$this->config->sessionVar]);
		session_start();
	}

	/**
	 * Set the header info.
	 * 
	 * @access public
	 * @return void
	 */
	public function sendHeader()
	{
		header("Content-Type: text/html; Language={$this->config->charset}");
		header("Cache-control: private");
	}

	/**
	 * Set the commpany.
	 *
	 * First, search company by the http host. If not found, search by the default domain. Last, use the first as the default. 
	 * After get the company, save it to session.
	 * @access public
	 * @return void
	 */
	public function setCompany()
	{        
		$httpHost = $this->server->http_host;

		if($this->session->company)
		{
			$this->app->company = $this->session->company;
		}
		else
		{
			$company = $this->loadModel('company')->getFirst();
			if(!$company) $this->app->triggerError(sprintf($this->lang->error->companyNotFound, $httpHost), __FILE__, __LINE__, $exit = true);
			$this->session->set('company', $company);
			$this->app->company  = $company;
		}
	}

	/**
	 * Set the user info.
	 * 
	 * @access public
	 * @return void
	 */
	public function setUser()
	{
		if($this->session->user)
		{
			$this->app->user = $this->session->user;
		}
		/*elseif($this->app->company->guest or defined('IN_SHELL'))
		{
			$user             = new stdClass();
			$user->id         = 0;
			$user->account    = 'guest';
			$user->realname   = 'guest';
			$user->role       = 'guest';
			$user->rights     = $this->loadModel('user')->authorize('guest');
			$this->session->set('user', $user);
			$this->app->user = $this->session->user;
		}*/
	}

	/**
	 * Load configs from database and save it to config->system and config->personal.
	 * 
	 * @access public
	 * @return void
	 */
	public function loadConfigFromDB()
	{
		/* Get configs of system and current user. */
		$account = isset($this->app->user->account) ? $this->app->user->account : '';
		if($this->config->db->name) $config  = $this->loadModel('setting')->getSysAndPersonalConfig($account);
		$this->config->system   = isset($config['system']) ? $config['system'] : array();
		$this->config->personal = isset($config[$account]) ? $config[$account] : array();

		/* Overide the items defined in config/config.php and config/my.php. */
		if(isset($this->config->system->common))
		{
			foreach($this->config->system->common as $record)
			{
				if($record->section)
				{
					if(!isset($this->config->{$record->section})) $this->config->{$record->section} = new stdclass();
					$this->config->{$record->section}->{$record->key} = $record->value;
				}
				else
				{
					if(!$record->section) $this->config->{$record->key} = $record->value;
				}
			}
		}
	}
	
	/**
	 * Juage a method of one module is open or not?
	 * 
	 * @param  string $module 
	 * @param  string $method 
	 * @access public
	 * @return bool
	 */
	public function isOpenMethod($module, $method)
	{
		if($module == 'user' and strpos('login|logout|deny|captcha', $method) !== false) return true;
		if($module == 'api'  and $method == 'getsessionid') return true;
		if($module == 'misc' and $method == 'ping') return true;
		//@Green delete

		if($this->loadModel('user')->isLogon())
		{
			if(stripos($method, 'ajax') !== false) return true;
			if(stripos($method, 'downnotify') !== false) return true;
		}

		if(stripos($method, 'ajaxgetdropmenu') !== false and $this->app->user->account == 'guest') return true;
		if(stripos($method, 'ajaxgetmatcheditems') !== false and $this->app->user->account == 'guest') return true;
		if($method == 'ajaxgetdetail' and $this->app->viewType == 'mhtml') return true;
		if($module == 'misc' and $method == 'qrcode') return true;
		if($module == 'misc' and $method == 'about') return true;
		if($module == 'misc' and $method == 'checkupdate') return true;
		return false;
	}

	/**
	 * Deny access.
	 * 
	 * @access public
	 * @return void
	 */
	public function deny($module, $method)
	{
		$vars = "module=$module&method=$method";
		if(isset($this->server->http_referer))
		{
			$referer = helper::safe64Encode($this->server->http_referer);
			$vars   .= "&referer=$referer";
		}
		$denyLink = helper::createLink('user', 'deny', $vars);

		/* Fix the bug of IE: use js locate, can't get the referer. */
		if(strpos($this->server->http_user_agent, 'MSIE') !== false)
		{
			echo "<a href='$denyLink' id='denylink' style='display:none'>deny</a>";
			echo "<script language='javascript'>document.getElementById('denylink').click();</script>";
		}
		else
		{
			echo js::locate($denyLink);
		}
		exit;
	}

	/**
	 * Get the run info.
	 * 
	 * @param mixed $startTime  the start time of this execution
	 * @access public
	 * @return array    the run info array.
	 */
	public function getRunInfo($startTime)
	{
		$info['timeUsed'] = round(getTime() - $startTime, 4) * 1000;
		$info['memory']   = round(memory_get_peak_usage() / 1024, 1);
		$info['querys']   = count(dao::$querys);
		return $info;
	}

	/**
	 * @author iat
	 * @date 20140827
	 * modify the showing in the right top corner
	 */
	public static function printTopBar()
	{
		global $lang, $app;

		if(isset($app->user))
		{
			$isGuest = $app->user->account == 'guest';
			echo "<div class='dropdown' id='userMenu'>";
			echo "<a href='javascript:;' data-toggle='dropdown'><i class='icon-user'></i> " . $app->user->realname . " <span class='caret'></span></a>";
			echo "<ul class='dropdown-menu'>";
				echo "<li class='dropdown-submenu'>";
					echo "<a href='javascript:;'>" . $lang->help . "</a>";
				echo "</li>";
				echo "<li class='dropdown-submenu'>";
					echo "<a href='mailto:$lang->systemMail;'>" . $lang->feedback . "</a>";
				echo "</li>";
				echo "<li class='dropdown-submenu'>";
					echo "<a href='mailto:$lang->systemMail;'>" . $lang->bugReport . "</a>";
				echo '</li>';
				echo "<li class='dropdown-submenu'>";
					echo "<a href='javascript:;'>" . $lang->theme . "</a><ul class='dropdown-menu'>";
					foreach ($app->lang->themes as $key => $value)
					{
						echo "<li class='theme-option" . ($app->cookie->theme == $key ? " active" : '') . "'><a href='javascript:selectTheme(\"$key\");' data-value='" . $key . "'>" . $value . "</a></li>";
					}
				echo '</ul></li>';
			echo '</ul></div>';
			echo "<a href='javascript:;'>" . $app->user->collegename ."</a>";
			echo "<a href='javascript:;'>" . $app->user->rolename ."</a>";
			if($isGuest)
			{
				echo html::a(helper::createLink('user', 'login'), $lang->login);
			}
			else
			{
				echo html::a(helper::createLink('user', 'logout'), $lang->logout);
			}
		}
	}

	/**
	 * Set mobile menu.
	 * 
	 * @access public
	 * @return void
	 */
	public function setMobileMenu()
	{
		$menu = new stdclass();
		
		$role = isset($this->app->user->role) ? $this->app->user->role : '';

		$this->config->locate = new stdclass();
		$this->config->locate->module = 'my';
		$this->config->locate->method = 'todo';
		$this->config->locate->params = '';

		$todo    = $this->lang->my->menu->todo['link'];
		$task    = $this->lang->my->menu->task['link'];
		$story   = $this->lang->my->menu->story['link'];
		$project = $this->lang->menu->project . '|locate=no&&status=isdoing';
		$product = $this->lang->menu->product . '|locate=no';

		if($role == 'dev' or $role == 'td' or $role == 'pm')
		{
			$menu = array('todo' => $todo, 'task' => $task, 'product' => $product, 'project' => $project);
		}
		elseif($role == 'pd' or $role == 'po')
		{
			$menu = array('todo' => $todo, 'story' => $story, 'product' => $product, 'project' => $project);
		}
		elseif($role == 'qa' or $role == 'qd')
		{
			$menu = array('todo' => $todo, 'project' => $project, 'product' => $product);
		}
		elseif($role == 'top')
		{
			$menu = array('project' => $project, 'product' => $product, 'todo' => $todo);

			$this->config->locate->module = 'project';
			$this->config->locate->method = 'index';
			$this->config->locate->params = 'locate=no&status=doing';
		}
		else
		{
			$menu = array('todo' => $todo, 'task' => $task, 'project' => $project, 'product' => $product);
		}

		unset($this->lang->menuOrder);
		unset($this->lang->menugroup);
		$this->lang->menu = new stdclass();
		$this->lang->menu = $menu;
	}

	/**
	 * Print the main menu.
	 * 
	 * @param  string $moduleName 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function printMainmenu($moduleName, $methodName = '')
	{
		global $app, $lang;
		echo "<ul class='nav'>\n";
 
		/* Set the main main menu. */
		$mainMenu = $moduleName;
		if(isset($lang->menugroup->$moduleName)) $mainMenu = $lang->menugroup->$moduleName;
		if($app->getViewType() == 'mhtml')
		{
			if($moduleName == 'my')   $mainMenu = $methodName;
			if($moduleName == 'todo') $mainMenu = $moduleName;
			if($moduleName == 'story' and !isset($lang->menu->story)) $mainMenu = 'product';
			//@Green delete one line
			if($moduleName == 'task'  and !isset($lang->menu->task))  $mainMenu = 'project';
		}

		/* Sort menu according to menuOrder. */
		if(isset($lang->menuOrder))
		{
			$menus = $lang->menu;
			$lang->menu = new stdclass();

			// ksort($lang->menuOrder, SORT_ASC);
			foreach($lang->menuOrder as $key)  
			{
				$menu = $menus->$key; 
				unset($menus->$key);
				$lang->menu->$key = $menu;
			}
			foreach($menus as $key => $menu)
			{
				$lang->menu->$key = $menu; 
			}
		}

		$activeName = $app->getViewType() == 'mhtml' ? 'ui-btn-active' : 'active';
		/* Print all main menus. */
		foreach($lang->menu as $menuKey => $menu)
		{
			if ($menu != '')
			{
				$active = $menuKey == $mainMenu ? "class='$activeName'" : '';
				$link = explode('|', $menu);
				list($menuLabel, $module, $method) = $link;
				$vars = isset($link[3]) ? $link[3] : '';

				if(common::hasPriv($module, $method))
				{
					$link  = helper::createLink($module, $method, $vars);

					// @Tony 这里是一级菜单
					echo "<li $active><a href='$link' $active id='menu$menuKey'>$menuLabel</a></li>\n";
				}
			}
		}
		echo "</ul>\n";
	}


	/**
	 * Print the module menu.
	 * 
	 * @param  string $moduleName 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function printModuleMenu($moduleName)
	{
		global $lang, $app;

		if(!isset($lang->$moduleName->menu)) {echo "<ul></ul>"; return;}

		/* Unset clearData menu when the data of pms is demo. */
		if(!isset($app->config->global->showDemoUsers) or !$app->config->global->showDemoUsers) unset($lang->admin->menu->clearData);

		/* Get the sub menus of the module, and get current module and method. */
		$submenus      = $lang->$moduleName->menu;  
		$currentModule = $app->getModuleName();
		$currentMethod = $app->getMethodName();

		/* Sort the subMenu according to menuOrder. */
		if(isset($lang->$moduleName->menuOrder))
		{
			$menus = $submenus;
			$submenus = new stdclass();

			ksort($lang->$moduleName->menuOrder, SORT_ASC);
			if(isset($menus->list)) 
			{
				$submenus->list = $menus->list; 
				unset($menus->list);
			}
			foreach($lang->$moduleName->menuOrder as $order)  
			{
				if(($order != 'list') && isset($menus->$order))
				{
					$subOrder = $menus->$order;
					unset($menus->$order);
					$submenus->$order = $subOrder;
				}
			}
			foreach($menus as $key => $menu)
			{
				$submenus->$key = $menu; 
			}
		}

		/* The beginning of the menu. */
		echo "<ul class='nav'>\n";

		/* Cycling to print every sub menus. */
		foreach($submenus as $subMenuKey => $submenu)
		{
			/* Init the these vars. */
			$link      = $submenu;
			$subModule = '';
			$alias     = '';
			$float     = '';
			$active    = '';
			$target    = '';

			if(is_array($submenu)) extract($submenu);   // If the sub menu is an array, extract it.

			/* Print the menu. */
			if(strpos($link, '|') === false)
			{
				echo "<li>$link</li>\n";
			}
			else
			{
				$link = explode('|', $link);
				list($label, $module, $method) = $link;
				$vars = isset($link[3]) ? $link[3] : '';
				if(common::hasPriv($module, $method))
				{
					/* Is the currentModule active? */
					$subModules = explode(',', $subModule);
					if(in_array($currentModule,$subModules) and $float != 'right') $active = 'active';
					if($module == $currentModule and (strtolower($method) == $currentMethod or strpos(",$alias,", ",$currentMethod,") !== false) and $float != 'right') $active = 'active';

					// @Tony 这里是二级菜单
					echo "<li class='$float $active'>" . html::a(helper::createLink($module, $method, $vars), $label, $target, "id=submenu$subMenuKey") . "</li>\n";
				}
			}
		}
		echo "</ul>\n";
	}

	/**
	 * Print the bread menu.
	 * 
	 * @param  string $moduleName 
	 * @param  string $position 
	 * @static
	 * @access public
	 * @return void
	 */

	// @Tony 删除页面下方所有无用按钮
	public static function printBreadMenu($moduleName, $position)
	{
		global $lang;
		$mainMenu = $moduleName;
		// if(isset($lang->menugroup->$moduleName)) $mainMenu = $lang->menugroup->$moduleName;
	   
		// @Tony 删除首页左下方无用按钮
		echo html::a(helper::createLink('my', 'index'), $lang->systemName) . $lang->arrow;
		
		/*if($moduleName != 'index')
		{
			if(!isset($lang->menu->$mainMenu)) return;
			list($menuLabel, $module, $method) = explode('|', $lang->menu->$mainMenu);
			
			// @Tony 删除首页左下方无用按钮
			echo html::a(helper::createLink($module, $method), $menuLabel);
		}
		else
		{
			echo $lang->index->common;
		}
		if(empty($position)) return;
		echo $lang->arrow;
		foreach($position as $key => $link)
		{
			echo $link;
			if(isset($position[$key + 1])) echo $lang->arrow;
		}*/
	}

	/**
	 * Print the link for notify file.
	 * 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function printNotifyLink()
	{
		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
		{
			global $app, $lang;
			$notifyFile = $app->getBasePath() . 'www/data/notify/notify.zip';

			if(!file_exists($notifyFile)) return false;
			echo html::a(helper::createLink('misc', 'downNotify'), "<i class='icon-bell'></i>", '', "title='$lang->downNotify'") . ' &nbsp; ';
		}
	}

	/**
	 * Print QR code Link. 
	 * 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function printQRCodeLink($color = '')
	{
		global $lang;
		
		// @Tony 二维码，今后可能有用
		// echo html::a('javascript:;', "<i class='icon-qrcode'></i>", '', "class='qrCode $color' id='qrcodeBtn' title='{$lang->user->mobileLogin}'");
		
		echo "<div class='popover top' id='qrcodePopover'><div class='arrow'></div><h3 class='popover-title'>{$lang->user->mobileLogin}</h3><div class='popover-content'><img src=\"" . helper::createLink('misc', 'qrCode') . "\"></div></div>";
		echo '<script>$(function(){$("#qrcodeBtn").click(function(){$("#qrcodePopover").toggleClass("show");}); $("#wrap").click(function(){$("#qrcodePopover").removeClass("show");});});</script>';
	}

	/**
	 * Diff two string. (see phpt)
	 * 
	 * @param string $text1 
	 * @param string $text2 
	 * @static
	 * @access public
	 * @return string
	 */
	public static function diff($text1, $text2)
	{
		$text1 = str_replace('&nbsp;', '', trim($text1));
		$text2 = str_replace('&nbsp;', '', trim($text2));
		$w  = explode("\n", $text1);
		$o  = explode("\n", $text2);
		$w1 = array_diff_assoc($w,$o);
		$o1 = array_diff_assoc($o,$w);
		$w2 = array();
		$o2 = array();
		foreach($w1 as $idx => $val) $w2[sprintf("%03d<",$idx)] = sprintf("%03d- ", $idx+1) . "<del>" . trim($val) . "</del>";
		foreach($o1 as $idx => $val) $o2[sprintf("%03d>",$idx)] = sprintf("%03d+ ", $idx+1) . "<ins>" . trim($val) . "</ins>";
		$diff = array_merge($w2, $o2);
		ksort($diff);
		return implode("\n", $diff);
	}

	/**
	 * Judge Suhosin Setting whether the actual size of post data is large than the setting size.
	 * 
	 * @param  int    $numberOfItems 
	 * @param  int    $columns 
	 * @access public
	 * @return void
	 */
	public function judgeSuhosinSetting($numberOfItems, $columns)
	{
		if(extension_loaded('suhosin'))
		{
			$maxPostVars    = ini_get('suhosin.post.max_vars');
			$maxRequestVars = ini_get('suhosin.request.max_vars');
			if($numberOfItems * $columns > $maxPostVars or $numberOfItems * $columns > $maxRequestVars) return true;
		}

		return false;
	}

	/**
	 * Get the previous and next object.
	 * 
	 * @param  string $type story|task|bug|case
	 * @param  string $objectIDs 
	 * @param  string $objectID 
	 * @access public
	 * @return void
	 */
	public function getPreAndNextObject($type, $objectID)
	{
		$preAndNextObject = new stdClass();

		$table = $this->config->objectTables[$type];
		/* Get objectIDs. */
		$queryCondition    = $type . 'QueryCondition';
		$typeOnlyCondition = $type . 'OnlyCondition';
		$queryCondition = $this->session->$queryCondition;
		$orderBy = $type . 'OrderBy';
		$orderBy = $this->session->$orderBy;
		$orderBy = str_replace('`left`', 'left', $orderBy); // process the `left` to left.
		if(empty($queryCondition) or $this->session->$typeOnlyCondition)
		{
			$objects = $this->dao->select('*')->from($table)
				->where('id')->eq($objectID)
				->beginIF($queryCondition != false)->orWhere($queryCondition)->fi()
				->beginIF($orderBy != false)->orderBy($orderBy)->fi()
				->fetchAll();
		}
		else
		{
			$objects = $this->dbh->query($queryCondition . " ORDER BY $orderBy")->fetchAll();
		}

		$tmpObjectIDs = array();
		foreach($objects as $key => $object) $tmpObjectIDs[$key] = (!$this->session->$typeOnlyCondition and isset($object->case)) ? $object->case : $object->id;//@Green delete
		$objectIDs = array_flip($tmpObjectIDs);

		/* Current object. */
		$currentKey = array_search($objectID, $tmpObjectIDs);
		$preKey = $currentKey - 1;
		$preAndNextObject->pre = '';
		if($preKey >= 0) 
		{
			$preID = $tmpObjectIDs[$preKey];
			$preAndNextObject->pre = $objects[$objectIDs[$preID]];
		}
		/* Get the next object. */
		$nextKey = $currentKey + 1;
		$preAndNextObject->next = '';
		if($nextKey < count($tmpObjectIDs)) 
		{
			$nextID = $tmpObjectIDs[$nextKey];
			$preAndNextObject->next = $objects[$objectIDs[$nextID]];
		}
		return $preAndNextObject;
	}

	/**
	 * Save one executed query.
	 * 
	 * @param  string    $sql 
	 * @param  string    $objectType story|task|bug
	 * @access public
	 * @return void
	 */
	public function saveQueryCondition($sql, $objectType, $onlyCondition = true)
	{
		/* Set the query condition session. */
		if($onlyCondition)
		{
			$queryCondition = explode('WHERE', $sql);
			$queryCondition = explode('ORDER', $queryCondition[1]);
			$queryCondition = str_replace('t1.', '', $queryCondition[0]);
		}
		else
		{
			$queryCondition = explode('ORDER', $sql);
			$queryCondition = $queryCondition[0];
		}
		$queryCondition = trim($queryCondition);
		if(empty($queryCondition)) $queryCondition = "1=1";
		$this->session->set($objectType . 'QueryCondition', $queryCondition);
		$this->session->set($objectType . 'OnlyCondition', $onlyCondition);

		/* Set the query condition session. */
		$orderBy = explode('ORDER BY', $sql);
		if(isset($orderBy[1]))
		{
			$orderBy = explode('limit', $orderBy[1]);
			$orderBy = str_replace('t1.', '', $orderBy[0]);

			$this->session->set($objectType . 'OrderBy', $orderBy);
		}
		else
		{
			$this->session->set($objectType . 'OrderBy', '');
		}
	}

	/**
	 * 学生获取和自己有相同导师的同伴（一个相同老师及以上）　
	 */
	public function getTeamByStudent($user='')
	{
		if(!$user) $user = $this->session->user->account;
		
		/**
		 * @author iat 
		 * @date 20140826
		 * Just take the following for example. 
		 * First, get the teachers the current user has
		 * Second, get the students'accounts in the relation with the teachers
		 * Third, get the realnames from the table USER
		 */
		$teachers = $this->dao
			->select('t1.tea_ID')->from(TABLE_RELATIONS)->alias(t1)
			->where('t1.stu_ID')->eq($user)
			->andwhere('t1.deleted')->eq(0)
			->fetchPairs();

		$students = $this->dao
			->select('t2.stu_ID, t3.realname')->from(TABLE_RELATIONS)->alias(t2)
			->leftjoin(TABLE_USER)->alias(t3)
			->on('t2.stu_ID = t3.account')
			->where('t2.tea_ID')->IN($teachers)
			->andwhere('t2.deleted')->eq(0)
			->andwhere('t3.deleted')->eq(0)
			->andwhere('t2.stu_ID')->ne($user)
			->fetchPairs();


	    return $students;
	}
	
	/**
	 * 根据学院id获取学院的名称
	 */
	public function getCollegeById($collegeId = '')
	{
		if (!$collegeId)  $collegeId = $this->session->user->college_id;

		$college = $this->dao->select('*')
						->from(TABLE_COLLEGE)
						->where('college_id')->eq($collegeId)
						->fetch();
		if ($college->deleted) 
		{
			return;
		}
		else
		{
			return $college->college_name;
		}
	}
}
