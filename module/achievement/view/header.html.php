<?php include '../../common/view/header.html.php';?>
<!--<script language="Javascript">var viewtype='<?php //echo $viewtype;?>';</script>-->
<div id='featurebar'>
  <ul class='nav'>
    <li><strong></strong></li>
  </ul>
  <div class="actions">
  	<div class='btn-group'>
	    <?php
	    common::printIcon('achievement', 'create', "", '', 'button', 'plus');
	    ?>
  	</div>
  </div>
</div>
<script>$('#<?php echo $viewtype;?>').addClass('active')</script>