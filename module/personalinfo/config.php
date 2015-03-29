<?php
global $lang;

$config->personalinfo = new stdclass();
$config->personalinfo->createLib = new stdclass();
$config->personalinfo->editLib   = new stdclass();
$config->personalinfo->create    = new stdclass();
$config->personalinfo->edit      = new stdclass();

$config->personalinfo->createLib->requiredFields = 'name';
$config->personalinfo->editLib->requiredFields   = 'name';
$config->personalinfo->create->requiredFields = 'title';
$config->personalinfo->edit->requiredFields   = 'title';

$config->personalinfo->editor = new stdclass();
$config->personalinfo->editor->create = array('id' => 'content', 'tools' => 'fullTools');
$config->personalinfo->editor->edit   = array('id' => 'content,digest,comment', 'tools' => 'fullTools');

$config->personalinfo->search['module']                   = 'personalinfo';
$config->personalinfo->search['fields']['title']          = $lang->personalinfo->title;
$config->personalinfo->search['fields']['id']             = $lang->personalinfo->id;
$config->personalinfo->search['fields']['keywords']       = $lang->personalinfo->keywords;
$config->personalinfo->search['fields']['product']        = $lang->personalinfo->product;
$config->personalinfo->search['fields']['project']        = $lang->personalinfo->project;
$config->personalinfo->search['fields']['type']           = $lang->personalinfo->type;
$config->personalinfo->search['fields']['module']         = $lang->personalinfo->module;
$config->personalinfo->search['fields']['lib']            = $lang->personalinfo->lib;
$config->personalinfo->search['fields']['digest']         = $lang->personalinfo->digest;
$config->personalinfo->search['fields']['content']        = $lang->personalinfo->content;
$config->personalinfo->search['fields']['url']            = $lang->personalinfo->url;
$config->personalinfo->search['fields']['addedBy']        = $lang->personalinfo->addedBy;
$config->personalinfo->search['fields']['addedDate']      = $lang->personalinfo->addedDate;
$config->personalinfo->search['fields']['editedBy']       = $lang->personalinfo->editedBy;
$config->personalinfo->search['fields']['editedDate']     = $lang->personalinfo->editedDate;

$config->personalinfo->search['params']['title']         = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->personalinfo->search['params']['keywords']      = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->personalinfo->search['params']['product']       = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->personalinfo->search['params']['module']        = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->personalinfo->search['params']['project']       = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->personalinfo->search['params']['type']          = array('operator' => '=',       'control' => 'select', 'values' => $lang->personalinfo->types);
$config->personalinfo->search['params']['lib']           = array('operator' => '=',       'control' => 'select', 'values' => '' );
$config->personalinfo->search['params']['digest']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->personalinfo->search['params']['content']       = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->personalinfo->search['params']['url']           = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->personalinfo->search['params']['addedBy']       = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->personalinfo->search['params']['addedDate']     = array('operator' => '>=',      'control' => 'input',  'values' => '');
$config->personalinfo->search['params']['editedBy']      = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->personalinfo->search['params']['editedDate']    = array('operator' => '>=',      'control' => 'input',  'values' => '');
