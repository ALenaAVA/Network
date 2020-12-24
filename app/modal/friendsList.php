<?php

session_start();

use vendor\core\DB;
use vendor\core\User;

include "../../vendor/core/DB.php";
include "../../vendor/core/User.php";

if ($_POST['cat'] == 'all') {
    $user = new User();
    $res = '';

    for ($i = 0; $i < count($user->friendsList()); $i++) {

        $friend = new User();
        $friend->id = $user->friendsList()[$i]['id_user'];

?>
        <div class="user-block">
            <div class="avatar-block">
                <img src="<?= $friend->avatar() ?>" alt="no-img">
            </div>
            <div class="right">
                <div class="main">
                    <div class="user-name">
                        <a class="pjax-page-link" onclick="go(this, event)" href="/network3/@<?= $friend->login() ?>"><?= $friend->name() . ' ' . $friend->surname() ?></a>
                    </div>
                    <div class="send-message-block" onclick="APP.window.form.messagesContainer(<?=$friend->id?>)">
                        <label> Написать сообщение</label>
                    </div>
                </div>
                <div class="user-menu-link">
                    <img src="/network3/public/img/menu/dots-horizontal.png" alt="">
                </div>
            </div>
        </div>
        <?php
    }
} elseif ($_POST['cat'] == 'online') {
    $user = new User();
    $friends = $user->friendsList('online');
    if (!empty($friends)) {
        for ($i = 0; $i < count($friends); $i++) {
            $friend = new User();
            $friend->id = $friends[$i];
            $friend->online();
        ?>

            <div class="user-block">
                <div class="avatar-block">
                    <img src="<?= $friend->avatar() ?>" alt="no-img">
                </div>
                <div class="right">
                    <div class="main">
                        <div class="user-name">
                            <a class="pjax-page-link" onclick="go(this, event)" href="/network3/@<?= $friend->login() ?>"><?= $friend->name() . ' ' . $friend->surname() ?></a>
                        </div>
                        <div class="send-message-block">
                            <label> Написать сообщение</label>
                        </div>
                    </div>
                    <div class="user-menu-link">
                        <img src="/network3/public/img/menu/dots-horizontal.png" alt="">
                    </div>
                </div>
            </div>
<?php
        }
    }
}
