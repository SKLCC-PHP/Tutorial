<?php
/**
 * @author Green iat
 * @date 20140829
 */

/* Module order. */
$lang->moduleOrder[0]   = 'index';
$lang->moduleOrder[5]   = 'my';
$lang->moduleOrder[10]   = 'workspace';
$lang->moduleOrder[15]   = 'task';
$lang->moduleOrder[20]  = 'problem';
$lang->moduleOrder[25]   = 'project';
$lang->moduleOrder[30]   = 'achievement';
$lang->moduleOrder[35]   = 'conclusion';
$lang->moduleOrder[40]  = 'tutor';
$lang->moduleOrder[45]  = 'resources';
$lang->moduleOrder[50]  = 'statistics';
$lang->moduleOrder[55]  = 'personalinfo';
$lang->moduleOrder[60]  = 'student';
$lang->moduleOrder[65]  = 'tutorial';
$lang->moduleOrder[70]  = 'file';
$lang->moduleOrder[75]  = 'company';
$lang->moduleOrder[80]  = 'group';
$lang->moduleOrder[85]  = 'user';
$lang->moduleOrder[90] = 'action'; 
$lang->moduleOrder[95] = 'system';
$lang->moduleOrder[100] = 'mail';
$lang->moduleOrder[105] = 'notice';


$lang->resource = new stdclass();

/* Index module. */
$lang->resource->index 			= new stdclass();
$lang->resource->index->index 	= 'index';
$lang->index->methodOrder[0] 	= 'index';

/* my. */
$lang->resource->my 			= new stdclass();
$lang->resource->my->index 		= 'index';

$lang->index->methodOrder[0] 	= 'index';

/* workspace. */
$lang->resource->workspace 					= new stdclass();

$lang->resource->workspace->index     		= 'index';
$lang->resource->workspace->MyCalendar    	= 'MyCalendar';
$lang->resource->workspace->task    		= 'task';
$lang->resource->workspace->viewProblem     = 'viewProblem';
$lang->resource->workspace->viewAchievement = 'viewAchievement';
$lang->resource->workspace->viewProject    	= 'viewProject';
$lang->resource->workspace->viewConclusion 	= 'viewConclusion';
$lang->resource->workspace->viewTutorialSystem = 'viewTutorialSystem';
$lang->resource->workspace->viewNotice = 'viewNotice';

$lang->workspace->methodOrder[0]  = 'index';
$lang->workspace->methodOrder[5]  = 'MyCalendar';
$lang->workspace->methodOrder[10] = 'task';
$lang->workspace->methodOrder[15] = 'viewProblem';
$lang->workspace->methodOrder[20] = 'viewAchievement';
$lang->workspace->methodOrder[25] = 'viewProject';
$lang->workspace->methodOrder[30] = 'viewConclusion';
$lang->workspace->methodOrder[35] = 'viewTutorialSystem';
$lang->workspace->methodOrder[40] = 'viewNotice';

/* task. */
$lang->resource->task 					= new stdclass();
$lang->resource->task->index     		= 'index';
$lang->resource->task->viewTask     	= 'viewTask';
$lang->resource->task->create    		= 'create';
$lang->resource->task->edit    			= 'edit';
$lang->resource->task->assess     		= 'assess';
$lang->resource->task->delete 			= 'delete';
$lang->resource->task->batchDelete      = 'batchDelete';
$lang->resource->task->finish    		= 'finish';
$lang->resource->task->view 			= 'view';
$lang->resource->task->viewGroup        = 'viewGroup';
$lang->resource->task->submit 			= 'submit';
$lang->resource->task->editsubmit       = 'editsubmit';
$lang->resource->task->search           = 'search';

$lang->task->methodOrder[0]  = 'index';
$lang->task->methodOrder[5]  = 'viewTask';
$lang->task->methodOrder[10]  = 'create';
$lang->task->methodOrder[15] = 'edit';
$lang->task->methodOrder[20] = 'assess';
$lang->task->methodOrder[25] = 'delete';
$lang->task->methodOrder[30] = 'batchDelete';
$lang->task->methodOrder[35] = 'finish';
$lang->task->methodOrder[40] = 'view';
$lang->task->methodOrder[45] = 'viewGroup';
$lang->task->methodOrder[50] = 'submit';
$lang->task->methodOrder[55] = 'editsubmit';
$lang->task->methodOrder[60] = 'search';

/* problem. */
$lang->resource->problem                   = new stdclass();

$lang->resource->problem->index            = 'index';
$lang->resource->problem->viewProblem      = 'viewProblem';
$lang->resource->problem->create           = 'create';
$lang->resource->problem->edit             = 'edit';
$lang->resource->problem->delete           = 'delete';
$lang->resource->problem->batchDelete      = 'batchDelete';
$lang->resource->problem->view             = 'view';
$lang->resource->problem->viewGroup        = 'viewGroup';
$lang->resource->problem->complete         = 'complete';
$lang->resource->problem->search           = 'search';

$lang->problem->methodOrder[0]   = 'index';
$lang->problem->methodOrder[5]   = 'viewProblem';
$lang->problem->methodOrder[10]  = 'create';
$lang->problem->methodOrder[15]  = 'edit';
$lang->problem->methodOrder[20]  = 'delete';
$lang->problem->methodOrder[25]  = 'batchDelete';
$lang->problem->methodOrder[30]  = 'view';
$lang->problem->methodOrder[35]  = 'viewGroup';
$lang->problem->methodOrder[40]  = 'complete';
$lang->problem->methodOrder[45]  = 'search';

/* conclusion. */
$lang->resource->conclusion 					= new stdclass();

$lang->resource->conclusion->index     		= 'index';
$lang->resource->conclusion->viewConclusion = 'viewConclusion';
$lang->resource->conclusion->create    		= 'create';
$lang->resource->conclusion->edit    		= 'edit';
$lang->resource->conclusion->delete 		= 'delete';
$lang->resource->conclusion->view 			= 'view';
$lang->resource->conclusion->search         = 'search';

$lang->conclusion->methodOrder[0]  = 'index';
$lang->conclusion->methodOrder[5]  = 'viewConclusion';
$lang->conclusion->methodOrder[10] = 'create';
$lang->conclusion->methodOrder[15] = 'edit';
$lang->conclusion->methodOrder[25] = 'delete';
$lang->conclusion->methodOrder[30] = 'view';
$lang->conclusion->methodOrder[35] = 'search';

/* project. */
$lang->resource->project                        = new stdclass();

$lang->resource->project->index                 = 'index';
$lang->resource->project->viewProject           = 'viewProject';
$lang->resource->project->create                = 'create';
$lang->resource->project->edit                  = 'edit';
$lang->resource->project->delete                = 'delete';
$lang->resource->project->view                  = 'view';
$lang->resource->project->finish                = 'finish';
$lang->resource->project->search                = 'search';

$lang->project->methodOrder[0]  = 'index';
$lang->project->methodOrder[5]  = 'viewProject';
$lang->project->methodOrder[10] = 'create';
$lang->project->methodOrder[15] = 'edit';
$lang->project->methodOrder[20] = 'delete';
$lang->project->methodOrder[25] = 'view';
$lang->project->methodOrder[30] = 'finish';
$lang->project->methodOrder[35] = 'search';


/* achievement. */
$lang->resource->achievement 					= new stdclass();

$lang->resource->achievement->index     		= 'index';
$lang->resource->achievement->viewAchievement 	= 'viewAchievement';
$lang->resource->achievement->create    		= 'create';
$lang->resource->achievement->edit    			= 'edit';
$lang->resource->achievement->delete 			= 'delete';
$lang->resource->achievement->view 				= 'view';
$lang->resource->achievement->check             = 'check';
$lang->resource->achievement->search            = 'search';

$lang->achievement->methodOrder[0]  = 'index';
$lang->achievement->methodOrder[5]  = 'viewAchievement';
$lang->achievement->methodOrder[10] = 'create';
$lang->achievement->methodOrder[15] = 'edit';
$lang->achievement->methodOrder[25] = 'delete';
$lang->achievement->methodOrder[30] = 'view';
$lang->achievement->methodOrder[35] = 'check';
$lang->achievement->methodOrder[40] = 'search';

/* tutorial. */
$lang->resource->tutorial                       = new stdclass();

$lang->resource->tutorial->viewTutorialSystem = 'viewTutorialSystem';
$lang->resource->tutorial->viewStudentSystem = 'viewStudentSystem';
$lang->resource->tutorial->viewAllStudent = 'viewAllStudent';
$lang->resource->tutorial->viewAllTutor = 'viewAllTutor';
$lang->resource->tutorial->viewSomeStudent = 'viewSomeStudent';
$lang->resource->tutorial->saveStudents = 'saveStudents';
$lang->resource->tutorial->saveTeachers = 'saveTeachers';
$lang->resource->tutorial->search = 'search';

$lang->tutorial->methodOrder[0] = 'viewTutorialSystem';
$lang->tutorial->methodOrder[5] = 'viewStudentSystem';
$lang->tutorial->methodOrder[10] = 'viewAllTutor';
$lang->tutorial->methodOrder[15] = 'viewAllStudent';
$lang->tutorial->methodOrder[20] = 'viewSomeStudent';
$lang->tutorial->methodOrder[25] = 'saveStudents';
$lang->tutorial->methodOrder[30] = 'saveTeachers';
$lang->tutorial->methodOrder[35] = 'search';


/* notice. */
$lang->resource->notice = new stdclass();
$lang->resource->notice->dynamic 	= 'dynamic';
$lang->resource->notice->viewNotice = 'viewNotice';
$lang->resource->notice->create 	= 'create';
$lang->resource->notice->view 		= 'view';
$lang->resource->notice->delete 	= 'delete';
$lang->resource->notice->search 	= 'search';

$lang->notice->methodOrder[5] 	= 'dynamic';
$lang->notice->methodOrder[10] = 'viewNotice';
$lang->notice->methodOrder[15] = 'create';
$lang->notice->methodOrder[20] = 'view';
$lang->notice->methodOrder[25] = 'delete';
$lang->notice->methodOrder[30] = 'search';

/* tutor. */
$lang->resource->tutor = new stdclass();
$lang->resource->tutor->index          = 'index';
$lang->resource->tutor->viewBasicInformation           = 'viewBasicInformation';
$lang->resource->tutor->viewProject         = 'viewProject';
$lang->resource->tutor->viewStudent         = 'viewStudent';
$lang->resource->tutor->Sharing           = 'sharing';
$lang->resource->tutor->viewStudentDetails = 'viewStudentDetails';
$lang->resource->tutor->viewProjectDetail = 'viewProjectDetail';
$lang->resource->tutor->viewMoreTask      = 'viewMoreTask';
$lang->resource->tutor->viewMoreAchievement = 'viewMoreAchievement';
$lang->resource->tutor->viewMoreProblem     = 'viewMoreProblem';
$lang->resource->tutor->search       = 'search';

$lang->tutor->methodOrder[0]   = 'index';
$lang->tutor->methodOrder[5]   = 'viewBasicInformation';
$lang->tutor->methodOrder[10]  = 'viewProject';
$lang->tutor->methodOrder[15]  = 'viewStudent';
$lang->tutor->methodOrder[20]  = 'sharing';
$lang->tutor->methodOrder[25]  = 'viewStudentDetails';
$lang->tutor->methodOrder[30]  = 'viewProjectDetail';
$lang->tutor->methodOrder[35]  = 'viewMoreTask';
$lang->tutor->methodOrder[40]  = 'viewMoreAchievement';
$lang->tutor->methodOrder[45]  = 'viewMoreProblem';
$lang->tutor->methodOrder[50]  = 'search';

/* student. */
$lang->resource->student = new stdclass();
$lang->resource->student->index            	= 'index';
$lang->resource->student->viewAll           = 'viewAll';
$lang->resource->student->viewUndergraduate = 'viewUndergraduate';
$lang->resource->student->viewGraduate      = 'viewGraduate';
$lang->resource->student->viewPostgraduate  = 'viewPostgraduate';
$lang->resource->student->viewstudentdetails= 'viewstudentdetails';
$lang->resource->student->viewMoreTask      = 'viewMoreTask';
$lang->resource->student->viewMoreAchievement = 'viewMoreAchievement';
$lang->resource->student->viewMoreProblem     = 'viewMoreProblem';
$lang->resource->student->search = 'search';

$lang->student->methodOrder[0]  = 'index';
$lang->student->methodOrder[5]  = 'viewAll';
$lang->student->methodOrder[10]  = 'viewUndergraduate';
$lang->student->methodOrder[15] = 'viewGraduate';
$lang->student->methodOrder[20] = 'viewPostgraduate';
$lang->student->methodOrder[25] = 'viewstudentdetails';
$lang->student->methodOrder[35]  = 'viewMoreTask';
$lang->student->methodOrder[40]  = 'viewMoreAchievement';
$lang->student->methodOrder[45]  = 'viewMoreProblem';
$lang->student->methodOrder[50]  = 'search';

/* statistics. */
$lang->resource->statistics = new stdclass();

$lang->resource->statistics->index         		= 'index';
$lang->resource->statistics->viewGraduationThesis 	= 'viewGraduationThesis';
$lang->resource->statistics->viewDetails      		= 'viewDetails';
$lang->resource->statistics->exportIndex      		= 'exportIndex';
$lang->resource->statistics->exportDetails      		= 'exportDetails';
$lang->resource->statistics->exportThesises     		= 'exportThesises';

$lang->statistics->methodOrder[0]  = 'index';
$lang->statistics->methodOrder[5]  = 'viewGraduationThesis';
$lang->statistics->methodOrder[10] = 'viewDetails';
$lang->statistics->methodOrder[15] = 'exportIndex';
$lang->statistics->methodOrder[20] = 'exportDetails';
$lang->statistics->methodOrder[20] = 'exportThesises';


/* resources. */
$lang->resource->resources = new stdclass();

$lang->resource->resources->index              = 'index';
$lang->resource->resources->viewTeachers	   = 'viewTeachers';
$lang->resource->resources->Sharing            = 'sharing';
$lang->resource->resources->viewteacherdetails = 'viewteacherdetails';
$lang->resource->resources->viewMoreAchievement= 'viewMoreAchievement';
$lang->resource->resources->viewMoreTask       = 'viewMoreTask';
$lang->resource->resources->viewMoreProblem    = 'viewMoreProblem';
$lang->resource->resources->viewMoreProject    = 'viewMoreProject';
$lang->resource->resources->viewMoreStudent    = 'viewMoreStudent';
$lang->resource->resources->search    = 'search';

$lang->resources->methodOrder[0]  = 'index';
$lang->resources->methodOrder[5]  = 'viewTeachers'; 
$lang->resources->methodOrder[10] = 'sharing';
$lang->resources->methodOrder[15] = 'viewteacherdetails';
$lang->resources->methodOrder[20] = 'viewMoreAchievement';
$lang->resources->methodOrder[25] = 'viewMoreProblem';
$lang->resources->methodOrder[30] = 'viewMoreTask';
$lang->resources->methodOrder[35] = 'viewMoreProject';
$lang->resources->methodOrder[40] = 'viewMoreStudent';
$lang->resources->methodOrder[45] = 'search';
//@Green delete

/* personalinfo. */
$lang->resource->personalinfo = new stdclass();

$lang->resource->personalinfo->index     				= 'index';
$lang->resource->personalinfo->viewBasicInformation    	= 'viewBasicInformation';
$lang->resource->personalinfo->changePassword 			= 'changePassword';
$lang->resource->personalinfo->editBasicInformation   	= 'editBasicInformation';

$lang->personalinfo->methodOrder[0]  = 'index';
$lang->personalinfo->methodOrder[5]  = 'viewBasicInformation';
$lang->personalinfo->methodOrder[10] = 'changePassword';
$lang->personalinfo->methodOrder[15] = 'editBasicInformation';

/* file. */
$lang->resource->file = new stdclass();
$lang->resource->file->download   = 'download';
$lang->resource->file->edit       = 'edit';
$lang->resource->file->delete     = 'delete';

$lang->file->methodOrder[5]  = 'download';
$lang->file->methodOrder[10] = 'edit';
$lang->file->methodOrder[15] = 'delete';

/* Company. */
$lang->resource->company = new stdclass();

$lang->resource->company->index  = 'index';
//$lang->resource->company->setUser = 'setUser';


$lang->company->methodOrder[0]  = 'index';
//$lang->company->methodOrder[5]  = 'setUser';


/* system. */
$lang->resource->system = new stdclass();

$lang->resource->system->index            	= 'index';
$lang->resource->system->setBasicsystem 	= 'setBasicsystem';
$lang->resource->system->setBackup      	= 'setBackup';
$lang->resource->system->log  				= 'log';
$lang->resource->system->mail  				= 'mail';
$lang->resource->system->error404  			= 'error404';

$lang->system->methodOrder[0]  = 'index';
$lang->system->methodOrder[5]  = 'setBasicsystem';
$lang->system->methodOrder[10] = 'setBackup';
$lang->system->methodOrder[15] = 'log';
$lang->system->methodOrder[20] = 'mail';
$lang->system->methodOrder[25] = 'error404';

/* mail. */
$lang->resource->mail = new stdclass();

$lang->resource->mail->index = 'index';
$lang->resource->mail->detect = 'detect';
$lang->resource->mail->edit = 'edit';
$lang->resource->mail->save = 'save';
$lang->resource->mail->test = 'test';
$lang->resource->mail->reset = 'reset';

$lang->mail->methodOrder[0] = 'index';
$lang->mail->methodOrder[5] = 'detect';
$lang->mail->methodOrder[10] = 'edit';
$lang->mail->methodOrder[15] = 'save';
$lang->mail->methodOrder[20] = 'test';
$lang->mail->methodOrder[25] = 'reset';

/* Group. */
$lang->resource->group = new stdclass();
$lang->resource->group->browse       = 'browse';
$lang->resource->group->create       = 'create';
$lang->resource->group->edit         = 'edit';
//$lang->resource->group->copy         = 'copy';
$lang->resource->group->delete       = 'delete';
$lang->resource->group->managePriv   = 'managePriv';
$lang->resource->group->manageMember = 'manageMember';

$lang->group->methodOrder[5]  = 'browse';
$lang->group->methodOrder[10] = 'create';
$lang->group->methodOrder[15] = 'edit';
//$lang->group->methodOrder[20] = 'copy';
$lang->group->methodOrder[25] = 'delete';
$lang->group->methodOrder[30] = 'managePriv';
$lang->group->methodOrder[35] = 'manageMember';

/* User. */
$lang->resource->user = new stdclass();
$lang->resource->user->index = 'index';
$lang->resource->user->create         = 'create';
$lang->resource->user->batchCreate    = 'batchCreate';
$lang->resource->user->view           = 'view';
$lang->resource->user->edit           = 'edit';
//$lang->resource->user->unlock         = 'unlock';
$lang->resource->user->delete         = 'delete';
//$lang->resource->user->todo           = 'todo';
//$lang->resource->user->story          = 'story';
//$lang->resource->user->task           = 'task';
//$lang->resource->user->resources            = 'resources';
//$lang->resource->user->testTask       = 'testTask';
//$lang->resource->user->project        = 'project';
$lang->resource->user->dynamic        = 'dynamic';
$lang->resource->user->profile        = 'profile';
$lang->resource->user->batchEdit      = 'batchEdit';
$lang->resource->user->search           = 'search';
//$lang->resource->user->manageContacts = 'manageContacts';
//$lang->resource->user->deleteContacts = 'deleteContacts';
$lang->user->methodOrder[0]  = 'index';
$lang->user->methodOrder[5]  = 'create';
$lang->user->methodOrder[7]  = 'batchCreate';
$lang->user->methodOrder[10] = 'view';
$lang->user->methodOrder[15] = 'edit';
//$lang->user->methodOrder[20] = 'unlock';
$lang->user->methodOrder[25] = 'delete';
//$lang->user->methodOrder[30] = 'todo';
//$lang->user->methodOrder[35] = 'task';
//$lang->user->methodOrder[40] = 'resources';
//$lang->user->methodOrder[45] = 'project';
$lang->user->methodOrder[50] = 'dynamic';
$lang->user->methodOrder[55] = 'profile';
$lang->user->methodOrder[60] = 'batchEdit';
$lang->user->methodOrder[65] = 'search';
//$lang->user->methodOrder[65] = 'manageContacts';
//$lang->user->methodOrder[70] = 'deleteContacts';

// /* Tree. */
// $lang->resource->tree = new stdclass();
// $lang->resource->tree->browse      = 'browse';
// $lang->resource->tree->browseTask  = 'browseTask';
// $lang->resource->tree->updateOrder = 'updateOrder';
// $lang->resource->tree->manageChild = 'manageChild';
// $lang->resource->tree->edit        = 'edit';
// $lang->resource->tree->fix         = 'fix';
// $lang->resource->tree->delete      = 'delete';

// $lang->tree->methodOrder[5]  = 'browse';
// $lang->tree->methodOrder[10] = 'browseTask';
// $lang->tree->methodOrder[15] = 'updateOrder';
// $lang->tree->methodOrder[20] = 'manageChild';
// $lang->tree->methodOrder[25] = 'edit';
// $lang->tree->methodOrder[30] = 'delete';

// /* Search. */
// $lang->resource->search = new stdclass();
// $lang->resource->search->buildForm    = 'buildForm';
// $lang->resource->search->buildQuery   = 'buildQuery';
// $lang->resource->search->saveQuery    = 'saveQuery';
// $lang->resource->search->deleteQuery  = 'deleteQuery';
// $lang->resource->search->select       = 'select';

// $lang->search->methodOrder[5]  = 'buildForm';
// $lang->search->methodOrder[10] = 'buildQuery';
// $lang->search->methodOrder[15] = 'saveQuery';
// $lang->search->methodOrder[20] = 'deleteQuery';
// $lang->search->methodOrder[25] = 'select';

// /* Editor. */
// $lang->resource->editor = new stdclass();
// $lang->resource->editor->index   = 'index';
// $lang->resource->editor->extend  = 'extend';
// $lang->resource->editor->edit    = 'edit';
// $lang->resource->editor->newPage = 'newPage';
// $lang->resource->editor->save    = 'save';
// $lang->resource->editor->delete  = 'delete';

// $lang->editor->methodOrder[5]  = 'index';
// $lang->editor->methodOrder[10] = 'extend';
// $lang->editor->methodOrder[15] = 'edit';
// $lang->editor->methodOrder[20] = 'newPage';
// $lang->editor->methodOrder[25] = 'save';
// $lang->editor->methodOrder[30] = 'delete';

/* Others. */
$lang->resource->action = new stdclass();
$lang->resource->action->trash    = 'trash';
$lang->resource->action->undelete = 'undelete';
$lang->resource->action->hideOne  = 'hideOne';
$lang->resource->action->hideAll  = 'hideAll';
$lang->resource->action->editComment = 'editComment';

$lang->action->methodOrder[5]  = 'trash';
$lang->action->methodOrder[10] = 'undelete';
$lang->action->methodOrder[15] = 'hideOne';
$lang->action->methodOrder[20] = 'hideAll';