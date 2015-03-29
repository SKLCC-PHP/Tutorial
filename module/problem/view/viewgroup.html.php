<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id = 'featurebar'>
  <ul class='nav'>
    <li><strong><?php echo $problem->title;?></strong></li>
    <?php
      $num = count($problems);
      foreach ($problems as $key => $value) {
        echo "<li id = '" . $value->id . "'>" . html::a($this->createLink('problem', 'viewgroup', array('ID' => $value->id)), $users[$value->acpID]);
        if ($key >= $num - 2) break;
      }
    ?> 
  </ul>
  <div class='actions'>
    <?php
      if (($problem->asgID == $this->session->user->account) && ($problem->completetime == null))
      {
        common::printIcon('problem', 'edit', "problemID=$problem->id", '', 'button');
        common::printIcon('problem', 'delete', "problemID=$problem->id&group=true", '', 'button', '', 'hiddenwin');              
        if (($problem->readtime != null) && ($problem->readtime != '0000-00-00 00:00:00'))
          common::printIcon('problem', 'complete', "problemID=$problem->id", '', 'button', 'ok', 'hiddenwin');
      } 
      echo "<div class='btn-group'>";
      common::printRPN($this->inlink('viewProblem'), $preAndNext, 'viewgroup');
      echo '</div>';
    ?>    
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->problem->detail?></legend>
        <fieldset>
          <legend><?php echo $lang->problem->content;?></legend>
          <div class='content'><?php echo $problem->content;?></div>
        </fieldset>
        <?php echo $this->fetch('file', 'printFiles', array('files' => $problem->files, 'fieldset' => 'true'));?>
      </fieldset>     
      <fieldset id='commentBox'>
        <legend><?php echo $lang->problem->other_solution;?></legend>
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
    <?php if ($problem->completetime == null):?>
      <fieldset>
        <legend><?php echo $lang->commentBox;?></legend>
        <div class='content'><?php echo $comment;?>
        <form class='form-condensed' method='post' target='hiddenwin'>
          <table class='table table-form'>
            <tr>
                <td colspan='2'><?php echo html::textarea('comment', '', "rows='6' class='w-p98'");?></td>
            </tr>
            <tr>
                <td colspan='3' class='text-center'><?php echo html::submitButton('评论') . html::linkButton($lang->goback, $this->inlink('viewProblem'));?></td>
            </tr>
          </table>
        </form>
      </fieldset>
    <?php else:?>
      <div class='actions actions-form'>
        <?php echo html::linkButton($lang->goback, $this->inlink('viewProblem'));?>
      </div>
    <?php endif;?>
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->problem->basicInfo;?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->problem->title;?></th>
            <td><?php echo $problem->title;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->problem->creator;?></th>
            <td>
              <?php 
                echo $users[$problem->asgID];
                if ($this->session->user->roleid == 'teacher'){
                  if (strstr($problem->relation, 'G')) echo '(指导学生)';
                  if (strstr($problem->relation, 'P')) echo '(毕业设计)';
                }
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->problem->receiver;?></th>
            <td>
              <?php 
                echo $users[$problem->acpID];
                if ($this->session->user->roleid == 'student'){
                  if (strstr($problem->relation, 'G')) echo '(指导老师)';
                  if (strstr($problem->relation, 'P')) echo '(毕业设计)';
                }
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->acl;?></th>
            <td><?php echo $lang->aclList[$problem->ACL];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->problem->readaccount;?></th>
            <td><?php echo count(explode('|', $problem->readaccount))-1;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->problem->createtime;?></th>
            <td><?php echo $problem->createtime;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->problem->teachers . $lang->problem->readtime;?></th>
            <td><?php echo $problem->readtime;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->problem->solvetime;?></th>
            <td><?php echo $problem->solvetime;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->problem->solvepeople;?></th>
            <td><?php echo $users[$problem->solID];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->problem->completetime;?></th>
            <td><?php echo $problem->completetime;?></td>
          </tr>
        </table>
      </fieldset>
    </div>
  </div> 
</div>

<script language='javascript'>$('#<?php echo $ID;?>').addClass('active')</script>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>