<?php
/**
 * The config file of ZenTaoPMS.
 *
 * Don't modify this file directly, copy the item to my.php and change it.
 *
 * @copyright   Copyright 2009-2013 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     config
 * @version     $Id: config.php 5068 2013-07-08 02:41:22Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
/* Judge class config and function getWebRoot exists or not, make sure php shells can work. */
if(!class_exists('config')){class config{}}
if(!function_exists('getWebRoot')){function getWebRoot(){}}

/* Basic settings. */
$config = new config();
$config->version      = '1.0';             // The version of zentaopms. Don't change it.
$config->charset      = 'UTF-8';           // The charset of zentaopms.
$config->cookieLife   = time() + 3*60;  // The cookie life time.
$config->timezone     = 'Asia/Shanghai';   // The time zone setting, for more see http://www.php.net/manual/en/timezones.php
$config->webRoot      = '';                // The root path of the pms.
$config->checkVersion = true;              // Auto check for new version or not.

/* The request settings. */
$config->requestType = 'PATH_INFO';       // The request type: PATH_INFO|GET, if PATH_INFO, must use url rewrite.
$config->pathType    = 'clean';           // If the request type is PATH_INFO, the path type.
$config->requestFix  = '-';               // The divider in the url when PATH_INFO.
$config->moduleVar   = 'm';               // requestType=GET: the module var name.
$config->methodVar   = 'f';               // requestType=GET: the method var name.
$config->viewVar     = 't';               // requestType=GET: the view var name.
$config->sessionVar  = 'sid';             // requestType=GET: the session var name.

/* Supported views. */
$config->views  = ',html,json,mhtml,'; 

/* Set the wide window size. */
$config->wideSize = 1400;

/* Supported languages. */
$config->langs['zh-cn'] = '简体';
$config->langs['zh-tw'] = '繁體';
$config->langs['en']    = 'English';

/* Supported charsets. */
$config->charsets['zh-cn']['utf-8'] = 'UTF-8';
$config->charsets['zh-cn']['gbk']   = 'GBK';
$config->charsets['zh-tw']['utf-8'] = 'UTF-8';
$config->charsets['zh-tw']['big5']  = 'BIG5';
$config->charsets['en']['utf-8']    = 'UTF-8';

/* Default settings. */
$config->default = new stdclass();
$config->default->view   = 'html';        // Default view.
$config->default->lang   = 'en';          // Default language.
$config->default->theme  = 'default';     // Default theme.
$config->default->module = 'index';       // Default module.
$config->default->method = 'index';       // Default method.

/* Upload settings. */
$config->file = new stdclass();
$config->file->dangers = 'php,jsp,py,rb,asp,'; // Dangerous files.
$config->file->maxSize = 1024 * 1024;          // Max size.

/* Master database settings. */
$config->db = new stdclass();
$config->db->persistant     = false;     // Pconnect or not.
$config->db->driver         = 'mysql';   // Must be MySQL. Don't support other database server yet.
$config->db->encoding       = 'UTF8';    // Encoding of database.
$config->db->strictMode     = false;     // Turn off the strict mode of MySQL.
//$config->db->emulatePrepare = true;    // PDO::ATTR_EMULATE_PREPARES
//$config->db->bufferQuery    = true;     // PDO::MYSQL_ATTR_USE_BUFFERED_QUERY

/* Slave database settings. */
$config->slaveDB = new stdclass();
$config->slaveDB->persistant = false;      
$config->slaveDB->driver     = 'mysql';    
$config->slaveDB->encoding   = 'UTF8';     
$config->slaveDB->strictMode = false;      
$config->slaveDB->checkCentOS= true;       

/* Include the custom config file. */
$configRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$myConfig   = $configRoot . 'my.php';
if(file_exists($myConfig)) include $myConfig;

/* Set default table prefix. */
if(!isset($config->db->prefix)) $config->db->prefix = 'zt_';

/* Define the tables. */
define('TABLE_COMPANY',       '`' . $config->db->prefix . 'company`');
define('TABLE_CONFIG',        '`' . $config->db->prefix . 'config`');
define('TABLE_USER',          '`' . $config->db->prefix . 'user`');
define('TABLE_GROUP',         '`' . $config->db->prefix . 'group`');
define('TABLE_GROUPPRIV',     '`' . $config->db->prefix . 'rolepriv`');
define('TABLE_COLLEGE',       '`' . $config->db->prefix . 'college`');
define('TABLE_TASK',          '`' . $config->db->prefix . 'task`');
define('TABLE_FILE',          '`' . $config->db->prefix . 'file`');
define('TABLE_RELATIONS',     '`' . $config->db->prefix . 'ts_relations`');
define('TABLE_COMMENT',     '`' . $config->db->prefix . 'comment`');
define('TABLE_CONCLUSION',     '`' . $config->db->prefix . 'conclusion`');
define('TABLE_ACHIEVEMENT',     '`' . $config->db->prefix . 'achievement`');
define('TABLE_PROJECT',     '`' . $config->db->prefix . 'project`');
define('TABLE_NOTICE',        '`' . $config->db->prefix . 'notice`');
define('TABLE_ACTION',        '`' . $config->db->prefix . 'action`');
define('TABLE_HISTORY',       '`' . $config->db->prefix . 'history`');
define('TABLE_QUESTION',       '`' . $config->db->prefix . 'question`');

$config->objectTables['task']        	= TABLE_TASK;
$config->objectTables['notice']        	= TABLE_NOTICE;
$config->objectTables['problem']    	= TABLE_QUESTION;
$config->objectTables['user']        	= TABLE_USER;
$config->objectTables['achievement']    = TABLE_ACHIEVEMENT;
$config->objectTables['project']        = TABLE_PROJECT;
$config->objectTables['comment']        = TABLE_COMMENT;
$config->objectTables['file']       	= TABLE_FILE;
$config->objectTables['group']       	= TABLE_GROUP;
$config->objectTables['company']       	= TABLE_COMPANY;
$config->objectTables['rolepriv']       = TABLE_GROUPPRIV;
$config->objectTables['conclusion']     = TABLE_CONCLUSION;
$config->objectTables['action']     	= TABLE_ACTION;
$config->objectTables['statistics']     = TABLE_USER;

/* Include extension config files. */
$extConfigFiles = glob($configRoot . 'ext/*.php');
if($extConfigFiles) foreach($extConfigFiles as $extConfigFile) include $extConfigFile;
