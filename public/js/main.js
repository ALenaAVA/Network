var r = new Router();
var d = new Router();
var b = new Router();

var go = function (e, a) {
    r.start({
        link: '.pjax-container-link',
        container: '.pjax-container',
        success: function () {
            r.reload('.top-block');
        }
    });

    d.start({
        link: '.pjax-page-link',
        container: '.pjax-page',
        success: function () {
            d.reload('.title-page');
        }
    });
    b.start({
        link: '.pjax-block-link',
        container: '.pjax-block',
        success: function () {
            b.reload('.title-page');
        }
    });
    var _;
    if ('.' + $(e).attr('class') === r.link) {
        _ = r;
    }
    if ('.' + $(e).attr('class') === d.link) {
        _ = d;
    }
    if ('.' + $(e).attr('class') === b.link) {
        _ = b;
    }
    a.preventDefault();
    _.pathURL = $(e).attr('href');
    if (_.pathURL !== location.pathname) {
        if (_.getHTML() !== undefined) {
            _.changeURL(_.pathURL);
            _.success();
            _.reload(_.container);
        }
    }
    else {
        _.reload(_.container);
    }
}


var www = '/network3';
var speedAnimation = 1000;
var APP = {
    element: undefined,
    action: {
        edit: function () {
            var name = $('#username').val().trim();
            var day = $('#day').val().trim();
            var month = $('#month').val().trim();
            var year = $('#year').val().trim();
            
            var sex = $('#sex').val().trim();
            
            var password = $('#password').val().trim();
            if (name !== "" && name.search(/^[a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ\-`]{1,20} [a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ\-`]{1,30}$/) === -1) {
                alert('Введите сначала Имя потом Фамилию');
                return;
            }
            if (password != "" && password.search(/[a-zA-Z0-9-#$%]{6,15}$/) === -1) {
                alert('Пароль должен быть от 6 до 15 символов,состоять из латинских букв и чисел, (-#$%)');
                return;
            }
            APP.query(www + '/vendor/action/edit.php', {
                name: name,
                day: day,
                month: month,
                year: year,
                sex: sex,
                password: password
            }, function (data) {
                if (data['return'] === 'success') {
                    APP.animate.load.btn(APP.element, "r.submit('" + www + "/@" + data['login'] + "',true)", speedAnimation);
                } else {
                    console.log(data);
                    $("#loading-input").prop("disabled", false);
                    $('#loading-input').attr({ 'value': 'Cохранить' });
                    $('#loading-input').css({ 'background-image': 'none' })
                }


            }, function (data) {
                console.log(data.responseText);
            }, 'json',
                function () {
                    $('#loading-input').attr({ 'value': '' });
                    $("#loading-input").prop("disabled", true);

                    $('#loading-input').css({
                        'background-image': 'url("public/img/other/loading.gif")',
                        'background-repeat': 'no-repeat',
                        'background-position': 'center'
                    });
                });
            
        },
        search: function (e, input) {
            var text = $(input).val().trim();

            var key = e.which;
            if (key == 13) {
                APP.query(www + '/vendor/action/search.php', { text: text }, function (data) {
                    APP.animate.load.btn(APP.element, "d.submit('" + www + "/search',true)", speedAnimation);
                    console.log(data);
                }, function (data) {
                    console.log(data.responseText);
                });
            }
        },
        friendRequest: function (e, login) {
            APP.query(www + '/vendor/action/friendRequest.php', { login: login }, function (data) {
                var block = '';
                if (data['return'] === 'success') {
                    block = '\
                    <select  class="change-request-block">\
                      <option selected>Заявка отправлена</option>\
                    </select>\
                    ';
                    $(e).parent().html(block);
                    //  $('select').dropdown();<option>Отменить заявку</option>\
                }
                // console.log(data);
            }, function (data) {
                console.log(data.responseText);
            }, 'json');
        },
        confirmFriendRequest: function (e, login) {
            APP.query(www + '/vendor/action/friendRequest.php', { login: login }, function (data) {
                var block = '';
                if (data['return'] === 'success') {
                    block = '\
                    <select  class="change-request-block">\
                      <option selected>У Вас в друзьях</option>\
                      <option>Убрать из друзей</option>\
                    </select>\
                    ';
                    $(e).parent().html(block);
                    // $('select').dropdown();
                }
            });
        },

        confirmRegist: function () {
            var pin = $('#pin').val().trim();
            APP.query(www + '/vendor/action/regist.php', { step: 'confirm', pin: pin }, function (data) {
                if (data['return'] == 'success') {
                    APP.animate.load.btn(APP.element, "r.submit('" + www + "/auth/finish',true)", speedAnimation);
                }
                else {
                    alert("Pin-code не верен")
                    $("#loading-input").prop("disabled", false);
                    $('#loading-input').attr({ 'value': 'Подтвердить' });
                    $('#loading-input').css({ 'background-image': 'none' })
                }
            }, function (data) {
                console.log(data);
            }, 'json',
                function () {
                    $('#loading-input').attr({ 'value': '' });
                    $("#loading-input").prop("disabled", true);

                    $('#loading-input').css({
                        'background-image': 'url("../public/img/other/loading.gif")',
                        'background-repeat': 'no-repeat',
                        'background-position': 'center'
                    })
                });
        },

        exit: function () {
            var c = $('.messages-container-nav');
            if (c.length != 0) {
                APP.window.form.messagesContainerClose($('.messages-container-nav'));
            }
            APP.query(www + '/vendor/action/exit.php', {}, function (data) {
                if (data['return'] === 'success') {
                    r.submit(www + "/login", true, function () { r.reload('.top-block') });
                } else {
                    console.log(data);
                }
            }, function (data) {
                console.log(data.responseText);
            });
        },

        finishRegist: function () {
            var login = $('#login').val().trim();
            if (login.search(/^[a-zA-Z0-9-_]{1,15}$/) === -1) {
                alert('Логин может состоять из латинских буквенно-числовых символов включая(-_) длинна не более 15');
                return;
            }
            APP.query(www + '/vendor/action/regist.php', { step: 'finish', login: login }, function (data) {
                console.log(data);

                if (data['return'] == 'success') {
                    APP.animate.load.btn(APP.element, "r.submit('" + www + "/@" + data['path'] + "',true)", speedAnimation);
                    APP.animate.load.btn(APP.element, "r.reload('.top-block')", speedAnimation);
                } else {
                    alert("Этот логин уже занят")
                    $("#loading-input").prop("disabled", false);
                    $('#loading-input').attr({ 'value': 'Подтвердить' });
                    $('#loading-input').css({ 'background-image': 'none' })
                }
            }, function (data) {
                console.log(data);
            }, 'json',
                function () {
                    $('#loading-input').attr({ 'value': '' });
                    $("#loading-input").prop("disabled", true);

                    $('#loading-input').css({
                        'background-image': 'url("../public/img/other/loading.gif")',
                        'background-repeat': 'no-repeat',
                        'background-position': 'center'
                    })
                });
        },

        hotkey: function () {
            var body = document.body;
            document.onkeydown = function (e) {
                if (e.keyCode === 27) {
                    $('.layer-bg').html('');
                    $('.layer-bg').hide();
                    return false;
                }
                if (e.ctrlKey && e.keyCode === 'I'.charCodeAt(0)) {
                    APP.window.modal({ data: this, type: 'createNewPost' });
                    return false;
                }
                if (e.ctrlKey && e.keyCode === 'O'.charCodeAt(0)) {
                    APP.upload.post.save('#new-post-text');
                    return false;
                }

            }
        },

        login: function () {
            var login = $('#login').val().trim();
            var password = $('#password').val().trim();
            if (login && password) {
                APP.query(www + '/vendor/action/login.php', { login: login, password: password },
                    function (data) {
                        if (data['return'] === 'success') {
                            APP.animate.load.btn(APP.element, "r.submit('" + www + "/@" + data['login'] + "',true)", speedAnimation);
                            APP.animate.load.btn(APP.element, "r.reload('.top-block')", speedAnimation);
                        } else {
                            alert("Логин или пароль введены неверно")
                            console.log(data);

                            $("#loading-input").prop("disabled", false);
                            $('#loading-input').attr({ 'value': 'Войти' });
                            $('#loading-input').css({ 'background-image': 'none' })
                        }
                    }, '', 'json',
                    function () {
                        $('#loading-input').attr({ 'value': '' });
                        $("#loading-input").prop("disabled", true);

                        $('#loading-input').css({
                            'background-image': 'url("public/img/other/loading.gif")',
                            'background-repeat': 'no-repeat',
                            'background-position': 'center'
                        })
                    }
                );
            }
        },

        regist: function () {
            var name = $('#username').val().trim();
            var day = $('#day').val().trim();
            var month = $('#month').val().trim();
            var year = $('#year').val().trim();
            var sex = $('#sex').val().trim();
            var email = $('#email').val().trim();
            var password = $('#password').val().trim();
            if (name.search(/^[a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ\-`]{1,20} [a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ\-`]{1,30}$/) === -1) {
                alert('Введите сначала Имя потом Фамилию');
                return;
            }
            if (email.search(/[-._a-z0-9]+@(?:[a-z0-9][a-z0-9]+\.)+[a-z]{2,10}$/) === -1) {
                alert('Введите сначала E-mail');
                return;
            }
            if (password.search(/[a-zA-Z0-9-#$%]{6,15}$/) === -1) {
                alert('Пароль должен быть от 6 до 15 символов,состоять из латинских букв и чисел, (-#$%)');
                return;
            }
            //[a-zA-Z0-9]{6,15}
            APP.query(www + '/vendor/action/regist.php', {
                step: 'regist',
                name: name,
                day: day,
                month: month,
                year: year,
                sex: sex,
                email: email,
                password: password
            }, function (data) {
                console.log(data);

                if (data['return'] === 'success') {
                    console.log(data);

                    APP.animate.load.btn(APP.element, "r.submit('" + www + "/auth/confirm',true)", speedAnimation);
                } else if (data['return'] === 'error email exist') {
                    alert("Пользователь с таким E-mail уже существует")
                    $("#loading-input").prop("disabled", false);
                    $('#loading-input').attr({ 'value': 'Войти' });
                    $('#loading-input').css({ 'background-image': 'none' })
                } else {
                    alert("Письмо на E-mail, для завершения регистрации, не может быть отправлено")
                    console.log(data);
                    $("#loading-input").prop("disabled", false);
                    $('#loading-input').attr({ 'value': 'Войти' });
                    $('#loading-input').css({ 'background-image': 'none' })
                }


            }, function (data) {
                console.log(data.responseText);
            }, 'json',
                function () {
                    $('#loading-input').attr({ 'value': '' });
                    $("#loading-input").prop("disabled", true);

                    $('#loading-input').css({
                        'background-image': 'url("public/img/other/loading.gif")',
                        'background-repeat': 'no-repeat',
                        'background-position': 'center'
                    })
                });
        }

    },
    date: {
        formate: function (e) {
            var d = document.getElementsByClassName(e);
            // console.log(d);
            for (let i = 0; i < d.length; i++) {
                var s = d[i];
                s.innerText = moment(s.innerHTML, 'DD.MM.YYYY', 'ru').format('DD MMMM YYYY');
                // console.log(s.innerText);
            }
        },
        dateTime: function (e) {
            var d = document.getElementsByClassName(e);
            // console.log(d);
            for (let i = 0; i < d.length; i++) {

                var s = d[i];
                s.innerText = moment(s.innerHTML, 'DD.MM.YYYY hh:mm', 'ru').format('DD MMMM YYYY в hh:mm');
            }
        }
    },
    query: function (url, data, success, error, dataType = 'json', beforeSend = undefined, complete = undefined) {

        formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: dataType,
            success: success,
            error: error,
            beforeSend: beforeSend,
            complete: complete,
        });
    },
    animate: {
        load: {
            btn: function (e, f, s) {
                s = (s === undefined) ? s = 1 : s = s;
                $(e).css({
                    "background-image": "url('/public/img/other/no-banner.png')",
                    "background-size": "calc(100 % - 30px) calc(100% - 25px)",
                    "background-repeat": "no - repeat",
                    "background-position": "center",
                    "color": "rgba(0, 0, 0, 0)"
                });
                setTimeout(f, s);
            }
        },
        hideLeftMenu: function (block, speed) {
            alert("hideLeftMenu");
            // $(block).animate({
            //     'margin-left': '-24%',
            // }, speed, 'linear');
            // // $('.page').animate({
            // //     'width': '100%',
            // // }, speed, 'linear');
            $('.left-menu-controll').attr('onclick', 'APP.animate.showLeftMenu("' + block + '",' + speed + ')');
        },
        showLeftMenu: function (block, speed) {
            alert("showLeftMenu");
            // $(block).animate({
            //     'margin-left': '0'
            // }, speed);
            // // $('.page').animate({
            // //     'width': '76%'
            // // }, speed);
            $('.left-menu-controll').attr('onclick', 'APP.animate.hideLeftMenu("' + block + '",' + speed + ')');
        },

    },
    upload: {
        avatar: function (func) {
            $(document).ready(function () {
                $("#drop-zone").on('dragover', function () {
                    $(this).addClass('drop-over');
                    return false;
                });
                $("#drop-zone").on('dragleave', function () {
                    $(this).removeClass('drop-over');
                    return false;
                })
                $("#drop-zone").on('drop', function (e) {
                    e.preventDefault();

                    $(this).removeClass('drop-over');
                    var json;
                    var formData = new FormData();
                    var files = e.originalEvent.dataTransfer.files;
                    formData.append('file[]', files[0]);
                    formData.append('type', 'avatar');

                    $.ajax({
                        url: '/network3/vendor/action/upload.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (data) {
                            json = jQuery.parseJSON(data);
                            if (json.return === 'success') {
                                func(json.data);
                            }
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                })
            });
        },
        post: {
            save: function (e) {
                var text = $(e).val().trim();
                if (text === '') return;

                var formdata = new FormData();
                for (var i = 0, len = storedFiles.length; i < len; i++) {
                    formdata.append('files[]', storedFiles[i]);
                }
                formdata.append('type', 'savePost');
                formdata.append('text', text);
                formdata.append('page', location.pathname.substr(10));

                $.ajax({
                    url: www + '/vendor/action/posts.php',
                    type: 'POST',
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    async: false,
                    success: function (data) {
                        if (data['return'] === 'success') {
                            $('.layer-bg').html('');
                            $('.layer-bg').hide();
                            APP.upload.post.getList('.user-posts-container', '*')
                        }
                    }, error: function (data) {
                        console.log(data.responseText);
                    }
                });
            },
            getList: function (b, count) {
                var login = location.pathname.substr(11);
                APP.query(www + '/vendor/action/posts.php', { type: 'getPosts', login: login, count: count, revers: true }, function (data) {
                    // console.log(data);
                    if (data['return'] === 'empty') {
                        console.log('empty posts');
                    }
                    else {
                        APP.query(www + '/app/modal/postBlockStd.php', { e: JSON.stringify(data) }, function (data) {
                            $(b).html(data);
                            APP.date.dateTime('date-and-time');

                        }, function (e) {
                            console.log(e.responseText);
                        }, 'html');
                        //console.log(data);
                    }
                }, function (e) {
                    console.log(e.responseText);
                });
            }
        },
        message: {
            send: function (e, friendId) {
                var text = $(e).val().trim();
                if (text === '') return;

                var formdata = new FormData();
                for (var i = 0, len = storedFiles.length; i < len; i++) {
                    formdata.append('files[]', storedFiles[i]);
                }
                //console.log(storedFiles);
                formdata.append('type', 'addMessage');
                formdata.append('text', text);
                formdata.append('recipient', friendId);

                $.ajax({
                    url: www + '/vendor/action/messages.php',
                    type: 'POST',
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    async: false,
                    success: function (data) {
                        console.log(data);
                        storedFiles.length = 0;
                        $('.attachment-img-mes').empty();
                        APP.upload.message.getList('.messages-block', friendId);
                        // if (data['return'] === 'success') {

                        //     // $('.layer-bg').html('');
                        //     // $('.layer-bg').hide();
                        //     // APP.upload.post.getList('.user-posts-container','*')
                        // }
                    }, error: function (data) {
                        console.log(data.responseText);
                    }
                });

                $(e).val('');
                //storedFiles.length = 0;
            },
            getList: function (b, id) {

                APP.query(www + '/vendor/action/messages.php', { type: 'getMessages', friend: id }, function (data) {
                    var block = '';
                    for (let i = 0; i < data.length; i++) {
                        if (data[i]['sender'] == id) {
                            block += '<div class="message-friend"><div class="intro-block"><div class = "text-message-friend">' + data[i]['text'] + '</div></div>';
                            if (data[i]['insertions'].length != 0) {
                                block += '<div class="img-message">';
                                for (let j = 0; j < data[i]['insertions'].length; j++) {
                                    block += '<img class = "insertion-friend" src = "/network3/uploads/insertions/' + data[i]['insertions'][j]['name_file'] + '"></img>';
                                }
                                block += '</div>';
                            }
                            block += '</div>';
                        }
                        else {
                            block += '<div class="message"><div class="intro-block"><div class = "text-message">' + data[i]['text'] + '</div></div>';
                            if (data[i]['insertions'].length != 0) {
                                block += '<div class="img-message">';
                                for (let j = 0; j < data[i]['insertions'].length; j++) {
                                    block += '<img class = "insertion" src = "uploads/insertions/' + data[i]['insertions'][j]['name_file'] + '"></img>';
                                }
                                block += '</div>';
                            }
                            block += '</div>';
                        }
                        // console.log(data[i]['sender'] + '  id ' + id);
                    }

                    $(b).html(block);

                    $(b).scrollTop($(b).prop('scrollHeight'));
                    // console.log(data);

                }, function (e) {
                    console.log(e.responseText);
                });
            }
        },
        friends: {
            list: function (cat) {
                APP.query(www + '/app/modal/friendsList.php', { cat: cat }, function (data) {
                    $('.friends-list-block .list-block .wrap').html(data);
                    //console.log(data);
                }, function (data) {
                    console.log(data.responseText);
                }, 'html');
            },
            searchList: function () {
                APP.query(www + '/app/modal/searchList.php', {}, function (data) {
                    $('.friends-list-block .list-block .wrap').html(data);
                    console.log(data);
                }, function (data) {
                    console.log(data.responseText);
                }, 'html');
            }
        },
        photos: {
            list: function () {
                APP.query(www + '/app/modal/photosList.php', {}, function (data) {
                    $(' .list-block .wrap .photos-list-block').html(data);
                    // console.log(data);
                }, function (data) {
                    console.log(data.responseText);
                }, 'html');
            },
            cancel: function (id, name) {
                var remove = confirm("Вы действительно хотите удалить это изображение?");
                if (remove) {
                    document.getElementById(name).closest('#photo-block').remove();
                    APP.query(www + '/vendor/action/photos.php', { type: 'cancel', id: id }, function (data) {
                    }, function (data) {
                        console.log(data.responseText);
                    });
                }
            },
            check: function (id, name) {
                var check = confirm("Вы действительно хотите сохранить это изображение?");
                console.log(check);

                if (check) {
                    document.getElementById(name).closest('#photo-block').remove();
                    APP.query(www + '/vendor/action/photos.php', { type: 'check', id: id }, function (data) {
                    }, function (data) {
                        console.log(data.responseText);
                    });
                }
            }
        }
    },
    window: {
        notifications: {
            getCount: function () {
                APP.query(www + '/vendor/action/notifications.php', { type: 'getCount' }, function (data) {
                    if (data != 0)
                        $('#notifications .count').text(data).css({ 'display': 'block' });
                    //r.reload('title');
                    //console.log(data);
                }, function (data) {
                    console.log(data.responseText);
                });
            },
            getList: function () {
                APP.query(www + '/vendor/action/notifications.php', { type: 'getList' }, function (data) {
                    APP.query(www + '/app/modal/listUserNotification.php', { e: JSON.stringify(data) }, function (data) {
                        $('#notifications .list').html(data);
                        $('#notifications .list').show();
                        APP.query(www + '/vendor/action/notifications.php', { type: 'viewed' }, function (data) {
                            if (data['return'] === 'success') {
                                // APP.window.notifications.getCount();
                                $('#notifications .count').css({ 'display': 'none' });

                            }
                            // console.log(data);
                        }, function (data) {
                            console.log(data);
                        });
                        $(document).mousedown(function (e) {
                            var container = $('#notifications');
                            if (!container.is(e.target) && container.has(e.target).length === 0) {
                                $('#notifications .list').html('');
                                $('#notifications .list').hide();
                            }
                        })

                    }, '', 'html');
                }, function (data) {
                    console.log(data.responseText);
                }, 'json');
            }
        },
        modal: function (data) {
            $('.layer-bg').css('display', 'flex');
            var type = data.type;
            if (type === 'forChooseAvatar') {
                APP.query(www + '/app/modal/forChooseAvatar.php', {}, function (data) {

                    $('.layer-bg').html(data);
                    APP.upload.avatar(function (e) {
                        APP.window.modal({ type: 'cropAvatar', data: e });
                    });
                    $('#file-avatar').on('change', function (e) {
                        e.preventDefault();
                        $(this).removeClass('drop-over');
                        var formData = new FormData();
                        var files = e.target.files;
                        formData.append('file[]', files[0]);
                        formData.append('type', 'avatar');

                        $.ajax({
                            url: '/network3/vendor/action/upload.php',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function (data) {
                                json = jQuery.parseJSON(data);
                                if (json.return === 'success') {
                                    //func(json.data);
                                    APP.window.modal({ type: 'cropAvatar', data: data[1] });
                                }
                            },
                            error: function (data) {
                                console.log(data.responseText);
                            }
                        });


                    })
                }, '', 'html');
            } else if (type === 'cropAvatar') {
                APP.query(www + '/app/modal/cropAvatar.php', {}, function (data) {

                    $('.layer-bg').html(data);
                    APP.window.crop(1, 1);
                }, '', 'html');
            } else if (type === 'cropBanner') {
                APP.query(www + '/app/modal/cropBanner.php', {}, function (data) {

                    $('.layer-bg').html(data);
                    APP.window.crop(1.5, 0.8);
                    console.log(999);
                }, '', 'html');
            } else if (type === 'createNewPost') {
                APP.query(www + '/app/modal/createNewPost.php', {}, function (data) {

                    $('.layer-bg').html(data);
                    $('textarea').focus();
                }, function (e) {
                    console.log(e.responseText);
                }, 'html');
            } else if (type === 'forChooseBanner') {
                APP.query(www + '/app/modal/forChooseBanner.php', {}, function (data) {

                    $('.layer-bg').html(data);

                    APP.upload.avatar(function (e) {
                        APP.window.modal({ type: 'cropBanner', data: e });
                    });
                    $('#file-avatar').on('change', function (e) {
                        e.preventDefault();
                        $(this).removeClass('drop-over');
                        var files = e.target.files;

                        APP.query('/network3/vendor/action/upload.php', { 'file[]': files[0], 'type': 'banner' }, function (data) {
                            APP.window.modal({ type: 'cropBanner', data: data[1] });
                            // console.log(data);
                        }, function (data) {
                            console.log(data.responseText);
                        });
                    })
                }, '', 'html');
            }
        },
        crop: function (w, h, img = '.layer-bg .img-avatar-block-cropper img') {
            var img = document.querySelector(img);
            var cropper = new Cropper(img, {
                aspectRatio: w / h,
                zoomable: false,
                autoCropArea: 1,
                minCropBoxHeight: 100,
                minCropBoxWidth: 100,
                dragMode: 'move',
                background: false,
                viewMode: 1,
                coords: this.coords,
                crop: function (e) {
                    cropper.coords = { top: e.detail.y, left: e.detail.x, width: e.detail.width, height: e.detail.height };
                    console.log(e);
                    return false;
                }
            });
            cropper.crop(h, w);
            $('#saveUserAvatar').click(function () {
                cropper.getCroppedCanvas().toBlob(function (blob) {
                    var top = cropper.coords.top,
                        left = cropper.coords.left,
                        width = cropper.coords.width,
                        height = cropper.coords.height;
                    var formData = new FormData();
                    formData.append('top', top);
                    formData.append('left', left);
                    formData.append('width', width);
                    formData.append('height', height);
                    formData.append('type', 'saveAvatar');
                    $.ajax({
                        url: '/network3/vendor/action/upload.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (data) {
                            $(document).ready(function () {
                                wait(data, function (data) {
                                    $(".layer-wrap").hide(1000);
                                    $(".layer-bg").hide(200);
                                    r.reload('.pjax-container');
                                    r.reload('.top-block');
                                    r.reload('title');
                                })
                            })
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                    return false;
                });
            });
            $('#saveUserBanner').click(function () {
                cropper.getCroppedCanvas().toBlob(function (blob) {
                    var top = cropper.coords.top,
                        left = cropper.coords.left,
                        width = cropper.coords.width,
                        height = cropper.coords.height;
                    var formData = new FormData();
                    formData.append('top', top);
                    formData.append('left', left);
                    formData.append('width', width);
                    formData.append('height', height);
                    formData.append('type', 'saveBanner');
                    $.ajax({
                        url: '/network3/vendor/action/upload.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (data) {
                            $(document).ready(function () {
                                wait(data, function (data) {
                                    $(".layer-wrap").hide(1000);
                                    $(".layer-bg").hide(200);
                                    r.reload('.pjax-container');
                                    r.reload('.top-block');
                                    r.reload('title');
                                    console.log(data);

                                })
                            })
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                    return false;
                });
            });
            function wait(data, callback) {
                callback(data);
            }
        },
        form: {
            topMainMenu: function () {
                APP.query(www + '/app/modal/topMainMenu.php', {}, function (data) {
                    $("#top-controll-btn").append(data);
                    $(document).mousedown(function (e) {
                        var container = $('.main-top-menu-nav');
                        if (!container.is(e.target) && container.has(e.target).length === 0) {
                            container.remove();
                        }
                    });
                }, function (e) {
                    console.log(e.responseText);
                }, 'html');
            },
            messagesContainer: function (id) {
                var c = $('.messages-container-nav');
                if (c.length != 0) {
                    APP.window.form.messagesContainerClose($('.messages-container-nav'));
                }
                APP.query('app/modal/messagesContainer.php', { id: id }, function (data) {
                    $('body').append(data);

                }, function (data) {
                    console.log(data.responseText);
                }, 'html')
            },
            messagesContainerClose: function (e) {
                var container = $('.messages-container-nav');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.remove();
                    clearInterval(interval.i);
                }
            },
        },
        onload: function (e) {
            window.onload = function () {
                e();
                return false;
            };
        }
    }
};

$(document).ready(function () {
    APP.window.onload(function () {
        APP.action.hotkey();
        APP.window.notifications.getCount();
        setInterval('APP.window.notifications.getCount();', 5000);
    })
    $(".change-request-block").change(function () {
        var e =$(this);
        if ($(this).val() === "Убрать из друзей") {
            var answer = confirm("Вы действительно хотите отменить дружбу")
            if (answer) {
                APP.query("vendor/action/removeFriend.php", { type: "remove", login: location.pathname.substr(11) }, function (data) {
                    if(data['return']=='success'){
                        console.log(data);
                        
                        var block = `<input onclick="APP.action.friendRequest(this, '`+location.pathname.substr(11)+`')" type="submit" id="add-friend-btn" value="Добавить в друзья">`;
                        $(e).parent().html(block);
                    }else{
                        alert("Не удалось отменить дружбу")
                    }

                }, function (data) {
                    console.log(data.responseText);

                });
            }
        }
    });
})

$(document).mousedown(function (e) {
    var container = $('.layer-wrap');
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $('.layer-bg').html('');
        $('.layer-bg').hide();
    }
})

