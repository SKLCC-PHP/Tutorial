<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('oldStoryID', $task->story); ?>
<?php js::set('confirmChangeProject', $lang->task->confirmChangeProject); ?>
<?php js::set('changeProjectConfirmed', false); ?>

<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['task']);?> <strong><?php echo $task->id;?></strong></span>
    <strong><?php echo html::a($this->createLink('task', 'view', "taskID=$task->id"), $task->title);?></strong>
    <small><?php echo $lang->task->edit;?></small>
  </div>
</div>
<form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
  <input type='hidden' value='<?php echo $task->acpID;?>', name='assignedTo'/>
  <div class='row-table'>
    <div class='col-main'>
      <div class='main'>
        <fieldset>
          <legend><?php echo $lang->task->content;?></legend>
          <div class='form-group'>
            <?php echo html::textarea('content', htmlspecialchars($task->content), "rows='8' class='form-control'");?>
          </div>
        </fieldset>
        <fieldset>
          <legend><?php echo $lang->files;?></legend>
          <?php echo $this->fetch('file', 'printFiles', array('files' => $task->files, 'fieldset' => 'false'));?>
          <br/>
          <div class='form-group'><?php echo $this->fetch('file', 'buildform');?></div>
        </fieldset>
        <div class='actions actions-form'>
          <?php echo html::submitButton() . html::linkButton($lang->goback, $this->inlink('view', "taskID=$task->id"));?>
        </div>
      </div>
    </div>
    <div class='col-side'>
      <div class='main main-side'>
        <fieldset>
          <legend><?php echo $lang->basicInfo?></legend>
          <table class='table table-data table-condensed table-borderless'>
            <tr>
              <th class='w-80px text-right'><?php echo $lang->task->title;?></th>
              <td><?php echo html::input('title', $task->title, 'class="form-control" required="required" placeholder="' . $lang->task->title . '"');?></td>
            </tr>
            <tr>
              <th><?php echo $lang->task->begin_time;?></th>
              <td><?php echo html::input('begintime', substr($task->begintime, 0, 10), 'class="form-control form-date" required="required" onchange="computeWorkDays()" placeholder="' . $lang->task->begin_time . '"');?></td>
            </tr>
            <tr>
              <th><?php echo $lang->task->deadline;?></th>
              <td><?php echo html::input('deadline', substr($task->deadline, 0, 10), 'class="form-control form-date" required="required" onchange="computeWorkDays()" placeholder="' . $lang->task->deadline . '"');?></td>
            </tr>
            <tr>
              <th><?php echo $lang->task->days;?></th>
              <td>
                <div class='input-group'>
                  <?php echo html::input('days', round((strtotime($task->deadline) - strtotime($task->begintime)) / 3600 / 24), "class='form-control' onchange=computeWorkDate()");?>
                  <span class='input-group-addon'><?php echo $lang->task->day;?></span>
                </div>
              </td>
            </tr>
            <tr>
              <th><?php echo $lang->acl;?></th>
              <td><?php echo nl2br(html::radio('ACL', $lang->aclList, $task->ACL, '', 'block'));?></td>
            </tr>
          </table>
        </fieldset>
      </div>
    </div>
  </div>
</form>
<?php include '../../common/view/footer.html.php';?>
