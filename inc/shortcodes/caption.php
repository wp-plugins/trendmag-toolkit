<?php

add_shortcode('trendmag_caption', 'trendmag_toolkit_shortcode_caption');

function trendmag_toolkit_shortcode_caption($atts, $content = null) {
    $output = '';
    
    if($content){
        $output = sprintf('<h4 class="element-title">%s</h4>', $content);
    }

    return apply_filters('trendmag_toolkit_shortcode_caption', $output, $atts, $content);
}
