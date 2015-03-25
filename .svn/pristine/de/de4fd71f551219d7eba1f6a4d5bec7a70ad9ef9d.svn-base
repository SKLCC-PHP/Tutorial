<?php 
include '../../common/view/header.html.php';
include '../../common/view/kindeditor.html.php';
?>

<div id='titlebar'>
  <div id='heading'>
    <strong><?php echo $task->title?></strong>
  </div>
</div>
<form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
  <div class='main'>
    <fieldset>
    	<legend><?php echo $lang->task->content;?></legend>
    	<?php echo html::textarea('submitcontent', $task->submitcontent, "rows='6' class='w-p98'");?>
    </fieldset>
	<fieldset>
		<legend><?php echo $lang->task->subfile;?></legend>
		<?php echo $this->fetch('file', 'printFiles', array('files' => $task->submitfiles, 'fieldset' => 'false'));?>
		<br/>
		<?php echo $this->fetch('file', 'buildform');?>
	</fieldset>
  </div>
  <br/>
  <div class='actions actions-form text-center'>
  <?php echo html::submitButton();?>
  </div>
</form>

<?php include '../../common/view/footer.html.php';?>