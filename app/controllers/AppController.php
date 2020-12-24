<?php

namespace app\controllers;

use DateTime;
use DateTimeZone;
use vendor\core\base\Controller;
use vendor\core\DB;
use vendor\core\User;

class AppController extends Controller
{
    public $db, $config, $user, $pageaJSON, $id;

    public function __construct($route)
    {
        parent::__construct($route);
        $this->config = include 'vendor/core/config.php';
        $this->db = new DB(
            $this->config['DB']['name'],
            $this->config['DB']['user'],
            $this->config['DB']['pass'],
            $this->config['DB']['host'],
            $this->config['DB']['type']
        );
    }
    protected function lastVisit()
    {
        $d = new DateTime('', new DateTimeZone('Europe/Riga'));
        $d->format('d.m.Y H:i');
        $l = substr($_SERVER['REDIRECT_URL'], 11);
        $this->user = new User($l);
        if ($this->user->sess_id == $this->user->id && $this->user->lastVisit() != 'Online') {
            $this->db->updateRow('UPDATE users SET `online` = ? WHERE id = ?', ['1', $this->user->sess_id]);
        }
        //$this->user->online();
        $this->db->updateRow('UPDATE users SET lastVisit = ? WHERE id = ?', [$d->format('d.m.Y H:i'), $this->user->sess_id]);
    }
}
