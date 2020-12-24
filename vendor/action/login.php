<?php

use vendor\core\DB;

session_start();

if (!empty($_POST)) {

    include "../core/DB.php";
    $config = include '../core/config.php';
    $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
    if ($db) {
        $query = $db->getRow('SELECT `password`,`id` FROM `users` WHERE `login` = ? ', [$_POST['login']]);
     
        if (password_verify($_POST['password'], $query['password'])) {
            $_SESSION['id'] = $query['id'];
            $_SESSION['login'] = $_POST['login'];
            echo json_encode(['return' => 'success', 'login' => $_POST['login']]);
        } else {
            echo json_encode(['return' => 'error']);
        }
    } else {
        echo json_encode(['return' => 'error: db connect']);
    }
} else {
    echo json_encode(['return' => 'error: array is empty']);
}

//44:48 #1
