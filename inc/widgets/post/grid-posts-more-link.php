<?php

add_action( 'widgets_init', array('TT_Widget_Grid_Post_More_Link', 'register_widget'));

class TT_Widget_Grid_Post_More_Link extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget(){
		register_widget('TT_Widget_Grid_Post_More_Link');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-articles-list-widget articles-list-7 kopa-match-height';
		$this->widget_description = __( 'Display grid posts with more link', 'trendmag-toolkit' );
		$this->widget_id          = 'trenmag_toolkit_grid_post_more_link_widget';
		$this->widget_name        = __( '(Trendmag) Grid Posts More Link', 'trendmag-toolkit' );

        $this->settings 		  = trendmag_toolkit_get_post_widget_args();
        $this->settings['btn_text'] = array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Button text', 'trendmag-toolkit' ),
        );
        $this->settings['btn_link'] = array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Button link', 'trendmag-toolkit' ),
        );
        $this->settings['target'] = array(
            'type'  => 'checkbox',
            'std'   => 1,
            'label' => __( 'Open link in new window', 'trendmag-toolkit' ),
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
                <div class="inner">
                    <h2 class="widget-title style-1"><span><?php echo esc_html($title); ?></span></h2>
                    <?php
                        if ( ! empty($btn_text) ) {
                            $target_tmp = '_self';
                            if ( $target ) {
                                $target_tmp = '_blank';
                            }
                            ?>
                            <a href="<?php echo esc_url($btn_link); ?>" target="<?php echo esc_attr($target_tmp); ?>" class="view-topic"><span><?php echo esc_html($btn_text); ?></span><i class="kopa-icon arrow-right"></i></a>
                        <?php }
                    ?>
                </div>
            </div>
        <?php }

        $query = trendmag_toolkit_get_post_widget_query($instance);
        $results = new WP_Query( $query );

        if ( $results->have_posts() ) {
            echo '<div class="widget-content">';
                echo '<div class="row">';
            $image_slug = 'single-related';
            while ( $results->have_posts() ) {
                $results->the_post();
                ?>

                    <div class="col-xs-12 col-sm-6 col-md-3 match-height-item">
                        <div class="entry-item">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="entry-thumb" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title();?>" itemprop="contentUrl">
                                        <?php trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('itemprop' => 'thumbnailUrl')); ?>
                                    </a>
                                    <?php get_template_part('template/module/common/overlay'); ?>
                                </div>
                            <?php endif; ?>

                            <header>
                                <h5 class="entry-title style-1">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </h5>
                                <?php get_template_part('template/module/common/category'); ?>
                            </header>
                        </div>
                        <!-- /.entry-item -->
                    </div>

                <?php
            }
                echo '</div>';
            echo '</div>';
        }

        wp_reset_postdata();

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}
