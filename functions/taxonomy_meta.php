<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

add_action('admin_init', 'category_custom_fields', 1);
if( !function_exists('category_custom_fields') ) {
function category_custom_fields()
    {
        add_action('edit_category_form_fields', 'category_custom_fields_form');
        add_action('edited_category', 'category_custom_fields_save');
        add_action( 'create_category', 'category_custom_fields_save'); 
        add_action( 'category_add_form_fields', 'category_custom_fields_form_new');

    }
}    

if( !function_exists('category_custom_fields_form') ) {
function category_custom_fields_form($tag)
    {
        $t_id = $tag->term_id;
        $cat_meta = get_option("category_$t_id");
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style( 'wp-color-picker' );
?>
        <tr class="form-field">
            <th scope="row" valign="top"><label><?php _e('Second category description','rehub_framework'); ?></label></th>
            <td>
                <textarea name="Cat_meta[cat_second_description]" id="Cat_meta[cat_second_description]" rows="5" cols="50" class="large-text"><?php echo (!empty($cat_meta['cat_second_description'])) ? $cat_meta['cat_second_description'] : ''; ?></textarea><br />
                <span class="description"><?php _e('Set html for second category description (will be after posts)','rehub_framework'); ?></span>
            </td>
        </tr>
        <tr class="form-field color_cat_grade">
        	<th scope="row" valign="top"><label><?php _e('Cat color','rehub_framework'); ?></label></th>
        	<td>
        		<input type="text" name="Cat_meta[cat_color]" id="Cat_meta[cat_color]" size="25" style="width:60%;" value="<?php echo (!empty($cat_meta['cat_color'])) ? $cat_meta['cat_color'] : ''; ?>" data-default-color="#E43917"><br />
	            <script type="text/javascript">
	    			jQuery(document).ready(function($) {   
	        			$('.color_cat_grade input').wpColorPicker();
	    			});             
	    		</script>
                <span class="description"><?php _e('Set category color. Note, this color will be used under white text','rehub_framework'); ?></span>
            </td>
        </tr>          
        <tr class="form-field">
        	<th scope="row" valign="top"><label><?php _e('Category banner custom html','rehub_framework'); ?></label></th>
        	<td>
        		<input type="text" name="Cat_meta[cat_image_url]" id="Cat_meta[cat_image_url]" size="25" style="width:60%;" value="<?php echo (!empty($cat_meta['cat_image_url'])) ? $cat_meta['cat_image_url'] : ''; ?>"><br />
                <span class="description"><?php _e('Set url to image of banner or any custom html, shortcode','rehub_framework'); ?></span>
            </td>
        </tr>          
<?php
    }
}    

if( !function_exists('category_custom_fields_form_new') ) {
function category_custom_fields_form_new($tag)
    {
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style( 'wp-color-picker' );
?>
        <div class="form-field">
            <label><?php _e('Second category description','rehub_framework'); ?></label>
            <textarea name="Cat_meta[cat_second_description]" id="Cat_meta[cat_second_description]" rows="5" cols="50"><?php echo (!empty($cat_meta['cat_second_description'])) ? $cat_meta['cat_second_description'] : ''; ?></textarea><br />
            <span class="description"><?php _e('Set html for second category description (will be after posts)','rehub_framework'); ?></span>
        </div>
        <div class="form-field color_cat_grade">
        	<label><?php _e('Cat color','rehub_framework'); ?></label>        	
        		<input type="text" name="Cat_meta[cat_color]" id="Cat_meta[cat_color]" size="25" style="width:60%;" value="" data-default-color="#E43917"><br />
	            <script type="text/javascript">
	    			jQuery(document).ready(function($) {   
	        			$('.color_cat_grade input').wpColorPicker();
	    			});             
	    		</script>
                <span class="description"><?php _e('Set category color. Note, this color will be used under white text','rehub_framework'); ?></span> 
        </div>          
        <div class="form-field">
        	<label><?php _e('Category banner custom html','rehub_framework'); ?></label>
        		<input type="text" name="Cat_meta[cat_image_url]" id="Cat_meta[cat_image_url]" size="25" style="width:60%;" value=""><br />
                <span class="description"><?php _e('Set url to image of banner or any custom html, shortcode','rehub_framework'); ?></span>     
        </div>         
<?php
    }    
}

if( !function_exists('category_custom_fields_save') ) {    
function category_custom_fields_save($term_id)
    {
        if (isset($_POST['Cat_meta'])) {
            $t_id = $term_id;
            $cat_meta = get_option("category_$t_id");
            $cat_keys = array_keys($_POST['Cat_meta']);
            foreach ($cat_keys as $key) {
                if (isset($_POST['Cat_meta'][$key])) {
                    $cat_meta[$key] = stripslashes($_POST['Cat_meta'][$key]);
                }
            }
            //save the option array
            update_option("category_$t_id", $cat_meta);
        }
    }
}    

// A callback function to add a custom field to our "presenters" taxonomy 
if( !function_exists('shopimage_taxonomy_custom_fields') ) { 
function shopimage_taxonomy_custom_fields($tag) {  
   // Check for existing taxonomy meta for the term you're editing  
    $t_id = $tag->term_id; // Get the ID of the term you're editing  
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check 
    if (function_exists('wp_enqueue_media')) {wp_enqueue_media();} 
?>  
<script>
jQuery(document).ready(function ($) {
//Image helper	
	var imageFrame;jQuery(".wpsm_tax_helper_upload_image_button").click(function(e){e.preventDefault();return $self=jQuery(e.target),$div=$self.closest("div.wpsm_tax_helper_image"),imageFrame?void imageFrame.open():(imageFrame=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),imageFrame.on("select",function(){selection=imageFrame.state().get("selection"),selection&&selection.each(function(e){console.log(e);{var t=e.attributes.sizes.full.url;e.id}$div.find(".wpsm_tax_helper_preview_image").attr("src",t),$div.find(".wpsm_tax_helper_upload_image").val(t)})}),void imageFrame.open())}),jQuery(".wpsm_tax_helper_clear_image_button").click(function(){var e='';return jQuery(this).parent().siblings(".wpsm_tax_helper_upload_image").val(""),jQuery(this).parent().siblings(".wpsm_tax_helper_preview_image").attr("src",e),!1});
});
</script>  
<tr class="form-field">  
    <th scope="row" valign="top">  
        <label for="brand_image"><?php _e('Shop image', 'rehub_framework'); ?></label>  
    </th>  
    <td> 
	<div class="wpsm_tax_helper_image">
		<img src="<?php echo $term_meta['brand_image'] ? $term_meta['brand_image'] : ''; ?>" class="wpsm_tax_helper_preview_image" alt="" style="max-height: 80px" />
		<p class="description"><?php _e('Upload or choose image here for affiliate shop', 'rehub_framework'); ?></p>
		<input name="term_meta[brand_image]" id="term_meta[brand_image]" size="25" style="width:60%;" value="<?php echo $term_meta['brand_image'] ? $term_meta['brand_image'] : ''; ?>" class="wpsm_tax_helper_upload_image" value="" />									
		<a href="#" class="wpsm_tax_helper_upload_image_button button" rel=""><?php _e('Choose Image', 'rehub_framework'); ?></a>
		<small>&nbsp;<a href="#" class="wpsm_tax_helper_clear_image_button button">X</a></small>
		<br /><br />		
	</div>       
    </td>  
</tr>  
  
<?php  
} 
}

// A callback function to add a custom field to our "presenters" taxonomy 
if( !function_exists('shopimage_taxonomy_custom_fields_new') ) { 
function shopimage_taxonomy_custom_fields_new($tag) {  
if (function_exists('wp_enqueue_media')) {wp_enqueue_media();}
?>  
<script>
jQuery(document).ready(function ($) {
//Image helper	
	var imageFrame;jQuery(".wpsm_tax_helper_upload_image_button").click(function(e){e.preventDefault();return $self=jQuery(e.target),$div=$self.closest("div.wpsm_tax_helper_image"),imageFrame?void imageFrame.open():(imageFrame=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),imageFrame.on("select",function(){selection=imageFrame.state().get("selection"),selection&&selection.each(function(e){console.log(e);{var t=e.attributes.sizes.full.url;e.id}$div.find(".wpsm_tax_helper_preview_image").attr("src",t),$div.find(".wpsm_tax_helper_upload_image").val(t)})}),void imageFrame.open())}),jQuery(".wpsm_tax_helper_clear_image_button").click(function(){var e='';return jQuery(this).parent().siblings(".wpsm_tax_helper_upload_image").val(""),jQuery(this).parent().siblings(".wpsm_tax_helper_preview_image").attr("src",e),!1});
});
</script>  
<div class="form-field"> 
        <label for="brand_image"><?php _e('Shop image', 'rehub_framework'); ?></label>  
		<div class="wpsm_tax_helper_image">
			<img src="" class="wpsm_tax_helper_preview_image" alt="" style="max-height: 80px" />
			<p class="description"><?php _e('Upload or choose image here for affiliate shop', 'rehub_framework'); ?></p>
			<input name="term_meta[brand_image]" id="term_meta[brand_image]" size="25" style="width:60%;" value="" class="wpsm_tax_helper_upload_image" value="" />									
			<a href="#" class="wpsm_tax_helper_upload_image_button button" rel=""><?php _e('Choose Image', 'rehub_framework'); ?></a>
			<small>&nbsp;<a href="#" class="wpsm_tax_helper_clear_image_button button">X</a></small>
			<br /><br />		
		</div>   
</div>  
  
<?php  
}  
}

// A callback function to save our extra taxonomy field(s) 
if( !function_exists('rehub_save_taxonomy_custom_fields') ) { 
function rehub_save_taxonomy_custom_fields( $term_id ) {  
    if ( isset( $_POST['term_meta'] ) ) {  
        $t_id = $term_id;  
        $term_meta = get_option( "taxonomy_term_$t_id" );  
        $cat_keys = array_keys( $_POST['term_meta'] );  
            foreach ( $cat_keys as $key ){  
            if ( isset( $_POST['term_meta'][$key] ) ){  
                $term_meta[$key] = $_POST['term_meta'][$key];  
            }  
        }  
        //save the option array  
        update_option( "taxonomy_term_$t_id", $term_meta );  
    }  
} 
}

$rh_woostore_tax_meta = apply_filters('rhwoostore_tax_fields', array(
    array(
        'label'=>  __('Set second description', 'rehub_framework'),
        'desc'  => __('Will be in bottom of page', 'rehub_framework'),
        'id'    => 'brand_second_description',
        'type'  => 'textarea'
    ),     
    array(
        'label'  => __('Upload logo', 'rehub_framework'),
        'desc'  => __('Upload or choose image here for retailer logo', 'rehub_framework'),
        'id'    => 'brandimage',
        'type'  => 'image'
    ),      
));

// A callback function to edit a custom field to our "deal brand" taxonomy 
if( !function_exists('rhwoostore_tax_fields_edit') ) { 
function rhwoostore_tax_fields_edit($term, $taxonomy) {  
    wp_nonce_field( basename( __FILE__ ), 'rhwoostore_nonce' );
    global $rh_woostore_tax_meta;  
    if (function_exists('wp_enqueue_media')) {wp_enqueue_media();} 
    ?>  
    <?php foreach ($rh_woostore_tax_meta as $field) :?>
        <?php $term_meta = get_term_meta( $term->term_id, $field['id'], true );?>
        <tr class="form-field">  
            <th scope="row" valign="top">  
                <label for="<?php echo $field['id'];?>"><?php echo $field['label'];?></label>  
            </th>
            <td>    
                <?php if ($field['type'] == 'text') :?>
                    <input name="<?php echo $field['id'];?>" id="<?php echo $field['id'];?>" value="<?php echo $term_meta ? $term_meta : ''; ?>" class="wpsm_tax_text_field" /><br /><br />
                <?php elseif($field['type'] == 'textarea'):?>
                    <textarea name="<?php echo $field['id'];?>" id="<?php echo $field['id'];?>" class="wpsm_tax_textarea_field" rows="5" cols="40"><?php echo $term_meta ? $term_meta : ''; ?></textarea><p class="description"><?php echo $field['desc'];?></p><br /><br />
                <?php elseif($field['type'] == 'image'):?>
                    <script>
                    jQuery(document).ready(function ($) {
                    //Image helper  
                        var imageFrame;jQuery(".wpsm_tax_helper_upload_image_button").click(function(e){e.preventDefault();return $self=jQuery(e.target),$div=$self.closest("div.wpsm_tax_helper_image"),imageFrame?void imageFrame.open():(imageFrame=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),imageFrame.on("select",function(){selection=imageFrame.state().get("selection"),selection&&selection.each(function(e){console.log(e);{var t=e.attributes.sizes.full.url;e.id}$div.find(".wpsm_tax_helper_preview_image").attr("src",t),$div.find(".wpsm_tax_helper_upload_image").val(t)})}),void imageFrame.open())}),jQuery(".wpsm_tax_helper_clear_image_button").click(function(){var e='';return jQuery(this).parent().siblings(".wpsm_tax_helper_upload_image").val(""),jQuery(this).parent().siblings(".wpsm_tax_helper_preview_image").attr("src",e),!1});
                    });
                    </script>                        
                    <div class="wpsm_tax_helper_image">
                        <img src="<?php echo $term_meta ? esc_url($term_meta) : ''; ?>" class="wpsm_tax_helper_preview_image" alt="" style="max-height: 80px" />
                        <p class="description"><?php echo $field['desc'];?></p>
                        <input name="<?php echo $field['id'];?>" id="<?php echo $field['id'];?>" size="25" style="width:60%;" value="<?php echo $term_meta ? esc_url($term_meta) : ''; ?>" class="wpsm_tax_helper_upload_image" />
                        <a href="#" class="wpsm_tax_helper_upload_image_button button" rel=""><?php _e('Choose Image', 'rehub_framework'); ?></a>
                        <small>&nbsp;<a href="#" class="wpsm_tax_helper_clear_image_button button">X</a></small>
                        <br /><br />        
                    </div>          
                <?php endif;?>
            </td>
        </tr>
    <?php endforeach;?>
    <?php  
} 
}

// A callback function to add a custom field to our "deal brand" taxonomy 
if( !function_exists('rhwoostore_tax_fields_new') ) { 
function rhwoostore_tax_fields_new($taxonomy) {   
    wp_nonce_field( basename( __FILE__ ), 'rhwoostore_nonce' );
    if (function_exists('wp_enqueue_media')) {wp_enqueue_media();}
    global $rh_woostore_tax_meta;
    ?>  
    <?php foreach ($rh_woostore_tax_meta as $field) :?>
        <div class="form-field">    
            <label for="<?php echo $field['id'];?>"><?php echo $field['label'];?></label>  
            <?php if ($field['type'] == 'text') :?>
                <input name="<?php echo $field['id'];?>" id="<?php echo $field['id'];?>" value="" class="wpsm_tax_text_field" /><br /><br />
            <?php elseif($field['type'] == 'textarea'):?>
                <textarea name="<?php echo $field['id'];?>" id="<?php echo $field['id'];?>" class="wpsm_tax_textarea_field" rows="5" cols="40"></textarea><p class="description"><?php echo $field['desc'];?></p><br /><br />
            <?php elseif($field['type'] == 'image'):?>
                <script>
                jQuery(document).ready(function ($) {
                //Image helper  
                    var imageFrame;jQuery(".wpsm_tax_helper_upload_image_button").click(function(e){e.preventDefault();return $self=jQuery(e.target),$div=$self.closest("div.wpsm_tax_helper_image"),imageFrame?void imageFrame.open():(imageFrame=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),imageFrame.on("select",function(){selection=imageFrame.state().get("selection"),selection&&selection.each(function(e){console.log(e);{var t=e.attributes.sizes.full.url;e.id}$div.find(".wpsm_tax_helper_preview_image").attr("src",t),$div.find(".wpsm_tax_helper_upload_image").val(t)})}),void imageFrame.open())}),jQuery(".wpsm_tax_helper_clear_image_button").click(function(){var e='';return jQuery(this).parent().siblings(".wpsm_tax_helper_upload_image").val(""),jQuery(this).parent().siblings(".wpsm_tax_helper_preview_image").attr("src",e),!1});
                });
                </script>                        
                <div class="wpsm_tax_helper_image">
                    <img src="" class="wpsm_tax_helper_preview_image" alt="" style="max-height: 80px" />
                    <p class="description"><?php echo $field['desc'];?></p>
                    <input name="<?php echo $field['id'];?>" id="<?php echo $field['id'];?>" size="25" style="width:60%;" value="" class="wpsm_tax_helper_upload_image" />
                    <a href="#" class="wpsm_tax_helper_upload_image_button button" rel=""><?php _e('Choose Image', 'rehub_framework'); ?></a>
                    <small>&nbsp;<a href="#" class="wpsm_tax_helper_clear_image_button button">X</a></small>
                    <br /><br />        
                </div>          
            <?php endif;?>
        </div>
    <?php endforeach;?>
    <?php  
}  
}

// A callback function to save our extra taxonomy field(s) 
if( !function_exists('rhwoostore_tax_fields_save') ) { 
function rhwoostore_tax_fields_save( $term_id, $tt_id) { 
    global $rh_woostore_tax_meta;
    if ( ! wp_verify_nonce( $_POST['rhwoostore_nonce'], basename( __FILE__ ) ) || !current_user_can('manage_categories'))
        return; 
    // loop through fields and save the data
    foreach ($rh_woostore_tax_meta as $field) {
        $old = get_term_meta($term_id, $field['id'], true);
        if (isset ($_POST[$field['id']])) {
            if ($field['type'] == 'image'){
                $new = esc_url($_POST[$field['id']]);
            }
            elseif($field['type'] == 'text'){
                $new = sanitize_text_field($_POST[$field['id']]);
            }           
            else{
                $new = $_POST[$field['id']];
            }  
        }
        else {
           $new =''; 
        }
        if ($new && $new != $old) {
            update_term_meta($term_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_term_meta($term_id, $field['id'], $old);
        }
    } // end foreach  
} 
}

//Add new column in term list
function rh_woostore_group_column( $columns ){
    $columns['rhwoostore'] = __( 'Logo', 'rehub_framework' );
    return $columns;
}
function rh_add_rhwoostore_column_content( $content, $column_name, $term_id ){
    if( $column_name !== 'rhwoostore' ){
        return $content;
    }
    $term_id = absint( $term_id );
    $rhwoostoreimage = get_term_meta( $term_id, 'brandimage', true );
    if( !empty( $rhwoostoreimage ) ){
        $content .= '<img src="'.$rhwoostoreimage.'" width=50 />';
    }
    return $content;
}
if( !function_exists('rhwoostore_tax_fields') ) {
function rhwoostore_tax_fields() {  
    add_action( 'store_edit_form_fields', 'rhwoostore_tax_fields_edit', 10, 2 );  
    add_action( 'store_add_form_fields', 'rhwoostore_tax_fields_new');
    add_action( 'edited_store', 'rhwoostore_tax_fields_save', 10, 2 ); 
    add_action( 'create_store', 'rhwoostore_tax_fields_save', 10, 2 );        
}
}

//Enable store taxonomy for woocommerce
if (class_exists('Woocommerce')) {
    add_action('admin_init', 'rhwoostore_tax_fields', 1);
    add_filter('manage_store_custom_column', 'rh_add_rhwoostore_column_content', 10, 3 );
    add_filter('manage_edit-store_columns', 'rh_woostore_group_column' );
}

//CLONE Store(Brand) taxonomy for posts
if(rehub_option('enable_brand_taxonomy') == 1){

    //Creating store taxonomy
    if(!function_exists('post_dealstore_init')){
        function post_dealstore_init() {
            register_taxonomy(
                'dealstore',
                'post',
                array(
                    'labels' => array(
                        'name'              => __( 'Affiliate Store', 'rehub_framework' ),
                        'singular_name'     => __( 'Affiliate Store', 'rehub_framework' ),
                        'search_items'      => __( 'Search store', 'rehub_framework' ),
                        'all_items'         => __( 'All stores', 'rehub_framework' ),
                        'parent_item'       => __( 'Parent store', 'rehub_framework' ),
                        'parent_item_colon' => __( 'Parent store:', 'rehub_framework' ),
                        'edit_item'         => __( 'Edit store', 'rehub_framework' ),
                        'update_item'       => __( 'Update store', 'rehub_framework' ),
                        'add_new_item'      => __( 'Add new store', 'rehub_framework' ),
                        'new_item_name'     => __( 'New store name', 'rehub_framework' ),
                        'menu_name'         => __( 'Affiliate Store', 'rehub_framework' ),
                    ),      
                    'show_ui' => true,
                    'show_admin_column' => true,
                    'update_count_callback' => '_update_post_term_count',
                    'hierarchical' => true,
                    'public' => true,
                    'query_var' => true,
                    'show_in_quick_edit' => true,
                    'rewrite' => array( 'slug' => (rehub_option('rehub_deal_store_tag') !='') ? rehub_option('rehub_deal_store_tag') : 'dealstore' ),
                )
            );
        }
    }
    add_action( 'init', 'post_dealstore_init' );

    //Enabling taxonomy meta
    add_action('admin_init', 'dealstore_tax_fields', 1);
    if( !function_exists('dealstore_tax_fields') ) {
        function dealstore_tax_fields() {  
            add_action( 'dealstore_edit_form_fields', 'rhwoostore_tax_fields_edit', 10, 2 );  
            add_action( 'dealstore_add_form_fields', 'rhwoostore_tax_fields_new');
            add_action( 'edited_dealstore', 'rhwoostore_tax_fields_save', 10, 2 ); 
            add_action( 'create_dealstore', 'rhwoostore_tax_fields_save', 10, 2 );              
        }
    }  

    //Adding column to store page in admin page
    add_filter('manage_dealstore_custom_column', 'rh_add_rhwoostore_column_content', 10, 3 ); 
    add_filter('manage_edit-dealstore_columns', 'rh_woostore_group_column' ); 
}

if(rehub_option('enable_blog_posttype') == 1){
//Create separate Blog post type
if ( ! function_exists('rh_blog_create_posttype') ) {
// Register Custom Post Type
function rh_blog_create_posttype() {

    $labels = array(
        'name'                  => __( 'Blog', 'rehub_framework' ),
        'singular_name'         => __( 'Blog', 'rehub_framework' ),
        'menu_name'             => __( 'Blog posts', 'rehub_framework' ),
        'name_admin_bar'        => __( 'Blog', 'rehub_framework' ),
        'archives'              => __( 'Item Archives', 'rehub_framework' ),
        'parent_item_colon'     => __( 'Parent Item:', 'rehub_framework' ),
        'all_items'             => __( 'All Items', 'rehub_framework' ),
        'add_new_item'          => __( 'Add New Item', 'rehub_framework' ),
        'add_new'               => __( 'Add New', 'rehub_framework' ),
        'new_item'              => __( 'New Item', 'rehub_framework' ),
        'edit_item'             => __( 'Edit Item', 'rehub_framework' ),
        'update_item'           => __( 'Update Item', 'rehub_framework' ),
        'view_item'             => __( 'View Item', 'rehub_framework' ),
        'search_items'          => __( 'Search Item', 'rehub_framework' ),
        'not_found'             => __( 'Not found', 'rehub_framework' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'rehub_framework' ),
        'featured_image'        => __( 'Featured Image', 'rehub_framework' ),
        'set_featured_image'    => __( 'Set featured image', 'rehub_framework' ),
        'remove_featured_image' => __( 'Remove featured image', 'rehub_framework' ),
        'use_featured_image'    => __( 'Use as featured image', 'rehub_framework' ),
        'insert_into_item'      => __( 'Insert into item', 'rehub_framework' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'rehub_framework' ),
        'items_list'            => __( 'Items list', 'rehub_framework' ),
        'items_list_navigation' => __( 'Items list navigation', 'rehub_framework' ),
        'filter_items_list'     => __( 'Filter items list', 'rehub_framework' ),
    );
    $args = array(
        'label'                 => __( 'Blog', 'rehub_framework' ),
        'description'           => __( 'Blog Description', 'rehub_framework' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', ),
        'taxonomies'            => array( 'blog_category', 'blog_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,        
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'rewrite' => array( 'slug' => (rehub_option('blog_posttype_slug') !='') ? rehub_option('blog_posttype_slug') : 'blog' ),
    );
    register_post_type( 'blog', $args );
}
}

if ( ! function_exists( 'rh_blog_category' ) ) {
// Register Custom Taxonomy
function rh_blog_category() {
    $labels = array(
        'name'                       => _x( 'Blog categories', 'Taxonomy General Name', 'rehub_framework' ),
        'singular_name'              => _x( 'Blog category', 'Taxonomy Singular Name', 'rehub_framework' ),
        'menu_name'                  => __( 'Blog category', 'rehub_framework' ),
        'all_items'                  => __( 'All categories', 'rehub_framework' ),
        'parent_item'                => __( 'Parent Item', 'rehub_framework' ),
        'parent_item_colon'          => __( 'Parent Item:', 'rehub_framework' ),
        'new_item_name'              => __( 'New category', 'rehub_framework' ),
        'add_new_item'               => __( 'Add category', 'rehub_framework' ),
        'edit_item'                  => __( 'Edit category', 'rehub_framework' ),
        'update_item'                => __( 'Update category', 'rehub_framework' ),
        'view_item'                  => __( 'View category', 'rehub_framework' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'rehub_framework' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'rehub_framework' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'rehub_framework' ),
        'popular_items'              => __( 'Popular Items', 'rehub_framework' ),
        'search_items'               => __( 'Search Items', 'rehub_framework' ),
        'not_found'                  => __( 'Not Found', 'rehub_framework' ),
        'no_terms'                   => __( 'No items', 'rehub_framework' ),
        'items_list'                 => __( 'Items list', 'rehub_framework' ),
        'items_list_navigation'      => __( 'Items list navigation', 'rehub_framework' ),       
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite' => array( 'slug' => (rehub_option('blog_posttypecat_slug') !='') ? rehub_option('blog_posttypecat_slug') : 'blog_category' ),         
    );
    register_taxonomy( 'blog_category', array( 'blog' ), $args );
}
}

if ( ! function_exists( 'rh_blog_tag' ) ) {
// Register Custom Taxonomy
function rh_blog_tag() {
    $labels = array(
        'name'                       => _x( 'Blog tags', 'Taxonomy General Name', 'rehub_framework' ),
        'singular_name'              => _x( 'Blog tag', 'Taxonomy Singular Name', 'rehub_framework' ),
        'menu_name'                  => __( 'Blog tag', 'rehub_framework' ),
        'all_items'                  => __( 'All tags', 'rehub_framework' ),
        'parent_item'                => __( 'Parent Item', 'rehub_framework' ),
        'parent_item_colon'          => __( 'Parent Item:', 'rehub_framework' ),
        'new_item_name'              => __( 'New tag', 'rehub_framework' ),
        'add_new_item'               => __( 'Add tag', 'rehub_framework' ),
        'edit_item'                  => __( 'Edit tag', 'rehub_framework' ),
        'update_item'                => __( 'Update tag', 'rehub_framework' ),
        'view_item'                  => __( 'View tag', 'rehub_framework' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'rehub_framework' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'rehub_framework' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'rehub_framework' ),
        'popular_items'              => __( 'Popular Items', 'rehub_framework' ),
        'search_items'               => __( 'Search Items', 'rehub_framework' ),
        'not_found'                  => __( 'Not Found', 'rehub_framework' ),
        'no_terms'                   => __( 'No items', 'rehub_framework' ),
        'items_list'                 => __( 'Items list', 'rehub_framework' ),
        'items_list_navigation'      => __( 'Items list navigation', 'rehub_framework' ),        
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite' => array( 'slug' => (rehub_option('blog_posttypetag_slug') !='') ? rehub_option('blog_posttypetag_slug') : 'blog_tag' ),        
    );
    register_taxonomy( 'blog_tag', array( 'blog' ), $args );
}
}

add_action( 'init', 'rh_blog_create_posttype', 0 );
add_action( 'init', 'rh_blog_tag', 0 );
add_action( 'init', 'rh_blog_category', 0 );

}


//EXTEND WORDPRESS TABLE OF POST
add_filter('manage_post_posts_columns', 'rh_admin_expired_table_head');
function rh_admin_expired_table_head( $defaults ) {
    $defaults['expiration_date']  = 'Expiration Date';
    $defaults['expiration_status']    = 'Expired';
    return $defaults;
}

add_action( 'manage_post_posts_custom_column', 'rh_admin_expired_table_content', 10, 2 );
function rh_admin_expired_table_content( $column_name, $post_id ) {
    if ($column_name == 'expiration_date') {
        $offer_coupon_date = get_post_meta( $post_id, 'rehub_offer_coupon_date', true );
        if($offer_coupon_date){
        echo  date( _x( 'F d, Y', 'Event date format', 'rehub_framework' ), strtotime( $offer_coupon_date ) );
        }
    }
    if ($column_name == 'expiration_status') {
        $expiration_status = get_post_meta( $post_id, 're_post_expired', true );
        if($expiration_status){ 
            echo '<span style="font-size:18px; color:red">&#128467;</span>';
        }
    }

}

add_filter( 'manage_edit-post_sortable_columns', 'rh_admin_expired_table_sorting' );
function rh_admin_expired_table_sorting( $columns ) {
  $columns['expiration_date'] = 'expiration_date';
  $columns['expiration_status'] = 'expiration_status';
  return $columns;
}

add_filter( 'request', 'rh_admin_expired_date_column_orderby' );
function rh_admin_expired_date_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'expiration_date' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'rehub_offer_coupon_date',
            'orderby' => 'meta_value'
        ) );
    }

    return $vars;
}

add_filter( 'request', 'rh_admin_expired_status_column_orderby' );
function rh_admin_expired_status_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'expiration_status' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 're_post_expired',
            'orderby' => 'meta_value'
        ) );
    }

    return $vars;
}