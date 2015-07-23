<?php

function trendmag_toolkit_metabox_field_gallery($html, $wrap_start, $wrap_end, $field, $value){
    ob_start();

    echo $wrap_start;        
    ?>  
    <div class="ysg-gallery-box">
        <input 
        class="medium-text ysg-gallery" 
        type="text" 
        name="<?php echo esc_attr($field['id']);?>" 
        id="<?php echo esc_attr($field['id']);?>" 
        value="<?php echo esc_attr($value);?>"         
        autocomplete="off">

        <a href="#" class="ysg-gallery-config button button-secondary">
            <?php _e('Config', 'trendmag-toolkit'); ?>
        </a>
    </div>
    <?php
    echo $wrap_end;
    $html = ob_get_clean();

    return $html;
}