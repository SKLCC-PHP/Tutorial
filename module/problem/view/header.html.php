<?php include '../../common/view/header.html.php';?>
<div id='featurebar'>
  <ul class='nav'>
    <?php
      if (($this->session->userinfo->roleid == 'student') || ($this->session->userinfo->roleid == 'teacher'))
      {
        foreach ($lang->workspace->problemMenu as $key => $value)
        {
          echo "<li id = '" . $key . "'>" . html::a($this->createLink('problem', 'viewProblem', "viewtype=$key"), $value) . "</li>";
        }
      }
      else
      {
        echo "<li id = 'all'>" . html::a($this->createLink('problem', 'viewProblem', "viewtype=all"), $lang->workspace->problemMenu->all) . "</li>";
      }
    ?>
  </ul>
  <div class='actions'>
    <?php common::printIcon('problem', 'create');?>
  </div>
</div>
<script>$('#<?php echo $viewtype;?>').addClass('active')</script>
