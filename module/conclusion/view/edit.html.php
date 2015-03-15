<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form class='form-condensed' method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform'>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['conclusion']);?> <strong><?php echo $conclusion->id;?></strong></span>
    <strong><?php echo html::a($this->createLink('conclusion', 'view', "conclusionID=$conclusion->id"), $conclusion->title);?></strong>
    <small><?php echo $lang->conclusion->edit;?></small>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->conclusion->content;?></legend>
        <div class='content'><?php echo html::textarea('content', $conclusion->content, "rows='12' class='form-control' required='required'");?></div>
      </fieldset>
      <fieldset>
      <legend><?php echo $lang->files;?></legend>
        <?php echo $this->fetch('file', 'printFiles', array('files' => $conclusion->files, 'fieldset' => 'false'));?>      
        <br/>
        <?php echo $this->fetch('file', 'buildform');?>
      </fieldset>
      <div class='actions'>
        <?php echo html::submitButton() . html::linkButton($lang->goback, $this->inlink('view', "conclusionID=$conclusion->id"));?>
      </div>
    </div>
  </div>
    <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->basicInfo?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->conclusion->title;?></th>
            <td><?php echo html::input('title', $conclusion->title, "class='form-control' required='required'");?></td>
          </tr>  
        </table>
      </fieldset>
    </div>
  </div>
</div>
</form>
<?php include '../../common/view/footer.html.php';?>
