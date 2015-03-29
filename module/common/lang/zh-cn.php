<?php
/**
 * The common simplified chinese file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id: zh-cn.php 5116 2013-07-12 06:37:48Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->arrow     = '&nbsp;<i class="icon-angle-right"></i>&nbsp;';
$lang->obArrow   = '&nbsp;<i class="icon-angle-left"></i>&nbsp;';
$lang->colon     = '::';
$lang->comma     = '，';
$lang->dot       = '。';
$lang->at        = ' 于 ';
$lang->downArrow = '↓';
$lang->null      = '空';

$lang->systemName      = '苏州大学导师制管理平台';
$lang->welcome        = "苏州大学导师制管理平台";
$lang->myControl      = "我的地盘";
$lang->currentPos     = '当前位置：';
$lang->logout         = '退出';
$lang->login          = '登录';
$lang->findPassword   = '找回密码';
$lang->aboutZenTao    = '关于';
$lang->profile        = '个人档案';
$lang->changePassword = '更改密码';
$lang->runInfo        = "<div class='row'><div class='u-1 a-center' id='debugbar'>时间: %s 毫秒, 内存: %s KB, 查询: %s.  </div></div>";

$lang->reset        = '重填';
$lang->refresh      = '刷新';
$lang->edit         = '编辑';
$lang->copy         = '复制';
$lang->delete       = '删除';
$lang->close        = '关闭';
$lang->link         = '关联';
$lang->unlink       = '移除';
$lang->import       = '导入';
$lang->export       = '导出';
$lang->search       = '搜索';
$lang->setFileName  = '文件名：';
$lang->activate     = '激活';
$lang->submitting   = '稍候...';
$lang->save         = '保存';
$lang->confirm      = '确认';
$lang->preview      = '查看';
$lang->goback       = '返回';
$lang->goPC         = 'PC版';
$lang->go           = 'GO';
$lang->more         = '更多';
$lang->day          = '天';

$lang->actions      = '操作';
$lang->acl      	= '访问权限';
$lang->comment      = '评论';
$lang->commentBox   = '评论框';
$lang->history      = '历史记录';
$lang->basicInfo    = '基本信息';
$lang->attatch      = '附件';
$lang->reverse      = '切换顺序';
$lang->switchDisplay= '切换显示';
$lang->switchHelp   = '切换帮助';
$lang->addFiles     = '上传了附件 ';
$lang->files        = '附件 ';
$lang->timeout      = '连接超时，请检查网络环境，或重试！';
$lang->unfold       = '+';
$lang->fold         = '-';

$lang->selectAll     = '全选';
$lang->selectReverse = '反选';
$lang->notFound      = '抱歉，您访问的对象并不存在！';
$lang->showAll       = '[[全部显示]]';
$lang->hideClosed    = '[[显示进行中]]';

$lang->future       = '未来';
$lang->year         = '年';
$lang->workingHour  = '工时';

$lang->idAB         = 'ID';
$lang->priAB        = 'P';
$lang->statusAB     = '状态';
$lang->openedByAB   = '创建';
$lang->assignedToAB = '指派';
$lang->typeAB       = '类型';

$lang->common = new stdclass();
$lang->common->common = '公有模块';

// @Tony 一级菜单修改
/* 主导航菜单。*///Green 对一级菜单进行修改。
$lang->menu = new stdclass();
$lang->menu->my       			= '<i class="icon-home"></i><span> 首页</span>|my|index';
$lang->menu->workspace 			= '工作区|workspace|index';
$lang->menu->tutor 				= '我的导师|tutor|index';
$lang->menu->student			= '我的学生|student|index';
$lang->menu->resources 		 	= '广场资源|resources|index';
$lang->menu->company 			= '后台管理|company|index';
$lang->menu->statistics	 		= '统计信息|statistics|index';
$lang->menu->system 			= '系统设置|system|index';
$lang->menu->personalinfo 		= '个人信息|personalinfo|index';


/* 导入支持的编码格式。*/
$lang->importEncodeList['gbk']   = 'GBK';
$lang->importEncodeList['big5']  = 'BIG5';
$lang->importEncodeList['utf-8'] = 'UTF-8';

/* 导出文件的类型列表。*/
$lang->exportFileTypeList['xls']  = 'xls';
$lang->exportFileTypeList['csv']  = 'csv';
$lang->exportFileTypeList['xml']  = 'xml';
$lang->exportFileTypeList['html'] = 'html';

$lang->exportTypeList['all']      = '全部记录';
$lang->exportTypeList['selected'] = '选中记录';

/*可评论模块*/
$lang->commentList['problem'] 	 = 'Q';
$lang->commentList['task']		 = 'T';
$lang->commentList['conclusion'] = 'C';
$lang->commentList['project'] 	 = 'P';
$lang->commentList['achievement']= 'A';
$lang->commentList['assessTask'] = 'AT';

/*访问权限*/
$lang->aclList['1'] = '接受人员可见';
$lang->aclList['2'] = '同导师成员可见';
$lang->aclList['3'] = '所有人可见';

$lang->help = "使用帮助";
$lang->feedback = "建议反馈";
$lang->bugReport = "BUG报告" ;
$lang->systemMail = "iat.net.cn@gmail.com";

/* 风格列表。*/
$lang->theme                 = '风格主题';
$lang->themes['default']     = '默认';
$lang->themes['green']       = '绿色';
$lang->themes['red']         = '红色';
$lang->themes['lightblue']   = '亮蓝';
$lang->themes['blackberry']  = '黑莓';

// @Tony 首页二级菜单修改
/* 首页菜单设置。*/
$lang->index = new stdclass();
$lang->index->menu = new stdclass();

// $lang->index->menu->product = '浏览产品|product|browse';
// $lang->index->menu->project = '浏览项目|project|browse';

/* 我的地盘菜单设置。*/
$lang->my = new stdclass();
$lang->my->menu = new stdclass();

$lang->my->menu->account        = '<span id="myname"><i class="icon-user"></i> %s' . $lang->arrow . '</span>';

$lang->todo = new stdclass();
$lang->todo->menu = $lang->my->menu;

// @Tony 工作区二级菜单修改
/* 工作区菜单设置。*/
$lang->workspace = new stdclass();
$lang->workspace->menu = new stdclass();

$lang->workspace->menu->list    = '工作区>';
//$lang->workspace->menu->MyCalendar   = array('link' => '我的日程|workspace|MyCalendar', 'subModule' => 'MyCalendar');
$lang->workspace->menu->task = array('link' => '任务|workspace|task', 'subModule' => 'task' , 'alias' => 'create,edit,submit,assess,view,editsubmit');
$lang->workspace->menu->problem = array('link' => '提问|workspace|viewProblem',     'subModule' => 'problem','alias' => 'create,edit,submit,assess,view');
$lang->workspace->menu->achievement  = array('link' => '成果|workspace|viewAchievement',  'subModule' => 'achievement');
$lang->workspace->menu->project    = array('link' => '课题项目|workspace|viewProject', 'subModule' => 'project','alias' => 'viewProject');
$lang->workspace->menu->conclusion     = array('link' => '学习小结|workspace|viewConclusion', 'subModule' => 'conclusion','alias' => 'create,edit,view');
$lang->workspace->menu->tutorial  = array('link' => '导师制|workspace|viewTutorialSystem', 'subModule' => 'tutorial', 'alias' =>'create, edit, delete');
$lang->workspace->menu->notice  = array('link' => '通知|workspace|viewNotice', 'subModule' => 'notice', 'alias' =>'create, edit, delete');

$lang->task = new stdclass();
$lang->task->menu = $lang->workspace->menu;

$lang->conclusion = new stdclass();
$lang->conclusion->menu = $lang->workspace->menu;

$lang->achievement = new stdclass();
$lang->achievement->menu = $lang->workspace->menu;

$lang->project = new stdclass();
$lang->project->menu = $lang->workspace->menu;

$lang->tutorial = new stdclass();
$lang->tutorial->menu = $lang->workspace->menu;

$lang->problem = new stdclass();
$lang->problem->menu = $lang->workspace->menu;

$lang->notice = new stdclass();
$lang->notice->menu = $lang->workspace->menu;
// @Green 我的导师二级菜单修改
/* 我的导师菜单设置。*/
$lang->tutor = new stdclass();
$lang->tutor->menu = new stdclass();

$lang->tutor->menu->list  	 = '我的导师>';
$lang->tutor->menu->basicInformation = array('link' => '基本信息|tutor|viewBasicInformation','subModule' => 'viewBasicInformation');
$lang->tutor->menu->project = array('link' => '指导项目|tutor|viewProject','subModule' => 'viewProject');
$lang->tutor->menu->student = array('link' => '指导学生|tutor|viewStudent' , 'alias' => 'viewstudentdetails');
$lang->tutor->menu->sharing = array('link' => '资源共享|tutor|sharing','subModule' => 'sharing');


// @Green 我的学生二级菜单修改
/* 我的学生菜单设置。*/
$lang->student = new stdclass();
$lang->student->menu = new stdclass();

$lang->student->menu->list  	 = '我的学生>';
$lang->student->menu->allstudent = array('link' => '所有学生|student|viewAll');
$lang->student->menu->undergraduate = array('link' => '本科生|student|viewUndergraduate');
$lang->student->menu->graduate     = array('link' => '毕业生|student|viewGraduate');
$lang->student->menu->postgraduate    = array('link' => '研究生|student|viewPostgraduate');


// @Green 统计数据二级菜单修改
/* 后台管理菜单设置。*/
$lang->statistics = new stdclass();
$lang->statistics->menu = new stdclass();

$lang->statistics->menu->list      			= "统计信息>";
$lang->statistics->menu->index   = array('link' => '一览|statistics|index' );
$lang->statistics->menu->details 			= array('link' => '详细|statistics|viewDetails|viewtype=task' );
// $lang->statistics->menu->others 			= array('link' => '毕业论文|statistics|viewGraduationThesis|account=all' );

// @Tony 广场资源二级菜单修改
/* QA视图菜单设置。*/
$lang->resources = new stdclass();
$lang->resources->menu = new stdclass();

$lang->resources->menu->list  = '广场资源>';
$lang->resources->menu->teachers      = array('link' => '导师一览|resources|viewTeachers', 'subModule' => 'tree', 'alias' => 'viewteacherdetails');
$lang->resources->menu->sharing = array('link' => '共享资源|resources|sharing');

//@Green delete the menu
// @Tony 个人信息二级菜单修改
/* 个人信息菜单设置。*/
$lang->personalinfo = new stdclass();
$lang->personalinfo->menu = new stdclass();

$lang->personalinfo->menu->list    = '个人信息>';
$lang->personalinfo->menu->basicInformation  = array('link' => '基本信息|personalinfo|viewBasicInformation', 'subModule' => 'viewBasicInformation', 'alias' => 'editBasicInformation');
$lang->personalinfo->menu->password  = '密码修改|personalinfo|changePassword';


// @Tony 我的成果二级菜单修改
/* 组织结构视图菜单设置。*/
$lang->company = new stdclass();
$lang->company->menu = new stdclass();

$lang->company->menu->name         = '后台管理' . $lang->arrow;
$lang->company->menu->user   = array('link' => '用户|user|index', 'subModule' => 'user');
$lang->company->menu->browseGroup  = array('link' => '权限|group|browse', 'subModule' => 'group');
$lang->company->menu->addGroup     = array('link' => '<i class="icon-group"></i>&nbsp;添加分组|group|create', 'float' => 'right');
$lang->company->menu->addUser      = array('link' => '<i class="icon-plus"></i>&nbsp;添加用户|user|create', 'subModule' => 'user', 'float' => 'right');
$lang->company->menu->batchAddUser = array('link' => '<i class="icon-plus-sign"></i>&nbsp;批量添加|user|batchCreate', 'subModule' => 'user', 'float' => 'right');

$lang->group = new stdclass();
$lang->user  = new stdclass();

$lang->group->menu = $lang->company->menu;
$lang->user->menu  = $lang->company->menu;


// @Green 新增菜单系统设置
/* 系统设置菜单设置。*/
$lang->system = new stdclass();
$lang->system->menu = new stdclass();

$lang->system->menu->list  	 = '系统设置>';

$lang->system->menu->backup = array('link' => '数据备份|system|setBackup','subModule' => 'setBackup');
$lang->system->menu->basicsystem = array('link' => '基本设置|system|setBasicsystem','subModule' => 'setBasicsystem');
$lang->system->menu->log = array('link' => '访问日志|system|log','subModule' => 'log');
$lang->system->menu->mail      = array('link' => '发信|system|mail', 'subModule' => 'mail');

$lang->mail = new stdclass();
$lang->mail->menu = $lang->system->menu;


/* 菜单分组。*/
$lang->menugroup = new stdclass();
$lang->menugroup->story       = 'product';
$lang->menugroup->productplan = 'product';
$lang->menugroup->task        = 'workspace';
$lang->menugroup->notice      = 'workspace';
$lang->menugroup->conclusion  = 'workspace';
$lang->menugroup->problem     = 'workspace';
$lang->menugroup->achievement = 'workspace';
$lang->menugroup->project     = 'workspace';
$lang->menugroup->tutorial    = 'workspace';
$lang->menugroup->convert     = 'admin';
$lang->menugroup->upgrade     = 'admin';
$lang->menugroup->user        = 'company';
$lang->menugroup->group       = 'company';
$lang->menugroup->resources   = 'resources';
$lang->menugroup->people      = 'company';
$lang->menugroup->todo        = 'my';
$lang->menugroup->action      = 'admin';
$lang->menugroup->editor      = 'admin';
$lang->menugroup->mail        = 'system';
$lang->menugroup->sso         = 'admin';

/* 错误提示信息。*/
$lang->error = new stdclass();
$lang->error->companyNotFound = "您访问的域名 %s 没有对应的公司。";
$lang->error->length          = array("『%s』长度错误，应当为『%s』", "『%s』长度应当不超过『%s』，且不小于『%s』。");
$lang->error->reg             = "『%s』不符合格式，应当为:『%s』。";
$lang->error->unique          = "『%s』已经有『%s』这条记录了。请联系管理员。。";
$lang->error->gt              = "『%s』应当大于『%s』。";
$lang->error->ge              = "『%s』应当不小于『%s』。";
$lang->error->notempty        = "『%s』不能为空。";
$lang->error->empty           = "『%s』必须为空。";
$lang->error->equal           = "『%s』必须为『%s』。";
$lang->error->int             = array("『%s』应当是数字。", "『%s』应当介于『%s-%s』之间。");
$lang->error->float           = "『%s』应当是数字，可以是小数。";
$lang->error->email           = "『%s』应当为合法的EMAIL。";
$lang->error->date            = "『%s』应当为合法的日期。";
$lang->error->account         = "『%s』应当为合法的用户名。";
$lang->error->passwordsame    = "两次密码应当相等。";
$lang->error->passwordrule    = "密码应该符合规则，长度至少为六位。";
$lang->error->accessDenied    = '您没有访问权限';
$lang->error->noData          = '没有数据';

/* 分页信息。*/
$lang->pager = new stdclass();
$lang->pager->noRecord  = "暂时没有记录";
$lang->pager->digest    = "共 <strong>%s</strong> 条记录，%s <strong>%s/%s</strong> &nbsp; ";
$lang->pager->recPerPage= "每页 <strong>%s</strong> 条";
$lang->pager->first     = "<i class='icon-step-backward' title='首页'></i>";
$lang->pager->pre       = "<i class='icon-play icon-rotate-180' title='上一页'></i>";
$lang->pager->next      = "<i class='icon-play' title='下一页'></i>";
$lang->pager->last      = "<i class='icon-step-forward' title='末页'></i>";
$lang->pager->locate    = "GO!";

$lang->zentaoSite     = "官方网站";
$lang->chinaScrum     = "<a href='http://api.zentao.net/goto.php?item=chinascrum' target='_blank'>Scrum社区</a>&nbsp; ";
$lang->agileTraining  = "<a href='http://api.zentao.net/goto.php?item=agiletrain' target='_blank'>培训</a> ";
$lang->donate         = "<a href='http://api.zentao.net/goto.php?item=donate' target='_blank'>捐赠 </a>";
$lang->proVersion     = "<a href='http://api.zentao.net/goto.php?item=proversion&from=footer' target='_blank' id='proLink' class='text-important'><i class='text-danger icon-reply icon-rotate-90'></i> 升至专业版！</a> &nbsp; ";
$lang->downNotify     = "下载桌面提醒";

$lang->suhosinInfo = "警告：数据太多，请在php.ini中修改<font color=red>sohusin.post.max_vars</font>和<font color=red>sohusin.request.max_vars</font>（设置更大的数）。 保存并重新启动apache，否则会造成部分数据无法保存。";

$lang->noResultsMatch     = "没有匹配结果";
$lang->selectAnOption     = "选择一个选项";
$lang->selectSomeOptions  = "选择一些选项";
//$lang->chooseUsersToMail  = "选择要发信通知的用户...";

/* 时间格式设置。*/
define('DT_DATETIME1',  'Y-m-d H:i:s');
define('DT_DATETIME2',  'y-m-d H:i');
define('DT_MONTHTIME1', 'n/d H:i');
define('DT_MONTHTIME2', 'n月d日 H:i');
define('DT_DATE1',     'Y-m-d');
define('DT_DATE2',     'Ymd');
define('DT_DATE3',     'Y年m月d日');
define('DT_DATE4',     'n月j日');
define('DT_TIME1',     'H:i:s');
define('DT_TIME2',     'H:i');

/* datepicker 时间*/
$lang->datepicker = new stdclass();

$lang->datepicker->dpText = new stdclass();
$lang->datepicker->dpText->TEXT_OR          = '或 ';
$lang->datepicker->dpText->TEXT_PREV_YEAR   = '去年';
$lang->datepicker->dpText->TEXT_PREV_MONTH  = '上月';
$lang->datepicker->dpText->TEXT_PREV_WEEK   = '上周';
$lang->datepicker->dpText->TEXT_YESTERDAY   = '昨天';
$lang->datepicker->dpText->TEXT_THIS_MONTH  = '本月';
$lang->datepicker->dpText->TEXT_THIS_WEEK   = '本周';
$lang->datepicker->dpText->TEXT_TODAY       = '今天';
$lang->datepicker->dpText->TEXT_NEXT_YEAR   = '明年';
$lang->datepicker->dpText->TEXT_NEXT_MONTH  = '下月';
$lang->datepicker->dpText->TEXT_CLOSE       = '关闭';
$lang->datepicker->dpText->TEXT_DATE        = '选择时间段';
$lang->datepicker->dpText->TEXT_CHOOSE_DATE = '选择日期';

$lang->datepicker->dayNames     = array('日', '一', '二', '三', '四', '五', '六');
$lang->datepicker->abbrDayNames = array('日', '一', '二', '三', '四', '五', '六');
$lang->datepicker->monthNames   = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');

/* Common action icons 通用动作图标 */
$lang->icons['todo']      = 'check';
$lang->icons['product']   = 'cube';
$lang->icons['resources'] = 'resources';
$lang->icons['task']      = 'check-sign';
$lang->icons['tasks']     = 'tasks';
$lang->icons['personalinfo']       = 'file-text';
$lang->icons['doclib']    = 'folder-close';
$lang->icons['story']     = 'lightbulb';
$lang->icons['roadmap']   = 'code-fork';
$lang->icons['plan']      = 'flag';
$lang->icons['dynamic']   = 'volume-up';
$lang->icons['build']     = 'tag';
$lang->icons['test']      = 'check';
$lang->icons['group']     = 'group';
$lang->icons['team']      = 'group';
$lang->icons['company']   = 'building';
$lang->icons['user']      = 'user';
$lang->icons['tree']      = 'sitemap';
$lang->icons['usecase']   = 'sitemap';
$lang->icons['result']    = 'flag-checkered';
$lang->icons['mail']      = 'envelope';
$lang->icons['trash']     = 'trash';
$lang->icons['app']       = 'th-large';

$lang->icons['results']        = 'flag-checkered';
$lang->icons['create']         = 'plus';
$lang->icons['post']           = 'edit';
$lang->icons['batchCreate']    = 'plus-sign';
$lang->icons['batchEdit']      = 'edit-sign';
$lang->icons['batchClose']     = 'off';
$lang->icons['edit']           = 'pencil';
$lang->icons['delete']         = 'remove';
$lang->icons['copy']           = 'copy';
$lang->icons['student']         = 'bar-chart';
$lang->icons['export']         = 'download-alt';
$lang->icons['student-file']    = 'file-powerpoint';
$lang->icons['import']         = 'upload-alt';
$lang->icons['finish']         = 'ok-sign';
$lang->icons['submit']         = 'ok-sign';
$lang->icons['resolve']        = 'ok-sign';
$lang->icons['start']          = 'play';
$lang->icons['run']            = 'play';
$lang->icons['runCase']        = 'play';
$lang->icons['batchRun']       = 'play-sign';
$lang->icons['assign']         = 'hand-right';
$lang->icons['assignTo']       = 'hand-right';
$lang->icons['change']         = 'random';
$lang->icons['link']           = 'link';
$lang->icons['close']          = 'off';
$lang->icons['activate']       = 'off';
$lang->icons['review']         = 'search';
$lang->icons['confirm']        = 'search';
$lang->icons['putoff']         = 'calendar';
$lang->icons['suspend']        = 'pause';
$lang->icons['cancel']         = 'ban-circle';
$lang->icons['recordEstimate'] = 'time';
$lang->icons['manage']         = 'cog';

include (dirname(__FILE__) . '/menuOrder.php');
