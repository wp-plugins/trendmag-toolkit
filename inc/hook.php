<?php

function trendmag_toolkit_meta_box_wrap_start($wrap, $value, $loop_index){
	if(0 == $loop_index){
		$wrap = '<div class="ysg-metabox-wrap ysg-metabox-wrap-first ysg-row">';
	}else{
		$wrap = '<div class="ysg-metabox-wrap ysg-row">';	
	}
	
	if ( $value['title'] ) {
		$wrap .= '<div class="ysg-col-xs-3">';
		$wrap .= esc_html($value['title']);
		$wrap .= '</div>';
		$wrap .= '<div class="ysg-col-xs-9">';
	}else{
		$wrap .= '<div class="ysg-col-xs-12">';
	}

	return $wrap;
}

function trendmag_toolkit_meta_box_wrap_end($wrap, $value, $loop_index){
	$wrap = '';

	if ( $value['desc'] ) {
		$wrap .= '<p class="ysg-help">'. $value['desc'] . '</p>';		
	}

	$wrap .= '</div>';
	$wrap .= '</div>';

	return $wrap;
}

function trendmag_toolkit_register_metabox_post_featured(){

    if ( function_exists( 'kopa_register_metabox' ) ) {
        $post_type = array('post');

        $args = array(
            'id'       => 'trendmag-post-options-metabox',
            'title'    => __('Featured content', 'trendmag-toolkit'),
            'desc'     => '',
            'pages'    => $post_type,
            'context'  => 'normal',
            'priority' => 'low',
            'fields'   => array(
                array(
                    'title' => __('Gallery:', 'trendmag-toolkit'),
                    'type'  => 'gallery',
                    'id'    =>  'trendmag_gallery',
                    'desc'  => __('This option only apply for post-format "Gallery".', 'trendmag-toolkit'),
                ),
                array(
                    'title' => __('Custom:', 'trendmag-toolkit'),
                    'type'  => 'textarea',
                    'id'    => 'trendmag_custom',
                    'desc'  => __('Enter custom content as shortcode or custom HTML, ...', 'trendmag-toolkit'),
                ),
            )
        );

        kopa_register_metabox( $args );

        # FEATURED IMAGE SIZE

        $fields = array();
        $sizes = trendmag_get_image_sizes();
        if ( $sizes ) {
            foreach( $sizes as $image ) {
                if ( isset($image['enable_custom']) && $image['enable_custom'] ) {
                    $fields[] = array(
                        'title'   => $image['widget_title'],
                        'type'    => 'upload',
                        'id'      => $image['slug'],
                        'desc'    => $image['widget_description'],
                        'mimes'   => 'image',
                    );
                }
            }
        }

        $args = array(
            'id'          => 'trendmag_post_feature_imgage_size',
            'title'       => __('Custom featured image size','trendmag-toolkit'),
            'desc'        => '',
            'pages'       => array( 'post' ),
            'context'     => 'normal',
            'priority'    => 'low',
            'fields'      => $fields
        );


        kopa_register_metabox( $args );
    }


}

function trendmag_toolkit_youtube_settings($code){
	if(strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false){
		return preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&autohide=1&showinfo=0&hd=1&rel=0&theme=light&controls=2", $code);		
	}
	
	return $code;
}

function trendmag_toolkit_excerpt_more($more){
	return '..';
}

function trendmag_toolkit_make_video_shortcode_responsive($html){
    if (!empty($html)) {
        $out = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $html);
        $out = preg_replace('/(width|height)="\d*"\s/', "", $out);
    }

    return $out;	
}

/**
 * Add field job for user profile
 * @param $profile_fields
 * @return array
 */
function trendmag_modify_user_profile($profile_fields) {
    $profile_fields['job'] = __('Job', 'trendmag-toolkit');

    return $profile_fields;
}

add_action('wp_head', 'trendmag_set_view_count_for_post');

/**
 * Set view count for post
 * @return int|mixed
 */
function trendmag_set_view_count_for_post() {
    if ( is_single() ) {
        global $post;
        $current_views = get_post_meta($post->ID, 'trendmag_view_count', true);
        if ( !isset($current_views) || !$current_views ) {
            $current_views = 0;
        }
        $new_views = $current_views + 1;
        update_post_meta($post->ID, 'trendmag_view_count', $new_views);
        return $new_views;
    }
}

/**
 * Get view count of post
 * @param $post_id
 * @return int|mixed
 */
function trendmag_get_view_count_for_post($post_id) {
    $current_views = get_post_meta($post_id, 'trendmag_view_count', true);
    if ( !isset($current_views) || !$current_views) {
        $current_views = 0;
    }
    return $current_views;
}

function trendmag_apply_get_header_home_2($header) {
    $header = 'page';
    return $header;
}

function trendmag_toolkit_search_share_via_social() {
    get_template_part('template/module/blog-featured/share');
}
