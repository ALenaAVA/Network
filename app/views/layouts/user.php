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
            <!-- <li class="main-li">
                <img class="left-menu-controll" src="<?= IMG ?>/menu/menu.png" alt="no-avatar" onclick="APP.animate.showLeftMenu('.left-main-menu-block',0); APP.query('/network3/vendor/action/session.php','createSessionForLeftMenu',function (data) {console.log(data+3);})">
            </li> -->
            <li class="logo">
                <a onclick="go(this,event)" class="pjax-container-link" href="<?= WWW ?>/@<?= $user->sess_login() ?>"><?= LOGO ?></a>
            </li>
        </ul>
        <ul class="middle-top-block">
            <li class="title-page"><?= $page ?></li>
            <li class="search-input-block">
                <form action="javascript:void(null)">
                    <input onkeydown="APP.action.search(event,this)" class="pjax-container-link" type="search" id="search-data" placeholder="Ищите друга по имени и/или фамилии" required>
                </form>
            </li>
        </ul>
        <ul class="right-top-menu" id="user-main-top-menu">
            <!-- <li id="music-fast">
                <img src="<?= IMG ?>/menu/start-play.png" alt="">
            </li>
            <li id="messenger">
                <img src="<?= IMG ?>/menu/messenger.png" alt="">
            </li> -->
            <p></p>
            <?php if ($user->sess_userRole() != 0) : ?>
                <li id="admin-panel">
                    <p></p>
                    <a href="<?= WWW ?>/admin-panel">
                        <img src="<?= IMG ?>/menu/panel.png" alt="" title="Панель администратора">
                    </a>
                </li>
            <?php endif; ?>
            <li class="hide-main-li">
                <a class="pjax-page-link" onclick="go(this, event)" href="<?= WWW ?>/@<?=$user->sess_login()?>">
                    <img src="<?= IMG ?>/menu/home-red.png" alt="">
                </a>
            </li>
            <li class="hide-main-li">
                <a class="pjax-page-link" onclick="go(this, event)" href="<?= WWW ?>/friends">
                    <img src="<?= IMG ?>/menu/friends-grey.png" alt="">
                </a>
            </li>
            <li id="notifications" onclick="APP.window.notifications.getList()">

                <img src="<?= IMG ?>/menu/bell.png" alt="">
                <div class="count"></div>
                <div class="list">

                </div>
            </li>
            <li id="exit" onclick='APP.action.exit()'>
                <img src="<?= IMG ?>/menu/exit.png" alt="" title="Выход">
            </li>
            <!-- <li id="top-controll-btn">
                <img id="user-main-avatar-top" src="<?= $user->sess_avatar() ?>" alt="" width="100px" onclick="APP.window.form.topMainMenu()">
            </li> -->
        </ul>
    </div>
    <div class="pjax-container page-block">
        <?php if (!empty($_SESSION['isLeftMenu']) && $_SESSION['isLeftMenu'] == 1) : ?>
            <script>
                $(document).ready(function() {
                    $('.left-main-menu-block').css('margin-left', '-24%');
                    $('.page').css('width', '100%');
                    $('.left-menu-controll').attr('onclick', 'APP.animate.showLeftMenu(".left-main-menu-block",1000); APP.query("/network3/vendor/action/session.php","createSessionForLeftMenu",function (data) {console.log(data+2);})');
                    console.log($('.left-menu-controll').prop('onclick'));
                })
            </script>
        <?php endif; ?>
        <div class="user-layout">
            <div class="left-main-menu-block">
                <ul class="left-menu-list">
                    <li style="background-image: url('<?= $user->sess_banner() ?>');">
                        <div class="intro-block">
                            <img src="/network3/public/img/menu/download-grey.png" alt="banner" onclick="APP.window.modal({data:this,type:'forChooseBanner'});">
                        </div>
                    </li>
                    <li class="avatar-user-li">
                        <img src="<?= $user->sess_avatar() ?>" alt="avatar" onclick="APP.window.modal({data:this,type:'forChooseAvatar'});">
                    </li>
                    <li class="user-name">
                        <a class="pjax-page-link" onclick="go(this, event)" href="<?= WWW ?>/@<?= $user->sess_login() ?>"><?= $user->sess_name() . ' ' . $user->sess_surname() ?>
                        </a></li>
                    <li class="user-link">
                        <a class="pjax-page-link" onclick="go(this, event)" href="<?= WWW ?>/@<?= $user->sess_login() ?>"> @<?= $user->sess_login() ?></a>
                    </li>
                    <!-- <li class="main-li">
                        <a class="pjax-page-link" href="<?= WWW ?>/news">
                            <img src="<?= IMG ?>/menu/newspaper-grey.png" alt=""> Новости
                        </a>
                    </li>
                    <li class="main-li">
                        <a class="pjax-page-link" href="<?= WWW ?>/messages">
                            <img src="<?= IMG ?>/menu/message-grey.png" alt=""> Сообщения
                        </a>
                    </li> -->
                    <li class="main-li">
                        <a class="pjax-page-link" onclick="go(this, event)" href="<?= WWW ?>/friends">
                            <img src="<?= IMG ?>/menu/friends-grey.png" alt=""> Друзья
                        </a>
                    </li>
                    <li class="main-li">
                        <a class="pjax-page-link" onclick="go(this, event)" href="<?= WWW ?>/settings">
                            <img src="<?= IMG ?>/menu/settings.png" alt=""> Редактировать
                        </a>
                    </li>
                    <!-- <li class="main-li">
                        <a class="pjax-page-link" href="<?= WWW ?>/groups">
                            <img src="<?= IMG ?>/menu/group-grey.png" alt=""> Группы
                        </a>
                    </li>
                    <li class="main-li">
                        <a class="pjax-page-link" href="<?= WWW ?>/photo">
                            <img src="<?= IMG ?>/menu/photo-grey.png" alt=""> Фотографии
                        </a>
                    </li>
                    <li class="main-li">
                        <a class="pjax-page-link" href="<?= WWW ?>/video">
                            <img src="<?= IMG ?>/menu/video-grey.png" alt=""> Видеозаписи
                        </a>
                    </li>
                    <li class="main-li">
                        <a class="pjax-page-link" href="<?= WWW ?>/music">
                            <img src="<?= IMG ?>/menu/music-grey.png" alt=""> Аудиозаписи
                        </a>
                    </li> -->
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