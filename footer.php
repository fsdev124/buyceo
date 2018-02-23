<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
	<?php if(rehub_option('rehub_ads_infooter') != '') : ?><div class="rh-container mediad_footer"><div class="clearfix"></div><div class="mediad megatop_mediad"><?php echo do_shortcode(rehub_option('rehub_ads_infooter')); ?></div><div class="clearfix"></div></div><?php endif; ?>
	<?php 

		$footer_style = (rehub_option('footer_style') == '1') ? ' white_style' : ' dark_style';
		$footer_bottom = (rehub_option('footer_style_bottom') == '1') ? 'white_style' : 'dark_style';    
	?>
	<?php if(rehub_option('rehub_footer_widgets')) : ?>
	<div class="footer-bottom<?php echo $footer_style;?>">
		<div class="rh-container clearfix">
			<div class="rh-flex-eq-height col_wrap_three">
				<div class="footer_widget col_item">
					<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
						<?php dynamic_sidebar( 'sidebar-2' ); ?>
					<?php else : ?>
						<p><?php _e('No widgets added. You can disable footer widget area in theme options - footer options', 'rehub_framework'); ?></p>
					<?php endif; ?> 
				</div>
				<div class="footer_widget col_item">
					<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
						<?php dynamic_sidebar( 'sidebar-3' ); ?>
					<?php endif; ?> 
				</div>
				<div class="footer_widget col_item last">
					<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
						<?php dynamic_sidebar( 'sidebar-4' ); ?>
					<?php endif; ?> 
				</div>
			</div>		
		</div>
	</div>
	<?php endif; ?>
	<footer id='theme_footer' class="<?php echo $footer_bottom;?>">
		<div class="rh-container clearfix">
			<div class="footer_most_bottom">
				<div class="f_text">
					<?php if(rehub_option('rehub_footer_text')) : ?>
						<span class="f_text_span"><?php echo rehub_kses(rehub_option('rehub_footer_text')); ?></span>
					<?php endif; ?>
					<?php if(rehub_option('rehub_footer_logo')) : ?><div class="floatright ml15 mr15 mobilecenterdisplay disablefloatmobile"><img src="<?php echo rehub_option('rehub_footer_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>" /></div><?php endif; ?>	
				</div>		
			</div>
		</div>
	</footer>
	<!-- FOOTER -->
</div><!-- Outer End -->
<?php if(rehub_option('rehub_analytics')) : ?><?php echo rehub_option('rehub_analytics'); ?><?php endif; ?>
<span class="rehub_scroll" id="topcontrol" data-scrollto="#top_ankor"><i class="fa fa-chevron-up"></i></span>
<?php if(rehub_option('rehub_disable_social_footer') !='1' && is_singular('post'))  : ?>
	<div id="rh_social_panel_footer">
		<?php echo rehub_social_inimage('flat'); ?>
	</div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>