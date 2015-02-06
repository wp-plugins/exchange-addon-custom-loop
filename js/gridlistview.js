jQuery(document).ready(function($){

    $('#grid').click(function() {
            $(this).addClass('active');
            $('#list').removeClass('active');
            $.cookie('gridcookie','grid', { path: '/' });
            $('ul.it-exchange-products').fadeOut(300, function() {
                $(this).addClass('grid').removeClass('list').fadeIn(300);
            });
        return false;
    });

    $('#list').click(function() {
            $(this).addClass('active');
            $('#grid').removeClass('active');
            $.cookie('gridcookie','list', { path: '/' });
            $('ul.it-exchange-products').fadeOut(300, function() {
                $(this).removeClass('grid').addClass('list').fadeIn(300);
            });
        return false;
    });

    if ($.cookie('gridcookie')) {
        $('ul.it-exchange-products, .it-exchange-custom-loop-view-selection').addClass($.cookie('gridcookie'));
    }

    if ($.cookie('gridcookie') == 'grid') {
        $('.it-exchange-custom-loop-view-selection #grid').addClass('active');
        $('.it-exchange-custom-loop-view-selection #list').removeClass('active');
    }

    if ($.cookie('gridcookie') == 'list') {
        $('.it-exchange-custom-loop-view-selection #list').addClass('active');
        $('.it-exchange-custom-loop-view-selection #grid').removeClass('active');
    }

    $('.it-exchange-custom-loop-view-selection a').click(function(event) {
        event.preventDefault()
    })
    
});