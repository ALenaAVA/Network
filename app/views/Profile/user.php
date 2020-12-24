<div class="page" id="profile-page">
    <div class="flex-block">
        <div class="left-block">
            <div class="page-wrapper-block" id="user-avatar-block">
                <div class="wrap user-avatar-img">
                    <img src="<?= $user->avatar() ?>">
                </div>
            </div>

            <?php if ($user->sess_id !== $user->id) : ?>
                <div class="page-wrapper-block" id="make-friend-block">
                    <div class="wrap">
                        <div class="btn">

                            <?php
                            $query = $db->getRow('SELECT `status` FROM `friends` WHERE (`id_user_1` = ? AND `id_user_2` = ?)', [$user->sess_id, $user->id]);
                            ?>
                            <?php if (!empty($query)) : ?>
                                <?php if ($query['status'] == 1) : ?>
                                    <select class="change-request-block">
                                        <option selected>Заявка отправлена</option>
                                        <!-- <option>Отменить заявку</option> -->
                                    </select>
                                <?php elseif ($query['status'] == 2) : ?>
                                    <select class="change-request-block">
                                        <option selected>У Вас в друзьях</option>

                                        <option>Убрать из друзей</option>
                                    </select>
                                <?php endif; ?>
                            <?php else : ?>
                                <?php
                                $query = $db->getRow('SELECT `status` FROM `friends` WHERE (id_user_1 = ? AND id_user_2 = ?)', [$user->id, $user->sess_id]);
                                if (!empty($query['status'])) {
                                    if ($query['status'] == 1) { ?>

                                        <div class="info-add-user">
                                            Этот пользователь подписан на Вас
                                        </div>
                                        <input type="submit" id="add-friend-btn" value="Подтвердить" onclick="APP.action.confirmFriendRequest(this,'<?= $user->login() ?>')">
                                    <?php
                                    } elseif ($query['status'] == 2) { ?>
                                        <select class="change-request-block">
                                            <option selected>У Вас в друзьях</option>

                                            <option>Убрать из друзей</option>
                                        </select>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <input onclick="APP.action.friendRequest(this,'<?= $user->login() ?>')" type="submit" id="add-friend-btn" value="Добавить в друзья">
                                <?php
                                }
                                ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php

            use vendor\core\User;

            $friends = $user->friendsList(); ?>
            <?php if (count($friends) != 0) : ?>
                <div class="page-wrapper-block" id="friends-list">
                    <div class="wrap">
                        <?php
                        for ($i = 0; $i < count($friends); $i++) {

                            $friend = new User();
                            $friend->id = $friends[$i]['id_user']; ?>

                            <div class="user-block">
                                <div class="left">
                                    <div class="avatar-block">
                                        <img src="<?= $friend->avatar() ?>" alt="no-img">
                                    </div>
                                    <div class="user-name">
                                        <a class="pjax-page-link" onclick="go(this, event)" href="/network3/@<?= $friend->login() ?>"><?= $friend->name() . ' ' . $friend->surname() ?></a>
                                    </div>
                                </div>
                                <?php if ($_SESSION['id'] != $friend->id) : ?>
                                    <div class="right">
                                        <div class="main">

                                            <div class="send-message-block" onclick="APP.window.form.messagesContainer(<?= $friend->id ?>)">
                                                <img src="public/img/menu/messages.png" alt="" title="Написать сообщение">
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="right-block">

            <div class="content-block">
                <div class="hide-block">
                    <div class="page-wrapper-block">
                        <div class="wrap">
                            <div class="hide-user-info-block">
                                <div id="banner-user-m" style="background-image: url('<?= $user->banner() ?>');">
                                    <!-- <div class="intro-block">
                                        <img src="/network3/public/img/menu/download-grey.png" alt="banner" onclick="APP.window.modal({data:this,type:'forChooseBanner'});">
                                    </div> -->
                                </div>
                                <div class="avatar-user-li">
                                    <img src="<?= $user->avatar() ?>" alt="avatar">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($user->sess_id !== $user->id) : ?>
                        <div class="page-wrapper-block" id="make-friend-block">
                            <div class="wrap">
                                <div class="btn">

                                    <?php
                                    $query = $db->getRow('SELECT `status` FROM `friends` WHERE (`id_user_1` = ? AND `id_user_2` = ?)', [$user->sess_id, $user->id]);
                                    ?>
                                    <?php if (!empty($query)) : ?>
                                        <?php if ($query['status'] == 1) : ?>
                                            <select class="change-request-block">
                                                <option selected>Заявка отправлена</option>
                                                <!-- <option>Отменить заявку</option> -->
                                            </select>
                                        <?php elseif ($query['status'] == 2) : ?>
                                            <select class="change-request-block">
                                                <option selected>У Вас в друзьях</option>

                                                <option>Убрать из друзей</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <?php
                                        $query = $db->getRow('SELECT `status` FROM `friends` WHERE (id_user_1 = ? AND id_user_2 = ?)', [$user->id, $user->sess_id]);
                                        if (!empty($query['status'])) {
                                            if ($query['status'] == 1) { ?>

                                                <div class="info-add-user">
                                                    Этот пользователь подписан на Вас
                                                </div>
                                                <input type="submit" id="add-friend-btn" value="Подтвердить" onclick="APP.action.confirmFriendRequest(this,'<?= $user->login() ?>')">
                                            <?php
                                            } elseif ($query['status'] == 2) { ?>
                                                <select class="change-request-block">
                                                    <option selected>У Вас в друзьях</option>

                                                    <option>Убрать из друзей</option>
                                                </select>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <input onclick="APP.action.friendRequest(this,'<?= $user->login() ?>')" type="submit" id="add-friend-btn" value="Добавить в друзья">
                                        <?php
                                        }
                                        ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="page-wrapper-block" id="user-main-data-block">
                    <div class="wrap">
                        <div class="top">
                            <div id="user-name">
                                <?= $user->name() . " " . $user->surname(); ?>
                            </div>
                            <div id="online">
                                <?= $user->online() ?>
                            </div>
                        </div>
                        <div class="data-list-block">
                            <ul>
                                <li class="td">
                                    <div class="tr data-key">Дата рождения:</div>
                                    <div class="tr date-moment data-val"><?= $user->birthday() . " " . $user->birthmonth() . " " . $user->birthyear() ?></div>
                                </li>

                                <li class="td">
                                    <div class="tr data-key">Город</div>
                                    <div class="tr data-val"><?= $user->city() ?></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="page-wrapper-block" id="create-new-post-block">
                    <div class="wrap">
                        <div class="user-avatar user-avatar-img">
                            <!-- <img src="<?= $user->avatar() ?>" alt=""> -->
                        </div>
                        <div class="input-post-block">
                            <!-- <input type="text" placeholder="Что у вас нового?" onclick="APP.window.modal({data:this,type:'createNewPost', user:{name:'<?= $user->name() ?>',surname:'<?= $user->surname() ?>',link:'<?= $user->login() ?>',avatar:'<?= $user->avatar() ?>',}})"> -->
                            <input type="text" placeholder="Что у вас нового?" onkeyup="this.value = ''; APP.window.modal({data:this,type:'createNewPost'})" onclick="APP.window.modal({data:this,type:'createNewPost'})">
                        </div>
                    </div>
                </div>
                <div class="user-posts-container">

                </div>
            </div>
            <div class="navigation-block">

            </div>
        </div>
        <script>
            $(document).ready(function() {
                APP.date.formate('date-moment');
                APP.upload.post.getList('.user-posts-container', '*');

                if ($('#online').text().trim() !== 'Online') {
                    moment.locale();
                    var last = 'Последнее посещение: ' + moment("<?= $user->lastVisit() ?>", "DD.MM.YYYY hh:mm", "ru").fromNow();
                    $('#online').text(last);
                }

                
            })
        </script>
    </div>
</div>