<?php


class AdminUserModel extends Model
{
//Lấy danh sách tài khoản
    public function loadListUser()
    {
        $sql = "SELECT taikhoan.ho_ten,taikhoan.id,taikhoan.ten_dang_nhap,taikhoan.email,nhomtaikhoan.ten_nhom FROM taikhoan INNER JOIN nhomtaikhoan ON taikhoan.id_nhom_tai_khoan = nhomtaikhoan.id ORDER BY taikhoan.id ASC ";
        $res = mysqli_query($this->conn, $sql);
        $data = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

//Lấy số lượng tải khoản
    public function countUser()
    {
        $sql = "SELECT COUNT(id) FROM taikhoan";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_row($res);
        return $row[0];
    }

//Xoá tài khoản
    public function deleteUser($id)
    {
        $sql = "DELETE FROM taikhoan WHERE id ='$id'";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return mysqli_error($this->conn);
        }
        return 'Đã xoá thành công';
    }

//Lấy thông tin tài khoản
    public function getUser($id)
    {
        $sql = "SELECT ho_ten,email,ten_dang_nhap,id_nhom_tai_khoan,mat_khau FROM taikhoan WHERE id = $id";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin tài khoản cần sửa: " . mysqli_errno($this->conn);
        }
        if (mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            return $row;
        } else {
            return 'Không tồn tại nhóm có ID là ' . $id;
        }
    }

//Lấy thông tin nhóm tài khoản
    public function getGroup()
    {
        $sql = "SELECT * FROM nhomtaikhoan ORDER BY id ASC";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin tài khoản cần sửa: " . mysqli_errno($this->conn);
        }
        $row = mysqli_fetch_all($res);
        return $row;
    }

//Cập nhật thông tin tài khoản
    public function updateUser($user, $name, $email, $group, $pass)
    {
        $sql = "UPDATE taikhoan SET ho_ten = '$name',email='$email',id_nhom_tai_khoan ='$group',mat_khau='$pass' WHERE ten_dang_nhap = '$user'";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin tài khoản cần sửa: " . mysqli_errno($this->conn);
        }
        return 'Cập nhật thành viên thành công';
    }

//Thêm tài khoản
    public function signupDB($userName, $passWord, $email, $name, $group)
    {
        $sql = "SELECT * FROM taikhoan WHERE (ten_dang_nhap = '$userName') OR (email ='$email')";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            return "Đã tồn tại tên tài khoản " . $userName . " hoặc email " . $email;
        } else {
            $sql = "INSERT INTO taikhoan(ten_dang_nhap,mat_khau,email,ho_ten,id_nhom_tai_khoan) VALUES ('$userName','$passWord','$email','$name',$group)";
            if (mysqli_query($this->conn, $sql)) {
                echo "Đăng kí thành công";
            } else {
                echo mysqli_error($this->conn);
            }
        }
    }

//Xem danh sách tài khoản theo nhóm tài khoản
    public function getUserByGroup($id)
    {
        $sql = "SELECT ho_ten,email,ten_dang_nhap,id_nhom_tai_khoan,mat_khau FROM taikhoan WHERE id_nhom_tai_khoan = $id";
        $res = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($res);
    }
}