<?php include '../../common/view/header.lite.html.php';?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php js::import($jsRoot . 'misc/date.js');?>
<div class='container'>
  <div id='titlebar'>
    <div class='heading'> 	
      <span class='prefix'><?php echo html::icon($lang->icons['bug']);?></span>
      <strong><small class='text-muted'><?php echo html::icon($lang->icons['create']);?></small> <?php echo $lang->project->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' id='dataform' enctype='multipart/form-data'>
    <table class='table table-form'> 
      <tr>
        <th class='w-90px'><?php echo $lang->project->name;?></th>
        <td class='w-p25-f'><?php echo html::input('name', $project->name, "class='form-control' required='required'");?></td>
        <td></td>
      </tr>
      <tr>
        <th ><?php echo $lang->project->teacher; ?></th>
        <td ><div class="required required-wrapper"></div><?php echo html::select('teacher', $teachers, $project->teacher, "class='form-control'") ?></td>
      </tr>     
      <tr>
        <th><?php echo $lang->project->dateRange;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('starttime', $project->starttime ? $project->starttime:date('Y-m-d'), "class='form-control w-100px form-date' onchange='computeWorkDays()' placeholder='" . $lang->project->begin . "'");?>
            <span class='input-group-addon'><?php echo $lang->project->to;?></span>
            <?php echo html::input('deadline', $project->deadline ? $project->deadline: null, "class='form-control form-date' onchange='computeWorkDays()' placeholder='" . $lang->project->end . "' required='required'");?>
            <div class="required required-wrapper"></div>
          </div>
        </td>
        <td id='unvaliddate'></td>
      </tr>
      <tr>
        <th><?php echo $lang->project->days;?></th>
        <td>
          <div class = 'input-group' id='memberBox'>
            <?php echo html::input('days', $project->days, "class='form-control' onchange='computeWorkDate()'");?>
            <span class='input-group-addon'><?php echo $lang->project->day;?></span>
          </div>
        </td>
      </tr>
    <?php if($memberLists):?>
      <tr>
        <th><nobr><?php echo $lang->project->member;?></nobr></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php 
              echo html::select('members[]', $memberLists, $project->members, "class='form-control' multiple"); 
            ?>
          </div>
        </td>
      </tr>
    <?php endif;?>
      <tr>
        <th><?php echo $lang->project->desc;?></th>
        <td colspan='2'><?php echo html::textarea('description', $project->description, "rows='6' class='form-control'");?></td>
      </tr> 
      <tr>
        <th><?php echo $lang->project->files;?></th>
        <td colspan='2'><?php echo $this->fetch('file', 'buildform')?></td>
      </tr>
      <tr>
        <th><?php echo $lang->project->authority;?></th>
        <td colspan='2'><?php echo nl2br(html::radio('ACL', $lang->aclList, 1));?></td>
      </tr> 
      <tr>
        <td></td><td colspan='2' class='text-center'><?php echo html::submitButton() . html::linkButton($lang->goback, $this->inlink('viewproject'));?></td>
      </tr>
    </table>
  </form>
</div>

<?php include '../../common/view/footer.html.php';?>

