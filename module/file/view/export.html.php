<?php
/**
 * The export view file of file module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<script>
function setDownloading()
{
    if($.browser.opera) return true;   // Opera don't support, omit it.

    $.cookie('downloading', 0);
    time = setInterval("closeWindow()", 300);
    return true;
}

function closeWindow()
{
    if($.cookie('downloading') == 1)
    {
        parent.$.closeModal();
        $.cookie('downloading', null);
        clearInterval(time);
    }
}
function switchEncode(fileType)
{
    var condition = ((fileType != 'csv') && (fileType != 'xls'));

    $('#encode').toggleClass('hidden', condition);
}
</script>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['export']);?></span>
    <strong><?php echo $lang->export;?></strong>
  </div>
</div>
<form class='form-condensed' method='post' target='hiddenwin' onsubmit='setDownloading();' style='padding: 40px 5% 50px'>
  <table class='w-p100'>
    <tr>
      <td>
        <div class='input-group'>
          <span class='input-group-addon'><?php echo $lang->setFileName;?></span>
          <?php echo html::input('fileName', '', 'class=form-control required="required"');?>
        </div>
      </td>
      <td class='w-80px'>
        <?php echo html::select('fileType',   $lang->exportFileTypeList, '', 'onchange=switchEncode(this.value) class="form-control"');?>
      </td>
      <td class='w-90px'>
        <?php echo html::select('encode',     $config->charsets[$this->cookie->lang], 'utf-8', key($lang->exportFileTypeList) == 'xls' ? "class='form-control'" : "class='form-control hidden'");?>
      </td>
<!--       <td class='w-100px'>
        <?php echo html::select('exportType', $lang->exportTypeList, ($this->cookie->checkedItem) ? 'selected' : 'all', "class='form-control'");?>
      </td> -->
      <td><?php echo html::submitButton($lang->export);?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>
