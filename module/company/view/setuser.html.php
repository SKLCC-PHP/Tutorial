<?php
/**
 * The browse view file of product dept of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: browse.html.php 5096 2013-07-11 07:02:43Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php 
include '../../common/view/header.html.php';
js::set('confirmDelete', $lang->user->confirmDelete);
?>
<div class='main'>
<form action='<?php echo $this->createLink('user', 'batchEdit'/*@Green*/)?>' method='post' id='userListForm'>
  <table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='userList'>
    <thead>
    <tr class='colhead'>
      <?php $vars = "param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
      <th class='w-120px'><?php common::printorderlink('realname', $orderBy, $vars, $lang->user->realname);?></th>
      <th class='w-120px'><?php common::printOrderLink('account',  $orderBy, $vars, $lang->user->account);?></th>
      <th class='w-120px'><?php common::printOrderLink('role',     $orderBy, $vars, $lang->user->role);?></th>
      <th class='w-150px'><?php common::printOrderLink('email',    $orderBy, $vars, $lang->user->email);?></th>
      <th><?php common::printOrderLink('gender',   $orderBy, $vars, $lang->user->gender);?></th>
      <th class='w-150px'><?php common::printOrderLink('mobile',    $orderBy, $vars, $lang->user->mobile);?></th>
      <th class='w-150px'><?php common::printOrderLink('qq',       $orderBy, $vars, $lang->user->qq);?></th>
      <th class='w-120px'><?php common::printOrderLink('join',     $orderBy, $vars, $lang->user->join);?></th>
      <th class='w-120px'><?php common::printOrderLink('last',     $orderBy, $vars, $lang->user->last);?></th>
      <th class='w-120px'><?php common::printOrderLink('visits',   $orderBy, $vars, $lang->user->visits);?></th>
      <th class='w-120px'><?php echo $lang->actions;?></th>
    </tr>
    </thead>
    <tbody>
    
    <?php 
    $canManageContacts = common::hasPriv('user', 'manageContacts');
    ?>
    <?php foreach($users as $user):?>
    <tr class='text-center'>
      <td><?php echo $user->realname;?></td>
      <td><?php echo $user->account;?></td>
      <td><?php echo $lang->user->roleList[$user->roleid];?></td>
      <td><?php echo html::mailto($user->email);?></td>
      <td><?php if(isset($lang->user->genderList[$user->gender])) echo $lang->user->genderList[$user->gender];?></td>
      <td><?php echo $user->phone;?></td>
      <td><?php if($user->qq) echo html::a("tencent://message/?uin=$user->qq", $user->qq);?></td>
      <td><?php echo $user->join;?></td>
      <td><?php if($user->last) echo date('Y-m-d', $user->last);?></td>
      <td><?php echo $user->visits;?></td>
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
      <td colspan='11'>
      <div class='table-actions clearfix'>
      <?php
      if($canBatchEdit or $canManageContacts) echo "<div class='input-group'>" . html::selectButton() . '</div>';
     //@删除维护列表@Green
      ?>
      </div>
      <?php echo $pager->show();?>
      </td>
    </tr>
    </tfoot>
  </table>
</form>
</div>

<?php include '../../common/view/footer.html.php';?>
