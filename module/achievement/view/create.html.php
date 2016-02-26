<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('holders', $lang->achievement->placeholder);?>
<div class='container'>
  <div id='titlebar'>
    <div class='heading'>
      <strong><?php echo $lang->achievement->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
    <table class='table table-form' align="center"> 
      <tr>
        <th><?php echo $lang->achievement->title;?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php echo html::input('title', $achievement->title, "class='form-control' required='required'");?>
          </div>
        </td>
      </tr>
      <tr>
        <th width="100px"><?php echo $lang->achievement->other_name;?></th>
        <td style="width:200px;">
          <table class='table  table-form table-borderless' id='memberBox'>
            <tr>
              <td><?php echo html::input('members[]', $achievement->members, "class='form-control'");?></td>
              <td><a href='javascript:void();' onclick='addMember()' class='btn btn-block'><i class='icon-plus'></i></a></td>
              <td><a href='javascript:void();' onclick='deleteMember()' class='btn btn-block'><i class='icon-remove'></i></a></td> 
            </tr>
          </table> 
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->achievement->tea_ID;?></th>
        <td><div style="width:120px;"><?php echo html::select('teaID', $teachers, $achievement->teaID, "class='form-control chosen' required='required'");?></div></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->achievement->description;?></th>
        <td colspan='2'><?php echo html::textarea('description', $achievement->content, "rows='10' class='form-control'");?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->files;?></th>
        <td colspan='2'><?php echo $this->fetch('file', 'buildform');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->achievement->type;?></th>
        <td colspan='3'><?php echo html::radio('type', $lang->achievement->typeList, 'thesis');?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan='3'  class='text-center'><?php echo html::submitButton() . html::linkButton($lang->goback, $this->inlink('viewachievement'));?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>