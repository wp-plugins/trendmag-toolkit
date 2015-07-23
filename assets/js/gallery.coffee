jQuery(document).ready ->	
	YT_Gallery.init()
	return	

jQuery(document).ajaxSuccess ->	
	YT_Gallery.init()	
	return

trendmag_toolkit_gallery        = ''
trendmag_toolkit_gallery_button = ''

YT_Gallery =
	init: () ->
		jQuery('.ysg-gallery-box').on 'click', '.ysg-gallery-config', (event)->
			event.preventDefault()

			trendmag_toolkit_gallery_button = jQuery this

			if trendmag_toolkit_gallery
	            trendmag_toolkit_gallery.open()
	            return
	            
			trendmag_toolkit_gallery = wp.media.frames.trendmag_toolkit_gallery = wp.media
	            title: 'Gallery config'
	            button:
	            	text: 'Use'
	            library:
	            	type: 'image'            	
	            multiple: true
	        
			trendmag_toolkit_gallery.on 'open', () ->
				ids = trendmag_toolkit_gallery_button.parents('.ysg-gallery-box').find('input.ysg-gallery').val()
				if '' != ids
					selection = trendmag_toolkit_gallery.state().get 'selection'
					ids       = ids.split ','				

					jQuery(ids).each (index, element) ->
						attachment = wp.media.attachment element
						attachment.fetch()
						selection.add  if attachment then [attachment] else []
						return 

				return

			trendmag_toolkit_gallery.on 'select', ()->
	            result = []
	            selection = trendmag_toolkit_gallery.state().get 'selection'
	            selection.map (attachment) ->
	                attachment = attachment.toJSON()
	                result.push attachment.id	                
	            
	            if result.length > 0
	                result = result.join (',')
	                trendmag_toolkit_gallery_button.parents('.ysg-gallery-box').find('input.ysg-gallery').val result
	            return

			trendmag_toolkit_gallery.open()

			return

		return