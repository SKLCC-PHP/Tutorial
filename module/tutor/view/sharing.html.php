<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php js::set('confirmDelete', $lang->file->confirmDelete); ?>
<div id='featurebar'>
  <ul class='nav'>
  <strong><?php echo $lang->tutor->sharing?></strong>
  </ul>
  <div class='actions'>
      <div class='btn-group'>
        <?php
        common::printIcon('resources', 'upload', "", '', 'button', 'plus', '', 'iframe', false, "data-width='750'");
        ?>
      </div>
  </div>
</div>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutor', 'search');?>' class='form-condensed'>
<input type='hidden' value='sharing' name='method'/> 
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->resources->title;?></td>
    <td><?php echo html::input('title', $searchtitle, 'class=form-control');?></td>
    <td class='text-right w-90px'><?php echo $lang->resources->addedBy;?></td>
    <td><?php echo html::input('creator', $searchcreator, 'class=form-control');?></td>
    <td class='w-120px'>
      <div class='btn-group'>
        <?php
          echo html::submitButton($lang->search);
          echo html::linkButton($lang->goback, $this->inlink('sharing'));
        ?>
      </div>
    </td>
  </tr>
</table>
</form>
<br/>
<div class='main'>
  <form method='post' id='sharingForm'>
    <table class='table table-condensed table-hover table-striped tablesorter' align="center" id='filetable'>
    <?php $vars = "orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID&paramtitle=$searchtitle&paramcreator=$searchcreator"; ?>
      <thead>
      <tr class='text-center'>
        <th class='w-60px text-left nobr'> <?php echo $lang->resources->title;?></th>
        <th class='w-30px'> <?php common::printOrderLink('extension', $orderBy, $vars, $lang->resources->title);?></th>
        <th class='w-40px'> <?php echo $lang->resources->addedBy;?></th>
        <th class='w-30px'> <?php echo $lang->acl;?></th>
        <th class='w-30px'> <?php echo $lang->resources->addedDate;?></th>
        <th class="w-40px"> <?php echo $lang->resources->extra;?></th>
        <th class='w-30px'> <?php echo $lang->resources->downloads;?></th>
        <th class='w-30px'> <?php echo $lang->actions;?></th>
      </tr>
      </thead>
    <tbody>
    <?php foreach($files as $file):?>
    <tr class='text-center'>
      <td class='text-left nobr'><?php echo $file->title;?></td>
      <td><?php echo $file->extension;?></td>
      <td><?php echo $userpairs[$file->addedBy];?></td>
      <td><?php echo $lang->aclList[$file->acl];?></td>
      <td><?php echo $file->addedDate;?></td>
      <td><?php echo $file->extra;?></td>
      <td><?php echo $file->downloads;?></td>
      <td class='text-center'>
        <?php
        echo html::a($this->createLink('file', 'download', "fileID=$file->id") . $sessionString, "<i class='icon-download'></i>", '_self', "title='{$lang->file->download}'");
        if(common::hasPriv('resources', 'delete') and $this->resources->checkPriv($file))
        {
          $deleteURL = $this->createLink('file', 'delete', "fileID=$file->id&confirm=yes");
          echo html::a("javascript:ajaxDelete(\"$deleteURL\",\"filetable\",confirmDelete)", '<i class="icon-remove"></i>', '', "title='{$lang->file->delete}' class='btn-icon'");
        }
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <?php $columns = $this->cookie->windowWidth > $this->config->wideSize ? 14 : 12;?>
        <td colspan='8'>
          <?php $pager->show();?>
        </td>
      </tr>
    </tfoot>
  </table> 
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
