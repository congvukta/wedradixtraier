<?php
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file
autoRemoveTokenlogin();
?>
<html>
<head>
    <title><?php echo !empty($data['pageTitle'])?$data['pageTitle']:'ABC'?></title>
    <meta charset="UTF-8"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE;?>/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE;?>/css/fontawesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE;?>/css/style.css?ver=<?php echo rand();?>"/>

</head>
<body>
