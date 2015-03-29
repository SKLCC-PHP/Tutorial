<div class='panel panel-block basicinformation'>
    <div class='panel-heading'>
      <i class='icon-user icon'></i><strong><?php echo $lang->personalinfo->common;?></strong>
    </div>
    <div class="main">
    <table class='table table-borderless table-data'>
        <tr>
      <th class='w-200px'><?php echo $lang->user->account;?></th>
      <td><?php echo $user->account;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->realname;?></th>
      <td><?php echo $user->realname;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->gender;?></th>
      <td><?php echo $lang->user->genderList[$user->gender];?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->college;?></th>
      <td><?php echo $collegelist[$user->college_id]; ?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->department;?></th>
      <td><?php echo $user->department;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->title;?></th>
      <td><?php echo $user->title;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->education;?></th>
      <td><?php echo $user->education;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->research;?></th>
      <td><?php echo $user->research;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->visits;?></th>
      <td><?php echo $user->visits;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->last;?></th>
      <td>
      <?php 
      if (!empty($user->last))
        echo date('Y-m-d H:i:s', $user->last);
      else
        echo "暂未登录过";
      ?>
      </td>
    </tr>
    <tr>
      <th><?php echo $lang->user->email;?></th>
      <td><?php echo $user->email;?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->user->status;?></th>
      <td><?php echo $lang->user->statusList[$user->status];?></td>
    </tr>
    </table>
    </div>
</div>