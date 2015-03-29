<?php
/**
 * The file module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id: zh-cn.php 4630 2013-04-10 05:54:08Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->file = new stdclass();
$lang->file->common        = '附件';
$lang->file->download      = '下载附件';
$lang->file->edit          = '重命名';
$lang->file->inputFileName = '请输入附件名称';
$lang->file->delete        = '删除附件';
$lang->file->export2CSV    = '导出CSV';
$lang->file->ajaxUpload    = '接口：编辑器上传附件';
$lang->file->label         = '标题：';
$lang->file->maxUploadSize = "<span class='red'>%s</span>";

$lang->file->errorNotExists   = "<span class='red'>文件夹 '%s' 已被删除</span>";
$lang->file->errorCanNotWrite = "<span class='red'>文件夹 '%s' 不可写,请改变文件夹的权限。在linux中输入指令:sudo chmod -R 777 '%s'</span>";
$lang->file->confirmDelete    = " 您确定删除该附件吗？";
$lang->file->NotExists = '文件已经被删除！';
