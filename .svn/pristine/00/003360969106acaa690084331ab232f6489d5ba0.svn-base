<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->resources->viewMoreStudent . '&nbsp&nbsp&nbsp' . $userpairs[$teacher_account];?></strong>
  </div>
  <div class='actions'>
    <?php echo html::linkButton($lang->goback, $this->inlink('viewTeacherDetails', "teacher_account=$teacher_account"));?>
  </div>
</div>
<div id = 'main'>
  <table class='table table-condensed table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th class='w-30px'><?php echo $lang->user->account;?></th>
        <th class='w-60px'><?php echo $lang->student->name;?></th>
        <th class='w-20px' > <?php echo $lang->user->gender;?></th>
        <th class='w-100px' > <?php echo $lang->user->college;?></th>
        <th class='w-100px' > <?php echo $lang->user->specialty;?></th>
        <th class='w-40px' > <?php echo $lang->user->visits;?></th>
        <th class='w-100px' > <?php echo $lang->user->last;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($students as $student):?>
        <tr class='text-center'>
          <td><?php echo $student->account;?></td>
          <td><?php echo $student->realname;?></td>
          <td><?php echo $lang->user->genderList[$student->gender];?></td>
          <td><?php echo $collegelist[$student->college_id];?></td>
          <td><?php echo $student->specialty;?></td>
          <td><?php echo $student->visits;?></td>
          <td><?php echo date(DT_DATETIME1, $student->last);;?></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>