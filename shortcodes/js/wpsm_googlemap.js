/*  */
jQuery(function($){
	
	'use strict';	
	$(document).ready(function(){
		
		if($('.wpsm_spec_tab_wrapcont .wpsm_gmap_loc').length > 0){
			var $this = $('.wpsm_spec_tab_wrapcont .wpsm_gmap_loc');
			var tabID = $this.parents('.tab-pane').attr('id');
			$(".wpsm_spec_tab_group a[href='#"+ tabID +"']").one('click', function(){
				if($this.find('map_canvas').length == 0 ){
					$this.wpsmGmapLoc();
				}
			});
		}else if($('.wpsm_spec_tab_wrapcont .wpsm_gmap_pos').length > 0){
			var $this = $('.wpsm_spec_tab_wrapcont .wpsm_gmap_pos');
			var tabID = $this.parents('.tab-pane').attr('id');
			$(".wpsm_spec_tab_group a[href='#"+ tabID +"']").one('click', function(){
				if($this.find('map_canvas').length == 0){
					$this.wpsmGmapPos();
				}
			});
		}else{	
			$('.wpsm_gmap_loc').each( function(){
				$(this).wpsmGmapLoc();
			});
			$('.wpsm_gmap_pos').each( function(){
				$(this).wpsmGmapPos();
			});
		}
	});
	
   $.fn.wpsmGmapLoc = function() {
		var $map_id = $(this).attr('id'),
		$title = $(this).find('.title').val(),
		$location = $(this).find('.location').val(),
		$zoom = parseInt( $(this).find('.zoom').val() ),
		geocoder, map;
		var mapOptions = {
			zoom: $zoom,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': $location}, function(results, status){
			if (status == google.maps.GeocoderStatus.OK){
				var mapOptions = {
					zoom: $zoom,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				map = new google.maps.Map($('#'+ $map_id + ' .map_canvas')[0], mapOptions);
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
				  map: map, 
				  position: results[0].geometry.location,
				  title : $location
				});
				var contentString = '<div class="map-infowindow">'+
					( ($title) ? '<h3>' + $title + '</h3>' : '' ) + 
					$location + '<br/>' +
					'<a href="https://maps.google.com/?q='+ $location +'" target="_blank">View on Google Map</a>' +
					'</div>';
				var infowindow = new google.maps.InfoWindow({
				  content: contentString
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map,marker);
				});
				
			} else {
				$('#'+ $map_id).html("Geocode was not successful for the following reason: " + status);
			}
		});
   };
   
   $.fn.wpsmGmapPos = function() {
		var $map_id = $(this).attr('id'),
		$title = $(this).find('.title').val(),
		$lat = parseFloat($(this).find('.lat').val()),
		$lng = parseFloat($(this).find('.lng').val()),	
		$zoom = parseInt($(this).find('.zoom').val()),
		map;
		var mapOptions = {
			zoom: $zoom,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: {lat: $lat, lng: $lng}
		};
		var myLatLng = mapOptions.center;
		map = new google.maps.Map($('#'+ $map_id + ' .map_canvas')[0], mapOptions);
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			title: $title
		});   
   };
   
});
