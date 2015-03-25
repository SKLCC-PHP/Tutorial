<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php js::set('browseType', $browseType);?>
<div id='featurebar'>
  <ul class='nav'>
  </ul>
  <div class='actions'>
  </div>
  <div id='querybox' class='<?php if($browseType =='bysearch') echo 'show';?>'></div>
</div>
<div class='main'>
  <form method='post' id='productStoryForm'>
    <table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='storyList'>
      <tfoot>
      <tr>
      </tr>
      </tfoot>
    </table>
  </form>
</div>
<script language='javascript'>
$('#module<?php echo $moduleID;?>').addClass('active')
$('#<?php echo $browseType;?>Tab').addClass('active')
</script>
<?php include '../../common/view/footer.html.php';?>
