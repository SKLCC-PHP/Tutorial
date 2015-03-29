<div class='main'>
  <form method='post' id='indexform'>
    <table class='table w-1000px table-condensed table-hover table-striped table-bordered tablesorter table-fixed' id='indexList'>
      <thead>
      <tr>
        <?php $vars = "browsetype=$browsetype&viewtype=$viewtype&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage";?>
        <th width="30px" rowspan="2"> <?php echo $lang->statistics->id;?></th>
        <th class='text-center' width="120px" rowspan="2">  <?php common::printOrderLink('account',         $orderBy, $vars, $lang->statistics->account[$viewtype]);?></th>
        <th width="120px" rowspan="2">  <?php common::printOrderLink('realname',         $orderBy, $vars, $lang->statistics->realname[$viewtype]);?></th>
        <th width="130px" colspan="4">  <?php echo $lang->statistics->details->project->Number;?></th>
        <th width="130px" rowspan="2"> <?php common::printOrderLink('UnderwayNumber',   $orderBy, $vars, $lang->statistics->details->project->UnderwayNumber);?></th>
        <th width="100px" rowspan="2"> <?php common::printOrderLink('FinishedNumber',   $orderBy, $vars, $lang->statistics->details->project->FinishedNumber);?></th>
      </tr>
      <tr class='text-center'>
        <th><?php common::printOrderLink('Number_sum',   $orderBy, $vars, '总数');?></th>
        <th><?php common::printOrderLink('Number_public',   $orderBy, $vars, '公开');?></th>
        <th><?php common::printOrderLink('Numberr_protected',   $orderBy, $vars, '同组');?></th>
        <th><?php common::printOrderLink('Numberr_private',   $orderBy, $vars, '私有');?></th>
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
        <td><?php echo $detail->Number_sum;?></td>
        <td><?php echo $detail->Number_public;?></td>
        <td><?php echo $detail->Number_protected;?></td>
        <td><?php echo $detail->Number_private;?></td>
        <td><?php echo $detail->UnderwayNumber;?></td>
        <td><?php echo $detail->FinishedNumber;?></td>
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
