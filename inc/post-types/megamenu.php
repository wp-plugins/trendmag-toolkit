<?php

if(!class_exists('TT_Megamenu')){

    class TT_Megamenu{

        public function __construct(){
            add_action('init', array($this, 'register_post_type'), 0);
            add_action('admin_init', array($this, 'register_metabox'));
            add_filter('manage_megamenu_posts_columns', array($this, 'manage_colums'));
            add_action('manage_megamenu_posts_custom_column' , array($this, 'manage_colum'));
        }

        public function register_post_type(){

            $labels = array(
                'name' => _x('Mega Menus', 'trendmag-toolkit'),
                'singular_name' => _x('Mega Menu', 'trendmag-toolkit'),
                'menu_name' => _x('Mega Menus', 'trendmag-toolkit'),
                'name_admin_bar' => _x('Mega Menus', 'trendmag-toolkit'),
                'add_new' => _x('Add New', 'trendmag-toolkit'),
                'add_new_item' => __('Add New Mega Menu', 'trendmag-toolkit'),
                'new_item' => __('New Mega Menu', 'trendmag-toolkit'),
                'edit_item' => __('Edit Mega Menu', 'trendmag-toolkit'),
                'view_item' => __('View Mega Menu', 'trendmag-toolkit'),
                'all_items' => __('All Mega Menus', 'trendmag-toolkit'),
                'search_items' => __('Search Mega Menus', 'trendmag-toolkit'),
                'not_found' => __('No mega menus found.', 'trendmag-toolkit'),
                'not_found_in_trash' => __('No mega menus found in Trash.', 'trendmag-toolkit')
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_icon' => 'dashicons-index-card',
                'query_var' => true,
                'rewrite' => array('slug' => 'megamenu'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'menu_position' => 80,
                'supports' => array('title')
            );

            register_post_type('megamenu', $args);
        }

        public function register_metabox(){

            global $wp_registered_sidebars;

            $register_sidebar = array();
            $register_sidebar[''] = '--None--';
            foreach ( $wp_registered_sidebars as $k => $v ) {
                $register_sidebar[$k] = $v['name'];
            }
            $args = array(
                'id'          => 'trendmag-toolkit-megamenu-options-metabox',
                'title'       => __('Settings', 'trendmag-toolkit'),
                'desc'        => '',
                'pages'       => array( 'megamenu' ),
                'context'     => 'normal',
                'priority'    => 'low',
                'fields'      => array(
                    array(
                        'title'   => __('Sidebar', 'trendmag-toolkit'),
                        'type'    => 'select',
                        'id'      => 'trendmag-toolkit-sidebar',
                        'options' => $register_sidebar
                    )
                )
            );

            kopa_register_metabox( $args );
        }

        public function manage_colums($columns){
            $columns = array(
                'cb' => array('<input type="checkbox">', 'cb', NULL),
                'title' => __('Title', 'trendmag-toolkit'),
                'tt-shortcode' => __('Shortcode', 'trendmag-toolkit')
            );

            return $columns;
        }

        public function manage_colum($column){
            global $post;
            switch ($column) {
                case 'tt-shortcode':
                    echo '[trendmag_megamenu id=' . $post->ID . ']';
                    break;
            }
        }
    }

    $tt_megamenu = new TT_Megamenu();

}

if(!class_exists('TT_Walker_Main_Menu')){

    class TT_Walker_Main_Menu extends Walker_Nav_Menu {

        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            parent::start_el($output, $item, $depth, $args, $id);
            if (!empty($item->description)) {
                if (strpos($item->description,'[trendmag_megamenu') !== false) {
                    ob_start();
                    echo do_shortcode($item->description);
                    $output .= ob_get_contents();
                    ob_end_clean();
                }
            }
        }

    }

}