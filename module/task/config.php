<?php
$config->task = new stdclass();
$config->task->batchCreate = 10;

$config->task->create   = new stdclass();
$config->task->edit     = new stdclass();
$config->task->start    = new stdclass();
$config->task->finish   = new stdclass();
$config->task->activate = new stdclass();

$config->task->create->requiredFields      = 'title,create_time,assignedTo,content';
$config->task->edit->requiredFields        = 'title,begintime,deadline,days';

$config->task->batchEdit = new stdclass();
$config->task->batchEdit->columns = 5;

$config->task->editor = new stdclass();
$config->task->editor->create = array('id' => 'content', 'tools' => 'simpleTools');
$config->task->editor->edit = array('id' => 'content,comment', 'tools' => 'simpleTools');
$config->task->editor->submit = array('id' => 'submitcontent', 'tools' => 'simpleTools');
$config->task->editor->view = array('id' => 'comment', 'tools' => 'simpleTools');
$config->task->editor->viewgroup = array('id' => 'comment', 'tools' => 'simpleTools');
$config->task->editor->assess     = array('id' => 'content,comment', 'tools' => 'simpleTools');
$config->task->editor->editsubmit   = array('id' => 'submitcontent', 'tools' => 'simpleTools');

$config->task->exportFields = '
    id, 
	title, content,
	acp_ID, content,
	create_time, deadline,
	mailto, files
    ';
