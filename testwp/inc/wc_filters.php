<?php
/**
 * Woocommerce Filter for Films
 * 
 * @package WordPress
 * @subpackage Testwp
 * @since Testwp 0.1
 */



if ( is_admin() && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	new Testwp_WC_Filter();
}

/**
 * Class Add Custon Meta Box
 */
class Testwp_WC_Filter {

	/**
	 * Set the hooks
	 */
	public function __construct() {
		add_action( 'woocommerce_product_data_tabs', array( $this, 'testwp_custom_product_data_tab' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'testwp_custom_product_data_fields' ) );
		add_action( 'woocommerce_process_product_meta_simple', array( $this, 'testwp_save_proddata_custom_fields' ) );
	}


	/**
	 * Add New Tab
	 * @param array $product_data_tabs
	 *
	 * @return mixed
	 */
	public function testwp_custom_product_data_tab( $product_data_tabs ) {
	    $product_data_tabs['my-custom-tab'] = array(
	        'label' => __( 'Films', 'testwp' ),
	        'target' => 'testwp_custom_product_data',
	        'class'     => array( 'show_if_simple' ),
	    );
	    return $product_data_tabs;
	}


	/**
	 * Data Fields
	 */
	public function testwp_custom_product_data_fields() {

	    ?> <div id = 'testwp_custom_product_data'
	    class = 'panel woocommerce_options_panel' > <?php
	        ?> <div class = 'options_group' > <?php
				  woocommerce_wp_select(
				    array(
				      'id' => '_wc_film',
				      'label' => __( 'Select Film', 'testwp' ),
				      'options' => $this->testwp_get_custom_posts_array('twfilms')
				    )
				  );
	        ?> </div>

	    </div><?php
	}


	/**
	 * Hook callback function to save custom fields information
	 *
	 * @param $post_id
	 */
	public function testwp_save_proddata_custom_fields($post_id) {
	    // Save Select
	    $select = $_POST['_wc_film'];
	    if (!empty($select)) {
	        update_post_meta($post_id, '_wc_film', esc_attr($select));
	    }
	}

	/**
	 * Get Custom posts for Custom tab
	 *
	 * @param string $post_type
	 *
	 * @return array
	 */
	public function testwp_get_custom_posts_array($post_type) {

	    $posts = get_posts([
		  'post_type' => $post_type,
		  'post_status' => 'publish',
		  'numberposts' => -1
		]);

	    $result = array('0' => __( 'Select Film', 'testwp' ));

	    if(!empty($posts)) {
		    foreach ( (array)$posts  as $post ) {
			    $result[$post->ID] = $post->post_title;
	    	}
	    }

	    return $result;
	}



}

