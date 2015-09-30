<?php
$config->conclusion = new stdclass();

$config->conclusion->create   = new stdclass();
$config->conclusion->edit     = new stdclass();
$config->conclusion->start    = new stdclass();
$config->conclusion->finish   = new stdclass();
$config->conclusion->activate = new stdclass();

$config->conclusion->create->requiredFields      = 'title, content';

$config->conclusion->editor = new stdclass();
$config->conclusion->editor->create     = array('id' => 'content,comment', 'tools' => 'fullTools');
$config->conclusion->editor->edit     = array('id' => 'content,comment', 'tools' => 'fullTools');
$config->conclusion->editor->view     = array('id' => 'content,comment', 'tools' => 'simpleTools');

$config->conclusion->exportFields = '
    id, 
	title, content,
	acp_ID, content,
	create_time, deadline,
	mailto, files
    ';
