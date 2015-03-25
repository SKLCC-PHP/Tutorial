<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php js::set('browseType', $browseType);?>
<div id='featurebar'>
  <ul class='nav'>
      <strong><?php echo $lang->statistics->common;?></strong>
  </ul>
<!--   <div id='querybox' class='<?php if($browseType =='bysearch') echo 'show';?>'></div> -->
</div>
<div class='main'>
  <form method='post' id='thesisForm'>
    <table class='table w-1000px table-condensed table-hover table-bordered table-striped tablesorter table-fixed' id='thesisList'>
      <thead>
      <tr>
        <?php $vars = "viewType=$viewType&param=$moduleID&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
        <th width="90px" > <?php common::printOrderLink('name',        $orderBy, $vars, $lang->tutor->name);?></th>
        <th width="80px" > <?php common::printOrderLink('student_number',   $orderBy, $vars, $lang->statistics->student_number);?></th>
        <th width="100px"><?php common::printOrderLink('task_number', $orderBy, $vars, $lang->statistics->task_number);?></th>
        <th width="100px"><?php common::printOrderLink('answer_number',   $orderBy, $vars, $lang->statistics->answer_number);?></th>
        <th width="100px"><?php common::printOrderLink('project_number',   $orderBy, $vars, $lang->statistics->project_number);?></th>
        <th width="100px"><?php common::printOrderLink('assess_number',   $orderBy, $vars, $lang->statistics->assess_number);?></th>
        <th width="100px"><?php common::printOrderLink('thesis_number',   $orderBy, $vars, $lang->statistics->thesis_number);?></th>
        <th width="100px"><?php common::printOrderLink('visits',   $orderBy, $vars, $lang->user->visits);?></th>
        <th width="100px"><?php common::printOrderLink('join',   $orderBy, $vars, $lang->user->join);?></th>
        <th width="100px"><?php common::printOrderLink('last',   $orderBy, $vars, $lang->user->last);?></th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($thesises as $thesis):?>
      <tr class='text-center'>
        <td class='text-center'><?php echo $userpairs[$thesis->tea_ID];?></td>
        <td><?php echo $thesis->other_name;?></td>
        <td><?php echo $thesis->create_time;?></td>
        <td><?php echo $thesis->update_time;?></td>
        <td><?php echo $thesis->update_time;?></td>
        <td><?php echo $thesis->update_time;?></td>
        <td><?php echo $thesis->update_time;?></td>
        <td><?php echo $thesis->update_time;?></td>
        <td><?php echo $thesis->update_time;?></td>
        <td><?php echo $thesis->update_time;?></td>
      </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot>
      <tr>
        <td colspan='10'>
          <?php //$pager->show();?>
        </td>
      </tr>
      </tfoot>
    </table>
  </form>
</div>
<script language='javascript'>
$('#module<?php echo $moduleID;?>').addClass('active')
$('#<?php echo $browseType;?>Tab').addClass('active')
</script>
<?php include '../../common/view/footer.html.php';?>
