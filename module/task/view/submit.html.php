<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='container'>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['task']);?> <strong><?php echo $task->id;?></strong></span>
    <strong><?php echo html::a($this->createLink('task', 'view', 'task=' . $task->id), $task->title, '_blank');?></strong>
    <small class='text-success'> <?php echo $lang->task->finish;?></small>
  </div>
</div>
<form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform' target='hiddenwin'>
  <table class='table table-form'>
    <tr>
      <th><?php echo $lang->task->content;?></th>
      <td colspan='2'><?php echo html::textarea('submitcontent', '', "rows='20' class='w-p98'");?></td>
    </tr>
    <tr>
      <th width="100px"><?php echo $lang->task->subfile;?></th>
      <td colspan='2' width="200px"><?php echo $this->fetch('file', 'buildform');?></td><td></td>
    </tr>
    <tr>
      <td colspan='3' class='text-center'><?php echo html::submitButton() . html::backButton();?></td>
    </tr>
  </table>
</form>
</div>
<?php include '../../common/view/footer.html.php';?>
