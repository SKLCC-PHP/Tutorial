<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->project->list;?></strong>
  </div>
  <div class='actions'>
    <?php common::printIcon('project', 'create');?>
  </div>
</div>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('project', 'search');?>' class='form-condensed'>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->project->name;?></td>
    <td><?php echo html::input('name', $searchname, 'class=form-control');?></td>
    <td class='text-right w-90px'><?php echo $lang->project->creater;?></td>
    <td><?php echo html::input('creator_ID', $searchstu, 'class=form-control');?></td>
  <?php if ($this->session->userinfo->roleid != 'teacher'):?>
    <td class='text-right w-90px'><?php echo $lang->project->teacher;?></td>
    <td><?php echo html::input('tea_ID', $searchtea, 'class="form-control chosen"');?></td>
  <?php 
    endif;?>
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
  <table class='table table-condensed table-hover table-striped tablesorter' id='projectList'>
    <?php $vars = "orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
      <thead>
        <tr class = 'text-center'>
          <th class = 'w-30px'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
          <th class = 'w-p30 text-left'> <?php common::printOrderLink('name', $orderBy, $vars, $lang->project->name);?></th>
          <th class = 'w-50px'> <?php  common::printOrderLink('PID', $orderBy, $vars, $lang->project->ID);?></th>
          <th class = 'w-50px'> <?php echo $lang->project->creater;?> </th>
        <?php if ($this->session->userinfo->roleid != 'teacher'):?>
          <th class = 'w-50px'><?php  echo $lang->project->teacher;?></th>
        <?php endif;?>
          <th class = 'w-50px'><?php echo $lang->project->status;?></th>
          <th class = 'w-60px'><?php common::printOrderLink('starttime', $orderBy, $vars, $lang->project->begin);?></th>
          <th class = 'w-60px'><?php common::printOrderLink('deadline', $orderBy, $vars, $lang->project->deadline);?></th>        
<!--         <?php if ($this->session->userinfo->roleid == 'student'):?>  
          <th class='w-50px'><?php echo $lang->actions;?></th>
        <?php endif;?> -->
        </tr>
      </thead>
      <tbody>
      <?php foreach ($projects as $project):?>
        <tr class = 'text-center'>
          <td><?php echo sprintf('%03d', $project->id);?></td>        
          <td class='text-left'><?php common::printLink('project', 'view', "projectID=$project->id", $project->name);?></td>
          <td><?php echo $project->PID;?></td>
          <td><?php echo $project->creator_name;?></td>
        <?php if ($this->session->userinfo->roleid !='teacher'):?>
          <td><?php echo $project->tea_name; ?></td>
        <?php endif;?>
          <td><?php echo $lang->project->statusList[$project->status];?></td>
          <td><?php echo substr($project->starttime, 0, 10);?></td>
          <td><?php echo substr($project->deadline, 0, 10);?></td> 
<!--         <?php if ($this->session->userinfo->roleid == 'student'):?>    
          <td>
            <?php 
            if (($project->priv) && ($project->finishtime == null))
            {
              common::printIcon('project', 'edit', "projectID=$project->id", '', 'list');
              common::printIcon('project', 'delete', "projectID=$project->id", '', 'list', '', 'hiddenwin');

              if (($project->status == 1) || ($project->status == 2))
              {
                common::printIcon('project', 'finish', "projectID=$project->id", '', 'list', '', 'hiddenwin');
              }
                     
            }           
            ?>
          </td>
        <?php endif;?> -->
        </tr>
      <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan='8'>
            <?php $pager->show();?>
          </td>
        </tr>
      </tfoot>
    </table>
</div>


<?php include '../../common/view/footer.html.php';?>
