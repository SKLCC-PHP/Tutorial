<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform'>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo html::a($this->createLink('project', 'view', "projectID=$project->id"), $project->name);?></strong>
    <small><?php echo html::icon($lang->icons['edit']) . ' ' . $lang->project->edit;?></small>
  </div>
</div>

<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->project->desc?></legend>
        <div colspan="2"><?php echo html::textarea('description', $project->description, "row='6' class='form-control'");?></div>
      </fieldset>

      <?php if($project->files) echo $this->fetch('file', 'printFiles', array('files' => $project->files, 'fieldset' => 'true'));?>
      <fieldset >
        <legend><?php echo $lang->project->files_up;?></legend>
        <div colspan = '2'><?php echo $this->fetch('file', 'buildform');?></div>
      </fieldset>
      <div class='actions actions-form'>
        <?php echo html::submitButton($lang->save) . html::linkButton($lang->goback, $this->inlink('view', "projectID=$project->id"));?>
      </div>
    </div>  
  </div>
  
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->project->basicInfo;?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->project->name;?></th>
            <td><?php echo html::input('name', $project->name, "class='form-control' required='required'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->project->ID;?></th>
            <td><?php echo html::input('PID', $project->PID, "class='form-control'")?></td>
          </tr>
          <tr>
            <th><?php echo $lang->project->teacher;?></th>
            <td><?php echo html::select('teacher', $teachers, $project->tea_ID, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->project->menber;?></th>
            <td><?php echo html::select('mailto[]', $menberLists, str_replace('|', ',', $project->other_account), "class='form-control' multiple"); ?></td>
          </tr>
          <tr>
           <th><?php echo $lang->project->authority?></th>
           <td colspan='2'><?php echo nl2br(html::radio('ACL', $lang->aclList, $project->ACL, '', 'block'));?></td>
          </tr>
        </table>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->project->timeInfo;?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->project->begin;?></th>
            <td>
                <?php echo html::input('starttime', substr($project->starttime, 0, 10), "class='form-control form-date'' placeholder='" . $lang->project->begin . "' required='required'");?>        
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->project->end;?></th>
            <td>
              <?php echo html::input('deadline', substr($project->deadline, 0, 10), "class='form-control form-date'' placeholder='" . $lang->project->end . "' required='required'");?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->project->days;?></th>
            <td>
              <div class='input-group'>
                <?php echo html::input('days', round((strtotime($project->deadline) - strtotime($project->starttime)) / 3600 / 24), "class='form-control' onchange=computeWorkDate()");?>
                <span class='input-group-addon'><?php echo $lang->project->day;?></span>
              </div>
            </td>
          </tr>
        </table>
      </fieldset>
    </div>
  </div> 
</div>
</form>

<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>