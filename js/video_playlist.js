/**
 * function to check the phone screen
 */

var rhDetect = {};

( function(){
    "use strict";
    rhDetect = {
        isIe8: false,
        isIe9 : false,
        isIe10 : false,
        isIe11 : false,
        isIe : false,
        isSafari : false,
        isChrome : false,
        isIpad : false,
        isTouchDevice : false,
        hasHistory : false,
        isPhoneScreen : false,
        isIos : false,
        isAndroid : false,
        isOsx : false,
        isFirefox : false,
        isWinOs : false,
        isMobileDevice:false,
        htmlJqueryObj:null,

        runIsPhoneScreen: function () {
            if ( (jQuery(window).width() < 768 || jQuery(window).height() < 768) && false === rhDetect.isIpad ) {
                rhDetect.isPhoneScreen = true;

            } else {
                rhDetect.isPhoneScreen = false;
            }
        },
        set: function (detector_name, value) {
            rhDetect[detector_name] = value;
        }
    };

    rhDetect.htmlJqueryObj = jQuery('html');

    if ( -1 !== navigator.appVersion.indexOf("Win") ) {
        rhDetect.set('isWinOs', true);
    }

    if ( !!('ontouchstart' in window) && !rhDetect.isWinOs ) {
        rhDetect.set('isTouchDevice', true);
    }

    if ( rhDetect.htmlJqueryObj.is('.ie8') ) {
        rhDetect.set('isIe8', true);
        rhDetect.set('isIe', true);
    }

    if ( rhDetect.htmlJqueryObj.is('.ie9') ) {
        rhDetect.set('isIe9', true);
        rhDetect.set('isIe', true);
    }

    if( navigator.userAgent.indexOf("MSIE 10.0") > -1 ){
        rhDetect.set('isIe10', true);
        rhDetect.set('isIe', true);
    }

    if ( !!navigator.userAgent.match(/Trident.*rv\:11\./) ){
        rhDetect.set('isIe11', true);
    }

    if (window.history && window.history.pushState) {
        rhDetect.set('hasHistory', true);
    }

    if ( -1 !== navigator.userAgent.indexOf('Safari')  && -1 === navigator.userAgent.indexOf('Chrome') ) {
        rhDetect.set('isSafari', true);
    }

    if (/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())) {
        rhDetect.set('isChrome', true);
    }

    if ( null !== navigator.userAgent.match(/iPad/i)) {
        rhDetect.set('isIpad', true);
    }


    if (/(iPad|iPhone|iPod)/g.test( navigator.userAgent )) {
        rhDetect.set('isIos', true);
    }

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        rhDetect.set('isMobileDevice', true);
    }

    rhDetect.runIsPhoneScreen();

    var user_agent = navigator.userAgent.toLowerCase();
    if ( user_agent.indexOf("android") > -1 ) {
        rhDetect.set('isAndroid', true);
    }

    if ( -1 !== navigator.userAgent.indexOf('Mac OS X') ) {
        rhDetect.set('isOsx', true);
    }

    if ( -1 !== navigator.userAgent.indexOf('Firefox') ) {
        rhDetect.set('isFirefox', true);
    }

})();

/*
* $f used by vimeo in rh_video shortcode
* */

"use strict";

var Froogaloop=function(){
	function e(a){
		return new e.fn.init(a)
	}
	function h(a,c,b){
		if(!b.contentWindow.postMessage)return!1;
		var f=b.getAttribute("src").split("?")[0],a=JSON.stringify({method:a,value:c});
		"//"===f.substr(0,2)&&(f=window.location.protocol+f);
		b.contentWindow.postMessage(a,f)
	}
	function j(a){
		var c,b;
		try{c=JSON.parse(a.data),b=c.event||c.method}catch(f){}
		"ready"==b&&!i&&(i=!0);
		if(a.origin!=k)return!1;
		var a=c.value,e=c.data,g=""===g?null:c.player_id;
		c=g?d[g][b]:d[b];
		b=[];
		if(!c)return!1;
		void 0!==a&&b.push(a);
		e&&b.push(e);
		g&&b.push(g);
		return 0<b.length?c.apply(null,b):c.call()
	}
	function l(a,c,b){
		b?(d[b]||(d[b]={}),d[b][a]=c):d[a]=c
	}
	var d={},i=!1,k="";
	e.fn=e.prototype={
		element:null,init:function(a){
			"string"===typeof a&&(a=document.getElementById(a));
			this.element=a;a=this.element.getAttribute("src");
			"//"===a.substr(0,2)&&(a=window.location.protocol+a);
			for(var a=a.split("/"),c="",b=0,f=a.length;
			b<f;b++){
				if(3>b)c+=a[b];
				else break;
				2>b&&(c+="/")
			}
			k=c;
			return this
		},
		api:function(a,c){
			if(!this.element||!a)return!1;
			var b=this.element,f=""!==b.id?b.id:null,d=!c||!c.constructor||!c.call||!c.apply?c:null,e=c&&c.constructor&&c.call&&c.apply?c:null;e&&l(a,e,f);h(a,d,b);
			return this
		},
		addEvent:function(a,c){
			if(!this.element)return!1;
			var b=this.element,d=""!==b.id?b.id:null;
			l(a,c,d);
			"ready"!=a?h("addEventListener",a,b):"ready"==a&&i&&c.call(null,d);
			return this
		},
		removeEvent:function(a){
			if(!this.element)return!1;
			var c=this.element,b;a:{
				if((b=""!==c.id?c.id:null)&&d[b]){
					if(!d[b][a]){b=!1;
					break a}d[b][a]=null
				}else{
					if(!d[a]){
						b=!1;
					break a
					}
					d[a]=null
				}
				b=!0
			}
			"ready"!=a&&b&&h("removeEventListener",a,c)
		}
	};
	e.fn.init.prototype=e.fn;
	window.addEventListener?window.addEventListener("message",j,!1):window.attachEvent("onmessage",j);
	return window.Froogaloop=window.$f=e
}();

/* video_playlist.js v1.1 */

var rhYoutubePlayer = {};
var rhVimeoPlaylistObj = {};
var rhPlaylistGeneralFunctions = {};


jQuery(window).load(function() {
//jQuery().ready(function() {

    'use strict';

    jQuery(document).on("click", ".rh_click_video_youtube:not(.rh_video_currently_playing)", function(e){

        rhYoutubePlayer.rhPlaylistVideoAutoplayYoutube = 1;

        rhPlaylistGeneralFunctions.rhPlaylistAddPlayControl( '.rh_youtube_control' );

        var rhYoutubeVideo = jQuery( this ).attr( 'id' ).substring( 3 );
        if ( '' !== rhYoutubeVideo ) {
            rhYoutubePlayer.playVideo( rhYoutubeVideo );
        }
    });


    jQuery( '.rh_youtube_control' ).click(function(e){
        e.stopPropagation();

        if ( jQuery( this ).hasClass( 'rh-sp-video-play' ) ){

            rhYoutubePlayer.rhPlaylistVideoAutoplayYoutube = 1;

            rhYoutubePlayer.rhPlaylistYoutubePlayVideo();

        } else {

            rhYoutubePlayer.rhPlaylistYoutubePauseVideo();
        }
    });


    if ( jQuery( '.rh_wrapper_playlist_player_youtube' ).length > 0) {

        if ( '1' == jQuery( '.rh_wrapper_playlist_player_youtube').data( 'autoplay' ) ) {
            rhYoutubePlayer.rhPlaylistVideoAutoplayYoutube = 1;
        }

        var firstVideo = jQuery( '.rh_wrapper_playlist_player_youtube' ).data( 'first-video' );

        if ( '' !== firstVideo ) {
            rhYoutubePlayer.rhPlaylistIdYoutubeVideoRunning = firstVideo;

            rhYoutubePlayer.playVideo( firstVideo );
        }
    }

	
    if ( '1' == jQuery( '.rh_wrapper_playlist_player_vimeo' ).data( 'autoplay' ) ) {
        rhVimeoPlaylistObj.rhPlaylistVideoAutoplayVimeo = 1;
    }

    jQuery(document).on("click", ".rh_click_video_vimeo:not(.rh_video_currently_playing)", function(e){
        e.stopPropagation();

        rhVimeoPlaylistObj.rhPlaylistVideoAutoplayVimeo = 1;

        rhPlaylistGeneralFunctions.rhPlaylistAddPlayControl( '.rh_vimeo_control' );

        rhVimeoPlaylistObj.createPlayer( jQuery( this ).attr( 'id' ).substring( 3 ) );
    });


    if ( jQuery( '.rh_wrapper_playlist_player_vimeo' ).length > 0 ) {

        rhPlaylistGeneralFunctions.rhPlaylistAddPlayControl( '.rh_vimeo_control' );

        rhVimeoPlaylistObj.createPlayer( jQuery( '.rh_wrapper_playlist_player_vimeo' ).data('first-video' ) );
    }


    jQuery( '.rh_vimeo_control' ).click(function(){

        if ( jQuery( this ).hasClass( 'rh-sp-video-play' ) ) {

            rhVimeoPlaylistObj.rhPlaylistVideoAutoplayVimeo = 1;

            rhVimeoPlaylistObj.rhPlaylistPlayerVimeo.api( 'play' );

        } else {

            rhVimeoPlaylistObj.rhPlaylistPlayerVimeo.api( 'pause' );
        }
    });
});


(function() {
    'use strict';

    rhYoutubePlayer = {
        rhYtPlayer: '',

        rhPlayerContainer: 'player_youtube',

        rhPlaylistVideoAutoplayYoutube: 0,

        rhPlaylistIdYoutubeVideoRunning: '',


        playVideo: function( videoId ) {
            if ( 'undefined' === typeof( YT ) || 'undefined' === typeof( YT.Player ) ) {
                window.onYouTubePlayerAPIReady = function() {
                    rhYoutubePlayer.loadPlayer( rhYoutubePlayer.rhPlayerContainer, videoId );
                };
                jQuery.getScript( 'https://www.youtube.com/player_api' );
            } else {
                rhYoutubePlayer.loadPlayer( rhYoutubePlayer.rhPlayerContainer, videoId );
            }
        },


        loadPlayer: function( container, videoId ) {

            rhYoutubePlayer.rhPlaylistIdYoutubeVideoRunning = videoId;

            var current_video_name = rh_youtube_list_ids['rh_' + rhYoutubePlayer.rhPlaylistIdYoutubeVideoRunning]['title'];
            var current_video_time = rh_youtube_list_ids['rh_' + rhYoutubePlayer.rhPlaylistIdYoutubeVideoRunning]['time'];

            rhPlaylistGeneralFunctions.rhVideoPlaylistRemoveFocused( '.rh_click_video_youtube' );

            jQuery( '#rh_' + videoId ).addClass( 'rh_video_currently_playing' );

            rhYoutubePlayer.rhYtPlayer = '';
            jQuery( '.rh_wrapper_playlist_player_youtube' ).html( '<div id=' + rhYoutubePlayer.rhPlayerContainer + '></div>' );

            rhYoutubePlayer.rhYtPlayer = new YT.Player( container, {
                playerVars: {

                    autoplay: rhYoutubePlayer.rhPlaylistVideoAutoplayYoutube
                },
                height: '100%',
                width: '100%',
                videoId: videoId,
                events: {
                    'onReady': rhYoutubePlayer.onPlayerReady,
                    'onStateChange': rhYoutubePlayer.onPlayerStateChange
                }
            });
        },


        onPlayerStateChange: function( event ) {
            if ( event.data === YT.PlayerState.PLAYING ) {

                rhPlaylistGeneralFunctions.rhPlaylistAddPauseControl( '.rh_youtube_control' );

            } else if ( event.data === YT.PlayerState.ENDED ) {

                rhPlaylistGeneralFunctions.rhPlaylistAddPlayControl( '.rh_youtube_control' );

                rhYoutubePlayer.rhPlaylistVideoAutoplayYoutube = 1;

                var nextVideoId = rhPlaylistGeneralFunctions.rhPlaylistChooseNextVideo( [ rh_youtube_list_ids, rhYoutubePlayer.rhPlaylistIdYoutubeVideoRunning ] );
                if ( '' !== nextVideoId ) {
                    rhYoutubePlayer.playVideo( nextVideoId );
                }

            } else if ( YT.PlayerState.PAUSED ) {

                rhPlaylistGeneralFunctions.rhPlaylistAddPlayControl( '.rh_youtube_control' );
            }
        },

        rhPlaylistYoutubeStopVideo: function() {
            rhYoutubePlayer.rhYtPlayer.stopVideo();
        },

        rhPlaylistYoutubePlayVideo: function() {
            if ( ! rhDetect.isMobileDevice ) {
                rhYoutubePlayer.rhYtPlayer.playVideo();
            }
        },

        rhPlaylistYoutubePauseVideo: function() {
            rhYoutubePlayer.rhYtPlayer.pauseVideo();
        }
    };


    //VIMEO
    rhVimeoPlaylistObj = {

        currentVideoPlaying : '',

        rhPlaylistPlayerVimeo: '',

        rhPlaylistVideoAutoplayVimeo: 0,

        createPlayer: function ( videoId ) {
            if ( '' !== videoId ) {

                var vimeo_iframe_autoplay = '';

                this.currentVideoPlaying = videoId;

                rhPlaylistGeneralFunctions.rhVideoPlaylistRemoveFocused( '.rh_click_video_vimeo' );

                jQuery( '#rh_' + videoId ).addClass( 'rh_video_currently_playing' );

                this.putMovieDataToControlBox( videoId );

                if ( 0 !== this.rhPlaylistVideoAutoplayVimeo ) {
                    vimeo_iframe_autoplay = '&autoplay=1';
                }

                jQuery( '.rh_wrapper_playlist_player_vimeo' ).html( '' );
                jQuery( '.rh_wrapper_playlist_player_vimeo' ).html( '<iframe id="player_vimeo_1" src="https://player.vimeo.com/video/' + videoId + '?api=1&player_id=player_vimeo_1' + vimeo_iframe_autoplay + '"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>' );

                this.createVimeoObjectPlayer( jQuery );
            }

        },

        putMovieDataToControlBox: function( videoId ){
        },

        createVimeoObjectPlayer : function( $ ) {
            var iframe = '';
            var player = '';

            iframe = $( '#player_vimeo_1' )[0];
            player = $f( iframe );

            this.rhPlaylistPlayerVimeo = player;

            player.addEvent( 'ready', function() {

                player.addEvent( 'play', rhVimeoPlaylistObj.onPlay );
                player.addEvent( 'pause', rhVimeoPlaylistObj.onPause );
                player.addEvent( 'finish', rhVimeoPlaylistObj.onFinish );
                player.addEvent( 'playProgress', rhVimeoPlaylistObj.onPlayProgress );
            });
        },

        onPlay : function( id ) {
            rhPlaylistGeneralFunctions.rhPlaylistAddPauseControl( '.rh_vimeo_control' );

            rhVimeoPlaylistObj.rhPlaylistVideoAutoplayVimeo = 1;
        },

        onPause : function( id ) {
            rhPlaylistGeneralFunctions.rhPlaylistAddPlayControl( '.rh_vimeo_control' );
        },

        onFinish : function( id ) {

            rhPlaylistGeneralFunctions.rhPlaylistAddPlayControl( '.rh_vimeo_control' );

            rhVimeoPlaylistObj.rhPlaylistVideoAutoplayVimeo = 1;

            if ( ! rhDetect.isMobileDevice || ! rhDetect.isAndroid ) {

                var nextVideoId = rhPlaylistGeneralFunctions.rhPlaylistChooseNextVideo( [rh_vimeo_list_ids, rhVimeoPlaylistObj.currentVideoPlaying] );
                if ( '' !== nextVideoId ) {
                    rhVimeoPlaylistObj.createPlayer( nextVideoId );
                }
            }
        },

        onPlayProgress : function onPlayProgress( data, id ) {

        }
    };


    rhPlaylistGeneralFunctions = {
		
        rhVideoPlaylistRemoveFocused: function( objClass ) {
			
            jQuery( objClass ).each(function() {
				
                jQuery( this ).removeClass( 'rh_video_currently_playing' );
            });
        },


        rhPlaylistChooseNextVideo: function( parramArray ){

            var videoList = parramArray[0];
            var currentVideoIdPlaying = 'rh_' + parramArray[1];

            var nextVideoId = '';
            var foundCurrent = '';
            for ( var video in videoList ) {
                if ( videoList.hasOwnProperty( video ) ) {
                    if ( 'found' === foundCurrent ) {
                        nextVideoId = video;
                        foundCurrent = '';
                        break;
                    }
                    if ( video === currentVideoIdPlaying ) {
                        foundCurrent = 'found';
                    }
                }
            }

            if ( '' !== nextVideoId ) {

                if ( 'rh_' === nextVideoId.substring( 0, 3 ) ) {
                    nextVideoId = nextVideoId.substring( 3 );
                }

                return nextVideoId;
            }

            return '';
        },


        rhPlaylistAddPauseControl: function( wrapperClass ){
            jQuery( wrapperClass ).removeClass( 'rh-sp-video-play' ).addClass( 'rh-sp-video-pause' );
        },

        rhPlaylistAddPlayControl: function( wrapperClass ){
            jQuery( wrapperClass ).removeClass( 'rh-sp-video-pause' ).addClass( 'rh-sp-video-play' );
        }
    };
})();
