<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Rushby Header Widget
 *
 * Elementor widget for Rushby CZ firearms header/navigation
 *
 * @since 1.0.0
 */
class Rushby_Header_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'rushby-header';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Header', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-nav-menu';
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
		return [ 'header', 'navigation', 'menu', 'nav', 'rushby' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls(): void {

		// ============================================
		// CONTENT TAB - Logo Section
		// ============================================
		$this->start_controls_section(
			'logo_section',
			[
				'label' => esc_html__( 'Logo', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'logo_image',
			[
				'label' => esc_html__( 'Logo Image', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'logo_text_line1',
			[
				'label' => esc_html__( 'Logo Text Line 1', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'RUSHBY',
				'label_block' => true,
			]
		);

		$this->add_control(
			'logo_text_line2',
			[
				'label' => esc_html__( 'Logo Text Line 2', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'INDUSTRIES',
				'label_block' => true,
			]
		);

		$this->add_control(
			'logo_url',
			[
				'label' => esc_html__( 'Logo Link URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => home_url( '/' ),
				],
			]
		);

		$this->add_control(
			'show_logo_text_mobile',
			[
				'label' => esc_html__( 'Show Logo Text on Mobile', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Navigation Menu
		// ============================================
		$this->start_controls_section(
			'menu_section',
			[
				'label' => esc_html__( 'Navigation Menu', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Get all registered menus
		$menus = wp_get_nav_menus();
		$menu_options = [];
		foreach ( $menus as $menu ) {
			$menu_options[ $menu->term_id ] = $menu->name;
		}

		$this->add_control(
			'menu_id',
			[
				'label' => esc_html__( 'Select Menu', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $menu_options,
				'default' => ! empty( $menu_options ) ? array_key_first( $menu_options ) : '',
				'description' => esc_html__( 'Select a WordPress menu to display. Create menus in Appearance > Menus.', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Header Features
		// ============================================
		$this->start_controls_section(
			'features_section',
			[
				'label' => esc_html__( 'Header Features', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_search',
			[
				'label' => esc_html__( 'Show Search', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'label' => esc_html__( 'Search Placeholder', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Search for triggers, magwells, springs...',
				'label_block' => true,
				'condition' => [
					'show_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_currency_switcher',
			[
				'label' => esc_html__( 'Show Currency Switcher', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__( 'Show currency switcher dropdown (requires Currency Converter for WooCommerce plugin)', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'currency_codes',
			[
				'label' => esc_html__( 'Currency Codes', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'USD, EUR, GBP, ZAR, CAD, AUD',
				'description' => esc_html__( 'Enter currency codes separated by commas (e.g., USD, EUR, GBP)', 'rushby-elementor-widgets' ),
				'label_block' => true,
				'condition' => [
					'show_currency_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_account',
			[
				'label' => esc_html__( 'Show Account Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'account_url',
			[
				'label' => esc_html__( 'Account Page URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '#',
				],
				'condition' => [
					'show_account' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_cart',
			[
				'label' => esc_html__( 'Show Cart', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'cart_url',
			[
				'label' => esc_html__( 'Cart Page URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#',
				],
				'condition' => [
					'show_cart' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Header Style
		// ============================================
		$this->start_controls_section(
			'header_style_section',
			[
				'label' => esc_html__( 'Header Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#374151',
				'selectors' => [
					'{{WRAPPER}} .rushby-header' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'header_sticky',
			[
				'label' => esc_html__( 'Sticky Header', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'header_height',
			[
				'label' => esc_html__( 'Header Height', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 60,
						'max' => 120,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 80,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-header-inner' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Logo Style
		// ============================================
		$this->start_controls_section(
			'logo_style_section',
			[
				'label' => esc_html__( 'Logo Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'logo_image_size',
			[
				'label' => esc_html__( 'Logo Image Size', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'size' => 48,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-logo-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'logo_text_color',
			[
				'label' => esc_html__( 'Logo Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-logo-text-line1' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'logo_subtext_color',
			[
				'label' => esc_html__( 'Logo Subtext Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#D1D5DB',
				'selectors' => [
					'{{WRAPPER}} .rushby-logo-text-line2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'logo_text_typography',
				'label' => esc_html__( 'Logo Text Typography', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-logo-text-line1',
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Menu Style
		// ============================================
		$this->start_controls_section(
			'menu_style_section',
			[
				'label' => esc_html__( 'Menu Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'menu_text_color',
			[
				'label' => esc_html__( 'Menu Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .rushby-nav-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_text_hover_color',
			[
				'label' => esc_html__( 'Menu Hover Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-nav-link:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'selector' => '{{WRAPPER}} .rushby-nav-link',
			]
		);

		$this->add_responsive_control(
			'menu_spacing',
			[
				'label' => esc_html__( 'Item Spacing', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 60,
						'step' => 2,
					],
				],
				'default' => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-nav' => 'gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Icons Style
		// ============================================
		$this->start_controls_section(
			'icons_style_section',
			[
				'label' => esc_html__( 'Icons Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#D1D5DB',
				'selectors' => [
					'{{WRAPPER}} .rushby-header-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-header-icon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_badge_bg_color',
			[
				'label' => esc_html__( 'Cart Badge Background', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#DC2626',
				'selectors' => [
					'{{WRAPPER}} .rushby-cart-badge' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_badge_text_color',
			[
				'label' => esc_html__( 'Cart Badge Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-cart-badge' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Mobile Menu Style
		// ============================================
		$this->start_controls_section(
			'mobile_menu_style_section',
			[
				'label' => esc_html__( 'Mobile Menu Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mobile_menu_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#374151',
				'selectors' => [
					'{{WRAPPER}} .rushby-mobile-menu' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'mobile_menu_border_color',
			[
				'label' => esc_html__( 'Border Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .rushby-mobile-menu' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
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
	 * Render widget output on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// Get WooCommerce cart count
		$cart_count = 0;
		if ( function_exists( 'WC' ) && WC()->cart ) {
			$cart_count = WC()->cart->get_cart_contents_count();
		}

		$sticky_class = $settings['header_sticky'] === 'yes' ? 'rushby-header-sticky' : '';
		$mobile_logo_text_class = $settings['show_logo_text_mobile'] === 'yes' ? '' : 'rushby-logo-text-hide-mobile';
		?>
		<header class="rushby-header <?php echo esc_attr( $sticky_class ); ?>">
			<!-- Main Header -->
			<div class="rushby-header-container">
				<div class="rushby-header-inner">
					<!-- Logo -->
					<?php
					$logo_target = $settings['logo_url']['is_external'] ? ' target="_blank"' : '';
					$logo_nofollow = $settings['logo_url']['nofollow'] ? ' rel="nofollow"' : '';
					?>
					<a href="<?php echo esc_url( $settings['logo_url']['url'] ); ?>" class="rushby-logo-link"<?php echo $logo_target . $logo_nofollow; ?>>
						<div class="rushby-logo">
							<div class="rushby-logo-image-wrapper">
								<?php if ( ! empty( $settings['logo_image']['url'] ) ) : ?>
									<img src="<?php echo esc_url( $settings['logo_image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['logo_text_line1'] ); ?>" class="rushby-logo-image" />
								<?php endif; ?>
							</div>
							<div class="rushby-logo-text <?php echo esc_attr( $mobile_logo_text_class ); ?>">
								<div class="rushby-logo-text-line1"><?php echo esc_html( $settings['logo_text_line1'] ); ?></div>
								<div class="rushby-logo-text-line2"><?php echo esc_html( $settings['logo_text_line2'] ); ?></div>
							</div>
						</div>
					</a>

					<!-- Desktop Navigation -->
					<nav class="rushby-nav">
						<?php
						if ( ! empty( $settings['menu_id'] ) ) {
							wp_nav_menu(
								array(
									'menu'            => $settings['menu_id'],
									'container'       => false,
									'menu_class'      => 'rushby-nav-list',
									'fallback_cb'     => false,
									'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
									'depth'           => 1,
									'walker'          => new Rushby_Walker_Nav_Menu(),
								)
							);
						}
						?>
					</nav>

					<!-- Right Actions -->
					<div class="rushby-header-actions">
						<!-- Currency Switcher -->
						<?php if ( $settings['show_currency_switcher'] === 'yes' && class_exists( 'WC_Currency_Converter' ) ) : ?>
							<?php
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
							$current_flag = isset( $currency_flags[ $current_currency ] ) ? $currency_flags[ $current_currency ] : '💱';

							// Ensure plugin scripts are enqueued
							$converter_instance = WC_Currency_Converter::instance();
							$converter_instance->enqueue_assets();
							wp_enqueue_script( 'wc_currency_converter' );
							wp_enqueue_script( 'wc_currency_converter_inline' );
							?>
							<div class="rushby-header-currency-switcher rushby-currency-hide-mobile">
								<button class="rushby-currency-switcher-button" onclick="rushbyToggleHeaderCurrency(this)" aria-label="<?php esc_attr_e( 'Select currency', 'rushby-elementor-widgets' ); ?>">
									<span class="rushby-currency-flag-desktop"><?php echo esc_html( $current_flag ); ?></span>
									<span class="rushby-currency-code-text"><?php echo esc_html( $current_currency ); ?></span>
									<svg class="rushby-currency-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
									</svg>
								</button>
								<div class="rushby-currency-dropdown" style="display: none;">
									<?php foreach ( $currency_codes as $currency ) : ?>
										<?php
										$is_active = $current_currency === $currency;
										$currency_name = function_exists( 'get_woocommerce_currencies' ) ? get_woocommerce_currencies()[ $currency ] ?? $currency : $currency;
										$currency_flag = $currency_flags[ $currency ] ?? '💱';
										$currency_symbol = get_woocommerce_currency_symbol( $currency );
										?>
										<button
											class="rushby-currency-dropdown-item <?php echo $is_active ? 'active' : ''; ?>"
											data-currencycode="<?php echo esc_attr( $currency ); ?>"
											onclick="rushbySelectHeaderCurrency(this)"
										>
											<span class="rushby-currency-dropdown-flag"><?php echo esc_html( $currency_flag ); ?></span>
											<div class="rushby-currency-dropdown-details">
												<div class="rushby-currency-dropdown-code"><?php echo esc_html( $currency ); ?></div>
												<div class="rushby-currency-dropdown-name"><?php echo esc_html( $currency_name ); ?></div>
											</div>
											<span class="rushby-currency-dropdown-symbol"><?php echo esc_html( $currency_symbol ); ?></span>
										</button>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<!-- Search -->
						<?php if ( $settings['show_search'] === 'yes' ) : ?>
						<button class="rushby-header-icon rushby-search-toggle" onclick="rushbyToggleSearch(this)">
							<svg class="rushby-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
							</svg>
						</button>
						<?php endif; ?>

						<!-- Account -->
						<?php if ( $settings['show_account'] === 'yes' ) : ?>
							<?php
							$account_target = $settings['account_url']['is_external'] ? ' target="_blank"' : '';
							$account_nofollow = $settings['account_url']['nofollow'] ? ' rel="nofollow"' : '';
							?>
							<a href="<?php echo esc_url( $settings['account_url']['url'] ); ?>" class="rushby-header-icon rushby-account-icon-hide-mobile"<?php echo $account_target . $account_nofollow; ?>>
								<svg class="rushby-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
								</svg>
							</a>
						<?php endif; ?>

						<!-- Cart -->
						<?php if ( $settings['show_cart'] === 'yes' ) : ?>
							<button type="button" class="rushby-header-icon rushby-cart-icon" onclick="rushbyOpenSideCart()">
								<svg class="rushby-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
								</svg>
								<?php if ( $cart_count > 0 ) : ?>
									<span class="rushby-cart-badge rushby-cart-count"><?php echo esc_html( $cart_count ); ?></span>
								<?php endif; ?>
							</button>
						<?php endif; ?>

						<!-- Mobile Menu Toggle -->
						<button class="rushby-header-icon rushby-mobile-toggle" onclick="rushbyToggleMobileMenu(this)">
							<svg class="rushby-icon rushby-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
							</svg>
							<svg class="rushby-icon rushby-close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
							</svg>
						</button>
					</div>
				</div>

				<!-- Search Bar -->
				<?php if ( $settings['show_search'] === 'yes' ) : ?>
				<div class="rushby-search-bar" style="display: none;">
					<div class="rushby-search-inner">
						<form role="search" method="get" class="rushby-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<div class="rushby-search-wrapper">
								<svg class="rushby-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
								</svg>
								<input type="search" name="s" class="rushby-search-input" placeholder="<?php echo esc_attr( $settings['search_placeholder'] ); ?>" value="<?php echo get_search_query(); ?>" />
								<?php if ( function_exists( 'WC' ) ) : ?>
									<input type="hidden" name="post_type" value="product" />
								<?php endif; ?>
							</div>
						</form>
					</div>
				</div>
				<?php endif; ?>
			</div>

			<!-- Mobile Menu -->
			<div class="rushby-mobile-menu" style="display: none;">
				<div class="rushby-mobile-menu-inner">
					<?php
					if ( ! empty( $settings['menu_id'] ) ) {
						wp_nav_menu(
							array(
								'menu'            => $settings['menu_id'],
								'container'       => false,
								'menu_class'      => 'rushby-mobile-nav-list',
								'fallback_cb'     => false,
								'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
								'depth'           => 1,
								'walker'          => new Rushby_Walker_Nav_Menu(),
							)
						);
					}
					?>
				</div>
			</div>
		</header>

		<!-- Side Cart -->
		<?php if ( $settings['show_cart'] === 'yes' && function_exists( 'WC' ) ) : ?>
			<!-- Backdrop -->
			<div class="rushby-side-cart-backdrop" onclick="rushbyCloseSideCart()" style="display: none;"></div>

			<!-- Side Cart Panel -->
			<div class="rushby-side-cart-panel" style="display: none;">
				<!-- Header -->
				<div class="rushby-side-cart-header">
					<div class="rushby-side-cart-title-row">
						<svg class="rushby-side-cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
						</svg>
						<h2 class="rushby-side-cart-title">
							<?php esc_html_e( 'Shopping Cart', 'rushby-elementor-widgets' ); ?> (<span class="rushby-cart-count"><?php echo esc_html( $cart_count ); ?></span>)
						</h2>
					</div>
					<button type="button" class="rushby-side-cart-close" onclick="rushbyCloseSideCart()">
						<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
						</svg>
					</button>
				</div>

				<!-- Cart Content (Dynamic) -->
				<div class="rushby-side-cart-content">
					<?php rushby_render_side_cart_content(); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php
	}
}

/**
 * Custom Walker for Navigation Menu
 */
class Rushby_Walker_Nav_Menu extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

		$output .= '<li class="' . esc_attr( $class_names ) . '">';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';
		$atts['class']  = 'rushby-nav-link';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
