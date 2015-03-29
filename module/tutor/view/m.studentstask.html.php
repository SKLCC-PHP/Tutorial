<div class='panel panel-block' id='taskbox' style="height:205px">
<?php if(count($tasks) == 0):?>
  <div class='panel-heading'>
    <i class='icon-tasks icon'></i><strong><?php echo $lang->task->common;?></strong>
  </div>
  <div class='panel-body text-center'><br><br>
    <span></span>
  </div>
<?php else:?>
  <table class='table table-condensed table-hover table-striped table-borderless'>
    <thead>
      <tr class='text-center'>
        <th class='w-60px'><div class='text-left'><i class='icon-tasks icon'></i><?php echo $lang->task->title;?></div></th>
        <th class='w-20px'> <?php echo $lang->task->creator;?></th>
        <th class='w-hour'> <?php echo $lang->task->create_time;?></th>
        <th class='w-hour'> <?php echo $lang->task->deadline;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($tasks as $key => $task):?>
      <tr class='text-center'>
        <td class='text-left nobr'><?php echo html::a($this->createLink('task', 'view', "taskID=$task->id&is_onlybody=yes", '', true), $task->title, '_self', 'class="iframe"');?></td>
        <td><?php echo $userpairs[$task->asgID];?></td>
        <td><?php echo $task->createtime;?></td>
        <td><?php echo $task->deadline;?></td>
      </tr>
      <?php  
        if ($key >= $breakTaskNum-1) break;
        endforeach;
      ?>
    </tbody>
  </table>
<?php if ($breakTaskNum == 5):?>
    <div class="pull-right"><?php common::printLink('tutor', 'viewMoreTask', "student_account=$student_account", $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
<?php endif;?>
<?php endif;?>
</div>
