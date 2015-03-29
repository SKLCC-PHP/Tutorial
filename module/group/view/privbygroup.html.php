<form class='form-condensed' method='post' target='hiddenwin'>
	<div id='featurebar'>
		<div class='heading'><i class='icon-lock'></i></div>
		<ul class='nav'>
			<li><?php echo $group->name;?></li>
			<?php $params = "type=byGroup&param=$role_name&menu=%s&version=$version";?>
			<li <?php echo empty($menu) ? "class='active'" : ""?>>
				<?php echo html::a(inlink('managePriv', sprintf($params, '')), $lang->group->all)?>
			</li>

			<?php foreach($lang->menu as $module => $title):?>
			<li <?php echo $menu == $module ? "class='active'" : ""?>>
				<?php echo html::a(inlink('managePriv', sprintf($params, $module)), substr($title, 0, strpos($title, '|')))?>
			</li>
			<?php endforeach;?>

			<li <?php echo $menu == 'other' ? "class='active'" : "";?>>
				<?php echo html::a(inlink('managePriv', sprintf($params, 'other')), $lang->group->other);?>
			</li>
		</ul>
	</div>
	<table class='table table-hover table-striped table-bordered table-form'> 
		<thead>
			<tr>
				<th><?php echo $lang->group->module;?></th>
				<th><?php echo $lang->group->method;?></th>
			</tr>
		</thead>
		<?php foreach($lang->resource as $moduleName => $moduleActions):?>
			<?php if(!$this->group->checkMenuModule($menu, $moduleName)) continue;?>
			<tr class='<?php echo cycle('even, bg-gray');?>'>
				<th class='text-right w-150px'><?php echo $this->lang->$moduleName->common;?><?php echo html::selectAll($moduleName, 'checkbox')?></th>
				<td id='<?php echo $moduleName;?>' class='pv-10px'>
					<?php $i = 1;?>
					<?php foreach($moduleActions as $action => $actionLabel):?>
					<?php if(!empty($version) and strpos($changelogs, ",$moduleName-$actionLabel,") === false) continue;?>
					<div class='group-item'>
						<input type='checkbox' name='actions[<?php echo $moduleName;?>][]' value='<?php echo $action;?>' <?php if(isset($groupPrivs[$moduleName][$action])) echo "checked";?> />
						<span class='priv' id="<?php echo $moduleName . '-' . $actionLabel;?>"><?php echo $lang->$moduleName->$actionLabel;?></span>
					</div>
					<?php endforeach;?>
				</td>
			</tr>
		<?php endforeach;?>
		<tr>
			<th class='text-right'><?php echo $lang->selectAll . html::selectAll('', 'checkbox')?></th>
			<td>
				<?php 
				echo html::submitButton($lang->save, "onclick='setNoChecked()'");
				echo html::linkButton($lang->goback, $this->createLink('group', 'browse'));
				echo html::hidden('foo'); // Just a hidden var, to make sure $_POST is not empty.
				echo html::hidden('noChecked'); // Save the value of no checked.
				?>
			</td>
		</tr>
	</table>
</form>
<script type='text/javascript'>
var role_name = <?php echo $role_name?>;
var menu    = "<?php echo $menu?>";
</script>
