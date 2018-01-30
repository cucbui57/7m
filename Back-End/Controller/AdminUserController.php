<?php


class AdminUserController extends Controller
{
    public function ListAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $admin = new AdminUserModel();
        $this->view = $admin->loadListUser();
    }

    public function IndexAction()
    {

    }

    public function AddAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $admin = new AdminUserModel();
        $this->layout = $admin->getGroup();
        if (isset($_POST['userName'])) {
            $userName = $_POST['userName'];
            $userN = $_POST['name'];
            $pass = md5($_POST['pass']);
            $email = $_POST['email'];
            $group = $_POST['group'];
            echo $admin->signupDB($userName, $pass, $email, $userN, $group);;
        }
    }

    public function DeleteAction()
    {
        $id = $_GET['id'];
        $admin = new AdminUserModel();
        $admin->deleteUser($id);
    }

    public function EditAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $admin = new AdminUserModel();
        if (isset($_POST['name'])) {
            $user = $_POST['user'];
            $name = $_POST['name'];
            $pass = $_POST['pass'];
            $email = $_POST['email'];
            $group = $_POST['group'];
            if (!Check_Valid_Md5_String($pass)) {
                $pass = md5($pass);
            }
            $res = $admin->updateUser($user, $name, $email, $group, $pass);
            echo $res;
        } else {
            $id = $_GET['id'];
            $this->view = $admin->getUser($id);
            $this->layout = $admin->getGroup();
        }

    }

}