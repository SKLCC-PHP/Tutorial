<?php
$config->project = new stdclass();
$config->project->batchCreate = 10;

$config->project->edit     = new stdclass();

$config->project->editor = new stdclass();
$config->project->editor->create = array('id' => 'description', 'tools' => 'simpleTools');
$config->project->editor->edit   = array('id' => 'description', 'tools' => 'simpleTools');
$config->project->editor->view   = array('id' => 'comment', 'tools' => 'simpleTools');

$config->project->create = new stdclass();
$config->project->create->requiredFields = 
	'name, start_time, tea_ID, deadline, description';
?>