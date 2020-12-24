<?php

namespace vendor\core;

use vendor\core\DB;

class Admin
{
    protected $db, $config;
    public function __construct()
    {
        $this->connect();
    }
    protected function connect()
    {
        $this->config = include 'config.php';
        $this->db = new DB(
            $this->config['DB']['name'],
            $this->config['DB']['user'],
            $this->config['DB']['pass'],
            $this->config['DB']['host'],
            $this->config['DB']['type']
        );
    }

    public function getUnverifiedPhotos()
    {
        $q = $this->db->getRows("SELECT * FROM `attachments` WHERE `checkPhoto` = ?", [0]);
        return $q;
    }
}
