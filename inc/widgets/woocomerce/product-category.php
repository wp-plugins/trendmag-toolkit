<?php

if(!class_exists('WooCommerce'))
    return;

add_action( 'widgets_init', array('TTP_Product_Category', 'register_widget'));

class TTP_Product_Category extends Kopa_Widget {

    public $kpb_group = 'product';

    public static function register_widget(){
        register_widget('TTP_Product_Category');
    }

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'trendmag_toolkit_plus-products-carousel kopa-owl-widget kopa-match-height owl-widget-6 nav-top loader';
		$this->widget_description = __( 'Show shop categories', 'trendmag-toolkit-plus' );
		$this->widget_id          = 'trendmag_toolkit_plus-product-category';
		$this->widget_name        = __( 'Trendmag Product Categories', 'trendmag-toolkit-plus' );

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
            'title' => array(
                'type'    => 'text',
                'std'     => '',
                'label'   => __( 'Title', 'trendmag-toolkit-plus' ),
            ),

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

        if ( ! empty($title) ) {
            echo '<h2 class="widget-title style-1"><span>' . esc_html($title) . '</span></h2>';
        }

        if ( $categories ) :

        ?>

        <div class="widget-content">
            <div class="kopa-row-30">

                <?php
                    $slide_item = 4;
                    if ( count($categories) > $slide_item):
                ?>
                    <div class="customNavigation">
                        <a class="btn prev"><i class="kopa-icon arrow-left"></i></a>
                        <span class="current-slide"></span>
                        <span class="text-center"> <?php _e('of', 'trendmag-toolkit-plus'); ?> </span>
                        <span class="total-slides"></span>
                        <a class="btn next"><i class="kopa-icon arrow-right"></i></a>
                    </div>
                    <!-- /.customNavigation -->
                <?php endif; ?>

                <div class="owl-carousel owl-theme owl-content" data-slider-item="<?php echo esc_attr($slide_item); ?>" data-slider-auto="2" data-slider-navigation="2" data-slider-pagination="2">

                    <?php
                    foreach ( $categories as $slug ) :
                        $term = get_term_by('slug', $slug, 'product_cat');
                        $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                        $image = wp_get_attachment_url( $thumbnail_id );
                        if ( empty($image) ) {
                            $image = '//placehold.it/247x353';
                        }
                        $params = array( 'width' => 247, 'height' => 353, 'crop' => true );
                        $term_img = bfi_thumb( $image, $params);
                        $term_url = get_term_link( $term, 'product_cat' );

                        ?>

                        <div class="match-height-item">
                            <article class="entry-item">
                                <div class="entry-thumb">
                                    <a href="<?php echo esc_url($term_url); ?>" title="<?php echo esc_attr($term->name); ?>">
                                        <img src="<?php echo esc_url($term_img); ?>" alt="<?php echo esc_attr($term->name); ?>" />
                                    </a>
                                </div>
                                <div class="entry-content">
                                    <h2 class="collection-name">
                                        <a href="<?php echo esc_url($term_url); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
                                    </h2>
                                    <span class="collection-description"><?php echo esc_textarea($term->description); ?></span>
                                    <span class="divier"></span>
                                    <span class="total-products"><?php echo esc_html($term->count) . __(' products', 'trendmag-toolkit-plus'); ?></span>

                                </div>
                            </article>
                            <!-- /.entry-item -->
                        </div>

                    <?php endforeach; ?>

                </div>

            </div>
        </div>

        <?php endif; ?>

        <?php
		echo $after_widget;
		$content = ob_get_clean();
		echo $content;
	}
}
