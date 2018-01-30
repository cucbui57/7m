<?php


class AdminGroupModel extends Model
{
    //Lấy danh sách các quyền
    public function listPermission()
    {
        $sql = "SELECT id,function_name FROM function ORDER BY id ASC ";
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
        $sql = "SELECT * FROM group_user ORDER BY id ASC";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return mysqli_errno($this->conn);
        }
        $row = mysqli_fetch_all($res);
        return $row;
    }

    public function getPermission($id)
    {
        $sql = "SELECT status,id_function FROM access WHERE id_group_name =$id";
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
            $sql = "INSERT INTO access (id_group_name,id_function,status) VALUES($idNhom, $idChucNang, $trangThai) ON DUPLICATE KEY UPDATE trang_thai = $trangThai";
            $res = mysqli_query($this->conn, $sql);
            if (mysqli_errno($this->conn)) {
                return mysqli_errno($this->conn);
            }
        }
        return 'Đã cập nhật thành công';
    }
}