<?php
session_start()
?>
<div class='layer-wrap' id='crop-avatar-wrap'>
    <div class='title-layer'>Выбор фотографии</div>
    <div class='layer-box'>
        <div class='text'>
            Вы можете обрезать <label class='blue-link'>фотографию</label>.
            <div class='img-avatar-block-cropper'>
                <img src='/network3/uploads/tmp_banners/<?= $_SESSION['tmp_banner'] ?>'>
            </div>
        </div>
        <div class='submit-block'>
            
            <input type='submit' value='Сохранить' id='saveUserBanner'>
        </div>
    </div>
</div>