<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix' title='GROUP'><?php echo html::icon($lang->icons['group']);?> <strong><?php echo $group->id;?></strong></span>
    <strong><?php echo $group->name;?></strong>
    <small class='text-muted'> <?php echo $lang->group->edit;?> <?php echo html::icon($lang->icons['edit']);?></small>
  </div>
</div>

<form class='form-condensed mw-500px pdb-20' method='post' target='hiddenwin' id='dataform'>
  <table align='center' class='table table-form'> 
    <tr>
      <th class='w-100px'><?php echo $lang->group->name;?></th>
      <td><?php echo html::input('name', $group->name, "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->group->rank;?></th>
      <td><?php echo html::input('rank', $group->rank, "class = form-control required='required' onchange='check()'");?></td>
    </tr>    
    <tr>
      <th><?php echo $lang->group->desc;?></th>
      <td><?php echo html::textarea('desc', $group->desc, "rows='5' class='form-control'");?></td>
    </tr>
    
    <tr><td colspan='2' class='text-center'><?php echo html::submitButton();?></td></tr>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>
