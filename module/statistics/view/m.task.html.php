<div class='side'>
  <div class='side-body'>
    <div class='panel panel-sm'>
      <div class='panel-heading nobr'><strong><?php echo $lang->statistics->details->common;?></strong></div>
      <div class='panel-body'>
      <ul>
      <?php
        if($this->session->userinfo->roleid == 'student')
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=task&viewtype=student'),  '自己') . "</li>";
        elseif($this->session->userinfo->roleid == 'teacher')
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=task&viewtype=student'),  '我的学生') . "</li>";
        else
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=task&viewtype=student'),  '学生') . "</li>";
        
        if($this->session->userinfo->roleid == 'teacher')
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=task&viewtype=teacher'),  '自己') . "</li>";
        elseif($this->session->userinfo->roleid == 'student')
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=task&viewtype=teacher'),  '我的老师') . "</li>";
        else
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=task&viewtype=teacher'),  '老师') . "</li>";
      ?>
      </ul>
      </div>
    </div>
  </div>
</div>

<div class='main'>
  <form method='post' id='indexform'>
    <table class='table w-1000px table-condensed table-hover table-striped table-bordered tablesorter table-fixed' id='indexList'>
      <thead>
      <?php $vars = "browsetype=$browsetype&viewtype=$viewtype&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=1";?>
      <tr>
        <th width="30px" rowspan="2"> <?php echo $lang->statistics->id;?></th>
        <th class='text-center' width="120px" rowspan="2">  <?php common::printOrderLink('account',         $orderBy, $vars, $lang->statistics->account[$viewtype]);?></th>
        <th width="120px" rowspan="2">  <?php common::printOrderLink('realname',         $orderBy, $vars, $lang->statistics->realname[$viewtype]);?></th>
        <th width="130px" colspan="4">  <?php echo $lang->statistics->details->task->AcceptNumber[$viewtype];?></th>
        <th width="130px" colspan="3"> <?php echo $lang->statistics->details->task->CompleteNumber[$viewtype];?></th>
        <th width="100px" rowspan="2"> <?php common::printOrderLink('UncompleteNumber',   $orderBy, $vars, $lang->statistics->details->task->UncompleteNumber[$viewtype]);?></th>
      </tr>
      <tr class='text-center'>
        <th><?php common::printOrderLink('AcceptNumber_sum',   $orderBy, $vars, '总数');?></th>
        <th><?php common::printOrderLink('AcceptNumber_public',   $orderBy, $vars, '公开');?></th>
        <th><?php common::printOrderLink('AcceptNumber_protected',   $orderBy, $vars, '同组');?></th>
        <th><?php common::printOrderLink('AcceptNumber_private',   $orderBy, $vars, '私有');?></th>
        <th><?php common::printOrderLink('CompleteNumber_sum',   $orderBy, $vars, '总数');?></th>
        <th><?php common::printOrderLink('CompleteNumber_undelayed',   $orderBy, $vars, '按时完成');?></th>
        <th><?php common::printOrderLink('CompleteNumber_delayed',   $orderBy, $vars, '超时完成');?></th>
      </tr>
      </thead>
      <tbody>
      <?php 
        $i=1;
        foreach($details as $detail):
      ?>
      <tr class='text-center'>
        <td><?php echo $i++;?></td>
        <td><?php echo $detail->account;?></td>
        <td><?php echo $detail->realname;?></td>
        <td><?php echo $detail->AcceptNumber_sum;?></td>
        <td><?php echo $detail->AcceptNumber_public;?></td>
        <td><?php echo $detail->AcceptNumber_protected;?></td>
        <td><?php echo $detail->AcceptNumber_private;?></td>
        <td><?php echo $detail->CompleteNumber_sum;?></td>
        <td><?php echo $detail->CompleteNumber_undelayed;?></td>
        <td><?php echo $detail->CompleteNumber_delayed;?></td>
        <td><?php echo $detail->UncompleteNumber;?></td>
      </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot>
      <tr>
        <td colspan='11'>
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
<script>$('#<?php echo $viewtype;?>').addClass('active')</script>
