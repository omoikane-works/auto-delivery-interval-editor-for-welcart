<?php
/**
 * Main plugin class.
 *
 * @package AutoDeliveryIntervalEditorForWelcart
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
final class ADIE_Plugin {

	/**
	 * Regular interval hooks.
	 *
	 * @var ADIE_Regular_Interval_Hooks|Null
	 */
	private ?ADIE_Regular_Interval_Hooks $adie_regular_interval_hooks = null;

	/**
	 * Boot the plugin.
	 *
	 * @return void
	 */
	public function boot(): void {
		$this->load_textdomain();

		if ( ! $this->is_auto_delivery_active() ) {
			add_action(
				'admin_notices',
				array( $this, 'render_missing_dependency_notice' )
			);
			return;
		}

		$this->adie_regular_interval_hooks = new ADIE_Regular_Interval_Hooks( new ADIE_Request() );
		$this->adie_regular_interval_hooks->register();
	}

	/**
	 * Load plugin translations.
	 *
	 * @return void
	 */
	private function load_textdomain(): void {
		load_plugin_textdomain(
			'auto-delivery-interval-editor-for-welcart',
			false,
			dirname( plugin_basename( ADIE_PLUGIN_FILE ) ) . '/languages'
		);
	}

	/**
	 * Determine whether WCEX Auto Delivery is active.
	 *
	 * @return bool
	 */
	private function is_auto_delivery_active(): bool {
		return defined( 'WCEX_AUTO_DELIVERY' );
	}

	/**
	 * Render missing dependency notice.
	 *
	 * @return void
	 */
	public function render_missing_dependency_notice(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		echo '<div class="notice notice-warning"><p>';
		echo esc_html__(
			'Auto Delivery Interval Editor for Welcart requires Welcart and WCEX Auto Delivery to be active.',
			'auto-delivery-interval-editor-for-welcart'
		);
		echo '</p></div>';
	}
}
