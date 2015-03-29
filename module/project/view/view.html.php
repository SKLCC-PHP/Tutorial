<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <strong><?php echo $project->name;?></strong>
  </div>
  <div class='actions'>
    <?php 
      if (($this->project->checkPriv($project->id)) && ($project->finishtime == null))
      {
        common::printIcon('project', 'edit', "projectID=$project->id");
        common::printIcon('project', 'delete', "projectID=$project->id", '', 'button', '', 'hiddenwin');
        if (($project->status == 1) || ($project->status == 2))
        {
          common::printIcon('project', 'finish', "projectID=$project->id", '', 'button', '', 'hiddenwin');
        }
        
      }
      echo "<div class='btn-group'>";
      common::printRPN($this->inlink('viewProject'), $preAndNext);
      echo '</div>';      
    ?>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->project->desc;?></legend>
        <div class='content'><?php echo $project->description;?></div>
      </fieldset>
      <?php echo $this->fetch('file', 'printFiles', array('files' => $project->files, 'fieldset' => 'true'));?>
      <fieldset id='commentBox'>
        <legend><?php echo $lang->comment;?></legend>
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
    <?php if ($project->finishtime == null):?>
      <fieldset>
        <legend><?php echo $lang->commentBox;?></legend>
        <div class='content'><?php echo $comment;?>
        <form class='form-condensed' method='post' target='hiddenwin'>
          <table class='table table-form'>
            <tr>
                <td colspan='2'><?php echo html::textarea('comment', '', "rows='6' class='w-p98'");?></td>
            </tr>
            <tr>
                <td colspan='3' class='text-center'><?php echo html::submitButton('评论') . html::linkButton($lang->goback, $this->inlink('viewProject'));?></td>
            </tr>
          </table>
        </form>
      </fieldset>
    <?php else:?>
      <div class='actions actions-form'>
        <?php echo html::linkButton($lang->goback, $this->inlink('viewProject'));?>
      </div>
    <?php endif;?>
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->project->basicInfo;?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->project->name;?></th>
            <td><?php echo $project->name;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->project->ID?></th>
            <td><?php echo $project->PID;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->project->teacher;?></th>
            <td>
              <?php 
                echo $userpairs[$project->tea_ID];
                if (($project->isG) && ($this->session->user->roleid == 'student')) echo '(指导老师)';
              ?>
            </td>
          </tr>        
          <tr>
            <th><?php echo $lang->project->creater;?></th>
            <td>
              <?php 
                echo $userpairs[$project->creator_ID];
                if (($project->isG) && ($this->session->user->roleid == 'teacher')) echo '(指导学生)';
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->project->menber;?></th>
            <td>
              <?php 
                $menber = explode('|', $project->other_account);
                foreach ($menber as $key => $value) 
                {
                  echo $this->loadModel('user')->getByAccount($value)->realname . ' ';
                }
              ?>
            </td>
          </tr>
          <tr>
           <th><?php echo $lang->project->authority?></th>
           <td><?php echo $lang->aclList[$project->ACL]?></td>
          </tr> 
        </table>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->project->timeInfo;?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th><?php echo $lang->project->begin;?></th>
            <td><?php echo substr($project->starttime, 0, 10);?></td>
          </tr>
          <tr>
            <th><?php echo $lang->project->end;?></th>
            <td><?php echo substr($project->deadline, 0, 10);?>
          </tr>
          <tr>
            <th><?php echo $lang->project->days;?></th> 
            <td><?php echo round((strtotime($project->deadline) - strtotime($project->starttime)) / 3600 / 24) . ' ' . $lang->project->day;?></td>
          </tr>
        <?php if ($project->finishtime != null):?>
          <tr>
            <th><?php echo $lang->project->finishtime;?></th>
            <td><?php echo substr($project->finishtime, 0, 10);?></td>
          </tr>
        <?php endif;?>
          <tr> 
            <th><?php echo $lang->project->status;?></th>
            <td class='<?php echo $project->status;?>'><?php echo $lang->project->statusList[$project->status];?></td>
          </tr>
        </table>
      </fieldset>
    </div>
  </div> 
</div>


<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>