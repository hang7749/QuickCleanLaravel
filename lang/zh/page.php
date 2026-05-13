<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Labels (通用标签)
    |--------------------------------------------------------------------------
    */

    'changeLanguage' => '切换语言',
    'button' => '按钮',
    'or' => '或',
    'no' => '否',
    'yes' => '是',
    'cancel' => '取消',
    'save' => '保存',
    'create' => '创建',
    'logout' => '注销',
    'logoutP' => '注销您的账户',
    'member' => '会员',
    'admin' => '管理员',
    'logoutConfirmation' => '您确定要注销吗？',
    'add' => '添加',
    'total' => '总计',
    'backToHome' => '返回首页',
    'home' => '首页',
    'allSet' => '一切就绪！',
    'awesome' => '太棒了！',
    'viewAll' => '查看全部',
    'edit' => '编辑',
    'delete' => '删除',
    'actions' => '操作',
    'saveChanges' => '保存更改',
    'update' => '更新',
    'confirm' => '确认',

    /*
    |--------------------------------------------------------------------------
    | Errors & Status (错误与状态)
    |--------------------------------------------------------------------------
    */

    'supabaseError' => 'Supabase 错误: :e',
    'unexpectedError' => '意外错误: :e',
    'status' => '状态',
    'pending' => '待处理',
    'confirmed' => '已确认',
    'completed' => '已完成',
    'cancelled' => '已取消',
    'error' => '错误',
    'success' => '成功',

    /*
    |--------------------------------------------------------------------------
    | Login & Registration (登录与注册)
    |--------------------------------------------------------------------------
    */

    'loginTitle' => '登录',
    'loginButton' => '登录',
    'adminLoginTitle' => '管理员登录',
    'loginAsAdmin' => '以管理员身份登录',
    'loginAsUser' => '以用户身份登录',
    'loginFailed' => '登录失败',
    'accountNotExist' => '未找到该凭据对应的会员账号。',
    'adminNotFound' => '未找到该凭据对应的管理员账号。',
    'signUp' => '注册',
    'dontHaveAccount' => "还没有账号？",
    'alreadyHaveAccount' => '已有账号？',
    'registrationSuccess' => '账号已创建！您现在可以登录了。',
    'registrationFailed' => '注册失败',
    'welcomeBack' => '欢迎回来, :name!',

    /*
    |--------------------------------------------------------------------------
    | Form Fields & Validation (表单字段与验证)
    |--------------------------------------------------------------------------
    */

    'emailLabel' => '电子邮箱',
    'emailHint' => '请输入您的电子邮箱',
    'emailError' => '请输入有效的电子邮箱地址',
    'passwordLabel' => '密码',
    'passwordHint' => '请输入您的密码',
    'passwordError' => '密码为必填项',
    'passwordTooShort' => '最少 6 个字符',
    'fullName' => '全名',
    'enterAName' => '输入姓名',
    'enterAnEmail' => '输入电子邮箱',
    'enterAPassword' => '输入密码',
    'termsAndConditions' => '我接受条款与条件',
    'termsAndConditionsError' => '请接受条款与条件',

    /*
    |--------------------------------------------------------------------------
    | Password Recovery (密码找回)
    |--------------------------------------------------------------------------
    */

    'forgotPassword' => '忘记密码？',
    'resetPassword' => '重置密码',
    'forgotPasswordInstruction' => "请输入您的电子邮箱，我们将向您发送重置密码的链接。",
    'sendLink' => '发送链接',
    'resetLinkSent' => '重置链接已发送！请检查您的邮箱。',
    'changePassword' => '修改密码',
    'updatePassword' => '更新密码',
    'newPassword' => '新密码',

    /*
    |--------------------------------------------------------------------------
    | Profile & Account (个人资料与账号)
    |--------------------------------------------------------------------------
    */

    'viewProfile' => '查看个人资料',
    'profileUpdated' => '个人资料更新成功！',
    'profileUpdateFailed' => '更新失败: :e',
    'passwordUpdated' => '密码更新成功！',
    'passwordUpdateFailed' => '更新密码失败。',
    'updateAccountSecurity' => '更新账号安全',
    'accountRole' => '账号角色',

    /*
    |--------------------------------------------------------------------------
    | Booking System (预约系统)
    |--------------------------------------------------------------------------
    */

    'myBookings' => '我的预约',
    'book' => '预约',
    'bookings' => '预约',
    'checkServiceSchedule' => '查看您的服务日程',
    'upcoming' => '即将开始',
    'history' => '历史记录',
    'noBooking' => '未找到预约。',
    'noBookingsFound' => '未找到任何预约。',
    'cancelBooking' => '取消预约',
    'confirmCancelBooking' => '您确定要取消此项服务吗？',
    'bookingCancelled' => '预约已成功取消',
    'bookingCancelError' => '取消预约时出错，请重试。',
    'selectDate' => '选择日期',
    'selectTime' => '选择时间',
    'selectSpecialist' => '选择专家',
    'noSpecialist' => '此项服务暂无可用专家。',
    'price' => '价格',
    'confirmBooking' => '确认预约',
    'bookingConfirmed' => '预约成功确认！',
    'bookingSuccess' => '您的预约已确认！我们期待为您服务。',
    'payment' => '支付',
    'paymentSuccessful' => '支付成功！您的预约已确认。',
    'paymentFailed' => '支付失败: :e',
    'checkout' => '结算',
    'orderSummary' => '订单摘要',
    'service' => '服务',
    'date' => '日期',
    'time' => '时间',
    'totalAmount' => '总金额',
    'confirmAndPay' => '确认并支付',
    'bookingSaveError' => '保存预约时出错，请重试。',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel & Management (管理后台)
    |--------------------------------------------------------------------------
    */

    'adminPanel' => '管理面板',
    'dashboard' => '仪表板',
    'manageServices' => '管理服务',
    'manageMembers' => '管理会员',
    'manageAdmin' => '管理管理员',
    'addNewAdmin' => '添加新管理员',
    'createAdminAccount' => '创建管理员账号',
    'manageServiceProviders' => '管理服务提供商',
    'manageBookings' => '管理预约',
    'searchByNameOrEmail' => '按姓名或邮箱搜索...',
    'noAdminsFound' => '未找到管理员。',
    'adminCreatedSuccessfully' => '管理员账号创建成功！',
    'adminCreationFailed' => '创建管理员账号失败，请重试。',
    'changeStatus' => '更改状态',
    'totalBookings' => '总预约数',
    'activeMembers' => '活跃会员',
    'recentBookings' => '最近预约',
    'provider' => '提供商',
    'dateTime' => '日期/时间',

    /*
    |--------------------------------------------------------------------------
    | Services & Providers (服务与提供商)
    |--------------------------------------------------------------------------
    */
    'services' => '服务',
    'serviceList' => '服务列表',
    'newService' => '新服务',
    'editService' => '编辑服务',
    'serviceName' => '服务名称',
    'serviceUpdated' => '服务已更新',
    'serviceDeleted' => '服务已删除',
    'errorFetchingServices' => '获取服务错误: :e',
    'iconURL' => '图标 URL',
    'imageURL' => '图片 URL',
    'currentImagePreview' => '当前图片预览',
    'description' => '描述',

    'topRated' => '高分推荐',
    'newServiceProvider' => '新服务提供商',
    'serviceAddFailed' => '添加服务失败，请重试。',
    'serviceUpdateFailed' => '更新服务失败，请重试。',
    'serviceProviders' => '服务提供商',
    'editServiceProvider' => '编辑提供商',
    'selectSpecialty' => '选择专业',
    'specialty' => '专业',
    'serviceDeleteFailed' => '删除服务失败，可能与现有预约相关联。',
    'available' => '可用',
    'notAvailable' => '不可用',

    'memberList' => '会员列表',
    'totalRegisteredCustomers' => '注册客户总数',
    'memberName' => '会员姓名',
    'emailAddress' => '电子邮箱地址',
    'joinedDate' => '加入日期',
    'editMember' => '编辑会员',
    'noMembersFound' => '未找到会员。',
    'memberUpdated' => '会员更新成功！',
    'memberUpdateFailed' => '更新会员失败，请重试。',
    'memberDeleted' => '会员已成功删除。',
    'confirmDeleteMember' => '您确定要删除此会员吗？这将移除其所有预约历史。',

    'adminList' => '管理员列表',
    'confirmDeleteAdmin' => '您确定要移除此管理员吗？',
    'createAdmin' => '创建管理员',

    'editBooking' => '编辑预约',
    'updateBooking' => '更新预约',
    'availableForBooking' => '可接受预约',
    'schedule' => '日程',
    'bookingUpdated' => '预约更新成功！',
    'providerUpdateFailed' => '更新提供商失败，请重试。',
    'providerAddFailed' => '添加提供商失败，请重试。',
    'providerRemoved' => '提供商已成功移除。',
    'providerUpdated' => '提供商已成功更新。',

    /*
    |--------------------------------------------------------------------------
    | Contact Options (联系方式)
    |--------------------------------------------------------------------------
    */

    'phone' => '拨打电话',
    'whatsapp' => 'WhatsApp',
    'email' => '电子邮箱',
    'messenger' => 'Messenger',

];