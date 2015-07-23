<?php
/**
 * Show Latest Products.
 *
 * @author 		Kopatheme
 * @category 	Widgets
 * @package 	KopaFramework/Widgets
 * @since    	1.0.0
 * @extends 	Kopa_Widget
 */

if(!class_exists('WooCommerce'))
    return;

add_action('widgets_init', array('Kopa_Widget_List_Product', 'register_widget'));


class Kopa_Widget_List_Product extends Kopa_Widget {

    public $kpb_group = 'product';

    public static function register_widget(){
        register_widget('Kopa_Widget_List_Product');
    }

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'products-list-widget products-list-1';
		$this->widget_description = __( 'Show latest products', 'newfashion' );
		$this->widget_id          = 'trendmag_toolkit_latest_product';
		$this->widget_name        = __( '(Trendmag) Latest Products', 'newfashion' );

		$this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'label' => __( 'Title', 'newfashion' ),
                'std' => __(' Products', 'newfashion')
            ),
            'products_per_page' => array(
                'type'    => 'number',
                'std'     => 3,
                'label'   => __( 'Number of products', 'newfashion' ),
                'min'     => '1',
            )
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

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        extract($instance);

		echo $before_widget;

        if ( ! empty($title) ) : ?>

            <h4 class="widget-title style-2">
                <span><?php echo esc_html($title); ?></span>
            </h4>

        <?php endif;


        global $woocommerce;
        $query_args = array('posts_per_page' => intval($products_per_page), 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product');
        $query_args['meta_query'] = array();
        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
        $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

        $products = new WP_Query($query_args);
        if ( $products->have_posts() ) :
        ?>
            <div class="widget-content">
                <ul class="rs-ul">
                    <?php while ( $products->have_posts() ) {
                        $products->the_post();
                        global $product;
                        ?>

                        <li>
                            <article class="entry-item" itemtype="http://schema.org/Product" itemscope="">
                                <div class="entry-thumb">
                                    <a href="<?php the_permalink(); ?>" itemprop="url" title="<?php the_title(); ?>">

                                        <?php
                                            if ( has_post_thumbnail() ){
                                                $image_slug = 'widget-woo-latest-product';
                                                trendmag_the_post_thumbnail(get_the_ID(), $image_slug);
                                            }else{
                                                woocommerce_placeholder_img( 'shop_thumbnail' );
                                            }
                                        ?>

                                    </a>
                                </div>
                                <!-- /.entry-thumb -->
                                <div class="entry-box">
                                    <h6 itemprop="name"><a href="<?php the_permalink(); ?>" itemprop="url" title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>

                                    <?php
                                    $product_terms = get_the_terms(  get_the_ID(), 'product_cat' );
                                    if ( $product_terms ) {
                                        $count = true;
                                        foreach ( $product_terms as $term ) {
                                            if ( $count ) { ?>

                                                <a href="<?php echo esc_url(get_term_link($term->term_id, 'product_cat')); ?>" class="categorie" title="<?php echo esc_html($term->name); ?>" rel="category"><?php echo esc_html(trendmag_uppercase_first_letter($term->name)); ?></a>

                                                <?php
                                            }
                                            $count = false;
                                        }
                                    }

                                    ?>

                                    <div class="price-wrap" itemtype="http://schema.org/Offer" itemscope="" itemprop="offers">

                                        <?php if ( isset($product->regular_price) && $product->regular_price > 0 ){ ?>
                                            <span  class="old-price"><del><?php echo woocommerce_price( $product->regular_price );?></del></span>
                                        <?php } ?>

                                        <?php
                                            $tt_is_on_sale = $product->is_on_sale();
                                            if ( !is_wp_error($tt_is_on_sale) && $product->get_sale_price() > 0 ) { ?>
                                                <span itemprop="price" class="current-price"><?php echo woocommerce_price( $product->get_sale_price() );?></span>
                                            <?php }
                                        ?>

                                        <meta itemprop="priceCurrency" content="£">
                                    </div>

                                </div>
                                <!-- /.entry-box -->
                            </article>
                        </li>

                        <?php

                    }?>
                </ul>
            </div>

        <?php endif;

		echo $after_widget;

        wp_reset_postdata();
		$content = ob_get_clean();
		echo $content;
	}

}
