<?php
/*
 * Plugin Name: iThemes Exchange - Custom Loop Add-on
 * Version: 1.0.6
 * Description: iThemes Exchange custom loop offers more control over the loop that builts a store page.
 * Plugin URI: http://weerdpress.com/wordpress-plugins/ithemes-exchange-custom-loop-add
 * Author: Ronald van Weerd
 * Author URI: http://vanweerd.com
 * iThemes Package: exchange-addon-custom-loop
 
 * Installation:
 * 1. Download and unzip the latest release zip file.
 * 2. If you use the WordPress plugin uploader to install this plugin skip to step 4.
 * 3. Upload the entire plugin directory to your `/wp-content/plugins/` directory.
 * 4. Activate the plugin through the 'Plugins' menu in WordPress Administration.
 *
*/

/**
 * This registers our plugin as an addon
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_register_custom_loop_addon() {
	$options = array(
		'name'              => __( 'Custom Loop', 'rvw-exchange-addon-custom-loop' ),
		'description'       => __( 'iThemes Exchange custom loop offers more control over the loop that builts a store page.', 'rvw-exchange-addon-custom-loop' ),
		'author'            => 'Ronald van Weerd',
		'author_url'        => 'http://vanweerd.com/',
		'icon'              => ITUtility::get_url_from_file( dirname( __FILE__ ) . '/lib/assets/custom-loop50px.png' ),
		'file'              => dirname( __FILE__ ) . '/init.php',
		'category'          => 'product-feature',
		'basename'          => plugin_basename( __FILE__ ),
		'settings-callback' => 'it_exchange_custom_loop_settings_callback',
	);
	it_exchange_register_addon( 'custom-loop', $options );
}
add_action( 'it_exchange_register_addons', 'it_exchange_register_custom_loop_addon' );