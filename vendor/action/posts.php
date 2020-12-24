<?php
session_start();

use vendor\core\DB;
use vendor\core\User;

if ($_POST['type'] == 'savePost') {
    include "../core/DB.php";
    include "../core/User.php";
    $config = include '../core/config.php';
    $text = strip_tags($_POST['text']);
    $d = new DateTime('', new DateTimeZone('Europe/Riga'));
    $date = $d->format('d.m.Y');
    $time = $d->format('H:i:s');
    $page = $_POST['page'];
    $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
    if (substr($page, 0, 1) === '@') {
        $id_page = substr($page, 1);
        $user = new User($id_page);

        if (!empty($user->id)) {
            $id_page = $user->id;
        } else {
            $id_page = $_SESSION['id'];
        }
    }
    $query = $db->insertRow("INSERT INTO `posts` (`date`,`time`,`id_author`, `text`,`id_page`) VALUES(?,?,?,?,?)", [$date,  $time, $_SESSION['id'], $text, $id_page]);

    if (!empty($_FILES)) {
        $str = [];
        $files = $_FILES['files']['tmp_name'];
        $q = $db->getRow("SELECT id FROM posts WHERE `time` = ? AND `date` = ? AND id_author = ? AND `text` = ? ", [$time, $date, $_SESSION['id'], $text]);

        for ($i = 0; $i < count($files); $i++) {
            $max_size = 724000;

            if ($_FILES['files']['size'][$i] > $max_size) {
                $fi = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = substr(finfo_file($fi, $_FILES['files']['tmp_name'][$i]), 6);
                $filename = $_FILES['files']['tmp_name'][$i];
               // echo $mime_type;
                list($w_i, $h_i) = getimagesize($filename);

                $w = 1680;
                $h = 1050;

                if ($w > $w_i) $w = $w_i;
                else $w =$w_i/2;
                if ($h > $h_i) $h = $h_i;
                else $h = $h_i/2;

                $image_p = imagecreatetruecolor($w, $h);
                $func = 'imagecreatefrom' . $mime_type;
                $image = $func($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $w_i, $h_i);
                $func = 'image' . $mime_type;
                $newFileName = date('dmYHis') . md5($files[$i]) . '.png';
                $func($image_p,  '../../uploads/attachments/' . $newFileName);
                $query = $db->insertRow("INSERT INTO `attachments` (`id_post`,`name_file`) VALUES(?,?)", [$q['id'], $newFileName]);
            } else {
                $newFileName = date('dmYHis') . md5($files[$i]) . '.png';
                $source_path = $files[$i];
                $target_path = '../../uploads/attachments/' . $newFileName;

                if (move_uploaded_file($source_path, $target_path)) {
                    $query = $db->insertRow("INSERT INTO `attachments` (`id_post`,`name_file`) VALUES(?,?)", [$q['id'], $newFileName]);
                }
            }
        }
        echo json_encode(['return' => 'success', 'page' => $id_page]);
    } else
        echo json_encode(['return' => 'success', 'page' => $id_page]);
} elseif ($_POST['type'] == 'getPosts') {
    $count = $_POST['count'];
    $revers = $_POST['revers'];

    include "../core/DB.php";
    include "../core/User.php";
    $config = include '../core/config.php';
    $user = new User($_POST['login']);
    $query = '';

    $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
    //echo json_encode([$user->id]);

    if ($revers === 'true') {
        $desc = 'DESC';
    } else {
        $desc = '';
    }
    if ($db->getRows('SELECT * FROM `posts` WHERE `id_page` = ?', [$user->id])) {
        if ($count === '*') {
            $query = $db->getRows('SELECT * FROM `posts` WHERE `id_page` = ? ORDER BY `id` ' . $desc, [$user->id]);
        } else {
            $query = $db->getRows('SELECT * FROM `posts` WHERE `id_page` = ? ORDER BY `id` ' . $desc . ' LIMIT ' . $count, [$user->id]);
        }
        for ($i = 0; $i < count($query); $i++) {
            $q = $db->getRows('SELECT name_file FROM `attachments` WHERE `id_post` = ?', [$query[$i]['id']]);

            $user = new User();
            $user->id = $query[$i]['id_author'];
            $query[$i]['user'] = ['name' => $user->name(), 'surname' => $user->surname(), 'login' => $user->login(), 'avatar' => $user->avatar()];
            $query[$i]['attachments'] = $q;
        }

        echo json_encode($query);
    } else {
        echo json_encode(['return' => 'empty']);
    }
}
