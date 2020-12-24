<?php

session_start();
use vendor\core\DB;
use vendor\core\User;

include "../core/DB.php";

$config = include '../core/config.php';
$db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);


if ($_POST['type'] == 'cancel') {

    $id = $_POST['id'];
    $query = $db->deleteRow("DELETE FROM `attachments` WHERE `id` = ?", [$id]);

    echo json_encode(['return'=>'success']);
 
} elseif ($_POST['type'] == 'check') {


    $id = $_POST['id'];
    $query = $db->updateRow("UPDATE `attachments` SET `checkPhoto` = ? WHERE `attachments`.`id` = ?", [1,$id]);

    echo json_encode(['return'=>'success']);
}
