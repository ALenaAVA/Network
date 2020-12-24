<div class="page" id="friends-page">
    <div class="flex-block">
        <div class="left-block">
            <div class="friends-list-block">
                <div class="top">
                    <div class="wrap">
                        <ul class="categories">
                            <li>
                                <a class="pjax-block-link" onclick="go(this, event)" href="?cat=all">Редактировать профиль </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="list-block">
                    <div class="edit-block">
                        <form action="javascript:void(null)">
                            <div class="input-data-block">
                                <div class="edit-name-block">

                                    <label for="name">Изменить имя фамилию</label>
                                    <input name="name" type="text" id="username" value="<?= $user->name() . " " . $user->surname() ?>" placeholder="Имя Фамилия" required autocomplete pattern="^[a-zA-Zа-яА-ЯёЁіІїЇ][a-zA-Zа-яА-ЯёЁіІїЇ\-`]{1,20} [a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ\-`]{1,30}$" title="Введите сначала Имя потом Фамилию">

                                </div>
                                <label for="name">Изменить дату рождения</label>
                                <div class="select-box" id="select-box">
                                    <div class="edit-date-block">
                                        <select name="day" id="day" class="select"><?= $user->birthday() ?></select>
                                        <select name="month" id="month" class="select"><?= $user->birthmonth() ?></select>
                                        <select name="year" id="year" class="select"><?= $user->birthyear() ?></select>
                                    </div>
                                </div>
                                <div class="select-box" id="select-box">
                                    <div class="edit-sex-block">
                                        <label for="name">Изменить пол</label><br>
                                        <select name="sex" id="sex" class="select">
                                            <?php if ($user->sex() == '0') : ?>
                                                <option value="0" selected>Муж</option>
                                                <option value="1">Жен</option>
                                            <?php else : ?>
                                                <option value="0">Муж</option>
                                                <option value="1" selected>Жен</option>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="edit-password-block">

                                    <label for="name">Изменить проль</label>
                                    <input name="password" type="password" id="password" placeholder="Пароль" pattern="[a-zA-Z0-9-#$%]{6,15}" title="от 6-15 символов a-zA-Z0-9_-#$%">
                                    <input type="hidden" name="step" value="regist">
                                </div>

                            </div>
                            <div class="submit-block">
                                <input id="loading-input" type="submit" value="Сохранить" onclick="APP.action.edit()">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var day = new Date,
        md = (new Date(day.getFullYear(), day.getMonth() + 1, 0, 0, 0, 0, 0)).getDate(),
        $month_name = "января февраля марта апреля мая июня июля августа сентября октября ноября декабря".split(" ");

    function set_select(a, c, d, e) {
        var el = document.getElementsByName(a)[0];
        for (var b = el.options.length = 0; b < c; b++) {
            el.options[b] = new Option(a == 'month' ? $month_name[b] : b + d, b + d);
        }
        el.options[e] && (el.options[e].selected = !0)
    }
    var bias = 100 - (day.getFullYear() - $('#year').text());

    set_select("day", md, 1, $('#day').text() - 1);
    set_select("month", 12, 1, $('#month').text() - 1);
    set_select("year", 101, day.getFullYear() - 100, bias);

    function check_date() {
        var a = year.value | 0,
            c = month.value | 0;
        md = (new Date(a, c, 0, 0, 0, 0, 0)).getDate();
        a = document.getElementById("day").selectedIndex;
        set_select("day", md, 1, a)
    };

    if (document.addEventListener) {
        year.addEventListener('change', check_date, false);
        month.addEventListener('change', check_date, false);

    } else {
        year.detachEvent('onchange', check_date);
        month.detachEvent('onchange', check_date);
    }
</script>