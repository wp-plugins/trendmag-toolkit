<?php

add_action( 'widgets_init', array('TT_Widget_Contact_Text', 'register_widget'));

class TT_Widget_Contact_Text extends Kopa_Widget {

	public $kpb_group = 'contact';
	public $lines = array();

	public static function register_widget(){
		register_widget('TT_Widget_Contact_Text');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-contact-widget contact-1';
		$this->widget_description = __( 'Display your organization information on footer.', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_toolkit-contact-text';
		$this->widget_name        = __( '(Trendmag) Contact', 'trendmag-toolkit' );
		
		$this->settings['name'] =array(
			'type'  => 'text',				
			'std'   => '',
			'label' => __( 'Name:', 'trendmag-toolkit' )
		);

        $this->settings['streetAddress'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Street Address:', 'trendmag-toolkit' )
        );

        $this->settings['addressLocality'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Address Locality:', 'trendmag-toolkit' )
        );

        $this->settings['postalCode'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Postal Code:', 'trendmag-toolkit' )
        );

        $this->settings['telephone'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Telephone:', 'trendmag-toolkit' )
        );

        $this->settings['email'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Email:', 'trendmag-toolkit' )
        );

        parent::__construct();
	}

	public function widget( $args, $instance ) {	

		ob_start();

		extract( $args );

		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		echo $before_widget;

		?>

            <div class="widget-content" itemtype="http://schema.org/Organization" itemscope="">
                <?php if ( ! empty($name) || ! empty($streetAddress) || ! empty($addressLocality) || ! empty($postalCode) ) : ?>
                    <p>
                        <span class="contact-icon"><i class="fa fa-map-marker"></i></span>
                        <span class="contact-info">
                            <?php if ( ! empty($name) ) : ?>
                                <span itemprop="name"><?php echo esc_html($name); ?></span>,
                            <?php endif; ?>

                            <?php if ( ! empty($streetAddress) || ! empty($addressLocality) || ! empty($postalCode) ) : ?>
                                <span itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
                                    <?php if ( ! empty($streetAddress) ) : ?>
                                        <span itemprop="streetAddress"> <?php echo esc_html($streetAddress); ?> </span>,
                                    <?php endif; ?>

                                    <?php if ( ! empty($addressLocality) ) : ?>
                                        <span itemprop="addressLocality"> <?php echo esc_html($addressLocality); ?></span>,
                                    <?php endif; ?>

                                    <?php if ( ! empty($postalCode) ) : ?>
                                        <span itemprop="postalCode"><?php echo esc_html($postalCode); ?> </span>
                                    <?php endif; ?>

                                </span>
                            <?php endif; ?>
                        </span>
                    </p>
                <?php endif; ?>

                <?php if ( ! empty($telephone) ) : ?>
                    <p>
                        <span class="contact-icon"><i class="fa fa-phone"></i></span>
                        <span class="contact-info">
                            <span itemprop="telephone"><?php echo esc_html($telephone); ?></span>
                        </span>
                    </p>
                <?php endif; ?>

                <?php if ( ! empty($email) ) : ?>
                    <p>
                        <span class="contact-icon"><i class="fa fa-envelope-o"></i></span>
                        <span class="contact-info">
                            <span itemprop="email"><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span>
                        </span>
                    </p>
                <?php endif; ?>
            </div>

		<?php

		$content = ob_get_clean();

		echo $content;

		echo $after_widget;
	}

}