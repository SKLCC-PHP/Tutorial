<?php 
  include '../../tutorial/view/header.html.php';
  include '../../common/view/treeview.html.php';
?>
<div class='main'>
  <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutorial', 'search');?>' class='form-condensed'>
  <input type='hidden' value='viewSomeStudent', name='method'/>
    <table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
      <tr>
        <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->tutorial->search;?></big></th>
        <td class='text-right w-60px'><?php echo $lang->tutorial->name;?></td>
        <td><?php echo html::input('name', $searchname, 'class=form-control');?></td>
        <td class='text-right w-60px'><?php echo $lang->tutorial->stu_account;?></td>
        <td><?php echo html::input('account', $searchaccount, 'class=form-control');?></td>
        <td class='w-120px'>
          <div class='btn-group'>
            <?php
              echo html::submitButton($lang->tutorial->search);
              echo html::linkButton($lang->goback, $this->inlink('viewSomeStudent'));
            ?>
          </div>
        </td>
      </tr>
    </table>
  </form>
  <br/>
  <table class='table table-condensed table-hover table-striped tablesorter' id='allstudentList'>
    <?php $vars = "paramname=$searchname&paramaccount=$searchaccount&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
      <thead>
        <tr>
          <th class = 'w-100px'><?php common::printOrderLink('realname', $orderBy, $vars, $lang->tutorial->name);?></th>
          <th class = 'w-100px'><?php common::printOrderLink('account', $orderBy, $vars, $lang->tutorial->stu_account);?></th>
          <th class = 'w-100px'><?php echo $lang->tutorial->gender;?></th>
          <th class = 'w-100px'><?php common::printOrderLink('specialty', $orderBy, $vars, $lang->tutorial->specialty);?></th>
          <th class = 'w-100px'><?php echo $lang->tutorial->mobile;?></th>
          <th class = 'w-200px'><?php echo $lang->tutorial->tutor;?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($students as $student):?>
      	<tr class = 'text-center'>
      	  <td><?php echo $student->realname;?></td>
      	  <td><?php echo $student->account;?></td>
      	  <td><?php echo $lang->user->genderList[$student->gender];?></td>
      	  <td><?php echo $student->specialty;?></td>
      	  <td><?php echo $student->mobile;?></td>
      	  <td><?php foreach ($student->tutor as $value) echo $value . '&nbsp&nbsp&nbsp&nbsp';?>
      	  </td>
      	</tr>
      <?php endforeach;?>
      </tbody>
      <tfoot>
        <tr>
        <?php $columns = 6;?>
          <td colspan='<?php echo $columns;?>'>
            <?php $pager->show();?>
          </td>
        </tr>
      </tfoot>
    </table>
</div>


<?php include '../../common/view/footer.html.php';?>