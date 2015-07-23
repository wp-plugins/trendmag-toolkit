<?php

add_action( 'widgets_init', array('TT_Widget_Grid_Post_Carousel', 'register_widget'));

class TT_Widget_Grid_Post_Carousel extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget(){
		register_widget('TT_Widget_Grid_Post_Carousel');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-owl-widget kopa-match-height owl-widget-2 loader';
		$this->widget_description = __( 'Display grid posts for some layouts with carousel effect', 'trendmag-toolkit' );
		$this->widget_id          = 'grid_post_widget';
		$this->widget_name        = __( '(Trendmag) Grid Posts Carousel', 'trendmag-toolkit' );

        $this->settings 		  = trendmag_toolkit_get_post_widget_args();
        $this->settings['show_header_border'] = array(
            'type' => 'checkbox',
            'label'   => __( 'Show border of header', 'trendmag-toolkit' ),
            'std'     => 1,
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();

		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);		
		
		echo $before_widget;

        #WIDGET TITLE
        if ( ! empty($title) ) { ?>
            <div class="widget-header">

                <?php if ( 1 == $show_header_border ) : ?>
                <span class="separator-1"></span>
                <?php endif; ?>

                <div class="inner">
                    <h2 class="widget-title style-1"><span><?php echo esc_html($title); ?></span></h2>
                </div>
            </div>
        <?php }

        $widget_content_before = '<div class="widget-content"><div class="kopa-row-30"><div class="owl-carousel owl-theme owl-content" data-slider-item="4" data-slider-auto="2" data-slider-navigation="2" data-slider-pagination="2">';
        $widget_content_after = '</div></div></div>';

        echo $widget_content_before;

        $query = trendmag_toolkit_get_post_widget_query($instance);
        $results = new WP_Query( $query );

        if ( $results->have_posts() ) {
            $image_slug = 'widget-grid-post-grid-4-posts';
            while ( $results->have_posts() ) {
                $results->the_post();
                $post_title = get_the_title();

                if ( empty($post_title) ) {
                    $post_title = __('No title', 'trendmag');
                }

                ?>

            <div class="match-height-item">
                <article class="entry-item" itemscope="" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="entry-thumb" itemscope="" itemtype="http://schema.org/ImageObject">
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($post_title); ?>">
                            <?php trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('itemprop' => 'thumbnailUrl')); ?>
                        </a>
                        <?php get_template_part('template/module/common/overlay'); ?>
                    </div>
                    <?php endif; ?>

                    <header>
                        <h5 class="entry-title style-1" itemprop="headline">
                            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($post_title); ?>"><?php echo esc_html($post_title); ?></a>
                        </h5>
                    </header>
                    <footer>
                        <div class="entry-meta">
                            <?php
                            get_template_part('template/module/common/category');
                            get_template_part('template/module/common/date');
                            get_template_part('template/module/common/share');
                            ?>
                        </div>
                    </footer>
                </article>
                <!-- /.entry-item -->
            </div>


                <?php
            }
        }

        wp_reset_postdata();

        echo $widget_content_after;

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}
