<div class='panel panel-block' id='achoievementbox'>
  <?php if(count($achievements) == 0):?>
    <div class='panel-heading'>
      <i class='icon-bar-chart icon'></i><strong><?php echo $lang->achievement->common;?></strong>
    </div>
    <div class='panel-body text-center'><br><br>
      <span></span>
    </div>
  <?php else:?>
    <table class='table table-condensed table-hover table-striped table-borderless table-fixed'>
      <thead>
        <tr class='text-left'>
          <th class='w-60px'><div class='text-left'><i class='icon-bar-chart icon'></i><?php echo $lang->achievement->title;?></div></th>
          <th class='w-30px'><?php echo $lang->achievement->creator;?></th>
          <th class='w-20px'><?php echo $lang->achievement->type;?></th>
          <th class='w-hour'><?php echo $lang->achievement->create_time;?></th>
          <th class='w-hour'><?php echo $lang->achievement->checktime;?></th>
        </tr>
      </thead>   
      <tbody>
      <?php foreach($achievements as $key => $achievement):?>
        <tr class='text-center'>
          <td class='text-left'><?php echo html::a($this->createLink('achievement', 'view', "achievementID=$achievement->id&is_onlybody=yes", '', true), $achievement->title, '_self', 'class="iframe"');?></td>
          <td><?php echo $userpairs[$achievement->creatorID];?></td>
          <td><?php echo $lang->achievement->typeList[$achievement->type];?></td>
          <td><?php echo $achievement->createtime;?></td>
          <td><?php echo $achievement->checktime;?></td>
        </tr>
      <?php  
          if ($key >= $breakAchNum-1) break;
          endforeach;
      ?>
      </tbody>
    </table>
<?php if ($breakAchNum == 6):?>
    <div class="pull-right"><?php common::printLink('resources', 'viewMoreAchievement', "teacher_account=$teacher_account", $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
<?php endif;?>
<?php endif;?>
</div>
