<?php
/**
 * The create view of notice module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     notice
 * @version     $Id: create.html.php 5090 2013-07-10 05:49:24Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div class='container'>
  <div id='titlebar'>
    <div class='heading'>
      <strong><?php echo $lang->notice->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
    <table class='table table-form' align="center"> 
      <tr>
        <th><?php echo $lang->notice->title;?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php echo html::input('title', $notice->title, "class='form-control' required='required'");?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->notice->content;?></th>
        <td colspan='2'><?php echo html::textarea('content', $notice->content, "rows='22' class='form-control' onsumbit='checkTextarea()'");?></td><td></td>
      </tr>   
      <tr>
        <th><?php echo $lang->files;?></th>
        <td colspan='2'><?php echo $this->fetch('file', 'buildform');?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan='3'><?php echo html::submitButton() . html::linkButton($lang->goback, $this->inlink('viewnotice'));?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
