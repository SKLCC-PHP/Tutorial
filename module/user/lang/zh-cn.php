<?php

$lang->user->common      = '用户';
$lang->user->account     = '用户名';
$lang->user->password    = '密码';
$lang->user->captcha     = '验证码';
$lang->user->password1    = '新密码';
$lang->user->password2   = '确认密码';
$lang->user->realname    = '姓名';
$lang->user->gender      = '性别';
$lang->user->college     = '学院';
$lang->user->specialty   = '专业';
$lang->user->department  = '系';
$lang->user->polical_status   = '政治面貌';
$lang->user->title  	 = '职称';
$lang->user->education   = '学历';
$lang->user->grade   = '年级';
$lang->user->manager_grade   = '管理年级';
$lang->user->education_now   = '在读';
$lang->user->status      = '帐号状态';
$lang->user->mobile 	 = '手机';
$lang->user->phone 	 	= '办公室电话';
$lang->user->email       = '邮箱';
$lang->user->qq          = 'QQ';
$lang->user->role        = '角色';
$lang->user->visits      = '访问次数';
$lang->user->ip          = '登录IP';
$lang->user->last        = '最后登录';
$lang->user->avatar      = '头像';
$lang->user->role      	 = '角色';
$lang->user->tutor       = '导师';
$lang->user->collegeName     = '学院名称';
$lang->user->createtime = '创建时间';
$lang->user->company     = '所属公司';
$lang->user->dormitory = '宿舍';
$lang->user->office = '办公室';
$lang->user->research = '研究方向';
$lang->user->search = '搜索用户';
$lang->user->class = '行政班级';

$lang->user->group       = '分组';
$lang->user->nickname    = '昵称';
$lang->user->commiter    = '源代码帐号';
$lang->user->birthyear   = '出生年';
$lang->user->basicInfo   = '基本信息';
$lang->user->accountInfo = '帐号信息';
$lang->user->contactInfo = '联系信息';
$lang->user->address     = '通讯地址';
$lang->user->zipcode     = '邮编';
$lang->user->join        = '加入日期';
$lang->user->verification_code = '验证码';

$lang->user->ditto       = '同上';
$lang->user->index           = "用户一览";
$lang->user->view            = "用户详情";
$lang->user->create          = "添加用户";
$lang->user->batchCreate     = "批量添加用户";
$lang->user->read            = "查看用户";
$lang->user->edit            = "编辑用户";
$lang->user->batchEdit       = "批量编辑";
$lang->user->editGroup       = "编辑用户分组";
$lang->user->unlock          = "解锁用户";
$lang->user->update          = "编辑用户";
$lang->user->delete          = "删除用户";
$lang->user->browse          = "浏览用户";
$lang->user->login           = "用户登录";
$lang->user->mobileLogin     = "手机访问";
$lang->user->userView        = "人员视图";
$lang->user->editBasicInformation     = "修改档案";
$lang->user->editPassword    = "修改密码";
$lang->user->manageContacts  = '维护联系人';
$lang->user->deleteContacts  = '删除联系人';
$lang->user->deny            = "访问受限";
$lang->user->confirmDelete   = "您确定删除该用户吗？";
$lang->user->confirmActivate = "您确定激活该用户吗？";
$lang->user->confirmUnlock   = "您确定解除该用户的锁定状态吗？";
$lang->user->relogin         = "重新登录";
$lang->user->asGuest         = "游客访问";
$lang->user->goback          = "返回前一页";
$lang->user->allUsers        = '全部用户';
$lang->user->deleted         = '(已删除)';
$lang->user->select          = '请选择用户';

$lang->user->profile      = '档案';
$lang->user->project      = '项目';
$lang->user->task         = '任务';
$lang->user->test         = '测试';
$lang->user->todo         = '待办';
$lang->user->story        = '需求';
$lang->user->team         = '团队';
$lang->user->dynamic      = '动态';
$lang->user->ajaxGetUser  = '接口:获得用户';
$lang->user->resources = '广场资源';

$lang->user->openedBy    = '由他创建';
$lang->user->assignedTo  = '指派给他';
$lang->user->finishedBy  = '由他完成';
$lang->user->resolvedBy  = '由他解决';
$lang->user->closedBy    = '由他关闭';
$lang->user->reviewedBy  = '由他评审';
$lang->user->canceledBy  = '由他取消';

$lang->user->testTask2Him = '他的任务';
$lang->user->case2Him     = '给他的用例';
$lang->user->caseByHim    = '他建的用例';

$lang->user->errorDeny   = "抱歉，您无权访问『<b>%s</b>』模块的『<b>%s</b>』功能。请联系管理员获取权限。点击后退返回上页。";
$lang->user->loginFailed = "登录失败，请检查您的用户名或密码是否填写正确。";
$lang->user->lockWarning = "您还有%s次尝试机会。";
$lang->user->wrong_captcha = "验证码不正确，请重新输入！";
$lang->user->loginLocked = "密码尝试次数太多，请联系管理员解锁，或%s分钟后重试。";
$lang->user->emailError = "邮箱与改账户填写的邮箱不符";
$lang->user->successSent = "密码邮件已发送，请检查您的邮箱，留意垃圾箱";
$lang->user->failSent = "Sorry, 发送失败，再次尝试或联系管理员";

$lang->user->genderList['m'] = '男';
$lang->user->genderList['f'] = '女';

$lang->user->statusList['1'] 	= '正常';
$lang->user->statusList['0'] 	= '禁用';
$lang->user->statusList['-1'] 	= '离校';

$lang->user->keepLogin['on']      = '保持登录';
$lang->user->loginWithDemoUser    = '这块保留';		// @Tony 暂时保留这块

$lang->user->placeholder = new stdclass();
$lang->user->placeholder->account   = '网关账号';
$lang->user->placeholder->password1 = '六位以上';
// $lang->user->placeholder->role      = '职位影响内容和用户列表的顺序。';
//$lang->user->placeholder->group     = '分组决定用户的权限列表。';
$lang->user->placeholder->join      = '入职日期';


$lang->user->error = new stdclass();
$lang->user->error->account       = "ID %s，网关账号? 英文、数字和下划线的组合，三位以上";
$lang->user->error->accountDupl   = "ID %s，该用户名已经存在";
$lang->user->error->realname      = "ID %s，必须填写真实姓名";
$lang->user->error->password      = "ID %s，密码必须六位以上";
$lang->user->error->mail          = "ID %s，请填写正确的邮箱地址";
$lang->user->error->role          = "ID %s，职位不能为空";

$lang->user->contacts = new stdclass();
$lang->user->contacts->common   = '联系人';
$lang->user->contacts->listName = '列表名称';
$lang->user->contacts->userList = '联系人列表';

$lang->user->contacts->manage       = '维护列表';
$lang->user->contacts->contactsList = '已有列表';
$lang->user->contacts->selectedUsers= '选择用户';
$lang->user->contacts->selectList   = '选择列表';
$lang->user->contacts->appendToList = '追加至已有列表：';
$lang->user->contacts->createList   = '创建新列表：';
$lang->user->contacts->noListYet    = '还没有创建任何列表。';
$lang->user->contacts->confirmDelete= '您确定要删除这个列表吗？';
$lang->user->contacts->or           = ' 或者 ';
