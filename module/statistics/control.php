<?php
class statistics extends control
{
	private $roleid;
	
	/**
	 * Construct function, load model of project and story modules.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$roleid = $this->session->userinfo->roleid;
		
		$this->loadModel('resources');
		$this->loadModel('user');
		$this->loadModel('tutor');
		$this->loadModel('achievement');
    $this->loadModel('student');
    $this->loadModel('action');
	}


	/**
	 * Index page.
	 * @access public
	 * @return void
	 */
	public function index($viewtype = 'student', $orderBy = '', $recTotal = 0, $recPerPage = 15, $pageID = 1)
	{
    if($orderBy == '')
    {
      $orderBy = 'account_asc';

      if($viewtype == 'teacher')
        $orderBy = 'realname_asc';
    }
    /* Process the order by field. */
    if(!$orderBy) $orderBy = $this->cookie->StatisticsOrder ? $this->cookie->StatisticsOrder : 'account_asc';
    setcookie('StatisticsOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

    /* Load pager and get tasks. */
    $this->app->loadClass('pager', $static = true);
    $pager = new pager($recTotal, $recPerPage, $pageID);

    $statistics = $this->statistics->getStatistics($viewtype,$orderBy,$pager);

    $this->view->statistics     = $statistics;
    $this->view->viewtype       = $viewtype;
    $this->view->pager          = $pager;
    $this->view->recTotal       = $pager->recTotal;
    $this->view->recPerPage     = $pager->recPerPage;
    $this->view->pageID         = $pager->pageID;
    $this->view->orderBy        = $orderBy;
	  $this->display();
	}

	/**
	 * viewGraduationThesis page.
	 * @access public
	 * @return void
	 */
	public function viewGraduationThesis($account = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 100, $pageID = 1)
	{
		/* Load pager and get tasks. */
		$this->app->loadClass('pager', $static = true);
		$pager = new pager($recTotal, $recPerPage, $pageID);

		$userpairs = $this->user->getPairs('noletter');

		$results = $this->statistics->getThesises($account,$orderBy, $pager);
    $tutors_list = (array)$results[0];
    $thesises = $results[1];

		/*set the summary*/
		$summary = sprintf($this->lang->achievement->thesis->summary, count($thesises));

		$this->view->position[] = $this->lang->statistics->index;
		$this->view->thesises = $thesises;
		$this->view->tutors_list = $tutors_list;
    $this->view->account = $account;
		$this->view->userpairs = $userpairs;
		$this->view->pager          = $pager;
		$this->view->recTotal    = $pager->recTotal;
		$this->view->recPerPage  = $pager->recPerPage;
    $this->view->pageID      = $pager->pageID;
		$this->view->orderBy     = $orderBy;
		$this->view->summary     = $summary;
		$this->display();
	}

	/**
	 * viewAchievement page.
	 * @access public
	 * @return void
	 */
	public function viewDetails($browsetype = 'task', $viewtype = 'student', $orderBy = '', $recTotal = 0, $recPerPage = 100, $pageID = 1)
	{
    if($orderBy == '')
    {
      $orderBy = 'account_asc';

      if($viewtype == 'teacher')
        $orderBy = 'realname_asc';
    }
		/* Process the order by field. */
    if(!$orderBy) $orderBy = $this->cookie->StatisticsOrder ? $this->cookie->StatisticsOrder : 'account_asc';
    setcookie('StatisticsOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

    /* Load pager and get tasks. */
    $this->app->loadClass('pager', $static = true);
    $pager = new pager($recTotal, $recPerPage, $pageID);

    $details = $this->statistics->getDetails($browsetype,$viewtype,$orderBy,$pager);

    $this->view->details        = $details;
    $this->view->viewtype       = $viewtype;
    $this->view->browsetype     = $browsetype;
    $this->view->pager          = $pager;
    $this->view->recTotal       = $pager->recTotal;
    $this->view->recPerPage     = $pager->recPerPage;
    $this->view->pageID         = $pager->pageID;
    $this->view->orderBy        = $orderBy;

    $this->display();
	}

  /**
   * Get data to export 
   * 
   * @param  string $productID 
   * @param  string $orderBy 
   * @access public
   * @return void
   */
  public function exportIndex($viewtype = 'student', $orderBy = 'account_asc', $confirm = 'no')
  {
      if($confirm == 'no')
      {
          die(js::confirm($this->lang->statistics->confirmExport, $this->createLink('statistics', 'exportIndex', "viewtype=$viewtype&orderBy=$orderBy&confirm=yes")));
      }
      else
      {
          $statisticsLang   = $this->lang->statistics;
          $statisticsConfig = $this->config->statistics;

          /* Create field lists. */
          $fields = explode(',', $statisticsConfig->list->index->exportFields);
          foreach($fields as $key => $fieldName)
          {
              $fieldName = trim($fieldName);
              if($fieldName == 'account')
              {
                  $fields[$fieldName] = $statisticsLang->account[$viewtype];
                  unset($fields[$key]);
                  continue;
              }
              elseif ($fieldName == 'realname') 
              {
                  $fields[$fieldName] = $statisticsLang->realname[$viewtype];
                  unset($fields[$key]);
                  continue;
              }
              $fieldName_CN = $statisticsLang->browse->$fieldName;
              $fields[$fieldName] = isset($fieldName_CN[$viewtype]) ? $fieldName_CN[$viewtype] : $fieldName;
              unset($fields[$key]);
          }

          $statistics = $this->statistics->getStatistics($viewtype,$orderBy);

          $this->fetch('file', 'export2xls', array('fields' => $fields, 'rows' => $statistics));
          $this->action->create('user', $this->session->user->id, 'exported');
          
          die(js::locate($this->server->http_referer, 'parent'));
      }
  }


    /**
     * Get data to export 
     * 
     * @param  string $productID 
     * @param  string $orderBy 
     * @access public
     * @return void
     */
    public function exportDetails($browsetype = 'task', $viewtype = 'student', $orderBy = 'account_asc', $confirm = 'no')
    {
         if($confirm == 'no')
        {
            die(js::confirm($this->lang->statistics->confirmExport, $this->createLink('statistics', 'exportDetails', "browsetype=$browsetype&viewtype=$viewtype&orderBy=$orderBy&confirm=yes")));
        }
        else
        {
            $statisticsLang   = $this->lang->statistics;
            $statisticsConfig = $this->config->statistics;

            /* Create field lists. */
            $fields = explode(',', $statisticsConfig->list->details->$browsetype->exportFields);
            foreach($fields as $key => $fieldName)
            {
                $fieldName = trim($fieldName);
                if($fieldName == 'account')
                {
                	$fields[$fieldName] = $statisticsLang->account[$viewtype];
                	unset($fields[$key]);
                	continue;
                }
                elseif ($fieldName == 'realname') 
                {
                	$fields[$fieldName] = $statisticsLang->realname[$viewtype];
                	unset($fields[$key]);
                	continue;
                }

               	if (is_array($statisticsLang->details->$browsetype->$fieldName)) 
               	{
               		$fieldName_temp = $statisticsLang->details->$browsetype->$fieldName;
               		$fieldName_CN = $fieldName_temp[$viewtype];
               	}
               	else
               	{
               		$fieldName_CN = $statisticsLang->details->$browsetype->$fieldName;
               	}
                $fields[$fieldName] = isset($fieldName_CN) ? $fieldName_CN : $fieldName;
                unset($fields[$key]);
            }

            $statistics = $this->statistics->getDetails($browsetype, $viewtype, $orderBy);
            foreach ($statistics as &$value) 
            {
            	$value = (object)$value;
            }

            $this->fetch('file', 'export2xls', array('fields' => $fields, 'rows' => $statistics));
            $this->action->create('user', $this->session->user->id, 'exported');
            
            die(js::locate($this->server->http_referer, 'parent'));
        }
    }

   //  /**
   //   * Get data to export 
   //   * 
   //   * @param  string $productID 
   //   * @param  string $orderBy 
   //   * @access public
   //   * @return void
   //   */
   //  public function exportThesises($orderBy = 'id_desc')
   //  {
   //      if($_POST)
   //      {
   //          $statisticsLang   = $this->lang->statistics;
   //          $statisticsConfig = $this->config->statistics;

   //          $userpairs = $this->user->getPairs('noletter');
			// $results = $this->statistics->getThesises('all',$orderBy);

   //          /* Create field lists. */
   //          $fields = explode(',', $statisticsConfig->list->thesis->exportFields);
   //          foreach($fields as $key => $fieldName)
   //          {
   //              $fieldName = trim($fieldName);

   //              $fields[$fieldName] = isset($statisticsLang->thesis->$fieldName) ? $statisticsLang->thesis->$fieldName : $fieldName;
   //              unset($fields[$key]);
   //          }

   //          foreach ($results[1] as $thesis) 
   //          {
   //          	$statistics['id'] = $thesis->id;
   //          	$statistics['creator'] = $userpairs[$thesis->creatorID];
   //          	$statistics['title'] = $thesis->title;
   //          	$statistics['tea_name'] = $thesis->realname;
   //          	$statistics['othername'] = $thesis->othername;
   //          	$statistics['createdate'] = substr($thesis->createtime, 0, 10);
   //          	$statistics['updatedate'] = substr($thesis->updatetime, 0, 10);
   //          	$thesises[] = (object)$statistics;
   //          }

   //          $this->post->set('fields', $fields);
   //          $this->post->set('rows', $thesises);
   //          $this->post->set('kind', 'statistics');
   //          $this->fetch('file', 'export2' . $this->post->fileType, $_POST);
   //          $this->action->create('user', $this->session->user->id, 'exported');
   //      }

   //      $this->display();
   //  }
}
