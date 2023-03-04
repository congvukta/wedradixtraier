<?php
// file này chức chức năng đăng xuất
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file
if (isLogin()){
    $token=getSession('login_token');
    delete('login_token',"token='$token'");
    removeSession('login_token');
    redirect('?module=auth&action=login');
}