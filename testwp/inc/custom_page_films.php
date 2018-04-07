<?php
/**
 * Custon Page for Films
 * 
 * @package WordPress
 * @subpackage Testwp
 * @since Testwp 0.1
 */

/**
 * Class Add Custom Page for Testwp
 */
final class Testwp_Custom_Page_Films{

	public static $post_slug = 'twfilms'; //slug
	public static $name_pst_ed = 'Film'; //Name Post
	public static $name_pst_mu = 'Films'; //Name Posts

	/**
	 * Initialise function
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'add_custom_post' ), 0 );
	}


	/**
	 * Custom page labels config
	 *
	 * @param string $name_ed
	 * @param string $name_mu
	 *
	 * @return array
	 */
	public static function labelstax( $name_ed, $name_mu ) {
		return array(
			'name'           => $name_mu,
			'singular_name'  => $name_ed,
			'menu_name'      => $name_mu,
			'name_admin_bar' => $name_ed,
			'add_new_item'   => __( 'New', 'testwp' ) . ' ' . $name_ed,
			'new_item'       => __( 'New', 'testwp' ) . ' ' . $name_ed,
		);
	}


	/**
	 * Create custom page
	 */
	public static function add_custom_post() {
		$labels = array(
			'name'              => self::$name_pst_mu,
			'singular_name'     => self::$name_pst_ed,
			'menu_name'         => self::$name_pst_mu,
			'name_admin_bar'    => self::$name_pst_mu,
			'add_new'           => __( 'New', 'testwp' ) . ' ' . self::$name_pst_ed,
			'add_new_item'      => __( 'Add', 'testwp' ) . ' ' . self::$name_pst_ed,
			'new_item'          => __( 'New', 'testwp' ) . ' ' . self::$name_pst_ed,
			'edit_item'         => __( 'Edit', 'testwp' ) . ' ' . self::$name_pst_ed,
			'view_item'         => __( 'Viev', 'testwp' ) . ' ' . self::$name_pst_ed,
			'all_items'         => __( 'All', 'testwp' ) . ' ' . self::$name_pst_mu,
			'search_items'      => __( 'Search', 'testwp' ) . ' ' . self::$name_pst_mu,
			'parent_item_colon' => __( 'Parent:', 'testwp' ) . ' ' . self::$name_pst_mu,
		);

		register_taxonomy( 'twfilmscat', array( 'twfilms' ), array(
			'label'             => __( 'Films Category', 'testwp' ),
			'hierarchical'      => true,
		) );

		register_post_type( self::$post_slug, array(
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
			'taxonomies'          => array( 'twfilmscat' ),
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-media-document',
			'public'              => true,
			'menu_position'       => 3,
			'can_export'          => true,
			'has_archive'         => false,
			'query_var'           => true,
			'publicly_queryable'  => true,
			'show_in_nav_menus'   => true,
			'exclude_from_search' => false,
			'capability_type'     => 'post',
		) );

	}
}

Testwp_Custom_Page_Films::init();