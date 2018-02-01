<?php


class AdminStoreController extends Controller
{
    public function ListAction()
    {
        $admin = new AdminStoreModel();
        $this->view = $admin->listStore();
    }

    public function DeleteAction()
    {
        $id = $_GET['id'];
        $admin = new AdminStoreModel();
        $admin->deleteStore($id);
    }

    public function AddAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $admin = new AdminStoreModel();
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $adress = $_POST['address'];
            $phone = $_POST['phone'];
            $idUser = $_POST['idUser'];
            echo $admin->signUpStore($name, $adress, $phone, $idUser);
        }
        $this->view['idUser'] = $admin->getAccountUser();
    }

    public function EditAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $admin = new AdminStoreModel();
        if (isset($_POST['name'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $adress = $_POST['address'];
            $phone = $_POST['phone'];
            $idUser = $_POST['idUser'];
            echo $admin->editStore($id, $name, $adress, $phone, $idUser);
        } else {
            $id = $_GET['id'];
            $this->view['data'] = $admin->getStore($id);
            $this->view['idUser'] = $admin->getAccountUser();
        }
    }
}