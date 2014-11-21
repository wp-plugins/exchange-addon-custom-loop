<?php
/**
 * Include and setup Exchange custom loop options
 *
 * @category iThemes Exchange custom loop
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'it_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function it_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_exchange_custom_loop_';

        /**
	 * Exchange custom loop metabox fields
	 */
	$meta_boxes[] = array(
		'id'         => 'enable_custom_loop',
		'title'      => __( 'iThemes Exchange Custom Loop', 'rvw-exchange-addon-custom-loop' ),
		'pages'      => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
                        array (
                            'name' => __( 'Enable the Custom Loop on this page', 'rvw-exchange-addon-custom-loop' ),
                            'desc' => __( 'Tick this box so that more options become available to setup your custom loop page', 'rvw-exchange-addon-custom-loop' ),
                            'id'   => $prefix . 'enable_custom_loop',
                            'type' => 'checkbox'
                        )
		),
	);
	/**
	 * Exchange custom loop metabox fields
	 */
	$meta_boxes[] = array(
		'id'         => 'exchange_custom_loop',
		'title'      => __( 'iThemes Exchange Custom Loop Options', 'rvw-exchange-addon-custom-loop' ),
		'pages'      => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
                        array(
                            'name' => 'View Setttings',
                            'desc' => 'This section allows you to specify the Grid / List settings.',
                            'type' => 'title',
                            'id' => $prefix . 'view_settings_title'
                        ),
                        array(
                            'name'    => __( 'Default view', 'rvw-exchange-addon-custom-loop' ),
                            'desc'    => __( 'the default store view', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'default_view',
                            'type'    => 'radio',
                            'options' => array(
                                    'list' => __( 'List style', 'rvw-exchange-addon-custom-loop' ),
                                    'grid'   => __( 'Grid style', 'rvw-exchange-addon-custom-loop' ),
                            ),
			),
                        array(
                            'name'    => __( 'Number of columns in Grid view', 'rvw-exchange-addon-custom-loop' ),
                            'desc'    => __( 'Defaults to 3 if left blank', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'number_of_columns',
                            'type'    => 'text_small'
			),
                        array(
                            'name'    => __( 'Padding between the products as a percentage', 'rvw-exchange-addon-custom-loop' ),
                            'desc'    => __( 'Defaults to 5 if left blank', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'padding',
                            'type'    => 'text_small'
			),
                        array(
                            'name'    => __( 'Viewport to default to List view', 'rvw-exchange-addon-custom-loop' ),
                            'desc'    => __( 'Although Grid view can work well on large screens, at smaller sizes, List view is recommended. Enter the minimum Viewport Width at which point the store Grid view will be changed to List view. If left blank, this will default to 600px. A value of 0 will disable this functionality.', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'viewport',
                            'type'    => 'text_small',
                            'default' => '600px'
			),                    
                        array(
                            'name' => 'Pagination Setttings',
                            'desc' => 'These settings control the number of posts per store page, and the text for the previous/next links.',
                            'type' => 'title',
                            'id' => $prefix . 'pagination_settings_title'
                        ),
                        array(
                            'name'    => __( 'Products per page', 'rvw-exchange-addon-custom-loop' ),
                            'desc'    => __( 'if left blank, will default to the value in the WordPress settings', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'posts_per_page',
                            'type'    => 'text_small',
			),                    
                        array(
                            'name' => __( 'Next page text', 'rvw-exchange-addon-custom-loop' ),
                            'desc' => __( 'Defaults to "next page &rarr;" if left blank', 'rvw-exchange-addon-custom-loop' ),
                            'id'   => $prefix . 'next_page_text',
                            'type' => 'text_medium'
			),
                        array(
                            'name' => __( 'Previous page text', 'rvw-exchange-addon-custom-loop' ),
                            'desc' => __( 'Defaults to "&larr; previous page" if left blank', 'rvw-exchange-addon-custom-loop' ),
                            'id'   => $prefix . 'previous_page_text',
                            'type' => 'text_medium',
			),
                        array(
                            'name' => 'Data Selections',
                            'desc' => '',
                            'type' => 'title',
                            'id' => $prefix . 'data_selections_title'
                        ),
                        array(
                            'name'     => __( 'Select the category/categories', 'rvw-exchange-addon-custom-loop' ),
                            'desc'     => __( 'if left blank, all categories will be included', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'categories',
                            'type'    => 'multicheck',
                            'options' => custom_get_category_options(),
                            'inline'  => true
                        ),
                        array(
                            'name'     => __( 'Select the product type(s)', 'rvw-exchange-addon-custom-loop' ),
                            'desc'     => __( 'if left blank, all product types will be included', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'product_types',
                            'type'    => 'multicheck',
                            'options' => custom_get_prodtype_options(),
                            'inline'  => true
                        ),
                        array(
                            'name' => 'Order Setttings',
                            'desc' => '',
                            'type' => 'title',
                            'id' => $prefix . 'order_settings_title'
                        ),
                        array(
                            'name'    => __( 'Order the products by', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'order_by',
                            'type'    => 'select',
                            'options' => array(
                                    'default' => __( 'Store default', 'rvw-exchange-addon-custom-loop' ),
                                    'price'   => __( 'Price', 'rvw-exchange-addon-custom-loop' ),
                                    'title'     => __( 'Title', 'rvw-exchange-addon-custom-loop' ),
                                    'date'     => __( 'Date', 'rvw-exchange-addon-custom-loop' ),
                            ),
			),
                        array(
                            'name'    => __( 'Order', 'rvw-exchange-addon-custom-loop' ),
                            'desc'    => __( 'Select how the products should be arranged (has no effect if Order by is "Store default")', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'order_seq',
                            'type'    => 'radio',
                            'options' => array(
                                    'asc' => __( 'Ascending (low to high)', 'rvw-exchange-addon-custom-loop' ),
                                    'desc'   => __( 'Descending (high to low)', 'rvw-exchange-addon-custom-loop' ),
                            ),
			),
                        array(
                            'name' => 'Front End options',
                            'desc' => '',
                            'type' => 'title',
                            'id' => $prefix . 'frontend_options_title'
                        ),
                        array(
                            'name'    => __( 'Show in heading', 'rvw-exchange-addon-custom-loop' ),
                            'id'      => $prefix . 'show',
                            'type'    => 'multicheck',
                            'options' => array(
                                    'checksortselection' => __( 'Display Sort selection', 'rvw-exchange-addon-custom-loop' ),
//                                    'checkcategoryfilter' => __( 'Display category filter (future use)', 'rvw-exchange-addon-custom-loop' ),
                                    'checkgridlist' => __( 'Display grid/list view selection', 'rvw-exchange-addon-custom-loop' )
                                    )
			),
		),
	);

	return $meta_boxes;
}

add_action( 'init', 'it_initialize_it_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function it_initialize_it_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}

/**
 * Gets a list of Exchange product types
 * @param  string       none
 * @param  string|array $args     Optional. Change the defaults retrieving terms.
 * @return array                  An array of options that matches the CMB options array
 */
function custom_get_prodtype_options() {

        $prodtype_options = array();

        $producttypes = it_exchange_get_enabled_addons( array( 'category' => 'product-type' ) );

        if ( count($producttypes) > 0 ){
            foreach ($producttypes as $key => $value) {
      
                $prodtype_options[] = array(
                       'name' => $value['name'],
                       'value' => $value['slug']
                );
            } 
        }

    return $prodtype_options;
}

function custom_get_category_options() {

        $exch_category_options = array();

        $exchange_categories = get_terms('it_exchange_category');

            if ( count($exchange_categories) > 0 ){
                foreach ( $exchange_categories as $term ) { 

                $exch_category_options[] = array(
                       'name' => $term->name,
                       'value' => $term->slug
                );
            } 
        }

    return $exch_category_options;
}