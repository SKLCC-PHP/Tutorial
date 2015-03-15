<?php
/**
 * The createlib view of doc module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Jia Fu <fujia@cnezsoft.com>
 * @package     doc
 * @version     $Id: createlib.html.php 975 2010-07-29 03:30:25Z jajacn@126.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['doclib']);?></span>
    <strong><small class='text-muted'><i class='icon icon-plus'></i></small> <?php echo $lang->resources->upload;?></strong>
  </div>
</div>
<div class='main'>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
    <table class='table table-form' align="center"> 
      <tr>
        <th width="100px"><?php echo $lang->files;?></th>
        <td width="700px"><?php echo $this->fetch('file', 'buildform');?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->resources->extra;?></th>
        <td colspan='2'><?php echo html::textarea('extra', '', "rows='7' class='form-control'");?></td><td></td>
      </tr>  
      <tr>
        <th><?php echo $lang->acl;?></th>
        <td colspan='3'><?php echo html::radio('acl', $lang->aclList, '1');?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan='3'><?php echo html::submitButton();?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
