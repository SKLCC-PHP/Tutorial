<?php 
	include '../../common/view/header.html.php';
	if($type == 'byGroup')  include 'privbygroup.html.php';
	if($type == 'byModule') include 'privbymodule.html.php';
	include '../../common/view/footer.html.php';
