<?php include '../../common/view/header.html.php';?>
<!--<script language="Javascript">var viewtype='<?php //echo $viewtype;?>';</script>-->
<div id='featurebar'>
    <ul class='nav'>
        <?php
        $method = $app->getMethodName();

        echo "<li id='task'>" . html::a($this->createLink('statistics', $method ,'viewtype=task'),  '任务') . "</li>";
        echo "<li id='problem'>" . html::a($this->createLink('statistics', $method ,'viewtype=problem'),  '问题') . "</li>";
        echo "<li id='project'>" . html::a($this->createLink('statistics', $method ,'viewtype=project'),  '课题项目') . "</li>";
        echo "<li id='achievement'>" . html::a($this->createLink('statistics', $method ,'viewtype=achievement'),  '成果') . "</li>";
        echo "<li id='conclusion'>" . html::a($this->createLink('statistics', $method ,'viewtype=conclusion'),  '小结') . "</li>";
        ?>
    </ul>

    <div class="actions">
      <div class='btn-group'>
        <?php
          common::printIcon('statistics', 'exportDetails', "browsetype=$browsetype&viewtype=$viewtype&orderBy=$orderBy", '', 'button', 'download-alt', 'hiddenwin');
        ?>
      </div>
    </div>

</div>
<script>$('#<?php echo $browsetype;?>').addClass('active')</script>