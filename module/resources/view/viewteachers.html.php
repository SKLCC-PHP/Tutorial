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
<div id='featurebar'>
  <ul class='nav'>
  <strong><?php echo $lang->tutor->teachers;?></strong>
  </ul>
</div>
<div class='main'>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('resources', 'search', 'searchobject=teachers');?>' class='form-condensed'>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->user->realname;?></td>
    <td><?php echo html::input('realname', $searchrealname, 'class=form-control');?></td>
    <td class='text-right w-60px'><?php echo $lang->user->research;?></td>
    <td><?php echo html::input('research', $searchresearch, 'class=form-control');?></td>
    <td class='w-160px'>
      <div class='btn-group'>
        <?php
          echo html::submitButton($lang->search);
          echo html::linkButton($lang->goback, $this->inlink('viewteachers'));
        ?>
      </div>
    </td>
  </tr>
</table>
</form>
</br>
<form method='post' id='teacherForm'>
  <table class='table table-condensed table-hover table-striped tablesorter' align="center" id='teachertable'>
    <thead>
    <tr class='text-center'>
      <th class='w-100px'> <?php echo $lang->user->realname;?></th>
      <th width="30px" > <?php echo $lang->user->gender;?></th>
      <th width="100px" > <?php echo $lang->user->research;?></th>
      <th width="100px" > <?php echo $lang->user->email;?></th>
      <th width="130px" > <?php echo $lang->user->department;?></th>
    </tr>
    </thead>   
    <tbody>
    <?php foreach($teachers as $teacher):?>
    <tr class='text-center'>
      <td class='text-center nobr'><?php echo html::a($this->createLink('resources', 'viewteacherdetails', "teacher_account=$teacher->account"), $teacher->realname);?></td>
      <td><?php echo $lang->user->genderList[$teacher->gender];?></td>
      <td><?php echo $teacher->research;?></td>
      <td><?php echo $teacher->email;?></td>
      <td><?php echo $teacher->department;?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <?php $columns = $this->cookie->windowWidth > $this->config->wideSize ? 14 : 12;?>
        <td colspan='<?php echo $columns;?>'>
          <?php $pager->show();?>
        </td>
      </tr>
    </tfoot>
  </table> 
</form>
</div>
<?php include '../../common/view/footer.html.php';?>
