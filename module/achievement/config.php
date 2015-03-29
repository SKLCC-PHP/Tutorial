<?php
$config->achievement = new stdclass();

$config->achievement->create   = new stdclass();
$config->achievement->edit     = new stdclass();

$config->achievement->create->requiredFields      = 'title';

$config->achievement->editor = new stdclass();
$config->achievement->editor->create     = array('id' => 'content,description', 'tools' => 'fullTools');
$config->achievement->editor->edit     = array('id' => 'content,description', 'tools' => 'fullTools');
$config->achievement->editor->check    = array('id' => 'comment', 'tools' => 'fullTools');

$config->achievement->exportFields = '
    id, 
	title, content,
	acp_ID, content,
	create_time, deadline,
	mailto, files
    ';
