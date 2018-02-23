jQuery(document).ready(function($) {

	//Compare multigroup functions
	if ($('#re-compare-bar').length > 0) {
		$.post(translation.ajax_url, {
			action: 're_compare_panel'
		}, function (response) {
			//$('#re-compare-icon-fixed').addClass(response.cssactive);
			var pageids = response.pageids;
			var total_comparing_ids = response.total_comparing_ids;
			var pageid;
			var total_comparing_id;

			for (index in pageids) {
				var pageid = pageids[index];
				$('.re-compare-wrap-'+ pageid).html(response.content[pageid]);
				$('.re-compare-tab-' + pageid + ' span').text(response.count[pageid]);
				$('.re-compare-tab-' + pageid).attr('data-comparing', response.comparing[pageid]);			
			}

			for (index in total_comparing_ids){ //Here we ensure to deactivate compare buttons if item is in compare
				var total_comparing_id = total_comparing_ids[index];
				var comparebtn = $('.addcompare-id-' + total_comparing_id);
				if(comparebtn.hasClass('not-incompare')) {
	        		comparebtn.removeClass('not-incompare').addClass('comparing'); 	
	        	}
			}
			
			pageid = $('#re-compare-bar-tabs').children("ul").children("li:first").attr("data-page");
			$('.re-compare-tab-' + pageid).attr('data-comparing', response.comparing[pageid]);

			var  total_count = response.total_count;
			if( '' == total_count ) {
				total_count = 0;
			}
			if (total_count > 0){
				$('#re-compare-icon-fixed').removeClass('rhhidden');
				$('.re-compare-icon-toggle .re-compare-notice').text(total_count);
			}				
			
			var compareurl = $('#re-compare-bar-tabs').children("ul").children("li:first").attr("data-url");
			var comparing = $('#re-compare-bar-tabs').children("ul").children("li:first").attr("data-comparing");
			
			comparing = (comparing) ? '?compareids=' + comparing : '';
			$('.re-compare-destin').attr('data-compareurl', compareurl + comparing); 
			
			$('#re-compare-bar-tabs').children("ul").children("li").click(function(){
				pageid = parseInt($(this).attr("data-page"));
				compareurl = $(this).data("url");
				comparing = $(this).data("comparing");
				comparing = (comparing) ? '?compareids=' + comparing : '';
				$('.re-compare-destin').attr('data-compareurl', compareurl + comparing); 
			});			
		});      
	}

	//compare multigroup button
	$(document).on('click', '.wpsm-button-new-compare', function(e){
	  	var thistoggle = $(this);
	  	var panel = $('#re-compare-bar');       
	  	var compareID = thistoggle.data('addcompare-id');
	  	var alltoggles = $('.addcompare-id-' + compareID); 
	  	alltoggles.addClass('loading');
	  	if(thistoggle.hasClass('not-incompare')) {       
	     	$.post(translation.ajax_url, {
	        	action: 're_add_compare',
	        	compareID: compareID,
	        	perform: 'add'
	     	}, function (response) {   
	        	//panel.addClass('active'); 
	        	alltoggles.removeClass('not-incompare').removeClass('loading');
	        	alltoggles.addClass('comparing'); 
	        	$('#re-compare-icon-fixed').removeClass('rhhidden');
			
	        	$('.re-compare-wrap-' + response.pageid).append(response.content).find(".re-compare-item:last").hide().fadeIn('slow');
	        	$('.re-compare-tab-' + response.pageid+' span').text(response.count);
				$('.re-compare-tab-' + response.pageid).attr('data-comparing', response.comparing);

				var  total_count = $('.re-compare-icon-toggle .re-compare-notice').first().text();
				$('.re-compare-icon-toggle .re-compare-notice').text(parseInt(total_count) + 1);				
			
				var compareurl = $('.re-compare-tab-' + response.pageid).data('url');
				$('.re-compare-destin').attr('data-compareurl', compareurl + '?compareids=' + response.comparing); 

				$('.re-compare-icon-toggle').addClass('proccessed');
				setTimeout(function() {
				   $('.re-compare-icon-toggle').removeClass('proccessed');
				}, 300);				

	     	}); 
	  	} else {
	     	$('.compare-item-' + compareID).css({'opacity': '.17'});         
	     	$.post(translation.ajax_url, {
	        	action: 're_add_compare',
	        	compareID: compareID,
	        	perform: 'remove'
	     	}, function (response) {
	        	alltoggles.addClass('not-incompare');
	        	alltoggles.removeClass('comparing').removeClass('loading');
			
	        	$('.compare-item-' + compareID).remove(); 
	        	$('.re-compare-tab-' + response.pageid + ' span').text(response.count);
				$('.re-compare-tab-' + response.pageid).attr('data-comparing', response.comparing);

				var total_count = $('.re-compare-icon-toggle .re-compare-notice').first().text();
				$('.re-compare-icon-toggle .re-compare-notice').text(parseInt(total_count) - 1);
			
				var compareurl = $('.re-compare-tab-' + response.pageid).data('url'); 
			
	        	if(total_count <= 1) {
	           		panel.removeClass('active');
	           		$('#re-compare-icon-fixed').addClass('rhhidden');
	        	}

	        	$('.re-compare-destin').attr('data-compareurl', compareurl + '?compareids=' + response.comparing); 

				$('.re-compare-icon-toggle').addClass('proccessed');
				setTimeout(function() {
				   $('.re-compare-icon-toggle').removeClass('proccessed');
				}, 300);

	     	});                
	  	} 
	});  

	//Compare multigroup close button
	$('body').on('click', '.re-compare-new-close', function(e){
	  	var block = $(this).parent();
	  	var panel = $('#re-compare-bar');       
	  	var compareID = block.data('compareid');
	  	var alltoggles = $('.addcompare-id-' + compareID);
	  	block.css({'opacity': '.17'});
	  	$.post(translation.ajax_url, {
	     	action: 're_add_compare',
	     	compareID: compareID,
	     	perform: 'remove'    
	  	}, function (response) { 
	     	alltoggles.addClass('not-incompare').removeClass('comparing');           
	     	block.remove(); 
		 
	     	$('.re-compare-tab-' + response.pageid + ' span').text(response.count);
		 	$('.re-compare-tab-' + response.pageid).attr('data-comparing', response.comparing);

			var  total_count = $('.re-compare-icon-toggle .re-compare-notice').first().text();
			$('.re-compare-icon-toggle .re-compare-notice').text(parseInt(total_count) - 1);		 	
		 
			var compareurl = $('.re-compare-tab-' + response.pageid).data('url'); 
			var comparing = $('.re-compare-tab-' + response.pageid).data('comparing');
		 
	    	if(total_count <= 1) {
	        	panel.removeClass('active');
	        	$('#re-compare-icon-fixed').addClass('rhhidden');
	    	}
	    	$('.re-compare-destin').attr('data-compareurl', compareurl + '?compareids=' + response.comparing);          
	  	});   
	}); 

	// Compare multigroup click button
	$( 'body' ).on("click", ".re-compare-destin", function(e){
	  	var $this = $(this);
	  	var $error = 0;
	  
		var check_tab = $( "#re-compare-bar-tabs ul li.current span" );
		if( '0' == check_tab.text() ) {
			$this.after('<p class="re-compare-error">'+ comparechart.item_error_add +'</p>');
			$error = 1;
		} else if( '1' == check_tab.text() ) {
			$this.after('<p class="re-compare-error">'+ comparechart.item_error_comp +'</p>');
			$error = 1;
		}
		setTimeout(function() {
		   	$('p.re-compare-error').remove();
		}, 4500);
	  
	  	var compareurl = $this.attr('data-compareurl'); 
	  	if( compareurl != "" && $error == 0 ){
	     	window.location.href= compareurl;
	  	}
	}); 

	$("#re-compare-bar-tabs").lightTabs();

	//clode the lateral panel
	$('#re-compare-bar').on('click', function(event){
		if( $(event.target).is('#re-compare-bar') || $(event.target).is('.closecomparepanel') ) { 
			$('#re-compare-bar').removeClass('active');
			event.preventDefault();
		}
	});	

	$(document).on('click', '.re-compare-icon-toggle, #re-compare-icon-fixed', function(event){
		event.preventDefault();
		$('#re-compare-bar').addClass('active');
	});	

   
   //Compare close button in chart
   $(document).on('click', '.re-compare-close-in-chart', function(e){
      var block = $(this).closest('.top_rating_item'); 
      $(this).closest('.table_view_charts').find('li').removeClass('row-is-different');      
      var compareID = block.data('compareid');    
      var alltoggles = $('.addcompare-id-' + compareID);  
      block.css({'opacity': '.17'});
      $.post(translation.ajax_url, {
         action: 're_add_compare',
         compareID: compareID,
         perform: 'remove'    
      }, function (response) {           
         block.remove();
         table_charts();
	     alltoggles.addClass('not-incompare');
	     alltoggles.removeClass('comparing').removeClass('loading');  
		$('.compare-item-' + compareID).remove(); 
		$('.re-compare-tab-' + response.pageid + ' span').text(response.count);
		$('.re-compare-tab-' + response.pageid).attr('data-comparing', response.comparing);

		var total_count = $('.re-compare-icon-toggle .re-compare-notice').first().text();
		$('.re-compare-icon-toggle .re-compare-notice').text(parseInt(total_count) - 1);

		var compareurl = $('.re-compare-tab-' + response.pageid).data('url'); 

		if($('#re-compare-bar-tabs div ').length == 0) {
				panel.removeClass('active');
		} else { 
			$('.re-compare-destin').attr('data-compareurl', compareurl + '?compareids=' + response.comparing);          
		}

		$('.re-compare-icon-toggle').addClass('proccessed');
		setTimeout(function() {
		   $('.re-compare-icon-toggle').removeClass('proccessed');
		}, 300);	            
         if (typeof (history.pushState) != "undefined") {
            var obj = { Page: 'Compare items', Url: window.location.pathname + '?compareids=' + response.comparing };
            history.pushState(obj, obj.Page, obj.Url);
         } else {
            window.location.href= window.location.pathname + '?compareids=' + response.comparing;
         }                                    
      }); 
                 
   });	

});

(function($){				
	jQuery.fn.lightTabs = function(options){
		var createTabs = function(){
			tabs = this;
			i = 0;
			showPage = function(i){
				$(tabs).children("div").children("div").hide();
				$(tabs).children("div").children("div").eq(i).show();
				$(tabs).children("ul").children("li").removeClass("current");
				$(tabs).children("ul").children("li").eq(i).addClass("current");
			}	
			showPage(0);
			$(tabs).children("ul").children("li").each(function(index, element){
				$(element).attr("data-id", i);
				i++;                        
			});
			$(tabs).children("ul").children("li").click(function(){
				showPage(parseInt($(this).attr("data-id")));
			});				
		};		
		return this.each(createTabs);
	};	
})(jQuery);