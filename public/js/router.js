class Router {
    constructor() {
        this.link = 'a';
        this.container = '.pjax-container';
        this.options = undefined;
        this.pathURL = undefined;
        this.success = undefined;
        this.popstate();
    };

    start(data) {
        this.link = data.link;
        this.container = data.container;
        this.pathURL = this.getPathURL();

        var i = this;
        this.success = data.success;
        $(this.link).click(function (e) {
            if (i.pathURL !== location.pathname) {
                $(document).ready(function () {
                    if (i.getHTML() !== undefined) {
                        i.changeURL(i.pathURL);
                        i.getContent(i.getHTML(i.pathURL));
                        i.success;
                        i.start(data);
                       // i.reload(i.container);
                    }
                })
            } else
                i.reload(i.container);
        });
        return true;
    };

    getPathURL() {
        var i = this;
        $(i.link).click(function (e) {
            e.preventDefault();
            i.pathURL = $('a',this).attr('href');
        });
        return i.pathURL;
    };

    getHTML(path) {
        var text = false;
        $.ajax({
            url: path,
            type: 'POST',
            data: { url: path },
            processData: false,
            contentType: false,
            dataType: "json",
            async: false,
        }).done(function (data) {
            text = data;
        });
        return text;
    };

    getContent(data) {
        this.getTitle(data);
        data = $("<head>", { html: data }).find(this.container).html();
        if ($(this.container).html(data) !== undefined) {
            return true;
        } else {
            return false;
        }
    };

    getTitle(data) {
        var title = $("<head>", { html: data }).find('title').text();
        document.title = title;
        return title;
    };

    changeURL(url) {
        $(document).ready(function () {
            history.pushState(null, null, url);
        });
        return url;
    };

    popstate() {
        var i = this;
        window.addEventListener('popstate', function () {
            $.ajax({
                url: location.pathname,
                type: 'POST',
                async: false,
                success: function (data) {
                    i.getContent(data);
                    document.title = i.getTitle(data);
                    i.start({
                        link: i.link,
                        container: i.container,
                        success: i.success
                    });
                }
            });
        });
        return true;
    };

    reload(container) {
        var i = this;
        $.ajax({
            url: i.pathURL,
            type: 'POST',
            async: false,
            success: function (data) {
                data = $("<html>", { html: data }).find(container).html();
                $(container).html(data);
            },
            error:function (data) {
                console.log(data);
            }
        });
        return true;
    };

    submit(path, reload, func) {
        this.pathURL = path;
        var i = this;
        var res = false;
        $.ajax({
            url: i.pathURL,
            type: 'POST',
            async: false,
            success: function (data) {
                if (reload === true) {
                    i.changeURL(i.pathURL);
                }
                i.getTitle(data);
                if (i.getContent(data) !== false & func !== undefined) {
                    func();
                }
                i.start({
                    link: i.link,
                    container: i.container,
                    success: i.success
                });
                res = true;
            }
        });
        return res;
    }

}


// var Router = {
//     link: 'a',
//     container: 'body',
//     options: undefined,
//     pathURL: undefined,
//     success: undefined,

//     start: function (data) {
//         this.link = data.link;
//         this.container = data.container;
//         // this.options = data.options;
//         this.getPathURL();
//         this.success = data.success();
//     },

//     getPathURL: function () {
//         var i = this;
//         $(i.link).click(function (e) {
//             e.preventDefault();
//             i.pathURL = $(this).attr('href');
//             i.getContent();
//         });
//     },

//     getContent: function () {
//         var i = this;
//         history.pushState(null, null, i.pathURL);
//         $.ajax({
//             url: i.pathURL,
//             type: 'POST',
//             data: { url: i.pathURL },
//             success: function (data) {
//                 $(document).ready(function () {
//                     i.destroyCurrentPage();
//                     i.changeURL();
//                     var title = $("<head>", { html: data }).find('title').text();
//                     data = $("<head>", { html: data }).find(i.container).html();
//                     $(i.container).html(data);
//                     document.title = title;
//                     $(i.container).css({ 'display': 'none' });
//                     $(i.container).show();
//                     i.getPathURL();
//                 })
//             }
//         }).done(function () {
//             if (i.success !== undefined)
//                 i.success();
//             else
//                 i.reload('.top-block');
//         });
//     },
//     destroyCurrentPage: function () {
//         var i = this;
//         $(this.container).html('');
//     },
//     changeURL: function () {
//         var i = this;
//        // history.pushState(null, null, i.pathURL);
//         $(document).ready(function () {
//             window.addEventListener('popstate', function () {
//                 $.ajax({
//                     url: location.pathname,
//                     type: 'POST',
//                     success: function (data) {
//                         i.destroyCurrentPage();
//                         var title = $("<head>", { html: data }).find('title').text();
//                         data = $("<head>", { html: data }).find(i.container).html();
//                         $(i.container).html(data);
//                         document.title = title;
//                         $(i.container).css({ 'display': 'none' });
//                         $(i.container).show();
//                         i.getPathURL();
//                     }
//                 })
//             })
//         });
//     },
//     reload: function (container) {
//         var i = this;
//         $(document).ready(function () {
//             $.ajax({
//                 url: location.pathname,
//                 type: 'POST',
//                 success: function (data) {
//                     data = $("<body>", { html: data }).find(container).html();
//                     $(container).html(data);
//                     $(container).css({ 'display': 'none' });
//                     $(container).show();
//                     i.getPathURL();
//                 }
//             })
//         })
//     },
//     submit: function (path) {
//         this.pathURL = path;
//         this.getContent();
//     },
// };
