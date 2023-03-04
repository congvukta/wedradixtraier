<?php
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file
function layout($layoutName='header',$dir='', $data=[]){
    if (!empty($dir)){
        $dir='/'.$dir;
    }
    if (file_exists(_WEB_PATH_TEMPLATE.$dir.'/layouts/'.$layoutName.'.php'))
    {
    require_once _WEB_PATH_TEMPLATE.$dir.'/layouts/'.$layoutName.'.php';}
}
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($to,$subject,$content){
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'congvukta@gmail.com';                     //SMTP username
        $mail->Password   = 'wcvwsgxrmrkuzvdq';                               //SMTP password
        $mail->SMTPSecure = 'ssl';                                //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('congvukta@gmail.com', 'Test mail');
        $mail->addAddress($to);     //Add a recipient
        $mail->addAddress($to);               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet='UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $content ;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        return $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
 // viết hàm kiểm tra phương thức Post
function isPost(){
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        return true;
    }
    return false;
}
// Viết hàm kiểm tra phương thức GET
function isGet(){
    if ($_SERVER['REQUEST_METHOD']=='GET'){
        return true;
    }
    return false;
}

// Viết hàm lấy giá trị phương thức POST, GET
function getBody(){
    $bodyArr=[];
    if(isGet()){
        //xử lý chuỗi trước khi hiển thị ra dùng filterget
        /*
         * Đọc key mảng $_GET
         * **/
        if (!empty($_GET)){
            foreach ($_GET as $key=>$value){
                $key=strip_tags($key);
                if (is_array($value)){
                    $bodyArr[$key]=filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }else{
                    $bodyArr[$key]=filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    // đọc key mảng $_POST
    if (isPost()){
        if (!empty($_POST)){
            foreach ($_POST as $key=>$value){
                $key=strip_tags($key);
                if (is_array($value)){
                    $bodyArr[$key]=filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }else{
                    $bodyArr[$key]=filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    return $bodyArr;
}
// hàm kiểm tra email
function isEmail($email){
    $checkEmail= filter_var($email,FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}
// hàm kiểm tra số nguyên
function isNumberint($number,$range=[])
{
    /*
     * $range=['min_range=>1, max_range=>20'];
     * */
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumner = filter_var($number, FILTER_VALIDATE_INT, $options);
    } else {
        $checkNumner = filter_var($number, FILTER_VALIDATE_INT);
    }
    return $checkNumner;
}

// hàm kiểm tra số thực
function isNumberFloat($number,$range=[]){
    /*
    * $range=['min_range=>1, max_range=>20'];
    * */
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumner = filter_var($number, FILTER_VALIDATE_FLOAT, $options);
    } else {
        $checkNumner = filter_var($number, FILTER_VALIDATE_FLOAT);
    }
    return $checkNumner;
}

// hàm Kiểm tra số điện thoại( bắt đầu bằng số 0 tiếp theo là 9 số)
function isPhone($phone){
    $checkfistZero= false;
    if ($phone[0]=='0'){
        $checkfistZero=true;
        $phone=substr($phone,1);
    }
   $checkNumberLast=false;
    if (isNumberint($phone) && strlen($phone)==9){
        $checkNumberLast=true;
    }
    if ($checkfistZero && $checkNumberLast){
        return true;
    }
    return false;

}

// hàm tạo thông báo
function getMsg($msg,$type='success'){
    if (!empty($msg)){
        echo '<div class="alert alert-'.$type.' " >';
        echo $msg;
        echo '</div>';
    }
}

//Hàm chuyển hướng trang
function redirect($path= 'index.php'){
    header("Location: $path");
    exit();
}

// Hàm Thông báo lỗi
 function form_error($fieldName, $erros,$beforeHtml='',$affterHtml=''){
      return (!empty($erros[$fieldName]))?$beforeHtml.reset($erros[$fieldName]).$affterHtml:null;
 }

 // Hàm dữ liệu cũ(giữ lại dữ liệu khi đăng ký sai)
function old($fieldName,$oldData,$default=null){
    return (!empty($oldData[$fieldName]))?$oldData[$fieldName]:null;
}

// hàm kiểm tra trạng thái đăng nhập
function isLogin(){
    $checkLogin=false;
    if (getSession('login_token')){
        $tokenLogin=getSession('login_token');
        $queryToken=firstRaw("SELECT userId FROM login_token WHERE token='$tokenLogin'");
        if (!empty($queryToken)){
            //$checkLogin=true;
            $checkLogin=$queryToken;
        }else{
            removeSession('login_token');
        }
    }
    return $checkLogin;
}

//Hàm tự động xóa token nếu đăng xuất
function autoRemoveTokenlogin(){
    $allUsers=getRaw("SELECT*FROM users WHERE status=1");
    if (!empty($allUsers)){
        foreach ($allUsers as $user){
            $now=date('Y-m-d H:i:s');
            $before=$user['lastActivity'];
            $diff= strtotime($now)-strtotime($before) ;// tính thời gian
            $diff=floor($diff/60);
            if ($diff>=15){
                delete('login_token',"userid=".$user['id']);
            }
        }
    }
}
// Lưu lại thời gian cuối cùng hoạt đồng
function saveActivity(){
    $userId=isLogin()['userId'];
    update('users',['lastActivity'=>date('Y-m-d H:i:s')],"id=$userId");
}

// Lấy thống tin user
function getUserInfo($userId){
    $info=firstRaw("SElECT * FROM users WHERE id=$userId");
    return $info;
}

//hàm active menu sidebar
function activeMenuSidebar($module){
    if (getBody()['module']==$module){
        return true;
    }
    return false;
}