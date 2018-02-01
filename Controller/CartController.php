<?php


class CartController extends Controller
{
    public function CartAction()
    {
    }

    public function AddAction()
    {
        if ($_GET['ajax'] = 1) {
            $this->disable_layout = 1;
        }
        if ($_POST['id']) {
            $id = $_POST['id'];
            if (isset($_SESSION['product'][$id])) {
                $_SESSION['product'][$id]['quantily']++;
            } else {
                $it = new CartModel();
                $item = $it->loadItem($id);
                $_SESSION['product'][$id]['ten'] = $item['ten_san_pham'];
                $_SESSION['product'][$id]['gia'] = $item['gia'];
                $_SESSION['product'][$id]['khuyenmai'] = $item['khuyenmai'];
                $_SESSION['product'][$id]['hinh_anh'] = $item['hinh_anh'];
                $_SESSION['product'][$id]['mo_ta'] = $item['mo_ta'];
                $_SESSION['product'][$id]['quantily'] = 1;
            }
            echo 'Thêm sản phẩm vào giỏ hàng thành công';
        }
    }

    public function DeleteAction()
    {
        if ($_GET['ajax'] = 1) {
            $this->disable_layout = 1;
        }
        if ($_POST['id']) {
            $id = $_POST['id'];
            unset($_SESSION['product'][$id]);
        }
    }

    public function EditAction()
    {
        if ($_GET['ajax'] = 1) {
            $this->disable_layout = 1;
        }
        if ($_POST['id']) {
            $id = $_POST['id'];
            $quantity = $_POST['sl'];
            $_SESSION['product'][$id]['quantily'] = $quantity;
        }
    }

    public function PayAction()
    {
        if ($_GET['ajax'] = 1) {
            $this->disable_layout = 1;
        }
        $user = new CartModel();
        if ($_POST['name']) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            echo $user->addItem($name, $address, $phone);
        }
    }
}