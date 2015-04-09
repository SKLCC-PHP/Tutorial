<?php
/*属性*/
$lang->achievement->index              = "首页";
$lang->achievement->viewAchievement    = "成果";
$lang->achievement->common     		   = '成果';

$lang->achievement->title             	= "成果名称";
$lang->achievement->create_time       	= "上传时间";
$lang->achievement->creator      		= "创建者";
$lang->achievement->other_name      	= '其他成员';
$lang->achievement->update_time       	= "修改时间";
$lang->achievement->checktime           = "审核时间";
$lang->achievement->type       			= "类型";
$lang->achievement->tea_ID       		= "指导老师";
$lang->achievement->ischecked       	= "审核状态";
$lang->achievement->comment             = "评论";
$lang->achievement->search              = "搜索";

$lang->achievement->createsucceed           = "成果新增成功！";
$lang->achievement->editsucceed           = "成果修改成功！";
$lang->achievement->deletesucceed           = "成果删除成功！";
$lang->achievement->checksucceed           = "成果通过成功！";
/*操作*/
$lang->achievement->check           = "审核";
$lang->achievement->description     = "简述";
$lang->achievement->create        	= "新增";
$lang->achievement->delete 			= "删除";
$lang->achievement->edit        	= "修改";
$lang->achievement->view      		= "查看";
$lang->achievement->confirmDelete	= "您确定删除该成果吗？";
$lang->achievement->noImportantInformation = "必填项没有填写完整";


$lang->achievement->checkList[1] = '通过';
$lang->achievement->checkList[-1] = '未通过';

$lang->achievement->checkedList['1'] 		= '审核通过';
$lang->achievement->checkedList['0'] 		= '审核中';
$lang->achievement->checkedList['-1'] 		= '审核未通过';

$lang->achievement->typeList['thesis'] 		= '论文';
$lang->achievement->typeList['copyright'] 	= '著作权';
$lang->achievement->typeList['patent'] 		= '专利';
$lang->achievement->typeList['research'] 		= '调查报告';
$lang->achievement->typeList['awards'] 		= '奖学金';

$lang->achievement->placeholder = new stdclass();
$lang->achievement->placeholder->other_name = '填写其他合作成员，以"，"分隔';

$lang->achievement->thesis      	= new stdclass();
$lang->achievement->thesis->title 		= '论文标题';
$lang->achievement->thesis->author 		= '论文作者';
$lang->achievement->thesis->members 	= '论文合作者';
$lang->achievement->thesis->summary 	= '导师共指导论文<strong>%s</strong>篇。';