<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->resources->viewMoreProject . '&nbsp&nbsp&nbsp' . $userpairs[$teacher_account];?></strong>
  </div>
  <div class='actions'>
    <?php echo html::linkButton($lang->goback, $this->inlink('viewTeacherDetails', "teacher_account=$teacher_account"));?>
  </div>
</div>
<div id = 'main'>
  <table class='table table-condensed table-hover table-striped tablesorter'>
  <?php $vars = "teacher_account=$teacher_account&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
    <thead>
      <tr class='text-center'>
        <th class='w-20px'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
        <th class='w-90px'><div class='text-left'><?php echo $lang->project->name;?></div></th>
        <th class = 'w-50px'> <?php  common::printOrderLink('PID', $orderBy, $vars, $lang->project->ID);?></th>
        <th class = 'w-50px'> <?php echo $lang->project->creater;?> </th>
        <th class = 'w-50px'><?php  echo $lang->project->teacher;?></th>
        <th class = 'w-50px'><?php echo $lang->project->status;?></th>
        <th class = 'w-60px'><?php common::printOrderLink('starttime', $orderBy, $vars, $lang->project->begin);?></th>
        <th class = 'w-60px'><?php common::printOrderLink('deadline', $orderBy, $vars, $lang->project->deadline);?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($projects as $key => $project):?>
      <tr class='text-center'>
        <td><?php echo html::a($this->createLink('project', 'view', "projectID=$project->id&is_onlybody=yes", '', true), $project->id, '_self', 'class="iframe"');?></td>
        <td class='text-left nobr'><?php echo html::a($this->createLink('project', 'view', "projectID=$project->id&is_onlybody=yes", '', true), $project->name, '_self', 'class="iframe"');?></td>
        <td><?php echo $project->PID;?></td>
        <td><?php echo $userpairs[$project->creator_ID];?></td>
        <td><?php echo $userpairs[$project->tea_ID]; ?></td>
        <td><?php echo $lang->project->statusList[$this->loadModel('project')->checkStatus($project)];?></td>
        <td><?php echo substr($project->starttime, 0, 10);?></td>
        <td><?php echo substr($project->deadline, 0, 10);?></td> 
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <?php $columns = $this->cookie->windowWidth > $this->config->wideSize ? 14 : 12;?>
        <td colspan='<?php echo $columns;?>'>
          <?php $pager->show();?>
        </td>
      </tr>
    </tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>