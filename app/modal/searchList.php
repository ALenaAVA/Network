<?php

session_start();

use vendor\core\DB;
use vendor\core\User;

include "../../vendor/core/DB.php";
include "../../vendor/core/User.php";

if (!empty($_SESSION['search'])) {
   $search = $_SESSION['search'];

    for ($i = 0; $i < count($search); $i++) {

        $friend = new User();
        $friend->id = $search[$i]['id'];
        

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
}
