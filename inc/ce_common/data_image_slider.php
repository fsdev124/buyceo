<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<li data-thumb="<?php $params = array( 'width' => 80, 'height' => 80, 'crop' => true  ); echo bfi_thumb($small_image, $params); ?>">
    <img src="<?php $params = array( 'width' => 765, 'height' => 478, 'crop' => true    );echo bfi_thumb($large_image, $params); ?>" />
</li>