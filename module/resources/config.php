<?php
$config->resources = new stdClass();
$config->resources->batchCreate = 10;

$config->resources->create  = new stdclass();
$config->resources->edit    = new stdclass();
$config->resources->resolve = new stdclass();
$config->resources->create->requiredFields  = 'title,openedBuild';
$config->resources->edit->requiredFields    = $config->resources->create->requiredFields;
$config->resources->resolve->requiredFields = 'resolution';

$config->resources->batchEdit = new stdclass();
$config->resources->batchEdit->columns = 9;

$config->resources->list = new stdclass();
$config->resources->list->allFields = 'id, module, project, story, task, 
    title, keywords, severity, pri, type, os, browser, hardware,
    found, steps, status, activatedCount, confirmed, mailto,
    openedBy, openedDate, openedBuild, 
    assignedTo, assignedDate,
    resolvedBy, resolution, resolvedBuild, resolvedDate,
    closedBy, closedDate, 
    duplicateBug, linkBug, 
    case,
    lastEditedBy,
    lastEditedDate';
$config->resources->list->defaultFields = 'id,severity,pri,title,openedBy,assignedTo,resolvedBy,resolution';

$config->resources->list->exportFields = 'id, product, module, project, story, task, 
    title, keywords, severity, pri, type, os, browser,
    steps, status, activatedCount, confirmed, mailto,
    openedBy, openedDate, openedBuild, 
    assignedTo, assignedDate,
    resolvedBy, resolution, resolvedBuild, resolvedDate,
    closedBy, closedDate, 
    duplicateBug, linkBug, 
    case,
    lastEditedBy,
    lastEditedDate, files';

$config->resources->editor = new stdclass();
$config->resources->editor->upload   = array('id' => 'extra', 'tools' => 'simpleTools');