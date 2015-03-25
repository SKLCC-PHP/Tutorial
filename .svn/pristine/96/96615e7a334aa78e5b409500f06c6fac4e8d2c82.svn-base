<?php include '../../common/view/header.lite.html.php';?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>

<div class='container'>
  <div id='titlebar'>
    <div class='heading'> 	
      <span class='prefix'><?php echo html::icon($lang->icons['bug']);?></span>
      <strong><small class='text-muted'><?php echo html::icon($lang->icons['create']);?></small> <?php echo $lang->problem->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' id='dataform' enctype='multipart/form-data'>
    <table class='table table-form'> 
      <tr>
        <th class='w-90px'><?php echo $lang->problem->title;?></th>
        <td class='w-p25-f'><?php echo html::input('title', $problem->title, "class='form-control' required='required'");?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->problem->teachers;?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php 
              echo html::select('teachers[]', $teachers, $problem->teachers, "class='form-control' multiple "); 
            ?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->problem->content;?></th>
        <td colspan='2'><?php echo html::textarea('content', $problem->content, "rows='6' class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->files;?></th>
        <td colspan='2'><?php echo $this->fetch('file', 'buildform')?></td>
      </tr>
      <tr>
        <th><?php echo $lang->problem->authority;?></th>
        <td colspan='2'><?php echo nl2br(html::radio('ACL', $lang->aclList, $problem->ACL ? $problem->ACL : 1, '', 'block'));?></td>
      </tr>    
      <tr>
        <td></td>
        <td colspan='2' class='text-center'><?php echo html::submitButton() . html::linkButton($lang->goback, $this->inlink('viewproblem'));?></td>
      </tr>
    </table>
  </form>
</div>

<?php include '../../common/view/footer.html.php';?>