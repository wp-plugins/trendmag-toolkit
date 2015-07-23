<?php
/*
Plugin Name: Trendmag Toolkit
Description: A specific plugin to be used in Trendmag WordPress Theme. It includes custom widgets, and layout for the theme.
Version: 1.0.1
Author: Kopa Theme
Author URI: http://kopatheme.com
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Trendmag Toolkit plugin, Copyright 2014 Kopatheme.com
Trendmag Toolkit is distributed under the terms of the GNU GPL

Requires at least: 4.1
Tested up to: 4.2.2
Text Domain: trendmag-toolkit
Domain Path: /languages/
*/

define('TT_IS_DEV', true);
define('TT_DIR', plugin_dir_url(__FILE__));
define('TT_PATH', plugin_dir_path(__FILE__));

add_action('plugins_loaded', array('Trendmag_Toolkit', 'plugins_loaded'));
add_action('after_setup_theme', array('Trendmag_Toolkit', 'after_setup_theme'), 20 );

class Trendmag_Toolkit {

	function __construct(){

		require TT_PATH . 'inc/hook.php';
		require TT_PATH . 'inc/util.php';
		require TT_PATH . 'inc/ajax.php';
		require TT_PATH . 'inc/field.php';
		require TT_PATH . 'inc/shortcode.php';
		require TT_PATH . 'inc/widget.php';
		require TT_PATH . 'inc/woocommerce.php';
		require TT_PATH . 'inc/post-types/megamenu.php';

		if(is_admin()){
			#make video shortcode responsive
			add_filter('wp_video_shortcode', 'trendmag_toolkit_make_video_shortcode_responsive');

			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 20);
			add_action('admin_init', 'trendmag_toolkit_register_metabox_post_featured');

			#metabox-custom-field
			add_filter('kopa_admin_meta_box_field_quote', 'trendmag_toolkit_metabox_field_quote', 10, 5);
			add_filter('kopa_admin_meta_box_field_icon', 'trendmag_toolkit_metabox_field_icon', 10, 5);
			add_filter('kopa_admin_meta_box_field_gallery', 'trendmag_toolkit_metabox_field_gallery', 10, 5);

			#widget-custom-field
			add_filter('kopa_widget_form_field_link_icon', 'trendmag_toolkit_widget_field_link_icon', 10, 5);
			add_filter('kopa_widget_form_field_icon', 'trendmag_toolkit_widget_field_icon', 10, 5);

			#metabox-custom-wrap
			add_filter('kopa_admin_meta_box_wrap_start', 'trendmag_toolkit_meta_box_wrap_start', 10, 3);
			add_filter('kopa_admin_meta_box_wrap_end', 'trendmag_toolkit_meta_box_wrap_end', 10, 3);

            #add job to user's profile
            add_filter('user_contactmethods', 'trendmag_modify_user_profile');
		}else{
			add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'), 9);
            add_action('trendmag_seach_share_post_via_social', 'trendmag_toolkit_search_share_via_social');
			
			add_filter('embed_handler_html', 'trendmag_toolkit_youtube_settings');
			add_filter('embed_oembed_html', 'trendmag_toolkit_youtube_settings');

			add_filter( 'excerpt_more', 'trendmag_toolkit_excerpt_more' );
		}

		#ajax
		add_action('wp_ajax_trendmag_toolkit_get_lighbox_icons', 'trendmag_toolkit_get_lighbox_icons');

	}

	public static function plugins_loaded(){
		load_plugin_textdomain('trendmag-toolkit', false, TT_PATH . '/languages/');
	}

	public static function after_setup_theme(){
		if (!defined('TRENDMAG_VERSION') || !class_exists('Kopa_Framework'))
			return; 		
		else	
			new Trendmag_Toolkit();
	}

	public function wp_enqueue_scripts(){
		wp_enqueue_style('font-awesome', TT_DIR . "assets/css/font-awesome.css", array(), NULL);
	    wp_enqueue_style('flaticon', TT_DIR . "assets/css/flaticon.css", array(), NULL);
	}

	public function admin_enqueue_scripts($hook){
		if(in_array($hook, array('edit.php'))){			
			wp_enqueue_style('trendmag_toolkit-datagrid', TT_DIR . "assets/css/datagrid.css", array(), NULL);
		}

		if(in_array($hook, array('widgets.php', 'post.php', 'post-new.php'))){	        

	        wp_enqueue_style('font-awesome', TT_DIR . "assets/css/font-awesome.css", array(), NULL);
	        wp_enqueue_style('flaticon', TT_DIR . "assets/css/flaticon.css", array(), NULL);
	        wp_enqueue_style('trendmag_toolkit-widget', TT_DIR . "assets/css/widget.css", array(), NULL);
	        wp_enqueue_style('trendmag_toolkit-metabox', TT_DIR . "assets/css/metabox.css", array(), NULL);
	        wp_enqueue_style('trendmag_toolkit-jquery-ui', TT_DIR . "assets/css/jquery-ui/jquery-ui.css", array(), NULL);
	        wp_enqueue_style('trendmag_toolkit-jquery-ui-structure', TT_DIR . "assets/css/jquery-ui/jquery-ui.structure.css", array(), NULL);
	        wp_enqueue_style('trendmag_toolkit-jquery-ui-theme', TT_DIR . "assets/css/jquery-ui/jquery-ui.theme.css", array(), NULL);
	                     
	        wp_enqueue_script('jquery-ui-core');
	        wp_enqueue_script('jquery-ui-dialog');
	        wp_enqueue_script('jquery-ui-position');
	        wp_enqueue_script('jquery-ui-droppable');
	        wp_enqueue_script('jquery-ui-draggable');

	        wp_enqueue_script('trendmag_toolkit-icon-picker', TT_DIR . "assets/js/icon_picker.js", array('jquery'), NULL, TRUE);
	        wp_enqueue_script('trendmag_toolkit-gallery', TT_DIR . "assets/js/gallery.js", array('jquery'), NULL, TRUE);

	        wp_localize_script('trendmag_toolkit-icon-picker', 'trendmag_toolkit', array(
	            'ajax' => array(
	                'url' => array(
	                    'get_lighbox_icons' => wp_nonce_url(admin_url('admin-ajax.php'), '$P$By.WhgC.styMXTVXajsHThQZgrlsVm1', 'security')
	                )                
	            ),
	            'i18n' => array(
					'icon_picker'    => __('Icon Picker', 'trendmag-toolkit'),
					'shortcodes'     => __('Shortcodes', 'trendmag-toolkit'),
					'caption'        => __('Caption', 'trendmag-toolkit'),
					'grid'           => __('Grid', 'trendmag-toolkit'),
					'container'      => __('Container', 'trendmag-toolkit'),
					'tabs'           => __('Tabs', 'trendmag-toolkit'),
					'accordion'      => __('Accordion', 'trendmag-toolkit'),
					'toggle'         => __('Toggle', 'trendmag-toolkit'),
					'dropcap'        => __('Dropcap', 'trendmag-toolkit'),
					'circle'         => __('Circle', 'trendmag-toolkit'),
					'rectangle'      => __('Rectangle', 'trendmag-toolkit'),
					'transparent'    => __('Transparent', 'trendmag-toolkit'),
					'alert'          => __('Alert box', 'trendmag-toolkit'),
					'notice'           => __('Notice', 'trendmag-toolkit'),
					'info'           => __('Info', 'trendmag-toolkit'),
					'success'        => __('Success', 'trendmag-toolkit'),
					'warning'        => __('Warning', 'trendmag-toolkit'),
					'danger'         => __('Danger', 'trendmag-toolkit'),
					'button'         => __('Button', 'trendmag-toolkit'),
					'white'           => __('White', 'trendmag-toolkit'),
					'black'          => __('Black', 'trendmag-toolkit'),
					'small'          => __('Small', 'trendmag-toolkit'),     
					'medium'         => __('Medium', 'trendmag-toolkit'),     
					'large'          => __('Large', 'trendmag-toolkit'),
					'default'        => __('Default', 'trendmag-toolkit'),
					'special'        => __('Special', 'trendmag-toolkit')
	            )
	        ));
	    }
	}
}