<?php


class AdminUserModel extends Model
{
//Lấy danh sách tài khoản
    public function loadListUser()
    {
        $sql = "SELECT user.fullname,user.id,user.username,user.email,group_user.name FROM user INNER JOIN group_user ON user.id_group_user= group_user.id ORDER BY user.id ASC ";
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
        $sql = "SELECT COUNT(id) FROM user";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_row($res);
        return $row[0];
    }

//Xoá tài khoản
    public function deleteUser($id)
    {
        $sql = "DELETE FROM user WHERE id ='$id'";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return mysqli_error($this->conn);
        }
        return 'Đã xoá thành công';
    }

//Lấy thông tin tài khoản
    public function getUser($id)
    {
        $sql = "SELECT fullname,email,username,id_group_name,password FROM user WHERE id = $id";
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
        $sql = "SELECT * FROM group_user ORDER BY id ASC";
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
        $sql = "UPDATE user SET fullname= '$name',email='$email',id_group_name='$group',password='$pass' WHERE username= '$user'";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin tài khoản cần sửa: " . mysqli_errno($this->conn);
        }
        return 'Cập nhật thành viên thành công';
    }

//Thêm tài khoản
    public function signupDB($userName, $passWord, $email, $name, $group)
    {
        $sql = "SELECT * FROM user WHERE (username = '$userName') OR (email ='$email')";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            return "Đã tồn tại tên tài khoản " . $userName . " hoặc email " . $email;
        } else {
            $sql = "INSERT INTO user(username,password,email,fullname,id_group_name) VALUES ('$userName','$passWord','$email','$name',$group)";
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
        $sql = "SELECT name,email,username,id_user_name,password FROM user WHERE id_group_user= $id";
        $res = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($res);
    }
}