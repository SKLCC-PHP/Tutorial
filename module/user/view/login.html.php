<?php
include '../../common/view/header.lite.html.php';
?>
<div id='container'>
	<div id='login-panel'>
		<div class='panel-head'>
			<h4><?php printf($lang->systemName, $app->company->name);?></h4>
		</div>

		<div class="panel-content" id="login-form">
			<form method='post' target='hiddenwin' id = 'form_login' class='form-condensed'>
				<input type = "hidden" name = "hidden" value = "login">
				<table class='table table-form'>
					<tr>
						<th width="65px"><?php echo $lang->user->account;?></th>
						<td width="235px" colspan="2"><input class='form-control' type='text' name='account' id='account' /></td>
					</tr>
					<tr>
						<th><?php echo $lang->user->password;?></th>
						<td colspan="2"><input class='form-control' type='password' name='password' id = 'password'/></td>
					</tr>
					<tr>
						<th><?php echo $lang->user->captcha;?></th>
						<td><input class='form-control' type='text' name='captcha' id = 'captcha'/></td>
						<td width="100px">
							<img id="captcha_img" border="0px" src="<?php echo $this->createLink('user', 'captcha');?>?r=<?php echo rand();?>"
							width="100px" height="30px" onclick="document.getElementById('captcha_img').src='<?php echo $this->createLink('user', 'captcha');?>?r='+Math.random()">
						</td>
					</tr>
					<tr>
						<th></th>
						<td colspan="2" id="keeplogin">
							<?php echo html::checkBox('keepLogin', $lang->user->keepLogin, $keepLogin);?>
							<a href="javascript:forgetPassword();">忘记密码</a>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<?php
								echo html::submitButton($lang->login);
							?>
						</td>
					</tr>
				</table>
			</form>

			<form method='post' target='hiddenwin' id = 'form_forget' style = "display:none" class='form-condensed'>
				<input type = "hidden" name = "hidden" value = "forget">
				<table class='table table-form'>
					<tr>
						<th><?php echo $lang->user->account;?></th>
						<td><input class='form-control' type='text' name='account' id='account' /></td>
					</tr>

					<tr>
						<th><?php echo $lang->user->email;?></th>
						<td><input class='form-control' type='text' name='email' id = 'email' /></td>
					</tr>
					<tr>
						<th></th>
						<td >
							<?php echo "输入用户邮箱，获取验证码，然后点击", '</br>';?>
							<a href="javascript:resetPassword();">重置密码</a>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<?php
								echo html::submitButton("发送验证邮件");
							?>
						</td>
					</tr>
				</table>
			</form>

			<form method='post' target='hiddenwin' id = 'form_reset' style = "display:none" class='form-condensed'>
				<input type = "hidden" name = "hidden" value = "reset">
				<table class='table table-form'>
					<tr>
						<th><?php echo $lang->user->account;?></th>
						<td><input class='form-control' type='text' name='account' id='account' /></td>
					</tr>

					<tr>
						<th><?php echo $lang->user->verification_code;?></th>
						<td><input class='form-control' type='text' name='verification_code' id = 'verification_code' /></td>
					</tr>
					<tr>
						<th><?php echo $lang->user->password1;?></th>
						<td><input class='form-control' type='password' name='password1' id = 'password1'/></td>
					</tr>
					<tr>
						<th><?php echo $lang->user->password2;?></th>
						<td><input class='form-control' type='password' name='password2' id = 'password2'/></td>
					</tr>
					<tr>
						<th></th>
						<td >
							<?php echo "请查看您的邮箱，输入验证码，重置密码", '</br>';?>
							<a href="javascript:backLogin();">返回登陆</a>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<?php
								echo html::submitButton("重置密码");
							?>
						</td>
					</tr>
				</table>
			</form>
		</div>

		<div class="panel-foot">
			<tr>demo&emsp;用户名：admin&nbsp;&nbsp;&nbsp;&nbsp;密码：123456</tr>
		</div>

		</div>
		<div id="poweredby">

		</div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
<script type="text/javascript">
	function forgetPassword()
	{
		document.getElementById("form_login").style.display = 'none';
		document.getElementById("form_reset").style.display = 'none';
		document.getElementById("form_forget").style.display = 'block';

	}
	function backLogin()
	{
		document.getElementById("form_forget").style.display = 'none';
		document.getElementById("form_reset").style.display = 'none';
		document.getElementById("form_login").style.display = 'block';
	}
	function resetPassword()
	{
		document.getElementById("form_forget").style.display = 'none';
		document.getElementById("form_login").style.display = 'none';
		document.getElementById("form_reset").style.display = 'block';
	}
</script>
