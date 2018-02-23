<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}?>
<h2>
<a href="<?php echo get_the_permalink(); ?>">
<?php echo rehub_truncate_title(65, get_the_ID());?>                                  
</a>
</h2>