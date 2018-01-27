<?php
session_start();

// Khai báo các đường dẫn tới thư mục
define('app_path', __DIR__);
define('layout_path', app_path . '/View/Layout/');
define('controller_path', app_path . '/Controller/');
define('model_path', app_path . '/Model/');

//Khởi chạy

require_once app_path . '/Core/app.php';
require_once app_path . '/libs/functions.php';
include app_path . '/Config/Config.php';

$app = new myMVC();
$app->run();

//Trong 10 phút mà không thực hiện xong đơn hàng
$inactive = 600;
if (!isset($_SESSION['timeout'])) {
    $_SESSION['timeout'] = time() + $inactive;
}
$session_life = time() - $_SESSION['timeout'];
if ($session_life > $inactive) {
    session_destroy();
}

$_SESSION['timeout'] = time();
