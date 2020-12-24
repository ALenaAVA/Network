<div class="page" id="friends-page">
    <div class="flex-block">
        <div class="left-block">
            <?php if (empty($_SESSION['search'])) : ?>
                <div class="page-wrapper-block no-friends-block">
                    <div class="intro">
                        <img src="/network3/public/img/other/sad-cat.jpg" alt="no-img">
                        <div class="text">К сожалению, этот человек еще не зарегистрирован</div>
                    </div>
                </div>
            <?php else : ?>

                <div class="friends-list-block">
                    <div class="top">
                        <div class="wrap">
                            <ul class="categories">
                                <li>
                                    <a class="pjax-block-link" onclick="go(this, event)" href="?cat=all">Найдено людей <label class="count"><?= count($_SESSION['search']) ?></label></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="list-block"> 
                        <div class="pjax-block wrap">
                            
                        </div>
                        <script>
                             APP.upload.friends.searchList();
                        </script>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>