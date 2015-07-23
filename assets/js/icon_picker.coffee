yosaga_lighbox_icons_id = '#yosaga_lighbox_icons';

jQuery(document).ready ($)->
	YT_Icon_Picker.init()

	return

jQuery(document).ajaxSuccess (event, xhr, settings)->
	YT_Icon_Picker.init()
	return

jQuery(window).load ($)->
	
	return

YT_Icon_Picker =	
	init: () ->
		if jQuery('.ysg-icon-picker').length > 0
			jQuery('.ysg-icon-picker').click (event)->
				event.preventDefault()
				btn = jQuery(this)

				if jQuery(yosaga_lighbox_icons_id).length != 1
					jQuery('body').append '<div id="yosaga_lighbox_icons" class="ysg-hide"></div>'
										
					jQuery.ajax
						beforeSend: (jqXHR) ->					
							return
						success: (data, textStatus, jqXHR) ->	
							jQuery(yosaga_lighbox_icons_id).html(data)												
							return
						complete: ()->
							YT_Icon_Picker.open_lighbox(btn)
							return
						url: trendmag_toolkit.ajax.url.get_lighbox_icons
						dataType: "html"
						type: 'GET'
						async: false
						data: 
							action: 'trendmag_toolkit_get_lighbox_icons'
					return
				else	
					YT_Icon_Picker.open_lighbox(btn)				
					return
			return
		

	open_lighbox: (btn)->
		jQuery(yosaga_lighbox_icons_id).dialog
			width: 360
			height: 480
			modal: true			
			title: trendmag_toolkit.i18n.icon_picker
			buttons:
				"OK": ()->
					icon = YT_Icon_Picker.click_ok()
					btn.parent().find('.ysg-icon-picker-value').val icon
					btn.parent().find('.ysg-icon-picker-preview i').attr 'class',icon					
					return
				"cancel": ()->
					jQuery(yosaga_lighbox_icons_id).dialog 'close'		
					return			
		return
	
	click_ok: ()->		
		icon = jQuery(yosaga_lighbox_icons_id).find('.ysg-item.ysg-active i').attr('class')
		jQuery(yosaga_lighbox_icons_id).dialog 'close'
		return icon

	select_a_icon:(event, obj)->
		event.preventDefault()

		obj.parents('.ysg-wrap').find('.ysg-item').removeClass('ysg-active')
		obj.addClass('ysg-active')
			
		return

	filter_icons: (event, obj) ->
		event.preventDefault()

		wrap = obj.parents('.ysg-list-of-icon')
		filter = obj.val()

		if !filter
			wrap.find('.ysg-item').show()
			return false  

		regex = new RegExp(filter, "i")

		wrap.find('.ysg-item i').each (index, element) ->
			if jQuery(this).data('title').search(regex) < 0
                jQuery(this).parent().hide()
            else
                jQuery(this).parent().show()           	
           	return 			           

		return		