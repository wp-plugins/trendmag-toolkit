<?php

add_action( 'widgets_init', array('TT_Widget_Advertisement', 'register_widget'));
add_filter('dynamic_sidebar_params', array('TT_Widget_Advertisement', 'dynamic_sidebar_params_for_widget_grid_post'));


class TT_Widget_Advertisement extends Kopa_Widget {

	public $kpb_group = 'intro';

	public static function register_widget(){
		register_widget('TT_Widget_Advertisement');
	}

    public static function dynamic_sidebar_params_for_widget_grid_post($params) {
        global $wp_registered_widgets;
        $widget_id = $params[0]['widget_id'];
        $widget_obj = $wp_registered_widgets[$widget_id];
        $widget_opt = get_option($widget_obj['callback'][0]->option_name);
        $widget_num = $widget_obj['params'][0]['number'];
        if ('(Trendmag) Advertisement' == $widget_obj['name']) {
            if (isset($widget_opt[$widget_num]['layout']) && !empty($widget_opt[$widget_num]['layout'])) {
                switch ($widget_opt[$widget_num]['layout']) {
                    case 'layout_980_90':
                        $classes = 'kopa-ads-widget ads-1';
                        break;
                    case 'layout_300_390':
                        $classes = 'kopa-ads-widget ads-3';
                        break;
                    case 'layout_252_125':
                        $classes = 'kopa-ads-widget ads-4';
                        break;
                    case 'layout_custom':
                        $classes = 'kopa-ads-widget';
                        break;
                }
                $params[0]['before_widget'] = sprintf('<div id="%1$s" class="widget %2$s">', $widget_id, $classes);
            }
        }
        return $params;
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-ads-widget ads-1';
		$this->widget_description = __( 'Display a banner with custom link.', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_toolkit-advertisement';
		$this->widget_name        = __( '(Trendmag) Advertisement', 'trendmag-toolkit' );
		
		$this->settings           = array(			
			'banner'    => array(
				'type'  => 'upload',
				'std'   => '',
				'label' =>  __( 'Banner:', 'trendmag-toolkit')
			),
            'layout'    => array(
                'type'  => 'select',
                'std'   => '',
                'label' => __( 'Layout for:', 'trendmag-toolkit'),
                'options' => array(
                    'layout_980_90' => __('Layout for size 980 x 90 px ( in blog content )', 'trendmag-toolkit'),
                    'layout_300_390' => __('Layout for size 300 x 390 px ( in blog sidebar )', 'trendmag-toolkit'),
                    'layout_252_125' => __('Layout for size 252 x 125 px ( in footer )', 'trendmag-toolkit'),
                    'layout_custom' => __('Layout for custom size', 'trendmag-toolkit'),
                )
            ),
			'link_to'  => array(
				'type'  => 'text',
				'std'   => '#',
				'label' => __( 'Link to:', 'trendmag-toolkit')
			));


		parent::__construct();
	}

	public function widget( $args, $instance ) {	

		ob_start();

		extract( $args );

		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		echo $before_widget;

		?>
       	<div class="widget-content">
            <a href="<?php echo esc_url($link_to); ?>" title="">
                <img src="<?php echo esc_url($banner); ?>"  alt="">
            </a>
        </div>
		<?php

		$content = ob_get_clean();

		echo $content;

		echo $after_widget;
	}

}