<?php

include "../core/DB.php";
$config = include '../core/config.php';
$db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
$this->db->updateRow('UPDATE users SET `online` = ? WHERE id = ?', ['0', $_SESSION['id']]);
session_destroy();
header('Location:/network3/main');
