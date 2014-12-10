jQuery(document).ready(function($) {

    // show hide all options depending on setting
    if ($('#enable_custom_loop #_exchange_custom_loop_enable_custom_loop').prop('checked') === true) {
        $('#exchange_custom_loop').show();
    } else {
        $('#exchange_custom_loop').hide();
    };

    // show hide options on change
    $("#enable_custom_loop #_exchange_custom_loop_enable_custom_loop").click(function () {
        if ($(this).prop('checked') === true) {
            $('#exchange_custom_loop').show('slow');
        } else {
            $('#exchange_custom_loop').hide('slow');
        }
    });
    
    // grey out options that are not applicable for "view - don't change"
    if ($('#_exchange_custom_loop_default_view3').prop('checked') === true) {
        $('.cmb_id__exchange_custom_loop_number_of_columns, .cmb_id__exchange_custom_loop_padding, .cmb_id__exchange_custom_loop_viewport, label[for = _exchange_custom_loop_show2]').addClass('fadethis').removeClass('dontfade');
    } else {
        $('.cmb_id__exchange_custom_loop_number_of_columns, .cmb_id__exchange_custom_loop_padding, .cmb_id__exchange_custom_loop_viewport, label[for = _exchange_custom_loop_show2]').addClass('dontfade').removeClass('fadethis');
    };

    // grey or un-grey options that are not applicable on change of "view"
    $('input[name="_exchange_custom_loop_default_view"]').change(function () {

        if ($('#_exchange_custom_loop_default_view3:checked').val() === 'none') {
            $('.cmb_id__exchange_custom_loop_number_of_columns, .cmb_id__exchange_custom_loop_padding, .cmb_id__exchange_custom_loop_viewport, label[for = _exchange_custom_loop_show2]').addClass('fadethis').removeClass('dontfade');
        } else {
            $('.cmb_id__exchange_custom_loop_number_of_columns, .cmb_id__exchange_custom_loop_padding, .cmb_id__exchange_custom_loop_viewport, label[for = _exchange_custom_loop_show2]').addClass('dontfade').removeClass('fadethis');
        }
    });

    // grey out options that are not applicable for "sort order - default"
    if ( $('select[name="_exchange_custom_loop_order_by"]').val() === 'default') {
        $('.cmb_id__exchange_custom_loop_order_seq').addClass('fadethis').removeClass('dontfade');
    } else {
        $('.cmb_id__exchange_custom_loop_order_seq').addClass('dontfade').removeClass('fadethis');
    };

    // grey or un-grey options that are not applicable on change of "sort order"
    $('select[name="_exchange_custom_loop_order_by"]').change(function () {

        if ( $('select[name="_exchange_custom_loop_order_by"]').val() === 'default') {
            $('.cmb_id__exchange_custom_loop_order_seq').addClass('fadethis').removeClass('dontfade');
        } else {
            $('.cmb_id__exchange_custom_loop_order_seq').addClass('dontfade').removeClass('fadethis');
        };
    });

});