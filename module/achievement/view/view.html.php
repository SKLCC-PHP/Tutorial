<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['achievement']);?> <strong><?php echo $achievement->id;?></strong></span>
    <strong><?php echo $achievement->title;?></strong>
  </div>
  <div class='actions'>
    <?php
      if ($this->session->userinfo->roleid != 'teacher')
      {
        if($achievement->checked != 1)
          common::printIcon('achievement', 'edit', "achievementID=$achievement->id", '', 'button', 'pencil');
        common::printIcon('achievement', 'delete', "achievementID=$achievement->id", '', 'button', '', 'hiddenwin');
        common::printIcon('achievement', 'check', "achievementID=$achievement->id", '', 'button', '', '', 'iframe', true);   
      }
      echo "<div class='btn-group'>";
      common::printRPN($this->inlink('viewAchievement'), $preAndNext, 'view');
      echo '</div>';
    ?>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->achievement->description;?></legend>
        <div class='content'><?php echo $achievement->description;?></div>
      </fieldset>
      <?php
        echo $this->fetch('file', 'printFiles', array('files' => $achievement->files, 'fieldset' => 'true'));
      ?> 
    <?php if ($comments != null):?>           
      <fieldset id='commentBox'>
        <legend><?php echo $lang->achievement->comment;?></legend>
        <ol id='historyItem'>
        <?php $i = 1; ?>
        <?php foreach ($comments as $comment):echo $comment;?>
          <li value="<?php echo $i++?>">
            <span>
              <?php echo $comment->create_time.' '.$comment->realname.'：'.$comment->content;?>
            </span>
          </li>
        <?php endforeach;?>
        </ol>
      </fieldset>
    <?php endif;?>
      <div class='actions actions-form'>
        <?php echo html::linkButton($lang->goback, $this->inlink('viewAchievement'));?>
      </div>
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->basicInfo?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->achievement->title;?></th>
            <td><?php echo $achievement->title;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->achievement->creator;?></th>
            <td>
              <?php 
                echo $userpairs[$achievement->creatorID];
                if (($achievement->isG) && ($this->session->user->roleid == 'teacher')) echo '(指导学生)';
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->achievement->other_name;?></th>
            <td>
              <?php 
                $members = explode(',', $achievement->othername);
                foreach ($members as $key => $member) 
                {
                  echo $member . '&nbsp&nbsp';
                }
              ?>
            </td>
          </tr>
          <tr> 
            <th><?php echo $lang->achievement->tea_ID?></th>
            <td>
              <?php
                echo $userpairs[$achievement->teaID];
                if (($achievement->isG) && ($this->session->user->roleid == 'student')) echo '(指导老师)';
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->achievement->type;?></th>
            <td><?php echo $lang->achievement->typeList[$achievement->type];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->achievement->create_time;?></th>
            <td><?php echo $achievement->createtime;?></td>
          </tr>
          <tr> 
          <?php
           if ($achievement->updatetime and $achievement->updatetime != '0000-00-00 00:00:00')
                echo '<th>'.$lang->achievement->update_time.'</th>
                      <td>'.$achievement->updatetime.'</td>';
          ?>
          </tr>
          <tr>
            <th><?php echo $lang->achievement->ischecked;?></th>
            <td><?php echo $lang->achievement->checkedList[$achievement->checked];?></td>
          </tr>  
        </table>
      </fieldset>
    </div>
  </div>
</div>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>
