<?php

add_action( 'widgets_init', array('TT_Widget_Instagram_Photos', 'register_widget'));

class TT_Widget_Instagram_Photos extends Kopa_Widget {

	public $kpb_group = 'contact';
	public $lines = array();

	public static function register_widget(){
		register_widget('TT_Widget_Instagram_Photos');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-instagram-widget';
		$this->widget_description = __( 'Display your photos from Instagram', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_toolkit_instagram';
		$this->widget_name        = __( '(Trendmag) Instagram', 'trendmag-toolkit' );
		
		$this->settings['title'] =array(
			'type'  => 'text',				
			'std'   => __('Follow us @ instagram', 'trendmag-toolkit'),
			'label' => __( 'Title:', 'trendmag-toolkit' )
		);
        $this->settings['client_id'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Client ID:', 'trendmag-toolkit' ),
            'desc'  => __('(You can obtain a client id registering a new Instagram API client app at <a href="http://instagram.com/developer/clients/register/" target="_blank">here</a>)', 'trendmag-toolkit')
        );
        $this->settings['limit'] =array(
            'type'  => 'number',
            'std'   => 6,
            'label' => __( 'Number of photos:', 'trendmag-toolkit' )
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {	

		ob_start();

		extract( $args );

		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		echo $before_widget;

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        if ( empty($limit) ) {
            $limit = 6;
        }
		
		if( ! empty($title) ) : ?>

            <h2 class="widget-title style-6">
                <span><?php echo esc_html($title); ?></span>
            </h2>

        <?php
			endif;

            if ( ! empty($client_id) ) :
		?>

            <div id="instafeed" data-instagram-client="<?php echo esc_attr($client_id); ?>" data-limit="<?php echo esc_attr($limit); ?>"></div>

		<?php
            endif;
		$content = ob_get_clean();

		echo $content;

		echo $after_widget;
	}

}