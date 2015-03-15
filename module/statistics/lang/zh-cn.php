<?php
$lang->statistics->common  				= '统计信息';
$lang->statistics->index   				= '一览';
$lang->statistics->id   				= '序号';
$lang->statistics->export   			= '导出数据';
$lang->statistics->viewGraduationThesis = '毕业论文';
$lang->statistics->viewDetails 			= '详细';
$lang->statistics->exportIndex 			= '导出一览';
$lang->statistics->exportDetails 		= '导出详细';
$lang->statistics->exportThesises 		= '导出论文';
$lang->statistics->confirmExport 		= '你确定要导出这些数据吗？';
$lang->statistics->account['student']	= '学号';
$lang->statistics->account['teacher']	= '用户名';
$lang->statistics->realname['student']	= '学生姓名';
$lang->statistics->realname['teacher']	= '老师姓名';

$lang->statistics->browse = new stdclass();

$lang->statistics->browse->common   				= '一览';

$lang->statistics->browse->AchievementNumber['student']	= '成果数';
$lang->statistics->browse->AchievementNumber['teacher']	= '成果数';
$lang->statistics->browse->ProjectNumber['student']	= '课题项目数';
$lang->statistics->browse->ProjectNumber['teacher']	= '课题项目数';
$lang->statistics->browse->TaskNumber['student']	= '接受任务数';
$lang->statistics->browse->TaskNumber['teacher']	= '安排任务数';
$lang->statistics->browse->ProblemNumber['student']	= '提问数';
$lang->statistics->browse->ProblemNumber['teacher']	= '解答问题数';
$lang->statistics->browse->ConclusionNumber['student']	= '学习小结数';
$lang->statistics->browse->ConclusionNumber['teacher']	= '批阅小结数';

$lang->statistics->details = new stdclass();

$lang->statistics->details->common = '详细';

$lang->statistics->details->task = new stdclass();

$lang->statistics->details->task->AcceptNumber['student'] 				= '接受任务数';
$lang->statistics->details->task->AcceptNumber['teacher'] 				= '安排任务数';
$lang->statistics->details->task->AcceptNumber_sum['student'] 			= '接受任务总数';
$lang->statistics->details->task->AcceptNumber_sum['teacher'] 			= '安排任务总数';
$lang->statistics->details->task->AcceptNumber_public['student'] 		= '接受公开任务数';
$lang->statistics->details->task->AcceptNumber_public['teacher'] 		= '安排公开任务数';
$lang->statistics->details->task->AcceptNumber_protected['student'] 	= '接受同组任务数';
$lang->statistics->details->task->AcceptNumber_protected['teacher']		= '安排同组任务数';
$lang->statistics->details->task->AcceptNumber_private['student'] 		= '接受私有任务数';
$lang->statistics->details->task->AcceptNumber_private['teacher'] 		= '安排私有任务数';
$lang->statistics->details->task->CompleteNumber_sum['student'] 		= '完成任务总数';
$lang->statistics->details->task->CompleteNumber_sum['teacher'] 		= '完成任务总数';
$lang->statistics->details->task->CompleteNumber_undelayed['student'] 	= '按时完成任务数';
$lang->statistics->details->task->CompleteNumber_undelayed['teacher'] 	= '按时完成任务数';
$lang->statistics->details->task->CompleteNumber_delayed['student'] 	= '超时完成任务数';
$lang->statistics->details->task->CompleteNumber_delayed['teacher'] 	= '超时完成任务数';
$lang->statistics->details->task->CompleteNumber['student'] 			= '已完成任务数';
$lang->statistics->details->task->CompleteNumber['teacher'] 			= '学生已完成任务数';
$lang->statistics->details->task->UncompleteNumber['student'] 			= '未完成任务数';
$lang->statistics->details->task->UncompleteNumber['teacher'] 			= '学生未完成任务数';

$lang->statistics->details->problem = new stdclass();

$lang->statistics->details->problem->AskNumber['student'] 				= '提问数';
$lang->statistics->details->problem->AskNumber['teacher'] 				= '学生提问数';
$lang->statistics->details->problem->AskNumber_sum['student'] 			= '提问总数';
$lang->statistics->details->problem->AskNumber_sum['teacher'] 			= '学生提问总数';
$lang->statistics->details->problem->AskNumber_public['student'] 		= '公开问题数';
$lang->statistics->details->problem->AskNumber_public['teacher'] 		= '公开问题数';
$lang->statistics->details->problem->AskNumber_protected['student'] 	= '同组问题数';
$lang->statistics->details->problem->AskNumber_protected['teacher']		= '同组问题数';
$lang->statistics->details->problem->AskNumber_private['student'] 		= '私有问题数';
$lang->statistics->details->problem->AskNumber_private['teacher'] 		= '私有问题数';
$lang->statistics->details->problem->AnsweredNumber['student'] 			= '已解答数';
$lang->statistics->details->problem->AnsweredNumber['teacher'] 			= '已解答数';
$lang->statistics->details->problem->UnansweredNumber['student'] 		= '未解答数';
$lang->statistics->details->problem->UnansweredNumber['teacher'] 		= '未解答数';

$lang->statistics->details->project = new stdclass();

$lang->statistics->details->project->Number 				= '课题项目数';
$lang->statistics->details->project->Number_sum 			= '课题项目总数';
$lang->statistics->details->project->Number_public 			= '公开项目数';
$lang->statistics->details->project->Number_protected		= '同组项目数';
$lang->statistics->details->project->Number_private 		= '私有项目数';
$lang->statistics->details->project->UnderwayNumber 		= '正在开展项目数';
$lang->statistics->details->project->FinishedNumber 		= '已经结束项目数';

$lang->statistics->details->achievement = new stdclass();

$lang->statistics->details->achievement->TotalNumber = '成果总数';
$lang->statistics->details->achievement->ThesisNumber = '论文数';
$lang->statistics->details->achievement->CopyrightNumber = '著作权数';
$lang->statistics->details->achievement->PatentNumber = '专利数';
$lang->statistics->details->achievement->ResearchNumber = '调查报告数';
$lang->statistics->details->achievement->AwardsNumber = '奖励数';

$lang->statistics->details->conclusion = new stdclass();

$lang->statistics->details->conclusion->TotalNumber = '小结总数';
$lang->statistics->details->conclusion->AssessedNumber = '已批阅数';
$lang->statistics->details->conclusion->UnassessedNumber = '未批阅数';

$lang->statistics->thesis = new stdclass();

$lang->statistics->thesis->id 			= 'ID';
$lang->statistics->thesis->creator 		= '论文作者';
$lang->statistics->thesis->title 		= '论文标题';
$lang->statistics->thesis->tea_name 	= '导师姓名';
$lang->statistics->thesis->othername 	= '论文合作者';
$lang->statistics->thesis->createtime 	= '上传日期';
$lang->statistics->thesis->updatetime 	= '修改日期';
?>