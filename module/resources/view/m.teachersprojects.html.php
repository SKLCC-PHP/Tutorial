<div class='panel panel-block' id='projectbox'>
  <div class='panel-heading'>
    <i class='icon-folder-close icon'></i><strong><?php echo $lang->project->common;?></strong>
    <?php if (count($projects) > 5):?>
     <div class="pull-right"><?php common::printLink('resources', 'viewMoreProject', "teacher_account=$teacher_account", $lang->more . "&nbsp;<i class='icon-th icon icon-double-angle-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");?></div>
    <?php endif;?>
  </div>
  <table class='table table-condensed table-hover table-striped table-borderless'>
    <?php foreach ($projects as $key => $project):?>
      <tr>
        <th><?php echo '#' . $project->id;?></th>
        <td class='text-left'><?php echo html::a($this->createLink('project', 'view', "projectID=$project->id&is_onlybody=yes", '', true), $project->name, '_self', 'class="iframe"');?></td>
      </tr>
    <?php 
      if ($key == 5) break;
      endforeach;
    ?>
  </table>
</div>