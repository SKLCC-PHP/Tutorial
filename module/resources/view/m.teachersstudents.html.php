<div class='panel panel-block' id='projectbox'>
  <?php if(count($students) == 0):?>
    <div class='panel-heading'>
      <i class='icon-group icon'></i><strong><?php echo $lang->tutor->students;?></strong>
    </div>
    <div class='panel-body text-center'><br><br>
      <span></span>
    </div>
  <?php else:?>
    
      <table class='table table-condensed table-hover table-striped table-borderless table-fixed'>
        <thead>
          <tr class='text-center'>
            <th class='w-60px'><div class='text-left'><i class='icon-group icon'></i><?php echo $lang->student->name;?></div></th>
            <th class='w-20px' > <?php echo $lang->user->gender;?></th>
            <th class='w-100px' > <?php echo $lang->user->college;?></th>
            <th class='w-100px' > <?php echo $lang->user->specialty;?></th>
            <th class='w-40px' > <?php echo $lang->user->visits;?></th>
            <th class='w-100px' > <?php echo $lang->user->last;?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($students as $key => $student):?>
          <tr class='text-center'>
            <td class='text-left nobr'><?php echo $student->realname;?></td>
            <td><?php echo $lang->user->genderList[$student->gender];?></td>
            <td><?php echo $collegelist[$student->college_id];?></td>
            <td><?php echo $student->specialty;?></td>
            <td><?php echo $student->visits;?></td>
            <td><?php echo date(DT_DATETIME1, $student->last);;?></td>
          </tr>
          <?php  
            if ($key >= $breakStuNum-1) break;
            endforeach;
          ?>
        </tbody>
      </table>
  <?php if ($breakStuNum == 6):?>
    <div class="pull-right"><?php common::printLink('resources', 'viewmorestudent', "teacher_account=$teacher_account", $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
  <?php endif;?>
<?php endif;?>
</div>
