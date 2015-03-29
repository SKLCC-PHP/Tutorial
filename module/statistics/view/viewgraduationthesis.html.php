<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<div id='featurebar'>
  <ul class='nav'>
  		<strong><?php echo $lang->statistics->common;?></strong>
  </ul>
  
  <div class='actions'>
        <div class='btn-group'>
          <div class='btn-group'>
            <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
              <i class='icon-download-alt'></i> <?php echo $lang->export ?>
              <span class='caret'></span>
            </button>
            <ul class='dropdown-menu' id='exportActionMenu'>
              <?php 
              $misc = common::hasPriv('statistics', 'exportThesises') ? "class='export'" : "class=disabled";
              $link = common::hasPriv('statistics', 'exportThesises') ?  $this->createLink('statistics', 'exportThesises', "orderBy=$orderBy") : '#';
              echo "<li>" . html::a($link, $lang->statistics->export, '', $misc) . "</li>";
              ?>
            </ul>
          </div>
        </div>
    </div>
</div>
<?php if($this->session->userinfo->roleid != 'teacher'):?>
<div class='side'>
  <a class='side-handle' data-id='teacherList'><i class='icon-caret-left'></i></a>
  <div class='side-body'>
    <div class='panel panel-sm'>
      <div class='panel-heading nobr'><?php echo html::icon($lang->icons['product']);?> <strong><?php echo "导师列表";?></strong></div>
      <div class='panel-body'>
      <ul>
        <?php
          echo "<li id='all'>" . html::a($this->createLink('statistics', 'viewGraduationThesis' ,'account=all'),  '全部') . "</li>"; 
          foreach ($tutors_list as $tutor)
          {
              echo "<li id='".$tutor->account."'>" . html::a($this->createLink('statistics', 'viewGraduationThesis' ,'account='.$tutor->account),  $tutor->realname) . "</li>";
          }
        ?>
      </ul>
      </div>
    </div>
  </div>
</div>
<?php endif;?>
<div class='main'>
  <form method='post' id='thesisForm'>
    <table class='table w-1000px table-condensed table-hover table-striped tablesorter table-fixed' id='thesisList'>
      <thead>
      <tr>
        <?php $vars = "account=all&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage";?>
        <th class='text-center' width="60px">  <?php common::printOrderLink('id',         $orderBy, $vars, $lang->idAB);?></th>
        <th width="80px" class='text-left'>  <?php common::printOrderLink('creatorID',         $orderBy, $vars, $lang->achievement->thesis->author);?></th>
        <th width="200px">  <?php common::printOrderLink('title',         $orderBy, $vars, $lang->achievement->thesis->title);?></th>
        <th width="90px" class='text-left'> <?php common::printOrderLink('teaID',        $orderBy, $vars, $lang->tutor->name);?></th>
        <th width="150px" > <?php common::printOrderLink('othername',   $orderBy, $vars, $lang->achievement->thesis->members);?></th>
        <th width="100px"><?php common::printOrderLink('createtime', $orderBy, $vars, $lang->achievement->create_time);?></th>
        <th width="100px"><?php common::printOrderLink('updatetime',   $orderBy, $vars, $lang->achievement->update_time);?></th>
      </tr>
      </thead>
      <tbody>
      <?php 
        foreach($thesises as $thesis):
          if(!empty($userpairs[$thesis->creatorID])):
      ?>
      <tr class='text-center'>
        <td class='text-center'>
          <?php printf('%02d', $thesis->id);?>
        </td>
        <td class='text-left'><?php echo $userpairs[$thesis->creatorID];?></td>
        <td><?php echo $thesis->title;?></td>
        <td class='text-left'><?php echo $thesis->realname;?></td>
        <td><?php echo $thesis->othername;?></td>
        <td><?php echo $thesis->createtime;?></td>
        <td><?php echo $thesis->updatetime;?></td>
      </tr>
      <?php 
        endif;
        endforeach;
      ?>
      </tbody>
      <tfoot>
      <tr>
        <td colspan='7'>
          <div class='table-actions clearfix'>
            <div class='text'><?php echo $summary;?></div>
          </div>
          <?php $pager->show();?>
        </td>
      </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript"> $('#<?php echo $account;?>').addClass('active') </script>
<?php include '../../common/view/footer.html.php';?>
