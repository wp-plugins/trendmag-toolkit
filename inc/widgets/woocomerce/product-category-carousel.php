<?php

if(!class_exists('WooCommerce'))
    return;

add_action( 'widgets_init', array('TTP_Product_Category_Carousel', 'register_widget'));

class TTP_Product_Category_Carousel extends Kopa_Widget {

    public $kpb_group = 'product';

    public static function register_widget(){
        register_widget('TTP_Product_Category_Carousel');
    }

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kopa-owl-widget kopa-match-height loader owl-widget-4';
		$this->widget_description = __( 'Show shop categories with carousel effect', 'trendmag-toolkit-plus' );
		$this->widget_id          = 'trendmag_toolkit_plus-product-category-carousel';
		$this->widget_name        = __( 'Trendmag Product Categories Carousel', 'trendmag-toolkit-plus' );

        $all_category = get_categories(array(
            'taxonomy'     => 'product_cat',
            'hide_empty' => 0,
        ));

        $categories['all'] = __('-- Select Categories --', 'trendmag-toolkit-plus');
        if ( $all_category ){
            foreach ($all_category as $category) {
                if ( isset($category->slug) && isset($category->name) ){
                    $categories[ $category->slug ] = $category->name;
                }
            }
        }

		$this->settings           = array(
            'categories_shop' => array(
                'type'    => 'multiselect',
                'std'     => 'all',
                'label'   => __( 'Categories', 'trendmag-toolkit-plus' ),
                'options' => $categories,
                'size'    => '5',
            ),

		);
		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		ob_start();
		extract( $args );

        $instance = wp_parse_args((array) $instance, $this->get_default_instance());

        extract($instance);
        
		echo $before_widget;

        $categories = array();

        if ( 1 == count($categories_shop) && 'all' == $categories_shop[0] ){
            $all_category = get_categories(array(
                'taxonomy'     => 'product_cat',
                'hide_empty' => 0,
            ));
            if ( $all_category ){
                foreach ($all_category as $category) {
                    if ( isset($category->slug) && isset($category->name) ){
                        $categories[ $category->slug ] = $category->name;
                    }
                }
            }
        } else {
            $categories = $categories_shop;
        }

        if ( $categories ) :

        ?>

        <div class="widget-content">
            <div class="owl-carousel owl-theme owl-content" data-slider-item="3" data-slider-auto="2" data-slider-navigation="2" data-slider-pagination="2">

                <?php
                    foreach ( $categories as $slug ) :
                        $term = get_term_by('slug', $slug, 'product_cat');
                        $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                        $image = wp_get_attachment_url( $thumbnail_id );
                        if ( empty($image) ) {
                            $image = '//placehold.it/100x100';
                        }
                        $params = array( 'width' => 100, 'height' => 100, 'crop' => true );
                        $term_img = bfi_thumb( $image, $params);
                        $term_url = get_term_link( $term, 'product_cat' );
                ?>

                        <div class="match-height-item">
                            <div class="entry-item">
                                <div class="entry-thumb">
                                    <a href="<?php echo esc_url($term_url); ?>" title="<?php echo esc_attr($term->name); ?>">
                                        <img src="<?php echo esc_url($term_img); ?>" alt="<?php echo esc_attr($term->name); ?>" />
                                    </a>
                                </div>
                                <!-- /.entry-thumb -->
                                <div class="entry-box">
                                    <h6 class="entry-title style-8">
                                        <a href="<?php echo esc_url($term_url); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
                                    </h6>
                                    <?php if ( ! empty($term->description) ) : ?>
                                        <p class="description"><?php echo esc_textarea($term->description); ?></p>
                                    <?php endif; ?>
                                </div>
                                <!-- /.entry-box -->
                            </div>
                            <!-- /.entry-item -->
                        </div>

                <?php endforeach; ?>

            </div>
        </div>

        <?php endif; ?>

        <?php
		echo $after_widget;
		$content = ob_get_clean();
		echo $content;
	}
}
