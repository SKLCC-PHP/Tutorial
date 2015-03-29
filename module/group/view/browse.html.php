<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php js::set('confirmDelete', $lang->group->confirmDelete);?>
<div id='titlebar'>
	<div class='heading'><?php echo html::icon($lang->icons['group']);?> <?php echo $lang->group->browse;?></div>
		<div class='actions'>
		<?php common::printIcon('group', 'create', '', '', 'button', '', '', 'iframe', true, "data-width='550'");?>
		<?php if(common::hasPriv('group', 'managePriv')):?>
		<?php echo html::a($this->createLink('group', 'managePriv', 'type=byModule', '', true), $lang->group->managePrivByModule, '', 'class="btn btn-primary iframe"');?>
		<?php endif;?>
	</div>
</div>		
<table align='center' class='table table-condensed table-hover table-striped  tablesorter table-fixed' id='groupList'>
	<thead>
		<tr>
			<th class='w-id'><?php echo $lang->group->id;?></th>
			<th class='w-100px'><?php echo $lang->group->name;?></th>
			<th class='w-p60'><?php echo $lang->group->users;?></th>
			<th class='w-120px {sorter:false}'><?php echo $lang->actions;?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($groups as $group):?>
			<?php 
				$users = implode('、', $groupUsers[$group->role]);
				$users = empty($users) ? $users : $users."等用户";
			?>
			<tr class='text-center'>
			<td class='strong'><?php echo $group->id;?></td>
			<td ><?php echo $group->name;?></td>
			<td class='text-left' title='<?php echo $users;?>'><?php echo $users;?></td>
			<td class='text-center'>
			<?php $lang->group->managepriv = $lang->group->managePrivByGroup;?>
			<?php common::printIcon('group', 'managepriv',   "type=byGroup&param=$group->role", '', 'list', 'lock');?>
			<?php $lang->group->managemember = $lang->group->manageMember;?>
			<?php common::printIcon('group', 'managemember', "role_name=$group->role", '', 'list', 'group', '', 'iframe', 'yes');?>
			<?php common::printIcon('group', 'edit',         "role_name=$group->role", '', 'list', '', '', 'iframe', 'yes', "data-width='550'");?>
			</td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php include '../../common/view/footer.html.php';?>
