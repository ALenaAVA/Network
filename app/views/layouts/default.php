<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="<?= WWW ?>/vendor/libs/momentjs/moment.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="<?= WWW ?>/vendor/libs/momentjs/moment.js"></script>
    <link rel="stylesheet" href="<?= WWW ?>/public/css/jquery.jscrollpane.css">
    <script src="<?= WWW ?>/public/js/masonry.pkgd.min.js"></script>
    <script src="<?= WWW ?>/public/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?= WWW ?>/public/js/jquery.jscrollpen.js"></script>
    <script src="<?= WWW ?>/public/js/jquery.mousewheel.js"></script>
    <link rel="stylesheet" href="<?= WWW ?>/public/css/cropper.css">
    <link rel="stylesheet" href="<?= WWW ?>/public/css/main.css">
    <script src="<?= WWW ?>/public/js/cropper.js"></script>
    <script src="/network3/public/js/router.js"></script>
    <script src="/network3/public/js/main.js"></script>

</head>

<body>
    <div class="top-block">
        <ul class="left-top-menu-main">
            <!-- <li class="main-li">
                <img class="left-menu-controll" src="<?= IMG ?>/menu/menu.png" onclick="">
            </li> -->
            <li class="logo">
                <a onclick="go(this,event)" class="pjax-container-link" href="<?= WWW ?>/main"><?= LOGO ?></a>
            </li>
        </ul>
        <ul class="middle-top-block">
            <li class="title-page">Главная</li>
            <!-- <li class="search-input-block">
                <form action="javascript:void(null)">
                    <input type="search" id="search-data" placeholder="Поиск в <?= LOGO ?>" required>
                </form>
            </li> -->
        </ul>
        <ul class="right-top-menu">
            <li>
                <a onclick="go(this,event)"   class="pjax-container-link" href="<?= WWW ?>/login">Войти</a>
            </li>
            <li><a onclick="go(this,event)"  class="pjax-container-link" href="<?= WWW ?>/regist">Регистрация</a></li>
        </ul>
    </div>
    <div class="pjax-container page-block">
        <div class="default-layout">
            <div class="left-main-menu-block">
                <ul class="left-menu-list">
                    <li>
                        <a href="<?= WWW ?>/main">
                            <?php
                            $uri = rtrim($_SERVER['REQUEST_URI'], '/');
                            if ($uri == WWW . '/main' || $uri == WWW . '/main/index' || $uri == WWW . '') : ?>
                                <img src="<?= IMG ?>/menu/home-red.png" alt="">
                                <label class='hover'>Главная</label>
                            <?php else : ?>
                                <img src="<?= IMG ?>/menu/home.png" alt="">
                                Главная
                            <?php endif ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WWW ?>/recomend">
                            <?php
                            $uri = rtrim($_SERVER['REQUEST_URI'], '/');
                            if ($uri == WWW . '/recomend' || $uri == WWW . '/recomend/index') : ?>
                                <img src="<?= IMG ?>/menu/star-circle-red.png" alt="">
                                Рекомендуемое
                            <?php else : ?>
                                <img src="<?= IMG ?>/menu/star-circle.png" alt="">
                                Рекомендуемое
                            <?php endif ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WWW ?>/new">
                            <?php
                            $uri = rtrim($_SERVER['REQUEST_URI'], '/');
                            if ($uri == WWW . '/new' || $uri == WWW . '/new/index') : ?>
                                <img src="<?= IMG ?>/menu/lightbulb-red.png" alt="">
                                Новое
                            <?php else : ?>
                                <img src="<?= IMG ?>/menu/lightbulb.png" alt="">
                                Новое
                            <?php endif ?>
                        </a>
                    </li>
                </ul>
            </div>



            <?= $content ?>
        </div>
    </div>

</body>

</html>