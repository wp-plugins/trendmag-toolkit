<?php

add_action( 'widgets_init', array('TTP_Widget_Carousel_Slide_Five', 'register_widget'));

class TTP_Widget_Carousel_Slide_Five extends Kopa_Widget {

	public $kpb_group = 'slider';

    public static function register_widget(){
        register_widget('TTP_Widget_Carousel_Slide_Five');
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-owl-widget kopa-match-height owl-widget-1 loader';
		$this->widget_description = __('Display slides with carousel effect, five item per page.', 'trendmag-toolkit-plus');
		$this->widget_id          = 'trendmag_carousel_slide_five';
		$this->widget_name        = __( '(Trendmag) Slide Five', 'trendmag-toolkit-plus' );
		$this->settings 		  = trendmag_toolkit_get_post_widget_args();

        $this->settings['excerpt_length'] = array(
            'type'    => 'number',
            'std'     => 5,
            'label'   => __( 'Number words of excerpt to show:', 'trendmag-toolkit' ),
            'min'     => '1',
        );

        $this->settings['thumbnail_size'] = array(
            'type'  => 'select',
            'std'   => '302_500',
            'options' => array(
                '302-500' => '302 x 500 px',
                '302-255' => '302 x 255 px',
            ),
            'label' => __( 'Thumbnail size', 'trendmag-toolkit-plus' )
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
			$image_slug = 'widget-carousel-slides-five-'.$thumbnail_size;

			?>

            <div class="widget-content">
                <div class="owl-carousel owl-theme owl-content" data-slider-item="5" data-slider-auto="2" data-slider-navigation="2" data-slider-pagination="2">
                    <?php
                        while ( $result_set->have_posts() ):
                            $result_set->the_post();

                            $post_excerpt = trendmag_get_the_excerpt(get_the_excerpt(), get_the_content(), intval($excerpt_length));
                    ?>

                        <article class="entry-item match-height-item" itemscope="" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

                            <?php if ( has_post_thumbnail() ) : ?>

                                <div class="entry-thumb" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" itemprop="contentUrl">
                                        <?php trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('itemprop' => 'thumbnailUrl')); ?>
                                    </a>
                                    <?php get_template_part('template/module/common/overlay'); ?>
                                </div>

                            <?php endif; ?>

                            <div class="entry-box">
                                <header>
                                    <h2 class="entry-title style-7" itemprop="headline">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </header>
                                <?php if ( ! empty($post_excerpt) ) : ?>
                                    <div class="entry-content" itemprop="text">
                                        <p class="entry-des"><?php echo wp_kses_post($post_excerpt); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- /.entry-box -->
                        </article>

                    <?php endwhile; ?>
                </div>

                <div class="customNavigation">
                    <a class="btn prev"><i class="kopa-icon arrow-left"></i></a>
                    <a class="btn next"><i class="kopa-icon arrow-right"></i></a>
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