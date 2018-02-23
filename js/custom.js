/*
   Author: Igor Sunzharovskyi.
   Author URI: https://wpsoul.com
*/
/****** Helpers JS *****/

/** Inview **/
!function(t){function e(){var e,i,n={height:a.innerHeight,width:a.innerWidth};return n.height||(e=r.compatMode,(e||!t.support.boxModel)&&(i="CSS1Compat"===e?f:r.body,n={height:i.clientHeight,width:i.clientWidth})),n}function i(){return{top:a.pageYOffset||f.scrollTop||r.body.scrollTop,left:a.pageXOffset||f.scrollLeft||r.body.scrollLeft}}function n(){var n,l=t(),r=0;if(t.each(d,function(t,e){var i=e.data.selector,n=e.$element;l=l.add(i?n.find(i):n)}),n=l.length)for(o=o||e(),h=h||i();n>r;r++)if(t.contains(f,l[r])){var a,c,p,s=t(l[r]),u={height:s.height(),width:s.width()},g=s.offset(),v=s.data("inview");if(!h||!o)return;g.top+u.height>h.top&&g.top<h.top+o.height&&g.left+u.width>h.left&&g.left<h.left+o.width?(a=h.left>g.left?"right":h.left+o.width<g.left+u.width?"left":"both",c=h.top>g.top?"bottom":h.top+o.height<g.top+u.height?"top":"both",p=a+"-"+c,v&&v===p||s.data("inview",p).trigger("inview",[!0,a,c])):v&&s.data("inview",!1).trigger("inview",[!1])}}var o,h,l,d={},r=document,a=window,f=r.documentElement,c=t.expando;t.event.special.inview={add:function(e){d[e.guid+"-"+this[c]]={data:e,$element:t(this)},l||t.isEmptyObject(d)||(l=setInterval(n,250))},remove:function(e){try{delete d[e.guid+"-"+this[c]]}catch(i){}t.isEmptyObject(d)&&(clearInterval(l),l=null)}},t(a).bind("scroll resize scrollstop",function(){o=h=null}),!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){h=null})}(jQuery);
/** PgwModal - Version 2.0 Copyright 2014, Jonathan M. Piat http://pgwjs.com - http://pagawa.com Released under the GNU GPLv3 license - http://opensource.org/licenses/gpl-3.0*/
(function(a){a.pgwModal=function(i){var c={};var g={mainClassName:"pgwModal",backdropClassName:"pgwModalBackdrop",maxWidth:500,titleBar:true,closable:true,closeOnEscape:true,closeOnBackgroundClick:true,closeContent:'<span class="pm-icon"></span>',loadingContent:'<span class="re_loadingbefore"></span>',errorContent:"An error has occured. Please try again in a few moments."};if(typeof window.pgwModalObject!="undefined"){c=window.pgwModalObject}if((typeof i=="object")&&(!i.pushContent)){if(!i.url&&!i.target&&!i.content){throw new Error('PgwModal - There is no content to display, please provide a config parameter : "url", "target" or "content"')}c.config={};c.config=a.extend({},g,i);window.pgwModalObject=c}var k=function(){var o='<div id="pgwModalBackdrop"></div><div id="pgwModal"><div class="pm-container"><div class="pm-body"><span class="pm-close"></span><div class="pm-title"></div><div class="pm-content"></div></div></div></div>';a("body").append(o);a(document).trigger("PgwModal::Create");return true};var l=function(){a("#pgwModal .pm-title, #pgwModal .pm-content").html("");a("#pgwModal .pm-close").html("").unbind("click");return true};var f=function(){angular.element('body').injector().invoke(function($compile){var scope=angular.element($('#pgwModal .pm-content')).scope();$compile($('#pgwModal .pm-content'))(scope);scope.$digest()});return true};var d=function(o){a("#pgwModal .pm-content").html(o);if(c.config.angular){f()}m();a(document).trigger("PgwModal::PushContent");return true};var m=function(){a("#pgwModal, #pgwModalBackdrop").show();var q=a(window).height();var o=a("#pgwModal .pm-body").height();var p=Math.round((q-o)/3);if(p<=0){p=0}a("#pgwModal .pm-body").animate({marginTop: p}, 200);return true};var h=function(){return c.config.modalData};var e=function(){var o=a('<div style="width:50px;height:50px;overflow:auto"><div></div></div>').appendTo("body");var q=o.children();if(typeof q.innerWidth!="function"){return 0}var p=q.innerWidth()-q.height(90).innerWidth();o.remove();return p};var b=function(){return a("body").hasClass("pgwModalOpen")};var n=function(){a("#pgwModal, #pgwModalBackdrop").removeClass().hide();a("body").css("padding-right","").removeClass("pgwModalOpen");l();a(window).unbind("resize.PgwModal");a(document).unbind("keyup.PgwModal");a("#pgwModal").unbind("click.PgwModalBackdrop");try{delete window.pgwModalObject}catch(o){window.pgwModalObject=undefined}a(document).trigger("PgwModal::Close");return true};var j=function(){if(a("#pgwModal").length==0){k()}else{l()}a("#pgwModal").removeClass().addClass(c.config.mainClassName);a("#pgwModalBackdrop").removeClass().addClass(c.config.backdropClassName);if(!c.config.closable){a("#pgwModal .pm-close").html("").unbind("click").hide()}else{a("#pgwModal .pm-close").html(c.config.closeContent).click(function(){n()}).show()}if(!c.config.titleBar){a("#pgwModal .pm-title").hide()}else{a("#pgwModal .pm-title").show()}if(c.config.title){a("#pgwModal .pm-title").text(c.config.title)}if(c.config.maxWidth){a("#pgwModal .pm-body").css("max-width",c.config.maxWidth)}if(c.config.url){if(c.config.loadingContent){a("#pgwModal .pm-content").html(c.config.loadingContent)}var o={url:i.url,success:function(q){d(q)},error:function(){a("#pgwModal .pm-content").html(c.config.errorContent)}};if(c.config.ajaxOptions){o=a.extend({},o,c.config.ajaxOptions)}a.ajax(o)}else{if(c.config.target){d(a(c.config.target).html())}else{if(c.config.content){d(c.config.content)}}}if(c.config.closeOnEscape&&c.config.closable){a(document).bind("keyup.PgwModal",function(q){if(q.keyCode==27){n()}})}if(c.config.closeOnBackgroundClick&&c.config.closable){a("#pgwModal").bind("click.PgwModalBackdrop",function(s){var r=a(s.target).hasClass("pm-container");var q=a(s.target).attr("id");if(r||q=="pgwModal"){n()}})}a("body").addClass("pgwModalOpen");var p=e();if(p>0){a("body").css("padding-right",p)}a(window).bind("resize.PgwModal",function(){m()});a(document).trigger("PgwModal::Open");return true};if((typeof i=="string")&&(i=="close")){return n()}else{if((typeof i=="string")&&(i=="reposition")){return m()}else{if((typeof i=="string")&&(i=="getData")){return h()}else{if((typeof i=="string")&&(i=="isOpen")){return b()}else{if((typeof i=="object")&&(i.pushContent)){return d(i.pushContent)}else{if(typeof i=="object"){return j()}}}}}}}})(window.Zepto||window.jQuery);
/*Fitvid http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/ */
(function(e){"use strict";e.fn.fitVids=function(t){var n={customSelector:null,ignore:null};if(!document.getElementById("fit-vids-style")){var r=document.head||document.getElementsByTagName("head")[0];var i=".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}";var s=document.createElement("div");s.innerHTML='<p>x</p><style id="fit-vids-style">'+i+"</style>";r.appendChild(s.childNodes[1])}if(t){e.extend(n,t)}return this.each(function(){var t=["iframe[src*='player.vimeo.com']","iframe[src*='youtube.com']","iframe[src*='youtube-nocookie.com']","iframe[src*='kickstarter.com'][src*='video.html']","object","embed"];if(n.customSelector){t.push(n.customSelector)}var r=".fitvidsignore";if(n.ignore){r=r+", "+n.ignore}var i=e(this).find(t.join(","));i=i.not("object object");i=i.not(r);i.each(function(){var t=e(this);if(t.parents(r).length>0){return}if(this.tagName.toLowerCase()==="embed"&&t.parent("object").length||t.parent(".fluid-width-video-wrapper").length){return}if(!t.css("height")&&!t.css("width")&&(isNaN(t.attr("height"))||isNaN(t.attr("width")))){t.attr("height",9);t.attr("width",16)}var n=this.tagName.toLowerCase()==="object"||t.attr("height")&&!isNaN(parseInt(t.attr("height"),10))?parseInt(t.attr("height"),10):t.height(),i=!isNaN(parseInt(t.attr("width"),10))?parseInt(t.attr("width"),10):t.width(),s=n/i;if(!t.attr("id")){var o="fitvid"+Math.floor(Math.random()*999999);t.attr("id",o)}t.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",s*100+"%");t.removeAttr("height").removeAttr("width")})})}})(window.jQuery||window.Zepto)
/*! jQuery Unveil http://luis-almeida.github.com/unveil Licensed under the MIT license. */
!function(t){t.fn.unveil=function(i,e){function n(){var i=a.filter(function(){var i=t(this);if(!i.is(":hidden")){var e=o.scrollTop(),n=e+o.height(),r=i.offset().top,s=r+i.height();return s>=e-u&&n+u>=r}});r=i.trigger("unveil"),a=a.not(r)}var r,o=t(window),u=i||0,s=window.devicePixelRatio>1,l=s?"data-src-retina":"data-src",a=this;return this.one("unveil",function(){var t=this.getAttribute(l);t=t||this.getAttribute("data-src"),t&&(this.setAttribute("src",t),"function"==typeof e&&e.call(this))}),o.on("scroll.unveil resize.unveil lookup.unveil",n),n(),this}}(window.jQuery||window.Zepto);
/* Cut tab.js v3.3.6*/
+function(a){"use strict";function c(c){return this.each(function(){var d=a(this),e=d.data("rh.tab");e||d.data("rh.tab",e=new b(this)),"string"==typeof c&&e[c]()})}var b=function(b){this.element=a(b)};b.prototype.show=function(){var b=this.element,c=b.closest("ul"),d=b.data("target");if(d||(d=b.attr("href"),d=d&&d.replace(/.*(?=#[^\s]*$)/,"")),!b.parent("li").hasClass("active")){var e=c.find(".active:last a"),f=a.Event("hide.rh.tab",{relatedTarget:b[0]}),g=a.Event("show.rh.tab",{relatedTarget:e[0]});if(e.trigger(f),b.trigger(g),!g.isDefaultPrevented()&&!f.isDefaultPrevented()){var h=a(d);this.activate(b.closest("li"),c),this.activate(h,h.parent(),function(){e.trigger({type:"hidden.rh.tab",relatedTarget:b[0]}),b.trigger({type:"shown.rh.tab",relatedTarget:e[0]})})}}},b.prototype.activate=function(a,b){function d(){c.removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),a.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0)}var c=b.find("> .active");d()};var d=a.fn.tab;a.fn.tab=c,a.fn.tab.Constructor=b,a.fn.tab.noConflict=function(){return a.fn.tab=d,this};var e=function(b){b.preventDefault(),c.call(a(this),"show")};a(document).on("click.rh.tab.data-api",'[data-toggle="tab"]',e)}(jQuery);

/***** BASIC CUSTOM JS *****/

//Here we will cache data from ajax calls

//CHARTS
var table_charts = function() {
   jQuery('.table_view_charts').each(function(index){
      var rowcount = jQuery(this).find('.top_chart_row_found').data('rowcount');
      for (var rowcountindex = 0; rowcountindex < rowcount; rowcountindex++) {

         //Equal height for each row
         var heightArray = jQuery(this).find('li.row_chart_'+ rowcountindex +'').map( function(){
            return  jQuery(this).height();
         }).get();
         var maxHeight = Math.max.apply( Math, heightArray);
         jQuery(this).find('li.row_chart_'+ rowcountindex +'').height(maxHeight);

         //Find differences
         var recomparecolvalue;
         jQuery(this).find('.top_chart_wrap li.row_chart_'+ rowcountindex +'').each(function(n) {
            if (jQuery(this).html() != recomparecolvalue && n > 0) {
               jQuery(this).closest('.table_view_charts').find('li.row_chart_'+ rowcountindex +'').addClass('row-is-different');
            }
            else {
               recomparecolvalue = jQuery(this).html();
            }
         });
      }
   });
}


function isVisibleOnScroll(elem)
{
   var $elem = jQuery(elem);
   var $window = jQuery(window);
   var docViewTop = $window.scrollTop();
   var docViewBottom = docViewTop + $window.height();
   var elemTop = $elem.offset().top;
   var elemBottom = elemTop + $elem.height();
   return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom) && (elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

var re_ajax_cache = {
    data: {},
    remove: function (cache_id) {
        delete re_ajax_cache.data[cache_id];
    },
    exist: function (cache_id) {
        return re_ajax_cache.data.hasOwnProperty(cache_id) && re_ajax_cache.data[cache_id] !== null;
    },
    get: function (cache_id) {
        return re_ajax_cache.data[cache_id];
    },
    set: function (cache_id, cachedData) {
        re_ajax_cache.remove(cache_id);
        re_ajax_cache.data[cache_id] = cachedData;
    }
};

var re_ajax_search = {

    // Some variables
    _current_selection_index:0,
    _last_request_results_count:0,
    _first_down_up:true,
    _is_search_open:false,

    init: function init() {

        // Search icon show/hide
        jQuery(document).on( 'click', '.icon-search-onclick', function(e) {
            e.stopPropagation();
            jQuery( '.main-nav' ).toggleClass( 'top-search-onclick-open' );
            if (re_ajax_search._is_search_open === true) {
                re_ajax_search._is_search_open = false;
            }
            else {
                re_ajax_search._is_search_open = true;
                if (jQuery('html').hasClass('flash')) {
                    setTimeout(function(){
                        jQuery( '.main-nav .search-header-contents input[name="s"]' ).focus();
                    }, 200);
                }                
            }
        });
  
        jQuery(document).click( function(e){ 
            if( jQuery(e.target).closest(".head_search").length || jQuery(e.target).closest(".custom_search_box").length) 
                return;
            jQuery( '.head_search .re-aj-search-wrap' ).removeClass( 're-aj-search-open' ).empty();
            jQuery( '.custom_search_box .re-aj-search-wrap' ).removeClass( 're-aj-search-open' ).empty();
            e.stopPropagation();
            if (re_ajax_search._is_search_open === true) {
                re_ajax_search._is_search_open = false;
            }            
        });

        jQuery(document).click( function(e){ 
            if( jQuery(e.target).closest(".search-header-contents").length ) 
                return;
            jQuery( '.main-nav' ).removeClass( 'top-search-onclick-open' );
            e.stopPropagation();
            if (re_ajax_search._is_search_open === true) {
                re_ajax_search._is_search_open = false;
            }            
        });        

        // keydown on the text box
        jQuery('.re-ajax-search').keydown(function(event) {
            var ajaxsearchitem = jQuery(this);
            if (
                (event.which && event.which == 39)
                || (event.keyCode && event.keyCode == 39)
                || (event.which && event.which == 37)
                || (event.keyCode && event.keyCode == 37))
            {
                //do nothing on left and right arrows
                re_ajax_search.re_ajax_set_focus(ajaxsearchitem);
                return;
            }

            if ((event.which && event.which == 13) || (event.keyCode && event.keyCode == 13)) {
                // on enter
                var re_ajax_search_cur = jQuery(this).parent().parent().find('.re-sch-cur-element');
                if (re_ajax_search_cur.length > 0) {
                    var re_searchopen_url = re_ajax_search_cur.find('.re-search-result-title a').attr('href');
                    window.location = re_searchopen_url;
                } else {
                    jQuery(this).parent().submit();
                }
                return false; //redirect for search on enter
            } else {

                if ((event.which && event.which == 40) || (event.keyCode && event.keyCode == 40)) {
                    // down
                    re_ajax_search.re_aj_search_move_key_down(ajaxsearchitem);
                    return false; //disable the envent

                } else if((event.which && event.which == 38) || (event.keyCode && event.keyCode == 38)) {
                    //up
                    re_ajax_search.re_aj_search_move_key_up(ajaxsearchitem);
                    return false; //disable the envent
                } else {

                    //for backspace we have to check if the search query is empty and if so, clear the list
                    if ((event.which && event.which == 8) || (event.keyCode && event.keyCode == 8)) {
                        //if we have just one character left, that means it will be deleted now and we also have to clear the search results list
                        var search_query = jQuery(this).val();
                        if (search_query.length == 1) {
                            jQuery(this).parent().parent().find('.re-aj-search-wrap').removeClass( 're-aj-search-open' ).empty();
                        }

                    }

                    //various keys
                    re_ajax_search.re_ajax_set_focus(ajaxsearchitem);
                    //jQuery('.re-aj-search-wrap').empty();
                    setTimeout(function(){
                        re_ajax_search.do_ajax_call(ajaxsearchitem);
                    }, 100);
                }
                return true;
            }
        });

    },

    /**
     * moves the select up
     */
    re_aj_search_move_key_up: function re_aj_search_move_key_up(elem) {
        if (re_ajax_search._first_down_up === true) {
            re_ajax_search._first_down_up = false;
            if (re_ajax_search._current_selection_index === 0) {
                re_ajax_search._current_selection_index = re_ajax_search._last_request_results_count - 1;
            } else {
                re_ajax_search._current_selection_index--;
            }
        } else {
            if (re_ajax_search._current_selection_index === 0) {
                re_ajax_search._current_selection_index = re_ajax_search._last_request_results_count;
            } else {
                re_ajax_search._current_selection_index--;
            }
        }
        elem.parent().parent().find('.re-search-result-div').removeClass('re-sch-cur-element');
        if (re_ajax_search._current_selection_index  > re_ajax_search._last_request_results_count -1) {
            //the input is selected
            elem.closest('form').fadeTo(100, 1);
        } else {
            re_ajax_search.re_search_input_remove_focus(elem);
            elem.parent().parent().find('.re-search-result-div').eq(re_ajax_search._current_selection_index).addClass('re-sch-cur-element');
        }
    },

    /**
     * moves the select prompt down
     */
    re_aj_search_move_key_down: function re_aj_search_move_key_down(elem) {
        if (re_ajax_search._first_down_up === true) {
            re_ajax_search._first_down_up = false;
        } else {
            if (re_ajax_search._current_selection_index === re_ajax_search._last_request_results_count) {
                re_ajax_search._current_selection_index = 0;
            } else {
                re_ajax_search._current_selection_index++;
            }
        }
        elem.parent().parent().find('.re-search-result-div').removeClass('re-sch-cur-element');
        if (re_ajax_search._current_selection_index > re_ajax_search._last_request_results_count - 1 ) {
            //the input is selected
            elem.closest('form').fadeTo(100, 1);
        } else {
            re_ajax_search.re_search_input_remove_focus(elem);
            elem.parent().parent().find('.re-search-result-div').eq(re_ajax_search._current_selection_index).addClass('re-sch-cur-element');
        }
    },

    /**
     * puts the focus on the input box
     */
    re_ajax_set_focus: function re_ajax_set_focus(elem) {
        re_ajax_search._current_selection_index = 0;
        re_ajax_search._first_down_up = true;
        elem.closest('form').fadeTo(100, 1);
        elem.parent().parent().find('.re-search-result-div').removeClass('re-sch-cur-element');
    },

    /**
     * removes the focus from the input box
     */
    re_search_input_remove_focus: function re_search_input_remove_focus(elem) {
        if (re_ajax_search._last_request_results_count !== 0) {
            elem.closest('form').css('opacity', 0.5);
        }
    },

    /**
     * AJAX: process the response from the server
     */
    process_ajax_response: function (data, callelem) {
        var current_query = callelem.val();

        //the search is empty - drop results
        if (current_query == '') {
            callelem.parent().parent().find('.re-aj-search-wrap').empty();
            return;
        }

        var td_data_object = jQuery.parseJSON(data); //get the data object
        //drop the result - it's from a old query
        if (td_data_object.re_search_query !== current_query) {
            return;
        }

        //reset the current selection and total posts
        re_ajax_search._current_selection_index = 0;
        re_ajax_search._last_request_results_count = td_data_object.re_total_inlist;
        re_ajax_search._first_down_up = true;


        //update the query
        callelem.parent().parent().find('.re-aj-search-wrap').addClass( 're-aj-search-open' ).html(td_data_object.re_data);
        var iconsearch = callelem.parent().find('.fa-refresh'); 
        iconsearch.removeClass('fa-refresh fa-spin').addClass('fa-search');
        callelem.removeClass('searching-now');
        var winheight = jQuery(window).height();
        if (winheight < 700){
          callelem.parent().parent().find('.re-aj-search-wrap').addClass( 're-aj-search-overflow' );
        }

    },

    /**
     * AJAX: do the ajax request
     */
    do_ajax_call: function do_ajax_call(elem) {
        var posttypes = elem.data('posttype');
        var enable_compare = elem.data('enable_compare');
        var catid = elem.data('catid');
        var callelem = elem;
        if (elem.val() == '') {
            re_ajax_search.re_ajax_set_focus(callelem);
            return;
        }

        var search_query = elem.val();

        //do we have a cache hit
        if (re_ajax_cache.exist(search_query)) {
            re_ajax_search.process_ajax_response(re_ajax_cache.get(search_query), callelem);
            return;
        }

        var iconsearch =  elem.parent().find('.fa-search');     
        iconsearch.removeClass('fa-search').addClass('fa-refresh fa-spin');
        elem.addClass('searching-now');

        jQuery.ajax({
            type: 'POST',
            url: translation.ajax_url,
            data: {
                action: 'rehub_ajax_search',
                re_string: search_query,
                posttypesearch: posttypes,
                enable_compare : enable_compare,
                catid : catid,
            },
            success: function(data, textStatus, XMLHttpRequest){
                re_ajax_cache.set(search_query, data);
                re_ajax_search.process_ajax_response(data, callelem);
            },
            error: function(MLHttpRequest, textStatus, errorThrown){
                //console.log(errorThrown);
            }
        });
    }
};

//MOBILE MENU AND MEGAMENU
var NavOverlayRemoved = true;
var revMenuStyle = function() { 
    var menu = jQuery('.responsive_nav_wrap'),
        openMenu = menu.find('#dl-trigger'),
        navMenu = menu.find('#slide-menu-mobile'),
        menuList = menu.find('#slide-menu-mobile > .menu'),
        subMenu = menu.find('.sub-menu'),
        header = jQuery('#main_header'),
        windowHeight = jQuery(window).height();
    menuList.addClass('off-canvas').css('height', windowHeight - 52);
    if (menuList.find('.close-menu').length === 0) {
        menuList.append('<li class="close-menu"><span><i class="fa fa-times" aria-hidden="true"></i></span></li>');
    }
    jQuery('#slide-menu-mobile .menu-item-has-children').children('a').after('<span class="submenu-toggle"><i class="fa fa-angle-right"></i></span>');
    jQuery('#slide-menu-mobile .menu-item-has-children:not(.rh-mobile-linkable)').children('a').addClass('submenu-toggle');
    menuList.on('click', '.submenu-toggle', function(evt) {
        evt.preventDefault();
        jQuery(this)
            .siblings('.sub-menu')
            .addClass('sub-menu-active');
    });
    subMenu.each(function() {
        var $this = jQuery(this);
        if ($this.find('.back-mb').length === 0) {
            $this.prepend('<li class="back-mb"><span class="rehub-main-color">'+translation.back+'</span></li>');
        }
        menu.on('click', '.back-mb span', function(evt) {
            evt.preventDefault();
            jQuery(this)
                .parent()
                .parent()
                .removeClass('sub-menu-active');
        });
    });
    openMenu.on('click', function() {
    	jQuery('#wpadminbar').css('z-index', '999');
    	navMenu.fadeIn(100);
        menuList.addClass('off-canvas-active');
        jQuery(this).addClass('toggle-active');                
        if(NavOverlayRemoved){
        	jQuery('body').append(jQuery('<div class="offsetnav-overlay"></div>').hide().fadeIn());
        	NavOverlayRemoved = false;
    	}
        jQuery('#slide-menu-mobile').find('img.lazyimages').each(function(){
          var source = jQuery(this).attr("data-src");
          jQuery(this).attr("src", source).css({'opacity': '1'});
        });
    });
    jQuery('#slide-menu-mobile .vc_tta-panel-heading a').on('click', function(e){
        e.stopPropagation();
        e.preventDefault();
        jQuery('#slide-menu-mobile .vc_tta-panel-heading a').removeClass('active');      
        jQuery('#slide-menu-mobile .vc_tta-panel-body').slideUp();
        jQuery(this).addClass('active').closest('.vc_tta-panel').find('.vc_tta-panel-body').slideDown();
    });    
    jQuery(document).on('click', '.close-menu, .offsetnav-overlay', function(event) {
        menuList.removeClass('off-canvas-active');
        openMenu.removeClass('toggle-active');
        jQuery('.sub-menu').removeClass('sub-menu-active');                
        if(!NavOverlayRemoved){
            jQuery('.offsetnav-overlay').remove();
            NavOverlayRemoved = true;
        }                       
    });

}

jQuery(document).ready(function($) {
   'use strict';

   /* better alerts*/
   (function(){$.simplyToast=function(e,t,n){function u(){$.simplyToast.remove(o)}n=$.extend(true,{},$.simplyToast.defaultOptions,n);var r='<div class="simply-toast rh-toast rh-toast-'+(t?t:n.type)+" "+(n.customClass?n.customClass:"")+'">';if(n.allowDismiss)r+='<span class="rh-toast-close" data-dismiss="alert">&times;</span>';r+=e;r+="</div>";var i=n.offset.amount;$(".simply-toast").each(function(){return i=Math.max(i,parseInt($(this).css(n.offset.from))+this.offsetHeight+n.spacing)});var s={position:n.appendTo==="body"?"fixed":"absolute",margin:0,"z-index":"999999",display:"none","min-width":n.minWidth,"max-width":n.maxWidth};s[n.offset.from]=i+"px";var o=$(r).css(s).appendTo(n.appendTo);switch(n.align){case"center":o.css({left:"50%","margin-left":"-"+o.outerWidth()/2+"px"});break;case"left":o.css("left","20px");break;default:o.css("right","20px")}if(o.fadeIn)o.fadeIn();else o.css({display:"block",opacity:1});if(n.delay>0){setTimeout(u,n.delay)}o.find('[data-dismiss="alert"]').removeAttr("data-dismiss").click(u);return o};$.simplyToast.remove=function(e){if(e.fadeOut){return e.fadeOut(function(){return e.remove()})}else{return e.remove()}};$.simplyToast.defaultOptions={appendTo:"body",customClass:false,type:"info",offset:{from:"top",amount:20},align:"right",minWidth:250,maxWidth:450,delay:4e3,allowDismiss:true,spacing:10}})();

    // Lazy load images
    $("img.lazyimages").unveil(40, function() {
        $(this).on('load', function(){
            this.style.opacity = 1;
        });
    });

    $('.tabs, .vc_tta, .wpsm-tabs, .tab-pane').find('img.lazyimages').trigger("unveil");

    $(document).on('wpf_ajax_success', function(e){
        $("img.lazyimages").unveil(40, function() {
            $(this).on('load', function(){
                this.style.opacity = 1;
            });
        });
    });

    $(document).on('faster-woo-widgets-complete', function(e){
        $("img.lazyimages").unveil(40, function() {
            $(this).on('load', function(){
                this.style.opacity = 1;
            });
        });
    });  
    
    $(document).on('fww-recently-viewed-products-complete', function(e){
        $("img.lazyimages").unveil(40, function() {
            $(this).on('load', function(){
                this.style.opacity = 1;
            });
        });
    });  
    
    $(document).on('auto-infinite-scroll-complete', function(e){
        $("img.lazyimages").unveil(40, function() {
            $(this).on('load', function(){
                this.style.opacity = 1;
            });
        });
    });  
    
    $(document).on('super-speedy-search-complete', function(e){
        $("img.lazyimages").unveil(40, function() {
            $(this).on('load', function(){
                this.style.opacity = 1;
            });
        });
    });            

    // Header and menu
    var res_nav = $("#main_header .top_menu").html();   
    $("#main_header .responsive_nav_wrap").html('<div id="slide-menu-mobile">'+res_nav+'</div>');
    if ($('#re_menu_near_logo').length > 0) { 
    	var header_responsive_menu = $("#re_menu_near_logo ul").html();
    	$("#main_header .responsive_nav_wrap ul.menu").prepend(header_responsive_menu);
    } 
    if ($('#main_header .top-nav ul.menu').length > 0) { 
        var header_top_menu_add = $("#main_header .top-nav ul.menu").html();
        $("#main_header .responsive_nav_wrap ul.menu").append(header_top_menu_add);
    }      
    $('#main_header .responsive_nav_wrap' ).wrapInner(function() {
        return "<div id='dl-menu' class='dl-menuwrapper'></div>";
    });  
    if ($('.rh_woocartmenu_cell').length > 0) { 
    	$( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( $(".rh_woocartmenu_cell").html());
    }   
    if ($('.rehub-custom-menu-item.rh_woocartmenu').length > 0) { 
      $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( $(".rehub-custom-menu-item.rh_woocartmenu").html());
    } 
    if ($('#main_header .header-top .act-rehub-login-popup').length > 0) {
        if (typeof $('#main_header .header-top .act-rehub-login-popup').data('type') !== 'undefined') {
            var copydatatype = $('#main_header .header-top .act-rehub-login-popup').data('type');
        }
        else{
            var copydatatype = '';
        }        
        if (typeof $('#main_header .header-top .act-rehub-login-popup').data('customurl') !== 'undefined') {
            var copycustomurl = $('#main_header .header-top .act-rehub-login-popup').data('customurl');
        }
        else{
            var copycustomurl = '';
        }
        $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( "<button class='act-rehub-login-popup rhhidden mobilevisible' data-type='"+copydatatype+"' data-customurl='"+copycustomurl+"'><i class='fa fa-sign-in'></i></button>" ); 
    }    
    if ($('.rehub-custom-menu-item.rehub-top-login-onclick .act-rehub-login-popup').length > 0) {
        if (typeof $('.rehub-custom-menu-item.rehub-top-login-onclick .act-rehub-login-popup').data('type') !== 'undefined') {
            var copydatatype = $('.rehub-custom-menu-item.rehub-top-login-onclick .act-rehub-login-popup').data('type');
        }
        else{
            var copydatatype = '';
        }         
        if (typeof $('.rehub-custom-menu-item.rehub-top-login-onclick .act-rehub-login-popup').data('customurl') !== 'undefined') {
            var copycustomurl = $('.rehub-custom-menu-item.rehub-top-login-onclick .act-rehub-login-popup').data('customurl');
        }
        else{
            var copycustomurl = '';
        }        
        $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( "<button class='act-rehub-login-popup'  data-type='"+copydatatype+"' data-customurl='"+copycustomurl+"'><i class='fa fa-sign-in'></i></button>" ); 
    } 
    if ($('.rehub-custom-menu-item.rehub-top-login-onclick .user-dropdown-intop').length > 0) {
        $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( $(".rehub-custom-menu-item.rehub-top-login-onclick").html()); 
    } 
    if ($('#main_header .header-top .user-dropdown-intop').length > 0) {
        $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( $(".userblockintop").html());
        $( "#main_header .responsive_nav_wrap #dl-menu .user-dropdown-intop" ).addClass('rhhidden mobilevisible');  
    }  
    if ($('#main_header .responsive_nav_wrap #dl-menu .rehub-custom-menu-item').length > 0) {
    	$( "#main_header .responsive_nav_wrap #dl-menu .rehub-custom-menu-item" ).remove();
    }
    if ($('.logo-section .mobileinmenu').length > 0) {
        $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( $(".logo-section .mobileinmenu").clone()); 
    }        
    if ($('#logo_mobile_wrapper').length > 0) { 
        $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend($('#logo_mobile_wrapper').html() );
        $( ".logo_image_insticky, header .logo" ).addClass('hideontablet');
    }       
    if ($('.main-nav .logo-inmenu').length > 0) { 
        $( "#main_header .responsive_nav_wrap #dl-menu .menu-item.logo-inmenu" ).remove();
    }   
    $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( "<button id='dl-trigger' class='dl-trigger'><i class='fa fa-bars'></i></button>" );
    $( "#main_header .responsive_nav_wrap #dl-menu" ).prepend( "<button class='icon-search-onclick'><i class='fa fa-search'></i></button>" );

    revMenuStyle();
    re_ajax_search.init();  

    if ($('.right_aff .price_count').length > 0) {
    	var width_ofcontainer = $('.right_aff .price_count').innerWidth() / 2;
    	$('.right_aff .price_count').append('<span class="triangle_aff_price" style="border-width: 14px ' + width_ofcontainer + 'px 0 ' + width_ofcontainer + 'px"></span>');
    }   

   /* scroll to # */
   $('.rehub_scroll, #kcmenu a, .kc-gotop').on('click',function (e) {
      e.preventDefault();
      if (typeof $(this).data('scrollto') !== 'undefined') {
         var target = $(this).data('scrollto');
         var hash = $(this).data('scrollto');
      } 
      else {
         var target = $(this.hash + ', a[name="'+ this.hash.replace(/#/,"") +'"]').first();
         var hash = this.hash;
      }
      var $target = $(target);
      $('html, body').stop().animate({
         'scrollTop': $target.offset().top - 45
      }, 500, 'swing', function () {
        if(history.pushState) {
          history.pushState(null, null, hash);
        }
        else {
          window.location.hash = hash;
        }
      });
   });   
   
   /* tabs */
   $('.tabs-menu').delegate('li:not(.current)', 'click', function() {
      $(this).addClass('current').siblings().removeClass('current').parents('.tabs').find('.tabs-item').hide().eq($(this).index()).fadeIn(700);
	    $(this).closest('.tabs').find('img.lazyimages').each(function(){
	        var source = $(this).attr("data-src");
	        $(this).attr("src", source).css({'opacity': '1'});
	    });    
   });
   $('.tabs-menu li:first-child').trigger('click');

   $('.wpsm-tabs:not(.vc_tta)').each(function(){
      $(this).tabs();
   }); 

   /*bar*/  
   $('.wpsm-bar').each(function(){
      $(this).find('.wpsm-bar-bar').animate({ width: $(this).attr('data-percent') }, 1500 );
   });   

   $('.progress-animate-onclick').on("click", ".trigger-progress-bar", function(e){
      $(this).closest('.progress-animate-onclick').find('.cssProgress').addClass('active');
      $(this).closest('.progress-animate-onclick').find('.cssProgress-bar').animate({ width: '100%' }, 18000);    
   });   

   /* accordition */
   $(".wpsm-accordion").each(function(){
      $(this).accordion({heightStyle: "content" });
   });

   /* toggle */
   $("h3.wpsm-toggle-trigger").click(function(){
      $(this).toggleClass("active").next().slideToggle("fast");return false;
   });

	if ($('.wpsm-tooltip-sw').length > 0) {
   		$(".wpsm-tooltip-sw").tipsy({gravity: "sw", fade: true, html: true });
   	}

   /* review woo tabs */
   $('.rehub_woo_tabs_menu').delegate('li:not(.current)', 'click', function() {
      $(this).addClass('current').siblings().removeClass('current').parents('.rehub_woo_review').find('.rehub_woo_review_tabs').hide().eq($(this).index()).fadeIn(700);
	    $(this).closest('.rehub_woo_review').find('img.lazyimages').each(function(){
	        var source = $(this).attr("data-src");
	        $(this).attr("src", source).css({'opacity': '1'});
	    });       
   })
   $('.rehub_woo_tabs_menu li:first-child').trigger('click');
   $('.btn_offer_block.choose_offer_woo').click(function(event){     
      event.preventDefault();
      $('.rehub_woo_tabs_menu li.woo_deals_tab').trigger('click');
   });
    
   /* widget dropdown */
   $('.cat_widget_custom .children').parent().find('a').append('<span class="drop_list">&nbsp; +</span>');  
      $('.tabs-item .drop_list').click(function() {
       $(this).parent().parent().find('.children').slideToggle();
        return false
    });  

    /* offer archive dropdown */  
    $(document).on('click', '.r_offer_details .r_show_hide', function(e){
      $(this).parent().find('.open_dls_onclk').slideToggle();
      $(this).parent().find('.hide_dls_onclk').toggleClass('rhhidden');
      $(this).toggleClass('r_show_active');
    });  

   	$('.expand_all_offers').click(function() {
   		var $expand = $(this).closest('.widget_merchant_list');
   		if($expand.hasClass('expandme')){
   			$expand.removeClass('expandme');
   			$(this).find('.expandme').html('-');
   		}
   		else{
   			$expand.addClass('expandme');
   			$(this).find('.expandme').html('+');
   		}
    });    

   	/* Category search */
	if(jQuery("#rh-category-search").length>0){
		var a=new Bloodhound({datumTokenizer:Bloodhound.tokenizers.obj.whitespace("long_name","key_word"),queryTokenizer:Bloodhound.tokenizers.whitespace,local:typeahead_categories});
		a.initialize(),jQuery("#rh-category-search .typeahead").typeahead({hint:!1,highlight:!0,minLength:1,autoselect:!0},{name:"categories",displayKey:"long_name",source:a.ttAdapter(),templates:{empty:['<div class="empty-message">','<strong>No results found.</strong>',"</div>"].join("\n")}}),jQuery("#category-search .typeahead").focus(),jQuery(".js-clear-search").on("click",function(){jQuery(this).parent().find(".typeahead").val(""),jQuery(this).addClass("hide")}),jQuery("#rh-category-search .typeahead").keyup(function(){jQuery(this).val().length>=3?jQuery(".js-clear-search").removeClass("hide"):jQuery(".js-clear-search").addClass("hide")}),jQuery(document).on("typeahead:selected",function(a,b){window.location=""+b.html_name})
	}

   if($('.rh-tilled-gallery').length > 0){
      $('.rh-tilled-gallery').each(function(){
         var galleryid = $(this).data('galleryid');
         $(this).justifiedGallery({
            lastRow : 'nojustify', 
            rowHeight : 200, 
            margins : 10,
            captions : false,
         }).on('jg.complete', function () {
            
         });          
      });    
   }

   	/* responsive video*/
	$('.rh-container').find( 'iframe[src*="player.vimeo.com"], iframe[src*="youtube.com"]' ).each( function() {
		var $video = $(this);
		if ( $video.parents( 'object' ).length ) return;
		if ($video.parent().hasClass('wpb_video_wrapper')) return;
		if ($video.parent().hasClass('video-container')) return;
		if ($video.parent().parent().hasClass('slides')) return;
		if ( ! $video.prop( 'id' ) ) $video.attr( 'id', 'rvw' + Math.floor( Math.random() * 999999 ) );
		$video.wrap( '<div class="video-container"></div>');
	});               

   // Coupon Modal
   $(document).on("click", ".masked_coupon:not(.expired_coupon)", function(e){
   	e.preventDefault();
      var $this = $(this);
      var codeid = $this.data('codeid');
      var codetext = $this.data('codetext');
      if (typeof $this.data('codeid') !== 'undefined') {var couponpage = window.location.pathname + "?codeid=" + codeid;}
      if (typeof $this.data('codetext') !== 'undefined') {var couponpage = window.location.pathname + "?codetext=" + codetext;}
      var couponcode = $this.data('clipboard-text'); 
      var destination = $this.data('dest'); 
      if( destination != "" || destination != "#" ){
         window.location.href= destination;
      }
      window.open(couponpage);
   });

   function GetURLParameter(sParam){
      var sPageURL = window.location.search.substring(1);
      var sURLVariables = sPageURL.split('&');
      for (var i = 0; i < sURLVariables.length; i++) 
      {
         var sParameterName = sURLVariables[i].split('=');
         if (sParameterName[0] == sParam) 
         {
            return sParameterName[1];
         }
      }
   }  

   var coupontrigger = GetURLParameter("codeid");
   if(coupontrigger){
      var $change_code = $(".rehub_offer_coupon.masked_coupon:not(.expired_coupon)[data-codeid='" + coupontrigger +"']");
      var couponcode = $change_code.data('clipboard-text');       
      $.pgwModal({
         url: translation.ajax_url + "?action=ajax_code&codeid=" + coupontrigger,
         titleBar: false,
         maxWidth: 650,
         mainClassName : 'pgwModal coupon-reveal-popup',
         ajaxOptions : {
            success : function(response) {
               if (response) {
                  $.pgwModal({ pushContent: response });
                  $change_code.removeClass('masked_coupon woo_loop_btn coupon_btn btn_offer_block wpsm-button').addClass('not_masked_coupon').html( '<i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text">'+ couponcode +'</span>' );                                  
                  $change_code.closest('.reveal_enabled').removeClass('reveal_enabled');
               } else {
                  $.pgwModal({ pushContent: 'An error has occured' });
               }
            }
         }
      });
   };

   $(document).on("click", "a.not_masked_coupon", function(e){
      e.preventDefault();
   });

   $(document).on("click", ".csspopuptrigger", function(e){
      e.preventDefault();
      var destination = '#' + $(this).data('popup');
      $(destination).toggleClass('active');
      $('body').addClass('flowhidden');
   });

   $(document).on("click", ".csspopup .cpopupclose", function(e){
      e.preventDefault();
      $(this).closest('.csspopup').removeClass('active');
      $('body').removeClass('flowhidden');
   });

   $(document).on("click", ".toggle-this-table", function(e){
      e.preventDefault();
      $(this).closest('.rh-tabletext-block').toggleClass('closedtable');
   });          

   $(".rehub_offer_coupon.masked_coupon.expired_coupon").each(function() {
      var couponcode = $(this).data('clipboard-text');
      $(this).removeClass('masked_coupon woo_loop_btn coupon_btn btn_offer_block wpsm-button').addClass('not_masked_coupon').text(couponcode);
      $(this).closest('.reveal_enabled').removeClass('reveal_enabled');
   });  

   //Coupons copy code function
   if($('.rehub_offer_coupon:not(.expired_coupon)').length > 0){
      var client = new Clipboard( '.rehub_offer_coupon:not(.expired_coupon)' );
      var OfferCoupon = $('.rehub_offer_coupon:not(.expired_coupon)');
      client.on( 'success', function(e) {
         OfferCoupon.find('i').replaceWith( '<i class="fa fa-check-square"></i>' );
         OfferCoupon.find('i').fadeOut( 2500, function() {
            OfferCoupon.find('i').replaceWith( '<i class="fa fa-scissors fa-rotate-180"></i>' ).fadeIn('slow');
         });
      });
      client.on( 'error', function(e) {
         console.log(e);       
      });      
   }    

   	//external links
   $('.ext-source').replaceWith(function(){
      return '<a href="' + $(this).data('dest') + '" target="_blank" rel="nofollow">' + $(this).html() + '</a>';
   });

   $('.int-source').replaceWith(function(){
      return '<a href="' + $(this).data('dest') + '">' + $(this).html() + '</a>';
   });    

   //Infinite scroll js
   $('.inf_scr_wrap_auto').each(function() {
      var $this = $(this);
      $this.infinitescroll({
         navSelector: ".more_post",
         nextSelector: ".more_post a",
         itemSelector: ".inf_scr_item",
         loading: {
            finishedMsg: '<em>' + translation.fin + '</em>',
            msgText: '',
            img: translation.templateurl + '/images/preload.gif',
         },        
      }, function(){
         $this.find('img.lazyimages').each(function(){
            var source = $(this).attr("data-src");
            $(this).attr("src", source).css({'opacity': '1'});
         });      
      }
      );      
   });   

   //fix for VC responsive sidebar
   //$('.vc_col-sm-4, .vc_col-sm-3').find('.sidebar').closest('.vc_row').addClass('vc_rehub_container');    

    //category pager
   $('.cat-pagination').on('click', 'a:not(.active) ', function(){
      var multi_cat = $(this).closest('.multi_cat');
      var multi_cat_wrap = multi_cat.find('.multi_cat_wrap');
      var page = $(this).data('paginated');
      var data = {
         'action': 'multi_cat',
         'page': page,
         'tax': multi_cat.data('tax'),
         'term': multi_cat.data('term'),
         'nonce' : translation.nonce,
      };

      multi_cat_wrap.addClass('loading');

      $.post(translation.ajax_url, data, function(response) {
         if (response !== 'fail') {
            multi_cat_wrap.html(response);
            multi_cat.find('.cat-pagination a').removeClass('active');
            multi_cat.find('.cat-pagination a[data-paginated="' + page + '"]').addClass('active');
            multi_cat.find('img.lazyimages').each(function(){
                var source = $(this).attr("data-src");
                $(this).attr("src", source).css({'opacity': '1'});
            });            
         }
         multi_cat_wrap.removeClass('loading');
      });
   }); 

   //Sharing popups JS
   jQuery(document).on( 'click', '.share-link-image', function( event ) {
      var href    = jQuery( this ).data( "href" ),
         service = jQuery( this ).data( 'service' ),
         width   = 'pinterest' == service ? 750 : 600,
         height  = 'twitter' == service ? 250 : 'pinterest' == service ? 320 : 300,
         top     = ( screen.height / 2 ) - height / 2,
         left    = ( screen.width / 2 ) - width / 2;
      var options = 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height;
      event.preventDefault();
      event.stopPropagation();
      window.open( href, service, options );
   });   

   //Comment filtering
   $(document).on('click', '#rehub-comments-tabs span', function() {
      if(typeof rating_tabs_ajax_send!=='undefined' && rating_tabs_ajax_send)
         return;
      var post_id = $('#rehub-comments-tabs').data('postid');
      var rating_tabs_ajax_send = true;
      var p = $(this).parent().children().removeClass('active');
      $(this).addClass('active');
      if ($(this).data('tabid')==1) {
         $('#loadcomment-list').html('');
         $('#tab-1').show();
         rating_tabs_ajax_send = false;
         return;
      }
      $.ajax({
         type: 'post',
         data: 'action=show_tab&post_id='+post_id+'&tab_number='+$(this).data('tabid')+'&rating_tabs_id='+translation.rating_tabs_id,
         url: translation.ajax_url,
         beforeSend: function() {
            $('#tab-1').hide();
            $('#loadcomment-list').html('<div class="text-center loadingcomment"><i class="fa fa-refresh fa-spin"></i></div>');
         },
         error: function(jqXHR, textStatus, errorThrown) {
            $('#loadcomment-list').html('error: '+errorThrown);
         },
         success : function(html_data) {
            rating_tabs_ajax_send = false;
            $("#loadcomment-list").html(html_data);
         }
      });
   });  

   // Search icon show/hide 
   $(window).resize(function(){
      var w = $(window).width();
      if (w > 1023){
        $('#slide-menu-mobile').hide();
        $('.offsetnav-overlay').hide();
      }
   });  

   // Add modal on links for non logged in comment form  

   if ($('#respond .must-log-in a').length > 0) {
      if ($('#rehub-login-popup').length > 0) {
         $( "#respond .must-log-in a" ).addClass('act-rehub-login-popup'); 
      }   
   } 

   if ($('#comments .comment-reply-login').length > 0) {
      if ($('#rehub-login-popup').length > 0) {
         $( ".comment-reply-login" ).addClass('act-rehub-login-popup'); 
      }   
   }        

   // Open login/register modal
   $(document).on('click', 'body:not(.logged-in) .act-rehub-login-popup', function(e) {
      e.preventDefault();
      var acttype = $(this).data('type');
      if (acttype == 'login') {
         $.pgwModal({
            titleBar: false,
            target: '#rehub-login-popup',
            mainClassName : 'pgwModal re-user-popup-wrap',
         });
         $('.re-user-popup-wrap .rehub-errors').html('');
      }
      else if(acttype == 'register') {
         $.pgwModal({
            titleBar: false,
            target: '#rehub-register-popup',
            mainClassName : 'pgwModal re-user-popup-wrap',
         });  
         $('.re-user-popup-wrap .rehub-errors').html('');
         $('.re-user-popup-wrap .recaptchamodail').attr('id', 'recaptchamodail');       
      }
      else if(acttype == 'resetpass') {
         $.pgwModal({
            titleBar: false,
            target: '#rehub-reset-popup',
            mainClassName : 'pgwModal re-user-popup-wrap',
         }); 
         $('.re-user-popup-wrap .rehub-errors').html('');        
      } 
      else if(acttype == 'restrict') {
         $.pgwModal({
            titleBar: false,
            target: '#rehub-restrict-login-popup',
            mainClassName : 'pgwModal re-user-popup-wrap',
         });         
      } 
      else if(acttype == 'url') {
      	if($(this).attr('href')){
      		var gocustomurl = $(this).attr('href');  
      	}else{
      		var gocustomurl = $(this).data('customurl');
      	}
      	window.location.href = gocustomurl;
      }       
      else {
         if($('#rehub-custom-login-url').length > 0){
            var gocustomurl = $('#rehub-custom-login-url').data('customloginurl');
            window.location.href = gocustomurl;
         }else{
            $.pgwModal({
               titleBar: false,
               target: '#rehub-login-popup',
               mainClassName : 'pgwModal re-user-popup-wrap',
            });
            $('.re-user-popup-wrap .rehub-errors').html('');            
         }
      }                
   });

   // Post login form submit 
   $(document).on('submit','.re-user-popup-wrap #rehub_login_form_modal',function(e){
      e.preventDefault();
      var button = $(this).find('button.rehub_main_btn');
      button.addClass('loading');
      $.post(translation.ajax_url, $(this).serialize(), function(data){
         var obj = $.parseJSON(data);
         $('.rehub-login-popup .rehub-errors').html(obj.message);       
         if(obj.error == false){
            if(obj.redirecturl){
              window.setTimeout(function(){window.location.href = obj.redirecturl;},200);
            }
            else{
              window.setTimeout(function(){location.reload()},200);
            }
            button.hide();
         }
         button.removeClass('loading');
      });
   });

   // Post register form
   $(document).on('submit','.re-user-popup-wrap #rehub_registration_form_modal',function(e){
      e.preventDefault();
      var button = $(this).find('button.rehub_main_btn');
      button.addClass('loading');
      $.post(translation.ajax_url, $(this).serialize(), function(data){       
         var obj = $.parseJSON(data);
         $('.rehub-register-popup .rehub-errors').html(obj.message);       
         if(obj.error == false){
            $('.rehub-register-popup').addClass('registration-complete');
            if(obj.redirecturl){
            	window.setTimeout(function(){window.location.href = obj.redirecturl;},4000);
            }
            else{
            	window.setTimeout(function(){location.reload()},4000);
            }
            //button.hide();
         }
         $('.rehub-register-popup').removeClass('registration-complete');
         button.removeClass('loading');       
      });
   });

   // Reset Password
   $(document).on('submit','.re-user-popup-wrap #rehub_reset_password_form_modal',function(e){
      e.preventDefault();
      var button = $(this).find('button.rehub_main_btn');
      button.addClass('loading');
      $.post(translation.ajax_url, $(this).serialize(), function(data){
         var obj = $.parseJSON(data);
         $('.rehub-reset-popup .rehub-errors').html(obj.message);    
         if(obj.error == false){
            window.setTimeout(function(){location.reload()},3000);  
         }
         button.removeClass('loading');
      });
   });

   // drop down for user menu
   $( '.user-ava-intop' ).click(function(e) {
      e.stopPropagation();
      $( this ).parent().find( '.user-dropdown-intop-menu' ).toggleClass('user-dropdown-intop-open');
      $(this).toggleClass('user-ava-intop-open');
   });
   $( '.user-dropdown-intop-menu' ).click(function(e) {
      e.stopPropagation();
   });    
   $( document ).click(function() {
      $( '.user-dropdown-intop-menu' ).removeClass('user-dropdown-intop-open');
      $( '.user-ava-intop' ).removeClass('user-ava-intop-open');
      $( '.re_tax_dropdown' ).removeClass('active');
   }); 

	// Open offer modal
 

	// Send form data
	$('body').on('click', '#rehub_add_offer_form_modal .rehub_main_btn', function(e){
		e.preventDefault();
		var error;
		var button = $(this);
		var ref = button.closest('form').find('input.required');
		var data = button.closest('form').find('input');
		
		// Validate form
        $(ref).each(function() {
            if ($(this).val() == '') {
                var errorfield = $(this);
                $(this).addClass('error').parent('.re-form-group').prepend('<div class="redcolor"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>');
                error = 1;
                $(":input.error:first").focus();
                return;
            }
        });
		
		if(!(error==1)) {
			button.addClass('loading');
			$.ajax({
				type: 'POST',
				url: translation.ajax_url,
				data: data,
				success: function() {
					setTimeout(function(){ button.removeClass('loading'); }, 500);
					$('.rehub-offer-popup').toggleClass('rhhidden');
					$('.rehub-offer-popup-ok').toggleClass('rhhidden');
				},
				error: function(xhr, str) {
					alert('Error: ' + xhr.responseCode);
				}
			});
        }
        return false;		
	}); 

   //Thumbs up function with overall score
   $(document).on("click", ".post_thumbs_wrap .thumbplus:not(.alreadyhot)", function(e){
      e.preventDefault();
      var $this = $(this);
      if ($this.hasClass("restrict_for_guests")) {
        return false;
      }      
      var post_id = $(this).data("post_id");  
      var informer = parseInt($(this).attr("data-informer"));      
      $(this).addClass("loading");            
      $.ajax({
         type: "post",
         url: translation.ajax_url,
         data: "action=hot-count&hotnonce="+translation.hotnonce+"&hot_count=hot&post_id="+post_id,
         success: function(count){
            $this.removeClass("loading"); 
            $this.addClass('alreadyhot').parent().find('.thumbminus').addClass('alreadyhot');      
            informer=informer+1;
            $this.closest('.post_thumbs_wrap').find('#thumbscount' + post_id + '').text(informer);
            $this.attr("data-informer",informer); 
            if($('#wishadded' + post_id + '').length > 0){
               $.simplyToast($('#wishadded' + post_id + '').html(), 'success');
            }                      
         }
      });
      
      return false;
   });

   //Heart function
   $(document).on("click", ".heart_thumb_wrap .alreadyhot.heartplus", function(e){
      e.preventDefault();
      var $this = $(this);
      if ($this.hasClass("restrict_for_guests")) {
        return false;
      }       
      var post_id = $(this).data("post_id");  
      var informer = parseInt($(this).attr("data-informer"));
      var wishlink = $(this).data("wishlink");
      if (typeof $(this).data("wishlink") !== "undefined" && $(this).data("wishlink") !='' && $('.re-favorites-posts').length == 0) {
        window.location.href= $(this).data("wishlink");
        return false;
      }
           
      $(this).addClass("loading");            
      $.ajax({
         type: "post",
         url: translation.ajax_url,
         data: "action=hot-count&hotnonce="+translation.hotnonce+"&hot_count=cold&heart=1&post_id="+post_id,
         success: function(count){
            $this.removeClass("loading"); 
            $this.removeClass('alreadyhot');      
            informer=informer-1;
            $this.closest('.post_thumbs_wrap').find('#thumbscount' + post_id + '').text(informer);
            $this.attr("data-informer",informer);
            if($('#wishremoved' + post_id + '').length > 0){
               $.simplyToast($('#wishremoved' + post_id + '').html(), 'danger');
            }         
         }
      });    
      return false;
   });   

   $(document).on("click", ".post_thumbs_wrap .thumbminus:not(.alreadyhot)", function(e){
      e.preventDefault();
      var $this = $(this);
      if ($this.hasClass("restrict_for_guests")) {
        return false;
      }       
      var post_id = $(this).data("post_id");  
      var informer = $(this).data("informer");      
      $(this).addClass("loading");
      $.ajax({
         type: "post",
         url: translation.ajax_url,
         data: "action=hot-count&hotnonce="+translation.hotnonce+"&hot_count=cold&post_id="+post_id,
         success: function(count){
            $this.removeClass("loading"); 
            $this.addClass('alreadyhot').parent().find('.thumbplus').addClass('alreadyhot');          
            informer=informer-1;
            $this.closest('.post_thumbs_wrap').find('#thumbscount' + post_id + '').text(informer);         
         }
      });    
      return false;
   }); 

   $(document).on("click", ".hotmeter .hotplus:not(.alreadyhot)", function(e){
      e.preventDefault();
      if ($(this).hasClass("restrict_for_guests")) {
        return false;
      }       
      var post_id = $(this).data("post_id");  
      var informer = $(this).data("informer");
      $(this).addClass('alreadyhot').parent().parent().find('.hotminus').addClass('alreadyhot');
      $('#textinfo' + post_id + '').html("<i class='fa fa-spinner fa-spin'></i>");            
      $.ajax({
         type: "post",
         url: translation.ajax_url,
         data: "action=hot-count&hotnonce="+translation.hotnonce+"&hot_count=hot&post_id="+post_id,
         success: function(count){
            $('#textinfo' + post_id + '').html('');       
            informer=informer+1;
            $('#temperatur' + post_id + '').text(informer+"°"); 
            if(informer>translation.max_temp){ informer=translation.max_temp; }            
            if(informer>=0){ 
               $('#scaleperc' + post_id + '').css("width", informer / translation.max_temp * 100+'%').removeClass('cold_bar');
               $('#temperatur' + post_id + '').removeClass('cold_temp'); 
            }
            else {
               $('#scaleperc' + post_id + '').css("width", informer / translation.min_temp * 100+'%');
            }          
         }
      });
      
      return false;
   });

   $(document).on("click", ".hotmeter .hotminus:not(.alreadyhot)", function(e){
      e.preventDefault();
      if ($(this).hasClass("restrict_for_guests")) {
        return false;
      }       
      var post_id = $(this).data("post_id");  
      var informer = $(this).data("informer");
      $(this).addClass('alreadyhot').parent().parent().find('.hotplus').addClass('alreadyhot');
      $('#textinfo' + post_id + '').html("<i class='fa fa-spinner fa-spin'></i>");
      $.ajax({
         type: "post",
         url: translation.ajax_url,
         data: "action=hot-count&hotnonce="+translation.hotnonce+"&hot_count=cold&post_id="+post_id,
         success: function(count){
            $('#textinfo' + post_id + '').html('');          
            informer=informer-1;
            $('#temperatur' + post_id + '').text(informer+"°");
            if(informer<translation.min_temp){ informer=translation.min_temp; } 
            if(informer<0){ 
               $('#scaleperc' + post_id + '').css("width", informer / translation.min_temp * 100+'%').addClass('cold_bar');
               $('#temperatur' + post_id + '').addClass('cold_temp'); 
            }
            else {
               $('#scaleperc' + post_id + '').css("width", informer / translation.max_temp * 100+'%');
            }          
         }
      });
      
      return false;
   });

	$(document).on("click", ".rh-user-favor-shop", function(e){
		e.preventDefault();
		var heart = $(this);
		var user_id = heart.data("user_id");
		heart.find(".favorshop_like").html("<i class='fa fa-spinner fa-spin'></i>");
		
		$.ajax({
			type: "post",
			url: translation.ajax_url,
			data: "action=rh-user-favor-shop&favornonce="+translation.hotnonce+"&rh_user_favorite_shop=&user_id="+user_id,
			success: function(count){
				if( count.indexOf( "already" ) !== -1 )
				{
					var lecount = count.replace("already","");
					if (lecount == 0)
					{
						var lecount = "0";
					}
					heart.find(".favorshop_like").html("<i class='fa fa-heart-o'></i>");
					heart.removeClass("alreadyinfavor");
					heart.find(".count").text(lecount);
				}
				else
				{
					heart.find(".favorshop_like").html("<i class='fa fa-heart'></i>");
					heart.addClass("alreadyinfavor");
					heart.find(".count").text(count);
				}
			}
		});
		
		return false;
	});    

    //AJAX PAGINATION on click button
   	$(document).on('click', '.re_ajax_pagination_btn', function(e){
   		e.preventDefault();
   		var $this = $(this);   		
      	var containerid = $this.data('containerid');
      	var activecontainer = $('#'+containerid);      	
      	var sorttype = $this.data('sorttype');
      	var offset = $this.data('offset');  
      	var filterargs = activecontainer.data('filterargs');
      	var innerargs = activecontainer.data('innerargs');
      	var template = activecontainer.data('template');       	   
		var data = {
		 	'action': 're_filterpost',		 	
		 	'sorttype': sorttype,
		 	'filterargs' : filterargs,
		 	'template' : template, 
		 	'containerid' : containerid,
		 	'offset' : offset, 
		 	'innerargs' : innerargs     
		};
      	$this.parent().find('span').removeClass('active');
      	$this.addClass('active');

	    $.ajax({
	        type: "POST",
	        url: translation.ajax_url,
	        data: data,
	        success: function(response){
				if (response !== 'fail') {
					activecontainer.find('.re_ajax_pagination').remove();					
					if (template == 'query_type3') {
						var $content = $( response);
						activecontainer.find('.masonry_grid_fullwidth').append($content).masonry( 'appended', $content );
					}	
					else{
						activecontainer.append($(response).hide().fadeIn(1000));
					}
			        activecontainer.find('img.lazyimages').each(function(){
			            var source = $(this).attr("data-src");
			            $(this).attr("src", source).css({'opacity': '1'});
			        }); 		        					
				}        
	        }
	    });      	
   	});    

    //AJAX PAGINATION infinite scroll on inview
   	$(document).on('inview', '.re_aj_pag_auto_wrap .re_ajax_pagination_btn', function(e){
   		e.preventDefault();
   		var $this = $(this);   		
      	var containerid = $this.data('containerid');
      	var activecontainer = $('#'+containerid);      	
      	var sorttype = $this.data('sorttype');
      	var offset = $this.data('offset');  
      	var filterargs = activecontainer.data('filterargs');
      	var innerargs = activecontainer.data('innerargs');      	
      	var template = activecontainer.data('template');       	   
		var data = {
		 	'action': 're_filterpost',		 	
		 	'sorttype': sorttype,
		 	'filterargs' : filterargs,
		 	'template' : template, 
		 	'containerid' : containerid,
		 	'offset' : offset,   
		 	'innerargs' : innerargs     
		};
      	$this.parent().find('span').removeClass('active');
      	$this.addClass('active');

	    $.ajax({
	        type: "POST",
	        url: translation.ajax_url,
	        data: data,
	        success: function(response){
				if (response !== 'fail') {
					activecontainer.find('.re_ajax_pagination').remove();	
					if (template == 'query_type3') {
						var $content = $( response);
						activecontainer.find('.masonry_grid_fullwidth').append($content).masonry( 'appended', $content );
					}	
					else{
						activecontainer.append($(response).hide().fadeIn(1000));
					}		
			        activecontainer.find('img.lazyimages').each(function(){
			            var source = $(this).attr("data-src");
			            $(this).attr("src", source).css({'opacity': '1'});
			        }); 		        					
				}        
	        }
	    });      	
   	});     

    //AJAX SORTING PANEL
   	$('.re_filter_panel').on('click', '.re_filtersort_btn:not(.active)', function(e){
   		e.preventDefault();
   		var $this = $(this);   		
      	var containerid = $this.data('containerid');
      	var activecontainer = $('#'+containerid);      	
      	var sorttype = $this.data('sorttype');  
      	var filterargs = activecontainer.data('filterargs');
      	var innerargs = activecontainer.data('innerargs');
      	var template = activecontainer.data('template');       	   
		var data = {
		 	'action': 're_filterpost',		 	
		 	'sorttype': sorttype,
		 	'filterargs' : filterargs,
		 	'template' : template, 
		 	'containerid' : containerid, 
		 	'innerargs' : innerargs     
		};
      	$this.closest('ul').addClass('activeul'); 
      	$this.addClass('re_loadingbefore');     	
      	activecontainer.addClass('sortingloading');

	    $.ajax({
	        type: "POST",
	        url: translation.ajax_url,
	        data: data,
	        success: function(response){
				if (response !== 'fail') {					
					if (template == 'query_type3') {
						var $content = $(response);
						activecontainer.find('.masonry_grid_fullwidth').html('').prepend($content).masonry( 'prepended', $content );
					}	
					else{
						activecontainer.html($(response).hide().fadeIn(1000));
					}
			        activecontainer.find('img.lazyimages').each(function(){
			            var source = $(this).attr("data-src");
			            $(this).attr("src", source).css({'opacity': '1'});
			        }); 		        					
				}   
      			$this.closest('.re_filter_panel').find('span').removeClass('active');
      			$this.removeClass('re_loadingbefore').addClass('active');				
				activecontainer.removeClass('sortingloading'); 
				$this.closest('ul').removeClass('activeul'); 
				if($this.closest('ul').hasClass('re_tax_dropdown')){
					$this.closest('.re_tax_dropdown').find('.rh_choosed_tax').html($this.html()).show();
					$this.closest('.re_tax_dropdown').find('.rh_tax_placeholder').hide();
					$this.closest('.re_filter_panel').find('.re_filter_ul li:first-child span').addClass('active');
				} 
				if($this.closest('ul').hasClass('re_filter_ul')){
					$this.closest('.re_filter_panel').find('.rh_tax_placeholder').show();
					$this.closest('.re_filter_panel').find('.rh_choosed_tax').hide();
				}				  
	        }
	    });      	
   	});  

   //Collapse filters in sort panel
   $('.re_filter_panel').on('click', '.re_filter_ul .re_filtersort_btn.active', function(e) {
         e.preventDefault();
         $(this).closest('.re_filter_panel').find('ul.re_filter_ul span').toggleClass('showfiltermobile');
   });

    //Collapse filters in tabs panel
    $('.rh_tab_links').on('click', 'a.active', function(e) {
        e.preventDefault();
        $(this).closest('.rh_tab_links').find('a').toggleClass('showtabmobile');
    });

    //Collapse filters in wc pro vendor dashboard
    $('.wcv-navigation ul.menu.horizontal').on('click', 'li.active', function(e) {
        e.preventDefault();
        $(this).closest('.menu').find('li').toggleClass('showtabmobile');
    });  

    //Collapse filters in wc pro vendor dashboard
    $('.dokan-dash-sidebar .dokan-dashboard-menu').on('click', 'li.active', function(e) {
        if($(window).width() < 768){
            e.preventDefault();
            $(this).closest('.dokan-dashboard-menu').find('li').toggleClass('showtabmobile');
        }
    });       

    //Collapse filters in tax dropdown
   $('.re_tax_dropdown').on('click', '.label', function(e) {
   		e.stopPropagation();
         e.preventDefault();
         $(this).closest('.re_tax_dropdown').toggleClass('active');
   });    	  	

    //AJAX GET FULL CONTENT
   	$('body').on('click', '.showmefulln', function(e){
   		e.preventDefault();
   		var $this = $(this);   		
      	var postid = $this.data('postid'); 
      	var aj_get_full_enabled = $this.attr('data-enabled'); 	   
		var data = {
		 	'action': 're_getfullcontent',		 	
		 	'postid': postid,    
		};
		var newshead = $this.parent().find('.featured_newscom_left');
		var newscont = $this.parent().find('.newscom_detail');		
		var newsheadfull = $this.parent().find('.newscom_head_ajax');
		var newscontfull = $this.parent().find('.newscom_content_ajax');	
		var newsbtn = $this.parent().find('.newscom_btn_block').html();	
      	var headcontent = $this.parent().find('.newscom_head').html();      	   	      	

      	if(aj_get_full_enabled==1) {
      		newsheadfull.fadeOut(500, function() {
      			newshead.fadeIn(500);
      			$this.attr('data-enabled', 2).removeClass('compress');      			
  			});
      		newscontfull.fadeOut(500, function() {
      			newscont.fadeIn(500);
  			});      		   		   		
      	}
      	else if (aj_get_full_enabled==2){
      		newshead.hide(10);
      		newscont.hide(10);
      		newsheadfull.fadeIn(1000);
      		newscontfull.fadeIn(1000);
      		$this.attr('data-enabled', 1).addClass('compress');
      	}
      	else {
      		$this.addClass('re_loadingafter');
		    $.ajax({
		        type: "POST",
		        url: translation.ajax_url,
		        data: data,
		        success: function(response){
					if (response !== 'fail') {
						newscont.hide(10);
						newshead.hide(10);
						newscontfull.html($(response).hide().fadeIn(1000).append(newsbtn));
						newsheadfull.html($(headcontent).hide().fadeIn(1000));											
					}   
					$this.attr('data-enabled', 1).removeClass('re_loadingafter').addClass('compress');     
		        }
		    });  		        		
      	}      	
   	});

   	//Woocommerce better categories
	$('.product-categories .show-all-toggle').each(function(){
		if( $(this).siblings('ul').length > 0 ) {
			var $toggleIcon = $('<span class="toggle-show-icon"><i class="fa fa-angle-right"></i></span>');

			$(this).siblings('ul').hide();
			if($(this).siblings('ul').is(':visible')){
				$toggleIcon.addClass( 'open' );
				$toggleIcon.html('<i class="fa fa-angle-up"></i>');
			}

			$(this).on( 'click', function(){
				$(this).siblings('ul').toggle( 'fast', function(){
					if($(this).is(':visible')){
						$toggleIcon.addClass( 'open' );
						$toggleIcon.closest('.closed-woo-catlist').removeClass('closed-woo-catlist');
						$toggleIcon.html('<i class="fa fa-angle-up"></i>');
					}else{
						$toggleIcon.removeClass( 'open' );
						$toggleIcon.html('<i class="fa fa-angle-right"></i>');
					}
				});
				return false;
			});
			$(this).append($toggleIcon);
		}
	});

	//Print function
	jQuery.fn.print=function(){var is_chrome = Boolean(window.chrome); if(this.size()>1)return void this.eq(0).print();if(this.size()){var t="printer-"+(new Date).getTime(),o=$("<iframe name='"+t+"'>");o.css("width","1px").css("height","1px").css("position","absolute").css("left","-9999px").appendTo($("body:first"));var i=window.frames[t],e=i.document,n=$("<div>").append("<style>body {-webkit-print-color-adjust: exact;}.printcoupon{max-width: 550px;margin: 20px auto; border: 2px dashed #cccccc;}.printcouponheader{background-color: #eeeeee;padding: 15px; margin-bottom:20px}.printcoupontitle{font-size: 20px;font: 22px/24px Georgia;margin-bottom: 8px;text-transform: uppercase;}.printcoupon_wrap{font-weight: bold;padding: 20px;background-color: #e7f3d6; margin: 0 auto 20px auto;}.expired_print_coupon{font-size:12px; color: #999;}.printcouponcentral, .printcouponheader{text-align: center;}.save_proc_woo_print{margin: 0 auto 20px auto;display: inline-block;position: relative;color: #000000;padding-right: 45px;}.countprintsale{font: bold 70px/70px Arial;}.procprintsale{right: 0;font: bold 36px/35px Tahoma;position: absolute;top: 2px;}.wordprintsale{right: 0;font: 20px Georgia;position: absolute;bottom: 9px;}.printcoupon_wrap {font: bold 20px/24px Arial;padding: 20px;background-color: #e7f3d6;margin: 0 30px;}.printcoupondesc{padding: 30px;}.printcoupondesc span{font: 13px/20px Georgia;}.printimage{float: left;width: 120px;margin: 0 25px 15px 0;}.printimage img{max-width:100%; height:auto}.couponprintend{text-align: center;padding: 20px;border-top: 2px dotted #eeeeee;margin: 0 30px;font: italic 12px Arial; clear:both}.couponprintend span{color: #cc0000;}.storeprint{margin-top:10px;}.storeprint a{text-decoration:none}.printcouponimg{text-align:center; margin:20px auto}.printcouponimg img{max-width:100%; height:auto;}</style>");e.open(),e.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'),e.write("<html>"),e.write("<body>"),e.write("<head>"),e.write("<title>"),e.write(document.title),e.write("</title>"),e.write(n.html()),e.write("</head>"),e.write(this.html()),e.write("</body>"),e.write("</html>"); if (is_chrome) {setTimeout(function(){e.close(),i.focus(),i.print(),o.remove()},254);}else{e.close(),i.focus(),i.print(),setTimeout(function(){o.remove()},6e4);} }};	
	$(document).on("click", "span.printthecoupon", function(e){
		e.preventDefault();
		var printid = $(this).data('printid');
		$("#printcoupon" + printid ).print();
	});

	$(document).on('click', '.rh_gmw_map_in_wcv_profile', function (e) {
		e.preventDefault();
		$('.wcvendor_profile_menu_items li').removeClass('active');
		$('div[role="tabvendor"]').removeClass('active');
		$('#vendor-location').addClass('active');
		$('html, body').stop().animate({
		 'scrollTop': $('#vendor-location').offset().top - 60
		}, 500, 'swing', function () {
		 window.location.hash = '#vendor-location';
		});			
	});

	$('.table_view_charts').on('click', '.re-compare-show-diff', function(e){
	  	if ($(this).is(':checked')){
	     	$(this).closest('.table_view_charts').find('li[class^="row_chart"]').filter(':not(.heading_row_chart)').filter(':not(.row-is-different)').addClass('low-opacity');
	  	} 
	  	else {
	     	$(this).closest('.table_view_charts').find('li[class^="row_chart"]').filter(':not(.heading_row_chart)').filter(':not(.row-is-different)').removeClass('low-opacity');
	  	}     
	});	

	if( $('#content-sticky-panel').length > 0 ){
		$('article.post').waypoint({
  			handler: function(direction) {
  				$('#content-sticky-panel').toggleClass('floating', direction=='down');
  			}, offset: 30
		});	
		var commenttitle = $('#comments .title_comments').first().html();
		if(commenttitle){
			$('#content-sticky-panel ul').append('<li class="top"><a href="#comments">'+commenttitle+'</a></li>');
			$('#comments .title_comments').waypoint({
	  			handler: function(direction) {
	  				$('#content-sticky-panel a').removeClass('active');
	    			$('#content-sticky-panel a[href="#comments"]').addClass('active');
	  			}, offset: 30
			});			
		}
		$('.kc-gotop').hide();
		$('#content-sticky-panel').on('click', '#mobileactivate', function(){
			$('#content-sticky-panel').toggleClass('mobileactive');
		});
		if ($(window).width() < 1300){
			var heightpost = $('article.post').offset().top;
			$('#content-sticky-panel').css('top', heightpost);
		}
	}

	$('#content-sticky-panel a').each(function(){
		$('a[name="'+ this.hash.replace(/#/,"") +'"]').waypoint({
  			handler: function(direction) {
  				$('#content-sticky-panel a').removeClass('active');
    			var corrlink = $(this.element).attr('name');
    			$('#content-sticky-panel a[href="#'+corrlink+'"]').addClass('active');
  			}, offset: 45
		})
	});

    if( $('.sidebar .widget-meta-data-filter').length > 0 ){
        var filtertitle = $('.sidebar .widget-meta-data-filter h3').first().html(); 
        $(".main-side").prepend('<span class="mobile_mdtf_toggle_btn wpsm-button white medium mb25"><i class="fa fa-bars"></i> '+ filtertitle + '</span>');
        $(document).on('click', '.mobile_mdtf_toggle_btn', function (e) {
            e.preventDefault();
            var target = $('.sidebar .widget-meta-data-filter');
            var $target = $(target);
            $('html, body').stop().animate({
                'scrollTop': $target.offset().top - 45
            }, 500, 'swing');
        });       
    }

    if($('.custom-html-widget .wpf_form').length > 0){
        var filtertitle = $('.wpf_form').parent().parent().find($('.title')).html();
        var idwidget = $('.wpf_form').parent().parent().attr('id');
        if(filtertitle){
            $(".main-side").prepend('<span class="mobile_wpf_toggle_btn wpsm-button white medium mb25"><i class="fa fa-bars"></i> '+ filtertitle + '</span>');           
            $(document).on('click', '.mobile_wpf_toggle_btn', function (e) {
                e.preventDefault();
                var target = $('.custom-html-widget .wpf_form');
                var $target = $(target);
                $('html, body').stop().animate({
                    'scrollTop': $target.offset().top - 65
                }, 500, 'swing');
            });        
        }
    }


}); //END Document.ready

// User Rate functions
jQuery(document).on('mouseenter', '.user-rate-active .starrate' , function (e) {
    var rated = jQuery(this);
    var rateditem = jQuery(this).closest('.user-rate');
    var current_rated_count = rated.attr('data-ratecount');
    if( rateditem.hasClass('rated-done') ){
      return false;
    }
    rateditem.find('.starrate').removeClass('active');
    for (i = 1; i <= current_rated_count; i++) {
        rateditem.find('.starrate'+i).addClass('active');
    }
});
jQuery(document).on('mouseleave', '.user-rate-active .starrate' , function (e) {
    var rated = jQuery(this);
    var rateditem = jQuery(this).closest('.user-rate');
    var current_rateddiv = rateditem.attr('data-rate');
    if( rateditem.hasClass('rated-done') ){
      return false;
    }
    rateditem.find('.starrate').removeClass('active');
    for (i = 1; i <= current_rateddiv; i++) {
        rateditem.find('.starrate'+i).addClass('active');
    }
});
jQuery(document).on('click', '.user-rate-active .starrate' , function (e) {
    var rated = jQuery(this);
    var rateditem = jQuery(this).closest('.user-rate');
    var current_rated_count = rated.attr('data-ratecount');    
    if( rateditem.hasClass('rated-done') ){
      return false;
    }
    rateditem.find('.post-norsp-rate').hide();
    rateditem.append('<span class="rehub-rate-load"><i class="fa fa-circle-o-notch fa-spin"></i></span>');
    var post_id = rateditem.attr('data-id');
    var rate_type = rateditem.attr('data-ratetype');
    var numVotes = rateditem.parent().find('.userrating-count').text();
    jQuery.post(translation.ajax_url, { action:'rehub_rate_post' , post:post_id , type:rate_type , value:current_rated_count}, function(data) {
        if(data){
            var post_rateed = '.rate-post-'+post_id;
            jQuery( post_rateed ).addClass('rated-done').attr('data-rate',data);
            for (i = 1; i <= current_rated_count; i++) {
                rateditem.find('.starrate'+i).addClass('active');
            }     
            jQuery(".rehub-rate-load").fadeOut(function () {
                rateditem.parent().find('.userrating-score').html( current_rated_count );
                if( (jQuery(rateditem.parent().find('.userrating-count'))).length > 0 ){
                    numVotes =  parseInt(numVotes)+1;
                    rateditem.parent().find('.userrating-count').html(numVotes);
                }else{
                    rateditem.parent().find('small').hide();
                }
                rateditem.parent().find('strong').html(translation.your_rating);
                rateditem.find('.post-norsp-rate').fadeIn();
            });
        }
    }, 'html');
    return false;
});

// Rate bar annimation
jQuery(function($){
'use strict';  
  $(document).ready(function(){   
    $('.rate_bar_wrap').bind('inview', function(event, visible) {
      if (visible) {
        $('.rate-bar').each(function(){
         $(this).find('.rate-bar-bar').animate({ width: $(this).attr('data-percent') }, 1500 );
         $('.rate_bar_wrap').unbind('inview');
        });
      }
    });

    $('.rate-line').bind('inview', function(event, visible) {
      if (visible) {
        $('.rate-line .line').each(function(){
         $(this).find('.filled').animate({ width: $(this).attr('data-percent') }, 1500 );
         $('.rate-line').unbind('inview');
        });
      }
    });

   $(document).on('inview', '.top_rating_block, .top_table_block, .top_chart', function(event, visible) {
      if (visible) {
        $('.radial-progress').each(function(){
          $(this).find('.circle .mask.full, .circle .fill:not(.fix)').animate({  borderSpacing: $(this).attr('data-rating')*18 }, {
              step: function(now,fx) {
                $(this).css('-webkit-transform','rotate('+now+'deg)'); 
                $(this).css('-moz-transform','rotate('+now+'deg)');
                $(this).css('transform','rotate('+now+'deg)');
              },
              duration:'slow'
          },'linear');

          $(this).find('.circle .fill.fix').animate({  borderSpacing: $(this).attr('data-rating')*36 }, {
              step: function(now,fx) {
                $(this).css('-webkit-transform','rotate('+now+'deg)'); 
                $(this).css('-moz-transform','rotate('+now+'deg)');
                $(this).css('transform','rotate('+now+'deg)');
              },
              duration:'slow'
          },'linear');                   
  
        });
      }
   }); 

  });
});  
  
   
//Scroll To top
var pretimer;
jQuery(window).scroll(function(){
'use strict';

   var postheight = jQuery('.post-inner').height() + jQuery('#main_header').height() - 100;
   if (jQuery(this).scrollTop() > 500) {
      clearTimeout(pretimer); 
      jQuery('#topcontrol, #float-posts-nav, #rh_social_panel_footer').addClass('scrollvisible');
      var refresh=function(){jQuery('#topcontrol, #float-posts-nav').removeClass('scrollvisible');}      
      pretimer=setTimeout(refresh,15000);

   } else {
      jQuery('#topcontrol').removeClass('scrollvisible');
      jQuery('#float-posts-nav').removeClass('scrollvisible');
   }
   if (jQuery(this).scrollTop() > postheight) {
      jQuery('#float-posts-nav').addClass('openedprevnext');
   } else {
      jQuery('#float-posts-nav').removeClass('openedprevnext');
   } 

   if (jQuery('.footer-bottom').length > 0) {
      if (jQuery('#re-compare-panel').length > 0) {
         if(isVisibleOnScroll(jQuery('.footer-bottom'))) {
            jQuery('#re-compare-panel').addClass('collapsed-onscroll');
         }
         else {
            jQuery('#re-compare-panel').removeClass('collapsed-onscroll');
         }
      }
   }

});


jQuery(window).on('load', function(){

   //CAROUSELS
   var makesiteCarousel = function() {
      if(jQuery().carouFredSel) {                 

         jQuery('.top_chart_wrap').each(function() {
            var carousel = jQuery(this).find('.top_chart_carousel');
            var directionrtl = (jQuery('body.rtl').length > 0) ? "right" : "left";
            var windowsize = jQuery(this).width();                      
            if (windowsize <= 280) {
               var passItems = 1;
            } else if (windowsize > 280 && windowsize <= 480) {
               var passItems = 2;               
            } else if (windowsize > 480) {
               var passItems = 4;
            }            
            carousel.carouFredSel({
               circular: false,
               infinite: false,                
               responsive: true,
               direction: directionrtl,
               auto: {
                  play: false
               },
               swipe: {
                  onTouch: true,
                  onMouse: true,
                  onAfter : function () {
                     var items = carousel.triggerHandler("currentVisible");
                     carousel.children().removeClass( "activecol" );
                     items.addClass( "activecol" );
                  }                  
               },               
               items: {
                  height: 'variable',
                  width: 220,  
                  visible   : {
                     min      : 1,
                     max      : passItems
                  },
               },
               scroll : {
                  onAfter : function () {
                     var items = carousel.triggerHandler("currentVisible");
                     carousel.children().removeClass( "activecol" );
                     items.addClass( "activecol" );
                  }          
               },               
               prev: {
                  button: function() {return jQuery(this).parent().parent().parent().children(".top_chart_controls").find(".prev");} 
               },
               next: {
                  button: function() {return jQuery(this).parent().parent().parent().children(".top_chart_controls").find(".next");}
               },
               pagination  : function() {return jQuery(this).parent().parent().parent().children(".top_chart_controls").find(".top_chart_pagination");},
               height: 'variable',
               width: "100%", 
               onCreate: function () {
                  var items = carousel.triggerHandler("currentVisible");
                  items.addClass( "activecol" );
               }                              
            });
         });         

      }
   }   
   table_charts();
   makesiteCarousel(); 
   jQuery(".sticky-cell").parent().each(function() {
      var stickyheight = (jQuery('.re-stickyheader').length > 0) ? jQuery('.re-stickyheader').height() : 0; 
      var length = jQuery(this).closest('.table_view_charts').height() - jQuery(this).height() - stickyheight + jQuery(this).closest('.table_view_charts').offset().top;
      var cell = jQuery(this);
      var width = cell.outerWidth();
      var height = cell.height() + 'px';
      var outerheight = cell.outerHeight() + 'px';
      cell.wrap(function() {
         return '<div class="sticky-wrapper" style="height:'+ outerheight +'"></div>';
      });

      jQuery(window).scroll(function () {
         var scroll = jQuery(this).scrollTop();
        
         if (scroll < jQuery('.table_view_charts').offset().top) {
            cell.closest('.sticky-wrapper').removeClass('is-sticky');
            cell.css({
               'position': '',
               'top': '',
               'width': '',
            });             

         } else if (scroll > length) { 
            cell.closest('.sticky-wrapper').removeClass('is-sticky');
            cell.css({
               'position': '',
               'top': '',
               'width': '',
            });                     
         } else {
            cell.closest('.sticky-wrapper').addClass('is-sticky');
            cell.css({
               'position': 'fixed',
               'top': stickyheight + 'px',
               'width': width
            });
         }
      });
   });  
   jQuery(".table_view_charts").each(function() {
      jQuery(this).removeClass('loading');
   });  

   /* OWL CAROUSEL */
   jQuery(".re_carousel").each(function(){
      jQuery(this).on('initialized.owl.carousel', function(e) {
        jQuery(this).parent().removeClass('loading');
        jQuery(this).find('img.lazyimages').trigger("unveil");
      });
      var carouselplay = (jQuery(this).data('auto')==1) ? true : false;
      var showrow = (jQuery(this).data('showrow') !='') ? jQuery(this).data('showrow') : 4;
      var laizy = (jQuery(this).data('laizy') == 1) ? true : false;
      var navdisable = (jQuery(this).data('navdisable') == 1) ? false : true;
      var loopdisable = (jQuery(this).data('loopdisable') == 1) ? false : true;
      var rtltrue = (jQuery('body').hasClass('rtl')) ? true : false;
      if (jQuery(this).data('fullrow') == 1) {
         var breakpoint = {
            0:{
               items:1,
               nav:true,
            },
            530:{
               items:2,
            },
            730:{
               items:3,
            },
            1024:{
               items:4,
            },                        
            1224:{
               items:showrow,
            }
         }
      }
      else if (jQuery(this).data('fullrow') == 2) {
         var breakpoint = {
            0:{
               items:1,
               nav:true,
            },
            768:{
               items:2,
            },
            1120:{
               items:3,
            },                        
            1224:{
               items:showrow,
            }
         }
      }      
      else {
         var breakpoint = {
            0:{
               items:1,
               nav:true,
            },
            510:{
               items:2,
            },
            600:{
               items:3,
            },            
            1024:{
               items:showrow,
            }
         }
      }         

      jQuery(this).owlCarousel({
      	rtl:rtltrue,
         loop:loopdisable,
         dots:false,
         nav: navdisable,
         lazyLoad: laizy,
         autoplay: carouselplay,
         responsiveClass:true,
         navText :["", ""],
         navClass: ["controls prev","controls next"],
         responsive: breakpoint
      });    
   });     

   var canSlide = true;

    // Setup a callback for the YouTube api to attach video event handlers
   window.onYouTubeIframeAPIReady = function(){
      // Iterate through all videos
      jQuery('.gallery_top_slider iframe').each(function(){
         var slider = jQuery('.gallery_top_slider');
         // Create a new player pointer; "this" is a DOMElement of the player's iframe
         var player = new YT.Player(this, {
            playerVars: {
               autoplay: 0
            }
         });
 
         // Watch for changes on the player
         player.addEventListener("onStateChange", function(state){
            switch(state.data)
            {
               // If the user is playing a video, stop the slider
               case YT.PlayerState.PLAYING:
                  slider.flexslider("stop");
                  canSlide = false;
                  break;
               // The video is no longer player, give the go-ahead to start the slider back up
               case YT.PlayerState.ENDED:
               case YT.PlayerState.PAUSED:
                  slider.flexslider("play");
                  canSlide = true;
                  break;
            }
         });
 
         jQuery(this).data('player', player);
      });
   }          

   //SLIDER
   var flexslidersiteInit = function() {
   if(jQuery().flexslider) {

      jQuery('.featured_slider').each(function() {
         var slider = jQuery(this);
         slider.flexslider({
            animation: "slide",
            selector: ".slides > .slide",
            slideshow: false,  
            start: function(slider) {
               slider.find('img.lazyimages').trigger("unveil");                               
            }             
         });
      });


      jQuery('.blog_slider').each(function() {
         var slider = jQuery(this); 
         var autoplay = jQuery(this).hasClass('autoplayfs') ? true : false;
         slider.flexslider({
            animation: "slide",
            controlNav: false,
            smoothHeight: true,
            slideshow: autoplay,
            start: function(slider) {
               slider.removeClass('loading');
               var first_height = jQuery('.blog_slider .slides li:last-child img').height();
               jQuery('.flex-viewport').height(first_height);
            }      
         });
      }); 
      
      jQuery('.gallery_top_slider').each(function() {
         var tag = document.createElement('script');
         tag.src = "//www.youtube.com/iframe_api";
         var firstScriptTag = document.getElementsByTagName('script')[0];
         firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);         
         var slider = jQuery(this); 
         slider.flexslider({
            animation: "fade",
            controlNav: "thumbnails",
            slideshow: false,
            video: true,
            //useCSS: false, 
            before: function(){                 
               if(!canSlide)
                  slider.flexslider("stop");
            },            
            start: function(slider) {
               slider.find('img.lazyimages').trigger("unveil");               
               slider.removeClass('loading');
               jQuery('.flex-control-thumbs img').each(function() {
                  var widththumb = jQuery(this).width();
                  jQuery(this).height(widththumb);
               });                
            }
         });
         slider.on("click", ".flex-prev, .flex-next, .flex-control-nav", function(){
            canSlide = true;
            jQuery('.gallery_top_slider iframe').each(function(){
               jQuery(this).data('player').pauseVideo();
            });
            if (jQuery('.gallery_top_slider .flex-active-slide iframe').length > 0) {
               jQuery('.gallery_top_slider .flex-active-slide iframe').data('player').playVideo();
            }
         });  
         jQuery(".play3").fitVids();          
      }); 

      jQuery('.main_slider').each(function() {
         var slider = jQuery(this);
         slider.flexslider({
            animation: "slide", 
            start: function(slider) {
               slider.removeClass('loading');
            }                
         });
      });

      jQuery('.rtl .main_slider').each(function() {
         var slider = jQuery(this);
         slider.flexslider({
            animation: "slide",
            rtl: true, 
            start: function(slider) {
               slider.removeClass('loading');
            }                
         });
      });      

      jQuery('.re_thing_slider').each(function() {
         var slider = jQuery(this);
         slider.flexslider({
            animation: "slide", 
            start: function(slider) {
               slider.removeClass('loading');
            }                
         });
      });      

      jQuery('.flexslider').each(function() {
         var slider = jQuery(this);
         slider.flexslider({
            animation: "slide",
            start: function(slider) {
               jQuery( slider ).removeClass( 'loading' );
            }                 
         });
      });                        

   }}

   flexslidersiteInit();   
});

//Check responsive nav pills
jQuery(function() {
   if(jQuery('.responsive-nav-greedy').length > 0){

      var $btnnavgreedy = jQuery('.responsive-nav-greedy .togglegreedybtn');
      var $vlinksgreedy = jQuery('.responsive-nav-greedy .rhgreedylinks');
      var $hlinksgreedy = jQuery('.responsive-nav-greedy .hidden-links');

      var numOfItemsGreedy = 0;
      var totalSpaceGreedy = 0;
      var breakWidthsGreedy = [];

      var greedytimer = function() {
            $hlinksgreedy.addClass('rhhidden');
         };      

      // Get initial state
      $vlinksgreedy.children().width(function(i, w) {
         totalSpaceGreedy += w;
         numOfItemsGreedy += 1;
         breakWidthsGreedy.push(totalSpaceGreedy);
      });

      var availableSpace, numOfVisibleItems, requiredSpace;

      var rh_responsive_pills_check = function() {

      // Get instant state
      availableSpace = $vlinksgreedy.width() - 10;

      numOfVisibleItems = $vlinksgreedy.children().length;
      requiredSpace = breakWidthsGreedy[numOfVisibleItems - 1];

      // There is not enought space
      if (requiredSpace > availableSpace) {
         $vlinksgreedy.children().last().prependTo($hlinksgreedy);
         numOfVisibleItems -= 1;
         rh_responsive_pills_check();
      // There is more than enough space
      } else if (availableSpace > breakWidthsGreedy[numOfVisibleItems]) {
         $hlinksgreedy.children().first().appendTo($vlinksgreedy);
         numOfVisibleItems += 1;
      }
      // Update the button accordingly
      $btnnavgreedy.attr("count", numOfItemsGreedy - numOfVisibleItems);
      if (numOfVisibleItems === numOfItemsGreedy) {
         $btnnavgreedy.addClass('rhhidden');
      } else $btnnavgreedy.removeClass('rhhidden');
      }

      // Window listeners
      jQuery(window).resize(function() {
         rh_responsive_pills_check();
      });

      $btnnavgreedy.on('click', function() {
         $hlinksgreedy.toggleClass('rhhidden');
         clearTimeout(greedytimer);
      });

      $hlinksgreedy.on('mouseleave', function() {
         setTimeout(greedytimer, 2000);
      }).on('mouseenter', function() {
         clearTimeout(greedytimer);
      });      

      rh_responsive_pills_check();
   }
});