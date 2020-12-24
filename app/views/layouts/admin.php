<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="<?= WWW ?>/public/css/jquery.jscrollpane.css">
    <link rel="stylesheet" href="<?= WWW ?>/public/css/cropper.css">
    <link rel="stylesheet" href="<?= WWW ?>/public/css/main.css">
    <script src="<?= WWW ?>/vendor/libs/momentjs/moment.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="<?= WWW ?>/public/js/masonry.pkgd.min.js"></script>
    <script src="<?= WWW ?>/public/js/imagesloaded.pkgd.min.js"></script>

    <script src="<?= WWW ?>/highslide/highslide.min.js"></script>
    <script src="<?= WWW ?>/public/js/jquery.jscrollpen.js"></script>
    <script src="<?= WWW ?>/public/js/jquery.mousewheel.js"></script>
    <script src="<?= WWW ?>/public/js/cropper.js"></script>
    <script src="<?= WWW ?>/public/js/router.js"></script>
    <script src="<?= WWW ?>/public/js/main.js"></script>
</head>

<body>
    <div class="top-block">
        <ul class="left-top-menu">
        </ul>
        <ul class="middle-top-block">
            <li class="title-page"><?= $page ?></li>
        </ul>
        <ul class="right-top-menu" id="user-main-top-menu">
            <li class="user-link">
                <a href="<?= WWW ?>/@<?= $user->sess_login() ?>" title="В акаунт">
                    <img src="<?= IMG ?>/menu/back.png" alt="">
                </a>
            </li>
            <li id="exit" onclick='APP.action.exit()'>
                <img src="<?= IMG ?>/menu/exit.png" alt="" title="Выход">
            </li>
        </ul>
    </div>
    <div class="pjax-container page-block">
        <div class="user-layout">
            <div class="left-main-menu-block">
                <ul class="left-menu-list">
                    <li style="background-image: url('<?= IMG ?>/other/admin.jpg');">
                    </li>
                    <li class="avatar-user-li">
                        <img src="<?= $user->sess_avatar() ?>" alt="avatar" onclick="APP.window.modal({data:this,type:'forChooseAvatar'});">
                    </li>
                    <li class="user-name">
                        <a href="<?= WWW ?>/@<?= $user->sess_login() ?>"><?= $user->sess_name() . ' ' . $user->sess_surname() ?>
                        </a></li>
                    <li class="main-li">
                        <a class="pjax-page-link" onclick="go(this, event)" href="<?= WWW ?>/admin-panel">
                            <img src="<?= IMG ?>/menu/photo-grey.png" alt=""> Добавленные фотографии
                        </a>
                    </li>
                    <!-- <li class="main-li">
                        <a class="pjax-page-link" onclick="go(this, event)" href="<?= WWW ?>/censure">
                            <img src="<?= IMG ?>/menu/newspaper-grey.png" alt=""> Жалобы
                        </a>
                    </li>
                    <?php if ($user->sess_userRole() == 2) : ?>
                        <li class="main-li">
                            <a href="<?= WWW ?>/add-admin">
                                <img src="<?= IMG ?>/menu/account-plus.png" alt=""> Добавить администратора
                            </a>
                        </li>
                    <?php endif; ?> -->
                </ul>
            </div>
            <div class="pjax-page">
                <?= $content ?>
            </div>

            <div class="layer-bg">
            </div>
        </div>
    </div>
</body>

</html>