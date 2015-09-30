<?php include '../../common/view/header.html.php';?>
<div class='container mw-500px'>
  <div id='titlebar'>
	<div class='heading'>
	  <span class='prefix' title='GROUP'><?php echo html::icon($lang->icons['group']);?></span>
	  <strong><small><?php echo html::icon($lang->icons['create']);?></small> <?php echo $lang->group->create;?></strong>
	</div>
  </div>
  <form class='form-condensed mw-500px pdb-20' method='post' target='hiddenwin' id='dataform'>
	<table align='center' class='table table-form'> 
		<tr>
			<th class='w-80px'><?php echo $lang->group->name;?></th>
			<td><?php echo html::input('name', '', "class = form-control required='required'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->group->role;?></th>
			<td><?php echo html::input('role', '', "class = form-control required='required'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->group->rank;?></th>
			<td><?php echo html::input('rank', '', "class = form-control required='required' onchange='check()'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->group->desc;?></th>
			<td><?php echo html::textarea('desc', '', "rows=5 class=form-control");?></td>
		</tr>
		<tr><td colspan='2' class='text-center'><?php echo html::submitButton();?></td></tr>
	</table>
</form>
</div>
<?php include '../../common/view/footer.html.php';?>
