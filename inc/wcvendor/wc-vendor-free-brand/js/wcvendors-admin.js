(function( $ ) {
	'use strict';

	if ( $( '.wcv-file-uploader_pv_shop_banner_id' ).find('img').length > 0 ){
		$('#_wcv_add_pv_shop_banner_id').hide(); 
	} else { 
		$('#_wcv_remove_pv_shop_banner_id').hide(); 
	}

	if ( $( '.wcv-file-uploader_pv_shop_icon_id' ).find('img').length > 0 ){ 
		$('#_wcv_add_pv_shop_icon_id').hide(); 
	} else { 
		$('#_wcv_remove_pv_shop_icon_id').hide(); 
	}

	// Handle Add banner
	$('#_wcv_add_pv_shop_banner_id').on( 'click', function(e) { 
		e.preventDefault(); 
		file_uploader( '_pv_shop_banner_id' ); 
		return false; 
	}); 

	$('#_wcv_remove_pv_shop_banner_id').on('click', function(e) { 
		e.preventDefault(); 
		// reset the data so that it can be removed and saved. 
		var upload_notice = $('#_pv_shop_banner_id').data('upload_notice'); 
		$( '.wcv-file-uploader_pv_shop_banner_id' ).html(''); 
		$( '.wcv-file-uploader_pv_shop_banner_id' ).append( upload_notice ); 
		$( '#_pv_shop_banner_id').val(''); 
		$( '#_wcv_add_pv_shop_banner_id').show(); 
		$( '#_wcv_remove_pv_shop_banner_id').hide(); 
	});

	// Handle Add icon
	$('#_wcv_add_pv_shop_icon_id').on( 'click', function(e) { 
		e.preventDefault(); 
		file_uploader( '_pv_shop_icon_id' ); 
		return false; 
	}); 

	$('#_wcv_remove_pv_shop_icon_id').on('click', function(e) { 
		e.preventDefault(); 
		// reset the data so that it can be removed and saved. 
		var upload_notice = $('#_pv_shop_icon_id' ).data('upload_notice'); 
		$( '.wcv-file-uploader_pv_shop_icon_id' ).html(''); 
		$( '.wcv-file-uploader_pv_shop_icon_id' ).append( upload_notice ); 
		$( '#_pv_shop_icon_id' ).val(''); 
		$( '#_wcv_add_pv_shop_icon_id' ).show(); 
		$( '#_wcv_remove_pv_shop_icon_id' ).hide(); 
	});


	function file_uploader( id )
	{

		var media_uploader, json, attachment_image_url;

		if ( undefined !== media_uploader ) { 
			media_uploader.open(); 
			return; 
		}

	    media_uploader = wp.media({
      		title: $( '#' + id ).data('window_title'), 
      		button: {
        		text: $( '#' + id ).data('save_button'), 
      		},
      		multiple: false  // Set to true to allow multiple files to be selected
    	});

	    media_uploader.on( 'select' , function(){
	    	json = media_uploader.state().get('selection').first().toJSON(); 

	    	if ( 0 > $.trim( json.url.length ) ) {
		        return;
		    }

		    attachment_image_url = json.sizes.thumbnail ? json.sizes.thumbnail.url : json.url;

		    $( '.wcv-file-uploader' + id )
		    	.html( '<img src="'+ attachment_image_url + '" alt="' + json.caption + '" title="' + json.title +'" style="max-width: 100%;" />' ); 
		    
		    $('#' + id ).val( json.id ); 

			$('#_wcv_add' + id ).hide(); 
			$('#_wcv_remove' + id ).show(); 

	    });

	    media_uploader.open();
	}

})( jQuery );
