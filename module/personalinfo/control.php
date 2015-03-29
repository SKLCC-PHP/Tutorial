<?php
/**
 * @author iat
 * @date 20140825
 * modify the old function
 */
class personalinfo extends control
{
	/**
	 * Construct function, load user, tree, action auto.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('user');
	}

	/**
	 * Go to browse page.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->locate(inlink('viewBasicInformation'));
	}

	/**
	 * Change password 
	 * 
	 * @access public
	 * @return void
	 */
	public function changePassword()
	{
		/* Set menu, save session. */
		$this->personalinfo->setMenu();

		if(!empty($_POST))
		{
			$this->user->updatePassword($this->app->user->account);
			if(dao::isError()) die(js::error(dao::getError()));
			die(js::locate($this->createLink('personalinfo', 'viewBasicInformation'), 'parent'));
		}

		$this->view->position[] = $this->lang->my->changePassword;
		$this->view->user       = $this->user->getByAccount($this->app->user->account);

		$this->display();
	}

	/**
	 * Edit profile 
	 * 
	 * @access public
	 * @return void
	 */
	public function editBasicInformation()
	{
		$collegelist = $this->personalinfo->getCollegeList();

		//init the years
		for($i = 0;$i < 6;$i++)
		{
			$years[date('Y')-$i] = date('Y')-$i;
		}

		if(!empty($_POST))
		{
			$qq_rule = '/^([0-9]{5,15})$/';
			$mobile_rule = '/^([0-9]{11})$/';

			if($_POST['qq'] != '' && !preg_match($qq_rule, $_POST['qq']))
			{
				die(js::error('qq格式不正确！'));
			}
			if($_POST['mobile'] != '' && !preg_match($mobile_rule, $_POST['mobile']))
			{
				die(js::error('手机格式不正确！'));
			}
    		
			$this->user->update($this->app->user->account);
			if(dao::isError()) die(js::error(dao::getError()));
			die(js::locate($this->createLink('personalinfo', 'viewBasicInformation'), 'parent'));
		}

		$this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->editBasicInformation;
		$this->view->position[] = $this->lang->my->editBasicInformation;
		$this->view->collegelist= $collegelist;
		$this->view->years 		= $years;
		$this->view->user       = $this->user->getByAccount($this->app->user->account);

		$this->display();
	}


	/**
	 * @author iat
	 * @date 20140825
	 * modify
	 */
	public function viewBasicInformation($account = 0, $is_onlybody = 'no')
	{
		if(!$account) $account = $this->session->user->account;
		$collegelist = $this->personalinfo->getCollegeList();
		
		$this->personalinfo->setMenu();
		$user = $this->user->getByAccount($account);
		$this->view->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->viewBasicInformation;
		$this->view->collegelist= $collegelist;
		$this->view->user = $user;
		$this->view->is_onlybody = $is_onlybody;
		$this->view->groups = $this->loadModel('group')->getByAccount($account);
		$this->display();
	}
}
