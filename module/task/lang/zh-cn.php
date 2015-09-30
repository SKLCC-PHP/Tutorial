<?php
/*属性*/
$lang->task->index              = "首页";
$lang->task->viewTask           = "任务一览";
$lang->task->common     		= '任务';
$lang->task->editsubmit         = "修改上交作业";
$lang->task->search             = "搜索";
$lang->task->basicInfo          = "基本信息";
$lang->task->title             	= "任务名称";
$lang->task->create_time       	= "创建时间";
$lang->task->deadline        	= "截止时间";
$lang->task->dateRange          = "起止日期";
$lang->task->complete_time      = "完成时间";
$lang->task->begin_time      	= "开始时间";
$lang->task->submit_time      	= "提交时间";
$lang->task->assess_time      	= "批阅时间";
$lang->task->readtime           = "阅读时间";
$lang->task->to                 = "至";
$lang->task->days               = "天数";
$lang->task->day                = "天";
$lang->task->creator      		= "创建者";
$lang->task->receiver      		= "接受者";
$lang->task->receiverNum        = "接受人数";
$lang->task->is_assessed      	= "是否批阅";
$lang->task->is_completed      	= "是否完成";
$lang->task->is_submitted       = "是否提交";
$lang->task->mailto      		= "抄送";
$lang->task->fileUp             = "附件上传";
$lang->task->subfile            = "附属材料";
$lang->task->teachertask        = "导师任务";
$lang->task->studentsubmit      = "学生上交";
$lang->task->tea_assess         = "导师批阅评语";

/*操作*/
$lang->task->assignedTo        	= "指派给";
$lang->task->content        	= "内容";
$lang->task->create        		= "新增";
$lang->task->delete 			= "删除";
$lang->task->batchDelete        = "批量删除";
$lang->task->assess        		= "批阅";
$lang->task->edit        		= "修改";
$lang->task->batchedit			= "批量修改";
$lang->task->finish      		= "完成";
$lang->task->submit      		= "提交";
$lang->task->view      			= "查看";
$lang->task->viewGroup          = "查看小组任务";
$lang->task->confirmFinish		= "您确定该任务已完成吗？";
$lang->task->confirmDelete		= "您确定删除该任务吗？";
$lang->task->cannotdelete		= "任务处于进行中，无法删除。";
$lang->task->can_not_submit		= "任务还没开始或者已经完成，无法提交！";
$lang->task->can_not_assess		= "任务还没开始或者已经完成，无法批阅！";
$lang->task->can_not_edit		= "只有任务还没开始的时候才能修改！";
$lang->task->unsubmit			= "学生还未提交过，无法批阅！";
$lang->task->noImportantInformation           = "必填信息没有填写完整！";
$lang->task->nosubmit           = "提交不能为空";
$lang->task->createsucceed           = "任务指派成功！";
$lang->task->editsucceed           = "任务修改成功！";
$lang->task->assesssucceed           = "任务批阅完成！";
$lang->task->deletesucceed           = "任务删除成功！";
$lang->task->finishsucceed           = "任务完成了！";
$lang->task->submitsucceed           = "提交成功！";

$lang->task->assessList['unassessed'] 		= '未批阅';
$lang->task->assessList['assessed'] 		= '已批阅';
$lang->task->assessList[0]                  = '未批阅';
$lang->task->assessList[1]                  = '已批阅';

$lang->task->completeList['undone'] 		= '未完成';
$lang->task->completeList['done'] 			= '已完成';
$lang->task->completeList[0]                = '未完成';
$lang->task->completeList[1]                = '已完成';

$lang->task->submitList[0]                  = '未提交';
$lang->task->submitList[1]                  = '已提交';

/*set the mail of the task*/
$lang->task->mail = new stdclass();

$lang->task->mail->subject 		= '新任务';
$lang->task->mail->body 		= '%s老师又布置新任务啦！快去看看吧：%s';
$lang->task->mail->editsubject  = '任务修改';
$lang->task->mail->editbody     = '%s老师修改了任务！快去看看吧：%s';
$lang->task->mail->subsubject   = '任务提交';
$lang->task->mail->subbody      = '%s同学提交了任务！快去看看吧：%s';
$lang->task->mail->editsubsubject   = '提交修改';
$lang->task->mail->editsubbody      = '%s同学修改了提交的内容！快去看看吧：%s';