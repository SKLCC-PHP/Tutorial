<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='container mw-800px'>
	<div id='titlebar'>
		<div class='heading'><i class='icon-pencil'></i> <?php echo $lang->my->editBasicInformation;?></div>
	</div>
	<form method='post' target='hiddenwin' class='form-condensed'>
		<fieldset>
			<legend><?php echo $lang->personalinfo->form->lblBasic;?></legend>
			<table class='table table-form'> 
				<tr>
					<th class='w-90px'><?php echo $lang->user->realname;?></th>
					<td width="263px"><?php echo html::input('realname', $user->realname, "class='form-control' autocomplete='off'");?></td>
					<th><?php echo $lang->user->gender;?></th>
					<td><?php echo html::radio('gender', $lang->user->genderList, $user->gender);?></td>
					<!-- <th class='w-90px' rowspan="3"><?php echo $lang->user->avatar;?></th> -->
				</tr>
				<tr>
					<?php if($user->roleid == 'counselor'):?>
					<th><?php echo $lang->user->manager_grade;?></th>
					<td><?php echo html::checkbox('grade', array_slice($years, 0, 4, true), $user->grade);?></td>
					<?php elseif($user->roleid == 'teacher'):?>
					<th><?php echo $lang->user->title;?></th>
					<td><?php echo html::input('title', $user->title,"class='form-control'");?></td>
					<th><?php echo $lang->user->department;?></th>
					<td><?php echo html::input('department', $user->department,"class='form-control'");?></td>
					<?php elseif($user->roleid == 'admin' || $user->roleid == 'manager'):?>
					<th><?php echo $lang->user->college;?></th>
					<td width="263px"><?php echo html::input('college_name', $collegelist[$user->college_id], "class='form-control' required='required'");?></td>
					<?php endif;?>
				</tr>
				<?php if($user->roleid == 'student'):?>
				<tr>
					<th><?php echo $lang->user->polical_status;?></th>
					<td><?php echo html::input('polical_status', $user->polical_status,"class='form-control'");?></td>
					<th><?php echo $lang->user->education_now;?></th>
					<td><?php echo html::select('education', array('本科生'=>'本科生', '研究生'=>'研究生'), '本科生', "class='form-control' required='required'");?></td>
				</tr>
				<?php elseif($user->roleid == 'teacher'):?>
				<tr>
					<th><?php echo $lang->user->education;?></th>
					<td><?php echo html::input('education', $user->education,"class='form-control'");?></td>
					<th><?php echo $lang->user->research;?></th>
					<td><?php echo html::input('research', $user->research, "class = 'form-control'");?></td>
				</tr>
				<?php endif;?>
			</table>
		</fieldset>
		<fieldset>
		<legend><?php echo $lang->personalinfo->form->lblContact;?></legend>
			<table class='table table-form'>
				<tr>
				<th class='w-90px'><?php echo $lang->user->mobile;?></th>
				<td><?php echo html::input('mobile', $user->mobile, "class='form-control'");?></td>
				<th class='w-90px'><?php echo $lang->user->qq;?></th>
				<td><?php echo html::input('qq', $user->qq, "class='form-control'");?></td>
			</tr>  
			<tr>
				<th><?php echo $lang->user->email;?></th>
				<td><?php echo html::input('email', $user->email, "class='form-control' autocomplete='off'");?></td>
				<?php if($user->roleid != 'student'):?>
					<th><?php echo $lang->user->office;?></th>
					<td><?php echo html::input('dormitory', $user->dormitory,"class='form-control'");?></td>
				<?php else:?>
					<th><?php echo $lang->user->dormitory;?></th>
					<td><?php echo html::input('dormitory', $user->dormitory,"class='form-control'");?></td>
				<?php endif;?>
			</tr>
			<tr>
				<?php if($user->roleid != 'student' and $user->roleid != 'admin'):?>
				<th><?php echo $lang->user->phone;?></th>
				<td><?php echo html::input('phone', $user->phone,"class='form-control'");?></td>
				<?php endif;?>
			</tr> 
			</table>
		</fieldset>
		<div class='text-center'><?php echo html::submitButton('', '', 'btn-primary') . ' &nbsp; ' . html::backButton();?></div>
	</form>
</div>
<?php include '../../common/view/footer.html.php';?>
