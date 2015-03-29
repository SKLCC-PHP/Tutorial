<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->student->viewAll;?></strong>
  </div>
</div>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('student', 'search');?>' class='form-condensed'>
  <input type='hidden' value='viewAll' name='method'/> 
  <table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
    <tr>
      <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
      <td class='text-right w-60px'><?php echo $lang->user->account;?></td>
      <td><?php echo html::input('account', $searchaccount, 'class=form-control');?></td>
      <td class='text-right w-60px'><?php echo $lang->user->realname;?></td>
      <td><?php echo html::input('name', $searchname, 'class=form-control');?></td>
      <td class='w-120px'>
        <div class='btn-group'>
          <?php
            echo html::submitButton($lang->search);
            echo html::linkButton($lang->goback, $this->inlink('viewAll'));
          ?>
        </div>
      </td>
    </tr>
  </table>
</form>
<br/>
<div id = 'main'>
  <table class='table table-condensed table-hover table-striped tablesorter' align = 'center' id='graduateList'>
    <?php $vars="orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID";?>
    <thead>
      <tr class='text-center'>
        <th class = 'w-100px'><?php common::printOrderLink('account', $orderBy, $vars, $lang->student->account);?></th>
        <th width = '100px'><?php echo $lang->student->name;?></th>
        <th width = '100px'><?php common::printOrderLink('gender', $orderBy, $vars, $lang->student->gender);?></th>
        <th width = '150px'><?php echo $lang->student->specialty;?></th>
        <th width = '100px'><?php echo $lang->student->mobile;?></th>
        <th width = '100px'><?php echo $lang->student->email;?></th>        
      </tr>
    </thead>    
    <tbody>
    <?php foreach ($students as $student):?>
    	<tr class = 'text-center'>
    	  <td><?php echo html::a($this->createLink('student', 'viewStudentDetails', "student_account=$student->account"), $student->account);?></td>
    	  <td><?php echo html::a($this->createLink('student', 'viewStudentDetails', "student_account=$student->account"), $student->realname);?></td>
    	  <td><?php echo $lang->user->genderList[$student->gender]?></td>
        <td><?php echo $student->specialty;?></td>
        <td><?php echo $student->mobile;?></td>
        <td><?php echo $student->email;?></td>
    	  <!-- <td><?php echo $student->college_name;?></td> -->
    	  
    	</tr>
    <?php endforeach;?>
    </tbody> 
    <tfoot>
      <tr>
      <?php $columns = 7;?>
        <td colspan='<?php echo $columns;?>'>
          <?php $pager->show();?>
        </td>
      </tr>
    </tfoot>  
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
