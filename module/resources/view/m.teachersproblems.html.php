<div class='panel panel-block' id='problembox'>
  <div class='panel-heading'>
    <i class='icon-cube icon'></i><strong><?php echo $lang->problem->common;?></strong>
    <?php if (count($problems) > 5):?>
     <div class="pull-right"><?php common::printLink('resources', 'viewMoreProblem', "teacher_account=$teacher_account", $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
    <?php endif;?>
  </div>
  <table class='table table-condensed table-hover table-striped table-borderless'>
    <?php foreach ($problems as $key => $problem):?>
      <tr>
        <th><?php echo '#' . $problem->id;?></th>
        <td class='text-left'><?php echo html::a($this->createLink('problem', 'view', "problemID=$problem->id&is_onlybody=yes", '', true), $problem->title, '_self', 'class="iframe"');?></td>
      </tr>
    <?php 
      if ($key == 5) break;
      endforeach;
    ?>
  </table>
</div>