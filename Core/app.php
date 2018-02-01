<?php

function __autoload($className)
{
    // Nếu 1 class được gọi bởi từ khóa new không tồn tại
    // thứ tự: ưu tiên controller trước, model, các file khác
    //1. Kiểm tra có file file là controller không?
    $file_path = controller_path . '/' . $className . '.php';
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        //2. kiểm tra đến model
        $file_path = model_path . '/' . $className . '.php';
        if (file_exists($file_path)) {
            require_once $file_path;
        } else {
            // kiểm tra thư mục core
            $file_path = __DIR__ . '/' . $className . '.php';
            if (file_exists($file_path)) {
                require_once $file_path;
            } else {
                die("Class name <b>$className</b> not found!");
            }
        }
    }
}

function getDbConnection()
{
    if (!empty($GLOBALS['conn'])) return $GLOBALS['conn']; else {
        $conn = null;
        require app_path . '/Config/connectDB.php';
        return $conn;
    }
}

class myMVC
{
    public function run()
    {
        //Lấy tham số trên URL
        $controller = isset($_GET['controller']) ? $_GET['controller'] : 'index';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        $GLOBALS['current_controller'] = $controller;
        $GLOBALS['current_action'] = $action;
        //Kiểm tra quyền truy cập

        //Convert Tên Controller và Action
        $controllerClass = convertUpperActionAndControllerName($controller) . 'Controller';
        $actionName = convertUpperActionAndControllerName($action) . 'Action';

        //Tạo mới Object Class
        $objectController = new $controllerClass();
//        if (!$this->checkAction($controller, $action)) {
//            echo '<b>Bạn không có quyền sử dụng chức năng này</b>';
//            exit();
//        }
        if (!method_exists($objectController, $actionName)) {
            die("Action $actionName Not Found");
        }
        $objectController->currentController = $controller;
        $objectController->currentAction = $action;
        $objectController->$actionName();

        if (empty($objectController->disable_layout)) {
            $objectController->renderLayout();
        }
    }

    /**
     * Hàm này để kiểm tra quyền sử dụng
     */
    function checkAction($controller, $action)
    {
        $strCheck = $controller . '_' . $action;
        //String có dạng index_index
        $defaultAllow = array('index_index', 'index_login', 'index_signin', 'index_logout', 'cart_add', 'cart_delete', 'cart_cart', 'cart_edit', 'cart_pay', 'product_index', 'product_list', 'product_comment', 'product_addcomment');
        //Luôn luôn cho phép truy cấp vào các trang mặc định.
        if (in_array($strCheck, $defaultAllow)) {
            return true;
        }
        //Kiểm tra xem tài khoản đã đăng nhập chưa
        if (empty($_SESSION['userLogin'])) {
            return false;
        }
        //
        if (empty($_SESSION['userLogin']['permission'])) {
            require_once app_path . '/Config/connectDB.php';
            $id_nhom = $_SESSION['userLogin']['id_nhom_tai_khoan'];
            $sql = "SELECT * FROM access INNER JOIN function ON access.id_function = function.id WHERE access.id_group_name = $id_nhom AND acess.status = 1";
            $res = mysqli_query(getDbConnection(), $sql);
            $auth = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $auth[] = $row['link'];
            }
            $_SESSION['userLogin']['permissionAllow'] = $auth;
        }
        if (in_array($strCheck, $_SESSION['userLogin']['permissionAllow'])) {
            return true;
        }
        return false;
    }


}