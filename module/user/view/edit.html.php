<?php include '../../common/view/header.html.php';?>

<div class="row">
<div class='col-md-6'>
	<div id='titlebar'>
		<div class='heading'>
			<span class='prefix' title='USER'><?php echo html::icon($lang->icons['user']);?></span>
			<strong><?php  echo $user->realname;?> (<small><?php echo $user->account;?></small>)</strong>
			<small class='text-muted'> <?php echo $lang->user->edit;?> <?php echo html::icon($lang->icons['edit']);?></small>
		</div>
	</div>
	<form class='form-condensed mw-500px' method='post' target='hiddenwin' id='dataform'>
		<table align='center' class='table table-form '>
		<tr>
			<th><?php echo $lang->user->realname;?></th>
			<td><?php echo html::input('realname', $user->realname, "class='form-control' required='required'");?>
		</tr>
		<tr>
			<th><?php echo $lang->user->gender;?></th>
			<td><?php echo html::radio('gender', $lang->user->genderList, $user->gender);?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->role;?></th>
			<?php if(!$can_edit) :?>
				<td><?php echo html::input('role_name', $groupList[$user->roleid], "class='form-control' readonly = 'true' required='required' autocomplete='off'");?></td>
			<?php else :?>
				<td><?php echo html::select('groups', $groupList, $user->roleid, "class='form-control' required='required'");?></td>
			<?php endif;?>
		</tr>
		<tr>
			<?php if($user->roleid == 'student'):?>
			<th><?php echo $lang->user->grade;?></th>
			<td><?php echo html::select('grade', $years, date('Y'),"class='form-control'");?></td>
			<?php elseif($user->roleid == 'counselor'): ?>
			<th><?php echo $lang->user->manager_grade;?></th>
			<td><?php echo html::checkbox('grade', array_slice($years, 0, 4, true), $user->grade);?></td>
			<?php endif;?>
		</tr>
		<tr>
			<th><?php echo $lang->user->collegeName;?></th>
			<?php if($this->session->user->roleid == 'admin' || $this->session->user->roleid == 'manager') :?>
				<td><?php echo html::select('college_id', $collegeList, $user->college_id, "class='form-control' required='required'");?></td>
			<?php endif;?>
		</tr>
		<?php if($user->roleid == 'student'):?>
		<tr>
			<th><?php echo $lang->user->specialty;?></th>
			<td><?php echo html::input('specialty', $user->specialty,"class='form-control'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->class;?></th>
			<td><?php echo html::input('administrativeclass', $user->administrativeclass,"class='form-control'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->education_now;?></th>
			<td><?php echo html::select('education', array('本科生'=>'本科生', '研究生'=>'研究生'), '本科生', "class='form-control' required='required'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->dormitory;?></th>
			<td><?php echo html::input('dormitory', $user->dormitory,"class='form-control'");?></td>
		</tr>
		<?php elseif($user->roleid == 'teacher'):?>
		<tr>
			<th><?php echo $lang->user->research;?></th>
			<td><?php echo html::input('research', $user->research, "class = 'form-control'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->title;?></th>
			<td><?php echo html::input('title', $user->title,"class='form-control'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->office;?></th>
			<td><?php echo html::input('dormitory', $user->dormitory,"class='form-control'");?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->department;?></th>
			<td><?php echo html::input('department', $user->department,"class='form-control'");?></td>
		</tr>
		<?php endif;?>
		<tr>
			<td colspan='5' class='text-center'><?php echo html::submitButton('修改信息') . html::backButton();?></td>
		</tr>
		</table>
	</form>
</div>
<div class='col-md-6'>

<div id='titlebar'>
		<div class='heading'>
			<span class='prefix' title='USER'><?php echo html::icon($lang->icons['user']);?></span>
			<strong><?php  echo $user->realname;?> (<small><?php echo $user->account;?></small>)</strong>
			<small class='text-muted'> <?php echo $lang->user->editPassword;?> <?php echo html::icon($lang->icons['editPassword']);?></small>
		</div>
	</div>
	<form class='form-condensed mw-500px' method='post' target='hiddenwin'>
			<table align='center' class='table table-form '> 
			<tr>
				<th><?php echo $lang->user->password;?></th>
				<td><?php echo html::password('password1', '', "class='form-control' required='required' autocomplete='off'");?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->password2;?></th>
				<td><?php echo html::password('password2', '', "class='form-control' required='required' autocomplete='off'");?></td>
			</tr>
			<tr>
				
				<td colspan='5' class='text-center'><?php echo html::submitButton('修改密码', '', 'btn-primary') . html::backButton();?></td>
			</tr>
			</table>
		</form>  
</div>

</div>
<?php include '../../common/view/footer.html.php';?>
