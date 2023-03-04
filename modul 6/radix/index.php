<?php
session_start();
require_once 'config.php';
// thêm phpmailer
require_once './includes/phpmailer/PHPMailer.php';
require_once './includes/phpmailer/Exception.php';
require_once './includes/phpmailer/SMTP.php';

require_once './includes/functions.php';
require_once './includes/connect.php';
require_once './includes/database.php';
require_once './includes/session.php';
//code chức năng điều hướng module
$module=_MODULE_DEFAUT;
$action=_ACTION_DEFAUT;
if (!empty($_GET['module'])){
    if (is_string($_GET['module'])){
        $module=trim($_GET['module']);
    }
}
if (!empty($_GET['action'])){
    if (is_string($_GET['action'])){
        $action=trim($_GET['action']);
    }
}

// code chức năng có tồn tại thư mực file có tờn tại không
$path='modules/'.$module.'/'.$action.'.php';
//echo $path;
if (file_exists($path)){
    require_once $path;
}else{
    require_once 'modules/errors/404.php';
}

