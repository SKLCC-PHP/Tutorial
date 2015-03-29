<?php include '../../tutorial/view/header.html.php';?>

<div class='main'>
  <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutorial', 'search');?>' class='form-condensed'>
  <input type='hidden' value='viewAllTutor', name='method'/>
    <table class = 'table table-form table-condensed'align='center' style='margin: 0 auto'>
      <tr>
        <th class='text-center w-90px'><i class='icon-search icon'></i><big><?php echo $lang->tutorial->search;?></big></th>
        <td class='text-right w-60px'><?php echo $lang->tutorial->name;?></td>
        <td><?php echo html::input('name', $searchname, 'class=form-control');?></td>
        <td class='text-right w-60px'><?php echo $lang->tutorial->tea_account;?></td>
        <td><?php echo html::input('account', $searchaccount, 'class=form-control');?></td>
        <td class='w-120px'>
          <div class='btn-group'>
            <?php
              echo html::submitButton($lang->tutorial->search);
              echo html::linkButton($lang->goback, $this->inlink('viewAllTutor'));
            ?>
          </div>
        </td>
      </tr>
    </table>
  </form>
  <br/>
  <table class='table table-condensed table-hover table-striped tablesorter' id='alltutorList'>
    <?php $vars = "paramname=$searchname&paramaccount=$searchaccount&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
      <thead>
        <tr>
          <th class = 'w-100px'><?php common::printOrderLink('realname', $orderBy, $vars, $lang->tutorial->name);?></th>
          <th class = 'w-100px'><?php common::printOrderLink('account', $orderBy, $vars, $lang->tutorial->tea_account);?></th>
          <th class = 'w-100px'><?php echo $lang->tutorial->department;?></th>
          <th class = 'w-100px'><?php echo $lang->tutorial->stu_number;?></th>
          <th class = 'w-400px'><?php echo $lang->tutorial->student;?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($tutors as $tutor):?>
        <tr class = 'text-center'>
          <td><?php echo $tutor->realname;?></td> 
          <td><?php echo $tutor->account;?></td>
          <td><?php echo $tutor->department;?></td>
          <td><?php echo $tutor->stu_number;?></td>
          <td class = 'text-left'>
            <?php 
              if ($tutor->student[I])
              {
                foreach ($tutor->student[I] as $value) 
                {
                  echo $value . '&nbsp&nbsp&nbsp&nbsp';
                }
              }

              if ($tutor->student[R])
              {
                if ($tutor->student[I])
                  echo '<br/>';
                switch ($tutor->student[R])
                {
                  case 1:
                    echo '(' . $lang->tutorial->relation2[R] . ')';
                  case -1:
                    echo $lang->tutorial->relation2[T] . ':&nbsp&nbsp';
                }

                if ($tutor->student[T])
                {
                  //echo $lang->tutorial->relation[T] . ':&nbsp&nbsp';
                  foreach ($tutor->student[T] as $value) {
                    echo $value . '&nbsp&nbsp&nbsp&nbsp';
                  }
                  echo '<br/>';
                }
                if ($tutor->student[G])
                {
                  echo $lang->tutorial->relation[G] . ':&nbsp&nbsp';
                  foreach ($tutor->student[G] as $value) {
                    echo $value . '&nbsp&nbsp&nbsp&nbsp';
                  }
                }
              }
              if ($tutor->student[P])
              {
                if (($tutor->student[R]) || ($tutor->student[I]))
                  echo '<br/>';
                echo $lang->tutorial->relation2[P] . ':&nbsp&nbsp';
                foreach ($tutor->student[P] as $value) {
                  echo $value . '&nbsp&nbsp&nbsp&nbsp';
                }
              }    
            ?>
          </td>
        </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot>
        <tr>
        <?php $columns = 5;?>
          <td colspan='<?php echo $columns;?>'>
            <?php $pager->show();?>
          </td>
        </tr>
      </tfoot>
    </table>
</div>


<?php include '../../common/view/footer.html.php';?>