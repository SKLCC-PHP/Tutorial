<div class='panel panel-block dynamic' style="height:655px">
    <div class='panel-heading'>
      <i class='icon-user icon'></i><strong><?php echo $lang->personalinfo->common;?></strong>
    </div>
    <div class="main">
    <table class='table table-borderless table-data'>
        <tr>
          <th width="150px"><?php echo $lang->user->account;?></th>
          <td><?php echo $student->account;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->realname;?></th>
          <td><?php echo $student->realname;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->gender;?></th>
          <td><?php echo $lang->user->genderList[$student->gender];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->college;?></th>
          <td><?php echo $collegelist[$student->college_id]; ?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->grade;?></th>
          <td><?php echo $student->grade;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->specialty;?></th>
          <td><?php echo $student->specialty;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->class;?></th>
          <td><?php echo $user->administrativeclass;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->dormitory;?></th>
          <td><?php echo $student->dormitory;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->polical_status;?></th>
          <td><?php echo $student->polical_status;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->tutor;?></th>
          <td>
          <?php  
              for ($i = 0;$i < count($tutors);$i++) 
              {
                echo $tutors[$i]->realname;
                if(!($i==count($tutors)-1))
                  echo "&nbsp&nbsp&nbsp";
              }
          ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->user->qq;?></th>
          <td><?php if($student->qq) echo html::a("tencent://message/?uin=$user->qq", $student->qq);?></td>
        </tr>     
        <tr>
          <th><?php echo $lang->user->mobile;?></th>
          <td><?php echo $student->mobile;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->email;?></th>
          <td><?php echo $student->email;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->visits;?></th>
          <td><?php echo $student->visits;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->last;?></th>
          <td>
          <?php 
          if (!empty($student->last))
            echo date('Y-m-d H:i:s', $student->last);
          else
            echo "暂未登录过";
          ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->user->status;?></th>
          <td><?php echo $lang->user->statusList[$student->status];?></td>
        </tr>
    </table>
    </div>
</div>