<?php

function trendmag_toolkit_metabox_field_icon($html, $wrap_start, $wrap_end, $field, $value){
    ob_start();

    echo $wrap_start;        
    ?>  
    <div class="ysg-row">
        <div class="ysg-col-xs-12">
            <a class="ysg-icon-picker" href="#"><?php _e('select icon', 'trendmag-toolkit'); ?></a>
            <input type="hidden"
                name="<?php echo esc_attr($field['id']);?>" 
                id="<?php echo esc_attr($field['id']);?>" 
                value="<?php echo esc_attr($value);?>" 
                autocomplete="off"
                class="ysg-icon-picker-value widefat"/>
            <span class="ysg-icon-picker-preview"><i class="<?php echo esc_attr( $value ); ?>"></i></span>

        </div>
    </div>      
    <?php
    echo $wrap_end;
    $html = ob_get_clean();

    return $html;
}