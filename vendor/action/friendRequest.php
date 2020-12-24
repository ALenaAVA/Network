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
    
    $date = date('d.m.Y');
    $time = date('H:i');
    
    if (empty($query['status'])) 
    {
        $text = 'Пользователь <a class="pjax-page-link" onclick="go(this, event,function(){$(\'#notifications .list\').html(\'\')})" href = "/network3/@' . $user->sess_login() . '">' . $user->sess_name() . ' ' . $user->sess_surname() . '</a> хочет добавить Вас в друзья.';
        
        $query = $db->insertRow('INSERT INTO `friends` (`id_user_1`, `id_user_2`,`status`) VALUES (?,?,?)', [$user->sess_id, $user->id, 1]);
        $notif = $db->insertRow('INSERT INTO `notifications` (`id_from`, `id_to`,`text`,`date`,`time`) VALUES (?,?,?,?,?)', [$user->sess_id, $user->id, $text, $date, $time]);

        echo json_encode(['return' => 'success']);
    } 
    elseif ($query['status'] == 3) 
    {
        $query = $db->updateRow('UPDATE `friends` SET `status` = ? WHERE (`id_user_1` = ? AND `id_user_2` = ?) OR (`id_user_1` = ? AND `id_user_2` = ?)', [1, $user->sess_id, $user->id, $user->id, $user->sess_id]);
    } 
    elseif ($query['status'] == 1) 
    {
        $text = 'Заявка в друзья принята. Теперь <a class ="pjax-page-link" onclick="go(this, event,function(){$(\'#notifications .list\').html(\'\')})" href = "/network3/@' . $user->sess_login() . '">' . $user->sess_name() . ' ' . $user->sess_surname() . '</a> Ваш друг.';
        
        $query = $db->updateRow('UPDATE `friends` SET `status` = ? WHERE (`id_user_1` = ? AND `id_user_2` = ?) OR (`id_user_1` = ? AND `id_user_2` = ?)', [2, $user->sess_id, $user->id, $user->id, $user->sess_id]);
        $notif = $db->insertRow('INSERT INTO `notifications` (`id_from`, `id_to`,`text`,`date`,`time`) VALUES (?,?,?,?,?)', [$user->sess_id, $user->id, $text, $date, $time]);
        
        echo json_encode(['return' => 'success']);
    }
}

// не друзья - 0
// запрос на дружбу - 1
// друзья - 2
// запрос на дружбу отклонен - 3
// черный список - 4
