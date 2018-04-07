<?php
/**
 * Custon Meta Box
 * 
 * @package WordPress
 * @subpackage Testwp
 * @since Testwp 0.1
 */



function call_Testwp_Custom_Meta() {
	new Testwp_Custom_Meta();
}

if ( is_admin() ) {
	add_action( 'load-post.php', 'call_Testwp_Custom_Meta' );
	add_action( 'load-post-new.php', 'call_Testwp_Custom_Meta' );
}

/**
 * Class Add Custon Meta Box
 */
class Testwp_Custom_Meta {

	/**
	 * Set the hooks
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );
		add_action( 'edit_form_after_title', array( $this, 'form_after_title' ) );
	}

	/**
	 * Add meta
	 */
	public function add_meta_box( $post_type ){

			$post_types = array('twfilms');

			if ( in_array( $post_type, $post_types )) {
				add_meta_box(
					'testwp_meta_box_subtitle',
					__( 'Subtitle', 'testwp' ),
					array( $this, 'render_meta_box' ),
					$post_type,
					'after_title',
					'high'
				);
			}
	}

	/**
	 * Save meta
	 *
	 * @param int $post_id
	 * @return int
	 */
	public function save_meta_box( $post_id ) {
		if ( ! isset( $_POST['testwp_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['testwp_custom_box_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'testwp_custom_box' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		if ( 'page' === $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$mydata = sanitize_text_field( $_POST['testwp_subtitle_field'] );

		update_post_meta( $post_id, '_testwp_subtitle_key', $mydata );
	}


	/**
	 * Render Field in Post
	 *
	 * @param WP_Post $post
	 */
	public function render_meta_box( $post ) {

		wp_nonce_field( 'testwp_custom_box', 'testwp_custom_box_nonce' );

		$value = get_post_meta( $post->ID, '_testwp_subtitle_key', true );

		echo '<input type="text" id="testwp_subtitle_field" style="width:100%;font-size:1.5em;" name="testwp_subtitle_field" value="' . esc_attr( $value ) . '"  />';
	}


    /**
	 * Put Meta from Title
	 */
	public function form_after_title() {

	    global $post, $wp_meta_boxes;

	    do_meta_boxes( get_current_screen(), 'after_title', $post );

	    unset( $wp_meta_boxes['post']['after_title'] );
	}


}

