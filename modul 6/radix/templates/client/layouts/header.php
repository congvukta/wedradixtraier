<?php
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file
if (!isLogin()){
    redirect('?module=auth&action=login');
}else{
    $userId=isLogin()['userId'];
    $userDetail=getUserInfo($userId);
}

saveActivity();// lưu hoạt động cuối cùng của user
autoRemoveTokenlogin();//
?>
<html>
<head>
    <title>Quản lý người dùng</title>
    <meta charset="UTF-8"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE;?>/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE;?>/css/fontawesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE;?>/css/style.css?ver=<?php rand();?>"/>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo _WEB_HOST_ROOT.'module=users';?>">Anh Vũ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo _WEB_HOST_ROOT.'module=users'; ?>">Tổng quan </a>
                </li>
                <li class="text-center">
                    <p class="text-center">Hi,<?php echo $userDetail['fullname'] ;?></p>
                </li>
                <li class="text-center">
                    <p style="margin-right: auto">Đổi mật khẩu</p>
                </li>
                <li class="nav-item profile">
                        <a class="dropdown-item" href="<?php echo _WEB_HOST_ROOT.'?module=auth&action=logout';?>">Đăng xuất</a>
                </li>
            </ul>

        </div>
    </nav>
</header>
