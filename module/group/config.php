<?php
$config->group = new stdclass();
$config->group->create = new stdclass();
$config->group->edit   = new stdclass();
$config->group->create->requiredFields = 'name, role, rank';
$config->group->edit->requiredFields   = 'name, role, rank';
