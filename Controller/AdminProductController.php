<?php


class AdminProductController extends Controller
{
    public function listAction()
    {
        $admin = new AdminProductModel();
        $this->view = $admin->loadProduct();

    }

    public function DeleteAction()
    {
        $id = $_GET['id'];
        $admin = new AdminProductModel();
        $this->view = $admin->deleteProduct($id);
    }

    public function AddAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $admin = new AdminProductModel();
        $this->view['store'] = $admin->listStore();
        $this->view['groupProduct'] = $admin->listGroupProduct();
        if (isset($_POST['nameProduct'])) {
            $nameProduct = $_POST['nameProduct'];
            $price = $_POST['price'];
            $describe = $_POST['describe'];
            $address = $_POST['add'];
            $store = $_POST['store'];
            $groupFood = $_POST['group'];
            $discount = $_POST['discount'];
            $file = $_FILES['file'];
            echo $admin->addProduct($nameProduct, $price, $describe, $discount, $address, $store, $groupFood, $file);
        }
    }

    public function EditAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $admin = new AdminProductModel();
        $this->view['store'] = $admin->listStore();
        $this->view['groupProduct'] = $admin->listGroupProduct();
        if (isset($_POST['nameProduct'])) {
            $id = $_POST['id'];
            $nameProduct = $_POST['nameProduct'];
            $price = $_POST['price'];
            $describe = $_POST['describe'];
            $address = $_POST['add'];
            $store = $_POST['store'];
            $groupFood = $_POST['group'];
            $discount = $_POST['discount'];
            echo $admin->updateItem($id, $nameProduct, $price, $address, $discount, $store, $groupFood,$describe);
        } else {
            $id = $_GET['id'];
            $this->view['id'] = $admin->getItem($id);
        }
    }
}