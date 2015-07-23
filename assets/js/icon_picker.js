var YT_Icon_Picker, yosaga_lighbox_icons_id;

yosaga_lighbox_icons_id = '#yosaga_lighbox_icons';

jQuery(document).ready(function($) {
  YT_Icon_Picker.init();
});

jQuery(document).ajaxSuccess(function(event, xhr, settings) {
  YT_Icon_Picker.init();
});

jQuery(window).load(function($) {});

YT_Icon_Picker = {
  init: function() {
    if (jQuery('.ysg-icon-picker-select').length > 0) {
        jQuery('.ysg-icon-picker-select').change(function(event){
            var btn = jQuery(this);
            var icon = btn.val();
            console.log(icon);
            btn.parent().find('.ysg-icon-picker-preview i').attr('class', icon);
        });
    }
    if (jQuery('.ysg-icon-picker').length > 0) {
      jQuery('.ysg-icon-picker').click(function(event) {
        var btn;
        event.preventDefault();
        btn = jQuery(this);
        if (jQuery(yosaga_lighbox_icons_id).length !== 1) {
          jQuery('body').append('<div id="yosaga_lighbox_icons" class="ysg-hide"></div>');
          jQuery.ajax({
            beforeSend: function(jqXHR) {},
            success: function(data, textStatus, jqXHR) {
              jQuery(yosaga_lighbox_icons_id).html(data);
            },
            complete: function() {
              YT_Icon_Picker.open_lighbox(btn);
            },
            url: trendmag_toolkit.ajax.url.get_lighbox_icons,
            dataType: "html",
            type: 'GET',
            async: false,
            data: {
              action: 'trendmag_toolkit_get_lighbox_icons'
            }
          });
        } else {
          YT_Icon_Picker.open_lighbox(btn);
        }
      });
    }
  },
  open_lighbox: function(btn) {
    jQuery(yosaga_lighbox_icons_id).dialog({
      width: 360,
      height: 480,
      modal: true,
      title: trendmag_toolkit.i18n.icon_picker,
      buttons: {
        "OK": function() {
          var icon;
          icon = YT_Icon_Picker.click_ok();
          btn.parent().find('.ysg-icon-picker-value').val(icon);
          btn.parent().find('.ysg-icon-picker-preview i').attr('class', icon);
        },
        "cancel": function() {
          jQuery(yosaga_lighbox_icons_id).dialog('close');
        }
      }
    });
  },
  click_ok: function() {
    var icon;
    icon = jQuery(yosaga_lighbox_icons_id).find('.ysg-item.ysg-active i').attr('class');
    jQuery(yosaga_lighbox_icons_id).dialog('close');
    return icon;
  },
  select_a_icon: function(event, obj) {
    event.preventDefault();
    obj.parents('.ysg-wrap').find('.ysg-item').removeClass('ysg-active');
    obj.addClass('ysg-active');
  },
  filter_icons: function(event, obj) {
    var filter, regex, wrap;
    event.preventDefault();
    wrap = obj.parents('.ysg-list-of-icon');
    filter = obj.val();
    if (!filter) {
      wrap.find('.ysg-item').show();
      return false;
    }
    regex = new RegExp(filter, "i");
    wrap.find('.ysg-item i').each(function(index, element) {
      if (jQuery(this).data('title').search(regex) < 0) {
        jQuery(this).parent().hide();
      } else {
        jQuery(this).parent().show();
      }
    });
  }
};
