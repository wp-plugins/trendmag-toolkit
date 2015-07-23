<?php

function trendmag_toolkit_widget_field_link_icon($html, $wrap_start, $wrap_end, $field, $value){
	ob_start();

	echo $wrap_start;
		
	$value = wp_parse_args((array) $value, array('icon'=> NULL, 'text' => NULL, 'url' => NULL));
	extract($value );	
	?>	
	<label for="<?php echo esc_attr($field['id']); ?>"><?php echo esc_html( $field['label'] ); ?></label>
	<br/>
	<div class="ysg-row">

		<div class="ysg-col-xs-12">
            <?php
                $t_icons = trendmag_toolkit_get_list_of_icon();
            ?>
            <p class="ysg-block ysg-block-first">
                <select id="<?php echo esc_attr($field['id']); ?>" name="<?php printf("%s[icon]", esc_attr($field['name']));?>" class="ysg-icon-picker-select">
                    <?php
                    foreach( $t_icons as $k => $v ){ ?>
                        <option value="<?php echo esc_attr($k); ?>" <?php selected( $k, $icon ); ?>><?php echo esc_attr($v); ?></option>
                        <?php }
                    ?>
                </select>
                <span class="ysg-icon-picker-preview"><i class="<?php echo esc_attr( $icon ); ?>"></i></span>
            </p>

			<p class="ysg-block ysg-block-first">
				<input class="widefat" 
				id="<?php echo esc_attr($field['id']); ?>"
				name="<?php printf("%s[text]", esc_attr($field['name']));?>"
				type="text"
				placeholder="<?php _e('Link text', 'trendmag-toolkit'); ?>"
				autocomplete="off"
				value="<?php echo esc_attr( $text ); ?>" />		
			</p>
			<p class="ysg-block">
				<input class="widefat" 
				id="<?php echo esc_attr($field['id']); ?>"
				name="<?php printf("%s[url]", $field['name']);?>" 
				type="url" 
				placeholder="<?php _e('Link URL', 'trendmag-toolkit'); ?>"
				autocomplete="off"
				value="<?php echo esc_url( $url ); ?>" />	
			</p>
		</div>
	</div>		
	<?php

	echo $wrap_end;

	$html = ob_get_clean();

	return $html;
}