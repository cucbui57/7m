<?php
//Kết nối tới Database
$conn = mysqli_connect('localhost', 'root', '', 'banhangdadung', 3306);

//Kết nối thất bại báo lỗi
if (mysqli_errno($conn)) {
    echo 'Kết nối tới Database thất bại';
    die();
}

mysqli_set_charset($conn, 'utf8');

$GLOBALS['conn'] = $conn;