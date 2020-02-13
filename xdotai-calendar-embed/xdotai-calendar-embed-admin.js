function xdotaiToggle () {
    console.log(jQuery('#xdotaiEmbedType').val());
    if (jQuery('#xdotaiEmbedType').val() == 'iframe') {
        jQuery('#xdotaiIframeHeight').parent().parent().show();
        jQuery('#xdotaiIframeWidth').parent().parent().show();
        jQuery('#xdotaiDataElement').parent().parent().hide();
        jQuery('#xdotaiDataHeight').parent().parent().hide();
        jQuery('#xdotaiDataWidth').parent().parent().hide();
    } else {
        jQuery('#xdotaiIframeHeight').parent().parent().hide();
        jQuery('#xdotaiIframeWidth').parent().parent().hide();
        jQuery('#xdotaiDataElement').parent().parent().show();
        jQuery('#xdotaiDataHeight').parent().parent().show();
        jQuery('#xdotaiDataWidth').parent().parent().show();
    }
}

jQuery('document').ready( function() { 
    xdotaiToggle(); 
    jQuery('#xdotaiEmbedType').on('change', function() { xdotaiToggle() } );
    jQuery('#xdotaiCalendarPage').on('blur', function() {
        var uri = jQuery('#xdotaiCalendarPage').val();
        // Full URL?
        if (uri.startsWith('https://x.ai/calendar')) {
            jQuery('#xdotaiCalendarPage').val(uri.replace('https://x.ai/calendar',''));
        }
        else if (uri.startsWith('/') === false) {
            jQuery('#xdotaiCalendarPage').val('/' + uri);
        } else
        {}
    });
} );