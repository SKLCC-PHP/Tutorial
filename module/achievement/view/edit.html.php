<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>

<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['achievement']);?> <strong><?php echo $achievement->id;?></strong></span>
    <strong><?php echo $achievement->title;?></strong>
  </div>
</div>
<form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->achievement->description;?></legend>
        <div><?php echo html::textarea('description', $achievement->description, "rows='10' class='form-control'");?></div>
      </fieldset>
      <fieldset>
      <legend><?php echo $lang->files;?></legend>
        <?php echo $this->fetch('file', 'printFiles', array('files' => $achievement->files, 'fieldset' => 'false'));?>
        <br/>
        <?php echo $this->fetch('file', 'buildform');?>
      </fieldset>
      <div class='actions actions-form'>
        <?php echo html::submitButton(); echo html::linkButton($lang->goback, $this->inlink('viewAchievement', ""));?>
      </div>
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->basicInfo?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->achievement->title;?></th>
            <td><?php echo html::input('title', $achievement->title, "class='form-control' required='required'");?></td>
          </tr>
          <tr> 
            <th><?php echo $lang->achievement->tea_ID;?></th>
            <td><?php echo html::select('teaID', $teachers, $achievement->teaID, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->achievement->other_name;?></th>
            <td>
              <table class='table table-borderless table-form' id='memberBox'>
              <?php foreach ($achievement->members as $member):?>
                <tr>
                  <td><?php echo html::input('member[]', $member, "class='form-control'");?></td>
                  <td><a href='javascript:void();' onclick='addMember()' class='btn btn-block'><i class='icon-plus'></i></a></td>           
                </tr>
              <?php endforeach;?>
              </table>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->achievement->type;?></th>
            <td><?php echo html::radio('type', $lang->achievement->typeList, 'thesis', '', 'block');?></td>
          </tr>
        </table>
      </fieldset>
    </div>
  </div>
</div>
</form>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>