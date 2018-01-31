<?php


class CartModel extends Model
{
    public function loadItem($id)
    {
        $sql = "SELECT ten_san_pham,gia,khuyenmai,hinh_anh,mo_ta FROM sanpham WHERE id = $id";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return "Lỗi lấy thông tin sản phẩm";
        }
        $row = mysqli_fetch_assoc($res);
        return $row;
    }

    public function addItem($name, $address, $phone)
    {
        $tong = 0;
        $sql = "SELECT id FROM donhang ORDER BY id DESC LIMIT 1";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_row($res);
        $id = $row[0] + 1;
        foreach ($_SESSION['product'] as $key => $value) {
            $sl = $value['quantily'];
            $tong += ($value['gia'] - $value['khuyenmai']) * $sl;
            $sql = "INSERT INTO giohang(id_gio_hang,id_san_pham,so_luong) VALUES ($id,$key,$sl)";
            mysqli_query($this->conn, $sql);
            if (mysqli_error($this->conn)) {
                return mysqli_error($this->conn);
            }
        }
        $id = $_SESSION['userLogin']['id'];
        $sql = "INSERT INTO donhang(ho_ten,dia_chi,dien_thoai,tong_tien,id_tai_khoan) VALUES ('$name','$address','$phone',$tong,$id)";
        mysqli_query($this->conn, $sql);
        unset($_SESSION['product']);
        return 'Đã đặt hàng thành công';
    }
}