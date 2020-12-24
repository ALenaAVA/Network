$(window).load(function () {
    var sizer = '.sizer4';
    var container = $('#gallery');
    container.imagesLoaded(function () {
        container.masonry({
            itemSelector: '.item-masonry',
            columnWidth: sizer,
            percentPosition: true,
            horizontalOrder: true
        });
    })
})