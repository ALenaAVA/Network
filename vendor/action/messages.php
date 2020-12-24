<?php
session_start();

use vendor\core\DB;
use vendor\core\User;

include "../core/DB.php";
include "../core/User.php";
$config = include '../core/config.php';
$db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);


if ($_POST['type'] == 'addMessage') {

    $text = strip_tags($_POST['text']);
    $d = new DateTime('', new DateTimeZone('Europe/Riga'));
    $date = $d->format('d.m.Y');
    $time = $d->format('H:i:s');
    $recipient = $_POST['recipient'];
    $sender = $_SESSION['id'];
    $user = new User();
    $user->id = $sender;
    $date = date('d.m.Y');
    $time = date('H:i');
    $text2 = 'Пользователь <a href = "/network3/@' . $user->login() . '">' . $user->name() . ' ' . $user->surname() . '</a> 
    отправил(а) Вам сообщение <img src="public/img/menu/messages.png" alt="" title="Написать сообщение" onclick="APP.window.form.messagesContainer(' . $user->id . ')">';

    $notif = $db->insertRow('INSERT INTO `notifications` (`id_from`, `id_to`,`text`,`date`,`time`) VALUES (?,?,?,?,?)', [$sender, $recipient, $text2, $date, $time]);

    $query = $db->insertRow("INSERT INTO `messages` (sender,recipient,`date`,`time`,`text`) VALUES(?,?,?,?,?)", [$sender, $recipient, $date, $time, $text]);
   // $notif = $db->insertRow('INSERT INTO `notifications` (`id_from`, `id_to`,`text`,`date`,`time`) VALUES (?,?,?,?,?)', [$sender, $recipient, $text2, $date, $time]);

    if (!empty($_FILES)) {
        $files = $_FILES['files']['tmp_name'];
        $id = $db->lastInsertId();

        for ($i = 0; $i < count($files); $i++) {
            $newFileName = date('dmYHis') . md5($files[$i]) . '.png';
            $source_path = $files[$i];
            $target_path = '../../uploads/insertions/' . $newFileName;

            if (move_uploaded_file($source_path, $target_path)) {
                $query = $db->insertRow("INSERT INTO `insertion` (`id_mes`, `name_file`) VALUES(?,?)", [$id, $newFileName]);
            }
        }
    }
    echo json_encode(['return' => 'success']);
} elseif ($_POST['type'] == 'getMessages') {
    // $recipient = $_POST['recipient'];
    $sender = $_SESSION['id'];
    $recipient = $_POST['friend'];
    $query = $db->getRows('SELECT * FROM messages WHERE  (sender = ? AND recipient = ?)OR(sender = ? AND recipient = ?)', [$sender, $recipient, $recipient, $sender]);
    for ($i = 0; $i < count($query); $i++) {
        $q = $db->getRows('SELECT name_file FROM `insertion` WHERE `id_mes` = ?', [$query[$i]['id']]);

        $query[$i]['insertions'] = $q;
    }


    echo json_encode($query);
}
