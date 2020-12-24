<?php

namespace vendor\core\base;

class View
{
    public
        $route = [],
        $view,
        $layout;

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        if ($this->layout===false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view=$view;
    }

    public function render($vars)
    {
        if (is_array($vars)) extract($vars);
        $file_view ="app/views/{$this->route['controller']}/{$this->view}.php";
        //debug($file_view);
        ob_start();
        if (is_file($file_view)) {
            require $file_view;
        } else {
            echo "Не найден вид <p><b>{$file_view}</b></p>";
        }
        $content = ob_get_clean();

        if (false !== $this->layout) {
            $file_layout = 'app/views/layouts/' . $this->layout . '.php';
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                echo "Не найден шаблон <p><b>{$file_layout}</b></p>";
            }
        }
    }
}
