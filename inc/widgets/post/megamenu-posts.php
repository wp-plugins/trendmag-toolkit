<?php

add_action( 'widgets_init', array('TT_Widget_Megamenu_Post', 'register_widget'));

class TT_Widget_Megamenu_Post extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget(){
		register_widget('TT_Widget_Megamenu_Post');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-articles-list-widget articles-list-8';
		$this->widget_description = __( 'Display grid posts for megamenu', 'trendmag-toolkit' );
		$this->widget_id          = 'trenmag_toolkit_grid_post_widget_megamenu';
		$this->widget_name        = __( '(Trendmag) Megamenu Posts', 'trendmag-toolkit' );

        $this->settings 		  = trendmag_toolkit_get_post_widget_args();
        $this->settings['posts_per_page'] = array(
            'type'  => 'select',
            'std'   => 3,
            'options' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4
            ),
            'label' => __( 'Number of posts', 'trendmag-toolkit-plus' )
        );

        if ( isset($this->settings['title']) ) {
            unset($this->settings['title']);
        }

        if ( isset($this->settings['number']) ) {
            unset($this->settings['number']);
        }

        parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();

		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		echo $before_widget;

        echo '<div class="widget-content"><div class="row">';

        $instance['number'] = $posts_per_page;
        $query = trendmag_toolkit_get_post_widget_query($instance);
        $results = new WP_Query( $query );

        if ( $results->have_posts() ) {
            $image_slug = 'widget-megamenu-post';
            while ( $results->have_posts() ) {
                $results->the_post();
                ?>

                <div class="col-xs-3">
                    <article class="entry-item" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
                        <?php if ( has_post_thumbnail() ) : ?>

                            <div class="entry-thumb" itemscope="" itemtype="http://schema.org/ImageObject">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array( 'itemprop' => 'thumbnailUrl' ) ); ?>
                                </a>
                                <?php get_template_part('template/module/common/overlay'); ?>
                            </div>

                        <?php endif; ?>

                        <div class="entry-box">
                            <div class="entry-header">
                                <h5 class="entry-title style-5" itemprop="headline">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </h5>
                                <div class="entry-meta">
                                    <?php
                                        get_template_part('template/module/common/category');
                                        get_template_part('template/module/common/date');
                                        get_template_part('template/module/common/share');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- /.entry-item -->
                </div>

                <?php
            }
        }

        wp_reset_postdata();

        echo '</div></div>';

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}
