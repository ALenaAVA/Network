
<?php

if (!empty($_POST)) {
    $block = '';
    $arr = json_decode($_POST['e'], true);
    for ($i = 0; $i < count($arr); $i++) {
        $block .= "
            <div class='page-wrapper-block post-block'>
                <div class='wrap'>
                    <div class='top'>
                        <div class='user-avatar'>
                            <a href='/network3/@" . $arr[$i]['user']['login'] . "'><img src='" . $arr[$i]['user']['avatar'] . "'></a>
                        </div>
                        <div class = 'data-post'>
                            <div class = 'author-post'>
                                <a href = '/network3/@" . $arr[$i]['user']['login'] . "'>" . $arr[$i]['user']['name'] . ' ' . $arr[$i]['user']['surname'] . "</a>
                            </div>
                            <div class = 'date-and-time-post'>
                                <a href = '/network3/@" . $arr[$i]['user']['login'] . "' class= 'date-and-time'>" . $arr[$i]['date'] . ' ' . $arr[$i]['time'] . "</a>
                            </div>
                        </div>
                    </div>
                    <div class='main-block'>
                        <div class='text-block'>
                        <p>" . $arr[$i]['text'] . "</p>
                        </div>
                        <div class = 'attachments-block'>
                            <div id='gallery" . $arr[$i]['id'] . "'>";
        $count = count($arr[$i]['attachments']);
        $sizer = 'sizer4';
        if($count == 1) $sizer = 'sizer1';
        else if($count == 2) $sizer = 'sizer2';

        if ($count != 0) {
            for ($j = 0; $j < $count; $j++) {
                $block .= "<div class='item-masonry ".$sizer."'><a class = 'highslide' onclick='return hs.expand(this)' href = '/network3/uploads/attachments/" . $arr[$i]['attachments'][$j]['name_file'] . "' ><img src = '/network3/uploads/attachments/" . $arr[$i]['attachments'][$j]['name_file'] . "'/></a></div>
                <script> 
                    $('#gallery" . $arr[$i]['id'] . "').imagesLoaded(function () {
                        $('#gallery" . $arr[$i]['id'] . "').masonry({
                            itemSelector: '.item-masonry',
                            columnWidth: '.".$sizer."',
                            percentPosition: true,
                            horizontalOrder: true,
                        });
                    })</script>";
            }
        }
        $block .= "</div></div></div></div></div>";
    }

    echo $block;
}
