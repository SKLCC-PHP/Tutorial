<?php include '../../common/view/header.html.php';?>
<!--<script language="Javascript">var viewtype='<?php //echo $viewtype;?>';</script>-->
<div id='featurebar'>
  <ul class='nav'>
    <?php
    $method = $app->getMethodName();
    
    foreach ($tutors as $tutor)
    {
        echo "<li id='".$tutor->account."'>" . html::a($this->createLink('tutor', $method ,'tutor_account='.$tutor->account),  $tutor->realname) . "</li>";
    }
    ?>
  </ul>
</div>
<script>$("#<?php echo $tutor_account;?>").addClass('active')</script>