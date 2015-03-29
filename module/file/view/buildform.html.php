<style>
.fileBox {margin-bottom: 10px; width: 100%}
table.fileBox td {padding: 0!important}
.fileBox .input-control > input[type='file'] {width: 100%; height: 100%; height: 26px; line-height: 26px; border: none; position: relative;}
.fileBox td .btn {border-radius: 0; border-left: none}
.file-wrapper.form-control {border-right: 0}
</style>
<div id='fileform'>
  <?php 
  /* Define the html code of a file row. */
  $fileRow = <<<EOT
  <table class='fileBox' id='fileBox\$i'>
    <tr>
    <td class='w-p45'><div class='form-control file-wrapper'><img id="tempimg" dynsrc="" src="" style="display:none" /><input type='file' id='fileuploade' name='files[]' class='fileControl'  tabindex='-1' onchange='checkfile()'/></div></td>
      <td class=''><input type='text' name='labels[]' class='form-control' placeholder='{$lang->file->label}' tabindex='-1' /></td>
      <td class='w-30px'><a href='javascript:void();' onclick='addFile(this)' class='btn btn-block'><i class='icon-plus'></i></a></td>
      <td class='w-30px'><a href='javascript:void();' onclick='delFile(this)' class='btn btn-block'><i class='icon-remove'></i></a></td>
    </tr>
  </table>
EOT;
  for($i = 1; $i <= $fileCount; $i ++) echo str_replace('$i', $i, $fileRow);
?>
</div>

<script language='javascript'>
$(function()
{
    var maxUploadInfo = maxFilesize();
    parentTag = $('#fileform').parent();
    if(parentTag.attr('tagName') == 'TD') parentTag.parent().find('th').append(maxUploadInfo); 
    if(parentTag.attr('tagName') == 'FIELDSET') parentTag.find('legend').append(maxUploadInfo);
});

/**
 * Show the upload max filesize of config.  
 */
function maxFilesize(){return "(<?php printf($lang->file->maxUploadSize, ini_get('upload_max_filesize'));?>)";}

/**
 * Set the width of the file form.
 * 
 * @param  float  $percent 
 * @access public
 * @return void
 */
function setFileFormWidth(percent)
{
    totalWidth = Math.round($('#fileform').parent().width() * percent);
    titleWidth = totalWidth - $('.fileControl').width() - $('.fileLabel').width() - $('.icon').width();
    if($.browser.mozilla) titleWidth  -= 8;
    if(!$.browser.mozilla) titleWidth -= 12;
    $('#fileform .text-3').css('width', titleWidth + 'px');
};

/**
 * Add a file input control.
 * 
 * @param  object $clickedButton 
 * @access public
 * @return void
 */
function addFile(clickedButton)
{
    fileRow = <?php echo json_encode($fileRow);?>;
    fileRow = fileRow.replace('$i', $('.fileID').size() + 1);
    $(clickedButton).closest('.fileBox').after(fileRow);

    setFileFormWidth(<?php echo $percent;?>);
    updateID();
}

/**
 * Delete a file input control.
 * 
 * @param  object $clickedButton 
 * @access public
 * @return void
 */
function delFile(clickedButton)
{
    if($('.fileBox').size() == 1) return;
    $(clickedButton).closest('.fileBox').remove();
    updateID();
}

/**
 * Update the file id labels.
 * 
 * @access public
 * @return void
 */
function updateID()
{
    i = 1;
    $('.fileID').each(function(){$(this).html(i ++)});
}

$(function(){setFileFormWidth(<?php echo $percent;?>)});


/*check the upload is or not over the max size*/
var maxsize = 8*1024*1024;//2M
var errMsg = "上传的附件文件不能超过8M！！！";
var tipMsg = "您的浏览器暂不支持计算上传文件的大小，确保上传文件不要超过8M，建议使用IE10或以下版本、FireFox、Chrome浏览器。";
var  browserCfg = {};
var ua = window.navigator.userAgent;
if (ua.indexOf("MSIE")>=1){
  browserCfg.ie = true;
}else if(ua.indexOf("Firefox")>=1){
  browserCfg.firefox = true;
}else if(ua.indexOf("Chrome")>=1){
  browserCfg.chrome = true;
}
function checkfile()
{
  try
  {
    var obj_file = document.getElementById("fileuploade");
    if(obj_file.value == "")
    {
      alert("请先选择上传文件");
      return;
    }
    var filesize = 0;
    if(browserCfg.firefox || browserCfg.chrome )
    {
      filesize = obj_file.files[0].size;

      checkExt(obj_file.files[0].name);
    }
    else if(browserCfg.ie)
    {
      var obj_img = document.getElementById('tempimg');
      obj_img.dynsrc = obj_file.value;
      filesize = obj_img.fileSize;

      checkExt(obj_file.value);   
    }
    else if(obj_file.files[0].name)
    {
      filesize = obj_file.files[0].size;
      checkExt(obj_file.files[0].name);
    }
    else
    {
      alert(tipMsg);
      return;
    }
    /*check the size*/
    if(filesize == -1)
    {
      alert(tipMsg);
      return;
    }
    else if(filesize > maxsize)
    {
      clearFileInput();
      alert(errMsg);
      return;
    }
    // else
    // {
    //   alert("文件大小符合要求");
    //   return;
    // }
  }
  catch(e)
  {
    alert(e);
  }
}

function clearFileInput()
{
  var content = document.getElementById('fileuploade');

  content.value = '';
  content.focus();
}

function checkExt(name)
{
  var idx = name.lastIndexOf(".");
  var ext;
  var EXTS = "ppt,jpg,png,jpeg,gif,bmp,zip,rar,doc,xlsx,xls,docx,pdf,txt";
  if (idx != -1)
  {   
    ext = name.substr(idx+1).toUpperCase();   
    ext = ext.toLowerCase( );
    // alert("ext="+ext);
    if (EXTS.indexOf(ext) == -1)
    {
        alert("文件类型非法，请上传合法文件类型！");
        clearFileInput(); 
        return;  
    }
  } 
  else 
  {  
    alert("文件类型非法，请上传合法文件类型！"); 
    clearFileInput();
    return;
  }
}
</script>
