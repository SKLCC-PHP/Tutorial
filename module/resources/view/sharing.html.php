<?php
/**
 * The browse view file of product module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: browse.html.php 4909 2013-06-26 07:23:50Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php js::set('confirmDelete', $lang->file->confirmDelete); ?>
<div id='featurebar'>
  <ul class='nav'>
  <strong><?php echo $lang->tutor->sharing?></strong>
  </ul>
</div>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('resources', 'search', 'searchobject=sharing');?>' class='form-condensed'>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->resources->title;?></td>
    <td><?php echo html::input('title', $searchtitle, 'class=form-control');?></td>
    <td class='text-right w-60px'><?php echo $lang->resources->addedBy;?></td>
    <td><?php echo html::input('addedBy', $searchaddedBy, 'class=form-control');?></td>
    <td class='w-160px'>
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
</br>
<div class='main'>
  <form method='post' id='sharingForm'>
    <table class='table table-condensed table-hover table-striped tablesorter' align="center" id='filetable'>
      <thead>
        <tr class='text-center'>
          <th class='w-60px text-left nobr'> <?php echo $lang->resources->title;?></th>
          <th width="30px"   > <?php echo $lang->resources->extension;?></th>
          <th class='w-30px' > <?php echo $lang->resources->addedBy;?></th>
          <th class='w-30px' > <?php echo $lang->acl;?></th>
          <th class='w-30px' > <?php echo $lang->resources->addedDate;?></th>
          <th width="30px"  > <?php echo $lang->resources->extra;?></th>
          <th class='w-30px' > <?php echo $lang->resources->downloads;?></th>
          <th class='w-30px' > <?php echo $lang->actions;?></th>
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
            echo html::a($this->createLink('file', 'download', "fileID=$file->id") . $sessionString, "<i class='icon-download'></i>", '_self', "title='{$lang->file->download}' onclick='return downloadFile($file->id)'");
            ?>
          </td>
        </tr>
    <?php endforeach;?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan='8'>
            <?php $pager->show();?>
          </td>
        </tr>
      </tfoot>
    </table> 
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
