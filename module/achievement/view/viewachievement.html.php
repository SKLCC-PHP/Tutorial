<?php include '../../common/view/header.html.php';?>

<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->achievement->common;?></strong>
  </div>
  <div class='actions'>
    <?php common::printIcon('achievement', 'create');?>
  </div>
</div>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('achievement', 'search');?>' class='form-condensed'>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->achievement->title;?></td>
    <td><?php echo html::input('title', $searchtitle, 'class=form-control');?></td>
    <td class='text-right w-90px'><?php echo $lang->achievement->type;?></td>
    <td><?php echo html::select('type', $typeList, $searchtype, 'class=form-control');?></td>
  <?php  if($this->session->userinfo->roleid != 'student'):
  ?>
    <td class='text-right w-60px'><?php echo $lang->achievement->creator;?></td>
    <td><?php echo html::input('asgID', $searchtea, 'class=form-control');?></td>
  <?php endif;
    if (($this->session->userinfo->roleid != 'student') && ($this->session->userinfo->roleid != 'teacher')):?>
    <td class='text-right w-60px'><?php echo $lang->achievement->tea_ID;?></td>
    <td><?php echo html::input('acpID', $searchstu, 'class="form-control chosen"');?></td>
  <?php endif;?>
    <td class='w-120px'>
      <div class='btn-group'>
        <?php
          echo html::submitButton($lang->search);
          echo html::linkButton($lang->goback, $this->inlink('viewAchievement'));
        ?>
      </div>
    </td>
  </tr>
</table>
</form>
<br/>
<form method='post' id='myachievementForm'>
  <table class='table table-condensed table-hover table-striped tablesorter table-fixed' align="center" id='achievementtable'>
  <?php $vars = "orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
    <thead>
    <tr class='text-center'>
      <th width="10px" class='text-left'> <?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
      <th class='w-90px text-left'> <?php echo $lang->achievement->title;?></th>
      <th class='w-hour'> <?php common::printOrderLink('type', $orderBy, $vars, $lang->achievement->type);?></th>
    <?php if ($this->session->userinfo->roleid != 'student'):?>
      <th class='w-hour'> <?php common::printOrderLink('creatorID', $orderBy, $vars, $lang->achievement->creator);?></th>
    <?php endif;
    if ($this->session->userinfo->roleid != 'teacher'):?>
      <th class='w-hour'> <?php common::printOrderLink('teaID', $orderBy, $vars, $lang->achievement->tea_ID);?></th>
    <?php endif;?>
      <th class='w-hour'> <?php echo $lang->achievement->create_time;?></th>
      <th class='w-hour'> <?php common::printOrderLink('checked', $orderBy, $vars, $lang->achievement->ischecked);?></th>
<!--     <?php if ($this->session->userinfo->roleid != 'teacher'):?>  
      <th class='w-20px'> <?php echo $lang->actions;?></th>
    <?php endif;?> -->
    </tr>
    </thead>   
    <tbody>
    <?php foreach($achievements as $achievement):?>
    <tr class='text-center'>
      <td class='text-left'><?php echo sprintf('%03d', $achievement->id);?></td>
      <td class='text-left nobr'><?php echo html::a($this->createLink('achievement', 'view', "achievementID=$achievement->id"), $achievement->title);?></td>
      <td><?php echo $lang->achievement->typeList[$achievement->type];?></td>
    <?php if ($this->session->userinfo->roleid != 'student'):?>
      <td><?php echo $userpairs[$achievement->creatorID];?></td>
    <?php endif;
    if ($this->session->userinfo->roleid != 'teacher'):?>
      <td><?php echo $userpairs[$achievement->teaID];?></td>
    <?php endif;?>
      <td><?php echo $achievement->createtime;?></td>
      <td><?php echo $lang->achievement->checkedList[$achievement->checked];?></td>
<!--     <?php if ($this->session->userinfo->roleid != 'teacher'):?> 
      <td class='text-center'>
        <?php
        if($achievement->checked != 1)
          common::printIcon('achievement', 'edit', "achievementID=$achievement->id", '', 'list', 'pencil');
        common::printIcon('achievement', 'delete', "achievementID=$achievement->id", '', 'list', '', 'hiddenwin');
        common::printIcon('achievement', 'check', "achievementID=$achievement->id", '', 'list', '', '', 'iframe', true, "data-width='900'");
        ?>
      </td>
    <?php endif;?> -->
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <?php 
          if ($this->session->userinfo->roleid == 'teacher')
          {
            $columns = 6;
          }
          elseif($this->session->userinfo->roleid == 'student')
          {
            $columns = 6;
          }
          else
          {
            $columns = 7;
          }
        ;?>
          <td colspan='<?php echo $columns;?>'>
            <?php $pager->show();?>
          </td>
        </tr>
    </tfoot>
  </table> 
</form>
<?php include '../../common/view/footer.html.php';?>
