<?php include '../../tutor/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutor', 'search');?>' class='form-condensed'>
<input type='hidden' value='viewProject' name='method'/> 
<input type='hidden' value='<?php echo $tutor_account;?>' name='teaAccount'/>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->project->name;?></td>
    <td><?php echo html::input('name', $searchname, 'class=form-control');?></td>
    <td class='text-right w-90px'><?php echo $lang->project->creater;?></td>
    <td><?php echo html::input('creator_ID', $searchstu, 'class=form-control');?></td>
    <td class='w-120px'>
      <div class='btn-group'>
        <?php
          echo html::submitButton($lang->search);
          echo html::linkButton($lang->goback, $this->inlink('viewProject'));
        ?>
      </div>
    </td>
  </tr>
</table>
</form>
<br/>
<div class='main'>
  <table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='projectList'>
    <?php $vars = "tutor_account=$tutor_account&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
      <thead>
        <tr class = 'text-center'>
          <th class = 'w-30px'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
          <th class = 'w-150px text-left'> <?php common::printOrderLink('name', $orderBy, $vars, $lang->project->name);?></th>
          <th class = 'w-50px'> <?php  common::printOrderLink('PID', $orderBy, $vars, $lang->project->ID);?></th>
          <th class = 'w-50px'> <?php echo $lang->project->creater;?> </th>
          <th class = 'w-50px'><?php echo $lang->project->status;?></th>
          <th class = 'w-60px'><?php common::printOrderLink('starttime', $orderBy, $vars, $lang->project->begin);?></th>
          <th class = 'w-60px'><?php common::printOrderLink('deadline', $orderBy, $vars, $lang->project->deadline);?></th>        
        </tr>
      </thead>
      <tbody>
      <?php foreach ($projects as $project):?>
        <tr class = 'text-center'>
          <td><?php echo html::a($this->createLink('tutor', 'viewProjectDetail', "projectID=$project->id"), $project->id);?></td>        
          <td class='text-left'><?php echo html::a($this->createLink('tutor', 'viewProjectDetail', "projectID=$project->id"), $project->name);?></td>
          <td><?php echo $project->PID;?></td>
          <td><?php echo $userpairs[$project->creator_ID];?></td>
          <td><?php echo $lang->project->statusList[$this->project->checkStatus($project)];?></td>
          <td><?php echo substr($project->starttime, 0, 10);?></td>
          <td><?php echo substr($project->deadline, 0, 10);?></td> 
        </tr>
      <?php endforeach; ?>
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