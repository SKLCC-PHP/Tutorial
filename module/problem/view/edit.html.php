<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['problem']);?> <strong><?php echo $problem->id;?></strong></span>
    <strong><?php echo $problem->title;?></strong>
    <?php echo $lang->problem->edit;?>
  </div>
  <div class='actions'>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->problem->detail?></legend>
        <fieldset>
          <legend><?php echo $lang->problem->content;?></legend>
          <div class='content'><?php echo html::textarea('content', $problem->content, "rows='6' class='form-control'");?></div>
        </fieldset>
        <fieldset>
          <legend><?php echo $lang->files;?></legend>
          <?php echo $this->fetch('file', 'printFiles', array('files' => $problem->files, 'fieldset' => 'false'));?>
          <br/>
          <?php echo $this->fetch('file', 'buildform')?>
        </fieldset>      
      </fieldset> 
      <div class='actions actions-form'>
        <?php echo html::submitButton($lang->save) . html::linkButton($lang->goback, $this->inlink('view', "problemID=$problem->id"));?>
      </div>          
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->problem->basicInfo;?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->problem->title;?></th>
            <td><?php echo html::input('title', $problem->title, "class='form-control' required='required'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->acl;?></th>
            <td><?php echo nl2br(html::radio('ACL', $lang->aclList, $problem->ACL, '', 'block'));?></td>
          </tr>
          </tr>
        </table>
      </fieldset>
    </div>
  </div> 
</div>
</form>

<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>