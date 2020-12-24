<?php

namespace app\controllers;

use vendor\core\base\Controller;
use vendor\core\User;
use app\controllers\AppController;

class AdminController extends AppController
{
    public function indexAction()
    {
        $this->root('admin', function () {
            $l = substr($_SERVER['REDIRECT_URL'], 11);
            $this->lastVisit();
            $db = $this->db;
            $user = $this->user = new User($l);
            $page = 'Панель администратора';
            $title = $this->user->name() . ' ' . $this->user->surname();
            $this->set(compact('title', 'user', 'page', 'db'));
            $this->layout = 'admin';
        });
    }
    public function censureAction()
    {
        $this->root('admin', function () {
            $l = substr($_SERVER['REDIRECT_URL'], 11);
            $this->lastVisit();
            $db = $this->db;
            $user = $this->user = new User($l);
            $page = 'Жалобы пользователей';
            $title = $this->user->name() . ' ' . $this->user->surname();
            $this->set(compact('title', 'user', 'page', 'db'));
            $this->layout = 'admin';
        });
    }
    public function censurePhotoAction()
    {
        $this->root('admin', function () {
            $l = substr($_SERVER['REDIRECT_URL'], 11);
            $this->lastVisit();
            $db = $this->db;
            $user = $this->user = new User($l);
            $page = 'Добавленные фотографии';
            $title = $this->user->name() . ' ' . $this->user->surname();
            $this->set(compact('title', 'user', 'page', 'db'));
            $this->layout = 'admin';
        });
    }
    public function addAdminAction()
    {
        $this->root('super-admin', function () {
            $l = substr($_SERVER['REDIRECT_URL'], 11);
            $this->lastVisit();
            $db = $this->db;
            $user = $this->user = new User($l);
            $page = 'Добавить администратора';
            $title = $this->user->name() . ' ' . $this->user->surname();
            $this->set(compact('title', 'user', 'page', 'db'));
            $this->layout = 'admin';
            $this->view = 'addAdmin';
        });
    }
}
