<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<?php js::set('roleGroup', $roleGroup);?>
<div id='titlebar'>
	<div class='heading'>
	<span class='prefix'><?php echo html::icon($lang->icons['user']);?></span>
	<strong><small class='text-muted'><?php echo html::icon($lang->icons['batchCreate']);?></small> <?php echo $lang->user->batchCreate;?></strong>
  </div>
</div>

<form class='form-condensed' method='post' target='hiddenwin' id='dataform'>
	<table class='table table-form table-fixed'> 
		<thead>
			<tr>
				<th class='w-40px'><?php echo $lang->idAB;?></th> 
				<th class='w-130px red'><?php echo $lang->user->account;?></th>
				<th class='w-130px red'><?php echo $lang->user->realname;?></th>
				<th class='w-170px'><?php echo $lang->user->college;?></th>
				<th class='w-150px'><?php echo $lang->user->role;?></th>
				<th class="red"><?php echo $lang->user->password;?></th>
			</tr>
		</thead>
		<?php $groupList = $groupList + array('ditto' => $lang->user->ditto)?>
		<?php $collegeList = $collegeList + array('ditto' => $lang->user->ditto)?>
		<?php for($i = 0; $i < $config->user->batchCreate; $i++):?>
		<tr class='text-center'>
			<td><?php echo $i+1;?></td>
			<td><?php echo html::input("account[$i]", '', "class='form-control account_$i' autocomplete='off' ");?></td>
			<td><?php echo html::input("realname[$i]", '', "class='form-control'");?></td>
			<td><?php echo html::select("college_id[$i]", $collegeList, $i > 0 ? 'ditto' : $creatorcollege_id, "class='form-control'");?></td>
			<td><?php echo html::select("group[$i]", $groupList, $i > 0 ? 'ditto' : 'student', "class='form-control'");?></td>
			<td align='left'>
			<div class='input-group'>
			<?php
			echo html::input("password[$i]", '', "class='form-control' autocomplete='off' onkeyup='toggleCheck(this, $i)'");
			if($i != 0) echo "<span class='input-group-addon'><input type='checkbox' name='ditto[$i]' id='ditto$i' " . ($i> 0 ? "checked" : '') . " /> {$lang->user->ditto}</span>";
			?>
			</div>
		  	</td>
		</tr>  
		<?php endfor;?>
		<tr><td colspan='9' class='text-center'><?php echo html::submitButton() . html::backButton();?></td></tr>
	</table>
</form>
<?php include '../../common/view/footer.html.php';?>
