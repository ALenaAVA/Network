<div class="page" id="friends-page">
    <div class="flex-block">
        <div class="left-block">
            <?php $admin = new \vendor\core\Admin() ?>
            <?php if (count($admin->getUnverifiedPhotos()) == 0) : ?>
                <div class="page-wrapper-block no-friends-block">
                    <div class="intro">
                        <img src="/network3/public/img/other/sad-cat.jpg" alt="no-img">
                        <div class="text">Нет непроверенных фотографий</div>
                    </div>
                </div>
            <?php else : ?>
                <div class="friends-list-block">
                    <div class="top">
                        <div class="wrap">
                            <ul class="categories">
                                <li>
                                    <a class="pjax-block-link" onclick="go(this, event)" href="?cat=all">Всего непроверенных фотографий <label class="count"><?= count($admin->getUnverifiedPhotos()) ?></label></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="list-block">
                        <div class="pjax-block wrap">
                            <div class="photos-list-block">

                            </div>
                        </div>
                        <script>
                            APP.upload.photos.list();
                        </script>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>