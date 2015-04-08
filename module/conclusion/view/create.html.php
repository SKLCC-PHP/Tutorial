<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('holders', $lang->conclusion->placeholder);?>
<div class='container'>
  <div id='titlebar'>
    <div class='heading'>
      <strong><?php echo $lang->conclusion->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
    <table class='table table-form' align="center"> 
      <tr>
        <th><?php echo $lang->conclusion->title;?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php echo html::input('title', $conclusion->title, "class='form-control' required='required'");?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->conclusion->content;?></th>
        <td colspan='2'><?php echo html::textarea('content', $conclusion->content, "rows='20' class='form-control'");?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->files;?></th>
        <td colspan='2'><?php echo $this->fetch('file', 'buildform');?></td>
      </tr>
      <tr>
        <td></td>
        <td class='text-center' colspan='3'><?php echo html::submitButton() . html::linkButton($lang->goback, $this->inlink('viewconclusion'));?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>