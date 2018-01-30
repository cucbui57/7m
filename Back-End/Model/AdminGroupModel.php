<?php


class AdminGroupModel extends Model
{
    //Lấy danh sách các quyền
    public function listPermission()
    {
        $sql = "SELECT id,ten_chuc_nang FROM chucnang ORDER BY id ASC ";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return mysqli_errno($this->conn);
        }
        $row = mysqli_fetch_all($res);
        return $row;
    }

    //Lấy danh sách nhóm
    public function getGroup()
    {
        $sql = "SELECT * FROM nhomtaikhoan ORDER BY id ASC";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return mysqli_errno($this->conn);
        }
        $row = mysqli_fetch_all($res);
        return $row;
    }

    public function getPermission($id)
    {
        $sql = "SELECT trang_thai,id_chuc_nang FROM quyen WHERE id_nhom_tai_khoan =$id";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return mysqli_errno($this->conn);
        }
        $row = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $row;
    }

    public function updatePermission($result)
    {

        foreach ($result as $row) {
            $idNhom = $row['id_nhom'];
            $idChucNang = $row['id'];
            $trangThai = $row['check'];
            if ($trangThai === 'true') {
                $trangThai = 1;
            } else {
                $trangThai = 0;
            }
            $sql = "INSERT INTO quyen (id_nhom_tai_khoan,id_chuc_nang,trang_thai) VALUES($idNhom, $idChucNang, $trangThai) ON DUPLICATE KEY UPDATE trang_thai = $trangThai";
            $res = mysqli_query($this->conn, $sql);
            if (mysqli_errno($this->conn)) {
                return mysqli_errno($this->conn);
            }
        }
        return 'Đã cập nhật thành công';
    }
}