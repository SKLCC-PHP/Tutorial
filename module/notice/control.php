<?php
/**
 * @author iat
 * @date 20140823
 */
class notice extends control
{
	/**
	 * Construct function, load user models auto.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('user');
		$this->loadModel('action');
	}

	/**
	 * view notices
	 * 
	 * @param  string $browseType 
	 * @param  string $orderBy 
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function viewNotice($orderBy = 'createtime_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1, $paramtitle = '', $paramcreator = '')
	{
		/* Process the order by field. */
        if(!$orderBy) $orderBy = $this->cookie->NoticeOrder ? $this->cookie->NoticeOrder : 'id_desc';
        setcookie('NoticeOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

        /* Load pager and get notices. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $notices = $this->notice->getNotices($orderBy,$pager, $paramtitle, $paramcreator);

		$this->view->notices = $notices;
		$this->view->pager          = $pager;
        $this->view->recTotal       = $pager->recTotal;
        $this->view->recPerPage     = $pager->recPerPage;
        $this->view->pageID         = $pager->pageID;
        $this->view->orderBy        = $orderBy;
		$this->view->userpairs = $this->user->getPairs("noletter");
		$this->view->searchtitle = $paramtitle;
		$this->view->searchcreator = $paramcreator;
		$this->display();
	}

	/**
	 * Notice dynamic.
	 * 
	 * @param  string $browseType 
	 * @param  string $orderBy 
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function dynamic($browseType = 'all', $param = '', $orderBy = 'date_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		$this->notice->setMenu();
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
		$this->session->set('noticeList',        $uri);
		$this->session->set('buildList',       $uri);
		$this->session->set('bugList',         $uri);
		$this->session->set('caseList',        $uri);
		$this->session->set('testnoticeList',    $uri);

		/* Set the pager. */
		$this->app->loadClass('pager', $static = true);
		$pager = pager::init($recTotal, $recPerPage, $pageID);
		$this->view->orderBy = $orderBy;
		$this->view->pager   = $pager;

		/* Set the user and type. */
		$account = $browseType == 'account' ? $param : 'all';
		$period  = ($browseType == 'account' or $browseType == 'product' or $browseType == 'project') ? 'all'  : $browseType;
		$queryID = ($browseType == 'bysearch') ? (int)$param : 0;


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
			$actions = $this->action->getDynamic($account, $period, $orderBy, $pager, $product);
		}
		else
		{
			$actions = $this->action->getDynamicBySearch($products, $projects, $queryID, $orderBy, $pager); 
		}

		/* Assign. */
		$this->view->browseType = $browseType;
		$this->view->account    = $account;
		$this->view->queryID    = $queryID; 
		$this->view->actions    = $actions;
		$this->display();
	}

	/**
	 * create a notice.
	 * 
	 * @param  string $browseType 
	 * @param  string $orderBy 
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function create($recreate = 0)
	{
		$notice = new stdClass();
        $notice->title       = '';
        $notice->content     = '';
        $notice->createtime = '';
        $notice->creatorID = '';
 
        if(!empty($_POST))
        {
        	$notice = fixer::input('post')->get();
            if (!($notice->title && $notice->content))
            {
                echo js::alert($this->lang->notice->noImportantInformation);
                $this->session->set('createNotice', $notice);
                die(js::locate($this->createLink('notice', 'create', "recreate=1"), 'parent'));
            }

            $this->notice->create();
            $this->action->create('notice', $noticeID, 'created');
            echo js::alert($this->lang->notice->createsucceed);
           	die(js::locate($this->createLink('notice', 'viewNotice'), 'parent'));
        }

        $this->view->notice  = $recreate ? $this->session->createNotice: null;
        $this->display();
	}

	/**
	 * view a notcie
	 * 
	 * @param  string $browseType 
	 * @param  string $orderBy 
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function view($noticeID = 0, $orderBy = 'createtime_desc')
	{
		if (!$this->notice->checkPriv($noticeID))  
			die(js::locate($this->createLink('system', 'error404'), 'parent'));

		/*get all coleges*/
		$colleges = $this->dao->select('college_id, college_name')->from(TABLE_COLLEGE)->where('status')->eq(1)->fetchAll();

		$collegeList = array();
		foreach ($colleges as $college) 
		{

			$collegeList[$college->college_id] = $college->college_name;
		}

		/*set the preAndNext*/
		$notices = $this->notice->getNotices($orderBy);
		foreach ($notices as $notice) 
		{
			$ids[] = $notice->id;
		}
		$ids = array_flip($ids);
		$index = $ids[$noticeID];
		$ids = array_flip($ids); 
		$preAndNext = new stdclass();
		if(count($ids) != 1)
		{
			switch ($index) 
			{
				case 0:
					$preAndNext->next = $ids[1];
					break;
				case count($ids)-1:
					$preAndNext->pre = $ids[count($ids)-2];
					break;

				default:
					$preAndNext->pre = $ids[$index-1];
					$preAndNext->next = $ids[$index+1];
					break;
			}
		}

		$notice = $this->notice->getNoticeByID($noticeID);
		if(empty($notice)) die();
		$this->view->notice = $notice;
		$this->view->orderBy = $orderBy;
		$this->view->preAndNext = $preAndNext;
		$this->view->collegeList = $collegeList;
		$this->view->userpairs = $this->user->getPairs('noletter');
		$this->display();
	}

	/**
	 * delete a notcie
	 * 
	 * @param  string $browseType 
	 * @param  string $orderBy 
	 * @param  int    $recTotal 
	 * @param  int    $recPerPage 
	 * @param  int    $pageID 
	 * @access public
	 * @return void
	 */
	public function delete($noticeID = 0, $confirm = 'no')
	{   
        if (!$this->notice->checkPriv($noticeID, 'delete')) 
    	{
    		die(js::locate($this->createLink('system', 'error404'), 'parent'));
    	}
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->notice->confirmDelete, inlink('delete', "noticeID=$noticeID&confirm=yes")));
        }
        else
        {
            $this->notice->delete($noticeID);
            $this->action->create('notice', $noticeID, 'deleted');
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
            echo js::alert($this->lang->notice->deletesucceed);
            die(js::locate($this->createLink('notice', 'viewNotice'), 'parent'));
        }
	}

	/**
	 * @author Green
	 * @date 20141025
	 */
	public function search()
    {
    	$get_data = fixer::input('post')->get();
																													
        die(js::locate($this->createLink('notice', 'viewNotice', 
        	array('orderBy' => 'createtime_desc', 'recTotal' => 0, 'recPerPage' => 20, 'pageID' => 1, 'paramtitle' => $get_data->title, 'paramcreator' => $get_data->creator)), 'parent'));
    }
}
