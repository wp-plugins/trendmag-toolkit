<?php

add_shortcode('trendmag_toggles', 'trendmag_toolkit_shortcode_toggles');
add_shortcode('trendmag_toggle', '__return_false');

function trendmag_toolkit_shortcode_toggles($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));

    $items = trendmag_toolkit_get_shortcode($content, true, array('trendmag_toggle'));

    $output = '';

    if ($items) {        
        $is_first = TRUE;
        
        $output.= '<div class="panel-group toggle">';

        foreach ($items as $item) {
            $child_id = 'toggle-' . wp_generate_password(4, false, false);            
            $title    = $item['atts']['title'];            
            $output   .= '<div class="panel panel-default">';

            if ($is_first) {
                $output .= '<div class="panel-heading active">';
            } else {
                $output .= '<div class="panel-heading">';
            }

            $output .= '<h5 class="panel-title">';
            $output .= sprintf('<a data-toggle="collapse" data-parent=".toggle" href="#%s" class="collapsed">', esc_attr($child_id));
            $output .= sprintf('<span class="tab-title">%s</span>', esc_html($title));
            $output .= sprintf(' <span class="b-collapse">+</span>');
            $output .= '</a>';
            $output .= '</h5>';
            $output .= '</div>';

            if ($is_first) {
                $output.= sprintf('<div id="%s" class="panel-collapse in">', esc_attr($child_id));
            } else {
                $output.= sprintf('<div id="%s" class="panel-collapse collapse">', esc_attr($child_id));
            }
            
            $output   .= '<div class="panel-body"><p>';
            $output   .= do_shortcode($item['content']);
            $output   .= '</p></div>';
            $output   .= '</div>';
            $output   .= '</div>';
            
            $is_first = FALSE;
        }
    }

    $output .= '</div>';

    return apply_filters('trendmag_toolkit_shortcode_toggles', $output, $atts, $content);
}