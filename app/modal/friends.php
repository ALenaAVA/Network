
<?php

if (!empty($_POST)) {
    $block = '';
    $arr = json_decode($_POST['search'], true);
}?>

<div class="page" id="friends-page">
    <div class="flex-block">
        <div class="left-block">
           <?php var_dump($arr)?>
        </div>
    </div>
</div>