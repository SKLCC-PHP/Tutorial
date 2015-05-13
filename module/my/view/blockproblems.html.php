<div class='panel panel-block' id='projectbox'>
	<?php if(count($problems) == 0):?>
		<div class='panel-heading'>
			<i class='icon-cube icon'></i> <strong><?php echo $lang->problem->common;?></strong>
		</div>
	<?php else:?>
	<table class='table table-condensed table-hover table-striped table-borderless table-fixed'>
		<thead>
			<tr class='text-center'>
				<th class='w-40px'><div class='text-left'><i class="icon icon-cube"></i> <?php echo $lang->problem->title;?></div></th>
				<th class='w-40px' > <?php echo $lang->problem->creator;?></th>
				<?php if($user->roleid == 'teacher'): ?>
				<th class='w-40px' > <?php echo $lang->problem->receiver;?></th>
				<?php else : ?>
				<th class='w-40px' > <?php echo $lang->problem->receiverNum;?></th>
				<?php endif; ?>
				<th class='w-hour' > <?php echo $lang->problem->createtime;?></th>
				<th class='w-hour' > <?php echo $lang->problem->solvetime;?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($problems as $problem):?>
			<tr class='text-center'>
				<?php if($user->roleid == 'teacher'): ?>
				<td class='text-left nobr'><?php echo html::a($this->createLink('problem', 'view', "problemID=$problem->id"), $problem->title);?></td>
				<?php else : ?>
				<td class='text-left nobr'><?php echo html::a($this->createLink('problem', 'viewGroup', "problemID=$problem->id"), $problem->title);?></td>
				<?php endif; ?>
				<td><?php echo $userpairs[$problem->asgID];?></td>
				<?php if($user->roleid == 'teacher'): ?>
				<td><?php echo $userpairs[$problem->acpID];?></td>
				<?php else : ?>
				<td><?php echo $problem->acpNum;?></td>
				<?php endif; ?>
				<td><?php echo $problem->createtime;?></td>
				<td><?php echo $problem->solvetime;?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
  </table>
  <div class="pull-right"><?php if(count($problems) >= 5) common::printLink('problem', 'viewProblem', 'viewtype=all', $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
  <?php endif;?>
</div>