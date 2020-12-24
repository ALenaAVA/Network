<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="<?= WWW ?>/vendor/libs/momentjs/moment.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= WWW ?>/public/css/cropper.css">
    <link rel="stylesheet" href="<?= WWW ?>/public/css/jquery.jscrollpane.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?= WWW ?>/public/js/masonry.pkgd.min.js"></script>
    <script src="<?= WWW ?>/public/js/imagesloaded.pkgd.min.js"></script>
    <link rel="stylesheet" href="<?= WWW ?>/public/css/main.css">
    <script src="<?= WWW ?>/public/js/jquery.jscrollpen.js"></script>
    <script src="<?= WWW ?>/public/js/jquery.mousewheel.js"></script>
    <script src="<?= WWW ?>/public/js/cropper.js"></script>
    <script src="/network3/public/js/router.js"></script>
    <script src="/network3/public/js/main.js"></script>
</head>

<body>
    <div class="top-block">
        <ul class="left-top-menu-main">
            <li class="logo">
                <a onclick="go(this,event)" class="pjax-container-link"  href="/network3/main"><?= LOGO ?></a>
            </li>
        </ul>
        <ul class="middle-top-block">
            <li class="title-page">Авторизация</li>
            <!-- <li class="search-input-block">
                <form action="javascript:void(null)">
                    <input type="search" id="search-data" placeholder="Поиск в <?= LOGO ?>" required>
                </form>
            </li> -->
        </ul>
        <ul class="right-top-menu">
            <li>
                <a onclick="go(this,event)" class="pjax-container-link" href="<?= WWW ?>/login">Войти</a>
            </li>
            <li><a onclick="go(this,event)" class="pjax-container-link" href="<?= WWW ?>/regist">Регистрация</a></li>
        </ul>
    </div>
    <div class="pjax-container page-block">

        <?= $content ?>

    </div>


</body>

</html>