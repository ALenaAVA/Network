<?php

session_start();

use vendor\core\DB;
use vendor\core\Admin;

include "../../vendor/core/DB.php";
include "../../vendor/core/Admin.php";

$admin = new Admin();
$photos = $admin->getUnverifiedPhotos();
for ($i = 0; $i < count($photos); $i++) {
?>

    <div id="photo-block">
        <div class="left-block">
            <img id="ph<?= $photos[$i]['id'] ?>" src="uploads/attachments/<?= $photos[$i]['name_file'] ?>" alt="no-img">
        </div>
        <div class="right-block">
            <div class="check">
                <img src="public/img/menu/check.png" alt="" onclick="APP.upload.photos.check('<?= $photos[$i]['id'] ?>','ph<?= $photos[$i]['id'] ?>')">
            </div>
            <div class="cancel">
                <img id="cancel<?= $photos[$i]['id'] ?>" src="public/img/menu/cancel.png" alt="" onclick="APP.upload.photos.cancel('<?= $photos[$i]['id'] ?>','ph<?= $photos[$i]['id'] ?>')">
            </div> 
        </div>
    </div>
<?php
}
?>