<?php
/**
 * Plugin Name: Auto Delivery Interval Editor for Welcart
 * Plugin URI: https://github.com/omoikane-works/auto-delivery-interval-editor-for-welcart
 * Description: Allows administrators to edit regular purchase intervals for WCEX Auto Delivery subscriptions.
 * Version: 1.0.0
 * Requires at least: 6.6
 * Requires PHP: 8.2
 * Author: Omoikane Works
 * Author URI: https://github.com/omoikane-works/
 * Text Domain: auto-delivery-interval-editor-for-welcart
 * Domain Path: /languages
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package AutoDeliveryIntervalEditorForWelcart
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ADIE_VERSION', '1.0.0' );
define( 'ADIE_PLUGIN_FILE', __FILE__ );
define( 'ADIE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once ADIE_PLUGIN_DIR . 'includes/class-adie-request.php';
require_once ADIE_PLUGIN_DIR . 'includes/class-adie-regular-interval-hooks.php';
require_once ADIE_PLUGIN_DIR . 'includes/class-adie-plugin.php';

/**

 * Plugin instance.
 *
 * @var ADIE_Plugin|null $adie_plugin
 */
$adie_plugin = null;

add_action(
	'plugins_loaded',
	static function () use ( &$adie_plugin ): void {
		$adie_plugin = new ADIE_Plugin();
		$adie_plugin->boot();
	}
);
