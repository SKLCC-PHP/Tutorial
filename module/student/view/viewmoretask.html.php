<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->student->viewMoreTask;?></strong>
  </div>
  <div class='actions'>
    <?php echo html::linkButton($lang->goback, $this->inlink('viewStudentDetails', "student_account=$student_account"));?>
  </div>
</div>
<div id = 'main'>
  <table class='table table-condensed table-hover table-striped tablesorter'>
  <?php $vars = "student_account=$student_account&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
    <thead>
      <tr class='text-center'>
        <th class='w-20px'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
        <th class='w-90px'><div class='text-left'><?php echo $lang->task->title;?></div></th>
        <th class='w-20px'><?php echo $lang->task->creator;?></th>
        <th class='w-30px'> <?php echo $lang->task->acl;?></th>
        <th class='w-hour'> <?php common::printOrderLink('createtime', $orderBy, $vars, $lang->task->create_time);?></th>
        <th class='w-hour'> <?php echo $lang->task->deadline;?></th>
        <th class='w-30px'> <?php echo $lang->task->is_submitted;?></th>
        <th class='w-30px'> <?php echo $lang->task->is_assessed;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($tasks as $key => $task):?>
      <tr class='text-center'>
        <td><?php echo html::a($this->createLink('task', 'view', "taskID=$task->id&is_onlybody=yes", '', true), $task->id, '_self', 'class="iframe"');?></td>
        <td class='text-left nobr'><?php echo html::a($this->createLink('task', 'view', "taskID=$task->id&is_onlybody=yes", '', true), $task->title, '_self', 'class="iframe"');?></td>
        <td><?php echo $userpairs[$task->asgID];?></td>
        <td><?php echo $lang->task->aclList[$task->ACL];?></td>
        <td><?php echo $task->createtime;?></td>
        <td><?php echo $task->deadline;?></td>
        <td><?php echo $lang->task->submitList[($task->submittime != null)];?></td>
        <td><?php echo $lang->task->assessList[($task->assesstime != null)];?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <?php $columns = $this->cookie->windowWidth > $this->config->wideSize ? 14 : 12;?>
        <td colspan='<?php echo $columns;?>'>
          <?php $pager->show();?>
        </td>
      </tr>
    </tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>