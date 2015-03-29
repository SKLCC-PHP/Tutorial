<div class='panel panel-block notice'>
	<?php if(count($notices) == 0):?>
	<div class='panel-heading'>
		<i class='icon-folder-close-alt icon'></i> <strong><?php echo $lang->notice->common;?></strong>
	</div>
	<?php else:?>
	<table class='table table-condensed table-hover table-striped table-borderless table-fixed'>
		<thead>
			<tr class='text-center'>
				<th class='w-60px'><div class='text-left'><?php echo html::icon($lang->icons['dynamic']);?><?php echo $lang->notice->common;?></div></th>
				<th class='w-40px' > <?php echo $lang->notice->date;?></th>
			</tr>
	  </thead>
	  <tbody>
		<?php foreach($notices as $notice):?>
		<tr class='text-center'>
			<td class='text-left nobr'>
			<?php 
				$title = '';
			    if(strlen($notice->title)>=42)
          			$title = substr($notice->title, 0, 42);
          		else
          			$title = $notice->title;
				echo html::a($this->createLink('notice', 'view', "noticeID=$notice->id"), $title);
			?>
			</td>
			<td><?php echo $notice->createtime;?></td>
		</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div class="pull-right"><?php if(count($notices) >= 13) common::printLink('notice', 'viewNotice', '', $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
	<?php endif;?>
</div>
