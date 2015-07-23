<?php

add_action( 'widgets_init', array('TT_Widget_Google_Map', 'register_widget'));

class TT_Widget_Google_Map extends Kopa_Widget {

    public $kpb_group = 'contact';

    public static function register_widget(){
        register_widget('TT_Widget_Google_Map');
    }

	public function __construct() {
		$this->widget_cssclass    = 'trendmag-google-map';
		$this->widget_description = __( 'Display your google map.', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag-google-map';
		$this->widget_name        = __( '(Trendmag) Google Map', 'trendmag-toolkit' );
		$this->settings 		  = array(
			'title'  => array(         
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Place', 'trendmag-toolkit' )
			),            
            'latitude'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => __('Latitude', 'trendmag-toolkit')
            ),
			'longitude'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => __('Longitude', 'trendmag-toolkit')
            ),		            
            'height'  => array(
                'type'  => 'text',
                'std'   => '400px',
                'label' => __('Height', 'trendmag-toolkit')
            ),
		);	

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();

		extract( $args );
		
        $instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
        extract( $instance );

		echo $before_widget;
        
        if (!empty($latitude) && !empty($longitude)):
            $style = ($height) ? "height: {$height};" : '';
            $map_id = 'kopa-map-' . wp_generate_password(4, false, false);
            ?>
                <div class="kopa-map-wrapper">
                    <div id="<?php echo esc_attr($map_id);?>"
                        class="kopa-map"
                        style="<?php echo esc_attr($style); ?>"
                        data-latitude="<?php echo esc_attr($latitude); ?>"
                        data-longitude="<?php echo esc_attr($longitude); ?>"
                        data-place="<?php echo esc_attr($title); ?>"></div>
                </div>
            <?php
        endif;
      
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}