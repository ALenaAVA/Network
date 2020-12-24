<?php

use vendor\core\DB;

session_start();

include "../core/DB.php";
$config = include '../core/config.php';
$db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
$db->updateRow('UPDATE users SET `online` = ? WHERE id = ?', ['0', $_SESSION['id']]);
if (session_destroy())
    echo json_encode(['return' => 'success']);
else
    echo json_encode(['return' => 'error']);
