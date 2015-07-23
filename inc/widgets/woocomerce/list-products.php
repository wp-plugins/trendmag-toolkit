<?php

if(!class_exists('WooCommerce'))
	return;

add_action( 'widgets_init', array('TTP_Widget_List_Products', 'register_widget'));

class TTP_Widget_List_Products extends Kopa_Widget {

	public $kpb_group = 'product';
	
	public static function register_widget(){
       register_widget('TTP_Widget_List_Products');
    }

	public function __construct() {
		$this->widget_cssclass    = 'trendmag_toolkit_plus-list kopa-intro-products kopa-match-height intro-product-1 ';
		$this->widget_description = __( 'Display a list of products.', 'trendmag-toolkit-plus' );
		$this->widget_id          = 'trendmag_toolkit_plus-list-products';
		$this->widget_name        = __( 'Trendmag List Products', 'trendmag-toolkit-plus' );
		$this->settings 		  = array(	
			'title_first' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Title first', 'trendmag-toolkit-plus' )
			),
            'title_after' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => __( 'Title after', 'trendmag-toolkit-plus' )
            ),
            'title_link' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => __( 'Title link', 'trendmag-toolkit-plus' )
            ),
            'description' => array(
                'type'  => 'textarea',
                'std'   => '',
                'label' => __( 'Description', 'trendmag-toolkit-plus' )
            ),
            'btn_text' => array(
                'type'  => 'text',
                'std'   => __('lookbook', 'trendmag-toolkit-plus'),
                'label' => __( 'Button text', 'trendmag-toolkit-plus' )
            ),
            'btn_link' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => __( 'Button link', 'trendmag-toolkit-plus' )
            ),
			'posts_per_page'  => array(
				'type'  => 'number',
				'std'   => 2,
				'label' => __( 'Number of product', 'trendmag-toolkit-plus' )
			),	
			'order'	=> array(
				'type'    => 'select',
				'std'     => 'best_selling_products',
				'label'   => __('Order', 'trendmag-toolkit-plus'),
				'options' => array(
					'sale_products'         => __('Sale products', 'trendmag-toolkit-plus'),
					'best_selling_products' => __('Best selling products', 'trendmag-toolkit-plus'),
					'top_rated_products'    => __('Top rated products', 'trendmag-toolkit-plus'),
					'featured_products'     => __('Featured products', 'trendmag-toolkit-plus'),
				),				
			),
            'target_window'  => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Open link in new window', 'trendmag-toolkit-plus' )
            ),
        );
		
		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();

		extract( $args );

		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		switch ($order) {
			case 'sale_products':
				$result_set = $this->get_query_sale_products($posts_per_page);
				break;
			case 'top_rated_products':
				$result_set = $this->get_query_top_rated_products($posts_per_page);
				break;
			case 'featured_products':
				$result_set = $this->get_query_featured_products($posts_per_page);
				break;
			default:
				$result_set = $this->get_query_best_selling_products($posts_per_page);
				break;
		}
		
		echo $before_widget;

        echo '<div class="inner"></div>';

        echo '<div class="widget-content wrapper">';

        if ( $target_window ) {
            $target = '_blank';
        } else {
            $target = '_self';
        }

		if ( ! empty($title_first) || ! empty($title_before) || ! empty($description) || ( ! empty($btn_text) && ! empty($btn_link))  ) : ?>

            <div class="intro-col match-height-item">
                <div class="entry-item">
                    <?php if ( ! empty($title_first) || ! empty($title_before) ) : ?>

                        <header>
                            <h2 class="entry-title style-9">
                                <a href="<?php echo esc_url($title_link); ?>" target="<?php echo esc_attr($target); ?>">
                                    <?php if ( ! empty($title_first) ) : ?>
                                        <span><?php echo esc_html($title_first) . ' '; ?></span>
                                    <?php endif; ?>
                                    <?php echo esc_html($title_after); ?>
                                </a>
                            </h2>
                        </header>

                    <?php endif; ?>

                    <?php if ( ! empty($description) ) : ?>
                        <div class="entry-content">
                            <p><?php echo esc_textarea($description);?></p>
                        </div>
                        <!-- /.entry-content -->
                    <?php endif; ?>

                    <?php if ( ! empty($btn_text) && ! empty($btn_link) ) : ?>
                        <footer>
                            <a href="<?php echo esc_url($btn_link); ?>" class="view-topic-2" target="<?php echo esc_attr($target); ?>"><span><?php echo esc_html($btn_text); ?></span><i class="kopa-icon arrow-right"></i></a>
                        </footer>
                    <?php endif; ?>
                </div>
            </div>

         <?php endif;

		if ($result_set->have_posts()):
            $image_slug = 'widget-woo-list-products';
            ?>

            <div class="products-col match-height-item">
                <ul class="rs-ul">
                    <?php
                        while ($result_set->have_posts()) {
                            $result_set->the_post();
                            global $product;
                        ?>

                            <li>
                                <div class="entry-item">
                                    <div class="entry-thumb">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php
                                                if ( has_post_thumbnail() ) {
                                                    trendmag_the_post_thumbnail(get_the_ID(), $image_slug);
                                                } else {
                                                    trendmag_get_default_image($image_slug);
                                                }
                                            ?>
                                        </a>
                                    </div>
                                    <div class="entry-content">
                                        <h5 class="product-name"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
                                        <?php
                                            if( $product->is_on_sale() && $product->get_sale_price() > 0 ) {
                                                echo '<span class="current-price">'.woocommerce_price( $product->get_sale_price() ).'</span>';
                                            } elseif ( isset($product->regular_price) && $product->regular_price > 0 ) {
                                                echo '<span class="current-price">'.woocommerce_price( $product->regular_price ).'</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                    ?>
                </ul>
            </div>

            <?php
		endif;

        echo '</div>';

		wp_reset_postdata();

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

	public function get_query_best_selling_products($posts_per_page){
		$meta_query = WC()->query->get_meta_query();
		$atts = array(
			'orderby' => 'title',
			'order'   => 'asc');
		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $posts_per_page,
			'meta_key'            => 'total_sales',
			'orderby'             => 'meta_value_num',
			'meta_query'          => $meta_query
		);		

		return new WP_Query(apply_filters('woocommerce_shortcode_products_query', $args, $atts));
	}

	public function get_query_sale_products($posts_per_page){
		$meta_query = WC()->query->get_meta_query();
		
		$atts = array(
			'orderby' => 'title',
			'order'   => 'asc');

		$product_ids_on_sale = wc_get_product_ids_on_sale();

		$args = array(
			'posts_per_page'	=> $posts_per_page,
			'orderby' 			=> $atts['orderby'],
			'order' 			=> $atts['order'],
			'no_found_rows' 	=> 1,
			'post_status' 		=> 'publish',
			'post_type' 		=> 'product',
			'meta_query' 		=> $meta_query,
			'post__in'			=> array_merge( array( 0 ), $product_ids_on_sale )
		);

		return new WP_Query(apply_filters('woocommerce_shortcode_products_query', $args, $atts));
	}

	public function get_query_top_rated_products($posts_per_page){
		$meta_query = WC()->query->get_meta_query();

		$atts = array(
			'orderby' => 'title',
			'order'   => 'asc');
		
		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'posts_per_page'      => $posts_per_page,
			'meta_query'          => $meta_query
		);

		add_filter('posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses'));

		$query = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $args, $atts));

		remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );

		return $query;
	}

	public function get_query_featured_products($posts_per_page){
		$atts = array(
			'orderby' => 'title',
			'order'   => 'asc');

		$meta_query   = WC()->query->get_meta_query();
		$meta_query[] = array(
			'key'   => '_featured',
			'value' => 'yes'
		);

		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $posts_per_page,
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'meta_query'          => $meta_query
		);

		return new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
	}
}