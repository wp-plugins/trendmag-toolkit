<?php

add_action( 'widgets_init', array('TT_Widget_Newsletter_Feedburner', 'register_widget'));

class TT_Widget_Newsletter_Feedburner extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget(){
		register_widget('TT_Widget_Newsletter_Feedburner');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-newsletter-widget';
		$this->widget_description = __( 'Display a newsletter form with feedburner service.', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_toolkit-newsletter-widget';
		$this->widget_name        = __( '(Trendmag) Newsletter Feedburner', 'trendmag-toolkit' );
		
		$this->settings['title'] = array(
			'type'  => 'text',				
			'std'   => __('Newsletter', 'trendmag-toolkit'),
			'label' => __( 'Title:', 'trendmag-toolkit' ),
		);

        $this->settings['button_text'] = array(
            'type'  => 'text',
            'std'   => __('Your Email', 'trendmag-toolkit'),
            'label' => __( 'Button text:', 'trendmag-toolkit' ),
        );

		$this->settings['uri'] = array(
			'type'  => 'text',				
			'std'   => 'KopaTheme',
			'label' => __( 'Feedburner URI:', 'trendmag-toolkit' ),
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {	

		ob_start();

		extract( $args );

		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		echo $before_widget;

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);		
		
		if($uri){ ?>

        <div class="widget-content">
            <div class="inner">

                <form class="newsletter-form clearfix"
                      action="http://feedburner.google.com/fb/a/mailverify"
                      method="post" target="popupwindow"
                      onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr($uri); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');
                                      return true;">

                    <?php if ( ! empty($title) ) : ?>
                        <span class="kopa-label"><?php echo esc_html($title); ?></span>
                    <?php endif; ?>

                    <?php if ( ! empty($button_text) ) : ?>
                        <input type="text" placeholder="<?php echo esc_html($button_text); ?>">
                    <?php endif; ?>

                    <input type="submit" name="submit" class="submit" /><i class="kopa-icon arrow-right-1"></i>

                    <input type="hidden" value="<?php echo esc_attr($uri); ?>" name="uri"/>
                    <input type="hidden" name="loc" value="en_US"/>

                </form>
            </div>
        </div>
        <?php }

		$content = ob_get_clean();

		echo $content;

		echo $after_widget;
	}

}