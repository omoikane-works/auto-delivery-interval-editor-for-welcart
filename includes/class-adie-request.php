<?php
/**
 * Request helper class.
 *
 * @package AutoDeliveryIntervalEditorForWelcart
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provides sanitized access to request values.
 */
final class ADIE_Request {

	/**
	 * Get a string value from POST data.
	 *
	 * @param string $key       POST key.
	 * @param string $fallback  Fallback value.
	 * @return string
	 */
	public function post_string( string $key, string $fallback = '' ): string {
		if ( ! isset( $_POST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is verified by WCEX Auto Delivery before this filter runs.
			return $fallback;
		}

		$value = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized below.

		if ( is_array( $value ) ) {
			return $fallback;
		}

		return sanitize_text_field( $value );
	}

	/**
	 * Get an integer value from POST data.
	 *
	 * @param string $key       POST key.
	 * @param int    $fallback  Fallback value.
	 * @return int
	 */
	public function post_int( string $key, int $fallback = 0 ): int {
		if ( ! isset( $_POST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is verified by WCEX Auto Delivery before this filter runs.
			return $fallback;
		}

		$value = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized below.

		if ( is_array( $value ) ) {
			return $fallback;
		}

		return absint( $value );
	}
}
