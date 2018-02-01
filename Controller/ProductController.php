<?php


class ProductController extends Controller
{
    public function IndexAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $user = new ProductModel();
        if (isset($_REQUEST['id'])) {
            $this->view = $user->productDetail($_REQUEST['id']);
        }
    }

    public function ListAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $user = new ProductModel();
        if (isset($_REQUEST['id'])) {
            echo json_encode($user->listProductWithSameStore($_REQUEST['id']), JSON_UNESCAPED_UNICODE);
        }
    }

    public function CommentAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        if (isset($_REQUEST['trangthai'])) {
            $user = new ProductModel();
            //  echo $user->getListComment($_REQUEST['trangthai'], $_REQUEST['id']);
            echo json_encode($user->getListComment($_REQUEST['trangthai'], $_REQUEST['id']), JSON_UNESCAPED_UNICODE);
        }
    }

    public function AddCommentAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        try {
            if (!isset($_SESSION['userLogin'])) {
                throw new Exception('Vui lòng đăng nhập', 123);
            } else {
                $user = new ProductModel();
                $user->addComment($_REQUEST['comment'], $_REQUEST['id']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}