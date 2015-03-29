<?php include '../../common/view/header.html.php';?>
<div id='featurebar'>
    <ul class='nav'>
        <strong><?php echo $lang->statistics->index;?></strong>
    </ul>

    <div class="actions">
      <div class='btn-group'>
        <?php
          common::printIcon('statistics', 'exportIndex', "viewtype=$viewtype&orderBy=$orderBy", '', 'button', 'download-alt', 'hiddenwin');
        ?>
      </div>
    </div>
</div>

<div class='side'>
  <div class='side-body'>
    <div class='panel panel-sm'>
      <div class='panel-heading nobr'><strong><?php echo $lang->statistics->index;?></strong></div>
      <div class='panel-body'>
      <ul>
      <?php
        if($this->session->userinfo->roleid == 'student')
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'index' ,'viewtype=student'),  '自己') . "</li>";
        elseif($this->session->userinfo->roleid == 'teacher')
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'index' ,'viewtype=student'),  '我的学生') . "</li>";
        else
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'index' ,'viewtype=student'),  '学生') . "</li>";
        
        if($this->session->userinfo->roleid == 'teacher')
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'index' ,'viewtype=teacher'),  '自己') . "</li>";
        elseif($this->session->userinfo->roleid == 'student')
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'index' ,'viewtype=teacher'),  '我的老师') . "</li>";
        else
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'index' ,'viewtype=teacher'),  '老师') . "</li>";
      ?>
      </ul>
      </div>
    </div>
  </div>
</div>
<div class='main'>
  <form method='post' id='indexform'>
    <table class='table w-1000px table-condensed table-hover table-striped tablesorter table-fixed' id='indexList'>
      <thead>
      <tr>
        <?php $vars = "viewtype=$viewtype&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=1";?>
        <th width="30px"> <?php echo $lang->statistics->id;?></th>
        <th class='text-center' width="100px">  <?php common::printOrderLink('account',         $orderBy, $vars, $lang->statistics->account[$viewtype]);?></th>
        <th width="100px">  <?php common::printOrderLink('realname',         $orderBy, $vars, $lang->statistics->realname[$viewtype]);?></th>
        <th width="60px">  <?php common::printOrderLink('TaskNumber',         $orderBy, $vars, $lang->statistics->browse->TaskNumber[$viewtype]);?></th>
        <th width="60px"> <?php common::printOrderLink('ProblemNumber',        $orderBy, $vars, $lang->statistics->browse->ProblemNumber[$viewtype]);?></th>
        <th width="60px"> <?php common::printOrderLink('ProjectNumber',   $orderBy, $vars, $lang->statistics->browse->ProjectNumber[$viewtype]);?></th>
        <th width="60px"><?php common::printOrderLink('AchievementNumber', $orderBy, $vars, $lang->statistics->browse->AchievementNumber[$viewtype]);?></th>
        <th width="60px"><?php common::printOrderLink('ConclusionNumber',   $orderBy, $vars, $lang->statistics->browse->ConclusionNumber[$viewtype]);?></th>
      </tr>
      </thead>
      <tbody>
      <?php 
        $i=1;
        foreach($statistics as $statistic):
      ?>
      <tr class='text-center'>
        <td><?php echo $i++;?></td>
        <td><?php echo $statistic->account;?></td>
        <td><?php echo $statistic->realname;?></td>
        <td><?php echo $statistic->TaskNumber;?></td>
        <td><?php echo $statistic->ProblemNumber;?></td>
        <td><?php echo $statistic->ProjectNumber;?></td>
        <td><?php echo $statistic->AchievementNumber;?></td>
        <td><?php echo $statistic->ConclusionNumber;?></td>
      </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot>
      <tr>
        <td colspan='8'>
          <div class='table-actions clearfix'>
            <div class='text'><?php echo $summary;?></div>
          </div>
          <?php $pager->show();?>
        </td>
      </tr>
      </tfoot>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
<script>$('#<?php echo $viewtype;?>').addClass('active')</script>
