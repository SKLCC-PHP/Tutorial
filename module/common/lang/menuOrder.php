<?php
/* Sort of main menu. */
$lang->menuOrder[5]  = 'my';
$lang->menuOrder[10] = 'workspace';
$lang->menuOrder[15] = 'tutor';
$lang->menuOrder[20] = 'student';
$lang->menuOrder[25] = 'statistics';
$lang->menuOrder[30] = 'resources';
$lang->menuOrder[35] = 'personalinfo';
$lang->menuOrder[40] = 'company';
$lang->menuOrder[45] = 'system';

/* index menu order. */
$lang->index->menuOrder[5]  = 'product';
$lang->index->menuOrder[10] = 'project';

/* my menu order. */
$lang->my->menuOrder[5]  = 'account';
$lang->my->menuOrder[10] = 'index';
$lang->my->menuOrder[15] = 'todo';
$lang->my->menuOrder[20] = 'task';
$lang->my->menuOrder[25] = 'resources';
$lang->my->menuOrder[35] = 'story';
$lang->my->menuOrder[40] = 'project';
$lang->my->menuOrder[45] = 'dynamic';
$lang->my->menuOrder[50] = 'profile';
$lang->my->menuOrder[55] = 'changePassword';
$lang->todo->menuOrder   = $lang->my->menuOrder;

/* workspace menu order. */
$lang->workspace->menuOrder[5]  = 'task';
$lang->workspace->menuOrder[10] = 'problem';
$lang->workspace->menuOrder[20] = 'MyCalendar';;
$lang->workspace->menuOrder[30] = 'achievement';
$lang->workspace->menuOrder[35] = 'project';
$lang->workspace->menuOrder[45] = 'conclusion';
$lang->workspace->menuOrder[50] = 'tutorial';
$lang->workspace->menuOrder[55] = 'notice';
$lang->MyCalendar->menuOrder       = $lang->workspace->menuOrder;
$lang->problem->menuOrder     = $lang->workspace->menuOrder;
$lang->task->menuOrder     = $lang->workspace->menuOrder;
$lang->project->menuOrder     = $lang->workspace->menuOrder;
$lang->achievement->menuOrder     = $lang->workspace->menuOrder;
$lang->conclusion->menuOrder     = $lang->workspace->menuOrder;
$lang->tutorial->menuOrder    = $lang->workspace->menuOrder;
$lang->notice->menuOrder    = $lang->workspace->menuOrder;

/* tutor menu order. */
$lang->tutor->menuOrder[5]  = 'basicInformation';
$lang->tutor->menuOrder[10] = 'project';
$lang->tutor->menuOrder[15] = 'student';
$lang->tutor->menuOrder[20] = 'sharing';

/* student menu order. */
$lang->student->menuOrder[5]  = 'viewAll';
$lang->student->menuOrder[10]  = 'viewUndergraduate';
$lang->student->menuOrder[15] = 'viewGraduate';
$lang->student->menuOrder[20] = 'viewPostgraduate';

/* statistics menu order. */
$lang->statistics->menuOrder[5]  = 'index';
$lang->statistics->menuOrder[15] = 'details';
$lang->statistics->menuOrder[20] = 'others';

/* resources menu order. */
$lang->resources->menuOrder[5]  = 'teachers';
$lang->resources->menuOrder[10]  = 'sharing';

/* personalinfo menu order. */
$lang->personalinfo->menuOrder[5]  = 'basicInformation';
$lang->personalinfo->menuOrder[20] = 'password';


/* company menu order. */
$lang->company->menuOrder[0]  = 'name';
$lang->company->menuOrder[5]  = 'user';
$lang->company->menuOrder[10] = 'browseGroup';
$lang->company->menuOrder[20] = 'edit';
$lang->company->menuOrder[30] = 'addGroup';
$lang->company->menuOrder[35] = 'batchAddUser';
$lang->company->menuOrder[40] = 'addUser';
$lang->group->menuOrder       = $lang->company->menuOrder;
$lang->user->menuOrder        = $lang->company->menuOrder;

/* system menu order. */
$lang->system->menuOrder[0]  	= 'index';
$lang->system->menuOrder[5] 	= 'basicsystem';
$lang->system->menuOrder[10] 	= 'backup';
$lang->system->menuOrder[15] 	= 'log';
$lang->system->menuOrder[15] 	= 'mail';
$lang->mail->menuOrder = $lang->system->menuOrder;