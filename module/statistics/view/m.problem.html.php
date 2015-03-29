<div class='side'>
  <div class='side-body'>
    <div class='panel panel-sm'>
      <div class='panel-heading nobr'><strong><?php echo $lang->statistics->details->common;?></strong></div>
      <div class='panel-body'>
      <ul>
      <?php
        if($this->session->userinfo->roleid == 'student')
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=problem&viewtype=student'),  '自己') . "</li>";
        elseif($this->session->userinfo->roleid == 'teacher')
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=problem&viewtype=student'),  '我的学生') . "</li>";
        else
          echo "<li id='student'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=problem&viewtype=student'),  '学生') . "</li>";
        
        if($this->session->userinfo->roleid == 'teacher')
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=problem&viewtype=teacher'),  '自己') . "</li>";
        elseif($this->session->userinfo->roleid == 'student')
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=problem&viewtype=teacher'),  '我的老师') . "</li>";
        else
          echo "<li id='teacher'>" . html::a($this->createLink('statistics', 'viewDetails' ,'browsetype=problem&viewtype=teacher'),  '老师') . "</li>";
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
      <tr>
        <?php $vars = "browsetype=$browsetype&viewtype=$viewtype&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage";?>
        <th width="30px" rowspan="2"> <?php echo $lang->statistics->id;?></th>
        <th class='text-center' width="120px" rowspan="2">  <?php common::printOrderLink('account',         $orderBy, $vars, $lang->statistics->account[$viewtype]);?></th>
        <th width="120px" rowspan="2">  <?php common::printOrderLink('realname',         $orderBy, $vars, $lang->statistics->realname[$viewtype]);?></th>
        <th width="130px" colspan="4">  <?php echo $lang->statistics->details->problem->AskNumber[$viewtype];?></th>
        <th width="130px" rowspan="2"> <?php common::printOrderLink('AnsweredNumber',   $orderBy, $vars, $lang->statistics->details->problem->AnsweredNumber[$viewtype]);?></th>
        <th width="100px" rowspan="2"> <?php common::printOrderLink('UnansweredNumber',   $orderBy, $vars, $lang->statistics->details->problem->UnansweredNumber[$viewtype]);?></th>
      </tr>
      <tr class='text-center'>
        <th><?php common::printOrderLink('AskNumber_sum',   $orderBy, $vars, '总数');?></th>
        <th><?php common::printOrderLink('AskNumber_public',   $orderBy, $vars, '公开');?></th>
        <th><?php common::printOrderLink('AskNumber_protected',   $orderBy, $vars, '同组');?></th>
        <th><?php common::printOrderLink('AskNumber_private',   $orderBy, $vars, '私有');?></th>
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
        <td><?php echo $detail->AskNumber_sum;?></td>
        <td><?php echo $detail->AskNumber_public;?></td>
        <td><?php echo $detail->AskNumber_protected;?></td>
        <td><?php echo $detail->AskNumber_private;?></td>
        <td><?php echo $detail->AnsweredNumber;?></td>
        <td><?php echo $detail->UnansweredNumber;?></td>
      </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot>
      <tr>
        <td colspan='9'>
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
