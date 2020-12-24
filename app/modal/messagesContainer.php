<div class='messages-container-nav'>
    <?php

    use vendor\core\DB;
    use vendor\core\User;

    include "../../vendor/core/DB.php";
    include "../../vendor/core/User.php";

    $friend = new User();
    $friend->id = $_POST['id'];
    ?>
    <div class='titlebar'>
        <div class="user-block">
            <a href="@<?= $friend->login() ?>">
                <img src="<?= $friend->avatar() ?>" alt="">
            </a>
            <a class="user-name" href="@<?= $friend->login() ?>"><?= $friend->name() ?> <?= $friend->surname() ?></a>
        </div>
        <div class="close" onclick="APP.window.form.messagesContainerClose(this)">
            <img src="public/img/menu/close.png" alt="">
        </div>
    </div>
    <div class="messages-block">

    </div>
    <div class="footer-block">

        <div class='attachment-img-mes'>
        </div>

        <div class="send-message">
            <input id="new-message" type="text" placeholder="Введите сообщение">
        </div>
        <div class="attachments-block">
            <ul>
                <li>
                    <label>
                        <img src="public/img/menu/image.png" alt="" title="Прикрепить фото">
                        <input type="file" id="choose-img-message" multiple>
                    </label>
                </li>
                <!-- <li>
                    <img src="public/img/menu/emoticon.png" alt="" title="Эмодзи">
                </li> -->
                <li class="right-li">
                    <img src="public/img/menu/send.png" alt="" title="Отправить" onclick="APP.upload.message.send('#new-message',<?= $friend->id ?>); $('#new-message').focus();">
                </li>
            </ul>
        </div>
    </div>

    <script>
        window.interval = {
            i:undefined,
        }
        var storedFiles = [];


        $(document).ready(function() {
            APP.upload.message.getList('.messages-block', <?= $friend->id ?>);
            
            interval.i = setInterval("APP.upload.message.getList('.messages-block', <?= $friend->id ?>);", 3000);

            $("#choose-img-message").on("change", handleFileSelect);

            $(".attachment-img-mes").on("click", ".close", removeFile);

        });

        function cropImage(image, croppingCoords) {
            var cc = croppingCoords;
            var workCan = document.createElement("canvas"); // create a canvas
            workCan.width = Math.floor(cc.width); // set the canvas resolution to the cropped image size
            workCan.height = Math.floor(cc.height);
            var ctx = workCan.getContext("2d"); // get a 2D rendering interface
            ctx.drawImage(image, -Math.floor(cc.x), -Math.floor(cc.y)); // draw the image offset to place it correctly on the cropped region
            image.src = workCan.toDataURL(); // set the image source to the canvas as a data URL
            return image;
        }

        function drawImg() {
            cropImage(
                this, {
                    x: this.width / 4, // crop keeping the center
                    y: this.height / 4,
                    width: 100,
                    height: 100,
                });
            $('#result').append(this); // Add the image to the DOM
            img.removeEventListener("load", drawImg, true);
        }

        function handleFileSelect(e) {
            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            filesArr.forEach(function(f) {

                if (!f.type.match("image.*")) {
                    return;
                }
                // storedFiles.push(f);
                // console.log(f);
                var reader = new FileReader();

                reader.onload = function(e) {
                    var img = new Image();
                    img.src = e.target.result;
                    img.addEventListener("load", drawImg, true);


                    function drawImg() {
                        cropImage(
                            this, {
                                x: this.width / 4, // crop keeping the center
                                y: this.height / 4,
                                width: 300,
                                height: 300,
                            });
                        var html = '\
                    <div class = "img-wrap">\
                        <img src = "public/img/menu/close-box-black.png" class= "close" data-file="' + f.name + '" title="Click to remove"/>\
                        <img class = "img-attachment" src = "' + this.src + '"/>\
                    </div>';
                        $(".attachment-img-mes").append(html);
                        var file = dataURLtoFile(this.src, f.name);
                        storedFiles.push(file);

                        img.removeEventListener("load", drawImg, true);
                    }
                }
                reader.readAsDataURL(f);
            });
        }

        function dataURLtoFile(dataurl, filename) {

            var arr = dataurl.split(',');

            mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new File([u8arr], filename, {
                type: mime
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
</div>