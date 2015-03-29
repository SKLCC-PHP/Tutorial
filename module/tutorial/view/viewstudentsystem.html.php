<?php include '../../tutorial/view/header.html.php';?>

<div class='main'>
  <div class='row'>
    <div class='col-sm-5'>
      <div class='panel panel-sm'>
        <div class='panel-heading'>
          <i class='icon-group icon'></i><strong><?php echo $lang->tutorial->studentlist;?></strong>
        </div>
        <div class='panel-body'>
            <div id='main'>
              <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutorial', 'search');?>' class='form-condensed'>
              <input type='hidden' value='viewStudentSystem', name='method'/>
                <table class = 'table table-form table-condensed'align='center' style='max-width: 1200px; margin: 0 auto'>
                  <tr>
                    <th class='text-center w-60px'><i class='icon-search icon'></i><big><?php echo $lang->tutorial->search;?></big></th>          
                    <td class='text-right w-40px'><?php echo $lang->tutorial->stu_account;?></td>
                    <td><?php echo html::input('account', $searchaccount, 'class=form-control');?></td>
                    <td class='text-right w-40px'><?php echo $lang->tutorial->name;?></td>
                    <td><?php echo html::input('name', $searchname, 'class=form-control');?></td>
                    <td class='w-120px'>
                      <div class='btn-group'>
                        <?php
                          echo html::submitButton($lang->tutorial->search);
                          echo html::linkButton($lang->goback, $this->inlink('viewStudentSystem'));
                        ?>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
              <hr/>
              <table class = 'table table-form table-fixed' id = 'tutorial_studentlist'>
                <tbody>
                <?php foreach ($students as $key => $student):?>
                  <tr>
                    <td class = 'text-right w-150px'><?php echo html::a($this->createLink('tutorial', 'viewStudentSystem', "paramname=$searchname&paramaccount=$searchaccount&stu_account=$student->account&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"), $student->account . '(' . $student->realname . ')');?></td>
                    <td class = 'w-50px'></td>
                    <td class = 'text-left w-150px'><?php echo $student->tea_number . $lang->tutorial->people;?></td>
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
          <i class='icon-sitemap'></i> <strong><?php echo $stu_account . '(' . $students[$stuid]->realname . ')' . $lang->tutorial->system . $lang->tutorial->tutorlist . '    (' . $lang->tutorial->tip . $lang->tutorial->tea . ')';?></strong>
        </div>
        <div class='panel-body'>
          <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tutorial', 'saveTeachers');?>' class='form-condensed'>
          <input type = 'hidden', value = '<?php echo $stu_account;?>', name = 'studentaccount'/>
            <table class='table table-form'>
              <tr>
                <td class='text-right w-120px'>
                  <nobr>
                    <strong><big><?php echo  $stu_account . '(' . $students[$stuid]->realname . ')' . $lang->obArrow;?></big></strong>             
                  </nobr>
                </td>
                <td class='w-600px'>
                  <table class='table table-form'>
                    <tr>
                      <td width='30%'></th>
                      <td width='50%' align='left'><strong><?php echo '&nbsp&nbsp&nbsp&nbsp'.$lang->tutorial->selecttip;?></strong></th>
                    </tr>
                    <?php 
                      $num = $students[$stuid]->tea_number;
                      foreach ($teachers as $key => $teacher) 
                      { 
                        echo "<tr>\n<td>\n";
                        echo html::select('newTeacher[]', $teacherList, $teacher->account, "class='form-control chosen'");
                        echo "</td>\n<td>\n";
                        echo html::checkbox('relation[' . $key . ']', $lang->tutorial->relation, $teacher->relation, '', 'inline', true);
                        echo "</td>\n</tr>\n";
                      }
                      for($i = 0; $i < TUTORIAL::NEW_COUNT ; $i++) 
                      { 
                        echo "<tr>\n<td>\n";
                        echo html::select('newTeacher[]', $teacherList, null, "class='form-control chosen'");
                        echo "</td>\n<td>\n";
                        echo html::checkbox('relation[' . ($i+$num) . ']', $lang->tutorial->relation);
                        echo "</td>\n</tr>\n";
                      }
                    ?>
                  </table> 
                </td> 
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <?php echo html::submitButton();?>
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