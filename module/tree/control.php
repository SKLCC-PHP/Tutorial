<?php
/**
 * The control file of tree module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id: control.php 5002 2013-07-03 08:25:39Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
class tree extends control
{
    const NEW_CHILD_COUNT = 10;

    /**
     * Module browse.
     * 
     * @param  int    $rootID 
     * @param  string $viewType         story|case
     * @param  int    $currentModuleID 
     * @access public
     * @return void
     */
    public function browse($rootID, $viewType, $currentModuleID = 0)
    {
        /* According to the type, set the module root and modules. */
        if(strpos('story|case', $viewType) !== false)
        {
            $product = $this->loadModel('product')->getById($rootID);
            $this->view->root = $product;
            $this->view->productModules = $this->tree->getOptionMenu($rootID, 'story');
        }

        if($viewType == 'story')
        {
            $this->lang->set('menugroup.tree', 'product');
            $this->product->setMenu($this->product->getPairs(), $rootID, 'story');
            $this->lang->tree->menu      = $this->lang->product->menu;
            $this->lang->tree->menuOrder = $this->lang->product->menuOrder;

            $products = $this->product->getPairs();
            unset($products[$rootID]);
            $currentProduct = key($products);

            $this->view->allProduct     = $products;
            $this->view->currentProduct = $currentProduct;
            $this->view->productModules = $this->tree->getOptionMenu($currentProduct, 'story');

            $title      = $product->name . $this->lang->colon . $this->lang->tree->manageProduct;
            $position[] = $this->lang->tree->manageProduct;
        }
        //@Green delete lines

        $parentModules = $this->tree->getParents($currentModuleID);
        $this->view->title           = $title;
        $this->view->position        = $position;
        $this->view->rootID          = $rootID;
        $this->view->viewType        = $viewType;
        $this->view->modules         = $this->tree->getTreeMenu($rootID, $viewType, $rooteModuleID = 0, array('treeModel', 'createManageLink'));
        $this->view->sons            = $this->tree->getSons($rootID, $currentModuleID, $viewType);
        $this->view->currentModuleID = $currentModuleID;
        $this->view->parentModules   = $parentModules;
        $this->display();
    }

}
