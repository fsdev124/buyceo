jQuery(document).ready(function($) {
'use strict';	
var $containerfull = $('.masonry_grid_fullwidth');
$containerfull.imagesLoaded( function() {
	$containerfull.addClass('loaded');
	$containerfull.masonry({
	    itemSelector: '.small_post',   
	});
	$containerfull.find('img.lazyimages').unveil(40, function() {
      $(this).load(function() {
        this.style.opacity = 1;
		$containerfull.masonry({
		    itemSelector: '.small_post',   
		});         
      });
   	});	
});
});