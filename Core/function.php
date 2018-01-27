<?php
/**
 * Hàm này chuyển chuỗi tham số thành tên controller hoặc tên action. Tên hàm viết sao cho dễ nhớ thôi.
 * @param $string
 * @return string
 *
 */

function convertUpperActionAndControllerName($string)
{
    // $string có dạng: admin-group-user
    $tmp = str_replace('-', ' ', $string);
    // kết quả lệnh trên:  admin group user

    // thay thế dấu - thành dấu cách để chuyển các ký tự đầu thành chữ in hoa:
    $tmp = ucwords($tmp);
    // hàm này sẽ tìm toàn bộ các từ (phân biệt bởi dấu cách, thay thế kí tự đầu tiên của từ thành chữ in hoa)
    // kết quả lệnh trên:  Admin Group User

    $tmp = str_replace(' ', '', $tmp); // việc này sẽ xóa hết dấu cách trở thành 1 chuỗi liền
    // kết quả lệnh trên:  AdminGroupUser

    return $tmp;
    // trả về chuỗi vừa xử lý xong
}

function Check_Valid_Md5_String($md5 = '')
{
    if (empty($md5)) return false;
    return preg_match('/^[a-f0-9]{32}$/', $md5);
}

?>
