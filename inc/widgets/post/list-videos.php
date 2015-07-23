<?php

add_action( 'widgets_init', array('TT_Widget_List_Videos', 'register_widget'));

class TT_Widget_List_Videos extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget(){
		register_widget('TT_Widget_List_Videos');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-owl-widget owl-widget-3 loader';
		$this->widget_description = __( 'Display list video posts with only thumbnail and play icon.', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_toolkit_list_video';
		$this->widget_name        = __( '(Trendmag) List Videos', 'trendmag-toolkit' );

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

        echo '<div class="wrapper">';

        if ( ! empty($title) || ! empty($btn_text) ): ?>

            <div class="widget-header">
                <?php if ( ! empty($title) ) : ?>
                    <h2 class="widget-title style-1"><span><?php echo esc_html($title); ?></span></h2>
                <?php endif; ?>

                <?php if ( ! empty($btn_text) ) :
                    $target_txt = '_self';
                    if ( 1 == $target ) {
                        $target_txt = '_blank';
                    }
                ?>
                    <a href="<?php echo esc_url($btn_link); ?>" target="<?php echo esc_attr($target_txt); ?>" class="view-topic"><span><?php echo esc_html($btn_text); ?></span><i class="kopa-icon arrow-right"></i></a>
                <?php endif; ?>
            </div>

        <?php endif;

        echo '<div class="widget-content">';

        $instance['post_format'] = 'post-format-video';
        $query = trendmag_toolkit_get_post_widget_query($instance);

        $result_set = new WP_Query( $query );

        if ( $result_set->have_posts() ) {
            echo '<div class="row">';
                echo '<div class="owl-carousel owl-theme owl-content" data-slider-item="4" data-slider-auto="2" data-slider-navigation="2" data-slider-pagination="2">';
                    while ( $result_set->have_posts() ) :
                        $result_set->the_post();
                        $post_title = get_the_title();

                        if ( empty($post_title) ) {
                            $post_title = __('No title', 'trendmag');
                        }
                        ?>

                        <article class="entry-item" itemscope="" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="entry-thumb" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($post_title); ?>" itemprop="contentUrl">
                                        <?php
                                            $image_slug = 'widget-list-video';
                                            trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('itemprop' => 'thumbnailUrl'));
                                        ?>
                                    </a>
                                    <div class="overlay style-1">
                                        <a href="<?php the_permalink(); ?>" class="kopa-icon" title="<?php echo esc_attr($post_title); ?>"><i class="fa fa-play"></i></a>
                                    </div>
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
                                        get_template_part('template/module/common/post-view');
                                    ?>
                                </div>
                            </footer>
                        </article>

                    <?php endwhile;
                echo '</div>';
            echo '</div>';
        }

        wp_reset_postdata();

        echo '</div>';

        echo '</div>';

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}
