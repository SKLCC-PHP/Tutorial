<?php include '../../tutor/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutor', 'search');?>' class='form-condensed'>
  <input type='hidden' value='viewStudent' name='method'/> 
  <input type='hidden' value='<?php echo $tutor_account;?>' name='teaAccount'/>
  <table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
    <tr>
      <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->tutorial->search;?></big></th>
      <td class='text-right w-60px'><?php echo $lang->user->account;?></td>
      <td><?php echo html::input('account', $searchaccount, 'class=form-control');?></td>
      <td class='text-right w-60px'><?php echo $lang->user->realname;?></td>
      <td><?php echo html::input('name', $searchname, 'class=form-control');?></td>
      <td class='w-120px'>
        <div class='btn-group'>
          <?php
            echo html::submitButton($lang->search);
            echo html::linkButton($lang->goback, $this->inlink('viewStudent'));
          ?>
        </div>
      </td>
    </tr>
  </table>
</form>
<br/>
<div class='main'>
  <table class='table table-condensed table-hover table-striped tablesorter' align="center" id='studenttable'>
    <thead>
    <tr class='text-center'>
      <th class='w-100px'><?php echo $lang->user->account;?></th>
      <th class='w-100px'><?php echo $lang->user->realname;?></th>
      <th class="w-150px"><?php echo $lang->user->specialty;?></th>
      <th class="w-100px"><?php echo $lang->user->mobile;?></th>
      <th class='w-150px'><?php echo $lang->user->email;?></th>
      <th class='w-150px'><?php echo $lang->user->last;?></th>
    </tr>
    </thead>   
    <tbody>
    <?php foreach($students as $student):?>
    <tr class='text-center'>
      <td><?php echo html::a($this->createLink('tutor', 'viewStudentDetails', "student_account=$student->account"), $student->account);?></td>
      <td><?php echo html::a($this->createLink('tutor', 'viewStudentDetails', "student_account=$student->account"), $student->realname);?></td>
      <td><?php echo $student->specialty;?></td>
      <td><?php echo $student->mobile;?></td>
      <td><?php echo $student->email;?></td>
      <td><?php echo date('Y-m-d H:i:s', $student->last);?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
  </table> 
</div>
<?php include '../../common/view/footer.html.php';?>
