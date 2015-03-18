<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['task']);?></span>
    <strong><small class='text-muted'><?php echo html::icon($lang->icons['batchEdit']);?></small> <?php echo $lang->task->batchEdit . ' ' . $lang->task->common;?></strong>
  </div>
</div>

<form class='form-condensed' enctype='multipart/form-data' id='dataform' method='post' target='hiddenwin' action="<?php echo inLink('batchEdit', "projectID={$projectID}")?>">
  <table class='table table-fixed table-form'>
    <thead>
      <tr>
        <th width="25px"><?php echo $lang->idAB;?></th> 
        <th width="200px">   <?php echo $lang->task->title?></th>
        <th width="300px"><?php echo $lang->task->content?></th>
        <th width="100px"><?php echo $lang->task->deadline;?></th>
        <th width="600px"><?php echo $lang->files;?></th>
      </tr>
    </thead>
    <?php foreach($taskIDList as $taskID):?>
    <tr class='text-center'>
      <td><?php echo $taskID . html::hidden("taskIDList[$taskID]", $taskID);?></td>
      <td><?php echo html::input("titles[$taskID]",          $tasks[$taskID]->title, "class='form-control'");?></td>
      <td><?php echo html::textarea('contents[$taskID]', $tasks[$taskID]->content, "rows='7' class='form-control'");?></td>
      <td><?php echo html::input("deadlines[$taskID]", $tasks[$taskID]->deadline, "class='form-control form-date'");?></td>
      <td style="padding-top:16px;"><?php echo $this->fetch('file', 'buildform');?></td>
    </tr>  
    <?php endforeach;?>

    <?php if(isset($suhosinInfo)):?>
    <tr><td colspan='<?php echo $this->config->task->batchEdit->columns;?>'>
      <div class='f-left blue'><?php echo $suhosinInfo;?></div>
    </td></tr>
    <?php endif;?>
    <tfoot>
      <tr><td colspan='<?php echo $this->config->task->batchEdit->columns;?>'>
        <?php echo html::submitButton();?>
      </td></tr>
    </tfoot>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>
