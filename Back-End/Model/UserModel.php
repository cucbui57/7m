<?php


class UserModel extends Model
{
//Lấy sản phẩm từ DB
    public function loadIndex($row, $trangThai)
    {
        $sql = null;
        $sqlC = null;
        if ($trangThai == 0) {
            $sqlC = "SELECT COUNT(*) FROM sanpham";
            $sql = "SELECT id,ten_san_pham,gia,dia_chi,mo_ta,hinh_anh,khuyenmai FROM sanpham ORDER BY ten_san_pham ASC LIMIT $row,4";
        } else if ($trangThai >= 1 && $trangThai <= 4) {
            $sqlC = "SELECT COUNT(*) FROM sanpham WHERE id_danh_muc = $trangThai";
            $sql = "SELECT id,ten_san_pham,gia,dia_chi,mo_ta,hinh_anh,khuyenmai FROM sanpham WHERE id_danh_muc = $trangThai ORDER BY ten_san_pham ASC LIMIT $row,4";

        } else if ($trangThai == 5) {
            $sql = "SELECT id,ten_san_pham,gia,dia_chi,mo_ta,hinh_anh,khuyenmai FROM sanpham ORDER BY id DESC LIMIT $row,12";

        } else if ($trangThai == 6) {
            $sql = "SELECT sanpham.id,sanpham.ten_san_pham,sanpham.gia,sanpham.dia_chi,sanpham.mo_ta,sanpham.hinh_anh,sanpham.khuyenmai FROM giohang INNER JOIN sanpham ON giohang.id_san_pham = sanpham.id GROUP BY id_san_pham ORDER BY sum(so_luong) DESC LIMIT $row,12";
        }
        $res = mysqli_query($this->conn, $sql);

        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
        if ($sqlC != null) {
            $res2 = mysqli_query($this->conn, $sqlC);
            $data['count'] = mysqli_fetch_row($res2);
        } else {
            $res2 = 0;
            $data['count'] = 0;
        }
        return $data;
    }

//Đăng nhập vào DB
    public function loginDB($userName, $passWord)
    {
        $sql = "SELECT * FROM taikhoan WHERE ten_dang_nhap = '$userName'";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin tài khoản" . mysqli_error($this->conn);
        }
        if (mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            if ($row['mat_khau'] == md5($passWord)) {
                if ($row['id_nhom_tai_khoan'] == 3) {
                    $idTK = $row['id'];
                    $sql = "SELECT id FROM cua_hang WHERE id_tai_khoan = $idTK";
                    $res = mysqli_query($this->conn, $sql);
                    $row2 = mysqli_fetch_assoc($res);
                    $row['id_cua_hang'] = $row2['id'];
                }
                return $row;
            } else {
                return "Sai mật khẩu";
            }
        } else {
            return "Không tồn tại tài khoản " . $userName;
        }
    }

//Đăng ki tài khoản
    public function signupDB($userName, $passWord, $email, $name)
    {
        $sql = "SELECT * FROM taikhoan WHERE (ten_dang_nhap = '$userName') OR (email ='$email')";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            return "Đã tồn tại tên tài khoản " . $userName . " hoặc email " . $email;
        } else {
            $sql = "INSERT INTO taikhoan(ten_dang_nhap,mat_khau,email,ho_ten) VALUES ('$userName','$passWord','$email','$name')";
            if (mysqli_query($this->conn, $sql)) {
                $sql = "SELECT * FROM taikhoan WHERE ten_dang_nhap = '$userName'";
                $res = mysqli_query($this->conn, $sql);
                $row = mysqli_fetch_assoc($res);
                $_SESSION['userLogin'] = $row;
                echo "Đăng kí thành công";
            } else {
                echo mysqli_error($this->conn);
            }
        }
    }

    //Lấy danh sách nhóm hàng
    public function listGroupProduct()
    {
        $sql = "SELECT id,ten_danh_muc FROM danhmucsp ORDER BY id ASC";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return mysqli_errno($this->conn);
        }
        $row = mysqli_fetch_all($res);
        return $row;
    }
}