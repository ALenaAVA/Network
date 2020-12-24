<?php

namespace app\controllers;

use app\controllers\AppController;

class MainController extends AppController
{
    public function indexAction()
    {
        $this->root('guests', function () {
            $title = 'Hello, InN';
            $this->set(compact('title'));
            $this->view = 'index';
        });
    }
}
