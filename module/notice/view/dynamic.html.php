<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<!--搜索条件待添加-->
<table class='table table-condensed table-hover table-striped tablesorter table-fixed'>
	<thead>
		<tr class='colhead'>
			<th class='w-150px'><?php echo $lang->action->date;?></th>
			<th class='w-140px'> <?php echo $lang->action->actor;?></th>
			<th class='w-100px'><?php echo $lang->action->action;?></th>
			<th class='w-80px'> <?php echo $lang->action->objectType;?></th>
			<th class='w-id'>   <?php echo $lang->idAB;?></th>
			<th><?php echo $lang->action->objectName;?></th>
		</tr>
	</thead>

	<tbody>
		<?php foreach($actions as $action):?>
		<?php $module = $action->objectType == 'case' ? 'testcase' : $action->objectType;?>
		<tr class='text-center'>
		<td><?php echo $action->date;?></td>
		<td>
		<?php 
		$actor = isset($users[$action->actor]) ? $users[$action->actor] : $action->actor;
		echo strpos($actor, ':') === false ? $actor : substr($actor, strpos($actor, ':') + 1);
		?>
		</td>
		<td><?php echo $action->actionLabel;?></td>
		<td><?php echo $lang->action->objectTypes[$action->objectType];?></td>
		<td><?php echo $action->objectID;?></td>
		<td class='text-left'><?php echo $action->objectName;?></td>
		<!-- <td class='text-left'><?php echo html::a($action->objectLink, $action->objectName);?></td> -->
		</tr>
		<?php endforeach;?>
	</tbody>

	<tfoot>
		<tr>
			<td colspan='6'><?php $pager->show();?>
			</td>
		</tr>
	</tfoot>
</table>

<?php include '../../common/view/footer.html.php';?>
