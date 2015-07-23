<?php

add_shortcode('trendmag_row', 'trendmag_toolkit_shortcode_row');
add_shortcode('trendmag_col', '__return_false');

function trendmag_toolkit_shortcode_row($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));

    $items = trendmag_toolkit_get_shortcode($content, true, array('trendmag_col'));
    $panels = array();

    if ($items) {
        foreach ($items as $item) {
            $panels[] = sprintf('<div class="col-sm-%s">%s</div>', $item['atts']['size'], do_shortcode($item['content']));
        }
    }

    $output = '<div class="row clearfix">';
    $output.= implode('', $panels);
    $output.= '</div>';

    return apply_filters('trendmag_toolkit_shortcode_row', $output, $atts, $content);
}