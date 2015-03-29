<div class='main'>
  <form method='post' id='indexform'>
    <table class='table w-1000px table-condensed table-hover table-striped table-bordered tablesorter table-fixed' id='indexList'>
      <thead>
      <tr>
        <?php $vars = "browsetype=$browsetype&viewtype=$viewtype&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage";?>
        <th width="30px"> <?php echo $lang->statistics->id;?></th>
        <th class='text-center' width="120px">  <?php common::printOrderLink('account',         $orderBy, $vars, $lang->statistics->account[$viewtype]);?></th>
        <th width="120px">  <?php common::printOrderLink('realname',         $orderBy, $vars, $lang->statistics->realname[$viewtype]);?></th>
        <th width="90px">  <?php common::printOrderLink('TotalNumber',   $orderBy, $vars, $lang->statistics->details->achievement->TotalNumber);?></th>
        <th width="90px">  <?php common::printOrderLink('ThesisNumber',   $orderBy, $vars, $lang->statistics->details->achievement->ThesisNumber);?></th>
        <th width="90px">  <?php common::printOrderLink('CopyrightNumber',   $orderBy, $vars, $lang->statistics->details->achievement->CopyrightNumber);?></th>
        <th width="90px">  <?php common::printOrderLink('PatentNumber',   $orderBy, $vars, $lang->statistics->details->achievement->PatentNumber);?></th>
        <th width="90px">  <?php common::printOrderLink('ResearchNumber',   $orderBy, $vars, $lang->statistics->details->achievement->ResearchNumber);?></th>
        <th width="90px">  <?php common::printOrderLink('AwardsNumber',   $orderBy, $vars, $lang->statistics->details->achievement->AwardsNumber);?></th>
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
        <td><?php echo $detail->TotalNumber;?></td>
        <td><?php echo $detail->ThesisNumber;?></td>
        <td><?php echo $detail->CopyrightNumber;?></td>
        <td><?php echo $detail->PatentNumber;?></td>
        <td><?php echo $detail->ResearchNumber;?></td>
        <td><?php echo $detail->AwardsNumber;?></td>
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
