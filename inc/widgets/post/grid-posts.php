<?php

add_action( 'widgets_init', array('TT_Widget_Grid_Post', 'register_widget'));

class TT_Widget_Grid_Post extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget(){
		register_widget('TT_Widget_Grid_Post');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-articles-list-widget articles-list-6';
		$this->widget_description = __( 'Display grid posts', 'trendmag-toolkit' );
		$this->widget_id          = 'trenmag_toolkit_grid_post_widget';
		$this->widget_name        = __( '(Trendmag) Grid Posts', 'trendmag-toolkit' );

        $this->settings 		  = trendmag_toolkit_get_post_widget_args();
        $this->settings['excerpt_length'] = array(
            'type' => 'number',
            'std' => 12,
            'label' => __( 'Number words of excerpt', 'trendmag-toolkit-plus' )
        );
        $this->settings['posts_per_page'] = array(
            'type'  => 'select',
            'std'   => 3,
            'options' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                6 => 6
            ),
            'label' => __( 'Number of posts', 'trendmag-toolkit-plus' )
        );

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

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);		
		
		echo $before_widget;

        #WIDGET TITLE
        if ( ! empty($title) ) { ?>
            <h2 class="widget-title style-1"><span><?php echo esc_html($title); ?></span></h2>
        <?php }

        $col_classes = array('mobile-fluid', 'col-xs-6');

        switch ((int) $posts_per_page) {
            case 1:
                array_push($col_classes, 'col-md-12', 'col-sm-12');
                break;
            case 2:
                array_push($col_classes, 'col-md-6', 'col-sm-6');
                break;
            case 3:
                array_push($col_classes, 'col-md-4', 'col-sm-4');
                break;
            case 4:
                array_push($col_classes, 'col-md-3', 'col-sm-3');
                break;
            default:
                array_push($col_classes, 'col-md-2', 'col-sm-2');
                break;
        }

        $col_classes = implode(' ', $col_classes);

        $instance['number'] = $posts_per_page;
        $query = trendmag_toolkit_get_post_widget_query($instance);
        $results = new WP_Query( $query );

        if ( $results->have_posts() ) {
            $image_slug = 'widget-grid-post-370-230';
            while ( $results->have_posts() ) {
                $results->the_post();

                $post_excerpt = trendmag_get_the_excerpt(get_the_excerpt(), get_the_content(), intval($excerpt_length) );
                ?>

                    <div class="<?php echo esc_attr($col_classes); ?>">
                        <article class="entry-item" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="entry-thumb" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title();?>" itemprop="contentUrl">
                                        <?php trendmag_the_post_thumbnail(get_the_ID(), $image_slug, array('itemprop' => 'thumbnailUrl')); ?>
                                    </a>
                                    <?php get_template_part('template/module/common/overlay'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="entry-box">
                                <header>
                                    <h5 class="entry-title style-8" itemprop="headline">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                    </h5>
                                    <div class="entry-meta">
                                        <?php get_template_part('template/module/common/date'); ?>

                                        <?php
                                            if ( comments_open() ) {
                                                comments_popup_link( __('No comments yet', 'trendmag-toolkit'), '1 ' . __('comment', 'trendmag-toolkit'), '% ' . __('comment(s)', 'trendmag-toolkit'), 'entry-comments', __('Comments are off for this post', 'trendmag-toolkit'));
                                            }
                                        ?>
                                    </div>
                                </header>

                                <?php if ( ! empty($post_excerpt) ) : ?>
                                    <div class="entry-content" itemprop="text">
                                        <p><?php echo esc_textarea($post_excerpt); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                        <!-- /.entry-item -->
                    </div>

                <?php
            }
        }

        wp_reset_postdata();

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}
