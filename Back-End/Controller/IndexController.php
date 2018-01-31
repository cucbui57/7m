<?php


class IndexController extends Controller
{
    public function IndexAction()
    {
        if (isset($_GET['ajax'])) {
        $this->disable_layout = 1;
    }
        $user = new UserModel();
        if (isset($_REQUEST['trangthai'])) {
            echo json_encode($user->loadIndex($_REQUEST['row'], $_REQUEST['trangthai']), JSON_UNESCAPED_UNICODE);
        }
    }

    public function LoginAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        if (isset($_SESSION['userLogin'])) {
            header('Location : index.php');
            exit();
        }
        if (isset($_POST['userName'])) {
            $userName = $_POST['userName'];
            $passWord = $_POST['passWord'];
            $user = new UserModel();
            $res = $user->loginDB($userName, $passWord);
            if (is_array($res)) {
                unset($passWord);
                $_SESSION['userLogin'] = $res;
            } else {
                echo $res;
            }
        }
    }

    public function LogoutAction()
    {
        unset($_SESSION['userLogin']);
        header("Location: index.php");
    }

    public function SigninAction()
    {
        if (isset($_REQUEST['ajax'])) {
            $this->disable_layout = 1;
        }
        if (isset($_POST['userName'])) {
            $userName = $_POST['userName'];
            $userN = $_POST['name'];
            $pass = md5($_POST['pass']);
            $email = $_POST['email'];
            $user = new UserModel();
            $res = $user->signupDB($userName, $pass, $email, $userN);
            echo $res;
        }
    }


}