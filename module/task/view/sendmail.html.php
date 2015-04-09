<?php
$onlybody = isonlybody() ? true : false;
if($onlybody) $_GET['onlybody'] = 'no';
?>
<table width='98%' align='center'>
  <tr class='header'>
    <td>
      TASK #<?php echo $task->id . "=>$task->assignedTo " . html::a(common::getSysURL() . $this->createLink('task', 'view', "taskID=$task->id"), $task->name);?>
    </td>
  </tr>
  <tr>
    <td>
    <fieldset>
      <legend><?php echo $lang->task->legendDesc;?></legend>
      <div class='content'><?php echo $task->desc;?></div>
    </fieldset>
    </td>
  </tr>
  <tr>
    <td><?php include '../../common/view/mail.html.php';?></td>
  </tr>
</table>
<?php if($onlybody) $_GET['onlybody'] = 'yes';?>
