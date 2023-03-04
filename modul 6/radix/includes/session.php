<?php
// chứa các hàm liên quan đến thao tác session
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file
//hàm set session
function setSession($key,$value){
    if (!empty(session_id())){
        $_SESSION[$key]=$value;
        return true;
    }
    return false;

}

//Hàm đọc session
function getSession($key=''){
    if (empty($key)){
        return $_SESSION;
    }else{
        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }
    return false;
}

//Hàm xóa session
function removeSession($key=''){
    if (empty($key)){
        session_destroy();
        return true;
    }else{
        if (isset($_SESSION[$key])){
            unset($_SESSION[$key]);
            return true;
        }
    }
    return false;
}
// hàm gán flash data. từ động thêm và xóa session
function setFlashData($key,$value){
    $key='flash'.$key;
    return setSession($key,$value);
}
//Hàm đọc flash data
function getFlashData($key){
    $key='flash'.$key;
    $data=getSession($key);
    removeSession($key);
    return $data;
}