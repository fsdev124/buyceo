<?php
/**
 * Post Image Gallery
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * RH_Meta_Box_Post.
 */
class RH_Meta_Box_Post {

	/**
	 * Is meta boxes saved once?
	 *
	 * @var boolean
	 */
	private static $saved_meta_boxes = false;

	/**
	 * Meta box error messages.
	 *
	 * @var array
	 */
	public static $meta_box_errors  = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 30 );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 1, 2 );

		/**
		 * Save Order Meta Boxes.
		 */

		// Save Post Meta Boxes
		add_action( 'rehub_process_post_meta', array( $this, 'save' ), 20, 2 );

		$def_p_types = rehub_option('rehub_ptype_formeta');
		$def_p_types = (!empty($def_p_types)) ? (array)$def_p_types : array('post');		
		foreach ($def_p_types as $def_p_type) {
			add_action( 'rehub_process_' . $def_p_type . '_meta', array( $this, 'save' ), 20, 2 );
		}	

		// Error handling (for showing errors from meta boxes on next page load)
		add_action( 'admin_notices', array( $this, 'output_errors' ) );
		add_action( 'shutdown', array( $this, 'save_errors' ) );
	}

	/**
	 * Add an error message.
	 * @param string $text
	 */
	public static function add_error( $text ) {
		self::$meta_box_errors[] = $text;
	}

	/**
	 * Save errors to an option.
	 */
	public function save_errors() {
		update_option( 'rehub_meta_box_errors', self::$meta_box_errors );
	}

	/**
	 * Show any stored error messages.
	 */
	public function output_errors() {
		$errors = maybe_unserialize( get_option( 'rehub_meta_box_errors' ) );

		if ( ! empty( $errors ) ) {

			echo '<div id="rehub_errors" class="error notice is-dismissible">';

			foreach ( $errors as $error ) {
				echo '<p>' . wp_kses_post( $error ) . '</p>';
			}

			echo '</div>';

			// Clear
			delete_option( 'rehub_meta_box_errors' );
		}
	}

	/**
	 * Add Meta boxes.
	 */
	public function add_meta_boxes() {
		// Posts
		$def_p_types = rehub_option('rehub_ptype_formeta');
		$def_p_types = (!empty($def_p_types)) ? (array)$def_p_types : array('post');		
		add_meta_box( 'rehub-post-images', __( "Post Thumbnails and video", "rehub_framework"  ), array( $this, 'output' ), $def_p_types, 'side', 'low' );
	}

	/**
	 * Check if we're saving, the trigger an action based on the post type.
	 */
	public function save_meta_boxes( $post_id, $post ) {
		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) || self::$saved_meta_boxes ) {
			return;
		}

		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the nonce
		if ( empty( $_POST['rehub_meta_nonce'] ) || ! wp_verify_nonce( $_POST['rehub_meta_nonce'], 'rehub_save_data' ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		self::$saved_meta_boxes = true;

		// Check the post type
		$def_p_types = rehub_option('rehub_ptype_formeta');
		$def_p_types = (!empty($def_p_types)) ? (array)$def_p_types : array('post');		
		if ( in_array( $post->post_type, $def_p_types ) ) {
			do_action( 'rehub_process_' . $post->post_type . '_meta', $post_id, $post );
		}
	}

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {
		?>
		<div id="rh_post_images_container">
			<ul class="rh_post_images">
				<?php
					if ( metadata_exists( 'post', $post->ID, 'rh_post_image_gallery' ) ) {
						$post_image_gallery = get_post_meta( $post->ID, 'rh_post_image_gallery', true );
					} else {
						// Backwards compat
						$attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_value=0' );
						$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
						$post_image_gallery = implode( ',', $attachment_ids );
					}

					$attachments = array_filter( explode( ',', $post_image_gallery ) );
					$update_meta = false;
					$updated_gallery_ids = array();

					if ( ! empty( $attachments ) ) {
						foreach ( $attachments as $attachment_id ) {
							$attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );

							// if attachment is empty skip
							if ( empty( $attachment ) ) {
								$update_meta = true;
								continue;
							}

							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . $attachment . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( "Delete image", "rehub_framework" ) . '">' . __( "Delete", "rehub_framework" ) . '</a></li>
								</ul>
							</li>';

							// rebuild ids to be saved
							$updated_gallery_ids[] = $attachment_id;
						}

						// need to update post meta to set new gallery ids
						if ( $update_meta ) {
							update_post_meta( $post->ID, 'rh_post_image_gallery', implode( ',', $updated_gallery_ids ) );
						}
					}
				?>
			</ul>
			<input type="hidden" id="rh_post_image_gallery" name="rh_post_image_gallery" value="<?php echo esc_attr( $post_image_gallery ); ?>" />
			<?php wp_nonce_field( 'rehub_save_data', 'rehub_meta_nonce' ); ?>
		</div>
		<p class="rh_add_post_images hide-if-no-js">
			<a href="#" data-choose="<?php esc_attr_e( "Add Images to Post Gallery", "rehub_framework" ); ?>" data-update="<?php esc_attr_e( "Add to gallery", "rehub_framework" ); ?>" data-delete="<?php esc_attr_e( "Delete image", "rehub_framework" ); ?>" data-text="<?php esc_attr_e( "Delete", "rehub_framework" ); ?>"><?php _e( "Add post gallery images", "rehub_framework" ); ?></a>
		</p>
		<p class="rh_add_post_images hide-if-no-js">
		<small><?php _e('Add video links, each link from new line. Youtube and vimeo are supported', 'rehub_framework');?></small>
			<textarea id="rh_post_image_videos" rows="3" name="rh_post_image_videos"><?php echo get_post_meta( $post->ID, 'rh_post_image_videos', true );?></textarea>
		</p> 
		<p class="rh_add_post_images hide-if-no-js"><small><?php _e('Some post layouts renders gallery thumbnails automatically. Also, you can add them to post with shortcode [rh_get_post_thumbnails video=1 height=200 justify=1]. video=1 - include also video. Height is maximum height, justify=1 is parameter to show pretty justify gallery.', 'rehub_framework');?></small></p>
		<?php
	}

	/**
	 * Save meta box data.
	 */
	public static function save( $post_id, $post ) {
		if( !empty($_POST['rh_post_image_gallery']) && !is_array($_POST['rh_post_image_gallery'])){
			$attachment_ids = sanitize_text_field( $_POST['rh_post_image_gallery']);
			update_post_meta( $post_id, 'rh_post_image_gallery', $attachment_ids );
		}elseif(isset($_POST['rh_post_image_gallery'])){
			delete_post_meta( $post_id, 'rh_post_image_gallery' );
		}

        $oldvideo = get_post_meta($post_id, 'rh_post_image_videos', true);
        if (isset ($_POST['rh_post_image_videos'])) {
            $newvideo = esc_html($_POST['rh_post_image_videos']);
        }
        else {
           $newvideo =''; 
        }
        if ($newvideo && $newvideo != $oldvideo) {
            update_post_meta($post_id, 'rh_post_image_videos', $newvideo);
        } elseif ('' == $newvideo && $oldvideo) {
            delete_post_meta($post_id, 'rh_post_image_videos', $oldvideo);
        }				
	}

}
new RH_Meta_Box_Post();