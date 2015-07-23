<?php

add_action( 'widgets_init', array('TT_Widget_Social_Links', 'register_widget'));

class TT_Widget_Social_Links extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget(){
		register_widget('TT_Widget_Social_Links');
	}

	public function __construct() {
		$this->widget_cssclass    = 'trendmag_toolkit-social-links top-social-wrap';
		$this->widget_description = __( 'Display your social links.', 'trendmag-toolkit' );
		$this->widget_id          = 'trendmag_toolkit-social-links';
		$this->widget_name        = __( '(Trendmag) Social Links', 'trendmag-toolkit' );
		
		$this->settings 		  = array(
            'title' => array(
                'type'  => 'text',
                'std'   => __('Follow me', 'trendmag-toolkit'),
                'label' => __('Title:', 'trendmag-toolkit')
            ),
            'title_responsive' => array(
                'type'  => 'text',
                'std'   => __('Follow', 'trendmag-toolkit'),
                'label' => __('Title responsive:', 'trendmag-toolkit')
            ),
			'number_of_socials'  => array(
				'type'  => 'number',
				'std'   => 0,					
				'label' => __('Number of social links:', 'trendmag-toolkit')
				),
			);

		parent::__construct();
	}

	public function widget( $args, $instance ) {

		ob_start();

		extract( $args );

		$this->_edit_setting_fields($instance);

		$instance = wp_parse_args((array) $instance, $this->get_default_instance());

		extract( $instance );

		echo $before_widget;

		$number_of_socials = (int) $number_of_socials;

		if($number_of_socials):
		?>

        <a href="#" class="toggle-social"><?php echo esc_html($title_responsive); ?></a>
        <div class="top-social">
            <span><?php echo esc_html($title); ?></span>
            <ul class="rs-ul">
                <?php
                for($i=1; $i<=$number_of_socials; $i++){
                    $slug  = "social_{$i}";
                    $icon  = $instance[$slug]['icon'];
                    $text  = $instance[$slug]['text'];
                    $url   = $instance[$slug]['url'];
                    if ( ! empty($url) ) {
                        printf('<li><a href="%s" target="_blank" title="%s" rel="nofollow"><i class="%s"></i></a></li>', esc_url($url), esc_attr($text), esc_attr($icon));
                    }
                }
                ?>
            </ul>
        </div>
		<?php
		endif;

		$content = ob_get_clean();

		echo $content;

		echo $after_widget;
	}

	private function _edit_setting_fields($instance){		
		if(isset($instance['number_of_socials'])){
			$number_of_socials = (int) $instance['number_of_socials'];
			if($number_of_socials){
				for($i=1; $i<=$number_of_socials; $i++){
					$slug  = "social_{$i}";
					$title = "#{$i}";
					$this->settings[$slug] = array(
						'type'  => 'link_icon',
						'label' => $title,
						'std'   => array(
							'icon' => '',
							'text' => '',
							'url'  => '',
							));
				}
			}
		}
	}

	function update( $new_instance, $old_instance ) {
		$this->_edit_setting_fields($new_instance);
		return parent::update($new_instance, $old_instance);		
	}

	function form( $instance ){
		$this->_edit_setting_fields($instance);
		parent::form( $instance );
	}
}