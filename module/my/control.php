<?php
/**
 * @author iat
 * @date 20140828
 */
class my extends control
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
		$this->my->setMenu();
		$this->loadModel('task');
		$this->loadModel('problem');
		$this->loadModel('notice');
		$this->loadModel('user');
	}

	/**
	 * Index page, goto todo.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->app->loadClass('pager', true);
		$taskCounts = new pager($recTotal = 1000, $this->config->my->taskCounts);
		$problemCounts = new pager($recTotal = 1000, $this->config->my->problemCounts);
		$noticeCounts = new pager($recTotal = 1000, $this->config->my->noticeCounts);

		$this->view->user = $this->session->user;
		$this->view->tasks = $this->task->getTasks('', '', $taskCounts);
		$this->view->userpairs = $this->user->getPairs('noletter');
		$this->view->problems = $this->problem->getProblems('', '', '', '', $problemCounts);
		$this->view->notices = $this->notice->getNotices('createtime_desc', $noticeCounts);
		$this->display();
	}
}
