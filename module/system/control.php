<?php

class system extends control
{
	/**
	 * The index of system, goto project deviation.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->display();
		//var_dump(getTime());
		//$startTime = '2014-08-30';
		//$this->loadModel('common')->getRunInfo($startTime);
		//vprintf($this->lang->runInfo, $this->loadModel('common')->getRunInfo($startTime));
	}
	
	/**
	 * Project deviation system.
	 * 
	 * @access public
	 * @return void
	 */
	public function setBackup()
	{
		$this->view->title      = $this->lang->system->backup;
		$this->view->position[] = $this->lang->system->backup;

		$this->display();
	}

	/**
	 * Product information system.
	 * 
	 * @access public
	 * @return void
	 */
	public function setBasicsystem()
	{
		//die(js::locate($this->createLink('mail', 'index'), 'parent'));
		// $this->view->title      = $this->lang->system->basicsystem;
		// $this->view->position[] = $this->lang->system->basicsystem;

		$this->display();
	}

	/**
	 * Bug summary system.
	 * 
	 * @param  int    $begin 
	 * @param  int    $end 
	 * @access public
	 * @return void
	 */
	public function log($browseType = 'all', $param = '', $orderBy = 'date_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		$this->app->loadLang('user');
		$this->app->loadLang('project');
		$this->loadModel('action');

		/* Save session. */
		$uri = $this->app->getURI(true);
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

		/* Set the user and type. */
		$account = $browseType == 'account' ? $param : 'all';
		$product = $browseType == 'product' ? $param : 'all';
		$project = $browseType == 'project' ? $param : 'all';
		$period  = ($browseType == 'account' or $browseType == 'product' or $browseType == 'project') ? 'all'  : $browseType;
		$queryID = ($browseType == 'bysearch') ? (int)$param : 0;

		/* Get products' list.*/
		//$products = $this->loadModel('product')->getPairs('nocode');
		//$products = array($this->lang->product->select) + $products;
		//$this->view->products = $products;

		/* Get projects' list.*/
		//$projects = $this->loadModel('project')->getPairs('nocode');
		//$projects = array($this->lang->project->select) + $projects;
	   // $this->view->projects = $projects; 

		/* Get users.*/
		$users = $this->loadModel('user')->getPairs('nodeleted|noclosed');
		$users[''] = $this->lang->user->select;
		$this->view->users    = $users; 

		/* The header and position. */
		$this->view->title      = $this->lang->company->common . $this->lang->colon . $this->lang->company->dynamic;
		$this->view->position[] = $this->lang->company->dynamic;

		/* Get actions. */
		if($browseType != 'bysearch') 
		{
			$actions = $this->action->getDynamic($account, $period, $orderBy, $pager, $product, $project);
		}
		else
		{
			$actions = $this->action->getDynamicBySearch($products, $projects, $queryID, $orderBy, $pager); 
		}
		//var_dump($actions);
		/* Build search form. */
		$projects[0] = '';
		$products[0] = '';
		$users['']   = '';
		ksort($projects);
		ksort($products);
		$projects['all'] = $this->lang->project->allProject;
		$products['all'] = $this->lang->product->allProduct;
		$this->config->company->dynamic->search['actionURL'] = $this->createLink('company', 'dynamic', "browseType=bysearch&param=myQueryID");
		$this->config->company->dynamic->search['queryID']   = $queryID;
		$this->config->company->dynamic->search['params']['project']['values'] = $projects;
		$this->config->company->dynamic->search['params']['product']['values'] = $products; 
		$this->config->company->dynamic->search['params']['actor']['values']   = $users; 
		//$this->loadModel('search')->setSearchParams($this->config->company->dynamic->search);

		/* Assign. */
		$this->view->browseType = $browseType;
		$this->view->account    = $account;
		$this->view->product    = $product;
		$this->view->project    = $project;
		$this->view->queryID    = $queryID; 
		$this->view->actions    = $actions;
		$this->display();
	}

	public function mail()
	{
		$this->locate($this->createLink('mail', 'edit'), 'parent');
	}

	/**
     * Print the run info.
     * 
     * @param mixed $startTime  the start time.
     * @access public
     * @return void
     */
    public function error404()
    {
    	header('HTTP/1.1 404 Not Found'); 
   		header('status: 404 Not Found');
        $this->display();
    }
}
