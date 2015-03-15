<?php include '../../common/view/header.html.php';?>
<!--<script language="Javascript">var viewtype='<?php //echo $viewtype;?>';</script>-->
<div id='featurebar'>
  <ul class='nav'>
    <?php
    $method = $app->getMethodName();

    foreach ($taskList as $value)
    {
      echo "<li id='".$value."'>" . html::a($this->createLink('task', $method ,'viewtype='.$value),  $lang->workspace->taskMenu->$value) . "</li>";
    }
    ?>
  </ul>
  <div class="actions">
  	<div class='btn-group'>
	    <?php
	    common::printIcon('task', 'create', "", '', 'button', 'plus');
	    ?>
  	</div>
  </div>
</div>
<script>$('#<?php echo $viewtype;?>').addClass('active')</script>