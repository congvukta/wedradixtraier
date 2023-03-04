<?php
// file này sử dụng đăng nhập
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file

$data=[
  'pageTitle'=>'Đăng nhập hệ thống'
];
layout('header-login',$data);
// kiểm tra trạng thái đăng nhập
 if (isLogin()){
     redirect('?module=users');
 }
//Xử lý đăng nhập
if (isPost()){
    $body=getBody();
    if ($body['email']&& $body['password']){
        if (!empty(trim($body['email'])) && !empty(trim($body['password']))){
            //Kiểm tra đăng nhập
            $email=$body['email'];
            $password=$body['password'];
            // truy vấn thông tin theo email
            $userQuery=firstRaw("SELECT id, password FROM users WHERE email='$email' AND status=1");
           if (!empty($userQuery)){
               $passwordHash=$userQuery['password'];
               if (password_verify($password,$passwordHash)){
                   // tạo token login
                   $userId=$userQuery['id'];
                   $tokenLogin=sha1(uniqid().time());

                   // Insert vào bảng login_token
                   $dataToken=[
                           'userId'=>$userId,
                       'token'=>$tokenLogin,
                       'createat'=>date('Y-m-d H:i:s')
                   ];
                   $insertTokenStatus= insert('login_token',$dataToken);
                   if ($insertTokenStatus){
                       // Thêm thành công

                       // Lưu token vào session
                       setSession('login_token',$tokenLogin);

                       // Chuyển hướng sang trang quản lý users
                       redirect('?module=users');

                   }else{
                       setFlashData('msg','Lỗi hệ thống, bạn không thể đăng nhập ngay lúc này');
                       setFlashData('msg-type','danger');
                       //redirect('?module=auth&action=login');

                   }
               }else{
                   setFlashData('msg','Mật khẩu không đúng');
                   setFlashData('msg-type','danger');
                   //redirect('?module=auth&action=login');
               }
           }else{
               setFlashData('msg','Email không tồn tại trong hệ thống hoặc chưa được kích hoạt');
               setFlashData('msg-type','danger');
               //redirect('?module=auth&action=login');
           }
        }
    }else{
        setFlashData('msg','Vui lòng nhập email và mật khẩu');
        setFlashData('msg-type','danger');
        //redirect('?module=auth&action=login');
    }
    redirect('?module=auth&action=login');
}


$msg=getFlashData('msg');
$msgType=getFlashData('msg-type');

?>
<div class="row">
    <div class="col-6" style="margin: 20px auto;">
        <h3 class="text-center text-uppercase ">Đăng nhập hệ thống</h3>
        <?php getMsg($msg,$msgType); ?>
        <form action="" method="post">
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" placeholder=" Đại chỉ email...">
        </div>
        <div class="form-group">
            <label for="">Mật Khẩu</label>
            <input type="password" name="password" class="form-control" placeholder=" Mật khẩu....">
        </div>
        <button type="submit" class="btn btn-primary btn-block"> Đăng nhập</button>
        <hr>
        <p class="text-center"><a href="?module=auth&action=forgot">Quên mật khẩu</a></p>
        <p class="text-center"><a href="?module=auth&action=register">Đăng ký tài khoản</a></p>
        </form>
    </div>
</div>
<?php
layout('footer-login');
