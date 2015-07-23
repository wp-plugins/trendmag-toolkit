var YT_Gallery, trendmag_toolkit_gallery, trendmag_toolkit_gallery_button;

jQuery(document).ready(function() {
  YT_Gallery.init();
});

jQuery(document).ajaxSuccess(function() {
  YT_Gallery.init();
});

trendmag_toolkit_gallery = '';

trendmag_toolkit_gallery_button = '';

YT_Gallery = {
  init: function() {
    jQuery('.ysg-gallery-box').on('click', '.ysg-gallery-config', function(event) {
      event.preventDefault();
      trendmag_toolkit_gallery_button = jQuery(this);
      if (trendmag_toolkit_gallery) {
        trendmag_toolkit_gallery.open();
        return;
      }
      trendmag_toolkit_gallery = wp.media.frames.trendmag_toolkit_gallery = wp.media({
        title: 'Gallery config',
        button: {
          text: 'Use'
        },
        library: {
          type: 'image'
        },
        multiple: true
      });
      trendmag_toolkit_gallery.on('open', function() {
        var ids, selection;
        ids = trendmag_toolkit_gallery_button.parents('.ysg-gallery-box').find('input.ysg-gallery').val();
        if ('' !== ids) {
          selection = trendmag_toolkit_gallery.state().get('selection');
          ids = ids.split(',');
          jQuery(ids).each(function(index, element) {
            var attachment;
            attachment = wp.media.attachment(element);
            attachment.fetch();
            selection.add(attachment ? [attachment] : []);
          });
        }
      });
      trendmag_toolkit_gallery.on('select', function() {
        var result, selection;
        result = [];
        selection = trendmag_toolkit_gallery.state().get('selection');
        selection.map(function(attachment) {
          attachment = attachment.toJSON();
          return result.push(attachment.id);
        });
        if (result.length > 0) {
          result = result.join(',');
          trendmag_toolkit_gallery_button.parents('.ysg-gallery-box').find('input.ysg-gallery').val(result);
        }
      });
      trendmag_toolkit_gallery.open();
    });
  }
};
