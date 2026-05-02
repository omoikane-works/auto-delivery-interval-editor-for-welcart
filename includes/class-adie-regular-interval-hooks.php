<?php
/**
 * Regular interval hook handlers.
 *
 * @package AutoDeliveryIntervalEditorForWelcart
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles WCEX Auto Delivery interval edit filters.
 */
final class ADIE_Regular_Interval_Hooks {

	/**
	 * Maximum selectable interval in days.
	 */
	private const MAX_DAY_INTERVAL = 90;

	/**
	 * Maximum selectable interval in months.
	 */
	private const MAX_MONTH_INTERVAL = 6;

	/**
	 * Request helper.
	 *
	 * @var ADIE_Request
	 */
	private ADIE_Request $request;

	/**
	 * Constructor.
	 *
	 * @param ADIE_Request $request Request helper.
	 */
	public function __construct( ADIE_Request $request ) {
		$this->request = $request;
	}

	/**
	 * Register filters.
	 *
	 * @return void
	 */
	public function register(): void {
		add_filter(
			'wcad_filter_regular_interval_edit_form',
			array( $this, 'render_interval_edit_form' ),
			10,
			3
		);
		add_filter(
			'wcad_filter_update_regulardetaildata',
			array( $this, 'update_regular_detail_data' ),
			10,
			2
		);
	}

	/**
	 * Render interval edit form.
	 *
	 * @param string               $text   Current interval label.
	 * @param array<string, mixed> $detail Regular detail data.
	 * @param int                  $index  Detail index.
	 * @return string
	 */
	public function render_interval_edit_form( string $text, array $detail, int $index ): string {
		$unit = isset( $detail['regdet_unit'] ) ? (string) $detail['regdet_unit'] : '';

		if ( 'day' !== $unit && 'month' !== $unit ) {
			return '';
		}

		$current_interval = $this->extract_interval_from_text( $text );
		$advance          = isset( $detail['regdet_advance'] ) ? (string) $detail['regdet_advance'] : '';

		return $this->build_interval_select( $index, $unit, $current_interval )
			. $this->build_hidden_advance_field( $index, $advance );
	}

	/**
	 * Update regular detail data query.
	 *
	 * @param string $query Regular detail update query.
	 * @param int    $index Detail index.
	 * @return string
	 */
	public function update_regular_detail_data( string $query, int $index ): string {
		$current_interval = $this->request->post_string( "regdet_interval_{$index}" );
		$new_interval     = $this->request->post_int( "update-interval_{$index}" );

		if ( $new_interval <= 0 || $current_interval === (string) $new_interval ) {
			return $query;
		}

		$encoded_advance = $this->request->post_string( "update-interval-name_{$index}" );

		if ( '' === $encoded_advance ) {
			return $query;
		}

		$new_encoded_advance = $this->replace_interval_in_advance( $encoded_advance, $new_interval );

		if ( null === $new_encoded_advance ) {
			return $query;
		}

		return $this->inject_interval_update( $query, $new_interval, $new_encoded_advance );
	}

	/**
	 * Build interval select HTML.
	 *
	 * @param int    $index            Detail index.
	 * @param string $unit             Interval unit.
	 * @param int    $current_interval Current interval.
	 * @return string
	 */
	private function build_interval_select( int $index, string $unit, int $current_interval ): string {
		$max    = 'day' === $unit ? self::MAX_DAY_INTERVAL : self::MAX_MONTH_INTERVAL;
		$suffix = 'day' === $unit ? '日毎' : 'ヶ月毎';
		$html   = sprintf(
			'<select name="update-interval_%1$d" id="update-interval_%1$d">',
			$index
		);

		for ( $i = 1; $i <= $max; $i++ ) {
			$html .= sprintf(
				'<option value="%1$d"%2$s>%3$s</option>',
				$i,
				selected( $current_interval, $i, false ),
				esc_html( "{$i}{$suffix}" )
			);
		}

		$html .= '</select>';

		return $html;
	}

	/**
	 * Build hidden field for encoded advance data.
	 *
	 * @param int    $index   Detail index.
	 * @param string $advance Encoded advance data.
	 * @return string
	 */
	private function build_hidden_advance_field( int $index, string $advance ): string {
		return sprintf(
			'<input type="hidden" name="update-interval-name_%1$d" value="%2$s">',
			$index,
			esc_attr( $advance )
		);
	}

	/**
	 * Extract interval number from current interval label.
	 *
	 * @param string $text Current interval label.
	 * @return int
	 */
	private function extract_interval_from_text( string $text ): int {
		if ( 1 !== preg_match( '/^([0-9]+)(日毎|ヶ月毎)$/u', $text, $matches ) ) {
			return 0;
		}

		return absint( $matches[1] );
	}

	/**
	 * Replace interval in regdet_advance value.
	 *
	 * @param string $encoded_advance Encoded advance data.
	 * @param int    $new_interval    New interval.
	 * @return string|null
	 */
	private function replace_interval_in_advance( string $encoded_advance, int $new_interval ): ?string {
		$advance = urldecode( $encoded_advance );
		$decoded = json_decode( $advance, true );

		if ( is_array( $decoded ) && array_key_exists( 'interval', $decoded ) ) {
			$decoded['interval'] = (string) $new_interval;

			$json = wp_json_encode( $decoded );

			return is_string( $json ) ? rawurlencode( $json ) : null;
		}

		if ( preg_match( '/interval[0-9]+/u', $advance ) ) {
			return preg_replace(
				'/interval[0-9]+/u',
				'interval' . $new_interval,
				$advance,
				1
			) ?? $advance;
		}

		return null;
	}

	/**
	 * Inject interval update fragment into WCEX Auto Delivery update query.
	 *
	 * @param string $query               Original query.
	 * @param int    $new_interval        New interval.
	 * @param string $new_encoded_advance New encoded advance data.
	 * @return string
	 */
	private function inject_interval_update( string $query, int $new_interval, string $new_encoded_advance ): string {
		if ( ! str_contains( $query, '`regdet_price`' ) ) {
			return $query;
		}

		$replacement = sprintf(
			'`regdet_interval` = %d, `regdet_advance` = \'%s\', `regdet_price`',
			absint( $new_interval ),
			esc_sql( $new_encoded_advance )
		);

		$updated_query = str_replace( '`regdet_price`', $replacement, $query );

		return $updated_query;
	}
}
