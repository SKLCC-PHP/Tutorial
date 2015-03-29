<?php include '../../tutorial/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/treeview.html.php';?>

<div class='main'>
  <div class='row'>
    <div class='col-sm-5'>
      <div class='panel panel-sm'>
        <div class='panel-heading'>
          <i class='icon-group icon'></i><strong><?php echo $lang->tutorial->tutorlist;?></strong>
        </div>
        <div class='panel-body'>
            <div id='main'>
              <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutorial', 'search');?>' class='form-condensed'>
              <input type='hidden' value='viewTutorialSystem', name='method'/>
                <table class = 'table table-form table-condensed'align='center' style='max-width: 1200px; margin: 0 auto'>
                  <tr>
                    <th class='text-center w-60px'><i class='icon-search icon'></i><big><?php echo $lang->tutorial->search;?></big></th>          
                    <td class='text-right w-60px'><?php echo $lang->tutorial->tea_account;?></td>
                    <td><?php echo html::input('account', $searchaccount, 'class=form-control');?></td>
                    <td class='text-right w-40px'><?php echo $lang->tutorial->name;?></td>
                    <td><?php echo html::input('name', $searchname, 'class=form-control');?></td>
                    <td class='w-120px'>
                      <div class='btn-group'>
                        <?php
                          echo html::submitButton($lang->tutorial->search);
                          echo html::linkButton($lang->goback, $this->inlink('viewTutorialSystem'));
                        ?>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
              <hr/>
              <table class = 'table table-form table-fixed' id = 'tutorial_tutorlist'>
                <tbody>
                <?php foreach ($tutors as $key => $tutor):?>
                  <tr>
                    <td class = 'text-right w-150px'><?php echo html::a($this->createLink('tutorial', 'viewTutorialSystem', "paramname=$searchname&paramaccount=$searchaccount&tea_account=$tutor->account&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"), $tutor->account . '(' . $tutor->realname . ')');?></td>
                    <td class = 'w-50px'></td>
                    <td class = 'text-left w-150px'><?php echo $tutor->stu_number . $lang->tutorial->people;?></td>
                  </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>        
                  <tr>
                    <?php $columns = 3;?>
                    <td colspan='<?php echo $columns;?>'>
                      <?php $pager->show();?>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>                  
        </div>
      </div>
    </div>
    <div class='col-sm-7'>
      <div class='panel panel-sm'>
        <div class='panel-heading'>
          <i class='icon-sitemap'></i> <strong><?php echo $tea_account . '(' . $tutors[$teaid]->realname . ')' . $lang->tutorial->system . $lang->tutorial->stu . "    (" . $lang->tutorial->tip . $lang->tutorial->stu_account . ")";?></strong>
        </div>
        <div class='panel-body'>
          <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutorial', 'saveStudents');?>' class='form-condensed'>
          <input type='hidden' value='<?php echo $tea_account;?>' name='tutoraccount' />
            <table class='table table-form'>
              <tr>
                <td class='text-right w-120px'>
                  <nobr>
                    <strong><big><?php echo $tea_account . '(' . $tutors[$teaid]->realname . ')'. $lang->arrow;?></big></strong>             
                  </nobr>
                </td>
                <td class='w-600px' id='addMember'> 
                  <table class='table table-form'>
                    <tbody>
                      <tr>
                        <td width='30%'></th>
                        <td width='50%' align='left'><strong><?php echo '&nbsp&nbsp&nbsp&nbsp'.$lang->tutorial->selecttip;?></strong></th>
                      </tr>
                      <?php
                        $num = $tutors[$teaid]->stu_number;
                        foreach ($students as $key => $student) 
                        { 
                          echo "<tr>\n<td>\n";
                          echo html::select('newStudent[]', $studentList, $student->account, "class='form-control chosen'");
                          echo "</td>\n<td>\n";
                          echo html::checkbox('relation[' . $key . ']', $lang->tutorial->relation, $student->relation, '', 'inline', true);
                          echo "</td>\n</tr>\n";
                        }
                        for($i = 0; $i < TUTORIAL::NEW_COUNT ; $i++) 
                        { 
                          echo "<tr>\n<td>\n";
                          echo html::select('newStudent[]', $studentList, null, "class='form-control chosen'");
                          echo "</td>\n<td>\n";
                          echo html::checkbox('relation[' . ($i+$num) . ']', $lang->tutorial->relation);
                          echo "</td>\n</tr>\n";
                        }
                      ?>
                    </tbody> 
                  </table>
                </td> 
              </tr>
              <tr>
                <td></td>
                <td>
                  <?php 
                    echo html::submitButton();
                  ?>
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../../common/view/footer.html.php';?>