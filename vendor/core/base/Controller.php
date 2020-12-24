<?php

namespace vendor\core\base;

use vendor\core\base\View;
use vendor\core\User;

abstract class Controller
{
    public
        $route = [],
        $view,
        $layout,
        $vars,
        $module,
        $user;

    public function __construct($route)
    {

        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    public function set($vars)
    {
        $this->vars = $vars;
    }

    protected function root($root, $func)
    {

        $this->user = new User();
        switch ($root) {

            case 'authorized':
                if (empty($this->user->sess_id)) {
                    header("Location:" . WWW . "/login");
                } else {
                    $func();
                }
                break;
            case 'super-admin':
                if (!empty($this->user->sess_id) && $this->user->sess_userRole() == 2) {
                   // header("Location:" . WWW . "/add-admin");
                   $func();
                } else {
                    header("Location: @" . $this->user->sess_login());
                }
                break;
            case 'admin':
                if (!empty($this->user->sess_id) && $this->user->sess_userRole() != 0) {
                   $func();
                } else {
                   // header("Location:" . WWW . "/login");
                    header("Location:" . WWW . "/@" . $this->user->sess_login());
                }
                break;
            case 'guests':
                if (!empty($this->user->sess_id)) {
                    header("Location:" . WWW . "/@" . $this->user->sess_login());
                } else {
                    $func();
                }
                break;
            case 'all':
                $func();
                return 0;
                break;
                // case 'admin': # code... break;
        }
    }
}
