<?php
if (!defined('_INCODE')) die('Access define...');// câu lệnh chặn truy cập trực tiếp vào file
?>
<div class="" style="width: 600px;padding: 20px 30px;text-align: center;margin: 0 auto;">
    <h3>Lỗi liên quan đến CSDL</h3>
    <hr>
    <p><?php echo $exception->getMessage(); ?></p>
    <p> FILE: <?php echo $exception->getFile(); ?></p>
    <p>LINE: <?php echo $exception->getLine(); ?></p>
</div>


