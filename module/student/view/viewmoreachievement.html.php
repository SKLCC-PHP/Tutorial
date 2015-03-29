<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->student->viewMoreAchievement;?></strong>
  </div>
  <div class='actions'>
    <?php echo html::linkButton($lang->goback, $this->inlink('viewStudentDetails', "student_account=$student_account"));?>
  </div>
</div>
<div id = 'main'>
  <table class='table table-condensed table-hover table-striped tablesorter'>
  <?php $vars = "student_account=$student_account&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
    <thead>
      <tr class='text-center'>
        <th class='w-20px'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
        <th class='w-90px'><div class='text-left'><?php echo $lang->achievement->title;?></div></th>
        <th class='w-30px' > <?php common::printOrderLink('type', $orderBy, $vars, $lang->achievement->type);?></th>
        <th class='w-hour'><?php common::printOrderLink('teaID', $orderBy, $vars, $lang->achievement->tea_ID);?></th>
        <th class='w-hour' > <?php echo $lang->achievement->create_time;?></th>
        <th class='w-30px' > <?php common::printOrderLink('checktime', $orderBy, $vars, $lang->achievement->checktime);?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($achievements as $key => $achievement):?>
      <tr class='text-center'>
        <td><?php echo html::a($this->createLink('achievement', 'view', "achievementID=$achievement->id&is_onlybody=yes", '', true), $achievement->id, '_self', 'class="iframe"');?></td>
        <td class='text-left nobr'><?php echo html::a($this->createLink('achievement', 'view', "achievement=$achievement->id&is_onlybody=yes", '', true), $achievement->title, '_self', 'class="iframe"');?></td>
        <td><?php echo $lang->achievement->typeList[$achievement->type];?></td>
        <td><?php echo $userpairs[$achievement->teaID];?></td>
        <td><?php echo $achievement->createtime;?></td>
        <td><?php echo $achievement->checktime;?></td>
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