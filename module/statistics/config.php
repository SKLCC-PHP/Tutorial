<?php
$config->statistics = new stdclass();

$config->statistics->list->index->exportFields = 'account, realname, TaskNumber, ProblemNumber, ProjectNumber, AchievementNumber, ConclusionNumber';
$config->statistics->list->details->task->exportFields = 'account, realname, AcceptNumber_sum, AcceptNumber_public, AcceptNumber_protected, AcceptNumber_private, CompleteNumber_sum, CompleteNumber_undelayed, CompleteNumber_delayed, UncompleteNumber';
$config->statistics->list->details->problem->exportFields = 'account, realname, AskNumber_sum, AskNumber_public, AskNumber_protected, AskNumber_private, AnsweredNumber, UnansweredNumber';
$config->statistics->list->details->project->exportFields = 'account, realname, Number_sum, Number_public, Number_protected, Number_private, UnderwayNumber, FinishedNumber';
$config->statistics->list->details->achievement->exportFields = 'account, realname, TotalNumber, ThesisNumber, CopyrightNumber, PatentNumber, ResearchNumber, AwardsNumber';
$config->statistics->list->details->conclusion->exportFields = 'account, realname, TotalNumber, AssessedNumber, UnassessedNumber';
$config->statistics->list->thesis->exportFields = 'id, creator, title, tea_name, othername, createtime, updatetime';
//@Green
?>