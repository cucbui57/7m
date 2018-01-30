<?php

class Controller
{
    public $currentController = null;
    public $currentAction = null;
    protected $view = array();
    protected $layout = array();

    public function renderLayout()
    {
        $checkController = substr($this->currentController, 0, 5);
        if ($checkController == 'admin') {
            if (file_exists(layout_path . 'admin.phtml')) {
                require_once layout_path . 'admin.phtml';
            } else {
                echo '<b>Layout Admin Not Found</b>';
                exit();
            }
        } else if ($this->currentController == 'cart') {
            if (file_exists(layout_path . 'cart.phtml')) {
                require_once layout_path . 'cart.phtml';
            } else {
                echo '<b>Layout Public Not Found</b>';
                exit();
            }
        } else if ($this->currentController == 'product') {
            if (file_exists(layout_path . 'product.phtml')) {
                require_once layout_path . 'product.phtml';
            } else {
                echo '<b>Layout Public Not Found</b>';
                exit();
            }
        } else {
            if (file_exists(layout_path . 'master.phtml')) {
                require_once layout_path . 'master.phtml';
            } else {
                echo '<b>Layout Public Not Found</b>';
                exit();
            }
        }
    }

    private function showContent()
    {
        $file_view_path = app_path . '/View/' . convertUpperActionAndControllerName($this->currentController) . '/' . ($this->currentAction) . '.phtml';

        if (file_exists($file_view_path)) require_once $file_view_path; else {
            echo 'File view ' . strtolower($this->currentAction) . '.phtml not found!';
            exit();
        }

    }

}