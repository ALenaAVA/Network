<div class="page" id="auth-page">
    <div class="block-content">
        <form action="javascript:void(null)">
            <div class="title-form">Регистрация</div>
            <div class="input-data-block">
                <input name="name" type="text" id="username" placeholder="Имя Фамилия" required autocomplete pattern="^[a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ\-`]{1,20} [a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ\-`]{1,30}$" title="Введите сначала Имя потом Фамилию">
                <div class="select-box" id="select-box">
                    <select name="day" id="day" class="select"></select>
                    <select name="month" id="month" class="select"></select>
                    <select name="year" id="year" class="select"></select>
                    <select name="sex" id="sex" class="select">
                        <option value="Муж">Муж</option>
                        <option value="Жен">Жен</option>
                    </select>
                </div>
                <input name="email" type="email" id="email" placeholder="Электронная почта" pattern="[-._a-z0-9]+@(?:[a-z0-9][a-z0-9]+\.)+[a-z]{2,10}$" title="example@gmail.com" required>
                <input name="password" type="password" id="password" placeholder="Пароль" required pattern="[a-zA-Z0-9-#$%]{6,15}" title="от 6-15 символов a-zA-Z0-9_-#$%">
                <input type="hidden" name="step" value="regist">
            </div>
            <div class="submit-block">
                <input id="loading-input" type="submit" value="Отправить" onclick="APP.action.regist()">
            </div>
        </form>
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
    set_select("day", md, 1, day.getDate() - 1);
    set_select("month", 12, 1, day.getMonth());
    set_select("year", 101, day.getFullYear() - 100, 100);

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