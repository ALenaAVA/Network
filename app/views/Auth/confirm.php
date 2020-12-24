<div class="page" id="auth-page">
    <div class="block-content">
        <form action="javascript:void(null)">
            <div class="title-form">Подтверждение Email</div>
            <div class="input-data-block">
                <input name="pin" type="text" id="pin" placeholder="Pin-код из почты" required>
                <input type="hidden" name="step" value="confirm">
            </div>
            <div class="submit-block">
                <input id="loading-input" type="submit" value="Подтвердить" onclick="APP.action.confirmRegist()">
            </div>
        </form>
    </div>
</div>