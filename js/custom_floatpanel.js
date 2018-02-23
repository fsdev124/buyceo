jQuery(document).ready(function($) {
'use strict';	

	// Cache selectors
	var lastId = '';
	var topMenu = $(".float-panel-woo-links");
	var topMenuHeight = $("#float-panel-woo-area").outerHeight()+15;
	// All list items
	var menuItems = topMenu.find("a");
	// Anchors corresponding to menu items
	var scrollItems = menuItems.map(function(){
		var elem = $(this).attr("href");
	  	var item = $(elem);
	  if (item.length) { return item; }
	});

	// Bind click handler to menu items
	// so we can get a fancy scroll animation
	menuItems.click(function(e){
		var href = $(this).attr("href"),
	  	offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
		$('html, body').stop().animate({ 
	  		scrollTop: offsetTop
		}, 500);
		e.preventDefault();
	});

	$('#contents-section-woo-area .contents-woo-area a').click(function(e){
		var href = $(this).attr("href"),
	  	offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
		$('html, body').stop().animate({ 
	  		scrollTop: offsetTop
		}, 500);
		e.preventDefault();
	});

	// Bind to scroll
	$(window).scroll(function(){
		// Get container scroll position
		var fromTop = $(this).scrollTop()+topMenuHeight;

		// Get id of current scroll item
		var cur = scrollItems.map(function(){
	 		if ($(this).offset().top < fromTop)
	   		return this;
		});
		// Get the id of the current element
		cur = cur[cur.length-1];
		var id = cur && cur.length ? cur[0].id : "";

		if (lastId !== id) {
	   		lastId = id;
	   		// Set/remove current class
	   		menuItems
	     	.parent().removeClass("current")
	     	.end().filter("[href='#"+id+"']").parent().addClass("current");
		}                   
	});


	$(window).scroll(function() {
		var theight = $('#contents-section-woo-area').offset();
		if ($(this).scrollTop()>theight.top) {
			$('#float-panel-woo-area').addClass('floating');
			$('.float_p_trigger').addClass('floatactive');
		}
		else {
			$('#float-panel-woo-area').removeClass('floating');
			$('.float_p_trigger').removeClass('floatactive');
		}
	});
   		
});