<div class="page" id="auth-page">
    <div class="block-content">
        <form action="javascript:void(null)">
            <div class="title-form">Завершение регистрации</div>
            <div class="input-data-block">
                <input name="login" type="text" id="login" placeholder="Придумайте логин" required>
                <input type="hidden" name="step" value="finish">
            </div>
            <div class="submit-block">
                <input id="loading-input" type="submit" value="Подтвердить" onclick="APP.action.finishRegist()">
            </div>
        </form>
    </div>
</div>