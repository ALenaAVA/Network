<?php

use vendor\core\DB;

session_start();
if (!empty($_FILES)) {

    if ($_POST['type'] == 'avatar') {

        $types = ['image/png', 'image/jpeg'];
        if (count($_FILES)) {

            if (in_array($_FILES['file']['type'][0], $types)) {
                $max_size = 10240000; //2 406 147 

                if ($_FILES['file']['size'][0] > $max_size || $_FILES['file']['size'][0] == 0) {
                    echo json_encode(['return' => 'Размер файлa не соответствует диапазону от 1 до 10240000.']);
                } else {
                    $newFileName = date('dmYHis') . md5($_SESSION['id']) . '.png';
                    if (move_uploaded_file($_FILES['file']['tmp_name'][0], '../../uploads/tmp_avatars/' . $newFileName)) {
                        $_SESSION['tmp_avatar'] = $newFileName;
                        echo json_encode(['return' => 'success', 'data' => $newFileName]);
                    } else
                        echo json_encode(['return' => 'Файл не сохрaнен.']);
                }
            } else
                echo json_encode(['return' => 'type is error']);
        } else
            echo json_encode(['return' => 'array is null']);
    } elseif ($_POST['type'] == 'banner') {
        $fi = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($fi, $_FILES['file']['tmp_name'][0]);
        if (strpos($mime_type, 'image') === false) {
            echo json_encode(['return' => 'Можно загружать только изображения!']);
        } else {
            if (count($_FILES)) {
                $max_size = 1024000;

                if ($_FILES['file']['size'][0] > $max_size || $_FILES['file']['size'][0] == 0) {

                    $filename = $_FILES['file']['tmp_name'][0];

                    list($width, $height) = getimagesize($filename);

                    $new_width = 1680;
                    $new_height = 1050;

                    $image_p = imagecreatetruecolor($new_width, $new_height);
                    $func = 'imagecreatefrom' . substr($mime_type, 6);
                    $image = $func($filename);
                    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    $func = 'image' . substr($mime_type, 6);
                    $newFileName = date('dmYHis') . md5($_SESSION['id']) . '.png';
                    $func($image_p,  '../../uploads/tmp_banners/' . $newFileName);
                    $_SESSION['tmp_banner'] = $newFileName;
                    echo json_encode(['return' => 'success', 'data' => $newFileName]);
                } else {
                    $newFileName = date('dmYHis') . md5($_SESSION['id']) . '.png';
                    if (move_uploaded_file($_FILES['file']['tmp_name'][0], '../../uploads/tmp_banners/' . $newFileName)) {
                        $_SESSION['tmp_banner'] = $newFileName;
                        echo json_encode(['return' => 'success', 'data' => $newFileName]);
                    } else
                        echo json_encode(['return' => 'Файл не сохрaнен.']);
                }
            } else {
                echo json_encode(['return' => 'Файл не выбран']);
            }
        }
    } 
} else {
    if ($_POST['type'] == 'saveAvatar') {

        $w = $_POST['width'];
        $h = $_POST['height'];
        $t = $_POST['top'];
        $l = $_POST['left'];
        $img = $_SESSION['tmp_avatar'];
        $dir_from = '../../uploads/tmp_avatars/';
        $dir_to = '../../uploads/avatars/';

        if ($w < 0 || $h < 0 || $t < 0 || $l < 0) {
            die('Data error');
            return false;
        }

        include "../core/DB.php";
        $config = include '../core/config.php';
        $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
        $query = $db->getRow('SELECT `avatar` FROM `users` WHERE `id` = ?', [$_SESSION['id']]);
        if (!empty($query['avatar'])) {

            list($w_i, $h_i, $type) = getimagesize($dir_from . $img);

            $types = ['', 'gif', 'jpeg', 'png'];
            $ext = $types[$type];
            if (!empty($ext)) {
                $func = 'imagecreatefrom' . $ext;
                $img_i = $func($dir_from . $img);
            } else {
                die('Image error!!!');
                return false;
            }

            if ($l + $w > $w_i) $w = $w_i - $l;
            if ($t + $h > $h_i) $h = $h_i - $t;

            $img_o = imagecreatetruecolor($w, $h);
            imagecopy($img_o, $img_i, 0, 0, $l, $t, $w, $h);

            $func = 'image' . $ext;
            if ($query['avatar'] != 'no-avatar.png') {
                unlink($dir_to . $query['avatar']);
            }

            $db->insertRow("UPDATE `users` SET `avatar` = ? WHERE `id` = ?", [$img, $_SESSION['id']]);
            $func($img_o, $dir_to . $img);
            unlink($dir_from . $img);
        }
        echo json_encode([$dir_from . $img, $dir_to . $img]);
    } elseif ($_POST['type'] == 'saveBanner') {
        $w = $_POST['width'];
        $h = $_POST['height'];
        $t = $_POST['top'];
        $l = $_POST['left'];
        $img = $_SESSION['tmp_banner'];
        $dir_from = '../../uploads/tmp_banners/';
        $dir_to = '../../uploads/banners/';

        if ($w < 0 || $h < 0 || $t < 0 || $l < 0) {
            die('Data error');
            return false;
        }

        include "../core/DB.php";
        $config = include '../core/config.php';
        $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
        $query = $db->getRow('SELECT `banner` FROM `users` WHERE `id` = ?', [$_SESSION['id']]);
        if (!empty($query['banner'])) {

            list($w_i, $h_i, $type) = getimagesize($dir_from . $img);

            // $fi = finfo_open(FILEINFO_MIME_TYPE);
            // $mime_type = substr(finfo_file($fi, $_FILES['file']['tmp_name'][0]), 6);
      
            $types = ['', 'gif', 'jpeg', 'png'];

            $ext = $types[$type];
            if (!empty($ext)) {
                $func = 'imagecreatefrom' . $ext;
                $img_i = $func($dir_from . $img);
            } else {
                die('Image error!!!');
                return false;
            }

            if ($l + $w > $w_i) $w = $w_i - $l;
            if ($t + $h > $h_i) $h = $h_i - $t;

            $img_o = imagecreatetruecolor($w, $h);
            imagecopy($img_o, $img_i, 0, 0, $l, $t, $w, $h);

            $func = 'image' . $ext;
            if ($query['banner'] != 'no-banner.png') {
                unlink($dir_to . $query['banner']);
            }

            $db->insertRow("UPDATE `users` SET `banner` = ? WHERE `id` = ?", [$img, $_SESSION['id']]);
            $func($img_o, $dir_to . $img);
            unlink($dir_from . $img);
        }
        echo json_encode([$dir_from . $img, $dir_to . $img]);
    }
}
