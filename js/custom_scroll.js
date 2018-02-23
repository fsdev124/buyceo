jQuery(document).ready(function($) {
'use strict';	
	$(window).scroll(function() {
		var sheight = $('.sidebar').height();
		var theight = $('.sidebar').offset();
		var swidth = $('.sidebar').width();
		var tthis = $('.sidebar .stickyscroll_widget').first().height();
		var hbot = $('.rh-content-wrap').offset();
		var hfoot = $('.rh-content-wrap').height();

		if ($(this).scrollTop()>sheight + theight.top) $('.sidebar .stickyscroll_widget').first().css({'position':'fixed','top':'70px', 'width': swidth}).addClass('scrollsticky');
		else $('.sidebar .stickyscroll_widget').first().css({'position':'static', 'width':'auto','top':'0'}).removeClass('scrollsticky');
		if ($(this).scrollTop()>hfoot + hbot.top - tthis ) $('.sidebar .stickyscroll_widget').first().css({'position':'static', 'width':'auto','top':'0'}).removeClass('scrollsticky');
	});
});