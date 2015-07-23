<?php

add_action( 'widgets_init', array('TTP_Widget_Recent_Post', 'register_widget'));

class TTP_Widget_Recent_Post extends Kopa_Widget {

	public $kpb_group = 'post';

    public static function register_widget(){
        register_widget('TTP_Widget_Recent_Post');
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-articles-list-widget articles-list-4';
		$this->widget_description = __('Display recent posts.', 'trendmag-toolkit-plus');
		$this->widget_id          = 'trendmag_toolkit_plus-recent-post';
		$this->widget_name        = __( '(Trendmag) Recent Posts', 'trendmag-toolkit-plus' );
		$this->settings 		  = trendmag_toolkit_get_post_widget_args();

		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		ob_start();

		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
		extract( $instance );
		
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);		

		$query = trendmag_toolkit_get_post_widget_query($instance);
		
		$result_set = new WP_Query( $query );
		
		echo $before_widget;

        if ( ! empty($title) ) : ?>

            <h4 class="widget-title style-2">
                <span><?php echo esc_html($title); ?></span>
            </h4>

        <?php endif;
		

		if ( $result_set->have_posts() ) :	?>

            <div class="widget-content">
                <ul class="rs-ul">
                    <?php while($result_set->have_posts() ) :
                        $result_set->the_post();
                    ?>
                    <li>
                        <article class="entry-item">
                            <?php if ( has_post_thumbnail() ) :
                                $image_slug = 'widget-recent-post';
                                ?>
                                <div class="entry-thumb">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('class' => 'img-responsive')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="entry-box">
                                <h5 class="entry-title style-6">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </h5>
                                <header>
                                    <p class="entry-meta">
                                        <?php get_template_part('template/module/common/category'); ?>
                                    </p>
                                </header>
                            </div>
                            <!-- /.entry-box -->
                        </article>
                        <!-- /.entry-item -->
                    </li>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    ?>
                </ul>
            </div>

			<?php
		endif;

		wp_reset_postdata();

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}