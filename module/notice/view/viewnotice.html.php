<?php
/**
 * The browse view file of notice module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     notice
 * @version     $Id: browse.html.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>

<div id='featurebar'>
  <strong><?php echo $lang->notice->common;?></strong>
  <div class="actions">
    <div class='btn-group'>
      <?php
      common::printIcon('notice', 'create', "", '', 'button', 'plus');
      ?>
    </div>
  </div>
</div>

<form method='post' target='hiddenwin' action='<?php echo $this->createLink('notice', 'search');?>' class='form-condensed'>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
<!--   <input type='hidden' value='<?php echo $viewtype;?>', name='viewtype'/> -->
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->notice->title;?></td>
    <td><?php echo html::input('title', $searchtitle, 'class=form-control');?></td>
    <td class='text-right w-60px'><?php echo $lang->notice->creator;?></td>
    <td><?php echo html::input('creator', $searchcreator, 'class=form-control');?></td>
    <td class='w-160px'>
      <div class='btn-group'>
        <?php
          echo html::submitButton($lang->search);
          echo html::linkButton($lang->goback, $this->inlink('viewnotice'));
        ?>
      </div>
    </td>
  </tr>
</table>
</form>
<br/>

<form method='post' id='mynoticeForm'>
  <table class='table table-condensed table-hover table-striped tablesorter table-fixed' align="center" id='noticetable'>
  <?php $vars = "orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
    <thead>
    <tr class='text-center'>
      <th width="30px" class='text-left'> <?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
      <th class='w-400px text-left'> <?php common::printOrderLink('title', $orderBy, $vars, $lang->notice->title);?></th>
      <th class='w-100px'> <?php common::printOrderLink('creatorID', $orderBy, $vars, $lang->notice->creator);?></th>
      <th class='w-100px'> <?php common::printOrderLink('createtime', $orderBy, $vars, $lang->notice->createtime);?></th>
    </tr>
    </thead>   
    <tbody>
    <?php foreach($notices as $notice):?>
    <tr class='text-center'>
      <td class='text-left'><?php echo sprintf('%03d', $notice->id);?></td>
      <td class='text-left nobr'><?php echo html::a($this->createLink('notice', 'view', "noticeID=$notice->id&orderBy=$orderBy"), $notice->title);?></td>
      <td><?php echo $userpairs[$notice->creatorID];?></td>
      <td><?php echo $notice->createtime;?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
          <td colspan='4'>
            <?php $pager->show();?>
          </td>
        </tr>
    </tfoot>
  </table> 
</form>
<?php include '../../common/view/footer.html.php';?>
