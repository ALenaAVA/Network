<div class='layer-wrap' id='new-post-wrap'>
    <div class='title-layer'>Создание нового поста</div>
    <div class='layer-box'>
        <div class='text'>
            <textarea id='new-post-text' placeholder="Что у Вас нового?"></textarea>
        </div>
    </div>
    <div class='attachment-img'></div>
    <div class="submit-block settings-block">
        <div class="menu-list">
            <ul>
                <li>
                    <label>
                        <img src="/network3/public/img/menu/camera-blue.png">
                        <input type="file" id="choose-img-post" multiple>
                    </label>

                </li>
                <!-- <li><img src="/network3/public/img/menu/video-blue.png"></li>
                <li><img src="/network3/public/img/menu/music-blue.png"></li>
                <li>Ещё<img src="/network3/public/img/menu/down-blue.png"></li> -->
            </ul>
        </div>
        <input type="submit" value="Сохранить" id="saveUserAvatar" onclick="APP.upload.post.save('#new-post-text'); $('textarea').focus()">
    </div>
</div>
<script>
    var storedFiles = [];

    $(document).ready(function() {

        $("#choose-img-post").on("change", handleFileSelect);

        $(".attachment-img").on("click", ".close", removeFile);
    });

    function handleFileSelect(e) {

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f) {

            if (!f.type.match("image.*")) {
                return;
            }
            storedFiles.push(f);


            var reader = new FileReader();

            reader.onload = function(e) {
                var html = '\
            <div class = "img-wrap">\
            <img src = "/network3/public/img/menu/close-box-black.png" class= "close" data-file="' + f.name + '" title="Click to remove"/>\
                <img class = "img-attachment" src = "' + e.target.result + '"/>\
            </div>';
                $(".attachment-img").append(html);
            }
            reader.readAsDataURL(f);
        });

    }

    function removeFile() {
        var file = $(this).data("file");
        for (var i = 0; i < storedFiles.length; i++) {
            if (storedFiles[i].name === file) {
                storedFiles.splice(i, 1);
                break;
            }
        }
        $(this).parent().remove();
    }
</script>