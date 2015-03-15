<?php include '../../common/view/header.html.php';?>
<div class='container mw-500px'>
	<div id='titlebar'>
		<div class='heading'><i class='icon-key'></i> <?php echo $lang->my->changePassword;?></div>
	</div>
	<form class='form-condensed' method='post' target='hiddenwin'>
		<table align='center' class='table table-form w-300px'> 
			<tr>
				<th class='rowhead w-80px'><?php echo $lang->user->account;?></th>
				<td><?php echo $user->account . html::hidden('account',$user->account);?></td>
			</tr>  
			<tr>
				<th><?php echo $lang->user->password;?></th>
				<td><?php echo html::password('password1', '', "class = 'form-control' required='required'");?></td>
			</tr>  
			<tr>
				<th><?php echo $lang->user->password2;?></th>
				<td><?php echo html::password('password2', '', "class='form-control' required='required'");?></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo html::submitButton('', '', 'btn-primary') . html::backButton();?></td>
			</tr>
		</table>
	</form>  
</div>

<?php include '../../common/view/footer.html.php';?>
