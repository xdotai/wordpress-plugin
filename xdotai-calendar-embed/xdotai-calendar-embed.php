<?php
/**
 * Plugin Name:     x.ai Calendar Embed
 * Plugin URI:      https://help.x.ai/en/articles/3607063-how-do-i-embed-my-calendar-page
 * Description:     Use this simple plugin to quickly embed your x.ai calendar pages anywhere on your Wordpress site with the shortcode [xai-calendar].
 * Author:          x.ai
 * Author URI:      https://x.ai
 * Version:         0.1.0
 * License:         GPL2
 
x.ai Calendar Embed is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
x.ai Calendar Embed is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with x.ai Calendar Embed. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.
*/

add_action( 'admin_menu', 'xdotai_add_admin_menu' );
add_action( 'admin_init', 'xdotai_settings_init' );

function xdotai_add_admin_menu(  ) {
    add_options_page( 'x.ai Calendar Embed', 'x.ai Calendar Embed', 'manage_options', 'xdotai-settings-page', 'xdotai_options_page' );
}

function xdotai_settings_init(  ) {
    register_setting( 'xdotaiPlugin', 'xdotai_settings', array('sanitize_callback'=>'xdotai_sanitize_input') );
    add_settings_section(
        'xdotai_xdotaiPlugin_section',
        __( 'Embedded Calendar Options', 'wordpress' ),
        'xdotai_settings_section_callback',
        'xdotaiPlugin'
    );

    add_settings_field(
        'xdotai_calendar_url',
        __( 'Your calendar page URL', 'wordpress' ),
        'xdotai_text_field_0_render',
        'xdotaiPlugin',
        'xdotai_xdotaiPlugin_section'
    );
    
    add_settings_field(
        'xdotai_select_field_1',
        __( 'Type of embed', 'wordpress' ),
        'xdotai_select_field_1_render',
        'xdotaiPlugin',
        'xdotai_xdotaiPlugin_section'
    );
    
    add_settings_field(
        'iframeHeight',
        __( 'Embed height', 'wordpress' ),
        'xdotai_iframeHeight_render',
        'xdotaiPlugin',
        'xdotai_xdotaiPlugin_section'
    );
    
    add_settings_field(
        'iframeWidth',
        __( 'Embed width', 'wordpress' ),
        'xdotai_iframeWidth_render',
        'xdotaiPlugin',
        'xdotai_xdotaiPlugin_section'
    );
    
    add_settings_field(
        'dataHeight',
        __( 'Popup height', 'wordpress' ),
        'xdotai_dataHeight_render',
        'xdotaiPlugin',
        'xdotai_xdotaiPlugin_section'
    );
    
    add_settings_field(
        'dataWidth',
        __( 'Popup width', 'wordpress' ),
        'xdotai_dataWidth_render',
        'xdotaiPlugin',
        'xdotai_xdotaiPlugin_section'
    );
    
    add_settings_field(
        'dataElement',
        __( 'Clickable element (advanced)', 'wordpress' ),
        'xdotai_dataElement_render',
        'xdotaiPlugin',
        'xdotai_xdotaiPlugin_section'
    );
}

function xdotai_text_field_0_render(  ) {
    $options = get_option( 'xdotai_settings' );
    ?>
    <input id="xdotaiCalendarPage" type='text' name='xdotai_settings[xdotai_calendar_url]' value='<?php echo $options['xdotai_calendar_url']; ?>'> The URL of your calendar page. Do not include <span style="font-family:courier;color:red;">https://x.ai/calendar</span>. Example: <span span style="font-family:courier;color:green;">/jenbot/phone</span>
    <?php
}

function xdotai_iframeHeight_render(  ) {
    $options = get_option( 'xdotai_settings' );
    ?>
    <input id="xdotaiIframeHeight" type='number' name='xdotai_settings[iframeHeight]' value='<?php echo $options['iframeHeight']; ?>'> pixels (leave blank for the default of 600 pixels)
    <?php
}

function xdotai_iframeWidth_render(  ) {
    $options = get_option( 'xdotai_settings' );
    ?>
    <input id="xdotaiIframeWidth" type='number' name='xdotai_settings[iframeWidth]' value='<?php echo $options['iframeWidth']; ?>'> pixels (leave blank for the default of 100% of the container width)
    <?php
}

function xdotai_dataHeight_render(  ) {
    $options = get_option( 'xdotai_settings' );
    ?>
    <input id="xdotaiDataHeight" type='number' name='xdotai_settings[dataHeight]' value='<?php echo $options['dataHeight']; ?>'> pixels (leave blank for the default of 85% of the screen)
    <?php
}

function xdotai_dataWidth_render(  ) {
    $options = get_option( 'xdotai_settings' );
    ?>
    <input id="xdotaiDataWidth" type='number' name='xdotai_settings[dataWidth]' value='<?php echo $options['dataWidth']; ?>'> pixels (leave blank for the default of 800 pixels maximum)
    <?php
}

function xdotai_dataElement_render(  ) {
    $options = get_option( 'xdotai_settings' );
    ?>
    <input id="xdotaiDataElement" type='text' name='xdotai_settings[dataElement]' value='<?php echo $options['dataElement']; ?>'> Define an element using a CSS selector such as #elementID (leave blank for the default "Schedule a meeting" button to appear)
    <?php
}

function xdotai_select_field_1_render(  ) {
    $options = get_option( 'xdotai_settings' );
    ?>
    <select id="xdotaiEmbedType" name='xdotai_settings[xdotai_embed_type]'>
        <option value='iframe' <?php selected( $options['xdotai_embed_type'], 'iframe' ); ?>>Inline iFrame</option>
        <option value='lightbox' <?php selected( $options['xdotai_embed_type'], 'lightbox' ); ?>>Popup Lightbox</option>
    </select> Inline iFrame embeds your calendar page on your website within the content. Popup Lightbox appears when visitors click a button or link. 
    <a href="https://help.x.ai/en/articles/3607063-how-do-i-embed-my-calendar-page" target="_BLANK">Read more</a>.

<?php
}

function xdotai_settings_section_callback(  ) {
    echo __( 'Set up your calendar page URL here and then add the shortcode [xai-calendar] to embed the calendar page on your website.', 'wordpress' );
}

function xdotai_sanitize_input($options) {
    $cal_slug = $options["xdotai_calendar_url"];
    $parts = explode('/', $cal_slug);
    if ($parts[0] != '') {
        add_settings_error( 'xdotai_settings[xdotai_calendar_url]', 'start-slash', 'Your calendar page needs to begin with a "/".', 'error' );
        $err = true;
    }    
    $api = 'https://my.x.ai/api/calendarPages/find_calendar_page?queryname=' . $parts[1];
    $request = wp_remote_get($api);
    if( ! empty( $request["body"] ) ) {
       $page_valid = json_decode($request["body"]);
       if (!$page_valid->exists) {
            add_settings_error( 'xdotai_settings[xdotai_calendar_url]', 'page-invalid', 'This calendar page is not valid. <a href="https://x.ai" target="_BLANK">Sign up for x.ai</a> to get your calendar page.' );
            $err = true;
       }
    }
    if (!$err) return $options;
    else return get_option( 'xdotai_settings' );
}

function xdotai_options_page(  ) {
    ?>
    <form action='options.php' method='post'>

        <?php
        settings_fields( 'xdotaiPlugin' );
        do_settings_sections( 'xdotaiPlugin' );
        submit_button();
        ?>

    </form>
    <?php
}



function xdotai_load_scripts($hook) {
 
     wp_register_script( 
        'xdotai-js', 
        plugins_url( 'x-ai-calendar-embed/xdotai-calendar-embed-admin.js' , dirname(__FILE__) ),
        array( 'jquery' )
    );
 
	wp_enqueue_script( 'xdotai-js' );
}
add_action('admin_enqueue_scripts', 'xdotai_load_scripts');

function xdotai_calendar_embed_shortcode() {
    $options = get_option( 'xdotai_settings' );
    if ($options['xdotai_embed_type'] == 'iframe') {
        $width = $options['iframeWidth'] ? 'width:' . $options['iframeWidth'] . 'px;' : 'width:' . '100%;';
        $height = $options['iframeHeight'] ? 'height:' . $options['iframeHeight'] . 'px;' : 'height:' . '600' . 'px;';
        $retv = $options['xdotai_calendar_url'] ? '<iframe src="https://x.ai/calendar'. $options['xdotai_calendar_url'] .'?utm_medium=embed&utm_source=wp-embed&utm_content=iframe" style="' . $width . $height . '" scrolling="auto" > </iframe>' : '';
    } elseif ($options['xdotai_embed_type'] == 'lightbox') {
        $page       = $options['xdotai_calendar_url'] ? $options['xdotai_calendar_url'] : '';
        $width      = $options['dataWidth'] ? $options['dataWidth'] : '';
        $height     = $options['dataHeight'] ? $options['dataHeight'] : '';
        $element    = $options['dataElement'] ? $options['dataElement'] : '';
        $retv       = $options['xdotai_calendar_url'] ? '<script type="text/javascript" src="https://x.ai/embed/xdotai-embed.js" id="xdotaiEmbed" data-page="'.$page.'" data-height="'.$height.'" data-width="'.$width.'" data-element="'.$element.'" async></script>' : '';
    } else {
        $retv = '';
    }
    return $retv;
}

add_shortcode('xai-calendar', 'xdotai_calendar_embed_shortcode');

function xdotai_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=xdotai-settings-page">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'xdotai_add_settings_link' );



?>
