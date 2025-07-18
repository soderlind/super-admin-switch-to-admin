<?php
/**
 * Super Admin Switch to Admin
 *
 * @package     Namespace
 * @author      Per Soderlind
 * @copyright   2021 Per Soderlind
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Super Admin Switch to Admin
 * Plugin URI: https://github.com/soderlind/super-admin-switch-to-admin
 * GitHub Plugin URI: https://github.com/soderlind/super-admin-switch-to-admin
 * Description: If you are logged in as a super admin, allows you to switch to a regular admin account on the current site.
 * Version:     1.0.9
 * Author:      Per Soderlind
 * Author URI:  https://soderlind.no
 * Network:     true
 * Text Domain: super-admin-switch-to-admin
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

declare(strict_types=1);
namespace Soderlind\Plugin\SuperAdminSwitchToAdmin;

if ( ! defined( 'ABSPATH' ) ) {
	wp_die();
}


define( 'SWITCH_TO_ADMIN_VERSION', '1.0.4' );
define( 'SWITCH_TO_ADMIN_FILE', __FILE__ );
define( 'SWITCH_TO_ADMIN_PATH', plugin_dir_path( SWITCH_TO_ADMIN_FILE ) );

require_once SWITCH_TO_ADMIN_PATH . 'vendor/autoload.php';

// Include plugin updater
if ( ! class_exists( 'Soderlind\WordPress\GitHub_Plugin_Updater' ) ) {
	require_once SWITCH_TO_ADMIN_PATH . 'class-github-plugin-updater.php';
}

// Initialize the plugin updater.
\Soderlind\WordPress\GitHub_Plugin_Updater::create_with_assets(
	'https://github.com/soderlind/super-admin-switch-to-admin',
	SWITCH_TO_ADMIN_FILE,
	'super-admin-switch-to-admin',
	'/super-admin-switch-to-admin\.zip/',
	'main'
);

/**
 * Class SuperAdminSwitchToAdmin
 */
class SuperAdminSwitchToAdmin {

	/**
	 * Admin list.
	 *
	 * @var array
	 */
	private $admin_list = [];

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', [ $this, 'switch_to_admin' ] );

	}

	/**
	 * Switch to admin.
	 *
	 * @return void
	 */
	public function switch_to_admin() {
		// Bail if current site is not a multisite.
		if ( ! \is_multisite() ) {
			return;
		}
		// Bail if the current user is not a super admin.
		if ( ! \is_super_admin() ) {
			return;
		}

		// Check if User Switching plugin is active.
		if ( function_exists( 'current_user_switched' ) ) {
			\load_plugin_textdomain( 'super-admin-switch-to-admin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
			$switched_user = \current_user_switched();
			// Bail if the user has already switched to another admin.
			if ( $switched_user ) {
				return;
			}

			// List all admins for the current site, except for the super admins.
			$admins = get_users(
				[ 
					'blog_id' => \get_current_blog_id(),
					'role'    => 'administrator',
					'exclude' => $this->get_super_admins_ids(),
				]
			);

			// Collect all the admins for the current site.
			foreach ( $admins as $admin ) {
				$this->admin_list[ $admin->ID ] = $admin->display_name;
			}

			// If there is more than one admin, show the dropdown in the admin notices.
			if ( count( $this->admin_list ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice' ] );
			}
		}
	}

	/**
	 * Admin notice.
	 *
	 * @return void
	 */
	public function admin_notice() {
		?>
		<div class="updated notice notice-success is-dismissible">

			<p>
				<span class="dashicons dashicons-admin-users" style="color:#56c234" aria-hidden="true"></span>
				<?php esc_html_e( 'You are logged in as a super admin. You can switch to a regular admin account on this site:', 'super-admin-switch-to-admin' ); ?>

				<?php
				// list admins in wp notice as a comma separated list. do not add a comma after the last admin.
				$last_admin = end( $this->admin_list );
				foreach ( $this->admin_list as $admin_id => $admin_name ) {
					printf(
						'<a href="%1$s">%2$s</a>%3$s',
						esc_url( \user_switching::maybe_switch_url( \get_user_by( 'id', $admin_id ) ) ),
						esc_html( $admin_name ),
						$admin_name === $last_admin ? '' : ', '
					);
				}

				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Get super admins ids.
	 *
	 * @return array
	 */
	private function get_super_admins_ids() {
		$super_admins     = \get_super_admins();
		$super_admins_ids = [];
		foreach ( $super_admins as $super_admin ) {
			$super_admins_ids[] = \get_user_by( 'login', $super_admin )->ID;
		}
		return $super_admins_ids;
	}

}

new SuperAdminSwitchToAdmin();
