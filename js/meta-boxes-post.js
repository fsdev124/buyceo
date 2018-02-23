jQuery( function( $ ) {
	
	if ($('#rh_post_images_container').length > 0) { 
		// Product gallery file uploads.
		var post_gallery_frame;
		var $image_gallery_ids = $( '#rh_post_image_gallery' );
		var $post_images    = $( '#rh_post_images_container' ).find( 'ul.rh_post_images' );
		
		$( '.rh_add_post_images' ).on( 'click', 'a', function( event ) {
			var $el = $( this );

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( post_gallery_frame ) {
				post_gallery_frame.open();
				return;
			}

			// Create the media frame.
			post_gallery_frame = wp.media.frames.post_gallery = wp.media({
				// Set the title of the modal.
				title: $el.data( 'choose' ),
				button: {
					text: $el.data( 'update' )
				},
				states: [
					new wp.media.controller.Library({
						title: $el.data( 'choose' ),
						filterable: 'all',
						multiple: true
					})
				]
			});

			// When an image is selected, run a callback.
			post_gallery_frame.on( 'select', function() {
				var selection = post_gallery_frame.state().get( 'selection' );
				var attachment_ids = $image_gallery_ids.val();

				selection.map( function( attachment ) {
					attachment = attachment.toJSON();

					if ( attachment.id ) {
						attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
						var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

						$post_images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
					}
				});

				$image_gallery_ids.val( attachment_ids );
			});

			// Finally, open the modal.
			post_gallery_frame.open();
		});

		// Image ordering.
		$post_images.sortable({
			items: 'li.image',
			cursor: 'move',
			scrollSensitivity: 40,
			forcePlaceholderSize: true,
			forceHelperSize: false,
			helper: 'clone',
			opacity: 0.65,
			placeholder: 'rh-metabox-sortable-placeholder',
			start: function( event, ui ) {
				ui.item.css( 'background-color', '#f6f6f6' );
			},
			stop: function( event, ui ) {
				ui.item.removeAttr( 'style' );
			},
			update: function() {
				var attachment_ids = '';

				$( '#rh_post_images_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
					var attachment_id = $( this ).attr( 'data-attachment_id' );
					attachment_ids = attachment_ids + attachment_id + ',';
				});

				$image_gallery_ids.val( attachment_ids );
			}
		});

		// Remove images.
		$( '#rh_post_images_container' ).on( 'click', 'a.delete', function() {
			$( this ).closest( 'li.image' ).remove();

			var attachment_ids = '';

			$( '#rh_post_images_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
				var attachment_id = $( this ).attr( 'data-attachment_id' );
				attachment_ids = attachment_ids + attachment_id + ',';
			});

			$image_gallery_ids.val( attachment_ids );

			// Remove any lingering tooltips.
			$( '#tiptip_holder' ).removeAttr( 'style' );
			$( '#tiptip_arrow' ).removeAttr( 'style' );

			return false;
		});

	}
});