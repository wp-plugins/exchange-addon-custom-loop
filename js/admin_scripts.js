jQuery(document).ready(function($) {

    if ($('#enable_custom_loop #_exchange_custom_loop_enable_custom_loop').prop('checked') === true) {
        $('#exchange_custom_loop').show();
    } else {
        $('#exchange_custom_loop').hide();
    };

    $("#enable_custom_loop #_exchange_custom_loop_enable_custom_loop").click(function () {
        if ($(this).prop('checked') === true) {
            $('#exchange_custom_loop').show('slow');
        } else {
            $('#exchange_custom_loop').hide('slow');
        }
    });

});