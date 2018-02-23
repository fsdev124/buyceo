<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="wpsm_arrowlist wpsm_pretty_list small_gap_list wpsm_pretty_colored darklink mb35 clearfix">
	<ul>
		<?php $i=0; 
		foreach ( $pages as $page ) {$i ++;
			echo '<li class="' . ( ( $bp->action_variables[0] == $page->post_name ) ? 'current' : '' ) . '">
                <a href="' . esc_url( bp_get_group_permalink( $bp->groups->current_group ) . $page_slug . '/' . $page->post_name ) . '">'
			     . stripslashes( $page->post_title ) .
			     '</a>
            </li>';
		} ?>
	</ul>
</div>

<?php do_action( 'bpge_template_display_gpages_nav_after', $pages ); ?>