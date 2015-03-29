<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php js::set('holders', $lang->user->placeholder);?>

<div class='container mw-600px'>
	<div id='titlebar'>
	<div class='heading'>
		<span class='prefix'>
			<?php echo html::icon($lang->icons['user']);?>
		</span>
		<strong>
			<small class='text-muted'>
				<?php echo html::icon($lang->icons['create']);?>
			</small> <?php echo $lang->user->create;?>
		</strong>
	</div>
	</div>
	<form class='form-condensed mw-500px' method='post' target='hiddenwin' id='dataform'>
		<table align='center' class='table table-form' id="info"> 
		<tr>
			<th><?php echo $lang->user->collegeName;?></th>
			<?php if($role_id != 'admin') :?>
				<td><?php echo html::input('college', $creatorcollege, "class='form-control' readonly = 'true' required='required' autocomplete='off'");?></td>
			<?php else :?>
				<td><?php echo html::select('college_id', $collegeList, '100', "class='form-control' required='required'");?></td>
			<?php endif;?>
		</tr>
		<tr id="role">
			<th><?php echo $lang->user->role;?></th>
	        <td><?php echo html::select('group', $groupList, 'student', 'onchange="createCheckbox(\'gradeBox\')" class="form-control" required="required"');?></td>
		</tr>
		<tr id="gradeBox">
		</tr>
		<tr>
			<th width="160px"><?php echo $lang->user->account;?></th>
			<td width="200px"><?php echo html::input('account', '', "class='form-control' required='required' autocomplete='off'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->realname;?></th>
			<td><?php echo html::input('realname', '', "class='form-control' required='required' autocomplete='off'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->password;?></th>
			<td><?php echo html::password('password1', '', "class='form-control' required='required' autocomplete='off'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->password2;?></th>
			<td><?php echo html::password('password2', '', "class='form-control' required='required' autocomplete='off'");?></td>
		</tr>
		<tr id='gradeSelect'>
			<th><?php echo $lang->user->grade;?></th>
			<td><?php echo html::select('grade', $years, date('Y'), 'class="form-control"');?></td>
		</tr>
		<tr id='specialtyInput'>
			<th><?php echo $lang->user->specialty;?></th>
			<td><?php echo html::input('specialty', '',"class='form-control'");?></td>
		</tr>
		<tr id='classInput'>
			<th><?php echo $lang->user->class;?></th>
			<td><?php echo html::input('administrativeclass', '',"class='form-control'");?></td>
		</tr>
		<tr><td colspan='2' class='text-center'><?php echo html::submitButton() . html::backButton();?></td></tr>
		</table>
	</form>
</div>
<?php include '../../common/view/footer.html.php';?>
