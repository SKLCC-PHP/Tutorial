<div class='panel panel-block' id='problembox' style="height:205px">
  <?php if(count($problems) == 0):?>
    <div class='panel-heading'>
      <i class='icon-cube icon'></i><strong><?php echo $lang->problem->common;?></strong>
    </div>
    <div class='panel-body text-center'><br><br>
      <span></span>
    </div>
  <?php else:?>
    <table class='table table-condensed table-hover table-striped table-borderless'>
      <thead>
        <tr class='text-center'>
          <th class='w-60px nobr'><div class='text-left'><i class='icon-cube icon'></i><?php echo $lang->problem->title;?></div></th>
          <th class='w-20px' > <?php echo $lang->problem->receiver;?></th>
          <th class='w-hour' > <?php echo $lang->problem->createtime;?></th>
          <th class='w-hour' > <?php echo $lang->problem->solvetime;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($problems as $key => $problem):?>
        <tr class='text-center'>
          <td class = 'text-left'><?php echo html::a($this->createLink('problem', 'view', "problemID=$problem->id&is_onlybody=yes", '', true), $problem->title, '_self', 'class="iframe"');?></td>
          <td><?php echo $userpairs[$problem->acpID];?></td>
          <td><?php echo $problem->createtime;?></td>
          <td><?php echo $problem->solvetime;?></td>
       </tr>
      <?php  
        if ($key >= $breakPromNum-1) break;
        endforeach;
      ?>
    </tbody>
  </table>
<?php if ($breakPromNum == 5):?>
    <div class="pull-right"><?php common::printLink('student', 'viewMoreProblem', "student_account=$student_account", $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
<?php endif;?>
<?php endif;?>
</div>
