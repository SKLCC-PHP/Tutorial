<?php 
include '../../task/view/header.html.php';
js::set('confirmDelete', $lang->task->confirmDelete);
?>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('task', 'search');?>' class='form-condensed'>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
  <input type='hidden' value='<?php echo $viewtype;?>', name='viewtype'/>
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->task->title;?></td>
    <td><?php echo html::input('title', $searchtitle, 'class=form-control');?></td>
  <?php  if ($curRole != 'teacher'):
  ?>
    <td class='text-right w-60px'><?php echo $lang->task->creator;?></td>
    <td><?php echo html::input('asgID', $searchtea, 'class=form-control');?></td>
  <?php endif;
    if (($curRole != 'student') && ($viewtype != 'all')):?>
    <td class='text-right w-60px'><?php echo $lang->task->receiver;?></td>
    <td><?php echo html::input('acpID', $searchstu, 'class="form-control chosen"');?></td>
  <?php 
    endif;?>
    <td class='w-120px'>
      <div class='btn-group'>
        <?php
          echo html::submitButton($lang->search);
          echo html::linkButton($lang->goback, $this->inlink('viewTask', "viewtype=$viewtype"));
        ?>
      </div>
    </td>
  </tr>
</table>
</form>
<br/>
<table class='table w-1000px table-condensed table-hover table-striped tablesorter' align="center" id='tasktable'>
  <?php $vars = "viewtype=$viewtype&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID&paramtitle=$searchtitle&paramstu=$searchstu&paramtea=$searchtea"; ?>
  <thead>
  <tr class='text-center'>
  <?php if (($viewtype != 'all') || ($curRole == 'student')):?>
    <th width="10px" class='text-left'> <?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
  <?php endif;?>
    <th class='w-150px text-left'><?php common::printOrderLink('title', $orderBy, $vars, $lang->task->title);?></th>
  <?php if ($curRole != 'teacher'):?>
    <th class='w-40px'> <?php common::printOrderLink('asgID', $orderBy, $vars, $lang->task->creator);?></th>
  <?php endif;
    if (($curRole != 'student') && ($viewtype == 'all')):
  ?>  
    <th class='w-40px'> <?php echo $lang->task->receiverNum;?></th>
  <?php else:?>   
    <th class='w-40px'> <?php common::printOrderLink('acpID', $orderBy, $vars, $lang->task->receiver);?></th>
  <?php endif;?>  
    <th class='w-50px'> <?php common::printOrderLink('begintime', $orderBy, $vars, $lang->task->begin_time);?></th>
    <th class='w-50px'> <?php common::printOrderLink('deadline', $orderBy, $vars, $lang->task->deadline);?></th>
  <?php if ((($curRole == 'student') && ($viewtype == 'undone')) || (($curRole == 'teacher') && ($viewtype == 'assessed'))):?>
    <th class='w-50px'> <?php common::printOrderLink('assesstime', $orderBy, $vars, $lang->task->assess_time);?></th>
  <?php endif;
    if ($viewtype == 'done'):
  ?>
    <th class='w-50px'> <?php common::printOrderLink('completetime', $orderBy, $vars, $lang->task->complete_time);?></th>
  <?php endif;
    if (($curRole == 'teacher') && (($viewtype == 'undone') || ($viewtype == 'unassessed'))):
  ?>
    <th class='w-50px'> <?php common::printOrderLink('readtime', $orderBy, $vars, $lang->task->readtime);?></th>
    <th class='w-50px'> <?php common::printOrderLink('submittime', $orderBy, $vars, $lang->task->submit_time);?></th>
  <?php endif;
    if (($viewtype == 'all') && ($curRole == 'student')):
  ?>  
    <th class='w-30px'> <?php echo $lang->task->is_submitted;?></th>
    <th class='w-30px'> <?php echo $lang->task->is_assessed;?></th>
  <?php endif;?>
<!--   <?php  if ((($curRole == 'teacher')||($curRole == 'student')) && ($viewtype != 'done'))://@Green?>
    <th class='w-30px'> <?php echo $lang->actions;?></th>
  <?php endif;?> -->
  </tr>
  </thead>
  <tbody>
    <?php foreach($tasks as $key => $task):?>
    <tr class='text-center'>
    <?php if (($viewtype != 'all') || ($curRole == 'student')):?>
      <td class='text-left'><?php echo sprintf('%03d', $task->id);?></td>
    <?php 
      endif;
      if (($viewtype == 'all') && ($curRole != 'student')):
    ?>
      <td class='text-left nobr'>
        <?php
          echo html::a($this->createLink('task', 'viewgroup', "ID=$task->id"), $task->title);
        ?>
      </td>
    <?php else:?>
      <td class='text-left nobr'><?php echo html::a($this->createLink('task', 'view', "taskID=$task->id&viewtype=$viewtype"), $task->title);?></td>
    <?php endif;if ($curRole != 'teacher'):?>
      <td><?php echo $userpairs[$task->asgID];?></td>
    <?php endif;
      if (($curRole != 'student') && ($viewtype == 'all')):
    ?>
      <td><?php echo $task->acpNum;?></td>
    <?php else:?>
      <td><?php echo $userpairs[$task->acpID];?></td>
    <?php endif;?>    
      <td><?php echo $task->begintime;?></td>
      <td><?php echo $task->deadline;?></td>
    <?php if ((($curRole == 'student') && ($viewtype == 'undone')) || (($curRole == 'teacher') && ($viewtype == 'assessed'))):?>
      <td><?php echo $task->assesstime?></td>
    <?php endif;
      if ($viewtype == 'done'):
    ?>  
      <td><?php echo $task->completetime;?></td>
    <?php endif;
      if (($curRole == 'teacher') && (($viewtype == 'undone') || ($viewtype == 'unassessed'))):
    ?>  
      <td><?php echo $task->readtime;?></td>
      <td><?php echo $task->submittime;?></td>
    <?php endif;
      if (($viewtype == 'all') && ($curRole == 'student')):
    ?>  
      <td><?php echo $lang->task->submitList[($task->submittime != null)];?></td>
      <td><?php echo $lang->task->assessList[$task->assesstime != null];?></td>
    <?php endif;?>
<!--     <?php if ((($curRole == 'teacher')||($curRole == 'student')) && ($viewtype != 'done')):?>
      <td class='text-center'>
        <?php         
          if ($task->completetime == null or $task->completetime == '0000-00-00 00:00:00')
          {
            if ($task->begintime <= helper::now())
            {
              if ($task->submittime == null)
                common::printIcon('task', 'submit', "taskID=$task->id", '', 'list', 'ok-sign'); 
              else
                common::printIcon('task', 'editsubmit', "taskID=$task->id", '', 'list', 'edit', '', 'iframe', true);                  
            }
            
            if ($viewtype != 'all')
            {
              if ($task->submittime != null)
              {
                common::printIcon('task', 'assess', "taskID=$task->id", '', 'list', 'edit');
              }

              if ($task->assesstime != null)
              {
                common::printIcon('task', 'finish', "taskID=$task->id", '', 'list', 'ok');
              }
                common::printIcon('task', 'edit', "taskID=$task->id", '', 'list', 'pencil');
                common::printIcon('task', 'delete', "taskID=$task->id", $task, 'list', '', 'hiddenwin');
            }
            else
            {
              common::printIcon('task', 'batchDelete', "taskID=$task->id", $task, 'list', 'remove', 'hiddenwin');
            }       
          }                    
        ?>
      </td>
    <?php endif;//@Green?> -->
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan='<?php echo $columns;?>'>
        <?php $pager->show();?>
      </td>
    </tr>
  </tfoot>
</table> 
<?php include '../../common/view/footer.html.php';?>
