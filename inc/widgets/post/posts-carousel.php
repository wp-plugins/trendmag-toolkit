<?php

add_action( 'widgets_init', array('TT_Widget_Post_Carousel', 'register_widget'));

class TT_Widget_Post_Carousel extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget(){
		register_widget('TT_Widget_Post_Carousel');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-owl-widget owl-widget-10 loader';
		$this->widget_description = __( 'Display list posts with carousel effect', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_post_carousel';
		$this->widget_name        = __( '(Trendmag) Post Carousel', 'trendmag-toolkit' );

        $this->settings 		  = trendmag_toolkit_get_post_widget_args();

        $this->settings['slide_item'] = array(
            'type'  => 'number',
            'std'   => 10,
            'label' => __( 'Slider item ( Default is 10 )', 'trendmag-toolkit' ),
            'min'     => '1'
        );

        $this->settings['auto'] = array(
            'type'  => 'checkbox',
            'std'   => 1,
            'label' => __( 'Auto slide', 'trendmag-toolkit' )
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();

		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

        $slide_item = intval($slide_item);

		echo $before_widget;

        echo '<div class="widget-content">';

            echo '<div class="owl-carousel owl-theme owl-content" data-slider-item="' . esc_attr($slide_item) . '" data-slider-auto="' . esc_attr($auto) . '" data-slider-navigation="2" data-slider-pagination="2">';

            $query = trendmag_toolkit_get_post_widget_query($instance);
            $results = new WP_Query( $query );

            if ( $results->have_posts() ) {
                while ( $results->have_posts() ) {
                    $results->the_post();
                    $image_slug = 'widget-post-carousel';
                    ?>

                        <div class="entry-item" data-title="<?php the_title(); ?>">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('itemprop' => 'thumbnailUrl')); ?></a>
                        </div>

                    <?php
                }
            }

            wp_reset_postdata();
            ?>
                </div>
                <div class="customNavigation">
                    <a class="btn prev"><i class="fa fa-angle-left"></i></a>
                    <a class="btn next"><i class="fa fa-angle-right"></i></a>
                </div>
            </div>

            <?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}
