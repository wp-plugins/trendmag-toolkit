<?php

add_action( 'widgets_init', array('TT_Widget_Contact_Text_Simple', 'register_widget'));

class TT_Widget_Contact_Text_Simple extends Kopa_Widget {

	public $kpb_group = 'contact';
	public $lines = array();

	public static function register_widget(){
		register_widget('TT_Widget_Contact_Text_Simple');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-contact-widget contact-1 trendmag-toolkit-contact-simple';
		$this->widget_description = __( 'Display your infomation.', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_toolkit-contact-text-simple';
		$this->widget_name        = __( '(Trendmag) Contact Simple', 'trendmag-toolkit' );

        $this->settings['address_title'] =array(
            'type'  => 'text',
            'std'   => __('Address', 'trendmag-toolkit'),
            'label' => __( 'Address title:', 'trendmag-toolkit' )
        );

        $this->settings['address'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Address:', 'trendmag-toolkit' )
        );

        $this->settings['telephone_title'] =array(
            'type'  => 'text',
            'std'   => __('Call us', 'trendmag-toolkit'),
            'label' => __( 'Telephone title:', 'trendmag-toolkit' )
        );

        $this->settings['telephone'] =array(
            'type'  => 'text',
            'std'   => '',
            'label' => __( 'Telephone:', 'trendmag-toolkit' )
        );

        $this->settings['email_title'] =array(
            'type'  => 'text',
            'std'   =>  __( 'Email:', 'trendmag-toolkit' ),
            'label' => __( ' title:', 'trendmag-toolkit' )
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

        <div class="contact-box-left kopa-col">
            <div class="inner">
                <?php if ( ! empty($address_title) || ! empty($address) ) : ?>
                    <p>
                        <span class="ct-label"><span class="contact-icon"><i class="fa fa-map-marker"></i></span><?php echo esc_html($address_title); ?></span>
                        <span><?php echo esc_html($address);?></span>
                    </p>
                <?php endif; ?>

                <?php if ( ! empty($telephone_title) || ! empty($telephone) ) : ?>
                <p>
                    <span class="ct-label"><span class="contact-icon"><i class="fa fa-phone"></i></span><?php echo esc_html($telephone_title); ?></span>
                    <span><?php echo esc_html($telephone); ?></span>
                </p>
                <?php endif; ?>

                <?php if ( ! empty($email_title) || ! empty($email) ) : ?>
                <p>
                    <span class="ct-label"><span class="contact-icon"><i class="fa fa-envelope"></i></span><?php echo esc_html($email_title); ?></span>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </p>
                <?php endif; ?>
            </div>
            <!-- /.inner -->
        </div>

		<?php

		$content = ob_get_clean();

		echo $content;

		echo $after_widget;
	}

}