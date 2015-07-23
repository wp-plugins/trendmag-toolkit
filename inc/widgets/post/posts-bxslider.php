<?php

add_action( 'widgets_init', array('TT_Widget_Post_Bxslider', 'register_widget'));

class TT_Widget_Post_Bxslider extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget(){
		register_widget('TT_Widget_Post_Bxslider');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-bx-widget bx-widget-1';
		$this->widget_description = __( 'Display list posts with bxslider effect', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_post_bxslider';
		$this->widget_name        = __( '(Trendmag) Post Bxslider', 'trendmag-toolkit' );

        $this->settings 		  = trendmag_toolkit_get_post_widget_args();
        $this->settings['mode'] = array(
            'type'  => 'select',
            'std'   => 'vertical',
            'label' => __( 'Mode ( horizontal or vertical. Default is vertical )', 'trendmag-toolkit' ),
            'options' => array(
                'vertical' => __('Vertical', 'trendmag-toolkit'),
                'horizontal' => __('Horizontal', 'trendmag-toolkit')
            )
        );
        $this->settings['auto'] = array(
            'type'  => 'checkbox',
            'std'   => 1,
            'label' => __( 'Auto slide', 'trendmag-toolkit' )
        );
        $this->settings['speed'] = array(
            'type'  => 'text',
            'std'   => 4000,
            'label' => __( 'Speed ( Default is 4000 )', 'trendmag-toolkit' )
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();

		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);		
		if ( empty($mode) ) {
            $mode = 'vertical';
        }
        if ( empty($speed)) {
            $speed = 4000;
        }
		echo $before_widget;

        if ( ! empty($title) ) : ?>

            <h4 class="widget-title style-2">
                <span><?php echo esc_html($title); ?></span>
            </h4>

        <?php endif;

        echo '<div class="widget-content" data-slider-mode="' . esc_attr($mode) . '" data-slider-auto="' . esc_attr($auto) . '" data-slider-speed="' . esc_attr($speed) .'" data-slider-navigation="1" data-slider-pagination="1">';

            echo '<ul class="rs-ul bxslider">';

        $query = trendmag_toolkit_get_post_widget_query($instance);
        $results = new WP_Query( $query );

        if ( $results->have_posts() ) {
            while ( $results->have_posts() ) {
                $results->the_post();

                $post_title = get_the_title();
                $image_slug = 'widget-post-bxslider';

                ?>

                    <li>
                        <article class="entry-item <?php if ( ! has_post_thumbnail() ) { echo ' no-thumb';}?>" itemscope="" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="entry-thumb" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($post_title); ?>" itemprop="contentUrl"><?php trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('itemprop' => 'thumbnailUrl')); ?></a>
                                    <?php get_template_part('template/module/common/overlay'); ?>
                                </div>
                                <!-- /.entry-thumb -->
                            <?php endif; ?>
                            <header>
                                <h6 class="entry-title style-5" itemprop="headline">
                                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($post_title); ?>"><?php echo esc_html($post_title); ?></a>
                                </h6>
                                <div class="entry-meta">
                                    <?php
                                        get_template_part('template/module/common/category');
                                        get_template_part('template/module/common/date');
                                        get_template_part('template/module/common/share');
                                    ?>
                                </div>
                            </header>
                        </article>
                        <!-- /.entry-item -->
                    </li>

                <?php
            }
        }

        wp_reset_postdata();

            echo '</ul>';
        echo '</div>';

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}
