<?php include '../../common/view/header.html.php';?>
<!--<script language="Javascript">var viewtype='<?php //echo $viewtype;?>';</script>-->
<div id='featurebar'>
  <ul class='nav'>
    <?php
      foreach ($tutorialList as $value) 
      {
        echo "<li id = '" . $value . "'>" . html::a($this->createLink('tutorial', $value), $lang->workspace->tutorialMenu->$value) . "</li>";
      }
    ?>
  </ul>
</div>
<script>$('#<?php echo $active;?>').addClass('active')</script>
