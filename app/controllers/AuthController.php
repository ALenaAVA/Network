<?php

namespace app\controllers;

use app\controllers\AppController;

class AuthController extends AppController
{

    public function registAction()
    {
        $this->root('guests', function () {
            $title = 'Регистрация';
            $this->set(compact('title'));
            $this->view = 'regist';
            $this->layout = 'auth';
        });
    }

    public function confirmAction()
    {
        $this->root('guests', function () {
            $title = 'Подтвердите Email';
            $this->set(compact('title'));
            $this->view = 'confirm';
            $this->layout = 'auth';
        });
    }

    public function finishAction()
    {
        $this->root('guests', function () {
            $title = 'Завершение регистрации';
            $this->set(compact('title'));
            $this->view = 'finish';
            $this->layout = 'auth';
        });
    }

    public function loginAction()
    {
        $this->root('guests', function () {
            $title = 'Авторизация';
            $this->set(compact('title'));
            $this->view = 'login';
            $this->layout = 'auth';
        });
    }

    public function exitAction()
    {
        $this->root('authorized', function () {
            $this->view = 'exit';
        });
    }
}
