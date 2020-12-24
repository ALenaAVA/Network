<?php

use vendor\core\DB;

session_start();
include "../core/DB.php";
$config = include '../core/config.php';
$db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);

if (!empty($_POST)) {
    $user = explode(' ', $_POST['name']);
    $name = $user[0];
    $surname = $user[1];
    $user = $db->getRow('SELECT * FROM `users` WHERE `id` = ?', [$_SESSION['id']]);
 
    if ($_POST['name'] != "" && ($user['name'] != $name || $user['surname'] != $surname)) {
        $query = $db->insertRow("UPDATE `users` SET `name` = ?,`surname`=? WHERE id = ?", [$name, $surname, $_SESSION['id']]);
    }
    if ($_POST['day'] != $user['birthday'] || $_POST['month'] != $user['birthmonth'] || $_POST['year'] != $user['birthyear']) {
        $query = $db->insertRow("UPDATE `users`SET `birthday` = ?,`birthmonth` = ?,`birthyear` =?  WHERE id = ?", [$_POST['day'], $_POST['month'], $_POST['year'], $_SESSION['id']]);
    }
    if ($_POST['sex'] != $user['sex']) {
        $query = $db->insertRow("UPDATE `users`SET`sex`= ?  WHERE id = ?", [$_POST['sex'], $_SESSION['id']]);
    }
    $userPassword = "";
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (!password_verify($_POST['password'], $user['password']) && $_POST['password'] != "") {
        $query = $db->insertRow("UPDATE `users` SET`password` = ? WHERE id = ?", [$password, $_SESSION['id']]);
    }
    echo json_encode(['return' => 'success', 'login' => $user['login']]);
} else {
    echo json_encode(['return' => 'error array is empty']);
}
