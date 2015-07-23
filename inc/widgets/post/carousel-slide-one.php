<?php
add_action( 'widgets_init', array('TTP_Widget_Carousel_One', 'register_widget'));

class TTP_Widget_Carousel_One extends Kopa_Widget {

	public $kpb_group = 'slider';

    public static function register_widget(){
        register_widget('TTP_Widget_Carousel_One');
    }
	
	public function __construct() {
		$this->widget_cssclass    = 'kopa-flex-widget flex-widget-2';
		$this->widget_description = __('Display slides with carousel effect, one item per page.', 'trendmag-toolkit-plus');
		$this->widget_id          = 'trendmag_carousel_slide_one';
		$this->widget_name        = __( '(Trendmag) Slide One', 'trendmag-toolkit-plus' );
		$this->settings 		  = trendmag_toolkit_get_post_widget_args();
		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		ob_start();

		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
		extract( $instance );

		$query = trendmag_toolkit_get_post_widget_query($instance);
		
		$result_set = new WP_Query( $query );

        echo $before_widget;
        if ( $result_set->have_posts() ) :
            $image_slug = 'widget-carousel-slides-one';
		?>

        <div class="widget-content">
            <div class="flexslider" data-slider-direction="horizontal" data-slider-speed="7000" data-slider-auto="2" data-slider-controlnav="1" data-slider-directionnav="1">
                <ul class="rs-ul slides">
                    <?php
                        while ( $result_set->have_posts() ) :
                        $result_set->the_post();
                    ?>

                    <li itemscope="" itemtype="http://schema.org/ImageObject">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title();?>">
                            <?php
                                if ( has_post_thumbnail() ) {
                                    trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('itemprop' => 'thumbnailUrl'));
                                } else {
                                    trendmag_get_default_image($image_slug);
                                }
                            ?>
                        </a>
                    </li>

                    <?php endwhile; ?>

                </ul>
            </div>
        </div>
        <!-- /.widget-content -->

        <?php
        endif;

        wp_reset_postdata();
        echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}