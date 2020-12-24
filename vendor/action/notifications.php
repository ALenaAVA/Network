<?php

use vendor\core\DB;
use vendor\core\User;

session_start();

if (!empty($_POST)) {

    include "../core/DB.php";
    include "../core/User.php";
    $config = include '../core/config.php';
    $user = new User();

    $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);

    if ($_POST['type'] == 'getCount') {
        $query = $db->getRow('SELECT count(id) FROM `notifications` WHERE `id_to` = ? AND `viewed` = ? ORDER BY `id` DESC', [$user->sess_id, 0]);
        echo json_encode($query['count(id)']);
    } elseif ($_POST['type'] == 'getList') {
        $query = $db->getRows('SELECT * FROM `notifications` WHERE `id_to` = ? AND  `viewed` = ? ORDER BY `id` DESC', [$user->sess_id,0]);
        echo json_encode($query);
    } elseif ($_POST['type'] == 'viewed') {
        $query = $db->updateRow('UPDATE `notifications` SET `viewed` = ? WHERE `viewed` = ? AND `id_to` = ?', [1, 0, $user->sess_id]);
        echo json_encode(['return' => 'success']);
    }
}

// 20:00
