jQuery(document).ready(function($) {
	'use strict';
    var $containerfull = $('.masonry_grid_fullwidth');
    $containerfull.infinitescroll({
        navSelector: ".more_post",
        nextSelector: ".more_post a",
        itemSelector: ".small_post",
		loading: {
			finishedMsg: '<em>' + js_local_vars.fin + '</em>',
			msgText: '',
			img: js_local_vars.theme_url + '/images/preload.gif',
		},        
    },

    function (newElements) {
        var $newElems = $(newElements).css({
            opacity: 0
        });
        $newElems.imagesLoaded(function () {
            $newElems.animate({
                opacity: 1
            });
            $containerfull.masonry('appended', $newElems);
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

    $containerfull.imagesLoaded(function () {
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