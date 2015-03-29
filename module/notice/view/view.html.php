<?php
/**
 * The view file of notice module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     notice
 * @version     $Id: view.html.php 4808 2013-06-17 05:48:13Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['notice']);?> <strong><?php echo $notice->id;?></strong></span>
    <strong><?php echo $notice->title;?></strong>
  </div>
  <div class='actions'>
    <?php   
      if($this->loadModel('notice')->checkPriv($notice->id, 'delete'))
        common::printIcon('notice', 'delete', "noticeID=$notice->id", $notice, 'button', '', 'hiddenwin');
      
      echo "<div class='btn-group'>";
      $this->notice->printRPNs($this->inlink('viewNotice'), $preAndNext, $orderBy);   
      echo '</div>';                            
    ?>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>  
      <fieldset>
        <fieldset>
          <div class='content'><?php echo $notice->content;?></div>
        </fieldset>
        <?php if(!empty($notice->files)):?>
        <fieldset>
          <legend><?php echo $lang->notice->files;?></legend>
          <?php echo $this->fetch('file', 'printFiles', array('files' => $notice->files, 'fieldset' => 'false'));?>
        </fieldset>
        <?php endif;?> 
      </fieldset>
      <div class='actions actions-form'>
        <?php echo html::backButton();?>
      </div>
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->basicInfo?></legend>
        <table class='table table-data table-condensed table-borderless'>
          <tr>
            <th class='w-80px text-right'><?php echo $lang->notice->department;?></th>
            <td><?php echo $collegeList[$notice->college_id];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->notice->creator;?></th>
            <td><?php echo $userpairs[$notice->creatorID];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->notice->date;?></th>
            <td><?php echo $notice->createtime;?></td>
          </tr>
        </table>
      </fieldset>
    </div>
  </div>
</div>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>
