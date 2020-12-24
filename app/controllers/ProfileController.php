<?php

namespace app\controllers;

use vendor\core\base\Controller;
use vendor\core\User;
use app\controllers\AppController;

class ProfileController extends AppController
{

    public function userAction()
    {
        $this->root('authorized', function () {
            $l = substr($_SERVER['REDIRECT_URL'], 11);
            $this->lastVisit();
            $db = $this->db;
            $user = $this->user = new User($l);
            $page = 'Главная';
            $title = $this->user->name() . ' ' . $this->user->surname();
            $this->set(compact('title', 'user', 'page', 'db'));
            $this->layout = 'user';
        });
    }

    public function editAction()
    {
        $this->root('authorized', function () {
            //$l = substr($_SERVER['REDIRECT_URL'], 11);
            
            $this->lastVisit();
            $db = $this->db;
            $user = $this->user = new User();
            $user->id = $user->sess_id;
            $page = 'Редактирование';
            $title = $this->user->name() . ' ' . $this->user->surname();
            $this->set(compact('title', 'user', 'page', 'db'));
            $this->layout = 'user';
        });
    }

    public function friendsAction()
    {
        $this->root('authorized', function () {
            $l = substr($_SERVER['REDIRECT_URL'], 11);
            $this->lastVisit();
            $user = $this->user = new User($l);
            $title = 'Cписок друзей';
            $page = 'Друзья';
            $this->set(compact('title', 'user', 'page'));
            $this->layout = 'user';
            $this->view = 'friends';
        });
    }

    public function foundFriendsAction()
    {
        $this->root('authorized', function () {
            $l = substr($_SERVER['REDIRECT_URL'], 11);
            $this->lastVisit();
            $user = $this->user = new User($l);
            $title = 'Поиск друзей';
            $page = 'Результаты';
            $this->set(compact('title', 'user', 'page'));
            $this->layout = 'user';
            $this->view = 'foundFriends';
        });
    }
}
