<?php
/**
 * About Widget
 *
 * @package Rushby_Elementor_Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Rushby_About_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name(): string {
		return 'rushby_about';
	}

	/**
	 * Get widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby About Section', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-info-circle';
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
		return [ 'about', 'company', 'info', 'rushby' ];
	}

	/**
	 * Get style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'rushby-widget-about', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// Section Header
		$this->start_controls_section(
			'header_section',
			[
				'label' => esc_html__( 'Section Header', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'About Us', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => esc_html__( 'Section Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Rushby Industries', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'section_subtitle',
			[
				'label' => esc_html__( 'Section Subtitle', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Precision CZ Parts and Accessories', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// Image Section
		$this->start_controls_section(
			'image_section',
			[
				'label' => esc_html__( 'Image', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label' => esc_html__( 'Show Floating Badge', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'badge_label',
			[
				'label' => esc_html__( 'Badge Label', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Made in', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_value',
			[
				'label' => esc_html__( 'Badge Value', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'South Africa', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Content Section
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'paragraph_1',
			[
				'label' => esc_html__( 'Paragraph 1', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => 'Rushby Industries is a dynamic parts designing and manufacturing firm nestled in the heart of <strong>Cape Town, South Africa</strong>. Our journey began with a simple aspiration: to create parts that elevated our EDC pistols, particularly focusing on <strong>CZ P07/P09 accessories</strong>. Over time, our passion and dedication have seen our product line expand, reflecting our company\'s growth and evolution.',
			]
		);

		$this->add_control(
			'paragraph_2',
			[
				'label' => esc_html__( 'Paragraph 2', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => 'At Rushby Industries, CZ P07/P09 accessories remain at the forefront of our endeavors. However, our commitment to innovation and excellence has propelled us to diversify our offerings. From our humble beginnings as a grassroots South African initiative, we have expanded our reach, now <strong>shipping our meticulously crafted parts worldwide</strong>.',
			]
		);

		$this->add_control(
			'paragraph_3',
			[
				'label' => esc_html__( 'Paragraph 3', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => 'We take immense pride in the reputation we have garnered for delivering <strong>top-tier, precision-engineered CZ accessories</strong>. Our relentless pursuit of quality and attention to detail underscore every facet of our work, ensuring that each product bearing the Rushby Industries name meets the highest standards.',
			]
		);

		$this->add_control(
			'cta_quote',
			[
				'label' => esc_html__( 'Call to Action Quote', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Join us on our journey as we continue to push boundaries, innovate, and set new benchmarks in the realm of CZ accessories. Experience the Rushby Industries difference today.', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// Highlights Section
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
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .rushby-about-section' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => esc_html__( 'Primary Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#556b2f',
				'selectors' => [
					'{{WRAPPER}} .rushby-about-badge' => 'background-color: rgba(85, 107, 47, 0.12); color: {{VALUE}};',
					'{{WRAPPER}} .rushby-about-subtitle' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rushby-about-cta-quote' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .rushby-about-highlight-icon-wrapper' => 'background-color: rgba(85, 107, 47, 0.12);',
					'{{WRAPPER}} .rushby-about-highlight-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rushby-about-floating-badge-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#374151',
				'selectors' => [
					'{{WRAPPER}} .rushby-about-paragraph' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rushby-about-highlight-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .rushby-about-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rushby-about-highlight-title' => 'color: {{VALUE}};',
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
				'name' => 'title_typography',
				'label' => esc_html__( 'Title', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-about-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => esc_html__( 'Content', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-about-paragraph',
			]
		);

		$this->end_controls_section();
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

	/**
	 * Render widget output
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		?>
		<section class="rushby-about-section">
			<!-- Background Decoration -->
			<div class="rushby-about-bg-decoration"></div>

			<div class="rushby-about-container">
				<!-- Section Header -->
				<div class="rushby-about-header">
					<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<div class="rushby-about-badge">
							<svg class="rushby-about-badge-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
							</svg>
							<?php echo esc_html( $settings['badge_text'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['section_title'] ) ) : ?>
						<h2 class="rushby-about-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $settings['section_subtitle'] ) ) : ?>
						<p class="rushby-about-subtitle"><?php echo esc_html( $settings['section_subtitle'] ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Content Grid -->
				<div class="rushby-about-content-grid">
					<!-- Image -->
					<div class="rushby-about-image-column">
						<div class="rushby-about-image-wrapper">
							<img
								src="<?php echo esc_url( $settings['image']['url'] ); ?>"
								alt="<?php echo esc_attr( $settings['section_title'] ); ?>"
								class="rushby-about-image"
							/>
							<?php if ( 'yes' === $settings['show_badge'] ) : ?>
								<!-- Floating Badge -->
								<div class="rushby-about-floating-badge">
									<div class="rushby-about-floating-badge-content">
										<svg class="rushby-about-floating-badge-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
										</svg>
										<div>
											<div class="rushby-about-badge-label"><?php echo esc_html( $settings['badge_label'] ); ?></div>
											<div class="rushby-about-badge-value"><?php echo esc_html( $settings['badge_value'] ); ?></div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<!-- Decorative Elements -->
						<div class="rushby-about-decoration rushby-about-decoration-1"></div>
						<div class="rushby-about-decoration rushby-about-decoration-2"></div>
					</div>

					<!-- Content -->
					<div class="rushby-about-text-column">
						<?php if ( ! empty( $settings['paragraph_1'] ) ) : ?>
							<div class="rushby-about-paragraph">
								<?php echo wp_kses_post( $settings['paragraph_1'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['paragraph_2'] ) ) : ?>
							<div class="rushby-about-paragraph">
								<?php echo wp_kses_post( $settings['paragraph_2'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['paragraph_3'] ) ) : ?>
							<div class="rushby-about-paragraph">
								<?php echo wp_kses_post( $settings['paragraph_3'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['cta_quote'] ) ) : ?>
							<!-- Call to Action -->
							<div class="rushby-about-cta">
								<p class="rushby-about-cta-quote">
									<?php echo esc_html( $settings['cta_quote'] ); ?>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( ! empty( $settings['highlights'] ) ) : ?>
					<!-- Highlights -->
					<div class="rushby-about-highlights">
						<?php foreach ( $settings['highlights'] as $highlight ) : ?>
							<div class="rushby-about-highlight-card">
								<div class="rushby-about-highlight-icon-wrapper">
									<?php \Elementor\Icons_Manager::render_icon( $highlight['icon'], [ 'aria-hidden' => 'true', 'class' => 'rushby-about-highlight-icon' ] ); ?>
								</div>
								<h3 class="rushby-about-highlight-title"><?php echo esc_html( $highlight['title'] ); ?></h3>
								<p class="rushby-about-highlight-description"><?php echo esc_html( $highlight['description'] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
