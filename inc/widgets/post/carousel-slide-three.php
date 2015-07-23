<?php

add_action( 'widgets_init', array('TTP_Widget_Carousel_Slide', 'register_widget'));

class TTP_Widget_Carousel_Slide extends Kopa_Widget {

	public $kpb_group = 'slider';

    public static function register_widget(){
        register_widget('TTP_Widget_Carousel_Slide');
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-owl-widget owl-widget-12 owl-nagative loader';
		$this->widget_description = __('Display slides with carousel effect, three item per page.', 'trendmag-toolkit-plus');
		$this->widget_id          = 'trendmag_carousel_slide';
		$this->widget_name        = __( '(Trendmag) Slide Three', 'trendmag-toolkit-plus' );
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
			$image_slug = 'widget-carousel-slides-three';
			?>

            <div class="widget-content">
                <div class="owl-carousel owl-theme owl-content" data-slider-item="3" data-item-tablet="1" data-slider-auto="2" data-slider-navigation="2" data-slider-pagination="2">
                    <?php
                        while ( $result_set->have_posts() ):
                            $result_set->the_post();
                    ?>

                        <div class="entry-item">

                            <div class="entry-thumb">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php
                                        if ( has_post_thumbnail()) {
                                            trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('alt' => get_the_title()));
                                        } else {
                                            trendmag_get_default_image($image_slug, array('alt' => get_the_title()));
                                        }
                                    ?>
                                </a>
                            </div>


                            <div class="entry-content">
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                                <div class="entry-meta">
                                    <?php
                                        get_template_part('template/module/common/category');
                                        get_template_part('template/module/common/date');
                                        get_template_part('template/module/common/share');
                                    ?>
                                </div>
                            </div>
                            <!-- /.entry-content -->
                        </div>
                        <!-- /.entry-item -->

                    <?php endwhile; ?>
                </div>

                <div class="customNavigation">
                    <a class="btn prev"></a>
                    <a class="btn next"></a>
                </div>
                <!-- /.customNavigation -->
            </div>

			<?php
		endif;

		wp_reset_postdata();

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}