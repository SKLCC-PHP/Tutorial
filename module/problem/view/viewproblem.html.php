<?php include './header.html.php';?>
<div id = 'main'>
  <form method='post' target='hiddenwin' action='<?php echo $this->createLink('problem', 'search');?>' class='form-condensed'>
    <table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
      <input type='hidden' value='<?php echo $viewtype;?>', name='viewtype'/>
      <tr>
        <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
        <td class='text-right w-90px'><?php echo $lang->problem->title;?></td>
        <td><?php echo html::input('title', $searchtitle, 'class=form-control');?></td>
      <?php  if($this->session->userinfo->roleid != 'student'):
      ?>
        <td class='text-right w-60px'><?php echo $lang->problem->creator;?></td>
        <td><?php echo html::input('acpID', $searchstu, 'class=form-control');?></td>
      <?php endif;
        if ($this->session->userinfo->roleid != 'teacher'):?>
        <td class='text-right w-60px'><?php echo $lang->problem->receiver;?></td>
        <td><?php echo html::input('asgID', $searchtea, 'class="form-control chosen"');?></td>
      <?php 
        endif;?>
        <td class='w-120px'>
          <div class='btn-group'>
            <?php
              echo html::submitButton($lang->search);
              echo html::linkButton($lang->goback, $this->inlink('viewProblem'));
            ?>
          </div>
        </td>
      </tr>
    </table>
  </form>
  <br/>
  <table class='table table-condensed table-hover table-striped tablesorter' align="center" id='problemtable'>
    <?php $vars = "viewtype=$viewtype&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
    <thead>
      <tr class='text-center'>
        <th width="10px" class='text-left'> <?php common::printOrderLink('id',$orderBy, $vars, $lang->idAB);?></th>
        <th class='w-150px text-left'><?php common::printOrderLink('title',$orderBy, $vars, $lang->problem->title);?></th>
      <?php if ($this->session->userinfo->roleid != 'student'):?>
        <th class='w-20px'> <?php echo common::printOrderLink('asgID', $orderBy, $vars, $lang->problem->creator);?></th>
      <?php
        endif;
        if ($this->session->userinfo->roleid != 'teacher'):
          if ($viewtype == 'all'):
      ?>
        <th class = 'w-20px'><?php echo $lang->problem->receiverNum;?></th>
      <?php else:?>
        <th class='w-20px'> <?php echo common::printOrderLink('acpID', $orderBy, $vars, $lang->problem->receiver);?></th>
      <?php endif;endif;?>
        <th class='w-50px'> <?php echo common::printOrderLink('createtime', $orderBy, $vars, $lang->problem->createtime);?></th>
      <?php if (($this->session->userinfo->roleid == 'student') && ($viewtype == 'isRead')):?>
        <th class='w-50px'> <?php echo common::printOrderLink('readtime', $orderBy, $vars, $lang->problem->readtime);?></th>
      <?php endif;?>
        <th class='w-40px'> <?php echo $lang->problem->solvetime;?></th>
      <?php if ($viewtype == 'all'):?>
        <th class='w-40px'> <?php echo $lang->problem->isRead;?></th>
      <?php endif;?>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($problems as $problem):?>
      <tr class='text-center'>
        <td class='text-left'><?php echo sprintf('%03d', $problem->id);?></td>
      <?php if ($viewtype == 'all' && $this->session->userinfo->roleid != 'teacher'):?>
        <td class = 'text-left'><?php echo html::a($this->createLink('problem', 'viewGroup', "ID=$problem->id"), $problem->title);?></td>
      <?php else:?>
        <td class='text-left'><?php echo html::a($this->createLink('problem', 'view', "problemID=$problem->id"), $problem->title);?></td>
      <?php endif;if ($this->session->userinfo->roleid != 'student'):?>
        <td><?php echo $users[$problem->asgID];?></td>
      <?php endif;
        if ($this->session->userinfo->roleid != 'teacher'):
          if ($viewtype == 'all'):
      ?>
        <td><?php echo $problem->acpNum;?></td>
      <?php else:?>
        <td><?php echo $users[$problem->acpID];?></td>
      <?php endif;endif;?>
        <td><?php echo $problem->createtime;?></td>
      <?php if (($this->session->userinfo->roleid == 'student') && ($viewtype == 'isRead')):?>
        <td><?php echo $problem->readtime;?></td>
      <?php endif;?>
        <td><?php echo $problem->solvetime;?></td>
      <?php if ($viewtype == 'all'):?>
        <td><?php echo $lang->problem->readStatusList[($problem->readtime != null) && ($problem->readtime != '0000-00-00 00:00:00')];?></td>
      <?php endif;?>
      </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
        <tr>
        <?php 
        if($viewtype == 'unRead') 
          $columns = 5;
        else
          $columns = 6;
      ?>
          <td colspan='<?php echo $columns;?>'>
            <?php $pager->show();?>
          </td>
        </tr>
    </tfoot>
  </table> 
</div>
<?php include '../../common/view/footer.html.php';?>
