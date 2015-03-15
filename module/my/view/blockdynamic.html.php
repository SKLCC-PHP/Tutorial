<div class='panel panel-block dynamic'>
	<div class='panel-heading'>
		<?php echo html::icon($lang->icons['dynamic']);?> 
		<strong>
		<?php 
		  echo $lang->my->home->latest;
		?>
		</strong>
	
		<div class="panel-actions pull-right">
			<?php common::printLink('notice', 'dynamic', '', $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>");?>
		</div>
	</div>
	<table class='table table-condensed table-hover table-striped table-borderless table-fixed'>
	<?php 
		foreach($actions as $action)
		{
			$user = isset($users[$action->actor]) ? $users[$action->actor] : $action->actor;
			if($action->action == 'login' or $action->action == 'logout') $action->objectName = $action->objectLabel = '';
			echo "<tr><td class='text-left nobr' width='100%'>";
			echo $action->date, '&nbsp;&nbsp;&nbsp;&nbsp;';
			echo $user, '&nbsp;&nbsp;&nbsp;&nbsp;';
			echo $action->actionLabel, $action->objectLabel, '&nbsp;&nbsp;&nbsp;&nbsp;'; 
			echo $action->objectName;
			echo "</td></tr>";
		}
   ?>
  </table>
</div>
