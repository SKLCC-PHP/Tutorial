<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('confirmFinish', $lang->task->confirmFinish); ?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['task']);?> <strong><?php echo $task->id;?></strong></span>
    <strong><?php echo $task->title;?></strong>
  </div>
  <div class='actions'>
    <?php
    $actionLinks = '';
    if(!$task->deleted)
    {
        ob_start();
        echo "<div class='btn-group'>";
        if (!$task->completetime) 
        common::printIcon('task', 'finish', "taskID=$task->id", '', 'button', 'ok-sign','hiddenwin');
        common::printIcon('task', 'edit',  "taskID=$task->id");
        common::printIcon('task', 'delete', "projectID=$task->project&taskID=$task->id", '', 'button', '', 'hiddenwin');
        echo '</div>';

        $actionLinks = ob_get_contents();
        ob_clean();
        echo $actionLinks;
    }
    else
    {
        common::printRPN($browseLink);
    }
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
      <fieldset>
        <div class='content'><?php echo $comment;?>
        <form class='form-condensed' method='post' target='hiddenwin'>
          <table class='table table-form'>
            <tr>
              <td colspan='2'><?php echo html::textarea('comment', '', "rows='6' class='w-p98'");?></td>
            </tr>
            <tr>
              <td colspan='3' class='text-center'><?php echo html::submitButton('批阅') . html::backButton();?></td>
            </tr>
          </table>
        </form>
      </fieldset>
    </div>
  </div>
</div>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>
