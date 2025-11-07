<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Rushby Floating Currency Switcher Widget
 *
 * Elementor widget for floating currency selector that integrates with Currency Converter for WooCommerce plugin
 *
 * @since 1.0.0
 */
class Rushby_Floating_Currency_Switcher_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'rushby-floating-currency-switcher';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Floating Currency Switcher', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-global-settings';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories(): array {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords(): array {
		return [ 'currency', 'converter', 'switcher', 'floating', 'money', 'rushby' ];
	}

	/**
	 * Get available currencies from WooCommerce Currency Converter plugin
	 *
	 * @return array
	 */
	private function get_available_currencies(): array {
		// Default currencies if plugin is not available
		$default_currencies = [
			'USD' => [ 'name' => 'US Dollar', 'symbol' => '$', 'flag' => '🇺🇸' ],
			'EUR' => [ 'name' => 'Euro', 'symbol' => '€', 'flag' => '🇪🇺' ],
			'GBP' => [ 'name' => 'British Pound', 'symbol' => '£', 'flag' => '🇬🇧' ],
			'ZAR' => [ 'name' => 'South African Rand', 'symbol' => 'R', 'flag' => '🇿🇦' ],
			'CAD' => [ 'name' => 'Canadian Dollar', 'symbol' => 'C$', 'flag' => '🇨🇦' ],
			'AUD' => [ 'name' => 'Australian Dollar', 'symbol' => 'A$', 'flag' => '🇦🇺' ],
		];

		return $default_currencies;
	}

	/**
	 * Get currency flags mapping
	 *
	 * @return array
	 */
	private function get_currency_flags(): array {
		return [
			'USD' => '🇺🇸',
			'EUR' => '🇪🇺',
			'GBP' => '🇬🇧',
			'ZAR' => '🇿🇦',
			'CAD' => '🇨🇦',
			'AUD' => '🇦🇺',
			'JPY' => '🇯🇵',
			'CHF' => '🇨🇭',
			'CNY' => '🇨🇳',
			'INR' => '🇮🇳',
			'MXN' => '🇲🇽',
			'BRL' => '🇧🇷',
			'KRW' => '🇰🇷',
			'RUB' => '🇷🇺',
			'SEK' => '🇸🇪',
			'NOK' => '🇳🇴',
			'DKK' => '🇩🇰',
			'NZD' => '🇳🇿',
			'SGD' => '🇸🇬',
			'HKD' => '🇭🇰',
		];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls(): void {

		// ============================================
		// CONTENT TAB - Currencies Section
		// ============================================
		$this->start_controls_section(
			'currencies_section',
			[
				'label' => esc_html__( 'Currencies', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'currency_codes',
			[
				'label' => esc_html__( 'Currency Codes', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'USD, EUR, GBP, ZAR, CAD, AUD',
				'description' => esc_html__( 'Enter currency codes separated by commas (e.g., USD, EUR, GBP). These must match currencies configured in Currency Converter for WooCommerce plugin.', 'rushby-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'disable_location',
			[
				'label' => esc_html__( 'Disable Location Detection', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
				'description' => esc_html__( 'Disable automatic currency detection based on user location', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Settings Section
		// ============================================
		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Settings', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_on_mobile_only',
			[
				'label' => esc_html__( 'Show on Mobile Only', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__( 'Only show the floating button on mobile/tablet devices', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_position',
			[
				'label' => esc_html__( 'Button Position', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'bottom-right',
				'options' => [
					'bottom-right' => esc_html__( 'Bottom Right', 'rushby-elementor-widgets' ),
					'bottom-left'  => esc_html__( 'Bottom Left', 'rushby-elementor-widgets' ),
					'top-right'    => esc_html__( 'Top Right', 'rushby-elementor-widgets' ),
					'top-left'     => esc_html__( 'Top Left', 'rushby-elementor-widgets' ),
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Button Style
		// ============================================
		$this->start_controls_section(
			'button_style_section',
			[
				'label' => esc_html__( 'Floating Button', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#DC2626',
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-float-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => esc_html__( 'Hover Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#B91C1C',
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-float-button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-float-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'button_size',
			[
				'label' => esc_html__( 'Button Size', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 80,
						'step' => 2,
					],
				],
				'default' => [
					'size' => 56,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-float-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'button_offset',
			[
				'label' => esc_html__( 'Offset from Edge', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-float-container.bottom-right' => 'bottom: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rushby-currency-float-container.bottom-left' => 'bottom: {{SIZE}}{{UNIT}}; left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rushby-currency-float-container.top-right' => 'top: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rushby-currency-float-container.top-left' => 'top: {{SIZE}}{{UNIT}}; left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Menu Style
		// ============================================
		$this->start_controls_section(
			'menu_style_section',
			[
				'label' => esc_html__( 'Currency Menu', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'menu_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-menu' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_border_color',
			[
				'label' => esc_html__( 'Border Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-menu' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rushby-currency-menu-header' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_item_hover_bg',
			[
				'label' => esc_html__( 'Item Hover Background', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#F3F4F6',
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-item:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_item_active_bg',
			[
				'label' => esc_html__( 'Active Item Background', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FEE2E2',
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-item.active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_width',
			[
				'label' => esc_html__( 'Menu Width', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 400,
						'step' => 10,
					],
				],
				'default' => [
					'size' => 240,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-currency-menu' => 'min-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// Check if Currency Converter plugin is active
		if ( ! class_exists( 'WC_Currency_Converter' ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div style="padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 4px;">';
				echo '<strong>' . esc_html__( 'Currency Converter for WooCommerce plugin is not active!', 'rushby-elementor-widgets' ) . '</strong><br>';
				echo esc_html__( 'Please install and activate the Currency Converter for WooCommerce plugin for this widget to work.', 'rushby-elementor-widgets' );
				echo '</div>';
			}
			return;
		}

		// Parse currency codes
		$currency_codes = array_map( 'trim', array_filter( explode( ',', $settings['currency_codes'] ) ) );
		if ( empty( $currency_codes ) ) {
			$currency_codes = [ 'USD', 'EUR', 'GBP' ];
		}

		// Get current currency
		$current_currency = get_woocommerce_currency();
		if ( ! empty( $_COOKIE['woocommerce_current_currency'] ) ) {
			$current_currency = sanitize_text_field( wp_unslash( $_COOKIE['woocommerce_current_currency'] ) );
		}

		// Get currency flags
		$currency_flags = $this->get_currency_flags();

		// Position classes
		$position_class = esc_attr( $settings['button_position'] );
		$mobile_only_class = $settings['show_on_mobile_only'] === 'yes' ? 'rushby-mobile-only' : '';

		// Enqueue Currency Converter plugin assets
		$converter_instance = WC_Currency_Converter::instance();
		$instance = [
			'currency_codes'   => implode( ',', $currency_codes ),
			'disable_location' => $settings['disable_location'] === 'yes' ? '1' : '0',
		];

		// Ensure plugin scripts are enqueued
		$converter_instance->enqueue_assets();
		wp_enqueue_script( 'wc_currency_converter' );
		wp_enqueue_script( 'wc_currency_converter_inline' );

		?>
		<div class="rushby-currency-float-container <?php echo esc_attr( $position_class . ' ' . $mobile_only_class ); ?>" data-currencies="<?php echo esc_attr( json_encode( $currency_codes ) ); ?>">
			<!-- Floating Button -->
			<button class="rushby-currency-float-button" aria-label="<?php esc_attr_e( 'Change currency', 'rushby-elementor-widgets' ); ?>" onclick="rushbyToggleCurrencyMenu(this)">
				<div class="rushby-currency-button-content">
					<span class="rushby-currency-flag" data-currency="<?php echo esc_attr( $current_currency ); ?>">
						<?php echo isset( $currency_flags[ $current_currency ] ) ? esc_html( $currency_flags[ $current_currency ] ) : '💱'; ?>
					</span>
					<span class="rushby-currency-code"><?php echo esc_html( $current_currency ); ?></span>
				</div>
			</button>

			<!-- Currency Menu -->
			<div class="rushby-currency-menu" style="display: none;">
				<!-- Header -->
				<div class="rushby-currency-menu-header">
					<span class="rushby-currency-menu-title"><?php esc_html_e( 'Select Currency', 'rushby-elementor-widgets' ); ?></span>
					<button class="rushby-currency-menu-close" onclick="rushbyCloseCurrencyMenu(this)" aria-label="<?php esc_attr_e( 'Close', 'rushby-elementor-widgets' ); ?>">
						<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
						</svg>
					</button>
				</div>

				<!-- Currency List -->
				<div class="rushby-currency-list">
					<?php foreach ( $currency_codes as $currency ) : ?>
						<?php
						$is_active = $current_currency === $currency;
						$currency_name = function_exists( 'get_woocommerce_currencies' ) ? get_woocommerce_currencies()[ $currency ] ?? $currency : $currency;
						$currency_flag = $currency_flags[ $currency ] ?? '💱';
						?>
						<button
							class="rushby-currency-item <?php echo $is_active ? 'active' : ''; ?>"
							data-currencycode="<?php echo esc_attr( $currency ); ?>"
							onclick="rushbySelectCurrency(this)"
						>
							<span class="rushby-currency-item-flag"><?php echo esc_html( $currency_flag ); ?></span>
							<div class="rushby-currency-item-details">
								<div class="rushby-currency-item-code"><?php echo esc_html( $currency ); ?></div>
								<div class="rushby-currency-item-name"><?php echo esc_html( $currency_name ); ?></div>
							</div>
							<?php if ( $is_active ) : ?>
								<div class="rushby-currency-item-indicator"></div>
							<?php endif; ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}
}
