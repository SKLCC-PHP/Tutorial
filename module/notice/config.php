<?php
$config->notice = new stdclass();

$config->notice->create->requiredFields = 'title, content';

$config->notice->editor = new stdclass();
$config->notice->editor->create   = array('id' => 'content', 'tools' => 'fullTools');
?>