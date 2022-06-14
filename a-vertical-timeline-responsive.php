<?php 
/**
 *  Plugin Name:      Vertical Timeline Responsive
 * Plugin URI:        https://thetechydots.com/
 * Description:       A simple way to create timeline for your website. Support shortcode and Elementor page builder.
 * Version:           2.0.0
 * Author:            Jahur Ahmed
 * Author URI:        https://thetechydots.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       avtlr
 * Domain Path:       /languages
 */

namespace AVTLR;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define most essential constants.
define( 'AVTLR_VERSION', '2.0.0' );
define( 'AVTLR_PLUGIN_MAIN_FILE', __FILE__ );
define( 'AVTLR_PHP_MINIMUM', '5.6.0' );
define( 'AVTLR_DIR', plugin_dir_url(__FILE__) );
define( 'AVTLR_URL', plugins_url( '/', __FILE__ ) );


if ( ! version_compare( PHP_VERSION, AVTLR_PHP_MINIMUM, '>=' ) ) {
    return false;
}

/**
 * Handles plugin activation.
 *
 * Throws an error if the plugin is activated with an insufficient version of PHP.
 *
 * @since 2.0.0
 * @since 2.0.0 Minimum required version of PHP raised to 5.6
 * @access private
 *
 * @param bool $network_wide Whether to activate network-wide.
 */
function avtlr_activate_plugin( $network_wide ) {
	if ( version_compare( PHP_VERSION, AVTLR_PHP_MINIMUM, '<' ) ) {
		wp_die(
			/* translators: %s: version number */
			esc_html( sprintf( __( 'Vertical Timeline Responsive requires PHP version %s', 'avtlr' ), AVTLR_PHP_MINIMUM ) ),
			esc_html__( 'Error Activating', 'avtlr' )
		);
	}

	if ( $network_wide ) {
		return;
	}

	do_action( 'avtlr_activation', $network_wide );
}
register_activation_hook( __FILE__, 'AVTLR\avtlr_activate_plugin' );

/**
 * Handles plugin deactivation.
 *
 * @since 1.1.1
 * @access private
 *
 * @param bool $network_wide Whether to deactivate network-wide.
 */
function avtlr_deactivate_plugin( $network_wide ) {
	if ( version_compare( PHP_VERSION, AVTLR_PHP_MINIMUM, '<' ) ) {
		return;
	}

	if ( $network_wide ) {
		return;
	}

	do_action( 'avtlr_deactivation', $network_wide );
}
register_deactivation_hook( __FILE__, 'AVTLR\avtlr_deactivate_plugin' );


class Avtlr_Main{

    public function load_dependencies(){

		require_once 'includes/admin/wp-metabox-api/class-hd-wp-metabox-api.php';

		require_once 'includes/admin/class_functions.php';
        $enqueue_scripts = new \AVTLR\Includes\Admin\Admin_Functions();

        require_once 'includes/public/class_enqueue_scripts.php';
        $enqueue_scripts = new \AVTLR\Includes\Public\Enqueue_Scripts();

        require_once 'includes/public/class_shortcode.php';
        $shortcode = new \AVTLR\Includes\Public\Shortcode();

		require_once 'elementor/class-load-elementor-widget.php';
        $shortcode = new \AVTLR\Includes\ElementorVtlr\Load();
        
    }

}


function load_avtlr(){
    $pg = new Avtlr_Main();
    $pg->load_dependencies();
}

add_action( 'plugins_loaded', 'AVTLR\load_avtlr' );

