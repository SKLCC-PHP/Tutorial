<div class='panel panel-block' id='taskbox'>
  <div class='panel-heading'>
    <i class='icon-tasks icon'></i><strong><?php echo $lang->task->common;?></strong>
    <?php if (count($tasks) >= 6):?>
     <div class="pull-right"><?php common::printLink('resources', 'viewMoreTask', "teacher_account=$teacher_account", $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
    <?php endif;?>
  </div>
  <table class='table table-condensed table-hover table-striped table-borderless'>
    <?php foreach ($tasks as $key => $task):?>
      <tr>
        <th><?php echo '#' . $task->id;?></th>
        <td class='text-left'><?php echo html::a($this->createLink('task', 'view', "taskID=$task->id&is_onlybody=yes", '', true), $task->title, '_self', 'class="iframe"');?></td>
      </tr>
    <?php 
      if ($key == 5) break;
      endforeach;
    ?>
  </table>
</div>