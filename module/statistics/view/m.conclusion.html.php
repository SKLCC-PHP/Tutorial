<div class='main'>
  <form method='post' id='indexform'>
    <table class='table w-1000px table-condensed table-hover table-striped table-bordered tablesorter table-fixed' id='indexList'>
      <thead>
      <tr>
        <?php $vars = "browsetype=$browsetype&viewtype=$viewtype&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage";?>
        <th width="30px"> <?php echo $lang->statistics->id;?></th>
        <th class='text-center' width="120px">  <?php common::printOrderLink('account',         $orderBy, $vars, $lang->statistics->account[$viewtype]);?></th>
        <th width="120px">  <?php common::printOrderLink('realname',         $orderBy, $vars, $lang->statistics->realname[$viewtype]);?></th>
        <th width="90px">  <?php common::printOrderLink('TotalNumber',   $orderBy, $vars, $lang->statistics->details->conclusion->TotalNumber);?></th>
        <th width="90px">  <?php common::printOrderLink('AssessedNumber',   $orderBy, $vars, $lang->statistics->details->conclusion->AssessedNumber);?></th>
        <th width="90px">  <?php common::printOrderLink('UnassessedNumber',   $orderBy, $vars, $lang->statistics->details->conclusion->UnassessedNumber);?></th>
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
        <td><?php echo $detail->AssessedNumber;?></td>
        <td><?php echo $detail->UnassessedNumber;?></td>
      </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot>
      <tr>
        <td colspan='6'>
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
