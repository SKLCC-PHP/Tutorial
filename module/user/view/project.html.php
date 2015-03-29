<?php
/**
 * The project view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: project.html.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include './featurebar.html.php';?>
<table class='table tablesorter'>
  <thead>
  <tr class='colhead'>
    <th class='w-id'><?php echo $lang->idAB;?></th>
    <th class='w-100px'><?php echo $lang->project->code;?></th>
    <th><?php echo $lang->project->name;?></th>
    <th class='w-date'><?php echo $lang->project->begin;?></th>
    <th class='w-date'><?php echo $lang->project->end;?></th>
    <th class='w-status'><?php echo $lang->statusAB;?></th>
    <th class='w-user'><?php echo $lang->team->role;?></th>
    <th class='w-date'><?php echo $lang->team->join;?></th>
    <th class='w-110px'><?php echo $lang->team->hours;?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($projects as $project):?>
  <?php $projectLink = $this->createLink('project', 'browse', "projectID=$project->id");?>
  <tr class='text-center'>
    <td><?php echo html::a($projectLink, $project->id);?></td>
    <td><?php echo $project->code;?></td>
    <td><?php echo html::a($projectLink, $project->name);?></td>
    <td><?php echo $project->begin;?></td>
    <td><?php echo $project->end;?></td>
    <td><?php echo $lang->project->statusList[$project->status];?></td>
    <td><?php echo $project->role;?></td>
    <td><?php echo $project->join;?></td>
    <td><?php echo $project->hours;?></td>
  </tr>
  <?php endforeach;?>
  </tbody>
</table> 
<?php include '../../common/view/footer.html.php';?>
