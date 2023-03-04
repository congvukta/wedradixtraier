<?php
// file chứa các hằng số cấu hình
date_default_timezone_set('Asia/Ho_Chi_Minh');
// thiết lập hằng số cho client
const _MODULE_DEFAUT ='home';//module mặc đinh
const _ACTION_DEFAUT ='lists';//action mặc định


// thiết lập hằng số cho Admin
const _MODULE_DEFAUT_ADMIN ='dashboard';
const _INCODE =true; // ngăn chặn hành vi truy cập trực tiếp vào file


// thiết lập host
define('_WEB_HOST_ROOT','http://'.$_SERVER['HTTP_HOST'].'/online_php/modul%206/radix');// Địa chỉ trang chủ
define('_WEB_HOST_TEMPLATE',_WEB_HOST_ROOT.'/templates/client');// đường dẫn vào thư mục
define('_WEB_HOST_ROOT_ADMIN',_WEB_HOST_ROOT.'/admin');
define('_WEB_HOST_ADMIN_TEMPLATE',_WEB_HOST_ROOT.'/templates/admin');
// thiết lập đường dẫn path
define('_WEB_PATH_ROOT',__DIR__);
define('_WEB_PATH_TEMPLATE',_WEB_PATH_ROOT.'/templates');

// Thiết lập kết nối database
// Thông tin kết nối
const _HOST='localhost';
const _USER='root';
const _PASS='';
const _DB='phonline_radix';
const _DRIVER='mysql';
const _PER_PAGE=5;
