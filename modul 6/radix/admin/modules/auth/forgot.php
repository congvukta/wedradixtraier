<?php
// file chứ chức năng quên mật khẩu
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file
$data=[
    'pageTitle'=>'Đặt lại mật khẩu'
];
layout('header-login',$data);
// kiểm tra trạng thái đăng nhập
if (isLogin()){
    redirect('?module=users');
}
//Xử lý đăng nhập
if (isPost()){
    $body=getBody();
    $email=$body['email'];
    if (!empty($body['email'])){
        $email=$body['email'];
       $queryUser=firstRaw("SELECT id FROM users WHERE email='$email'");
       if (!empty($queryUser)){
           $userId=$queryUser['id'];

           // tạo forgotToken
           $forgotToken=sha1(uniqid().time());
           $dataUpdate=[
               'forgotToken'=>$forgotToken
           ];
           $updateStatus=update('users',$dataUpdate,"id=$userId");
           if ($updateStatus){
               // Thiết lập link reset mật khẩu
               $linkReset=_WEB_HOST_ROOT.'?module=auth&action=reset&token='.$forgotToken;
               //Thiết lập gửi mail
               $subject='Yêu cầu khôi phục mật khẩu';
               $content='Chào bạn '.$email.'<br/>';
               $content.='Chúng tôi nhận được yêu cầu khôi phục mật khẩu từ bạn. Vui lòng click vào link sau để khôi phục mật khẩu <br/>';
               $content.=$linkReset.'<br/>';
               $content.= 'Trân trọng';
               $sendStatus=sendMail($email,$subject,$content);
               if ($sendStatus){
                   setFlashData('msg','Vui lòng kiểm tra email để đặt lại mật khẩu');
                   setFlashData('msg-type','success');
               }else{
                   setFlashData('msg','Lỗi hệ thống bạn không thể sử dụng chức năng này');
                   setFlashData('msg-type','danger');
               }
           }else{
               setFlashData('msg','Lỗi hệ thống bạn không thể sử dụng chức năng này');
               setFlashData('msg-type','danger');
           }
       }else{
           setFlashData('msg','Email không tồn tại');
           setFlashData('msg-type','danger');

       }
    }else{
        setFlashData('msg','Vui lòng nhập dữ liệu');
        setFlashData('msg-type','danger');
    }
}


$msg=getFlashData('msg');
$msgType=getFlashData('msg-type');

?>
    <div class="row">
        <div class="col-6" style="margin: 20px auto;">
            <h3 class="text-center text-uppercase ">Đặt lại mật khẩu</h3>
            <?php getMsg($msg,$msgType); ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" placeholder=" Đại chỉ email...">
                </div>

                <button type="submit" class="btn btn-primary btn-block"> Xác Nhận</button>
                <hr>
                <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
                <p class="text-center"><a href="?module=auth&action=register">Đăng ký tài khoản</a></p>
            </form>
        </div>
    </div>
<?php
layout('footer-login');