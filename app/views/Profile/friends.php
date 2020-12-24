<div class="page" id="friends-page">
    <div class="flex-block">
        <div class="left-block">
            <?php $user = new \vendor\core\User() ?>
            <?php if (count($user->friendsList()) == 0) : ?>
                <div class="page-wrapper-block no-friends-block">
                    <div class="intro">
                        <img src="/network3/public/img/other/sad-cat.jpg" alt="no-img">
                        <div class="text">У Вас, еще пока, нет друзей</div>
                    </div>
                </div>
            <?php else : ?>
                <div class="friends-list-block">
                    <div class="top">
                        <div class="wrap">
                            <ul class="categories">
                                <li>
                                    <a class="pjax-block-link" onclick="go(this, event)" href="?cat=all">Все друзья <label class="count"><?= count($user->friendsList()) ?></label></a>
                                </li>
                                <li>
                                    <a class="pjax-block-link" onclick="go(this, event)" href="?cat=online">Друзья в сети <label class="count"><?= count($user->friendsList('online')) ?></label></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="list-block">
                        <div class="seach-block">
                            <input id="live-search" type="text" id="seach-input" placeholder="Введите имя друга">
                        </div>
                        <div class="pjax-block wrap">

                        </div>
                        <script>
                            $('#live-search').keyup(function() {
                                var text = $('#live-search').val().trim().toLowerCase();
                                

                                let list = $('.list-block .wrap .right .main .user-name a');

                                if (text != '') {
                                    $.each(list, function() {
                                        if (this.innerText.toLowerCase().search(text) == -1) {
                                            $(this).closest('.user-block').css({
                                                'display': 'none'
                                            });
                                        } else{
                                            $(this).closest('.user-block').css({
                                                'display': 'flex'
                                            });
                                        }
                                    })
                                } else {
                                    $.each(list, function() {
                                        $(this).closest('.user-block').css({
                                            'display': 'flex'
                                        });
                                    })
                                }
                            })
                            if (location.search.substring(1).split('=')[1] === undefined)
                                APP.upload.friends.list('all');
                            else
                                APP.upload.friends.list(location.search.substring(1).split('=')[1]);

                            if (location.search.substring(1).split('=')[1] === 'online') {
                                $('ul.categories li:last-child').attr('class', 'active');
                                $('ul.categories li:first-child').attr('class', '');
                            } else {
                                $('ul.categories li:first-child').attr('class', 'active');
                                $('ul.categories li:last-child').attr('class', '');
                            }
                            $('.pjax-block-link').click(function() {
                                APP.upload.friends.list(location.search.substring(1).split('=')[1]);
                                if (location.search.substring(1).split('=')[1] === 'online') {
                                    $('ul.categories li:last-child').attr('class', 'active');
                                    $('ul.categories li:first-child').attr('class', '');
                                } else {
                                    $('ul.categories li:first-child').attr('class', 'active');
                                    $('ul.categories li:last-child').attr('class', '');
                                }
                            })
                        </script>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>