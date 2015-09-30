<?php
$config->problem = new stdclass();
$config->problem->batchCreate = 10;

$config->problem->edit     = new stdclass();

$config->problem->editor = new stdclass();
$config->problem->editor->create = array('id' => 'content', 'tools' => 'simpleTools');
$config->problem->editor->edit   = array('id' => 'content', 'tools' => 'simpleTools');
$config->problem->editor->view   = array('id' => 'comment', 'tools' => 'simpleTools');
$config->problem->editor->viewgroup = array('id' => 'comment', 'tools' => 'simpleTools');

$config->problem->create = new stdclass();
$config->problem->create->requiredFields = 
	'title, teachers, content';
?>