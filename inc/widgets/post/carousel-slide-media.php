<?php

add_filter('kpb_get_widgets_list', array('TTP_Widget_Carousel_Slide_Media', 'register_block'));

class TTP_Widget_Carousel_Slide_Media extends Kopa_Widget {

	public $kpb_group = 'slider';
	
	public static function register_block($blocks){
        $blocks['TTP_Widget_Carousel_Slide_Media'] = new TTP_Widget_Carousel_Slide_Media();
        return $blocks;
    }

    
	public function __construct() {
		$this->widget_cssclass    = 'kopa-owl-widget owl-widget-12 owl-nagative loader';
		$this->widget_description = __('Display slides with carousel effect for media page, three item per page.', 'trendmag-toolkit-plus');
		$this->widget_id          = 'trendmag_carousel_slide_media';
		$this->widget_name        = __( '(Trendmag) Slide Media', 'trendmag-toolkit-plus' );
		$this->settings 		  = trendmag_toolkit_get_post_widget_args();

        $this->settings['post_format'] = array(
            'type' => 'select',
            'std'   => '',
            'options' => array(
                'post-format-video' => __('Video', 'trendmag-toolkit'),
                'post-format-gallery' => __('Gallery', 'trendmag-toolkit'),
            ),
            'label' => __( 'Format:', 'trendmag-toolkit' ),
        );
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
                                        if ( has_post_thumbnail() ) {
                                            trendmag_the_post_thumbnail(get_the_ID(), $image_slug);
                                        } else {
                                            trendmag_get_default_image($image_slug);
                                        }
                                    ?>
                                </a>
                                <?php
                                    $play_icon = '';
                                    if ( 'post-format-video' == $post_format ) {
                                        $play_icon = 'fa fa-play';
                                    } elseif ( 'post-format-gallery' == $post_format ) {
                                        $play_icon = 'fa fa-picture-o';
                                    }
                                    if ( ! empty($play_icon) ):
                                ?>
                                <a class="kopa-icon" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><i class="<?php echo esc_attr($play_icon); ?>"></i></a>
                                <?php endif; ?>
                            </div>

                            <div class="entry-content">
                                <?php
                                $post_cats = get_the_category( get_the_ID() );
                                if ( $post_cats ) {
                                    $count = true;
                                    foreach ( $post_cats as $category ) {
                                        if ( $count ) {
                                            echo sprintf('<span>%s</span>', esc_html($category->name));
                                        }
                                        $count = false;
                                    }
                                }

                                ?>
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <!-- /.entry-content -->
                        </div>

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