<?php 
include '../../common/view/header.html.php';
js::set('confirmDelete', $lang->user->confirmDelete);
?>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('user', 'search');?>' class='form-condensed'>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
<!--   <input type='hidden' value='<?php echo $viewtype;?>', name='viewtype'/> -->
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->user->account;?></td>
    <td><?php echo html::input('account', $searchaccount, 'class=form-control');?></td>
    <td class='text-right w-60px'><?php echo $lang->user->realname;?></td>
    <td><?php echo html::input('realname', $searchrealname, 'class=form-control');?></td>
    <?php if($this->session->user->roleid == 'admin'):?>
    <td class='text-right w-60px'><?php echo $lang->user->college;?></td>
    <td><?php echo html::input('college', $searchcollege, 'class="form-control"');?></td>
    <?php endif;?>
    <td class='text-right w-60px'><?php echo $lang->user->role;?></td>
    <td><?php echo html::input('role', $searchrole, 'class="form-control"');?></td>
    <td class='w-160px'>
      <div class='btn-group'>
        <?php
          echo html::submitButton($lang->search);
          echo html::linkButton($lang->goback, $this->inlink('index'));
        ?>
      </div>
    </td>
  </tr>
</table>
</form>
<br/>
<div class='main'>
	<form action='<?php echo $this->createLink('user', 'batchEdit'/*@Green*/)?>' method='post' id='userListForm'>
		<table class='table table-condensed table-hover table-striped tablesorter' id='userList'>
			<thead>
				<tr class='colhead'>
				<?php $vars = "param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
				<th><?php common::printOrderLink('account', $orderBy, $vars, $lang->user->account);?></th>
				<th width="140px"><?php common::printorderlink('realname', $orderBy, $vars, $lang->user->realname);?></th>
				<?php if($this->session->user->roleid == 'admin'):?>
				<th width="150px"><?php common::printorderlink('collegeid', $orderBy, $vars, $lang->user->college);?></th>
				<?php endif;?>
				<th width="80px"><?php common::printorderlink('roleid', $orderBy, $vars, $lang->user->role);?></th>
				<th><?php common::printOrderLink('mobile',  $orderBy, $vars, $lang->user->mobile);?></th>
				<th width="180px"><?php common::printOrderLink('email', $orderBy, $vars, $lang->user->email);?></th>
				<th><?php common::printOrderLink('createtime', $orderBy, $vars, $lang->user->createtime);?></th>
				<th class='w-125px'><?php common::printOrderLink('last', $orderBy, $vars, $lang->user->last);?></th>
				<th><?php echo $lang->actions;?></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$canManageContacts = common::hasPriv('user', 'manageContacts');
				?>
				<?php foreach($users as $user):?>
				<tr class='text-center'>
					<td><?php echo $user->account;?></td>
					<td><?php echo html::a($this->createLink('personalinfo', 'viewBasicInformation', "account=$user->account&is_onlybody=yes", '', true), $user->realname, '_self', 'class="preview iframe" data-width=\'400\'');?></td>
					<?php if($this->session->user->roleid == 'admin'):?>
					<td><?php echo $collegeList[$user->collegeid];?></td>
					<?php endif;?>
					<td><?php echo $groupList[$user->roleid];?></td>	
					<td><?php echo $user->mobile;?></td>
					<td><?php echo html::mailto($user->email);?></td>
					<td><?php echo $user->createtime;?></td>
					<td><?php if($user->last) echo date('Y-m-d H:i:s', $user->last);?></td>
					<td class='a-left w-80px'>
					<?php 
						common::printIcon('user', 'edit',  "user_account=$user->account&from=company", '', 'list');
						if(strpos($this->app->company->admins, ",{$user->account},") === false and common::hasPriv('user', 'delete'))
						{
							$deleteURL = $this->createLink('user', 'delete', "user_account=$user->account&confirm=yes");
							echo html::a("javascript:ajaxDelete(\"$deleteURL\",\"userList\",confirmDelete)", '<i class="icon-remove"></i>', '', "title='{$lang->user->delete}' class='btn-icon'");
						}
					?>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
				<td colspan='10'>
				<div class='table-actions clearfix'>
				
				</div>
				<?php echo $pager->show();?>
				</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>

<?php include '../../common/view/footer.html.php';?>
