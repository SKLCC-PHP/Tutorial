<?php 
include '../../conclusion/view/header.html.php';
js::set('confirmDelete', $lang->conclusion->confirmDelete);
?>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('conclusion', 'search');?>' class='form-condensed'>
<table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
  <input type='hidden' value='<?php echo $viewtype;?>', name='viewtype'/>
  <tr>
    <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->search;?></big></th>
    <td class='text-right w-90px'><?php echo $lang->conclusion->title;?></td>
    <td><?php echo html::input('title', $searchtitle, 'class=form-control');?></td>
  <?php if ($this->session->userinfo->roleid != 'student'):?>
    <td class='text-right w-60px'><?php echo $lang->conclusion->creator;?></td>
    <td><?php echo html::input('creator', $searchstu, 'class="form-control chosen"');?></td>
  <?php endif;?>
    <td class='w-120px'>
      <div class='btn-group'>
        <?php
          echo html::submitButton($lang->search);
          echo html::linkButton($lang->goback, $this->inlink('viewConclusion'));
        ?>
      </div>
    </td>
  </tr>
</table>
</form>
<br/>
<form method='post' id='myconclusionForm'>
  <table class='table table-condensed table-hover table-striped tablesorter' align="center" id='conclusiontable'>
  <?php $vars = "orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
    <thead>
    <tr class='text-center'>
      <th class='w-20px'><?php common::printOrderLink('id',$orderBy, $vars, $lang->idAB);?></th>
      <th class='w-100px text-left'> <?php echo $lang->conclusion->title;?></th>
      <th class='w-hour'> <?php echo $lang->conclusion->creator;?></th>
      <th class='w-hour'> <?php common::printOrderLink('createtime', $orderBy, $vars, $lang->conclusion->create_time);?></th>
      <th class='w-hour'> <?php echo $lang->conclusion->update_time;?></th>
      <th class='w-hour'> <?php echo $lang->conclusion->viewtime;?></th>
<!--     <?php if ($this->session->userinfo->roleid == 'student'):?>
      <th class='w-20px'> <?php echo $lang->actions;?></th>
    <?php endif;?> -->
    </tr>
    </thead>   
    <tbody>
    <?php foreach($conclusions as $conclusion):?>
    <tr class='text-center'>
      <td><?php echo sprintf('%03d', $conclusion->id);?></td>
      <td class='text-left nobr'><?php echo html::a($this->createLink('conclusion', 'view', "conclusionID=$conclusion->id"), $conclusion->title);?></td>
      <td><?php echo $userpairs[$conclusion->creatorID];?></td>
      <td><?php echo $conclusion->createtime;?></td>
      <td><?php echo $conclusion->updatetime;?></td>
      <td><?php echo $conclusion->viewtime;?></td>
<!--     <?php if ($this->session->userinfo->roleid == 'student'):?>
      <td class='text-center'>
        <?php
          common::printIcon('conclusion', 'edit', "conclusionID=$conclusion->id", '', 'list', 'pencil');
          common::printIcon('conclusion', 'delete', "conclusionID=$conclusion->id", '', 'list', '', 'hiddenwin');
        ?>
      </td>
    <?php endif;?> -->
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
        <tr>
          <td colspan='6'>
            <?php $pager->show();?>
          </td>
        </tr>
    </tfoot>
  </table> 
</form>
<?php include '../../common/view/footer.html.php';?>
