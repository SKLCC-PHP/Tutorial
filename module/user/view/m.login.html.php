<?php
include '../../common/view/m.header.lite.html.php';
$lang->user->placeholder->account  = $lang->user->account;
$lang->user->placeholder->password = $lang->user->password;
js::set('holders', $lang->user->placeholder) ;
?>
<div data-role="header" data-position="fixed">
	<h1 style='margin-left:0px;margin-right:0px'><?php echo $app->company->name;?></h1>
</div>
<div data-role="content" >
<form class='form-condensed' method='post' target='hiddenwin'>
	<table align='center'> 
		<tr><td><?php echo html::input('account')?></td></tr>  
		<tr><td><?php echo html::password('password')?></td></tr>
		<!-- <tr><td><?php echo html::select('lang', $config->langs, $this->app->getClientLang(), 'class=select-2 onchange=selectLang(this.value)');?></td></tr> -->
		<tr>
			<td align='center'>
			<?php 
			echo html::submitButton($lang->login, "data-inline='true' data-theme='b'");
			/*if($app->company->guest) echo html::linkButton($lang->user->asGuest, $this->createLink($config->default->module), '', "data-inline='true'");
			echo html::hidden('referer', $referer);*/
			?>
			</td>
		</tr>  
	</table>
</form>
</div>
<?php include '../../common/view/m.footer.lite.html.php';?>
