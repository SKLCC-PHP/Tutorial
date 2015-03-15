<?php include '../../common/view/header.html.php';?>
<div class='container mw-600px'>
  	<div id='titlebar'>
		<div class='heading'>
			<?php echo html::icon($lang->icons['user']);?> <?php echo $lang->personalinfo->common;?>
		</div>
		<div>
			<?php if($user->email == '' && $is_onlybody == 'no'):
				echo "<font color = red>" . $lang->personalinfo->warning . "</font>";
				endif;
			?>
		</div>
		<div class='actions'>
			<?php
				if($is_onlybody == 'no') 
					echo html::a($this->createLink('personalinfo', 'editBasicInformation'), $lang->user->editBasicInformation, '', "class='btn btn-primary'");
			?>
		</div>
	</div>
	<table class='table table-borderless table-data'>
		<tr>
			<th><?php echo $lang->user->account;?></th>
			<td><?php echo $user->account;?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->realname;?></th>
			<td><?php echo $user->realname;?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->gender;?></th>
			<td><?php echo $lang->user->genderList[$user->gender];?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->college;?></th>
			<td><?php echo $collegelist[$user->college_id]; ?></td>
		</tr>
		<?php if($user->roleid == 'student'):?>
			<tr>
				<th><?php echo $lang->user->grade;?></th>
				<td><?php echo $user->grade;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->specialty;?></th>
				<td><?php echo $user->specialty;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->class;?></th>
				<td><?php echo $user->administrativeclass;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->polical_status;?></th>
				<td><?php echo $user->polical_status;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->dormitory;?></th>
				<td><?php echo $user->dormitory;?></td>
			</tr>
		<?php elseif($user->roleid == 'teacher'):?>
			<tr>
				<th><?php echo $lang->user->office;?></th>
				<td><?php echo $user->dormitory;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->research;?></th>
				<td><?php echo $user->research;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->department;?></th>
				<td><?php echo $user->department;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->title;?></th>
				<td><?php echo $user->title;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->phone;?></th>
				<td><?php echo $user->phone;?></td>
			</tr>
		<?php elseif($user->roleid == 'counselor'):?>
			<tr>
				<th><?php echo $lang->user->manager_grade;?></th>
				<td><?php echo $user->grade;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->phone;?></th>
				<td><?php echo $user->phone;?></td>
			</tr>
		<?php elseif($user->roleid == 'manager'):?>
			<tr>
				<th><?php echo $lang->user->office;?></th>
				<td><?php echo $user->dormitory;?></td>
			</tr>
			<tr>
				<th><?php echo $lang->user->phone;?></th>
				<td><?php echo $user->phone;?></td>
			</tr>
		<?php endif;?>
		<tr>
			<th><?php echo $lang->user->mobile;?></th>
			<td><?php echo $user->mobile;?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->email;?></th>
			<td><?php if($user->email) echo html::a("mailto:$user->email", $user->email);?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->qq;?></th>
			<td><?php if($user->qq) echo html::a("tencent://message/?uin=$user->qq", $user->qq);?></td>
		</tr>
		<?php if($is_onlybody == 'yes'):?>
		<tr>
			<th><?php echo $lang->user->visits;?></th>
			<td><?php echo $user->visits;?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->status;?></th>
			<td><?php echo $lang->user->statusList[$user->status];?></td>
		</tr>
		<tr>
			<th><?php echo $lang->user->last;?></th>
			<td><?php echo empty($user->last) ? "暂未登录":date('Y-m-d H:i:s', $user->last);?></td>
		</tr>
		<?php endif;?>
	</table>
</div>
<?php include '../../common/view/footer.html.php';?>
