<div class="page" id="auth-page">
    <div class="block-content">
        <form action="javascript:void(null)">
            <div class="title-form">Авторизация</div>
            <div class="input-data-block">
                <input name="login" type="text" id="login" placeholder="Login" required>
                <input name="password" type="password" id="password" placeholder="Password" required>
                <input type="hidden" name="step" value="confirm">
            </div>
            <div class="submit-block">
                <input id="loading-input" type="submit" value="Войти" onclick="APP.action.login()" >
            </div>
        </form>
    </div>
</div>