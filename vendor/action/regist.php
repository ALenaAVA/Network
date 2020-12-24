<?php

// use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\PHPMailer;
use vendor\core\DB;

session_start();
//use PHPMailer;
if (!empty($_POST)) {
    // var_dump($_POST);
    if ($_POST['step'] == 'regist') {
        include "../core/DB.php";
        $config = include '../core/config.php';
        $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
        if ($db) {
            $query = $db->getRow('SELECT `id` FROM `users` WHERE `email` = ?', [$_POST['email']]);
            if (empty($query['id'])) {

                require_once '../libs/PHPMailer-master/src/PHPMailer.php';
                require_once '../libs/PHPMailer-master/src/SMTP.php';
                require_once '../libs/PHPMailer-master/src/Exception.php';

                $mail = new PHPMailer;
 
                $mail->isSMTP();

               // $mail->SMTPDebug = 2;

                //$mail->Debugoutput = 'html';
              
                $mail->Host = 'smtp.gmail.com';
               
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->Username = "inzpnet@gmail.com";
                $mail->Password = "uXsyTmT7heBc8sG";

                $mail->setFrom('inzpnet@gmail.com', 'InZpNet');
                $mail->addAddress($_POST['email'], $_POST['name']);
                $mail->Subject = 'Регистрация нового пользователя';
                $mail->CharSet = "utf-8";
                $pin = $_SESSION['sess_pin'] = rand(123662, 967881);
                $body = "Для регистрации необходимо подтвердить Email. Введите следующий код: {$pin}";
                $mail->Body = $body;
                if ($mail->send()) {
                    $_SESSION['name'] = $_POST['name'];
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $_SESSION['day'] = $_POST['day'];
                    $_SESSION['month'] = $_POST['month'];
                    $_SESSION['year'] = $_POST['year'];
                    if ($_POST['sex'] == 'Муж') {
                        $_SESSION['sex'] = '0';
                    } else {
                        $_SESSION['sex'] = '1';
                    }
                     echo json_encode(['return' => 'success']);
                } else {
                    echo json_encode(['return' => $mail->ErrorInfo]);
                }
            } else {
                echo json_encode(['return' => 'error email exist']);
            }
        } else {
            echo json_encode(['return' => 'error db connect']);
        }
    } elseif ($_POST['step'] == 'confirm') {
        if (trim($_POST['pin']) == trim($_SESSION['sess_pin'])) {
            echo json_encode(['return' => 'success', 'location' => '/auth/finish']);
        }
        else{
            echo json_encode(['return' => 'error']);    
        }
    } elseif ($_POST['step'] == 'finish') {
        if (!empty($_POST['login'])) {
            include "../core/DB.php";
            $config = include '../core/config.php';
            $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
            $query = $db->getRow('SELECT `id` FROM `users` WHERE `login` = ?', [$_POST['login']]);
            if (empty($query['id'])) {
                $user = explode(' ', $_SESSION['name']);
                $name = $user[0];
                $surname = $user[1];
                $path = $_POST['login'];
                $query = $db->insertRow(
                    "INSERT INTO `users`(`login`,`password`,`email`,`name`, `surname`,`path`,`birthday`,`birthmonth`,`birthyear`,`sex`) 
                VALUES(?,?,?,?,?,?,?,?,?,?)",
                    [$_POST['login'], $_SESSION['password'], $_SESSION['email'], $name, $surname, $path, $_SESSION['day'], $_SESSION['month'], $_SESSION['year'], $_SESSION['sex']]
                );

                if ($query) {
                    $query = $db->getRow('SELECT `id` FROM `users` WHERE `login` = ?', [$_POST['login']]);
                    $_SESSION['id'] = $query['id'];
                    echo json_encode(['return' => 'success', 'path' => $path]);
                } else {
                    echo json_encode(['return' => 'error db insert']);
                }
            } else {
                echo json_encode(['return' => 'error login already exists']);
            }
        } else {
            echo json_encode(['return' => 'error empty login']);
        }
    }
} else {
    //  var_dump($_POST);
    echo json_encode(['return' => 'error array is empty']);
}

//44:48 #1
