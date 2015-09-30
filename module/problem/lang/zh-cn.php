<?php
$lang->problem->common              = '提问';
$lang->problem->viewProblem         = '问题';
$lang->problem->index               = '提问首页';
$lang->problem->viewProblem         = '问题列表';
$lang->problem->detail              = '问题详细';
$lang->problem->complete            = '问题完成';
$lang->problem->search              = "搜索";
$lang->problem->basicInfo          	= "基本信息";
$lang->problem->anwserInfo			= "解答状况";

$lang->problem->title             	= "问题标题";
$lang->problem->createtime       	= "提问时间";
$lang->problem->answertime       	= "解答时间";
$lang->problem->readaccount         = "浏览人数";
$lang->problem->readtime            = "查看时间";
$lang->problem->solvetime           = "解答时间";
$lang->problem->completetime        = "完成时间";
$lang->problem->authority           = "权限";

$lang->problem->creator      		= "提问人";
$lang->problem->receiver            = "接受者";
$lang->problem->receiverNum         = "接受数量";
$lang->problem->solvepeople         = "解决人";
$lang->problem->teachers      		= "导师";
$lang->problem->isSolved 	     	= "是否解答";
$lang->problem->isRead 		     	= "是否阅读";
$lang->problem->stu_files           = "学生附件";
$lang->problem->other_solution      = "解答交流";

$lang->problem->solID      		    = "回答者";

$lang->problem->comment 			= "评论";
$lang->problem->modify				= "修改";

$lang->problem->content        		= "内容";
$lang->problem->create        		= "我要提问";
$lang->problem->delete 				= "删除";
$lang->problem->batchDelete         = "批量删除";
$lang->problem->comment        		= "评论";
$lang->problem->edit        		= "编辑";

$lang->problem->view      			= "查看";
$lang->problem->viewGroup           = "查看组问题";
$lang->problem->confirmDelete		= "您确定删除该问题吗？";
$lang->problem->confirmComplete     = "您确定问题结束？";
$lang->problem->noImportantInformation           = "必填项没有填写完整";
$lang->problem->createsucceed           = "提问成功！";
$lang->problem->editsucceed           = "问题修改成功！";
$lang->problem->deletesucceed           = "问题删除成功！";
$lang->problem->completesucceed           = "提问已经解答好了！";

$lang->problem->solveStatusList[0]  = "未解决";
$lang->problem->solveStatusList[1]  = "已解决";

$lang->problem->readStatusList[0]   = "未读";
$lang->problem->readStatusList[1]   = "已读";

$lang->problem->problemTitle		= "问题名称";

/*set the mail of the problem*/
$lang->problem->mail = new stdclass();

$lang->problem->mail->subject 		= '新提问';
$lang->problem->mail->body 		= '%s同学又提出问题了，真是好学呢！快去看看吧：%s';
$lang->problem->mail->editsubject  = '问题修改';
$lang->problem->mail->editbody     = '%s同学修改了问题！快去看看吧：%s';
$lang->problem->mail->answersubject   = '问题解答';
$lang->problem->mail->answerbody      = '%s有人解答了问题！快去看看吧：%s';