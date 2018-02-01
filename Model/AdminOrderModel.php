<?php


class AdminOrderModel extends Model
{
    public function loadList()
    {
        $sql = "SELECT id,ngay_gio_dat,ho_ten,dia_chi,dien_thoai,tong_tien,trang_thai FROM donhang";
        $res = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($res);
    }

    public function loadDetail($id)
    {
        $sql = "SELECT sp.ten_san_pham,gh.so_luong FROM giohang AS gh INNER JOIN sanpham AS sp ON gh.id_san_pham = sp.id INNER JOIN donhang AS dh ON dh.id = gh.id_gio_hang WHERE dh.id =$id";
        $res = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($res);
    }

    public function updateOrderStatus($id, $trangthai)
    {
        $sql = "UPDATE donhang SET trang_thai = $trangthai WHERE id =$id";
        mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return mysqli_error($this->conn);
        }
        return 'Đã cập nhật trạng thái đơn hàng thành công';
    }
}