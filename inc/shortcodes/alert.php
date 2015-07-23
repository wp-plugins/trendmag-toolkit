<?php

add_shortcode('trendmag_alert', 'trendmag_toolkit_shortcode_alert');

function trendmag_toolkit_shortcode_alert($atts, $content = null) {
    if ($content) {
        extract(shortcode_atts(array('class' => 'alert alert-info alert-dismissable'), $atts));
        $class = isset($atts['class']) ? $atts['class'] : 'alert alert-info alert-dismissable';
        
		$html = sprintf('<div class="%s" role="alert">', $class);
		$html .= '<button type="button" class="close" data-dismiss="alert" aria-label="' . __('Close', 'trendmag-toolkit') . '"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>';
		$html .= do_shortcode($content);
		$html .= '</div>';

        return apply_filters('trendmag_toolkit_shortcode_alert', $html, $atts, $content);
    }
}