<?php
/**
 * The model file of personalinfo module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     personalinfo
 * @version     $Id: model.php 881 2010-06-22 06:50:32Z chencongzhi520 $
 * @link        http://www.zentao.net
 */
?>
<?php
class personalinfoModel extends model
{
    /**
     * Set menus
     * 
     * @param  array  $libs 
     * @param  int    $libID 
     * @param  string $extra 
     * @access public
     * @return void
     */
    public function setMenu($libs, $libID, $extra = '')
    {
        $currentModule = $this->app->getModuleName();
        $currentMethod = $this->app->getMethodName();


        common::setMenuVars($this->lang->personalinfo->menu, 'list', $selectHtml);
        foreach($this->lang->personalinfo->menu as $key => $menu)
        {
            if($key != 'list') common::setMenuVars($this->lang->personalinfo->menu, $key, $libID);
        }
    }

    /**
    *get college list.
    *
    *@access public
    *@return array
    */
    public function getCollegeList()
    {
        $allcollege = $this->dao->select('*')->from(TABLE_COLLEGE)->fetchAll();

        $collegelist = array();
        foreach ($allcollege as $college) 
        {
            $collegelist[$college->college_id] = $college->college_name;
        }

        return $collegelist;
    }
}
