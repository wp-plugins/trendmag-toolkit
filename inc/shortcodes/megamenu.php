<?php

add_shortcode('trendmag_megamenu', 'trendmag_toolkit_shortcode_megamenu');

function trendmag_toolkit_shortcode_megamenu($atts, $content = null) {
    extract(shortcode_atts(array('id' => 0), $atts));
    $output = '';

    if (isset($atts['id']) && (int) $atts['id'] > 0) {
        $post_id = $atts['id'];
        $sidebar = get_post_meta($post_id, 'trendmag-toolkit-sidebar', true);
        ob_start();
        echo '<div class="megamenu sf-mega">';
        if ('sidebar_hide' != $sidebar && is_active_sidebar($sidebar)) {
            dynamic_sidebar($sidebar);
        }
        echo '</div>';
        $output .= ob_get_contents();
        ob_end_clean();
    }

    return apply_filters('trendmag_toolkit_shortcode_megamenu', $output, $atts, $content);
}
