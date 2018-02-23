<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php  
    $re_egg_id = get_post_meta( get_the_ID(), '_affegg_egg_id', true );
    $re_egg_product_id = get_post_meta( get_the_ID(), '_affegg_product_id', true );
    $item = array(
        'id' => $re_egg_product_id,
        'orig_url' => $aff_url_exist,
        'egg_id' => $re_egg_id,
    );
    $out = (class_exists('\Keywordrush\AffiliateEgg\AffiliateEgg')) ? Keywordrush\AffiliateEgg\LinkHandler::createAffUrl($item) : esc_url($offer_url_exist);
?>