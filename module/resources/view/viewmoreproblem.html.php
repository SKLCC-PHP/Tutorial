<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->resources->viewMoreProblem . '&nbsp&nbsp&nbsp' . $userpairs[$teacher_account];?></strong>
  </div>
  <div class='actions'>
    <?php echo html::linkButton($lang->goback, $this->inlink('viewTeacherDetails', "teacher_account=$teacher_account"));?>
  </div>
</div>
<div id = 'main'>
  <table class='table table-condensed table-hover table-striped tablesorter'>
  <?php $vars = "teacher_account=$teacher_account&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
    <thead>
		<tr class='text-center'>
		  <th class='w-20px'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
		  <th class='w-60px'><div class='text-left'><?php echo $lang->problem->title;?></div></th>
		  <th class='w-20px' > <?php common::printOrderLink('asgID', $orderBy, $vars, $lang->problem->creator);?></th>
		  <th class='w-20px' > <?php common::printOrderLink('acpID', $orderBy, $vars, $lang->problem->receiver);?></th>
		  <th class='w-hour' > <?php common::printOrderLink('createtime', $orderBy, $vars, $lang->problem->createtime);?></th>
		  <th class='w-hour' > <?php echo $lang->problem->solvetime;?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($problems as $key => $problem):?>
		<tr class='text-center'>
		  <td><?php echo html::a($this->createLink('problem', 'view', "problemID=$problem->id&is_onlybody=yes", '', true), $problem->id, '_self', 'class="iframe"');?></td>
		  <td class = 'text-left'><?php echo html::a($this->createLink('problem', 'view', "problemID=$problem->id&is_onlybody=yes", '', true), $problem->title, '_self', 'class="iframe"');?></td>
		  <td><?php echo $userpairs[$problem->asgID];?></td>
		  <td><?php echo $userpairs[$problem->acpID];?></td>
		  <td><?php echo $problem->createtime;?></td>
		  <td><?php echo $problem->solvetime;?></td>
		</tr>
		<?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <?php $columns = $this->cookie->windowWidth > $this->config->wideSize ? 14 : 12;?>
        <td colspan='<?php echo $columns;?>'>
          <?php $pager->show();?>
        </td>
      </tr>
    </tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>