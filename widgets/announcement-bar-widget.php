<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Rushby Announcement Bar Widget
 *
 * Elementor widget for Rushby CZ firearms announcement bar with contact info and social links
 *
 * @since 1.0.0
 */
class Rushby_Announcement_Bar_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'rushby-announcement-bar';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Announcement Bar', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-info-bar';
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
		return [ 'announcement', 'bar', 'contact', 'social', 'header', 'rushby' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls(): void {

		// ============================================
		// CONTENT TAB - Contact Information Section
		// ============================================
		$this->start_controls_section(
			'contact_section',
			[
				'label' => esc_html__( 'Contact Information', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_contact',
			[
				'label' => esc_html__( 'Show Contact Info', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'email',
			[
				'label' => esc_html__( 'Email Address', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'info@rushbyindustries.com',
				'label_block' => true,
				'condition' => [
					'show_contact' => 'yes',
				],
			]
		);

		$this->add_control(
			'phone',
			[
				'label' => esc_html__( 'Phone Number', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '+27 12 345 6789',
				'label_block' => true,
				'condition' => [
					'show_contact' => 'yes',
				],
			]
		);

		$this->add_control(
			'phone_link',
			[
				'label' => esc_html__( 'Phone Link (tel:)', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '+27123456789',
				'label_block' => true,
				'description' => esc_html__( 'Phone number without spaces for tel: link', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_contact' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Mobile Currency Switcher Section
		// ============================================
		$this->start_controls_section(
			'mobile_currency_section',
			[
				'label' => esc_html__( 'Mobile Currency Switcher', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_mobile_currency_switcher',
			[
				'label' => esc_html__( 'Show Mobile Currency Switcher', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__( 'Show currency switcher on mobile (requires Currency Converter for WooCommerce plugin)', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'mobile_currency_codes',
			[
				'label' => esc_html__( 'Currency Codes', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'USD, EUR, GBP, ZAR, CAD, AUD',
				'description' => esc_html__( 'Enter currency codes separated by commas (e.g., USD, EUR, GBP)', 'rushby-elementor-widgets' ),
				'label_block' => true,
				'condition' => [
					'show_mobile_currency_switcher' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Social Media Section
		// ============================================
		$this->start_controls_section(
			'social_section',
			[
				'label' => esc_html__( 'Social Media', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_social_label',
			[
				'label' => esc_html__( 'Show "Follow Us" Label', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'social_label_text',
			[
				'label' => esc_html__( 'Social Label Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Follow Us:',
				'condition' => [
					'show_social_label' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_facebook',
			[
				'label' => esc_html__( 'Show Facebook', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'facebook_url',
			[
				'label' => esc_html__( 'Facebook URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://facebook.com/yourpage', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => 'https://facebook.com',
				],
				'condition' => [
					'show_facebook' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_instagram',
			[
				'label' => esc_html__( 'Show Instagram', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'instagram_url',
			[
				'label' => esc_html__( 'Instagram URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://instagram.com/yourpage', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => 'https://instagram.com',
				],
				'condition' => [
					'show_instagram' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_twitter',
			[
				'label' => esc_html__( 'Show Twitter', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'twitter_url',
			[
				'label' => esc_html__( 'Twitter URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://twitter.com/yourpage', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => 'https://twitter.com',
				],
				'condition' => [
					'show_twitter' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_youtube',
			[
				'label' => esc_html__( 'Show YouTube', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'youtube_url',
			[
				'label' => esc_html__( 'YouTube URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com/yourchannel', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => 'https://youtube.com',
				],
				'condition' => [
					'show_youtube' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Bar Style
		// ============================================
		$this->start_controls_section(
			'bar_style_section',
			[
				'label' => esc_html__( 'Bar Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bar_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#1F2937',
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-bar' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'bar_border_color',
			[
				'label' => esc_html__( 'Border Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#374151',
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-bar' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'bar_height',
			[
				'label' => esc_html__( 'Bar Height', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 80,
						'step' => 2,
					],
				],
				'default' => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-bar-inner' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Contact Style
		// ============================================
		$this->start_controls_section(
			'contact_style_section',
			[
				'label' => esc_html__( 'Contact Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'contact_text_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#D1D5DB',
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-contact-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'contact_text_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-contact-link:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'contact_typography',
				'label' => esc_html__( 'Typography', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-announcement-contact-text',
			]
		);

		$this->add_responsive_control(
			'contact_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 30,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 14,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-contact-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'contact_spacing',
			[
				'label' => esc_html__( 'Item Spacing', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-contact' => 'gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Social Icons Style
		// ============================================
		$this->start_controls_section(
			'social_style_section',
			[
				'label' => esc_html__( 'Social Icons Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'social_label_color',
			[
				'label' => esc_html__( 'Label Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#9CA3AF',
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-social-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'social_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#9CA3AF',
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-social-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'social_icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-social-link:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 30,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-social-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'social_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 30,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 12,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-announcement-social' => 'gap: {{SIZE}}{{UNIT}}',
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
		?>
		<div class="rushby-announcement-bar">
			<div class="rushby-announcement-container">
				<div class="rushby-announcement-bar-inner">
					<!-- Left - Contact Info -->
					<?php if ( $settings['show_contact'] === 'yes' ) : ?>
					<div class="rushby-announcement-contact">
						<?php if ( ! empty( $settings['email'] ) ) : ?>
						<a href="mailto:<?php echo esc_attr( $settings['email'] ); ?>" class="rushby-announcement-contact-link">
							<svg class="rushby-announcement-contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
							</svg>
							<span class="rushby-announcement-contact-text"><?php echo esc_html( $settings['email'] ); ?></span>
						</a>
						<?php endif; ?>

						<?php if ( ! empty( $settings['phone'] ) ) : ?>
						<a href="tel:<?php echo esc_attr( $settings['phone_link'] ); ?>" class="rushby-announcement-contact-link">
							<svg class="rushby-announcement-contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
							</svg>
							<span class="rushby-announcement-contact-text"><?php echo esc_html( $settings['phone'] ); ?></span>
						</a>
						<?php endif; ?>
					</div>
					<?php endif; ?>

					<!-- Center - Currency Switcher (Mobile Only) -->
					<?php if ( $settings['show_mobile_currency_switcher'] === 'yes' && class_exists( 'WC_Currency_Converter' ) ) : ?>
						<?php
						// Parse currency codes
						$mobile_currency_codes = array_map( 'trim', array_filter( explode( ',', $settings['mobile_currency_codes'] ) ) );
						if ( empty( $mobile_currency_codes ) ) {
							$mobile_currency_codes = [ 'USD', 'EUR', 'GBP' ];
						}

						// Get current currency
						$mobile_current_currency = get_woocommerce_currency();
						if ( ! empty( $_COOKIE['woocommerce_current_currency'] ) ) {
							$mobile_current_currency = sanitize_text_field( wp_unslash( $_COOKIE['woocommerce_current_currency'] ) );
						}

						// Get currency flags
						$mobile_currency_flags = $this->get_currency_flags();
						$mobile_current_flag = isset( $mobile_currency_flags[ $mobile_current_currency ] ) ? $mobile_currency_flags[ $mobile_current_currency ] : '💱';

						// Ensure plugin scripts are enqueued
						$converter_instance = WC_Currency_Converter::instance();
						$converter_instance->enqueue_assets();
						wp_enqueue_script( 'wc_currency_converter' );
						wp_enqueue_script( 'wc_currency_converter_inline' );
						?>
						<div class="rushby-announcement-mobile-currency rushby-mobile-only">
							<button class="rushby-announcement-currency-button" onclick="rushbyToggleAnnouncementCurrency(this)" aria-label="<?php esc_attr_e( 'Select currency', 'rushby-elementor-widgets' ); ?>">
								<span class="rushby-currency-flag"><?php echo esc_html( $mobile_current_flag ); ?></span>
								<span class="rushby-currency-code"><?php echo esc_html( $mobile_current_currency ); ?></span>
								<svg class="rushby-currency-chevron-small" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
								</svg>
							</button>
							<div class="rushby-announcement-currency-dropdown" style="display: none;">
								<?php foreach ( $mobile_currency_codes as $currency ) : ?>
									<?php
									$is_active = $mobile_current_currency === $currency;
									$currency_name = function_exists( 'get_woocommerce_currencies' ) ? get_woocommerce_currencies()[ $currency ] ?? $currency : $currency;
									$currency_flag = $mobile_currency_flags[ $currency ] ?? '💱';
									$currency_symbol = get_woocommerce_currency_symbol( $currency );
									?>
									<button
										class="rushby-announcement-currency-item <?php echo $is_active ? 'active' : ''; ?>"
										data-currencycode="<?php echo esc_attr( $currency ); ?>"
										onclick="rushbySelectAnnouncementCurrency(this)"
									>
										<span class="rushby-currency-flag-small"><?php echo esc_html( $currency_flag ); ?></span>
										<div class="rushby-currency-details-small">
											<div class="rushby-currency-code-small"><?php echo esc_html( $currency ); ?></div>
											<div class="rushby-currency-name-small"><?php echo esc_html( $currency_name ); ?></div>
										</div>
										<span class="rushby-currency-symbol-small"><?php echo esc_html( $currency_symbol ); ?></span>
									</button>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>

					<!-- Right - Social Icons -->
					<div class="rushby-announcement-social">
						<?php if ( $settings['show_social_label'] === 'yes' && ! empty( $settings['social_label_text'] ) ) : ?>
						<span class="rushby-announcement-social-label"><?php echo esc_html( $settings['social_label_text'] ); ?></span>
						<?php endif; ?>

						<?php if ( $settings['show_facebook'] === 'yes' && ! empty( $settings['facebook_url']['url'] ) ) : ?>
							<?php
							$facebook_target = $settings['facebook_url']['is_external'] ? ' target="_blank"' : '';
							$facebook_nofollow = $settings['facebook_url']['nofollow'] ? ' rel="nofollow noopener noreferrer"' : ' rel="noopener noreferrer"';
							?>
							<a href="<?php echo esc_url( $settings['facebook_url']['url'] ); ?>" class="rushby-announcement-social-link" aria-label="Facebook"<?php echo $facebook_target . $facebook_nofollow; ?>>
								<svg class="rushby-announcement-social-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
								</svg>
							</a>
						<?php endif; ?>

						<?php if ( $settings['show_instagram'] === 'yes' && ! empty( $settings['instagram_url']['url'] ) ) : ?>
							<?php
							$instagram_target = $settings['instagram_url']['is_external'] ? ' target="_blank"' : '';
							$instagram_nofollow = $settings['instagram_url']['nofollow'] ? ' rel="nofollow noopener noreferrer"' : ' rel="noopener noreferrer"';
							?>
							<a href="<?php echo esc_url( $settings['instagram_url']['url'] ); ?>" class="rushby-announcement-social-link" aria-label="Instagram"<?php echo $instagram_target . $instagram_nofollow; ?>>
								<svg class="rushby-announcement-social-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
								</svg>
							</a>
						<?php endif; ?>

						<?php if ( $settings['show_twitter'] === 'yes' && ! empty( $settings['twitter_url']['url'] ) ) : ?>
							<?php
							$twitter_target = $settings['twitter_url']['is_external'] ? ' target="_blank"' : '';
							$twitter_nofollow = $settings['twitter_url']['nofollow'] ? ' rel="nofollow noopener noreferrer"' : ' rel="noopener noreferrer"';
							?>
							<a href="<?php echo esc_url( $settings['twitter_url']['url'] ); ?>" class="rushby-announcement-social-link" aria-label="Twitter"<?php echo $twitter_target . $twitter_nofollow; ?>>
								<svg class="rushby-announcement-social-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
								</svg>
							</a>
						<?php endif; ?>

						<?php if ( $settings['show_youtube'] === 'yes' && ! empty( $settings['youtube_url']['url'] ) ) : ?>
							<?php
							$youtube_target = $settings['youtube_url']['is_external'] ? ' target="_blank"' : '';
							$youtube_nofollow = $settings['youtube_url']['nofollow'] ? ' rel="nofollow noopener noreferrer"' : ' rel="noopener noreferrer"';
							?>
							<a href="<?php echo esc_url( $settings['youtube_url']['url'] ); ?>" class="rushby-announcement-social-link" aria-label="YouTube"<?php echo $youtube_target . $youtube_nofollow; ?>>
								<svg class="rushby-announcement-social-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
								</svg>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
