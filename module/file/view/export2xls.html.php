<?php
/**
 * The export2csv view file of file module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
foreach($fields as $field)
{
   echo $field."\t";
}

echo "\n";

foreach ($rows as $row) 
{
	foreach ($row as $value) 
	{
		echo strip_tags($value)."\t";
	}
	echo "\n";
}
?>