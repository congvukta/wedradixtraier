<?php
//file này chứ chức năng đặt lại mật khẩu
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file
layout('header-login');
echo '<div class="container text-center"><br/>';
$token=getBody()['token'];
if (!empty($token)){
    //truy vấn kiểm tra token với database
    $tokenQuery= firstRaw("SELECT id, email FROM users WHERE forgotToken='$token'");
    if (!empty($tokenQuery)){
        $userId=$tokenQuery['id'];
        $email=$tokenQuery['email'];
        if (isPost()){
            $body=getBody();
            $erros=[];
            // Validate mật khẩu: Bắt buộc phải nhập,>=8 ký tự
            if (empty(trim($body['password']))){
                $erros['password']['required']='Mật khẩu bắt buộc phải nhập';
            }else{
                if (strlen(trim($body['password']))<8){
                    $erros['password']['min']='Mật khẩu lớn hơn 8 ký tự';
                }
            }

            // validate nhập lại mật khẩu
            if (empty(trim($body['confirm_password']))){
                $erros['confirm_password']['required']='Xác nhận mật khẩu không được để trống';
            }else{
                if (trim($body['password'])!=trim($body['confirm_password'])){
                    $erros['confirm_password']['match']='Hai mật khẩu không giống nhau';
                }
            }
            if (empty($erros)){
                // Xử lý update
                $passwordHash=password_hash($body['password'],PASSWORD_DEFAULT);
                $dateUpdate= [
                    'password'=>$passwordHash,
                    'updateAt'=>date('Y-m-d H:i:s')
                ];
                $updateStatus=update('users',$dateUpdate,"id=$userId");
                if ($updateStatus){
                    setFlashData('msg','Thay đổi mật khảu thành công');
                    setFlashData('msg-type','success');

                    //Gửi email thông báo khi đổi xong
                    $subject='Bạn vừa đổi mật khẩu';
                    $content='Chúc mừng bạn vừa đổi mật khẩu thành công';
                    sendMail($email,$subject,$content);


                    redirect('?module=auth&action=login');
                }else{
                    etFlashData('msg','Lỗi hệ thống bạn không thể đổi mật khẩu');
                    setFlashData('msg-type','danger');
                    redirect('?module=auth&action=reset&token='.$token);
                }
            }else{
                setFlashData('msg','Vui lòng kiểm tra dữ liệu nhập vào');
                setFlashData('msg-type','danger');
                setFlashData('erros',$erros);
                redirect('?module=auth&action=reset&token='.$token);// load lại trang đằng ký
            }

        }
        // Viết thông báo ngoài post
        $msg=getFlashData('msg');
        $msgType=getFlashData('msg-type');
        $erros=getFlashData('erros');


        ?>
        <div class="row" >
            <div class="col-6" style="margin: 20px auto;">
                <h3 class=" text-uppercase ">Đặt lại mật khẩu</h3>
                <?php getMsg($msg,$msgType); ?>
                <form action="" method="post">

                    <div class="form-group">
                        <label for="">Mật Khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder=" Mật khẩu....">
                        <?php echo form_error('password',$erros,'<span class="error">','</span>')?>
                    </div>
                    <div class="form-group">
                        <label for="">Nhập lại Mật Khẩu</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder=" Nhập lại Mật khẩu....">
                        <?php echo form_error('confirm_password',$erros,'<span class="error">','</span>')?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"> Xác Nhận</button>
                    <hr>
                    <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
                    <p class="text-center"><a href="?module=auth&action=register">Đăng ký tài khoản</a></p>
                    <input type="hidden" name="token" value="<?php echo $token;?>">
                </form>
            </div>
        </div>
<?php
    }else{
        getMsg('Liên kết không tồn tại hoặc đã hết hạn','danger');
    }
}else{
    getMsg('Liên kết không tồn tại hoặc đã hết hạn','danger');
}

echo '</div>';
layout('footer-login');