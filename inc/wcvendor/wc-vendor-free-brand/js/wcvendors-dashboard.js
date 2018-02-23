jQuery( function( $ ){	

	// Iterate over all instances of the uploader on the page 
	$('.wcv-img-id').each( function () {
	    
	    var id = this.id; 

	    // Handle Add banner
		$('.wcv-file-uploader-add' + id ).on( 'click', function(e) { 
			e.preventDefault(); 
			file_uploader( id ); 
			return false; 
		}); 

		$('.wcv-file-uploader-delete' + id ).on('click', function(e) { 
			e.preventDefault(); 
			// reset the data so that it can be removed and saved. 
			$( '.wcv-file-uploader' + id ).html(''); 
			$( 'input[id=' + id + ']').val(''); 
			$('.wcv-file-uploader-delete' + id ).addClass('rhhidden'); 
			$('.wcv-file-uploader-add' + id ).removeClass('rhhidden'); 
		});

	});

	function file_uploader( id )
	{

		var media_uploader, json;

		if (undefined !== media_uploader ) { 
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
		    	.append( '<img src="'+ attachment_image_url + '" alt="' + json.caption + '" title="' + json.title +'" style="max-width: 100%;" />' ); 
		    
		    $('#' + id ).val( json.id ); 

		    $('.wcv-file-uploader-add' + id ).addClass('rhhidden'); 
		    $('.wcv-file-uploader-delete' + id ).removeClass('rhhidden'); 

	    });

	    media_uploader.open();
	}

});

	