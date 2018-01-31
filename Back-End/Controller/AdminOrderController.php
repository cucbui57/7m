<?php


class AdminOrderController extends Controller
{
    public function ListAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $user = new AdminOrderModel();
        $this->view = $user->loadList();
        if (isset($_REQUEST['id'])) {
            if (!isset($_REQUEST['trangthai'])) {
                echo json_encode($user->loadDetail($_REQUEST['id']));
            } else {
                echo $user->updateOrderStatus($_REQUEST['id'], $_REQUEST['trangthai']);
            }
        }
    }
}