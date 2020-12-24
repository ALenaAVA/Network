<?php

session_start();

if (!empty($_POST)) {
    if ($_POST['type'] == 'createSessionForLeftMenu') {
        if (empty($_SESSION['isLeftMenu'])) {
            $_SESSION['isLeftMenu'] = 1;
            echo json_encode([$_SESSION['isLeftMenu']]);
        } else {
            unset($_SESSION['isLeftMenu']);
            echo json_encode([0]);
        }
    } else
        echo json_encode(['type is empty']);
} else
    echo json_encode(['post is empty']);
