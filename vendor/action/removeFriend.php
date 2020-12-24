<?php

use vendor\core\DB;
use vendor\core\User;

session_start();
if (!empty($_POST)) {
    include "../core/DB.php";
    include "../core/User.php";

    $config = include '../core/config.php';
    $user = new User($_POST['login']);

    $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
    $query = $db->getRow('SELECT `status` FROM `friends` WHERE (`id_user_1` = ? AND `id_user_2` = ?) OR (`id_user_1` = ? AND `id_user_2` = ?)', [$user->sess_id, $user->id, $user->id, $user->sess_id]);

    if ($_POST['type'] == "remove") {

        if ($query['status'] == '2') {
            $query = $db->deleteRow('DELETE FROM `friends` WHERE  (`id_user_1` = ? AND `id_user_2` = ?) OR (`id_user_1` = ? AND `id_user_2` = ?)', [$user->sess_id, $user->id, $user->id, $user->sess_id]);
            echo json_encode(['return' => 'success']);
        }
    }
}
