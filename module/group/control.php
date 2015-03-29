<?php
class group extends control
{
	/**
	 * Construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('company')->setMenu();
		$this->loadModel('user');
	}

	/**
	 * Browse groups.
	 * 
	 * @param  int    $companyID 
	 * @access public
	 * @return void
	 */
	public function browse($companyID = 0)
	{
		if($companyID == 0) $companyID = $this->app->company->id;

		$groups = $this->group->getList($companyID);
		$groupUsers = array();
		foreach($groups as $group) $groupUsers[$group->role] = array_slice($this->group->getUserPairs($group->role), 0, 15);

		$this->view->groups     = $groups;
		$this->view->groupUsers = $groupUsers;

		$this->display();
	}

	/**
	 * Create a group.
	 * 
	 * @access public
	 * @return void
	 */
	public function create()
	{
		if(!empty($_POST))
		{
			$this->group->create();
			if(dao::isError()) die(js::error(dao::getError()));
			die(js::locate($this->createLink('group', 'browse'), 'parent'));
		}

		$this->view->title = $this->lang->company->orgView . $this->lang->colon . $this->lang->group->create;
		$this->display();
	}

	/**
	 * Edit a group.
	 * 
	 * @param  int    $role_name 
	 * @access public
	 * @return void
	 */
	public function edit($role_name)
	{
	   if(!empty($_POST))
		{
			$this->group->update($role_name);
			die(js::locate($this->createLink('group', 'browse'), 'parent'));
		}

		$title      = $this->lang->company->orgView . $this->lang->colon . $this->lang->group->edit;
		$position[] = $this->lang->group->edit;
		$this->view->title    = $title;
		$this->view->position = $position;
		$this->view->group    = $this->group->getById($role_name);

		$this->display();
	}

	/**
	 * Copy a group.
	 * 
	 * @param  int    $role_name 
	 * @access public
	 * @return void
	 */
	public function copy($role_name)
	{
	   if(!empty($_POST))
		{
			$this->group->copy($role_name);
			if(dao::isError()) die(js::error(dao::getError()));
			if(isonlybody()) die(js::closeModal('parent.parent', 'this'));
			die(js::locate($this->createLink('group', 'browse'), 'parent'));
		}

		$this->view->title      = $this->lang->company->orgView . $this->lang->colon . $this->lang->group->copy;
		$this->view->position[] = $this->lang->group->copy;
		$this->view->group      = $this->group->getById($role_name);
		$this->display();
	}

	/**
	 * Manage privleges of a group. 
	 * 
	 * @param  int    $role_name 
	 * @access public
	 * @return void
	 */
	public function managePriv($type = 'byGroup', $param = 0, $menu = '', $version = '')
	{
		if($type == 'byGroup') $role_name = $param;

		$this->view->type = $type;
		foreach($this->lang->resource as $moduleName => $action)
		{
			if($this->group->checkMenuModule($menu, $moduleName) or $type != 'byGroup') $this->app->loadLang($moduleName);
		}

		if(!empty($_POST))
		{

			if($type == 'byGroup')  $result = $this->group->updatePrivByGroup($role_name, $menu, $version);
			if($type == 'byModule') $result = $this->group->updatePrivByModule();
			print(js::alert($result ? $this->lang->group->successSaved : $this->lang->group->errorNotSaved));
			exit;
		}

		if($type == 'byGroup')
		{
			$this->group->sortResource();
			$group      = $this->group->getById($role_name);
			$groupPrivs = $this->group->getPrivs($role_name);

			$this->view->title      = $this->lang->company->common . $this->lang->colon . $group->name . $this->lang->colon . $this->lang->group->managePriv;
			$this->view->position[] = $group->name;
			$this->view->position[] = $this->lang->group->managePriv;

			/* Join changelog when be equal or greater than this version.*/
	/*		$realVersion = str_replace('_', '.', $version);
			$changelog = array();
			foreach($this->lang->changelog as $currentVersion => $currentChangeLog)
			{
				if(version_compare($currentVersion, $realVersion, '>=')) $changelog[] = join($currentChangeLog, ',');
			}*/
			$this->view->group      = $group;
			$this->view->changelogs = ',' . join($changelog, ',') . ',';
			$this->view->groupPrivs = $groupPrivs;
			$this->view->role_name    = $role_name;
			$this->view->menu       = $menu;
			//$this->view->version    = $version;
		}
		elseif($type == 'byModule')
		{
			$this->group->sortResource();
			$this->view->title      = $this->lang->company->common . $this->lang->colon . $this->lang->group->managePriv;
			$this->view->position[] = $this->lang->group->managePriv;

			foreach($this->lang->resource as $module => $moduleActions)
			{
				$modules[$module] = $this->lang->$module->common;
				foreach($moduleActions as $action)
				{
					$actions[$module][$action] = $this->lang->$module->$action;
				}
			}
			$this->view->groups  = $this->group->getPairs();
			$this->view->modules = $modules;
			$this->view->actions = $actions;
		}
		$this->display();
	}

	/**
	 * Manage members of a group.
	 * 
	 * @param  int    $role_name 
	 * @access public
	 * @return void
	 */
	public function manageMember($role_name)
	{
		if(!empty($_POST))
		{
			$this->group->updateUser($role_name);
			if(isonlybody()) die(js::closeModal('parent.parent', 'this'));
			die(js::locate($this->createLink('group', 'browse'), 'parent'));
		}
		$group      = $this->group->getById($role_name);
		$groupUsers = $this->group->getUserPairs($role_name);
		$allUsers   = $this->user->getPairs('nodeleted|noclosed|noempty|noletter');
		$otherUsers = array_diff_assoc($allUsers, $groupUsers);

		$title      = $this->lang->company->common . $this->lang->colon . $group->name . $this->lang->colon . $this->lang->group->manageMember;
		$position[] = $group->name;
		$position[] = $this->lang->group->manageMember;

		$this->view->title      = $title;
		$this->view->position   = $position;
		$this->view->group      = $group;
		$this->view->groupUsers = $groupUsers;
		$this->view->otherUsers = $otherUsers;

		$this->display();
	}

	/**
	 * Delete a group.
	 * 
	 * @param  int    $role_name 
	 * @param  string $confirm  yes|no
	 * @access public
	 * @return void
	 */
	public function delete($role_name, $confirm = 'no')
	{
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->group->confirmDelete, $this->createLink('group', 'delete', "role_name=$role_name&confirm=yes")));
		}
		else
		{
			$this->group->delete($role_name);

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
			die(js::locate($this->createLink('group', 'browse'), 'parent'));
		}
	}
}
