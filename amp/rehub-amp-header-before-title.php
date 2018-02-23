<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php echo re_badge_create('labelsmall', $this->ID)?>
<?php 	
$post_id = $this->ID;
if(rehub_option('exclude_cat_meta') != 1){ 
	echo '<div class="rh-cat-list-title">';
	if ('post' == get_post_type($post_id)) {
		$categories = get_the_category($post_id);
		$separator = '';
		$output = '';
		if ( ! empty( $categories ) ) {
		    foreach( $categories as $category ) {
		        $output .= '<a class="rh-cat-label-title rh-cat-'.$category->term_id.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'rehub_framework' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
		    }
		    echo trim( $output, $separator );
		}
		if(rehub_option('enable_brand_taxonomy') == 1){ 
			$dealcats = wp_get_post_terms($post_id, 'dealstore', array("fields" => "all"));	
			if( ! empty( $dealcats ) && ! is_wp_error( $dealcats ) ) {
				foreach( $dealcats as $dealcat ) {
			        echo '<a class="rh-cat-label-title rh-dealstore-cat rh-cat-'.$dealcat->term_id.'" href="' . esc_url( get_term_link( $dealcat->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'rehub_framework' ), $dealcat->name ) ) . '">' . esc_html( $dealcat->name ) . '</a>' . $separator;						
				}
			}								
		}		
	}
	echo '</div>';
}
?>