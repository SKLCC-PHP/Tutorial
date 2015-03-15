<?php 
include '../../statistics/view/header.html.php';
switch ($browsetype) 
{
 	case 'task':
 		include '../../statistics/view/m.task.html.php';
 		break;
 	
 	case 'problem':
 		include '../../statistics/view/m.problem.html.php';
 		break;

 	case 'project':
 		include '../../statistics/view/m.project.html.php';
 		break;

 	case 'achievement':
 		include '../../statistics/view/m.achievement.html.php';
 		break;

 	case 'conclusion':
 		include '../../statistics/view/m.conclusion.html.php';
 		break;

 	default:
 		die();
 		break;
}
include '../../common/view/footer.html.php';
?>
