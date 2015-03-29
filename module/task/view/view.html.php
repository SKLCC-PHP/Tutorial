<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['task']);?> <strong><?php echo $task->id;?></strong></span>
    <strong><?php echo $task->title;?></strong>
  </div>
  <div class='actions'>
    <?php   
      if ($task->completetime == null)
      {
        if ($task->begintime <= helper::now())
        {
          if ($task->submittime == null)
            common::printIcon('task', 'submit', "taskID=$task->id", '', 'button', 'ok-sign'); 
          else
            common::printIcon('task', 'editsubmit', "taskID=$task->id", '', 'button', 'edit', '', 'iframe', true);                  
        }

        if ($task->submittime != null)
        {
          common::printIcon('task', 'assess', "taskID=$task->id", '', 'button', 'edit');
        }

        if ($task->assesstime != null)
        {
          common::printIcon('task', 'finish', "taskID=$task->id", '', 'button', 'ok');
        }
        common::printIcon('task', 'edit', "taskID=$task->id", '', 'button', 'pencil');
        common::printIcon('task', 'delete', "taskID=$task->id", $task, 'button', '', 'hiddenwin');            
      } 
      echo "<div class='btn-group'>";
      common::printRPN($this->inlink('viewTask', "viewtype=$viewtype"), $preAndNext);
      echo '</div>';      
    ?>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->task->teachertask;?></legend>
        <fieldset>
          <legend><?php echo $lang->task->content;?></legend>
          <div class='content'><?php echo $task->content;?></div>
        </fieldset>
        <?php echo $this->fetch('file', 'printFiles', array('files' => $task->files, 'fieldset' => 'true'));?>
      </fieldset>    
      <fieldset>
        <legend><?php echo $lang->task->studentsubmit;?></legend>
        <fieldset>
          <legend><?php echo $lang->task->content;?></legend>
          <div class='content'><?php echo $task->submitcontent;?></div>
        </fieldset>
        <fieldset>
          <legend><?php echo $lang->task->subfile;?></legend>
          <?php echo $this->fetch('file', 'printFiles', array('files' => $task->submitfiles, 'fieldset' => 'false'));?>
        </fieldset>
      </fieldset>
    <?php if ($task->assesstime != null):?>
      <fieldset>
        <legend><?php echo $lang->task->tea_assess;?></legend>
          <ul id='historyItem'>
          <?php $i = 1; ?>
          <?php foreach ($assess_comments as $comment):?>
            <li value="<?php echo $i++?>">
              <span>
                <?php echo $comment->create_time.' '.$comment->realname.'：'.$comment->content;?>
              </span>
            </li>
          <?php endforeach;?>
          </ul>
      </fieldset>
    <?php endif;?>
      <div class='actions'>
        <?php   
          if ($task->completetime == null)
          {
            if ($task->begintime <= helper::now())
            {
              if ($task->submittime == null)
                common::printIcon('task', 'submit', "taskID=$task->id", '', 'button', 'ok-sign'); 
              else
                common::printIcon('task', 'editsubmit', "taskID=$task->id", '', 'button', 'edit', '', 'iframe', true);                  
            }

            if ($task->submittime != null)
            {
              common::printIcon('task', 'assess', "taskID=$task->id", '', 'button', 'edit');
            }

            if ($task->assesstime != null)
            {
              common::printIcon('task', 'finish', "taskID=$task->id", '', 'button', 'ok');
            }
            common::printIcon('task', 'edit', "taskID=$task->id", '', 'button', 'pencil');
            common::printIcon('task', 'delete', "taskID=$task->id", $task, 'button', '', 'hiddenwin');            
          } 
          echo "<div class='btn-group'>";
          common::printRPN($this->inlink('viewTask', "viewtype=$viewtype"), $preAndNext);
          echo '</div>';      
        ?>
      </div>
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->basicInfo?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->task->title;?></th>
            <td><?php echo $task->title;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->receiver;?></th>
            <td>
              <?php 
                echo $userpairs[$task->acpID];
                if ($this->session->user->roleid == 'teacher'){
                  if (strstr($task->relation, 'G')) echo '(指导学生)';
                  if (strstr($task->relation, 'P')) echo '(毕业设计)';
                }
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->task->creator;?></th>
            <td>
              <?php 
                echo $userpairs[$task->asgID];
                if ($this->session->user->roleid == 'student'){
                  if (strstr($task->relation, 'G')) echo '(指导老师)';
                  if (strstr($task->relation, 'P')) echo '(毕业设计)';
                }              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->task->create_time;?></th>
            <td><?php echo $task->createtime;?></td>
          </tr>
          <tr> 
          <?php
           if ($task->begintime and $task->begintime != '0000-00-00 00:00:00')
                echo '<th>'.$lang->task->begin_time.'</th>
                      <td>'.$task->begintime.'</td>';
          ?>
          </tr>
          <tr> 
          <?php
           if ($task->submittime and $task->submittime != '0000-00-00 00:00:00')
                echo '<th>'.$lang->task->submit_time.'</th>
                      <td>'.$task->submittime.'</td>';
          ?>
          </tr>
          <tr> 
          <?php
           if ($task->assesstime and $task->assesstime != '0000-00-00 00:00:00')
                echo '<th>'.$lang->task->assess_time.'</th>
                      <td>'.$task->assesstime.'</td>';
          ?>
          </tr>
          <tr>
          <?php
           if ($task->completetime and $task->completetime != '0000-00-00 00:00:00')
                echo '<th>'.$lang->task->complete_time.'</th>
                      <td>'.$task->completetime.'</td>';
          ?>
          </tr>
          <tr>
            <th><?php echo $lang->task->deadline;?></th>
            <td><?php echo $task->deadline;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->acl;?></th>
            <td><?php echo $lang->aclList[$task->ACL];?></td>
          </tr>  
        </table>
      </fieldset>
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
      <fieldset>
        <legend><?php echo $lang->commentBox;?></legend>
        <div class='content'><?php echo $comment;?>
        <form class='form-condensed' method='post' target='hiddenwin'>
          <table class='table table-form'>
            <tr>
                <td colspan='2'><?php echo html::textarea('comment', '', "rows='6' class='w-p98'");?></td>
            </tr>
            <tr>
                <td colspan='3' class='text-center'><?php echo html::submitButton('评论');?></td>
            </tr>
          </table>
        </form>
      </fieldset>
    </div>
  </div>
</div>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>
