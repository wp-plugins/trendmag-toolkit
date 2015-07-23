<?php

function trendmag_toolkit_get_lighbox_icons(){
	check_ajax_referer('$P$By.WhgC.styMXTVXajsHThQZgrlsVm1', 'security');

	$icons = trendmag_toolkit_get_list_of_icon();
	if($icons):
		?>
		<div class="ysg-list-of-icon">		
			<div class="ysg-row">				
				<input type="text" 
				value="" 
				class="ysg-textbox"
				placeholder="<?php _e('Search...', 'trendmag-toolkit'); ?>"
				onkeyup="YT_Icon_Picker.filter_icons(event, jQuery(this));">				
			</div>	
			<div class="ysg-row ysg-wrap">
			<?php foreach($icons as $key => $val): ?>
				<span class="ysg-item ysg-col-xs-2" onclick="YT_Icon_Picker.select_a_icon(event, jQuery(this));">
					<i class="<?php echo esc_attr($key); ?>" data-title="<?php echo esc_attr($val); ?>"></i>
				</span>
			<?php endforeach;?>
			</div>	
		</div>
		<?php	
	endif;
	exit();
}
