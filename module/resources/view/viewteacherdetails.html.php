<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/sparkline.html.php';?>
<?php css::import($defaultTheme . 'index.css',   $config->version);?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $lang->resources->viewteacherdetails .'&nbsp&nbsp&nbsp'. $teacher_name;?></strong>
  </div>
  <div class='actions'>
    <?php echo html::linkButton($lang->goback, $this->inlink('viewTeachers'));?>
  </div>
</div>
<div class="row">
  <div class="col-md-8">
    <?php include './m.teachersstudents.html.php';?>
    <?php include './m.teachersachievements.html.php';?>
  </div>
  <div class="col-md-4">
    <?php include './m.teachersbasicinformation.html.php';?>
  </div>
</div>
<div class="row">
  <div class='col-md-4 col-sm-6'>
    <?php include './m.teacherstasks.html.php';?>
  </div>
  <div class='col-md-4 col-sm-6'>
    <?php include './m.teachersprojects.html.php';?>
  </div>
  <div class-'col-md-4 col-sm-6'>
    <?php include './m.teachersproblems.html.php';?>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>  
