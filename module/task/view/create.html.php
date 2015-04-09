<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('holders', $lang->task->placeholder);?>
<div class='container'>
  <div id='titlebar'>
    <div class='heading'>
      <strong><?php echo $lang->task->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
    <table class='table table-form' align="center"> 
      <tr>
        <th><?php echo $lang->task->title;?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php echo html::input('title', $task->title, "class='form-control' required='required' onblur='checkTitle()'");?>
          </div>
        </td>
        <td colspan="2" width="700px"></td>
      </tr>
      <tr>
        <th width="100px"><?php echo $lang->task->assignedTo;?></th>
        <td  colspan='2'><div class="required required-wrapper"></div><?php echo html::select('assignedTo[]', $members, $task->acp_ID, "class='form-control chosen' multiple");?></td><td></td>
        <td width="700px"></td>
      </tr> 
      <tr>
        <th><?php echo $lang->task->content;?></th>
        <td colspan='4'><?php echo html::textarea('content', $task->content, "rows='7' class='form-control'");?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->dateRange;?></th>
        <td width = '300px'>
          <div class='input-group'>
            <?php echo html::input('begintime', $task->begintime ? $task->begintime : date('Y-m-d'), "class='form-control w-100px form-date' onchange='computeWorkDays()' placeholder='" . $lang->task->begin . "' required='required'");?>
            <span class='input-group-addon'><?php echo $lang->task->to;?></span>
            <?php echo html::input('deadline', $task->deadline ? $task->deadline : null, "class='form-control form-date' onchange='computeWorkDays()' placeholder='" . $lang->task->deadline . "' required='required'");?>
            <div class="required required-wrapper"></div>
          </div>
        </td>
        <td id='unvaliddate'></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->days;?></th>
        <td>
          <div class = 'input-group' id='memberBox'>
            <?php echo html::input('days', $task->days, "class='form-control' required='required' onchange='computeWorkDate()'");?>
            <span class='input-group-addon'><?php echo $lang->task->day;?></span>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->files;?></th>
        <td colspan='4'><?php echo $this->fetch('file', 'buildform');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->acl;?></th>
        <td colspan='3'><?php echo html::radio('acl', $lang->aclList, $task->acl ? $task->acl : '1');?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan='3'><?php echo html::submitButton() . html::linkButton($lang->goback, $this->inlink('viewtask'));?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>