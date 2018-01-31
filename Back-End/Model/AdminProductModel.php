<?php


class AdminProductModel extends Model
{
    //Đếm số lượng sản phẩm
    public function countProduct()
    {
        $sql = null;
        if ($_SESSION['userLogin']['id_nhom_tai_khoan'] == 1) {
            $sql = "SELECT COUNT(id) FROM sanpham";
        } else {
            $idStore = $_SESSION['userLogin']['id_cua_hang'];
            $sql = "SELECT COUNT(id) FROM sanpham WHERE id_cua_hang = $idStore";

        }
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_row($res);
        return $row[0];
    }

//Lấy danh sách sản phẩm
    public function loadProduct()
    {
        $sql = null;
        if ($_SESSION['userLogin']['id_nhom_tai_khoan'] == 1) {
            $sql = "SELECT id,ten_san_pham,gia,dia_chi,mo_ta,ngay_thang,hinh_anh FROM sanpham";
        } else {
            $idStore = $_SESSION['userLogin']['id_cua_hang'];
            $sql = "SELECT id,ten_san_pham,gia,dia_chi,mo_ta,ngay_thang,hinh_anh FROM sanpham WHERE id_cua_hang = $idStore";
        }
        $res = mysqli_query($this->conn, $sql);
        $data = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    //Thêm sản phẩm
    public function addProduct($nameProduct, $price, $describe, $discount, $address, $store, $groupFood, $img)
    {
        try {

            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (!isset($img['error']) || is_array($img['error'])) {
                throw new RuntimeException('Invalid parameters.');
            }

            // Check $img['error'] value.
            switch ($img['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            // You should also check filesize here. 
            if ($img['size'] > 1000000) {
                throw new RuntimeException('Exceeded filesize limit.');
            }

            // DO NOT TRUST $img['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search($finfo->file($img['tmp_name']), array('jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif',), true)) {
                throw new RuntimeException('Invalid file format.');
            }

            // You should name it uniquely.
            // DO NOT USE $img['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
            $dir = sprintf('public/frontend/images/%s.%s', sha1_file($img['tmp_name']), $ext);
            if (!move_uploaded_file($img['tmp_name'], app_path . '/' . $dir)) {
                throw new RuntimeException('Failed to move uploaded file.');
            }

            $sql = "INSERT INTO sanpham(ten_san_pham,gia,dia_chi,mo_ta,khuyenmai,hinh_anh,id_cua_hang,id_danh_muc) VALUES ('$nameProduct',$price,'$address','$describe','$discount','$dir',$store,$groupFood)";
            $res = mysqli_query($this->conn, $sql);
            if (!mysqli_error($this->conn)) {
                throw new RuntimeException(mysqli_error($this->conn));
            }
            return 'Thêm sản phẩm thành công';
        } catch (RuntimeException $e) {

            return $e->getMessage();

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

    //Xoá sản phẩm
    public function deleteProduct($id)
    {
        $loc = "SELECT hinh_anh FROM sanpham WHERE id=$id";
        $res = mysqli_query($this->conn, $loc);
        $row = mysqli_fetch_all($res);
        foreach ($row as $item) {
            unlink($item[0]);
        }
        $sql = "DELETE FROM sanpham WHERE id ='$id'";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return mysqli_error($this->conn);
        }
        return 'Đã xoá thành công';
    }

    //Danh sách cửa hàng
    public function listStore()
    {
        $sql = "SELECT id,ten_cua_hang FROM cua_hang";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_error($this->conn)) {
            return mysqli_error($this->conn);
        }
        $row = mysqli_fetch_all($res);
        return $row;
    }

    //Lấy thôn tin sản phẩm
    public function getItem($id)
    {
        $sql = "SELECT id,ten_san_pham,gia,mo_ta,dia_chi,khuyenmai,id_danh_muc,id_cua_hang FROM sanpham WHERE id = $id";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin sản phẩm cần sửa: " . mysqli_errno($this->conn);
        }
        if (mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            return $row;
        }
    }

    //Sửa sản phẩm
    public function updateItem($id, $nameProduct, $price, $address, $discount, $store, $groupFood, $describe)
    {
        $sql = "UPDATE sanpham SET ten_san_pham ='$nameProduct',gia = $price,dia_chi = '$address',mo_ta='$describe',khuyenmai =$discount,id_cua_hang=$store,id_danh_muc = $groupFood WHERE id = $id";
        $res = mysqli_query($this->conn, $sql);
        if (mysqli_errno($this->conn)) {
            return "Lỗi lấy thông tin sản phẩm cần sửa: " . mysqli_errno($this->conn);
        }
        return 'Sửa sản phẩm thành công';
    }
}
