<?php


class AdminGroupController extends Controller
{
    public function PermissionAction()
    {
        if (isset($_GET['ajax'])) {
            $this->disable_layout = 1;
        }
        $admin = new AdminGroupModel();
        $this->view['group'] = $admin->getGroup();
        $this->view['perList'] = $admin->listPermission();
        if (isset($_POST['id'])) {
            echo json_encode($admin->getPermission($_POST['id']), JSON_UNESCAPED_UNICODE);
        }
        if (isset($_POST['content'])) {
            $result = json_decode($_POST['content'], TRUE);
            echo $admin->updatePermission($result);
        }
    }
}