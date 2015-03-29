<div class='panel panel-block' id='projectbox'>
	<?php if(count($tasks) == 0):?>
	<div class='panel-heading'>
		<i class='icon-folder-close-alt icon'></i> <strong><?php echo $lang->task->common;?></strong>
	</div>
	<?php else:?>
	<table class='table table-condensed table-hover table-striped table-borderless table-fixed'>
		<thead>
			<tr class='text-center'>
				<th class='w-40px'><div class='text-left'><?php echo html::icon($lang->icons['tasks']);?> <?php echo $lang->task->title;?></div></th>
				<th class='w-40px' > <?php echo $lang->task->creator;?></th>
				<?php if($user->roleid == 'student'): ?>
				<th class='w-40px' > <?php echo $lang->task->receiver;?></th>
				<?php else : ?>
				<th class='w-40px' > <?php echo $lang->task->receiverNum;?></th>
				<?php endif; ?>
				<th class='w-hour' > <?php echo $lang->task->create_time;?></th>
				<th class='w-hour' > <?php echo $lang->task->deadline;?></th>
			</tr>
	  </thead>
	  <tbody>
		<?php foreach($tasks as $task):?>
		<tr class='text-center'>
			<?php if($user->roleid == 'student'): ?>
			<td class='text-left nobr'><?php echo html::a($this->createLink('task', 'view', "taskID=$task->id"), $task->title);?></td>
			<?php else : ?>
			<td class='text-left nobr'><?php echo html::a($this->createLink('task', 'viewGroup', "taskID=$task->id"), $task->title);?></td>
			<?php endif; ?>
			<td><?php echo $userpairs[$task->asgID];?></td>
			<?php if($user->roleid == 'student'): ?>
			<td><?php echo $userpairs[$task->acpID];?></td>
			<?php else : ?>
			<td><?php echo $task->acpNum;?></td>
			<?php endif; ?>
			<td><?php echo $task->createtime;?></td>
			<td><?php echo $task->deadline;?></td>
		</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div class="pull-right"><?php if(count($tasks) >= 5) common::printLink('task', 'viewTask', 'viewtype=all', $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
	<?php endif;?>
</div>
