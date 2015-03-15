<?php
$config->installed       = true;
$config->debug           = true;
$config->requestType     = 'PATH_INFO';
$config->db->host        = '127.0.0.1';
$config->db->port        = '3306';
$config->db->name        = 'oa';
$config->db->user        = 'root';
$config->db->password    = 'lml';
$config->db->prefix      = 'oa_';
$config->webRoot         = getWebRoot();
$config->default->lang   = 'zh-cn';
$config->mysqldump       = 'C:\Program Files\MySQL\MySQL Server 5.1\bin\mysqldump.exe';