<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Rushby Hero Widget
 *
 * Elementor widget for Rushby CZ firearms hero section
 *
 * @since 1.0.0
 */
class Rushby_Hero_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'rushby-hero';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Hero', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-header';
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
		return [ 'hero', 'banner', 'header', 'rushby' ];
	}

	public function get_style_depends(): array {
		return [ 'rushby-widget-hero' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls(): void {

		// ============================================
		// CONTENT TAB - Headline Section
		// ============================================
		$this->start_controls_section(
			'headline_section',
			[
				'label' => esc_html__( 'Headline', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'headline_line1',
			[
				'label' => esc_html__( 'Headline Line 1', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Premium CZ',
				'label_block' => true,
			]
		);

		$this->add_control(
			'headline_line2',
			[
				'label' => esc_html__( 'Headline Line 2 (Colored)', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Firearm Accessories',
				'label_block' => true,
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Precision-engineered triggers, magwells, and performance upgrades for CZ P07, P09, and Shadow 2.',
				'rows' => 4,
			]
		);

		$this->add_control(
			'description_highlight',
			[
				'label' => esc_html__( 'Description Highlight', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Crafted in South Africa, shipped worldwide.',
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Trust Indicators
		// ============================================
		$this->start_controls_section(
			'trust_section',
			[
				'label' => esc_html__( 'Trust Indicators', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_trust_indicators',
			[
				'label' => esc_html__( 'Show Trust Indicators', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'indicator_icon',
			[
				'label' => esc_html__( 'Icon Type', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'star',
				'options' => [
					'star' => esc_html__( 'Star', 'rushby-elementor-widgets' ),
					'check' => esc_html__( 'Check', 'rushby-elementor-widgets' ),
					'globe' => esc_html__( 'Globe', 'rushby-elementor-widgets' ),
				],
			]
		);

		$repeater->add_control(
			'indicator_text',
			[
				'label' => esc_html__( 'Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Trust Indicator',
				'label_block' => true,
			]
		);

		$this->add_control(
			'trust_indicators',
			[
				'label' => esc_html__( 'Indicators', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'indicator_icon' => 'star',
						'indicator_text' => '4.9/5.0 Rating',
					],
					[
						'indicator_icon' => 'check',
						'indicator_text' => 'Lifetime Warranty',
					],
					[
						'indicator_icon' => 'globe',
						'indicator_text' => 'Global Shipping',
					],
				],
				'title_field' => '{{{ indicator_text }}}',
				'condition' => [
					'show_trust_indicators' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - CTA Buttons
		// ============================================
		$this->start_controls_section(
			'buttons_section',
			[
				'label' => esc_html__( 'CTA Buttons', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_button1',
			[
				'label' => esc_html__( 'Show Shop Button', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'button1_text',
			[
				'label' => esc_html__( 'Primary Button Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'SHOP NOW',
				'label_block' => true,
				'condition' => [
					'show_button1' => 'yes',
				],
			]
		);

		$this->add_control(
			'button1_url',
			[
				'label' => esc_html__( 'Primary Button URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => '#',
				],
				'condition' => [
					'show_button1' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_button2',
			[
				'label' => esc_html__( 'Show Compatibility Button', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button2_text',
			[
				'label' => esc_html__( 'Secondary Button Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'View Compatibility Guide',
				'label_block' => true,
				'condition' => [
					'show_button2' => 'yes',
				],
			]
		);

		$this->add_control(
			'button2_url',
			[
				'label' => esc_html__( 'Secondary Button URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => '#',
				],
				'condition' => [
					'show_button2' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Stats
		// ============================================
		$this->start_controls_section(
			'stats_section',
			[
				'label' => esc_html__( 'Statistics', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_stats',
			[
				'label' => esc_html__( 'Show Statistics', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$stats_repeater = new \Elementor\Repeater();

		$stats_repeater->add_control(
			'stat_number',
			[
				'label' => esc_html__( 'Number', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '10K+',
			]
		);

		$stats_repeater->add_control(
			'stat_label',
			[
				'label' => esc_html__( 'Label', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Parts Shipped',
			]
		);

		$this->add_control(
			'stats',
			[
				'label' => esc_html__( 'Stats Items', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $stats_repeater->get_controls(),
				'default' => [
					[
						'stat_number' => '10K+',
						'stat_label' => 'Parts Shipped',
					],
					[
						'stat_number' => '50+',
						'stat_label' => 'Countries',
					],
					[
						'stat_number' => '100%',
						'stat_label' => 'Satisfaction',
					],
				],
				'title_field' => '{{{ stat_number }}} - {{{ stat_label }}}',
				'condition' => [
					'show_stats' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Highlights
		// ============================================
		$this->start_controls_section(
			'highlights_section',
			[
				'label' => esc_html__( 'Highlights', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Highlight Title', 'rushby-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Highlight description text', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'highlights',
			[
				'label' => esc_html__( 'Highlights', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $this->get_default_highlights(),
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Product Showcase
		// ============================================
		$this->start_controls_section(
			'product_section',
			[
				'label' => esc_html__( 'Product Showcase', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'product_image',
			[
				'label' => esc_html__( 'Product Image', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'product_title',
			[
				'label' => esc_html__( 'Product Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Jackal Flat Trigger',
				'label_block' => true,
			]
		);

		$this->add_control(
			'product_subtitle',
			[
				'label' => esc_html__( 'Product Subtitle', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'CZ P07/P09/Omega',
			]
		);

		$this->add_control(
			'product_rating',
			[
				'label' => esc_html__( 'Rating', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '5.0',
			]
		);

		$this->add_control(
			'product_reviews_count',
			[
				'label' => esc_html__( 'Reviews Count', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '22',
			]
		);

		$this->add_control(
			'product_badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'BEST SELLER',
			]
		);

		$this->end_controls_section();

		// ============================================
		// CONTENT TAB - Floating Cards
		// ============================================
		$this->start_controls_section(
			'floating_cards_section',
			[
				'label' => esc_html__( 'Floating Cards', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_floating_cards',
			[
				'label' => esc_html__( 'Show Floating Cards', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'card1_title',
			[
				'label' => esc_html__( 'Card 1 Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Quality Guaranteed',
				'condition' => [
					'show_floating_cards' => 'yes',
				],
			]
		);

		$this->add_control(
			'card1_subtitle',
			[
				'label' => esc_html__( 'Card 1 Subtitle', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '7075 T6 Aluminum',
				'condition' => [
					'show_floating_cards' => 'yes',
				],
			]
		);

		$this->add_control(
			'card2_title',
			[
				'label' => esc_html__( 'Card 2 Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Drop-In Install',
				'condition' => [
					'show_floating_cards' => 'yes',
				],
			]
		);

		$this->add_control(
			'card2_subtitle',
			[
				'label' => esc_html__( 'Card 2 Subtitle', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'No Gunsmith Needed',
				'condition' => [
					'show_floating_cards' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Background
		// ============================================
		$this->start_controls_section(
			'background_style_section',
			[
				'label' => esc_html__( 'Background', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .rushby-hero-section' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'show_background_pattern',
			[
				'label' => esc_html__( 'Show Background Pattern', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rushby-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'rushby-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Badge Style
		// ============================================
		$this->start_controls_section(
			'badge_style_section',
			[
				'label' => esc_html__( 'Badge Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#e4ecd1',
				'selectors' => [
					'{{WRAPPER}} .rushby-badge' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#445024',
				'selectors' => [
					'{{WRAPPER}} .rushby-badge' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'badge_border_color',
			[
				'label' => esc_html__( 'Border Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#cad89b',
				'selectors' => [
					'{{WRAPPER}} .rushby-badge' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'selector' => '{{WRAPPER}} .rushby-badge',
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Headline Style
		// ============================================
		$this->start_controls_section(
			'headline_style_section',
			[
				'label' => esc_html__( 'Headline Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'headline_typography',
				'selector' => '{{WRAPPER}} .rushby-headline',
			]
		);

		$this->add_control(
			'headline_color',
			[
				'label' => esc_html__( 'Line 1 Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .rushby-headline' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'headline_highlight_color',
			[
				'label' => esc_html__( 'Line 2 Color (Highlighted)', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#556b2f',
				'selectors' => [
					'{{WRAPPER}} .rushby-headline-highlight' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Description Style
		// ============================================
		$this->start_controls_section(
			'description_style_section',
			[
				'label' => esc_html__( 'Description Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .rushby-description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#374151',
				'selectors' => [
					'{{WRAPPER}} .rushby-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'description_highlight_color',
			[
				'label' => esc_html__( 'Highlight Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .rushby-description-highlight' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Trust Indicators Style
		// ============================================
		$this->start_controls_section(
			'trust_style_section',
			[
				'label' => esc_html__( 'Trust Indicators Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'trust_text_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .rushby-trust-indicator' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trust_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#556b2f',
				'selectors' => [
					'{{WRAPPER}} .rushby-trust-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'trust_typography',
				'selector' => '{{WRAPPER}} .rushby-trust-indicator',
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Buttons Style
		// ============================================
		$this->start_controls_section(
			'buttons_style_section',
			[
				'label' => esc_html__( 'Buttons Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button1_heading',
			[
				'label' => esc_html__( 'Primary Button', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'button1_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#556b2f',
				'selectors' => [
					'{{WRAPPER}} .rushby-btn-primary' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button1_text_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-btn-primary' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button1_hover_bg_color',
			[
				'label' => esc_html__( 'Hover Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#445024',
				'selectors' => [
					'{{WRAPPER}} .rushby-btn-primary:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button2_heading',
			[
				'label' => esc_html__( 'Secondary Button', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button2_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-btn-secondary' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button2_text_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .rushby-btn-secondary' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button2_border_color',
			[
				'label' => esc_html__( 'Border Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#9CA3AF',
				'selectors' => [
					'{{WRAPPER}} .rushby-btn-secondary' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'buttons_typography',
				'selector' => '{{WRAPPER}} .rushby-btn-primary, {{WRAPPER}} .rushby-btn-secondary',
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Stats Style
		// ============================================
		$this->start_controls_section(
			'stats_style_section',
			[
				'label' => esc_html__( 'Stats Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'stats_number_color',
			[
				'label' => esc_html__( 'Number Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .rushby-stat-number' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'stats_label_color',
			[
				'label' => esc_html__( 'Label Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .rushby-stat-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'stats_border_color',
			[
				'label' => esc_html__( 'Border Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#D1D5DB',
				'selectors' => [
					'{{WRAPPER}} .rushby-stats' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'stats_number_typography',
				'label' => esc_html__( 'Number Typography', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-stat-number',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'stats_label_typography',
				'label' => esc_html__( 'Label Typography', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-stat-label',
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Product Showcase Style
		// ============================================
		$this->start_controls_section(
			'product_style_section',
			[
				'label' => esc_html__( 'Product Showcase Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_card_bg',
			[
				'label' => esc_html__( 'Card Background', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-product-card' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_badge_bg',
			[
				'label' => esc_html__( 'Badge Background', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#556b2f',
				'selectors' => [
					'{{WRAPPER}} .rushby-product-badge' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_badge_text_color',
			[
				'label' => esc_html__( 'Badge Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-product-badge' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// ============================================
		// STYLE TAB - Floating Cards Style
		// ============================================
		$this->start_controls_section(
			'floating_cards_style_section',
			[
				'label' => esc_html__( 'Floating Cards Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'floating_card_bg',
			[
				'label' => esc_html__( 'Card Background', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-floating-card' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'floating_card_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#e4ecd1',
				'selectors' => [
					'{{WRAPPER}} .rushby-floating-card-icon' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'floating_card_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#556b2f',
				'selectors' => [
					'{{WRAPPER}} .rushby-floating-card-icon' => 'color: {{VALUE}}',
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
		?>
		<section class="rushby-hero-section">
			<!-- Background Pattern -->
			<?php if ( $settings['show_background_pattern'] === 'yes' ) : ?>
			<div class="rushby-hero-pattern">
				<div style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23000000' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
			</div>
			<?php endif; ?>

			<div class="rushby-hero-container">
				<div class="rushby-hero-grid">
					<!-- Left Column - Content -->
					<div class="rushby-hero-content">

						<!-- Headline -->
						<div class="rushby-headline-wrapper">
							<h1 class="rushby-headline">
								<?php echo esc_html( $settings['headline_line1'] ); ?>
								<span class="rushby-headline-highlight">
									<?php echo esc_html( $settings['headline_line2'] ); ?>
								</span>
							</h1>

							<p class="rushby-description">
								<?php echo esc_html( $settings['description'] ); ?>
								<?php if ( ! empty( $settings['description_highlight'] ) ) : ?>
									<span class="rushby-description-highlight"> <?php echo esc_html( $settings['description_highlight'] ); ?></span>
								<?php endif; ?>
							</p>
						</div>

						<!-- Trust Indicators -->
						<?php if ( $settings['show_trust_indicators'] === 'yes' && ! empty( $settings['trust_indicators'] ) ) : ?>
						<div class="rushby-trust-indicators">
							<?php foreach ( $settings['trust_indicators'] as $indicator ) : ?>
								<div class="rushby-trust-indicator">
									<?php
									$icon_html = '';
									switch ( $indicator['indicator_icon'] ) {
										case 'star':
											$icon_html = '<svg class="rushby-trust-icon" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
											break;
										case 'check':
											$icon_html = '<svg class="rushby-trust-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
											break;
										case 'globe':
											$icon_html = '<svg class="rushby-trust-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
											break;
									}
									echo $icon_html;
									?>
									<span><?php echo esc_html( $indicator['indicator_text'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>

						<!-- CTA Buttons -->
						<?php if ( $settings['show_button1'] === 'yes' || $settings['show_button2'] === 'yes' ) : ?>
						<div class="rushby-buttons">
							<?php if ( $settings['show_button1'] === 'yes' ) : ?>
								<?php
								$button1_target = $settings['button1_url']['is_external'] ? ' target="_blank"' : '';
								$button1_nofollow = $settings['button1_url']['nofollow'] ? ' rel="nofollow"' : '';
								?>
								<a href="<?php echo esc_url( $settings['button1_url']['url'] ); ?>" class="rushby-btn rushby-btn-primary"<?php echo $button1_target . $button1_nofollow; ?>>
									<?php echo esc_html( $settings['button1_text'] ); ?>
									<svg class="rushby-btn-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
									</svg>
								</a>
							<?php endif; ?>

							<?php if ( $settings['show_button2'] === 'yes' ) : ?>
								<?php
								$button2_target = $settings['button2_url']['is_external'] ? ' target="_blank"' : '';
								$button2_nofollow = $settings['button2_url']['nofollow'] ? ' rel="nofollow"' : '';
								?>
								<a href="<?php echo esc_url( $settings['button2_url']['url'] ); ?>" class="rushby-btn rushby-btn-secondary"<?php echo $button2_target . $button2_nofollow; ?>>
									<?php echo esc_html( $settings['button2_text'] ); ?>
								</a>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<!-- Stats -->
						<?php if ( $settings['show_stats'] === 'yes' && ! empty( $settings['stats'] ) ) : ?>
						<div class="rushby-stats">
							<?php foreach ( $settings['stats'] as $stat ) : ?>
								<div class="rushby-stat">
									<div class="rushby-stat-number"><?php echo esc_html( $stat['stat_number'] ); ?></div>
									<div class="rushby-stat-label"><?php echo esc_html( $stat['stat_label'] ); ?></div>
								</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>

					<!-- Right Column - Product Showcase -->
					<div class="rushby-product-showcase">
						<!-- Main Product Card -->
						<div class="rushby-product-card">
							<div class="rushby-product-inner">
								<div class="rushby-product-content">
									<div class="rushby-product-image-wrapper">
										<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'product_image' ); ?>
									</div>
									<div class="rushby-product-info">
										<h3 class="rushby-product-title"><?php echo esc_html( $settings['product_title'] ); ?></h3>
										<p class="rushby-product-subtitle"><?php echo esc_html( $settings['product_subtitle'] ); ?></p>
										<div class="rushby-product-rating">
											<svg class="rushby-rating-icon" fill="currentColor" viewBox="0 0 20 20">
												<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
											</svg>
											<span><?php echo esc_html( $settings['product_rating'] ); ?> (<?php echo esc_html( $settings['product_reviews_count'] ); ?> reviews)</span>
										</div>
									</div>
								</div>
							</div>

							<!-- Floating Badge -->
							<?php if ( ! empty( $settings['product_badge_text'] ) ) : ?>
							<div class="rushby-product-badge-wrapper">
								<div class="rushby-product-badge"><?php echo esc_html( $settings['product_badge_text'] ); ?></div>
							</div>
							<?php endif; ?>
						</div>

						<!-- Floating Cards -->
						<?php if ( $settings['show_floating_cards'] === 'yes' ) : ?>
						<!-- Card 1 -->
						<div class="rushby-floating-card rushby-floating-card-1">
							<div class="rushby-floating-card-content">
								<div class="rushby-floating-card-icon">
									<svg fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
									</svg>
								</div>
								<div>
									<div class="rushby-floating-card-title"><?php echo esc_html( $settings['card1_title'] ); ?></div>
									<div class="rushby-floating-card-subtitle"><?php echo esc_html( $settings['card1_subtitle'] ); ?></div>
								</div>
							</div>
						</div>

						<!-- Card 2 -->
						<div class="rushby-floating-card rushby-floating-card-2">
							<div class="rushby-floating-card-content">
								<div class="rushby-floating-card-icon">
									<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
									</svg>
								</div>
								<div>
									<div class="rushby-floating-card-title"><?php echo esc_html( $settings['card2_title'] ); ?></div>
									<div class="rushby-floating-card-subtitle"><?php echo esc_html( $settings['card2_subtitle'] ); ?></div>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( ! empty( $settings['highlights'] ) ) : ?>
					<!-- Highlights -->
					<div class="rushby-hero-highlights">
						<?php foreach ( $settings['highlights'] as $highlight ) : ?>
							<div class="rushby-hero-highlight-card">
								<div class="rushby-hero-highlight-icon-wrapper">
									<?php \Elementor\Icons_Manager::render_icon( $highlight['icon'], [ 'aria-hidden' => 'true', 'class' => 'rushby-hero-highlight-icon' ] ); ?>
								</div>
								<h3 class="rushby-hero-highlight-title"><?php echo esc_html( $highlight['title'] ); ?></h3>
								<p class="rushby-hero-highlight-description"><?php echo esc_html( $highlight['description'] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template(): void {
		?>
		<#
		var button1Target = settings.button1_url.is_external ? ' target="_blank"' : '';
		var button1Nofollow = settings.button1_url.nofollow ? ' rel="nofollow"' : '';
		var button2Target = settings.button2_url.is_external ? ' target="_blank"' : '';
		var button2Nofollow = settings.button2_url.nofollow ? ' rel="nofollow"' : '';
		#>
		<section class="rushby-hero-section">
			<!-- Rest of the template for live editing in Elementor -->
			<div class="rushby-hero-container">
				<div class="rushby-hero-grid">
					<div class="rushby-hero-content">

						<div class="rushby-headline-wrapper">
							<h1 class="rushby-headline">
								{{{ settings.headline_line1 }}}
								<span class="rushby-headline-highlight">
									{{{ settings.headline_line2 }}}
								</span>
							</h1>
							<p class="rushby-description">
								{{{ settings.description }}}
								<# if ( settings.description_highlight ) { #>
									<span class="rushby-description-highlight"> {{{ settings.description_highlight }}}</span>
								<# } #>
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}

	/**
	 * Get default highlights
	 */
	private function get_default_highlights(): array {
		return [
			[
				'icon' => [
					'value' => 'fas fa-wrench',
					'library' => 'solid',
				],
				'title' => 'Precision Engineering',
				'description' => 'Every product crafted with meticulous attention to detail',
			],
			[
				'icon' => [
					'value' => 'fas fa-globe',
					'library' => 'solid',
				],
				'title' => 'Global Shipping',
				'description' => 'Delivering quality CZ accessories to shooters worldwide',
			],
			[
				'icon' => [
					'value' => 'fas fa-award',
					'library' => 'solid',
				],
				'title' => 'Lifetime Warranty',
				'description' => 'Standing behind every product with confidence',
			],
		];
	}
}
