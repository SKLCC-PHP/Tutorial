<?php
/* Open daily reminder.*/
$config->tutorial                      = new stdclass();

$config->tutorial->viewAllStudent      = new stdclass();
$config->tutorial->viewAllStudent->search['module']               = 'tutorial';

$config->tutorial->viewAllStudent->search['fields']['realname']   = $lang->tutorial->name;
$config->tutorial->viewAllStudent->search['fields']['account']    = $lang->tutorial->account;

$config->tutorial->viewAllStudent->search['params']['realname']   = array('operator' => 'include', 'control' => 'input', 'values' => '');
$config->tutorial->viewAllStudent->search['params']['account']    = array('operator' => 'include', 'control' => 'input', 'values' => '');
?>