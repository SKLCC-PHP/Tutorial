<?php
/**
 * The control file of company module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     company
 * @version     $Id: control.php 5100 2013-07-12 00:25:23Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
class company extends control
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
    }

    /**
     * Index page, header to browse.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate($this->createLink('user', 'index'));
    }

    /**
     * setUser departments and users of a company.
     * 
     * @param  int    $param 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function setUser($param = 0 , $orderBy = 'account', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->lang->set('menugroup.company', 'company');

        $this->company->setMenu();

        /* Save session. */
        $this->session->set('userList', $this->app->getURI(true));

        /* Set the pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);
        $users        = $this->company->getUsers($pager, $orderBy);

        $this->view->title       = $this->lang->company->index . $this->lang->colon;
        $this->view->position[]  = $this->lang->company->user;
        $this->view->users       = $users;
        $this->view->orderBy     = $orderBy;
        $this->view->pager       = $pager;
        $this->view->param       = $param;
        $this->view->type        = $type;

        $this->display();
    }
}
