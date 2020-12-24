<?php
session_start();
use vendor\core\DB;
use vendor\core\User;

include "../core/DB.php";

$config = include '../core/config.php';
$db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);


if (!empty($_POST['text'])) {
    $text = strip_tags($_POST['text']);
    $query = $db->getRows("SELECT * FROM `users` WHERE MATCH (name,surname) AGAINST(? IN BOOLEAN MODE)", ['+'.$text]);
    $_SESSION['search'] = $query;
    echo json_encode($query);
}
