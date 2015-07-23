<?php

add_action( 'widgets_init', array('TT_Widget_Flickr_Photos', 'register_widget'));

class TT_Widget_Flickr_Photos extends Kopa_Widget {

	public $kpb_group = 'contact';
	public $lines = array();

	public static function register_widget(){
		register_widget('TT_Widget_Flickr_Photos');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-photo-flick-widget';
		$this->widget_description = __( 'Display your photos from Flickr.com', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_toolkit_flickr';
		$this->widget_name        = __( '(Trendmag) Flickr', 'trendmag-toolkit' );
		
		$this->settings['title'] =array(
			'type'  => 'text',				
			'std'   => __('FLICKR', 'trendmag-toolkit'),
			'label' => __( 'Title:', 'trendmag-toolkit' )
		);
        $this->settings['flickr_id'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Flickr ID:', 'trendmag-toolkit' ),
            'desc'  => __('(click <a href="http://idgettr.com/" target="_blank">here</a> to find your ID)', 'trendmag-toolkit')
        );
        $this->settings['flickr_limit'] =array(
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

        if ( empty($flickr_limit) ) {
            $flickr_limit = 6;
        }
		
		if( ! empty($title) ) : ?>

            <h4 class="widget-title style-2">
                <span><?php echo esc_html($title); ?></span>
            </h4>

        <?php
			endif;

            if ( ! empty($flickr_id) ) :
		?>

                <div class="widget-content" data-id="<?php echo esc_attr($flickr_id); ?>" data-limit="<?php echo esc_attr($flickr_limit); ?>">
                    <div class="kopa-row-1">
                        <ul class="rs-ul">
                        </ul>
                    </div>
                </div>

		<?php
            endif;
		$content = ob_get_clean();

		echo $content;

		echo $after_widget;
	}

}