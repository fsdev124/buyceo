<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php ob_start(); ?>
<style type="text/css">
<?php if (rehub_option('rehub_logo_pad') !='') :?>
	@media (min-width: 768px){
		header .logo-section{padding: <?php echo rehub_option('rehub_logo_pad') ?>px 0;}		
	}
<?php endif; ?>
<?php if (is_page_template('visual_builder.php')) :?>
	<?php if (vp_metabox('vcr.bg_disable') =='1') :?>body{ background: none #fff}<?php endif; ?>
	<?php if (vp_metabox('vcr.menu_disable') =='1') :?>nav.top_menu, .responsive_nav_wrap{display: none !important;}<?php endif; ?>
	<?php if (vp_metabox('vcr.content_type') == 'full_post_area') :?>.rh-boxed-container.page-template-visual_builder .rh-outer-wrap{width:100%; overflow:hidden}<?php endif; ?>
	
<?php endif; ?>	
<?php if (is_singular('post') && rehub_option('rehub_replace_color') =='1' && rehub_option('color_type_review') =='simple') :?>
	<?php $category = get_the_category($post->ID); $first_cat = $category[0]->term_id; $cat_data = get_option("category_$first_cat");?>
		<?php if (!empty($cat_data['cat_color'])) :?>
			.category-<?php echo $first_cat ;?> .rate-line .filled, .category-<?php echo $first_cat ;?> .rate_bar_wrap .review-top .overall-score, .category-<?php echo $first_cat ;?> .rate-bar-bar{background-color: <?php echo $cat_data['cat_color'];?> !important; color:#fff !important; text-decoration: none;}
			.category-<?php echo $first_cat ;?> .rate_bar_wrap_two_reviews .score_val, .category-<?php echo $first_cat ;?> .rate_bar_wrap_two_reviews .user-review-criteria .score_val{border-color: <?php echo $cat_data['cat_color'];?>}
			.category-<?php echo $first_cat ;?>.user_reviews_view .userstar-rating span:before{color: <?php echo $cat_data['cat_color'];?>}
		<?php endif;?>
<?php endif; ?>
<?php if (rehub_option('rehub_review_color') && rehub_option('color_type_review') =='simple') :?>
	.rate-line .filled, .rate_bar_wrap .review-top .overall-score, .rate-bar-bar, .top_rating_item .score.square_score, .radial-progress .circle .mask .fill{background-color: <?php echo rehub_option('rehub_review_color') ?> ;}
	.meter-wrapper .meter, .rate_bar_wrap_two_reviews .score_val{border-color: <?php echo rehub_option('rehub_review_color') ?>;}
<?php endif; ?>	
<?php if (rehub_option('rehub_review_color_user') && rehub_option('color_type_review') =='simple') :?>
	.user-review-criteria .rate-bar-bar{background-color: <?php echo rehub_option('rehub_review_color_user') ?> ;}
	.userstar-rating span:before{color: <?php echo rehub_option('rehub_review_color_user') ?>;}
	.rate_bar_wrap_two_reviews .user-review-criteria .score_val{border-color: <?php echo rehub_option('rehub_review_color_user') ?>;}
<?php endif; ?>
<?php if (rehub_option('rehub_userreview_multicolor') && rehub_option('color_type_review') =='multicolor') :?>
	.userstar-rating span:before{color: <?php echo rehub_option('rehub_userreview_multicolor') ?>;}
<?php endif; ?>	
<?php if (rehub_option('rehub_enable_menu_shadow') ==1) :?>
	.main-nav{box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.03);}
<?php endif; ?>	
<?php if (rehub_option('header_menuline_type') == 1) :?>
	nav.top_menu > ul > li > a{padding: 6px 12px 10px 12px; font-size: 14px}
<?php elseif (rehub_option('header_menuline_type') == 2) :?>
	nav.top_menu > ul > li > a{padding: 11px 15px 15px 15px; font-size: 17px}
<?php endif; ?>	
<?php if (rehub_option('rehub_nav_font_custom') != '') :?>
	nav.top_menu > ul > li > a{font-size: <?php echo rehub_option('rehub_nav_font_custom');?>px}
<?php endif; ?>	
<?php if (rehub_option('rehub_nav_font_upper') != '') :?>
	nav.top_menu > ul > li > a{text-transform: uppercase;}
<?php endif; ?>	
<?php if (rehub_option('rehub_nav_font_light') != '') :?>
	nav.top_menu > ul > li > a{font-weight: normal;}
<?php endif; ?>
<?php if (rehub_option('rehub_nav_font_border') != '') :?>
	nav.top_menu > ul > li{border:none;}
<?php endif; ?>
<?php if(rehub_option('rehub_nav_font')) : ?>
	.dl-menuwrapper li a, nav.top_menu ul li a, #re_menu_near_logo li, #re_menu_near_logo li {
		font-family:"<?php echo rehub_option('rehub_nav_font'); ?>", trebuchet ms !important;
		font-weight:<?php echo rehub_option('rehub_nav_font_weight'); ?>!important;
		font-style:<?php echo rehub_option('rehub_nav_font_style');?>;
		<?php if(rehub_option('rehub_nav_font_trans') =='1') : ?>text-transform:none;<?php endif; ?>			
	}
<?php endif; ?>	
<?php if(rehub_option('rehub_headings_font')) : ?>
	.priced_block .btn_offer_block,
	.rh-deal-compact-btn,
	.btn_block_part .btn_offer_block,
	.wpsm-button.rehub_main_btn,
	input[type="submit"],
	.woocommerce div.product p.price,
	.rehub_feat_block div.offer_title,
	.rh_wrapper_video_playlist .rh_video_title_and_time .rh_video_title,
	.main_slider .flex-overlay h2,
	.main_slider .flex-overlay a.btn_more,
	.re-line-badge,
	.related_articles ul li > a,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.news_out_tabs .tabs-menu li,
	.cats_def a,
	.btn_more,
	.widget.tabs > ul > li,
	.widget .title,
	.title h1,
	.title h5,
	.small_post blockquote p,
	.related_articles .related_title,
	#comments .title_comments,
	.commentlist .comment-author .fn,
	.commentlist .comment-author .fn a,
	#commentform #submit,
	.media_video > p,
	.rate_bar_wrap .review-top .review-text span.review-header,
	.ap-pro-form-field-wrapper input[type="submit"],
	.vc_btn3,
	.wpsm-numbox.wpsm-style6 span.num,
	.wpsm-numbox.wpsm-style5 span.num,
	.woocommerce ul.product_list_widget li a,
	.widget.better_woocat,
	.re-compare-destin.wpsm-button,
	.rehub-main-font,
	.vc_general.vc_btn3,
	.cegg-list-logo-title, 
	.logo .textlogo,
	.woocommerce .summary .masked_coupon,
	.woocommerce a.woo_loop_btn,
	.woocommerce input.button.alt,
	.woocommerce .checkout-button.button,
	.woocommerce a.add_to_cart_button,
	.woocommerce .single_add_to_cart_button,
	.woocommerce div.product form.cart .button,
	#buddypress input[type="submit"],
	#buddypress input[type="button"],
	#buddypress input[type="reset"],
	#buddypress button.submit,
	.btn_block_part .btn_offer_block,
	.wcv-grid a.button,
	input.gmw-submit,
	#ws-plugin--s2member-profile-submit,
	#rtmedia_create_new_album,
	input[type="submit"].dokan-btn-theme,
	a.dokan-btn-theme,
	.dokan-btn-theme, 
	.woocommerce div.product .single_add_to_cart_button,
	.woocommerce div.product .summary .masked_coupon,
	.woocommerce div.product .summary .price{
		font-family:"<?php echo rehub_option('rehub_headings_font'); ?>", trebuchet ms;
		font-weight:<?php echo rehub_option('rehub_headings_font_weight'); ?>;
		font-style:<?php echo rehub_option('rehub_headings_font_style'); ?>;
		<?php if(rehub_option('rehub_headings_font_upper') =='1') : ?>text-transform:uppercase;<?php endif; ?>			
	}
<?php endif; ?>
<?php if(rehub_option('rehub_body_font')) : ?>
	.news .detail p, article, .small_post > p, .title_star_ajax, .breadcrumb, footer div.f_text, .header-top .top-nav li, .related_articles ul li > a, .commentlist .comment-content p, .sidebar, .prosconswidget, .rehub-body-font, body, .post {
		font-family:"<?php echo rehub_option('rehub_body_font'); ?>", arial !important;
		font-weight:<?php echo rehub_option('rehub_body_font_weight'); ?>!important;
		font-style:<?php echo rehub_option('rehub_body_font_style'); ?> !important;			
	}
<?php endif; ?>	
<?php if(rehub_option('body_font_size')) : ?>
	article {
		font-size:<?php echo intval(rehub_option('body_font_size'));?>px;		
	}
<?php endif; ?>		
<?php if(rehub_option('rehub_custom_color_nav') !='') : ?>
	header .main-nav, .main-nav.dark_style{
		background: none repeat scroll 0 0 <?php echo rehub_option('rehub_custom_color_nav'); ?>!important;
		box-shadow: none;			
	}
	.main-nav{ border-bottom: none;}
	.dl-menuwrapper .dl-menu{margin: 0 !important}
<?php endif; ?>	
<?php if(rehub_option('rehub_custom_color_top') !='') : ?>
	.header_top_wrap{
		background: none repeat scroll 0 0 <?php echo rehub_option('rehub_custom_color_top'); ?>!important;			
	}
	.header-top, .header_top_wrap{ border: none !important}
<?php endif; ?>	
<?php if(rehub_option('rehub_custom_color_top_font') !='') : ?>
	.header_top_wrap .user-ava-intop:after, .header-top .top-nav a, .header-top a.cart-contents, .header_top_wrap .icon-search-onclick:before{
		color: <?php echo rehub_option('rehub_custom_color_top_font'); ?> !important;			
	}
	.header-top .top-nav li{border: none !important;}
<?php endif; ?>			
<?php if(rehub_option('rehub_custom_color_nav_font') !='') : ?>
	.main-nav .user-ava-intop:after, nav.top_menu ul li a, .dl-menuwrapper button i{
		color: <?php echo rehub_option('rehub_custom_color_nav_font'); ?> !important;			
	}
	nav.top_menu > ul > li > a:hover{box-shadow: none;}
<?php endif; ?>	
<?php if (rehub_option('rehub_header_color_background') !='') :?>
	#main_header, .is-sticky .logo_section_wrap{background-color: <?php echo rehub_option('rehub_header_color_background'); ?> !important }
	.header-top{border: none;}
<?php endif; ?>
<?php if (rehub_option('rehub_header_background_image') !='') :?>
	<?php $bg_header_url = rehub_option('rehub_header_background_image'); ?>
	<?php $bg_header_position = (rehub_option('rehub_header_background_position') !='') ? rehub_option('rehub_header_background_position') : 'left'; ?>
	<?php $bg_header_repeat = (rehub_option('rehub_header_background_repeat') !='') ? rehub_option('rehub_header_background_repeat') : 'repeat'; ?>
	#main_header {background-image: url("<?php echo $bg_header_url ?>") ; background-position: <?php echo $bg_header_position ?> top; background-repeat: <?php echo $bg_header_repeat ?>}
<?php endif; ?>			
<?php if(rehub_option('rehub_sidebar_left') =='1') : ?>
	.main-side {float:right;}
	.sidebar{float: left}
<?php endif; ?>
<?php if(rehub_option('rehub_feature_color') !='') : ?>
	.main_slider .pattern {background-color: <?php echo rehub_option('rehub_feature_color'); ?>;}
<?php endif; ?>
<?php if (rehub_option('footer_color_background') !='') :?>
	.footer-bottom{background-color: <?php echo rehub_option('footer_color_background'); ?> !important }
	.footer-bottom .footer_widget{border: none !important}
<?php endif; ?>	
<?php if (rehub_option('footer_background_image') !='') :?>
	<?php $bg_footer_url = rehub_option('footer_background_image'); ?>
	<?php $bg_footer_position = (rehub_option('footer_background_position') !='') ? rehub_option('footer_background_position') : 'left'; ?>
	<?php $bg_footer_repeat = (rehub_option('footer_background_repeat') !='') ? rehub_option('footer_background_repeat') : 'repeat'; ?>
	.footer-bottom{background-image: url("<?php echo $bg_footer_url ?>") ; background-position: <?php echo $bg_footer_position ?> bottom; background-repeat: <?php echo $bg_footer_repeat ?>}
<?php endif; ?>	

/**********MAIN COLOR SCHEME*************/
<?php 
	if (rehub_option('rehub_custom_color')) {
		$maincolor = rehub_option('rehub_custom_color');
	} 
	else {
		if (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
			$maincolor = '#D7541A';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'RETHING') {
			$maincolor = '#B07C01';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'REVENDOR') {
			$maincolor = '#17baae';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'REDOKAN') {
			$maincolor = '#54ae3f';	
		}								
		else{
			$maincolor = '#43c801';			
		}
	}
?>
.widget .title:after{border-bottom: 2px solid <?php echo $maincolor; ?>;}

.rehub-main-color-border, .rh-big-tabs-li.active a, .rh-big-tabs-li:hover a{border-color: <?php echo $maincolor; ?>;}
.wpsm_promobox.rehub_promobox { border-left-color: <?php echo $maincolor; ?>!important; }
.top_rating_block .top_rating_item .rating_col a.read_full, .color_link{ color: <?php echo $maincolor; ?> !important;}
nav.top_menu > ul:not(.off-canvas) > li > a:hover, nav.top_menu > ul:not(.off-canvas) > li.current-menu-item a, .search-header-contents{border-top-color: <?php echo $maincolor; ?>; }

nav.top_menu > ul > li ul{ border-bottom: 2px solid <?php echo $maincolor; ?>; }
.wpb_content_element.wpsm-tabs.n_b_tab .wpb_tour_tabs_wrapper .wpb_tabs_nav .ui-state-active a{ border-bottom: 3px solid <?php echo $maincolor; ?> !important }
.featured_slider:hover .score, .top_chart_controls .controls:hover, article.post .wpsm_toplist_heading:before{border-color:<?php echo $maincolor; ?>;}
.btn_more:hover, .small_post .overlay .btn_more:hover, .tw-pagination .current { border: 1px solid <?php echo $maincolor; ?>; color: #fff }
.wpsm-tabs ul.ui-tabs-nav .ui-state-active a, .rehub_woo_review .rehub_woo_tabs_menu li.current { border-top: 3px solid <?php echo $maincolor; ?>; }
.wps_promobox { border-left: 3px solid <?php echo $maincolor; ?>; }
.gallery-pics .gp-overlay {  box-shadow: 0 0 0 4px <?php echo $maincolor; ?> inset; }
.post .rehub_woo_tabs_menu li.current, .woocommerce div.product .woocommerce-tabs ul.tabs li.active{ border-top:2px solid <?php echo $maincolor; ?>;}
.rething_item a.cat{border-bottom-color: <?php echo $maincolor; ?>}
nav.top_menu ul li ul { border-bottom: 2px solid <?php echo $maincolor; ?>; }
.widget.deal_daywoo{border: 3px solid <?php echo $maincolor; ?>; padding: 20px; background: #fff; }
.deal_daywoo .wpsm-bar-bar{background-color: <?php echo $maincolor; ?> !important}

/*BGS*/
#buddypress div.item-list-tabs ul li.selected a span,
#buddypress div.item-list-tabs ul li.current a span,
#buddypress div.item-list-tabs ul li a span,
.user-profile-div .user-menu-tab > li.active > a,
.user-profile-div .user-menu-tab > li.active > a:focus,
.user-profile-div .user-menu-tab > li.active > a:hover,
.slide .news_cat a,
.news_in_thumb:hover .news_cat a,
.news_out_thumb:hover .news_cat a,
.col-feat-grid:hover .news_cat a,
.alphabet-filter .return_to_letters span,
.carousel-style-deal .re_carousel .controls,
.re_carousel .controls:hover,
.openedprevnext .postNavigation a,
.postNavigation a:hover,
.top_chart_pagination a.selected,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,
.flex-control-paging li a.flex-active,
.flex-control-paging li a:hover,
.widget_edd_cart_widget .edd-cart-number-of-items .edd-cart-quantity,
.btn_more:hover,
.news_out_tabs > ul > li:hover,
.news_out_tabs > ul > li.current,
.featured_slider:hover .score,
#bbp_user_edit_submit,
.bbp-topic-pagination a,
.bbp-topic-pagination a,
.widget.tabs > ul > li:hover,
.custom-checkbox label.checked:after,
.slider_post .caption,
ul.postpagination li.active a,
ul.postpagination li:hover a,
ul.postpagination li a:focus,
.top_theme h5 strong,
.re_carousel .text:after,
.widget.tabs .current,
#topcontrol:hover,
.main_slider .flex-overlay:hover a.read-more,
.rehub_chimp #mc_embed_signup input#mc-embedded-subscribe, 
#rank_1.top_rating_item .rank_count, 
#toplistmenu > ul li:before,
.rehub_chimp:before,
.wpsm-members > strong:first-child,
.r_catbox_btn,
.wpcf7 .wpcf7-submit,
.rh_woocartmenu-icon,
.comm_meta_wrap .rh_user_s2_label,
.wpsm_pretty_hover li:hover,
.wpsm_pretty_hover li.current,
.rehub-main-color-bg,
.togglegreedybtn:after,
.rh-bg-hover-color:hover .news_cat a,
.rh_wrapper_video_playlist .rh_video_currently_playing, 
.rh_wrapper_video_playlist .rh_video_currently_playing.rh_click_video:hover,
.rtmedia-list-item .rtmedia-album-media-count,
.tw-pagination .current,
.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,
.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover,
.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover,
#ywqa-submit-question{ background: <?php echo $maincolor;?>;}
@media (max-width: 767px) {
	.postNavigation a{ background: <?php echo $maincolor; ?>; }
}

/*color*/
a, 
.carousel-style-deal .deal-item .priced_block .price_count ins, 
nav.top_menu ul li.menu-item-has-children ul li.menu-item-has-children > a:before, 
.top_chart_controls .controls:hover,
.flexslider .fa-pulse,
.footer-bottom .widget .f_menu li a:hover,
.comment_form h3 a,
.bbp-body li.bbp-forum-info > a:hover,
.bbp-body li.bbp-topic-title > a:hover,
#subscription-toggle a:before,
#favorite-toggle a:before,
.aff_offer_links .aff_name a,
.rh-deal-price,
.commentlist .comment-content small a,
.related_articles .title_cat_related a,
article em.emph,
.campare_table table.one td strong.red,
.sidebar .tabs-item .detail p a,
.category_tab h5 a:hover,
.footer-bottom .widget .title span,
footer p a,
.welcome-frase strong, 
article.post .wpsm_toplist_heading:before, 
.post a.color_link,
.categoriesbox:hover h3 a:after,
.bbp-body li.bbp-forum-info > a,
.bbp-body li.bbp-topic-title > a,
.widget .title i,
.woocommerce-MyAccount-navigation ul li.is-active a,
.category-vendormenu li.current a,
.deal_daywoo .title,
.rehub-main-color,
.wpsm_pretty_colored ul li.current a,
.wpsm_pretty_colored ul li.current,
.rh-heading-hover-color:hover h2 a,
.rh-heading-hover-color:hover h3 a,
.rh-heading-hover-color:hover h4 a,
.rh-heading-hover-color:hover h5 a,
.rh-heading-icon:before{ color: <?php echo $maincolor; ?>; }

<?php if (rehub_option('rehub_color_link')) :?>
	a{color: <?php echo rehub_option('rehub_color_link') ?>;}
<?php endif; ?>

/**********SECONDARY COLOR SCHEME*************/
<?php 
	if (rehub_option('rehub_sec_color')) {
		$seccolor = rehub_option('rehub_sec_color');
	} 
	else {
		if (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
			$seccolor = '#44AEFF';	
		}			
		else{
			$seccolor = '#111';			
		}
		
	}
?>
span.re_filtersort_btn:hover, 
span.active.re_filtersort_btn, 
.page-link > span:not(.page-link-title), 
.postimagetrend .title, .widget.widget_affegg_widget .title, 
.widget.top_offers .title, 
header .header_first_style .search form.search-form [type="submit"], 
header .header_eight_style .search form.search-form [type="submit"],
.more_post a, 
.more_post span, 
.filter_home_pick span.active, 
.filter_home_pick span:hover, 
.filter_product_pick span.active,
.filter_product_pick span:hover,
.rh_tab_links a.active, 
.rh_tab_links a:hover, 
.wcv-navigation ul.menu li.active, 
.wcv-navigation ul.menu li:hover a, 
header .header_seven_style .search form.search-form [type="submit"],
.rehub-sec-color-bg,
#buddypress div.item-list-tabs#subnav ul li a:hover, 
#buddypress div.item-list-tabs#subnav ul li.current a, 
#buddypress div.item-list-tabs#subnav ul li.selected a{ background: <?php echo $seccolor ?> !important; color: #fff !important;}
.widget.widget_affegg_widget .title:after, .widget.top_offers .title:after, .vc_tta-tabs.wpsm-tabs .vc_tta-tab.vc_active, .vc_tta-tabs.wpsm-tabs .vc_tta-panel.vc_active .vc_tta-panel-heading{border-top-color: <?php echo $seccolor ?> !important;}  
.page-link > span:not(.page-link-title){border: 1px solid <?php echo $seccolor ?>;}  
.page-link > span:not(.page-link-title), .header_first_style .search form.search-form [type="submit"] i{color:#fff !important;}
.rh_tab_links a.active,
.rh_tab_links a:hover,
.rehub-sec-color-border{border-color: <?php echo $seccolor ?>}
.rh_wrapper_video_playlist .rh_video_currently_playing, .rh_wrapper_video_playlist .rh_video_currently_playing.rh_click_video:hover {background-color: <?php echo $seccolor; ?>;box-shadow: 1200px 0 0 <?php echo $seccolor; ?> inset;}	
.rehub-sec-color{color: <?php echo $seccolor ?>}	
<?php if (REHUB_NAME_ACTIVE_THEME == 'REPICK'):?>
.rehub_chimp{background-color: <?php echo $seccolor; ?>;border-color: <?php echo $seccolor; ?>;}
<?php endif;?>

/**********BUTTON COLOR SCHEME*************/
<?php 
	$boxshadow = '';
	if (rehub_option('rehub_btnoffer_color')) {
		$btncolor = rehub_option('rehub_btnoffer_color');
	} 
	else {
		if (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
			$btncolor = '#D7541A';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'RETHING') {
			$btncolor = '#B07C01';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'REWISE') {
			$btncolor = '#43c801';	
		}						
		else{
			$btncolor = '#43c801';			
		}
	}
?>
<?php 	
	if (REHUB_NAME_ACTIVE_THEME == 'REWISE' || rehub_option('enable_smooth_btn') == 1):?>
		<?php $boxshadow = hex2rgba($btncolor, 0.25);?>
		.price_count, .rehub_offer_coupon, #buddypress .dir-search input[type=text], .gmw-form-wrapper input[type=text], .gmw-form-wrapper select, .rh_post_layout_big_offer .priced_block .btn_offer_block, #buddypress a.button{border-radius: 100px}
		.news .priced_block .price_count, .blog_string  .priced_block .price_count, .main_slider .price_count{margin-right: 5px}
		.right_aff .priced_block .btn_offer_block, .right_aff .priced_block .price_count{border-radius: 0 !important}
<?php endif;?>
/*woo style btn*/
.woocommerce .summary .masked_coupon,
.woocommerce a.woo_loop_btn,
.woocommerce input.button.alt,
.woocommerce .checkout-button.button,
.woocommerce a.add_to_cart_button,
.woocommerce-page a.add_to_cart_button,
.woocommerce .single_add_to_cart_button,
.woocommerce div.product form.cart .button,
.priced_block .btn_offer_block,
.priced_block .button, 
.rh-deal-compact-btn, 
input.mdf_button, 
#buddypress input[type="submit"], 
#buddypress input[type="button"], 
#buddypress input[type="reset"], 
#buddypress button.submit,
.btn_block_part .btn_offer_block,
.wpsm-button.rehub_main_btn,
.wcv-grid a.button,
input.gmw-submit,
#ws-plugin--s2member-profile-submit,
#rtmedia_create_new_album,
input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme 
{ background: none <?php echo $btncolor ?> !important; 
	color: #fff !important; 
	border:none !important;
	text-decoration: none !important; 
	outline: 0;  
	<?php if($boxshadow) :?>
		border-radius: 100px !important;
		box-shadow: -1px 6px 19px <?php echo $boxshadow;?> !important;
	<?php else:?>
		border-radius: 0 !important;
		box-shadow: 0 2px 2px #E7E7E7 !important;
	<?php endif; ?>
}

.woocommerce a.woo_loop_btn:hover,
.woocommerce input.button.alt:hover,
.woocommerce .checkout-button.button:hover,
.woocommerce a.add_to_cart_button:hover,
.woocommerce-page a.add_to_cart_button:hover,
.woocommerce a.single_add_to_cart_button:hover,
.woocommerce-page a.single_add_to_cart_button:hover,
.woocommerce div.product form.cart .button:hover,
.woocommerce-page div.product form.cart .button:hover,
.priced_block .btn_offer_block:hover, 
.wpsm-button.rehub_main_btn:hover, 
#buddypress input[type="submit"]:hover, 
#buddypress input[type="button"]:hover, 
#buddypress input[type="reset"]:hover, 
#buddypress button.submit:hover, 
.small_post .btn:hover,
.ap-pro-form-field-wrapper input[type="submit"]:hover,
.btn_block_part .btn_offer_block:hover,
.wcv-grid a.button:hover,
#ws-plugin--s2member-profile-submit:hover,
input[type="submit"].dokan-btn-theme:hover, a.dokan-btn-theme:hover, .dokan-btn-theme:hover{ background: none <?php echo $btncolor ?> !important;color: #fff !important; opacity: 0.8; box-shadow: none !important; border-color: transparent;}

.woocommerce a.woo_loop_btn:active,
.woocommerce .button.alt:active,
.woocommerce .checkout-button.button:active,
.woocommerce a.add_to_cart_button:active,
.woocommerce-page a.add_to_cart_button:active,
.woocommerce a.single_add_to_cart_button:active,
.woocommerce-page a.single_add_to_cart_button:active,
.woocommerce div.product form.cart .button:active,
.woocommerce-page div.product form.cart .button:active, 
.wpsm-button.rehub_main_btn:active, 
#buddypress input[type="submit"]:active, 
#buddypress input[type="button"]:active, 
#buddypress input[type="reset"]:active, 
#buddypress button.submit:active,
.ap-pro-form-field-wrapper input[type="submit"]:active,
.btn_block_part .btn_offer_block:active,
.wcv-grid a.button:active,
#ws-plugin--s2member-profile-submit:active,
input[type="submit"].dokan-btn-theme:active, a.dokan-btn-theme:active, .dokan-btn-theme:active{ background: none <?php echo $btncolor ?> !important; box-shadow: none; top:2px;color: #fff !important;}

.re_thing_btn .rehub_offer_coupon.masked_coupon:after{border: 1px dashed <?php echo $btncolor ?>; border-left: none;}
.re_thing_btn.continue_thing_btn a, .re_thing_btn .rehub_offer_coupon.not_masked_coupon{color: <?php echo $btncolor ?> !important;}
.re_thing_btn a, .re_thing_btn .rehub_offer_coupon {background-color: <?php echo $btncolor ?>; border: 1px solid <?php echo $btncolor ?>;}
.main_slider .re_thing_btn a, .widget_merchant_list .buttons_col{background-color: <?php echo $btncolor ?> !important;}
.re_thing_btn .rehub_offer_coupon {border-style: dashed;}
<?php if(rehub_option('rehub_btnoffer_color_hover') !='') : ?>
	.re_thing_btn a:hover, .re_thing_btn.continue_thing_btn a:hover, .woocommerce .summary .masked_coupon:hover, .woocommerce a.woo_loop_btn:hover, .woocommerce input.button.alt:hover, .woocommerce .checkout-button.button:hover, .woocommerce a.add_to_cart_button:hover, .woocommerce a.single_add_to_cart_button:hover, .woocommerce div.product form.cart .button:hover{background-color:<?php echo rehub_option('rehub_btnoffer_color_hover') ?>; border: 1px solid <?php echo rehub_option('rehub_btnoffer_color_hover') ?>; color: #fff !important}
	.rehub_offer_coupon:hover{border: 1px dashed <?php echo rehub_option('rehub_btnoffer_color_hover') ?>; }
	.rehub_offer_coupon:hover i.fa{ color: <?php echo rehub_option('rehub_btnoffer_color_hover') ?>}
	.re_thing_btn .rehub_offer_coupon.not_masked_coupon:hover{color: <?php echo rehub_option('rehub_btnoffer_color_hover') ?> !important}
<?php endif; ?>
.deal_daywoo .price{color: <?php echo $btncolor ?>}

<?php if(rehub_option('enable_adsense_opt') =='1') : ?>
	@media screen and (min-width: 1100px) {
	.rh-boxed-container .rh-outer-wrap{width: 1120px}
	.centered-container .vc_col-sm-12 > * > .wpb_wrapper, .vc_section .vc_row, .rh-container, .content{width: 1080px; }
	.vc_row.vc_rehub_container > .vc_col-sm-8, .main-side:not(.full_width){width: 755px}
	.vc_row.vc_rehub_container>.vc_col-sm-4, .sidebar, .side-twocol{width: 300px}
	.side-twocol .columns {height: 200px}
	.main_slider.flexslider .slides .slide{ height: 418px; line-height: 418px}
	.main_slider.flexslider{height: 418px}	
	.main-side, .gallery-pics{width:728px;}
	.main_slider.flexslider{width: calc(100% - 325px);}
	.main_slider .flex-overlay h2{ font-size: 36px; line-height: 34px}
	.offer_grid .offer_thumb{ height: 130px}
	.offer_grid .offer_thumb img, .offer_grid figure img{max-height: 130px}
	header .logo { max-width: 300px;}	
	.rh_video_playlist_column_full .rh_container_video_playlist{ width: 320px !important}
  	.rh_video_playlist_column_full .rh_wrapper_player {width: calc(100% - 320px) !important;}
  	.woocommerce .full_width div.product div.images figure .rh_table_image{height: 300px}
	}
<?php endif; ?>	

<?php if(rehub_option('badge_color_1') !='') : ?>
	.re-starburst.badge_1, .re-starburst.badge_1 span, .re-line-badge.badge_1, .re-ribbon-badge.badge_1 span{background: <?php echo rehub_option('badge_color_1')?>;}
	.table_view_charts .top_chart_item.badge_1{border-top: 1px solid <?php echo rehub_option('badge_color_1')?>;}
	.re-line-badge.re-line-table-badge.badge_1:before{border-top-color: <?php echo rehub_option('badge_color_1')?>}
	.re-line-badge.re-line-table-badge.badge_1:after{border-bottom-color: <?php echo rehub_option('badge_color_1')?>}
<?php endif;?>
<?php if(rehub_option('badge_color_2') !='') : ?>
	.re-starburst.badge_2, .re-starburst.badge_2 span, .re-line-badge.badge_2, .re-ribbon-badge.badge_2 span{background: <?php echo rehub_option('badge_color_2')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_2, .table_view_charts .top_chart_item.ed_choice_col.badge_2 li:first-child:before, .table_view_charts .top_chart_item.ed_choice_col.badge_2 > ul > li:last-child:before{border-top: 1px solid <?php echo rehub_option('badge_color_2')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_2 > ul > li:last-child{border-bottom:1px solid <?php echo rehub_option('badge_color_2')?>;}
	.re-line-badge.re-line-table-badge.badge_2:before{border-top-color: <?php echo rehub_option('badge_color_2')?>}
	.re-line-badge.re-line-table-badge.badge_2:after{border-bottom-color: <?php echo rehub_option('badge_color_2')?>}
<?php endif;?>
<?php if(rehub_option('badge_color_3') !='') : ?>
	.re-starburst.badge_3, .re-starburst.badge_3 span, .re-line-badge.badge_3, .re-ribbon-badge.badge_3 span{background: <?php echo rehub_option('badge_color_3')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_3, .table_view_charts .top_chart_item.ed_choice_col.badge_3 li:first-child:before, .table_view_charts .top_chart_item.ed_choice_col.badge_3 > ul > li:last-child:before{border-top: 1px solid <?php echo rehub_option('badge_color_3')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_3 > ul > li:last-child{border-bottom:1px solid <?php echo rehub_option('badge_color_3')?>;}
	.re-line-badge.re-line-table-badge.badge_3:before{border-top-color: <?php echo rehub_option('badge_color_3')?>}
	.re-line-badge.re-line-table-badge.badge_3:after{border-bottom-color: <?php echo rehub_option('badge_color_3')?>}
<?php endif;?>
<?php if(rehub_option('badge_color_4') !='') : ?>
	.re-starburst.badge_4, .re-starburst.badge_4 span, .re-line-badge.badge_4, .re-ribbon-badge.badge_4 span{background: <?php echo rehub_option('badge_color_4')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_4, .table_view_charts .top_chart_item.ed_choice_col.badge_4 li:first-child:before, .table_view_charts .top_chart_item.ed_choice_col.badge_4 > ul > li:last-child:before{border-top: 1px solid <?php echo rehub_option('badge_color_4')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_4 > ul > li:last-child{border-bottom:1px solid <?php echo rehub_option('badge_color_4')?>;}
	.re-line-badge.re-line-table-badge.badge_4:before{border-top-color: <?php echo rehub_option('badge_color_4')?>}
	.re-line-badge.re-line-table-badge.badge_4:after{border-bottom-color: <?php echo rehub_option('badge_color_4')?>}
<?php endif;?>

<?php if (rehub_option('rehub_color_background') ) :?>
	<?php $bg_url = (rehub_option('rehub_background_image') !='') ? 'background-image: url("'.rehub_option('rehub_background_image').'");' : 'background-image:none';?>
	<?php $bg_repeat = (rehub_option('rehub_background_repeat') !='') ? 'background-repeat:'.rehub_option('rehub_background_repeat').';' : '';?>
	<?php $bg_position = (rehub_option('rehub_background_position') !='') ? rehub_option('rehub_background_position') : 'left';?>	
	<?php $bg_offset = (rehub_option('rehub_background_offset') !='') ? rehub_option('rehub_background_offset') : '0';?>	
	<?php $bg_fixed = (rehub_option('rehub_background_fixed') !='') ? 'background-attachment:fixed;' : '';?>	
	<?php $bg_color = rehub_option('rehub_color_background') ?>
	<?php $bg_sized = (rehub_option('rehub_sized_background') !='') ? 'background-size:cover;' : '';?>	
	body, body.dark_body{background-color: <?php echo $bg_color ?>; background-position: <?php echo $bg_position ?> <?php echo $bg_offset ?>px; <?php echo $bg_repeat; ?><?php echo $bg_url; ?><?php echo $bg_fixed; ?><?php echo $bg_sized; ?>}
<?php endif; ?>	
<?php if (rehub_option('rehub_branded_bg_url') ) :?>
	<?php $bg_branded_url = rehub_option('rehub_branded_background_image'); ?>
	#branded_bg {height: 100%;left: 0;position: fixed;top: 0;width: 100%;z-index: 0;}
	footer, .top_theme, .content, .footer-bottom, header { position: relative; z-index: 1 }
<?php endif; ?>	
<?php if(rehub_option('rehub_enable_fullwith_layout') ==1) : ?>
	@media (min-width:1600px){ 
		.rh-boxed-container .rh-outer-wrap{width: 1580px}
		.rh-container, .content{width:1530px;} 
		.centered-container .vc_col-sm-12 > * > .wpb_wrapper, .vc_section .vc_row{max-width:1530px;}
		.sidebar, .side-twocol, .vc_row.vc_rehub_container > .vc_col-sm-4{ width: 336px} 
		.vc_row.vc_rehub_container > .vc_col-sm-8, .main-side:not(.full_width), .main_slider.flexslider{width:1170px;} 
	}
<?php endif; ?>	
<?php if (REHUB_NAME_ACTIVE_THEME == 'REHUB' || REHUB_NAME_ACTIVE_THEME == 'RECASH') :?>
	@media(min-width: 1224px) {
		.single-post .full_width > article.post, single-product .full_width > article.post{padding: 32px}
		.title_single_area.full_width{margin: 25px 32px 0 32px;}	
		.main-side .title_single_area.full_width{margin: 0;}
		.full_width .wpsm-comptable td img{padding:5px}
	}
<?php endif; ?>	
<?php if(rehub_option('rehub_bpheader_image') !='') : ?>
	#bprh-full-header-image{background-image: url("<?php echo rehub_option('rehub_bpheader_image'); ?>");background-position:center top;background-repeat:no-repeat;background-size:cover;}
<?php endif; ?>	

</style>
<?php 
	$dynamic_css = ob_get_contents();
	ob_end_clean();
	if (function_exists('rehub_quick_minify')) {
		echo rehub_quick_minify($dynamic_css);
	}
	else {echo $dynamic_css;}
?>