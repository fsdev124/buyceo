jQuery(document).ready(function($) {
	'use strict';
	// Create a jquery plugin that prints the given element.
	jQuery.fn.print = function(){
	    // NOTE: We are trimming the jQuery collection down to the
	    // first element in the collection.
	    if (this.size() > 1){
	        this.eq( 0 ).print();
	        return;
	    } else if (!this.size()){
	        return;
	    }

	    // ASSERT: At this point, we know that the current jQuery
	    // collection (as defined by THIS), contains only one
	    // printable element.

	    // Create a random name for the print frame.
	    var strFrameName = ("printer-" + (new Date()).getTime());

	    // Create an iFrame with the new name.
	    var jFrame = $( "<iframe name='" + strFrameName + "'>" );

	    // Hide the frame (sort of) and attach to the body.
	    jFrame
	        .css( "width", "1px" )
	        .css( "height", "1px" )
	        .css( "position", "absolute" )
	        .css( "left", "-9999px" )
	        .appendTo( $( "body:first" ) )
	    ;

	    // Get a FRAMES reference to the new frame.
	    var objFrame = window.frames[ strFrameName ];

	    // Get a reference to the DOM in the new frame.
	    var objDoc = objFrame.document;

	    // Grab all the style tags and copy to the new
	    // document so that we capture look and feel of
	    // the current document.

	    // Create a temp document DIV to hold the style tags.
	    // This is the only way I could find to get the style
	    // tags into IE.
	    var jStyleDiv = $( "<div>" ).append('<style>body {-webkit-print-color-adjust: exact;}.printcoupon{max-width: 550px;margin: 20px auto; border: 2px dashed #cccccc;}.printcouponheader{background-color: #eeeeee;padding: 15px; margin-bottom:20px}.printcoupontitle{font-size: 20px;font: 22px/24px Georgia;margin-bottom: 8px;text-transform: uppercase;}.printcoupon_wrap{font-weight: bold;padding: 20px;background-color: #e7f3d6; margin: 0 auto 20px auto;}.expired_print_coupon{font-size:12px; color: #999;}.printcouponcentral, .printcouponheader{text-align: center;}.save_proc_woo_print{margin: 0 auto 20px auto;display: inline-block;position: relative;color: #000000;padding-right: 45px;}.countprintsale{font: bold 70px/70px Arial;}.procprintsale{right: 0;font: bold 36px/35px Tahoma;position: absolute;top: 2px;}.wordprintsale{right: 0;font: 20px Georgia;position: absolute;bottom: 9px;}.printcoupon_wrap {font: bold 20px/24px Arial;padding: 20px;background-color: #e7f3d6;margin: 0 30px;}.printcoupondesc{padding: 30px;}.printcoupondesc span{font: 13px/20px Georgia;}.printimage{float: left;width: 120px;margin: 0 25px 15px 0;}.printimage img{max-width:100%; height:auto}.couponprintend{text-align: center;padding: 20px;border-top: 2px dotted #eeeeee;margin: 0 30px;font: italic 12px Arial; clear:both}.couponprintend span{color: #cc0000;}.storeprint{margin-top:10px;}.storeprint a{text-decoration:none}.printcouponimg{text-align:center; margin:20px auto}.printcouponimg img{max-width:100%; height:auto;}</style>');

	    // Write the HTML for the document. In this, we will
	    // write out the HTML of the current element.
	    objDoc.open();
	    objDoc.write( "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">" );
	    objDoc.write( "<html>" );
	    objDoc.write( "<body>" );
	    objDoc.write( "<head>" );
	    objDoc.write( "<title>" );
	    objDoc.write( document.title );
	    objDoc.write( "</title>" );
	    objDoc.write( jStyleDiv.html() );
	    objDoc.write( "</head>" );
	    objDoc.write( this.html() );
	    objDoc.write( "</body>" );
	    objDoc.write( "</html>" );
	    objDoc.close();

	    // Print the document.
	    objFrame.focus();
	    objFrame.print();

	    // Have the frame remove itself in about a minute so that
	    // we don't build up too many of these frames.
	    setTimeout(
	        function(){
	            jFrame.remove();
	        },
	        (60 * 1000)
	    );
	};
	$( 'body' ).on("click", "span.printthecoupon", function(e){
			e.preventDefault();
			var printid = $(this).data('printid');
			$("#printcoupon" + printid ).print();
	});		
});