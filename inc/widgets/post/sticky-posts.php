<?php

add_action( 'widgets_init', array('TT_Widget_Sticky_Post', 'register_widget'));
	
class TT_Widget_Sticky_Post extends Kopa_Widget {

	public $kpb_group = 'post';
	
	public static function register_widget(){
       register_widget('TT_Widget_Sticky_Post');
    }
    
	public function __construct() {
		$this->widget_cssclass    = 'kopa-sticker-widget sticker-1 loader';
		$this->widget_description = __( 'Display sticky post by newest.', 'trendmag-toolkit');
		$this->widget_id          = 'trendmag_toolkit_plus-sticky-post';
		$this->widget_name        = __( '(Trendmag) Sticky Posts', 'trendmag-toolkit' );
		$this->settings 		  = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => __('live stream', 'trendmag-toolkit'),
                'label' => __( 'Title:', 'trendmag-toolkit' ),
            ),
            'number' => array(
                'type'    => 'number',
                'std'     => '5',
                'label'   => __( 'Number of posts:', 'trendmag-toolkit' ),
                'min'     => '0',
            ),
            'length' => array(
                'type'    => 'number',
                'std'     => '10',
                'label'   => __( 'Number words of Excerpt to show:', 'trendmag-toolkit' ),
                'min'     => '1',
            )
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		ob_start();

		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
		extract( $instance );
		
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        $sticky = get_option( 'sticky_posts' );
        $args = array(
            'posts_per_page' => intval($number),
            'post__in'  => $sticky,
            'ignore_sticky_posts' => 1
        );

		$result_set = new WP_Query( $args );
		echo $before_widget;
		
		echo '<div class="widget-content">';
            echo ' <div class="wrapper">';

                if ( ! empty($title) ) {
                    echo sprintf('<span class="kp-headline-title">%s</span>', esc_attr($title));
                }

                if ( $result_set->have_posts() && $number ) {
                    echo '<div class="kp-headline">';
                    echo '<dl class="ticker" data-ticker-width="920" data-ticker-height="30">';

                    while ( $result_set->have_posts() ) :
                        $result_set->the_post();
                        $post_excerpt = trendmag_get_the_excerpt(get_the_excerpt(), get_the_content(), intval($length), '...');
                        ?>

                    <dt></dt>
                    <dd>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <strong><?php the_title(); ?>:</strong>
                            <?php echo wp_kses_post($post_excerpt); ?>
                        </a>
                    </dd>

                    <?php
                    endwhile;
                    echo '</dl>';
                    echo '</div>';
                }

            echo '</div>';
        echo '</div>';

		wp_reset_postdata();

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}