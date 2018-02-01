<?php


class ProductModel extends Model
{
    public function productDetail($id)
    {
        $sql = "SELECT id,ten_san_pham,gia,dia_chi,mo_ta,hinh_anh,khuyenmai FROM sanpham WHERE id = $id";
        $res = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($res);
    }

    public function listProductWithSameStore($id)
    {
        $sql = "SELECT id,ten_san_pham,gia,dia_chi,mo_ta,hinh_anh,khuyenmai FROM sanpham WHERE id_cua_hang = (SELECT id_cua_hang FROM sanpham WHERE id = $id)";
        $res = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    public function getListComment($trangThai, $id)
    {
        $sql = "SELECT binhluan.*,taikhoan.ten_dang_nhap FROM binhluan INNER JOIN taikhoan ON binhluan.id_tai_khoan = taikhoan.id WHERE id_san_pham = $id ORDER BY binhluan.thoi_gian_binh_luan ASC";
        $res = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);

    }

    public function addComment($comment, $id)
    {
        $user = $_SESSION['userLogin']['id'];
        $sql = "INSERT INTO binhluan(id_tai_khoan,id_san_pham,binh_luan) VALUES ($user,$id,'$comment')";
        $res = mysqli_query($this->conn, $sql);
    }
}