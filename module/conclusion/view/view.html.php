<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['conclusion']);?> <strong><?php echo $conclusion->id;?></strong></span>
    <strong><?php echo $conclusion->title;?></strong>
  </div>
  <div class='actions'>
    <?php
      common::printIcon('conclusion', 'edit', "conclusionID=$conclusion->id", '', 'button', 'pencil');
      common::printIcon('conclusion', 'delete', "conclusionID=$conclusion->id", '', 'button', '', 'hiddenwin');

      echo "<div class='btn-group'>";
      common::printRPN($this->inlink('viewConclusion'), $preAndNext, 'view');
      echo '</div>';
    ?>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->conclusion->content;?></legend>
        <div class='content'><?php echo $conclusion->content;?></div>
      </fieldset>
      <?php
          if($conclusion->files) 
              echo $this->fetch('file', 'printFiles', array('files' => $conclusion->files, 'fieldset' => 'true'));
      ?>
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
        <div class='content'><?php echo $comment;?>
        <form class='form-condensed' method='post' target='hiddenwin'>
          <table class='table table-form'>
            <tr>
                <td colspan='2'><?php echo html::textarea('comment', '', "rows='6' class='w-p98'");?></td>
            </tr>
            <tr>
                <td colspan='3' class='text-center'><?php echo html::submitButton('评论') . html::linkButton($lang->goback, $this->inlink('viewConclusion'));?></td>
            </tr>
          </table>
        </form>
      </fieldset>
    </div>
  </div>
    <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->basicInfo?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->conclusion->title;?></th>
            <td><?php echo $conclusion->title;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->conclusion->creator;?></th>
            <td><?php echo $userpairs[$conclusion->creatorID];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->conclusion->create_time;?></th>
            <td><?php echo $conclusion->createtime;?></td>
          </tr>
          <tr> 
            <th><?php echo $lang->conclusion->update_time;?></th>
            <td><?php echo $conclusion->updatetime;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->conclusion->viewtime;?></th>
            <td><?php echo $conclusion->viewtime;?></td>
          </tr>  
        </table>
      </fieldset>
    </div>
  </div>
</div>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>
