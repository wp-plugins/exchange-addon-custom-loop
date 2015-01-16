<?php
/**
 * iThemes Exchange custom loop offers more control over the loop that builts a store page.
 */
if (!class_exists('it_exchange_custom_loop')) {
    
    class it_exchange_custom_loop {

        var $version = '1.0.5';
        var $prefix = '_exchange_custom_loop_';
        var $orderby = array(
            'default' => 'default',
            'datedesc' => 'date (high to low)',
            'dateasc' => 'date (low to high)',
            'pricedesc' => 'price (high to low)',
            'priceasc' => 'price (low to high)',
            'namedesc' => 'name (high to low)',
            'nameasc' => 'name (low to high)'
        );
        var $selections = array(
            'enable_custom_loop' => FALSE,
            'default_view' => 'list',
            'number_of_columns' => 3,
            'padding' => 5,
            'viewport' => 600,
            'posts_per_page' => NULL,
            'next_page_text' => 'next page',
            'previous_page_text' => 'previous page',
            'categories' => NULL,
            'product_types' => NULL,
            'order_by' => NULL,
            'order_seq ' => 'DESC',
            'order_by_text' => NULL,
            'show' => NULL,
            'before_or_after' => 'after',
            'content_before' => NULL,
            'content_after' => NULL
        );
        var $views = array('grid', 'list');
        var $location = array('before', 'after', 'ignore');

        function it_exchange_custom_loop() {

            if ( is_admin() ) {
                $this->load_admin();
                $this->get_options();
                $this->load_metaboxes();
            } else {
                add_action('wp', array($this, 'load_frontend'));
            }

        }

        /**
         * Init and add menu page
         */
        function load_admin() {

            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles_scripts'));

        }

        /**
         * add styles and scripts for admin backend
         */
        function enqueue_admin_styles_scripts() {

            wp_register_script('it-custom-loop-admin', plugins_url('js/admin_scripts.js', __FILE__), array('jquery'), $this->version, false);
            wp_enqueue_script('it-custom-loop-admin');

            wp_register_style('it-custom-loop-admin-styles', plugins_url('css/admin_style.css', __FILE__), null, $this->version);
            wp_enqueue_style('it-custom-loop-admin-styles');

        }

        /**
         * Load the metaboxes
         */
        function load_metaboxes() {

            require_once( dirname(__FILE__) . '/lib/metabox/page-meta-box.php' );
            
            add_filter( 'cmb_localized_data', array($this, 'update_select_defaults') );

        }
        
        /**
         * Translate custom meta box library select text
         */
        function update_select_defaults( $l10n=array() ) {

		$l10n   = array(
                    'check_toggle'    => __( 'Select / Deselect All', 'rvw-exchange-addon-custom-loop' ),
		);
                
		return $l10n;
            
        }

        /**
         * Init and load products page
         */
        function load_frontend() {

            $this->get_options();

            if ($this->selections['enable_custom_loop'] == TRUE) :

                if (!empty($this->selections['show']) && ( in_array('checksortselection', $this->selections['show']) )) :
                    add_filter( 'query_vars',  array($this, 'add_query_vars_filter' ) );
                endif;

                $this->enqueue_styles_scripts();
                $this->add_code();

            endif;
        }

        /**
         * register our custom queryvar
         */                
        function add_query_vars_filter( $vars ){

            $vars[] = "orderby";
            return $vars;

        }

        /**
         * add styles and scripts
         */
        function enqueue_styles_scripts() {

            add_action('wp_enqueue_scripts', array($this, 'add_styles_scripts'));

        }

        /**
         * Get plugins options from post meta
         */
        function get_options() {

            global $post;

            // get the post options
            $this->selections['enable_custom_loop'] = get_post_meta(get_the_ID(), $this->prefix . 'enable_custom_loop', true);

            if ($this->selections['enable_custom_loop'] == TRUE) :

                // get the global store settings for default order/order by
                $this->store_settings = it_exchange_get_option( 'settings_general' );

                $this->selections['default_view'] = get_post_meta(get_the_ID(), $this->prefix . 'default_view', true);
                $this->selections['number_of_columns'] = get_post_meta(get_the_ID(), $this->prefix . 'number_of_columns', true);
                $this->selections['padding'] = get_post_meta(get_the_ID(), $this->prefix . 'padding', true);
                $this->selections['viewport'] = get_post_meta(get_the_ID(), $this->prefix . 'viewport', true);
                $this->selections['posts_per_page'] = get_post_meta(get_the_ID(), $this->prefix . 'posts_per_page', true);
                $this->selections['next_page_text'] = get_post_meta(get_the_ID(), $this->prefix . 'next_page_text', true);
                $this->selections['previous_page_text'] = get_post_meta(get_the_ID(), $this->prefix . 'previous_page_text', true);
                $this->selections['categories'] = get_post_meta(get_the_ID(), $this->prefix . 'categories', true);
                $this->selections['product_types'] = get_post_meta(get_the_ID(), $this->prefix . 'product_types', true);
                $this->selections['order_by'] = get_post_meta(get_the_ID(), $this->prefix . 'order_by', true);
                $this->selections['order_seq'] = get_post_meta(get_the_ID(), $this->prefix . 'order_seq', true);
                $this->selections['order_by_text'] = get_post_meta(get_the_ID(), $this->prefix . 'order_by_text', true);
                $this->selections['show'] = get_post_meta(get_the_ID(), $this->prefix . 'show', true);
                $this->selections['before_or_after'] = get_post_meta(get_the_ID(), $this->prefix . 'before_or_after', true);
                $this->selections['content_before'] = wpautop( get_post_meta( get_the_ID(), $this->prefix . 'content_before', true ) );
                $this->selections['content_after'] = wpautop( get_post_meta( get_the_ID(), $this->prefix . 'content_after', true ) );

                // validate and set defaults
                if ( !in_array(strtolower($this->selections['default_view']), $this->views) ) {
                    $this->selections['default_view'] = 'none';
                }

                if ( !is_numeric($this->selections['number_of_columns']) ) {
                    $this->selections['number_of_columns'] = 3;
                }

                if ( !is_numeric($this->selections['padding']) ) {
                    $this->selections['padding'] = 5;
                }

                if ( $this->selections['viewport'] ):
                    $this->selections['viewport'] = preg_replace("/[^0-9]/", '', $this->selections['viewport']);
                else:
                    $this->selections['viewport'] = 600;
                endif;

                // posts per page, use site default if none entered
                if ( !$this->selections['posts_per_page'] ):
                    $this->selections['posts_per_page'] = get_option('posts_per_page');
                endif;

                // next page text
                if ( !$this->selections['next_page_text'] ):
                    $this->selections['next_page_text'] = __( 'next page &rarr;', 'rvw-exchange-addon-custom-loop' );
//                    $this->selections['next_page_text'] = "next page &rarr;";
                endif;

                // previous page text
                if ( !$this->selections['previous_page_text'] ):
                    $this->selections['previous_page_text'] = __( '&larr; previous page', 'rvw-exchange-addon-custom-loop' );
                endif;

                // order by
                if ( !$this->selections['order_by'] ):
                    $this->selections['order_by'] = "default";
                endif;

                // order sequence
                if ( !$this->selections['order_seq'] ):
                    $this->selections['order_seq'] = "ASC";
                endif;

                // show before or after existing page content
                if ( !in_array(strtolower($this->selections['before_or_after']), $this->location) ) :
                    $this->selections['before_or_after'] = "after";
                endif;

            endif;
        }

        /**
         * process options and add code
         */
        function add_code() {

            add_filter('the_content', array($this, 'process'));

        }

        /**
         * Register and enqueue stylesheets and scripts
         */
        function add_styles_scripts() {

            wp_register_script('it-custom-loop-script', plugins_url('js/scripts.js', __FILE__), array('jquery'), $this->version, false);
            wp_enqueue_script('it-custom-loop-script');

            wp_register_style('it-custom-loop-styles', plugins_url('css/style.css', __FILE__), null, $this->version);
            wp_enqueue_style('it-custom-loop-styles');

            // only add code for grid list if ticked in page meta data
            if  (in_array(strtolower($this->selections['default_view']), $this->views) ) :

                wp_register_script('it_jquery_cookie', plugins_url('js/jquery.cookie.js', __FILE__), array('jquery'), $this->version, false);
                wp_enqueue_script('it_jquery_cookie');

                wp_register_script('it_jquery_gridlist', plugins_url('js/gridlistview.js', __FILE__), array('jquery'), $this->version, false);
                wp_enqueue_script('it_jquery_gridlist');

                wp_register_style('it-gridlist-styles', plugins_url('css/gridlist.css', __FILE__), null, $this->version);
                wp_enqueue_style('it-gridlist-styles');

                // add css for grid / list
                add_action('wp_head', array($this, 'add_css_for_gridlist'));

                // add js for for grid / list 
                add_action('wp_footer', array($this, 'add_js_for_gridlist'));

                // only add code for minimum viewport if value > 0
                if (!empty($this->selections['viewport']) && ( $this->selections['viewport'] > 0 ) ):

                    add_action('wp_footer', array($this, 'add_js_for_viewport'));

                endif;

                if (!empty($this->selections['show']) && (in_array( 'checkgridlist', $this->selections['show'] ) ) ):

                    wp_register_style('it-custom-loop-icons', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', null, '4.2.0');
                    wp_enqueue_style('it-custom-loop-icons');

                endif;

            endif;
        }

        /**
         * Process post meta data, build the query
         */
        function process() {

            // save the content as it needs to be re-applied before or after the loop
            if ($this->selections['before_or_after'] <> 'ignore') :
                $save_content = get_the_content();
            endif;

            ob_start();

            echo "\n<div class='it-exchange-custom-loop-header entry-header'>";

            // only add code for order by if ticked in page meta data
            if (!empty($this->selections['show']) && ( in_array('checksortselection', $this->selections['show']) )) :

                $this->add_sort_selections();

            endif;

            // only add code for grid list if ticked in page meta data
            if (!empty($this->selections['show']) && (in_array( 'checkgridlist', $this->selections['show'] ) ) && (in_array(strtolower($this->selections['default_view']), $this->views) ) ):

                $this->add_gridlist_selections();

            endif;

            echo "\n</div>";

            // Set up our custom loop
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

            // 1. built the basic query
            $exchange_custom_loop_args = array(
                'post_type' => 'it_exchange_prod',
                'posts_per_page' => $this->selections['posts_per_page'],
                'paged' => $paged,
            );

            // 2. add order by
            if (!is_null($this->selections['order_by'])) :

                if ($this->selections['order_by'] == 'price') :

                    $add_order_query = array(
                        'meta_key' => '_it-exchange-base-price',
                        'orderby' => 'meta_value_num',
                        'order' => strtoupper($this->selections['order_seq'])
                    );

                elseif ($this->selections['order_by'] == 'title') :

                    $add_order_query = array(
                        'orderby' => 'title',
                        'order' => strtoupper($this->selections['order_seq'])
                    );

                elseif ($this->selections['order_by'] == 'date') :

                    $add_order_query = array(
                        'orderby' => 'date',
                        'order' => strtoupper($this->selections['order_seq'])
                    );

                else :

                    $add_order_query = array(
                        'orderby' => $this->store_settings['store-product-order-by'],
                        'order' => $this->store_settings['store-product-order']
                    );


                endif;

                $exchange_custom_loop_args = array_merge((array) $exchange_custom_loop_args, (array) $add_order_query);

            endif;

            // 3. add meta_query for product types
            if (!empty($this->selections['product_types'])) :

                $add_meta_query = array(
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => '_it_exchange_product_type',
                            'value' => $this->selections['product_types'],
                            'compare' => 'IN'
                        ),
                        array(
                            'key' => '_it-exchange-visibility',
                            'value' => 'hidden',
                            'compare' => '!='
                        )
                    )
                );

                $exchange_custom_loop_args = array_merge((array) $exchange_custom_loop_args, (array) $add_meta_query);

            else: // always skip the hidden products

                $add_meta_query = array(
                    'meta_query' => array(
                        array(
                            'key' => '_it-exchange-visibility',
                            'value' => 'hidden',
                            'compare' => '!='
                        )
                    )
                );

                $exchange_custom_loop_args = array_merge((array) $exchange_custom_loop_args, (array) $add_meta_query);
            endif;

            // 4. add tax_query for category slugs
            if (!empty($this->selections['categories'])) :

                $add_tax_query = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'it_exchange_category',
                            'field' => 'slug',
                            'terms' => $this->selections['categories'],
                            'operator' => 'IN'
                        ),
                    )
                );

                $exchange_custom_loop_args = array_merge((array) $exchange_custom_loop_args, (array) $add_tax_query);

            endif;

            // tada ... the custom loop
            $exchange_custom_loop = new WP_Query($exchange_custom_loop_args);

            do_action( 'it_exchange_content_store_before_wrap' ); 
            echo "\n<div id='it-exchange-store' class='it-exchange-wrap it-exchange-custom-loop-content'>";

                do_action( 'it_exchange_content_store_begin_wrap' ); 
                it_exchange_get_template_part( 'messages' ); 

                    do_action( 'it_exchange_content_store_before_products_loop' );  
                    echo "\n\t<ul class='it-exchange-products'>";

                        do_action( 'it_exchange_content_store_begin_products_loop' ); 

                        if ($exchange_custom_loop->have_posts() ) : 
                            while ( $exchange_custom_loop->have_posts() ) : $exchange_custom_loop->the_post(); 

                                it_exchange_set_product( $post->ID );
                                it_exchange_get_template_part( 'content-store/elements/product' ); 

                            endwhile;

                        else : 

                            it_exchange_get_template_part( 'content-store/elements/no-products-found' ); 

                        endif;

                        do_action( 'it_exchange_content_store_end_product_loops' ); 

                        echo "\n\t</ul>";

                    do_action( 'it_exchange_content_store_after_products_loop' ); 

                do_action( 'it_exchange_content_store_end_wrap' );

            echo "\n</div>";
            do_action( 'it_exchange_content_store_after_wrap' ); 

            // Add pagination
            if ($exchange_custom_loop->max_num_pages > 1) :

                $big = 999999999;

                $pagination_args = array(
                    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'    => 'page/%#%',
                    'current'   => max( 1, get_query_var('paged') ),
                    'show_all'  => true,
                    'total'     => $exchange_custom_loop->max_num_pages,
                    'prev_next' => true,
                    'prev_text' => $this->selections['previous_page_text'],
                    'next_text' => $this->selections['next_page_text'],
                    'add_args'  => array( 'orderby' => $this->selected )
                );

                // display the pagination links
                echo "\n<div class='it-exchange-custom-loop-footer entry-footer'>";
                    echo "\n\n<nav class='it-exchange-custom-loop'>\n";
                        echo paginate_links($pagination_args); 
                    echo "</nav>\n";        
                echo "</div>\n";

            endif;

            wp_reset_postdata();

            // $output contains the entire loop
            $output = ob_get_clean();

            if ( $this->selections['content_before']):
                $output = $this->selections['content_before'] . $output;
            endif;

            if ( $this->selections['content_after']):
                $output = $output . $this->selections['content_after'];                        
            endif;

            if ($this->selections['before_or_after'] == 'before') : // store before content
                $output = $output . $save_content;
            elseif ($this->selections['before_or_after'] == 'after') : // store after content
                $output = $save_content . $output;
            endif;

            // finally, we return the entire content for the WordPress loop
            return $output;

        }

        /**
         * Process options and print dynamic css for grid/list
         */
        function add_css_for_gridlist() {

            // calculate margins and product width
            $total_padding = ($this->selections['number_of_columns'] - 1) * $this->selections['padding'];
            $prod_width = ((100 - $total_padding) / $this->selections['number_of_columns']) - 1;

            echo "\n<!-- Additional css for exchange custom loop -->";
            echo "\n<style type='text/css'>";
            echo "\n#it-exchange-store ul.it-exchange-products.grid li.it-exchange-product {";
            echo "\n\twidth: " . $prod_width . "%;";
            echo "\n\tmargin-right: " . $this->selections['padding'] . "%;";
            echo "\n}";
            echo "\n\n#it-exchange-store ul.it-exchange-products.grid li.it-exchange-product:nth-child(" . $this->selections['number_of_columns'] . "n) {";
            echo "\n\tmargin-right: 0;";
            echo "\n\tclear: right;";
            echo "\n}";
            echo "\n\n#it-exchange-store ul.it-exchange-products.grid li.it-exchange-product:nth-child(" . $this->selections['number_of_columns'] . "n + 1) {";
            echo "\n\tclear: left;";
            echo "\n}";
            echo "\n</style>";
            echo "\n<!-- End additional css for exchange custom loop -->\n";
        }

        /**
         * Default for grid list view
         */                
        function add_js_for_gridlist() {

            $default_view = $this->selections['default_view'];

            echo "\n<script type='text/javascript'>";
                echo "\nvar default_view = '" . $this->selections['default_view'] . "';";
                echo "\n\tif (jQuery.cookie('gridcookie') == null) {";
                    echo "\n\t\tjQuery('ul.it-exchange-products').addClass('" . $default_view . "');";
                    echo "\n\t\tjQuery('.it-exchange-custom-loop-view-selection #" . $default_view . "').addClass('active');";
                echo "\n\t}";
            echo "\n</script>\n"; 

        }

        /**
         * Default min viewport for grid view
         */                
        function add_js_for_viewport() {

            echo "\n<script type='text/javascript'>";
                echo "\njQuery(document).ready(function($) {";
                    echo "\n\tdoResize();";
                    echo "\n\t$(window).resize(function() {";
                        echo "\n\t\tdoResize();";
                    echo "\n\t});";
                echo "\n});";
                echo "\nfunction doResize() {";
                    echo "\n\tif(window.innerWidth < " . $this->selections['viewport'] . ") {";
                        echo "\n\t\tif(jQuery.cookie('gridcookie') == 'grid') {";
                            echo "\n\t\t\tjQuery('#list').click();";
                        echo "\n\t\t}";
                    echo "\n\t}";
                echo "\n}";
            echo "\n</script>\n";

        }

        /**
         * Add the order by dropdown
         */
        function add_sort_selections() {

            // get the sort order from query var
            if (isset($_GET['orderby'])) {
                $this->selected = get_query_var( 'orderby' );
            } else {
                $this->selected = $this->selections['order_by'];
            }

            // display the sort order dropdown
            $name = "OrderBy";
            $options = $this->orderby;
            echo "\n<div class='it-exchange-custom-loop-sort-selection'>";
                echo "\n\t<form name='selectorderby' method='get'>";
                if ($this->selections['order_by_text']):
                    echo "\n<span class='it-exchange-custom-loop-order-by-text'>" . $this->selections['order_by_text'] . "</span>";
                endif;
                echo $this->dropdown($name, $options, $this->selected);
                echo "\n\t</form>";
            echo "\n</div>\n";

            if ($this->selected) :

                if ($this->selected == 'default') {
                    $this->selections['order_by'] = 'store_default';
                    $this->selections['order_seq'] = 'ASC';
                } elseif ($this->selected == 'priceasc') {
                    $this->selections['order_by'] = 'price';
                    $this->selections['order_seq'] = 'ASC';
                } elseif ($this->selected == 'pricedesc') {
                    $this->selections['order_by'] = 'price';
                    $this->selections['order_seq'] = 'DESC';
                } elseif ($this->selected == 'dateasc') {
                    $this->selections['order_by'] = 'date';
                    $this->selections['order_seq'] = 'ASC';
                } elseif ($this->selected == 'datedesc') {
                    $this->selections['order_by'] = 'date';
                    $this->selections['order_seq'] = 'DESC';
                } elseif ($this->selected == 'nameasc') {
                    $this->selections['order_by'] = 'title';
                    $this->selections['order_seq'] = 'ASC';
                } elseif ($this->selected == 'namedesc') {
                    $this->selections['order_by'] = 'title';
                    $this->selections['order_seq'] = 'DESC';
                }

            endif;

        }

        /**
         * Add the grid/list select buttons
         */
        function add_gridlist_selections() {

            echo "\n<div class='it-exchange-custom-loop-view-selection'>";
                echo "\n\t<a id='grid'><i class='fa fa-th fa-2x'></i></a>";
                echo "\n\t<a id='list'><i class='fa fa-list fa-2x'></i></a>";
            echo "\n</div>";

        }

        /**
         * TODO Delete post meta data if not enabled on this page
         */
        function process_custom_loop_post_meta($post_id) {

            if ($this->selections['enable_custom_loop'] == FALSE) {
                delete_post_meta($post_id, $this->prefix . 'default_view');
                delete_post_meta($post_id, $this->prefix . 'number_of_columns');
                delete_post_meta($post_id, $this->prefix . 'padding');
                delete_post_meta($post_id, $this->prefix . 'viewport');
                delete_post_meta($post_id, $this->prefix . 'posts_per_page');
                delete_post_meta($post_id, $this->prefix . 'next_page_text');
                delete_post_meta($post_id, $this->prefix . 'previous_page_text');
                delete_post_meta($post_id, $this->prefix . 'categories');
                delete_post_meta($post_id, $this->prefix . 'product_types');
                delete_post_meta($post_id, $this->prefix . 'order_by');
                delete_post_meta($post_id, $this->prefix . 'order_seq');
                delete_post_meta($post_id, $this->prefix . 'order_by_text');
                delete_post_meta($post_id, $this->prefix . 'show');
                delete_post_meta($post_id, $this->prefix . 'before_or_after');
                delete_post_meta($post_id, $this->prefix . 'content_before');
                delete_post_meta($post_id, $this->prefix . 'content_after');
            }
        }

        /**
         * orderby dropdown
         */
        function dropdown($name, array $options, $selected) {

            $active_selection = "";
            $inactive_selection = "";

            $dropdown = "\n<select name='" . $name . "' id='" . $name . "' onchange='doReload(this.value)'>";

            foreach ($options as $key => $option) {

                if ($selected == $key) {
                    $active_selection = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . $key . "'>" . $option . "</option>";
                } else {
                    $inactive_selection .= "\n\t<option style=\"padding-right: 10px;\" value='" . $key . "'>" . $option . "</option>";
                }
            }

            $dropdown .= $active_selection;
            $dropdown .= $inactive_selection;

            $dropdown .= "\n</select>\n";

            return $dropdown;
        }
    }
}

// Instantiate the class
if (class_exists('it_exchange_custom_loop')) {
        $it_exchange_custom_loop_var = new it_exchange_custom_loop();
}