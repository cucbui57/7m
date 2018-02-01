<?php


class AdminStoreModel extends Model
{
    public function listStore()
    {
        $sql = "SELECT * FROM cua_hang";
        $res = mysqli_query($this->conn, $sql);
        $data = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function countStore()
    {
        $sql = "SELECT COUNT(id) FROM cua_hang";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_row($res);
        return $row[0];
    }

    public function deleteStore($id)
    {
        $sql = "DELETE FROM cua_hang WHERE id ='$id'";
        $res = mysqli_query($this->conn, $sql);
        $sql = "SELECT hinh_anh FROM sanpham WHERE id_cua_hang ='$id'";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_row($res);
        foreach ($row as $item) {
            unlink($item[0]);
        }
        $sql = "DELETE FROM sanpham WHERE id_cua_hang ='$id'";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return mysqli_error($this->conn);
        }
        return 'Đã xoá thành công';
    }

    public function signUpStore($name, $adress, $phone, $idUser)
    {
        $sql = "INSERT INTO cua_hang(ten_cua_hang,dia_chi,sdt,id_tai_khoan) VALUES ('$name','$adress',$phone,$idUser)";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return mysqli_error($this->conn);
        }
        return 'Đã thêm cửa hàng thành công';
    }

    public function editStore($id, $name, $addres, $phone, $idUser)
    {
        $sql = "UPDATE cua_hang SET ten_cua_hang = '$name',dia_chi='$addres',sdt=$phone,id_tai_khoan=$idUser WHERE id = '$id'";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin tài khoản cần sửa: " . mysqli_errno($this->conn);
        }
        return 'Cập nhật cửa hàng thành công';
    }

    public function getAccountUser()
    {
        $sql = "SELECT id,ten_dang_nhap,ho_ten FROM taikhoan WHERE id_nhom_tai_khoan = 3";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return mysqli_error($this->conn);
        }
        return mysqli_fetch_all($res);
    }

    public function getStore($id){
        $sql = "SELECT * FROM cua_hang WHERE id = $id";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin cửa hàng cần sửa: " . mysqli_errno($this->conn);
        }
        if (mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            return $row;
        } else {
            return 'Không tồn tại nhóm có ID là ' . $id;
        }
    }
}