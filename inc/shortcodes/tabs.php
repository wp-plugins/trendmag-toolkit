<?php

add_shortcode('trendmag_tabs', 'trendmag_toolkit_shortcode_tabs');
add_shortcode('trendmag_tab', '__return_false');

function trendmag_toolkit_shortcode_tabs($atts, $content = null) {
    extract(shortcode_atts(array('class' => 'kopa-tab-widget'), $atts));

    $items  = trendmag_toolkit_get_shortcode($content, true, array('trendmag_tab'));
    $navs   = array();
    $panels = array();

    if ($items) {
        $active = 'active';
        foreach ($items as $item) {
            $title    = $item['atts']['title'];
            $item_id  = 'tab-' . wp_generate_password(4, false, false);
            $navs[]   = sprintf('<li class="%s"><a href="#%s" data-toggle="tab">%s</a></li>', esc_attr($active), esc_attr($item_id), do_shortcode($title));
            $panels[] = sprintf('<div class="tab-pane %s" id="%s">%s</div>', esc_attr($active), esc_attr($item_id), do_shortcode($item['content']));
            $active   = '';
        }
    }

    $output = '<div class="kopa-tabs">';
    
    $output .= '<ul class="nav nav-tabs">';
    $output .= implode('', $navs);
    $output .= '</ul>';
    
    $output .= '<div class="tab-content">';
    $output .= implode('', $panels);
    $output .= '</div>';
    
    $output .= '</div>';

    return apply_filters('trendmag_toolkit_shortcode_tabs', $output, $atts, $content);
}