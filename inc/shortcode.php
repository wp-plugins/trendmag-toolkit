<?php

class Trendmag_Shortcode{
	
	function __construct(){
		add_action('admin_init', array($this, 'admin_init'));
	}

	public function admin_init(){
		if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
			add_filter('mce_external_plugins', array($this, 'mce_external_plugins'));
			add_filter('mce_buttons', array($this, 'mce_buttons'));
		}
	}

	public function mce_external_plugins($plugin_array) {
		$affix = TT_IS_DEV ? '' : '.min';
	    $plugin_array['trendmag_shortcodes'] = TT_DIR . "assets/js/tinymce{$affix}.js";
	    return $plugin_array;
	}

	public function mce_buttons($buttons) {
	    $buttons[] = 'trendmag_shortcodes';
	    return $buttons;
	}

	public function load_shortcodes(){
		require TT_PATH . 'inc/shortcodes/caption.php';
		require TT_PATH . 'inc/shortcodes/grid.php';
		require TT_PATH . 'inc/shortcodes/tabs.php';
		require TT_PATH . 'inc/shortcodes/accordions.php';
		require TT_PATH . 'inc/shortcodes/toggle.php';
		require TT_PATH . 'inc/shortcodes/dropcaps.php';
		require TT_PATH . 'inc/shortcodes/alert.php';
		require TT_PATH . 'inc/shortcodes/button.php';
		require TT_PATH . 'inc/shortcodes/megamenu.php';
	}
}

$trendmag_toolkit_shortcodes = new Trendmag_Shortcode();
$trendmag_toolkit_shortcodes->load_shortcodes();