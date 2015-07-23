<?php

if(!class_exists('WooCommerce'))
	return;

new Trendmag_WooCommerce();

class Trendmag_WooCommerce{
	
	function __construct(){
		add_action('init', array($this, 'init'));

		#register-layout
		add_filter('kopa_layout_manager_settings', array($this,'add_layout_product_archive'));
		add_filter('kopa_layout_manager_settings', array($this,'add_layout_product_single'));
		add_filter('kopa_custom_template_setting_id', array($this,'set_layout_setting_id'));
		add_filter('kopa_custom_template_setting', array($this, 'get_layout_setting'), 10, 2);			
	}

	public function init(){
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
		add_filter('trendmag_get_breadcrumb', '__return_false');		
		add_filter('woocommerce_show_page_title', '__return_false');
		add_filter('woocommerce_breadcrumb_defaults', array($this, 'edit_breadcrumb_args'));
		add_action('trendmag_breadcrumb', 'woocommerce_breadcrumb');

		add_action('woocommerce_before_main_content', array($this,'before_main_content'), 5);
		add_action('woocommerce_after_main_content', array($this,'after_main_content'), 5);
		add_action('woocommerce_sidebar', array($this, 'get_sidebar'), 5);
		add_filter('loop_shop_columns', array($this, 'loop_shop_columns'));
	}

	public function edit_breadcrumb_args(){
    	return array(
            'delimiter'   => '',
            'wrap_before' => '<div class="kopa-breadcrumb" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">',
            'wrap_after'  => '</div>',
            'before'      => '<span itemprop="title">',
            'after'       => '</span>',
            'home'        => __( 'Home', 'trendmag-toolkit'),
        );		
	}

	public function before_main_content(){
		$sb_blog_top    = apply_filters('trendmag_get_sidebar', 'sb_shop_top', 'pos_shop_top');

        ?>
        <div class="wrap-top-page has-parallax" data-stellar-background-ratio="0.5">
                <div class="wrapper">
                    <?php
                        get_template_part('template/module/title');
                        get_template_part('template/module/breadcrumb');
                    ?>
                </div>
                <!-- /.wrapper -->
            </div>
            <!-- /.wrap-top-page -->
        <?php

        if (is_active_sidebar($sb_blog_top)){
            echo '<div class="gray-box">';
                echo '<div class="wrapper">';
                    dynamic_sidebar($sb_blog_top);
                echo '</div>';
            echo '</div>';
        }

        ?>

        <div class="kopa-filter">
            <div class="wrapper">
                <?php do_action('woocommerce_before_shop_loop'); ?>
            </div>
            <!-- /.wrapper -->
        </div>
        <!-- /.kopa-filter -->

        <?php

        printf('
            <div class="gap-60"></div>
                <div class="wrapper">
                    <div class="kopa-row-30">
                        <div class="kopa-col main-col">
                            <div class="widget kopa-match-height kopa-products-list">
                                <div class="widget-content">
            ');
	}

	public function after_main_content(){
        printf('
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ');
	}

	public function loop_shop_columns($product_per_row){
		$product_per_row = 4;
		return $product_per_row;
	}

	public function get_sidebar(){
        $sb_before_footer       = apply_filters('trendmag_get_sidebar', 'sb_shop_before_footer', 'pos_shop_before_footer');
        if (is_active_sidebar($sb_before_footer)){
            dynamic_sidebar($sb_before_footer);
        }
	}

	public function add_layout_product_archive($options){
		$positions = trendmag_get_positions();
		$sidebars  = trendmag_get_sidebars();
		
		$layout = array(
			'title'     => __( 'Product Archive', 'trendmag_toolkit' ),
			'preview'   => TT_DIR . '/assets/images/layouts/shop.png',
			'positions' => array(
                'sb_blog_top',
                'sb_before_footer'
            )
        );

		$options[] = array(
			'title'   => __( 'Product Archive', 'trendmag_toolkit' ),
			'type' 	  => 'title',
			'id' 	  => 'product-archive'
		);

		$options[] = array(
			'title'     =>  __( 'Product Archive',  'trendmag_toolkit' ),
			'type'      => 'layout_manager',
			'id'        => 'product-archive',
			'positions' => $positions,
			'layouts'   => array(
				'product-archive' => $layout,		
			),
			'default' => array(
				'layout_id' => 'product-archive',
				'sidebars'  => array(
					'product-archive' => $sidebars,			
				),
			),
		);		
			
		return $options;
	}

	public function add_layout_product_single($options){
		$positions = trendmag_get_positions();
		$sidebars  = trendmag_get_sidebars();

		$layout = array(
			'title'     => __( 'Product Single', 'trendmag_toolkit' ),
            'preview'   => TT_DIR . '/assets/images/layouts/shop.png',
			'positions' => array(
                'sb_blog_top',
                'sb_before_footer'
            ));


		$options[] = array(
			'title'   => __( 'Product Single', 'trendmag_toolkit' ),
			'type' 	  => 'title',
			'id' 	  => 'product-single'
		);

		$options[] = array(
			'title'     =>  __( 'Product Single',  'trendmag_toolkit' ),
			'type'      => 'layout_manager',
			'id'        => 'product-single',
			'positions' => $positions,
			'layouts'   => array(
				'product-single' => $layout,		
			),
			'default' => array(
				'layout_id' => 'product-single',
				'sidebars'  => array(
					'product-single' => $sidebars,			
				),
			),
		);
			
		return $options;
	}

	public function set_layout_setting_id($setting_id){
		if(is_singular('product')){
			 $setting_id = 'product-single';
		}elseif (is_post_type_archive('product') || is_tax('product_tag')  || is_tax('product_cat')) {
			 $setting_id = 'product-archive';
		}						

		return $setting_id;
	}

	public function get_layout_setting($setting, $setting_id){
		if(empty($setting)){
			if('product-single' == $setting_id){
				$layouts = $this->add_layout_product_single(array());

				if(isset($layouts[1]['default'])){
					$setting = $layouts[1]['default'];
				}
			}elseif('product-archive' == $setting_id){
				$layouts = $this->add_layout_product_archive(array());

				if(isset($layouts[1]['default'])){
					$setting = $layouts[1]['default'];
				}
			}
		}			

		return $setting;
	}

}