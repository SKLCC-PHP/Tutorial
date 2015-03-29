<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/sparkline.html.php';?>
<?php css::import($defaultTheme . 'index.css',   $config->version);?>
<div class="row">
	<div class="col-md-8">
		<?php include './blocktasks.html.php';?>
		<?php include './blockproblems.html.php';?>
	</div>
	<!--index view show dymatic-->
	<div class="col-md-4">
		<?php //if(common::hasPriv('notice', 'dynamic')) include './blockdynamic.html.php';?>
		<?php include './blocknotice.html.php';?>
	</div>
</div>
<?php include '../../common/view/footer.html.php';?>  
