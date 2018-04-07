<?php
/**
 * Custom Registration Data
 * 
 * @package WordPress
 * @subpackage Testwp
 * @since Testwp 0.1
 */



/**
 * Class Add Custon Meta Box
 */
class Testwp_Custom_Reg_Data {

	/**
	 * Set the hooks
	 */
	public function __construct() {
		add_action( 'register_form', array( $this, 'testwp_add_skype_for_registration_form' ) );
		add_action( 'user_register', array( $this, 'testwp_save_skype_for_registration_form' ) );
		add_action( 'show_user_profile', array( $this, 'testwp_show_skype_in_profile' ) );
		add_action( 'edit_user_profile', array( $this, 'testwp_show_skype_in_profile' ) );
		add_action( 'personal_options_update', array( $this, 'testwp_save_skype_in_profile' ) );
		add_action( 'edit_user_profile_update', array( $this, 'testwp_save_skype_in_profile' ) );
	}

	/**
	 * Add Skype for registration form
	 */
	public function testwp_add_skype_for_registration_form() {
		?>
		<p>
			<label for="user_skype">Skype<br>
				<input type="text" name="user_skype" id="user_skype" class="input" value="" size="20">
			</label>
		</p>
		<?php
	}

	/**
	 * Save Skype in User Meta
	 */
	public function testwp_save_skype_for_registration_form( $user_id ) {
		if ( ! empty( $_POST['user_skype'] ) ) {
			update_user_meta( $user_id, 'user_skype', esc_attr( $_POST['user_skype'] ) );
		}

	}


	/**
	 * Show Skype in profile
	 *
	 * @param $user
	 */
	public function testwp_show_skype_in_profile( $user ) {
		?>
		<h2><?php esc_attr_e( 'Additional Information', 'testwp' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><label for="user_skype">Skype</label></th>
				<td>
					<input name="user_skype" id="user_skype" value="<?php echo esc_attr( get_the_author_meta( 'user_skype', $user->ID ) ); ?>" class="regular-text" type="text">
				</td>
			</tr>
		</table>
		<?php
	}



	/**
	 * Save Skype in Profile
	 * @param $user_id
	 *
	 * @return bool
	 */
	public function testwp_save_skype_in_profile( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}
		update_user_meta( $user_id, 'user_skype', $_POST['user_skype'] );
	}
}

new Testwp_Custom_Reg_Data();

