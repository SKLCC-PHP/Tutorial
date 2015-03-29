<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>

<div id='titlebar'>
  <div id='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['achievement']);?> <strong><?php echo $achievement->id;?></strong></span>
    <strong><?php echo $achievement->title;?></strong>
  </div>
</div>
<form class='form-condensed' method='post' target='hiddenwin'>
  <div class='main'>
    <table class = 'table table-form table-fixed table-borderless'>
      <tbody>
        <tr>
          <th class = 'w-50px'><strong><?php echo $lang->achievement->check;?></strong></th>
          <td><?php echo html::radio('checked', $lang->achievement->checkList, $achievement->checked);?></td>
        </tr>
        <br/>
        <tr>
          <th><?php echo $lang->commentBox;?></th>
          <td colspan='2'><?php echo html::textarea('comment', '', "rows='2' class='form-control'");?></td>
        </tr>
        <tr>
          <td></td><td class = 'text-center' colspan='2'><?php echo html::submitButton();?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <br/>

  
</form>

<?php include '../../common/view/footer.html.php';?>