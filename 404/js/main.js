$(function(){
    $('.js-position-center').each(function(){
        $(this).css({
            width: '100%',
            maxWidth: $(this).outerWidth(),
            height: '100%',
            maxHeight: $(this).outerHeight(),
            margin: 'auto',
            position: 'absolute',
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        });
    });
});
