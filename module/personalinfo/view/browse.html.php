<?php
/**
 * The browse view file of doc module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     lib
 * @version     $Id: browse.html.php 958 2010-07-22 08:09:42Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>


<div id='featurebar'>
  <ul class='nav'>

  </ul>
  <div id='querybox' class='<?php if($browseType == 'bysearch') echo 'show';?>'></div>
</div>

<div class='main'>

</div>
<?php include '../../common/view/footer.html.php';?>
