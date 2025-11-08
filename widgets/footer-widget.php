<?php
/**
 * Footer Widget
 *
 * @package Rushby_Elementor_Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Rushby_Footer_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name(): string {
		return 'rushby_footer';
	}

	/**
	 * Get widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Footer', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-footer';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories(): array {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 */
	public function get_keywords(): array {
		return [ 'footer', 'newsletter', 'links', 'social', 'rushby' ];
	}

	/**
	 * Get style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'rushby-widget-footer', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// Newsletter Section
		$this->start_controls_section(
			'newsletter_section',
			[
				'label' => esc_html__( 'Newsletter Section', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_newsletter',
			[
				'label' => esc_html__( 'Show Newsletter Section', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'newsletter_title',
			[
				'label' => esc_html__( 'Newsletter Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Stay Updated', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_newsletter' => 'yes',
				],
			]
		);

		$this->add_control(
			'newsletter_description',
			[
				'label' => esc_html__( 'Newsletter Description', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Get exclusive deals, new product launches, and installation tips delivered to your inbox.', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_newsletter' => 'yes',
				],
			]
		);

		$this->add_control(
			'newsletter_button_text',
			[
				'label' => esc_html__( 'Button Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Subscribe', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_newsletter' => 'yes',
				],
			]
		);

		$this->add_control(
			'newsletter_discount_text',
			[
				'label' => esc_html__( 'Discount Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Get 10% off your first order when you subscribe', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_newsletter' => 'yes',
				],
			]
		);

		$this->add_control(
			'newsletter_form_action',
			[
				'label' => esc_html__( 'Form Action URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-mailchimp-url.com', 'rushby-elementor-widgets' ),
				'description' => esc_html__( 'Enter your newsletter service form action URL (e.g., MailChimp, ConvertKit)', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_newsletter' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Brand Section
		$this->start_controls_section(
			'brand_section',
			[
				'label' => esc_html__( 'Brand & Logo', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'logo',
			[
				'label' => esc_html__( 'Logo', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'brand_name',
			[
				'label' => esc_html__( 'Brand Name', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'RUSHBY', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'brand_tagline',
			[
				'label' => esc_html__( 'Brand Tagline', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'INDUSTRIES', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'brand_description',
			[
				'label' => esc_html__( 'Brand Description', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Precision-engineered CZ firearm accessories from Cape Town, South Africa.', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// Social Media Section
		$this->start_controls_section(
			'social_media_section',
			[
				'label' => esc_html__( 'Social Media', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'facebook_url',
			[
				'label' => esc_html__( 'Facebook URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://facebook.com/rushbyindustries', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'instagram_url',
			[
				'label' => esc_html__( 'Instagram URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://instagram.com/rushbyindustries', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'youtube_url',
			[
				'label' => esc_html__( 'YouTube URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com/channel/UCDgCnlBaiViGkX_e4pFIGRQ', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// Footer Column 1
		$this->add_footer_column_controls( 1, 'Shop', $this->get_default_shop_links() );

		// Footer Column 2
		$this->add_footer_column_controls( 2, 'By Model', $this->get_default_model_links() );

		// Footer Column 3
		$this->add_footer_column_controls( 3, 'Support', $this->get_default_support_links() );

		// Footer Column 4
		$this->add_footer_column_controls( 4, 'Company', $this->get_default_company_links() );

		// Trust Badges Section
		$this->start_controls_section(
			'trust_badges_section',
			[
				'label' => esc_html__( 'Trust Badges', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_trust_badges',
			[
				'label' => esc_html__( 'Show Trust Badges', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Trust Badge', 'rushby-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'badge_icon',
			[
				'label' => esc_html__( 'Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-check-circle',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'trust_badges',
			[
				'label' => esc_html__( 'Trust Badges', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $this->get_default_trust_badges(),
				'title_field' => '{{{ badge_text }}}',
				'condition' => [
					'show_trust_badges' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Bottom Bar Section
		$this->start_controls_section(
			'bottom_bar_section',
			[
				'label' => esc_html__( 'Bottom Bar', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'copyright_text',
			[
				'label' => esc_html__( 'Copyright Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '© 2025 Rushby Industries. All rights reserved. | Reg: 2020/053579/07', 'rushby-elementor-widgets' ),
			]
		);

		$repeater_links = new \Elementor\Repeater();

		$repeater_links->add_control(
			'link_text',
			[
				'label' => esc_html__( 'Link Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Link', 'rushby-elementor-widgets' ),
			]
		);

		$repeater_links->add_control(
			'link_url',
			[
				'label' => esc_html__( 'Link URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
			]
		);

		$this->add_control(
			'bottom_links',
			[
				'label' => esc_html__( 'Bottom Links', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater_links->get_controls(),
				'default' => $this->get_default_bottom_links(),
				'title_field' => '{{{ link_text }}}',
			]
		);

		$this->end_controls_section();

		// Style Tab - Colors
		$this->start_controls_section(
			'style_colors',
			[
				'label' => esc_html__( 'Colors', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#09090b',
				'selectors' => [
					'{{WRAPPER}} .rushby-footer' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#a1a1aa',
				'selectors' => [
					'{{WRAPPER}} .rushby-footer' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .rushby-footer-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => esc_html__( 'Accent Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#d97706',
				'selectors' => [
					'{{WRAPPER}} .rushby-footer-subscribe-btn' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .rushby-footer-social-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Typography
		$this->start_controls_section(
			'style_typography',
			[
				'label' => esc_html__( 'Typography', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'label' => esc_html__( 'Headings', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-footer-heading',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => esc_html__( 'Text', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-footer-text',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Add footer column controls
	 */
	private function add_footer_column_controls( int $column_num, string $default_title, array $default_links ): void {
		$this->start_controls_section(
			"column_{$column_num}_section",
			[
				'label' => sprintf( esc_html__( 'Column %d', 'rushby-elementor-widgets' ), $column_num ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			"column_{$column_num}_title",
			[
				'label' => esc_html__( 'Column Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => $default_title,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'link_text',
			[
				'label' => esc_html__( 'Link Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Link', 'rushby-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'link_url',
			[
				'label' => esc_html__( 'Link URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
			]
		);

		$this->add_control(
			"column_{$column_num}_links",
			[
				'label' => esc_html__( 'Links', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $default_links,
				'title_field' => '{{{ link_text }}}',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get default shop links
	 */
	private function get_default_shop_links(): array {
		return [
			[ 'link_text' => 'Triggers', 'link_url' => [ 'url' => '/shop/triggers' ] ],
			[ 'link_text' => 'Magwells', 'link_url' => [ 'url' => '/shop/magwells' ] ],
			[ 'link_text' => 'Spring Kits', 'link_url' => [ 'url' => '/shop/springs' ] ],
			[ 'link_text' => 'Performance Upgrades', 'link_url' => [ 'url' => '/shop/performance' ] ],
			[ 'link_text' => 'Magazine Extensions', 'link_url' => [ 'url' => '/shop/magazine-extensions' ] ],
		];
	}

	/**
	 * Get default model links
	 */
	private function get_default_model_links(): array {
		return [
			[ 'link_text' => 'CZ P07', 'link_url' => [ 'url' => '/shop/p07' ] ],
			[ 'link_text' => 'CZ P09', 'link_url' => [ 'url' => '/shop/p09' ] ],
			[ 'link_text' => 'Shadow 2', 'link_url' => [ 'url' => '/shop/shadow-2' ] ],
			[ 'link_text' => 'Omega P01', 'link_url' => [ 'url' => '/shop/omega' ] ],
		];
	}

	/**
	 * Get default support links
	 */
	private function get_default_support_links(): array {
		return [
			[ 'link_text' => 'Contact Us', 'link_url' => [ 'url' => '/contact' ] ],
			[ 'link_text' => 'Shipping Info', 'link_url' => [ 'url' => '/shipping' ] ],
			[ 'link_text' => 'Returns Policy', 'link_url' => [ 'url' => '/returns' ] ],
			[ 'link_text' => 'Warranty', 'link_url' => [ 'url' => '/warranty' ] ],
			[ 'link_text' => 'FAQ', 'link_url' => [ 'url' => '/faq' ] ],
		];
	}

	/**
	 * Get default company links
	 */
	private function get_default_company_links(): array {
		return [
			[ 'link_text' => 'About Us', 'link_url' => [ 'url' => '/about' ] ],
			[ 'link_text' => 'Quality Guarantee', 'link_url' => [ 'url' => '/quality' ] ],
			[ 'link_text' => 'Compatibility Guide', 'link_url' => [ 'url' => '/compatibility' ] ],
			[ 'link_text' => 'Installation Guides', 'link_url' => [ 'url' => '/installation' ] ],
			[ 'link_text' => 'Become a Dealer', 'link_url' => [ 'url' => '/dealers' ] ],
		];
	}

	/**
	 * Get default trust badges
	 */
	private function get_default_trust_badges(): array {
		return [
			[
				'badge_text' => 'Secure Checkout',
				'badge_icon' => [
					'value' => 'fas fa-shield-alt',
					'library' => 'solid',
				],
			],
			[
				'badge_text' => 'Lifetime Warranty',
				'badge_icon' => [
					'value' => 'fas fa-check-circle',
					'library' => 'solid',
				],
			],
			[
				'badge_text' => 'Premium Quality',
				'badge_icon' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			],
			[
				'badge_text' => 'Worldwide Shipping',
				'badge_icon' => [
					'value' => 'fas fa-shipping-fast',
					'library' => 'solid',
				],
			],
		];
	}

	/**
	 * Get default bottom links
	 */
	private function get_default_bottom_links(): array {
		return [
			[ 'link_text' => 'Privacy Policy', 'link_url' => [ 'url' => '/privacy' ] ],
			[ 'link_text' => 'Terms of Service', 'link_url' => [ 'url' => '/terms' ] ],
			[ 'link_text' => 'Sitemap', 'link_url' => [ 'url' => '/sitemap' ] ],
		];
	}

	/**
	 * Render widget output
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		?>
		<footer class="rushby-footer">
			<?php if ( 'yes' === $settings['show_newsletter'] ) : ?>
				<!-- Newsletter Section -->
				<div class="rushby-footer-newsletter">
					<div class="rushby-footer-container">
						<div class="rushby-footer-newsletter-grid">
							<div class="rushby-footer-newsletter-content">
								<h3 class="rushby-footer-heading rushby-footer-newsletter-title">
									<?php echo esc_html( $settings['newsletter_title'] ); ?>
								</h3>
								<p class="rushby-footer-text rushby-footer-newsletter-description">
									<?php echo esc_html( $settings['newsletter_description'] ); ?>
								</p>
							</div>
							<div class="rushby-footer-newsletter-form-wrapper">
								<form class="rushby-footer-newsletter-form" action="<?php echo esc_url( $settings['newsletter_form_action']['url'] ?? '#' ); ?>" method="post">
									<input
										type="email"
										name="email"
										placeholder="<?php esc_attr_e( 'Enter your email', 'rushby-elementor-widgets' ); ?>"
										required
										class="rushby-footer-newsletter-input"
									/>
									<button type="submit" class="rushby-footer-subscribe-btn">
										<svg class="rushby-footer-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
										</svg>
										<span><?php echo esc_html( $settings['newsletter_button_text'] ); ?></span>
									</button>
								</form>
								<?php if ( ! empty( $settings['newsletter_discount_text'] ) ) : ?>
									<p class="rushby-footer-newsletter-discount">
										<?php echo esc_html( $settings['newsletter_discount_text'] ); ?>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<!-- Main Footer Content -->
			<div class="rushby-footer-main">
				<div class="rushby-footer-container">
					<div class="rushby-footer-columns">
						<!-- Brand Column -->
						<div class="rushby-footer-brand-column">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rushby-footer-brand-link">
								<div class="rushby-footer-logo-wrapper">
									<img
										src="<?php echo esc_url( $settings['logo']['url'] ); ?>"
										alt="<?php echo esc_attr( $settings['brand_name'] ); ?>"
										class="rushby-footer-logo"
									/>
								</div>
								<div class="rushby-footer-brand-text">
									<div class="rushby-footer-brand-name"><?php echo esc_html( $settings['brand_name'] ); ?></div>
									<div class="rushby-footer-brand-tagline"><?php echo esc_html( $settings['brand_tagline'] ); ?></div>
								</div>
							</a>
							<p class="rushby-footer-text rushby-footer-brand-description">
								<?php echo esc_html( $settings['brand_description'] ); ?>
							</p>
							<!-- Social Media -->
							<div class="rushby-footer-social">
								<?php if ( ! empty( $settings['facebook_url']['url'] ) ) : ?>
									<a href="<?php echo esc_url( $settings['facebook_url']['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="rushby-footer-social-link">
										<svg fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $settings['instagram_url']['url'] ) ) : ?>
									<a href="<?php echo esc_url( $settings['instagram_url']['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="rushby-footer-social-link">
										<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $settings['youtube_url']['url'] ) ) : ?>
									<a href="<?php echo esc_url( $settings['youtube_url']['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="rushby-footer-social-link">
										<svg fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
									</a>
								<?php endif; ?>
							</div>
						</div>

						<!-- Footer Columns 1-4 -->
						<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
							<?php
							$column_title = $settings["column_{$i}_title"];
							$column_links = $settings["column_{$i}_links"];
							?>
							<div class="rushby-footer-link-column">
								<h4 class="rushby-footer-heading rushby-footer-column-title">
									<?php echo esc_html( $column_title ); ?>
								</h4>
								<ul class="rushby-footer-link-list">
									<?php foreach ( $column_links as $link ) : ?>
										<li>
											<a href="<?php echo esc_url( $link['link_url']['url'] ?? '#' ); ?>" class="rushby-footer-link">
												<?php echo esc_html( $link['link_text'] ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endfor; ?>
					</div>

					<?php if ( 'yes' === $settings['show_trust_badges'] && ! empty( $settings['trust_badges'] ) ) : ?>
						<!-- Trust Badges -->
						<div class="rushby-footer-trust-badges">
							<?php foreach ( $settings['trust_badges'] as $badge ) : ?>
								<div class="rushby-footer-trust-badge">
									<?php \Elementor\Icons_Manager::render_icon( $badge['badge_icon'], [ 'aria-hidden' => 'true', 'class' => 'rushby-footer-trust-icon' ] ); ?>
									<span class="rushby-footer-trust-text"><?php echo esc_html( $badge['badge_text'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- Bottom Bar -->
					<div class="rushby-footer-bottom">
						<div class="rushby-footer-bottom-content">
							<div class="rushby-footer-copyright rushby-footer-text">
								<?php echo esc_html( $settings['copyright_text'] ); ?>
							</div>
							<?php if ( ! empty( $settings['bottom_links'] ) ) : ?>
								<div class="rushby-footer-bottom-links">
									<?php foreach ( $settings['bottom_links'] as $link ) : ?>
										<a href="<?php echo esc_url( $link['link_url']['url'] ?? '#' ); ?>" class="rushby-footer-bottom-link">
											<?php echo esc_html( $link['link_text'] ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<?php
	}
}
