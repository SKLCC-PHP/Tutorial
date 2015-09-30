<?php include '../../common/view/header.html.php';?>

<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->student->info;?></strong>
    <strong><?php echo $studentName; ?></strong>
    <strong><?php echo $lang->task->common;?></strong>
  </div>
</div>
<div id='main'>
  <table class='table table-condensed table-hover table-striped tablesorter'>
      <thead>
        <tr class='text-center'>
          <th class='w-90px'> <?php echo $lang->task->title;?></th>
          <th class='w-20px'> <?php echo $lang->task->creator;?></th>
          <th class='w-30px'> <?php echo $lang->task->acl;?></th>
          <th class='w-hour'> <?php echo $lang->task->create_time;?></th>
          <th class='w-hour'> <?php echo $lang->task->deadline;?></th>
          <th class='w-30px'> <?php echo $lang->task->is_completed;?></th>
          <th class='w-30px'> <?php echo $lang->task->is_assessed;?></th>
        </tr>
      </thead>
      <tbody>
      
      </tbody>
      <tfoot>

      </tfoot>
    </table>
</div>
<?php include '../../common/view/footer.html.php';?>