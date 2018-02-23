jQuery(document).ready(function($) {
   'use strict';	

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

   var affcoupontrigger = GetURLParameter("codetext");
   if(affcoupontrigger){
      var $change_mecode = $(".rehub_offer_coupon.masked_coupon:not(.expired_coupon)[data-codetext='" + affcoupontrigger +"']");
      var couponcode = $change_mecode.data('clipboard-text'); 
      var coupondestination = $change_mecode.data('dest');
      $change_mecode.removeClass('masked_coupon woo_loop_btn coupon_btn btn_offer_block wpsm-button').addClass('not_masked_coupon').html( '<i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text">'+ decodeURIComponent(couponcode) +'</span>' );
      $change_mecode.closest('.reveal_enabled').removeClass('reveal_enabled');      
      $.pgwModal({
         titleBar: false,
         mainClassName : 'pgwModal coupon-reveal-popup',
         content: '<div class="coupon_code_in_modal"><div class="re_title_inmodal">' + coupvars.coupontextready + '</div><div class="add_modal_coupon"><div class="text_copied_coupon">' + coupvars.coupontextcopied + '</div></div><div class="coupon_modal_coupon"><input type="text" class="code" value="' + decodeURIComponent(couponcode) + '" readonly=""><span class="buttoncpd"><i class="fa fa-check-square"></i></span></div><div class="add_modal_coupon">' + coupvars.coupongoto + '<a href="' + coupondestination + '" target="_blank" rel="nofollow">' + coupvars.couponwebsite + '</a>' + coupvars.couponuseoffer + '<br>' + coupvars.couponorcheck + '</div></div>',
      });
   };

});