<?php
/**
 * Product Page Widget
 *
 * @package Rushby_Elementor_Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Rushby_Product_Page_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name(): string {
		return 'rushby_product_page';
	}

	/**
	 * Get widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Product Page', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-single-product';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories(): array {
		return [ 'woocommerce-elements' ];
	}

	/**
	 * Get widget keywords.
	 */
	public function get_keywords(): array {
		return [ 'product', 'woocommerce', 'single', 'page', 'rushby' ];
	}

	public function get_style_depends(): array {
		return [ 'rushby-widget-product-page' ];
	}

	public function get_script_depends(): array {
		return [ 'rushby-widgets-frontend', 'wc-add-to-cart-variation' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {

		// Content Settings
		$this->start_controls_section(
			'content_settings',
			[
				'label' => esc_html__( 'Content Settings', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_breadcrumb',
			[
				'label' => esc_html__( 'Show Breadcrumb', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_back_button',
			[
				'label' => esc_html__( 'Show Back Button', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'back_button_text',
			[
				'label' => esc_html__( 'Back Button Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Back to Products', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_back_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'back_button_url',
			[
				'label' => esc_html__( 'Back Button URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( '/shop', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => '/shop',
				],
				'condition' => [
					'show_back_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label' => esc_html__( 'Show Badge', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__( 'Show Category', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label' => esc_html__( 'Show Rating', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_sku',
			[
				'label' => esc_html__( 'Show SKU', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_stock_status',
			[
				'label' => esc_html__( 'Show Stock Status', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
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

		$this->add_control(
			'show_features',
			[
				'label' => esc_html__( 'Show Key Features', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_specifications',
			[
				'label' => esc_html__( 'Show Specifications', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_related_products',
			[
				'label' => esc_html__( 'Show Related Products', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'related_products_title',
			[
				'label' => esc_html__( 'Related Products Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'You May Also Like', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_related_products' => 'yes',
				],
			]
		);

		$this->add_control(
			'related_products_count',
			[
				'label' => esc_html__( 'Related Products Count', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 3,
				'min' => 1,
				'max' => 12,
				'condition' => [
					'show_related_products' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Trust Badges
		$this->start_controls_section(
			'trust_badges_section',
			[
				'label' => esc_html__( 'Trust Badges', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'show_trust_badges' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_1_icon',
			[
				'label' => esc_html__( 'Badge 1 Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-shield-alt',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'badge_1_text',
			[
				'label' => esc_html__( 'Badge 1 Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Lifetime Warranty', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'badge_2_icon',
			[
				'label' => esc_html__( 'Badge 2 Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-shipping-fast',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'badge_2_text',
			[
				'label' => esc_html__( 'Badge 2 Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Free Shipping $150+', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'badge_3_icon',
			[
				'label' => esc_html__( 'Badge 3 Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-box',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'badge_3_text',
			[
				'label' => esc_html__( 'Badge 3 Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '2-3 Day Shipping', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Colors', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => esc_html__( 'Primary Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#556b2f',
				'selectors' => [
					'{{WRAPPER}} .rushby-product-badge' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .rushby-add-to-cart-btn' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .rushby-star-rating svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
					'{{WRAPPER}} .rushby-stock-status.in-stock' => 'color: #10b981;',
					'{{WRAPPER}} .rushby-trust-badge-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get current product
	 */
	private function get_current_product() {
		global $product;

		// If we're on a product page, use that product
		if ( is_product() && $product ) {
			return $product;
		}

		// Otherwise, check if we're in the editor and try to get any product
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$args = [
				'post_type' => 'product',
				'posts_per_page' => 1,
				'post_status' => 'publish',
			];
			$products = get_posts( $args );
			if ( ! empty( $products ) ) {
				return wc_get_product( $products[0]->ID );
			}
		}

		return null;
	}

	/**
	 * Get product badge
	 */
	private function get_product_badge( $product ) {
		if ( $product->is_on_sale() ) {
			return esc_html__( 'Sale', 'rushby-elementor-widgets' );
		}
		if ( $product->is_featured() ) {
			return esc_html__( 'Best Seller', 'rushby-elementor-widgets' );
		}
		return '';
	}

	/**
	 * Render widget output
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( ! function_exists( 'WC' ) ) {
			echo '<p>' . esc_html__( 'WooCommerce is not active. Please install and activate WooCommerce.', 'rushby-elementor-widgets' ) . '</p>';
			return;
		}

		$product = $this->get_current_product();

		if ( ! $product ) {
			echo '<p>' . esc_html__( 'No product found. Please view this widget on a product page.', 'rushby-elementor-widgets' ) . '</p>';
			return;
		}

		$product_id = $product->get_id();
		$categories = $product->get_category_ids();
		$category_name = '';
		if ( ! empty( $categories ) ) {
			$category = get_term( $categories[0], 'product_cat' );
			if ( $category && ! is_wp_error( $category ) ) {
				$category_name = $category->name;
			}
		}

		$rating_count = $product->get_rating_count();
		$average_rating = $product->get_average_rating();
		$badge = $this->get_product_badge( $product );
		$is_variable = $product->is_type( 'variable' );
		?>

		<div class="rushby-product-page-container">
			<?php if ( 'yes' === $settings['show_breadcrumb'] ) : ?>
				<!-- Breadcrumb -->
				<nav class="rushby-breadcrumb">
					<?php
					if ( function_exists( 'woocommerce_breadcrumb' ) ) {
						woocommerce_breadcrumb( [
							'wrap_before' => '<div class="rushby-breadcrumb-wrapper">',
							'wrap_after' => '</div>',
							'before' => '',
							'after' => '',
							'delimiter' => '<svg class="rushby-breadcrumb-separator" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
						] );
					}
					?>
				</nav>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_back_button'] && ! empty( $settings['back_button_url']['url'] ) ) : ?>
				<!-- Back Button -->
				<a href="<?php echo esc_url( $settings['back_button_url']['url'] ); ?>" class="rushby-back-button">
					<svg class="rushby-back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
					</svg>
					<?php echo esc_html( $settings['back_button_text'] ); ?>
				</a>
			<?php endif; ?>

			<!-- Product Section -->
			<div class="rushby-product-main-grid">
				<!-- Product Images -->
				<div class="rushby-product-images">
					<!-- Main Image -->
					<div class="rushby-product-main-image">
						<?php echo $product->get_image( 'large' ); ?>
					</div>

					<!-- Gallery Thumbnails -->
					<?php
					$attachment_ids = $product->get_gallery_image_ids();
					if ( ! empty( $attachment_ids ) ) :
						?>
						<div class="rushby-product-gallery">
							<!-- Main product image as first thumbnail -->
							<button class="rushby-gallery-thumb active" data-image-index="0">
								<?php echo $product->get_image( 'thumbnail' ); ?>
							</button>
							<?php foreach ( $attachment_ids as $index => $attachment_id ) : ?>
								<button class="rushby-gallery-thumb" data-image-index="<?php echo esc_attr( $index + 1 ); ?>">
									<?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ); ?>
								</button>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Product Info -->
				<div class="rushby-product-info">
					<!-- Badge & Category -->
					<div class="rushby-product-meta-top">
						<?php if ( 'yes' === $settings['show_badge'] && ! empty( $badge ) ) : ?>
							<span class="rushby-product-badge"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
						<?php if ( 'yes' === $settings['show_category'] && ! empty( $category_name ) ) : ?>
							<span class="rushby-product-category"><?php echo esc_html( $category_name ); ?></span>
						<?php endif; ?>
					</div>

					<!-- Product Title -->
					<h1 class="rushby-product-title"><?php echo esc_html( $product->get_name() ); ?></h1>

					<!-- Rating & Reviews -->
					<?php if ( 'yes' === $settings['show_rating'] && $rating_count > 0 ) : ?>
						<div class="rushby-product-rating-wrapper">
							<div class="rushby-star-rating">
								<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
									<svg class="rushby-star" fill="currentColor" viewBox="0 0 20 20">
										<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
									</svg>
								<?php endfor; ?>
							</div>
							<span class="rushby-rating-text">
								<?php echo esc_html( number_format( $average_rating, 1 ) ); ?> (<?php echo esc_html( $rating_count ); ?> reviews)
							</span>
						</div>
					<?php endif; ?>

					<!-- Price -->
					<div class="rushby-product-price-wrapper">
						<?php echo $product->get_price_html(); ?>
					</div>

					<!-- Stock Status -->
					<?php if ( 'yes' === $settings['show_stock_status'] ) : ?>
						<div class="rushby-stock-status <?php echo $product->is_in_stock() ? 'in-stock' : 'out-of-stock'; ?>">
							<span class="rushby-stock-indicator"></span>
							<?php
							if ( $product->is_in_stock() ) {
								esc_html_e( 'In Stock - Ships in 2-3 days', 'rushby-elementor-widgets' );
							} else {
								esc_html_e( 'Out of Stock', 'rushby-elementor-widgets' );
							}
							?>
						</div>
					<?php endif; ?>

					<!-- Description -->
					<?php if ( $product->get_short_description() ) : ?>
						<div class="rushby-product-description">
							<?php echo wp_kses_post( $product->get_short_description() ); ?>
						</div>
					<?php endif; ?>

					<!-- Add to Cart Form -->
					<div class="rushby-product-add-to-cart">
						<?php woocommerce_template_single_add_to_cart(); ?>
					</div>

					<!-- Trust Badges -->
					<?php if ( 'yes' === $settings['show_trust_badges'] ) : ?>
						<div class="rushby-trust-badges">
							<?php if ( ! empty( $settings['badge_1_text'] ) ) : ?>
								<div class="rushby-trust-badge">
									<div class="rushby-trust-badge-icon">
										<?php \Elementor\Icons_Manager::render_icon( $settings['badge_1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</div>
									<p class="rushby-trust-badge-text"><?php echo esc_html( $settings['badge_1_text'] ); ?></p>
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $settings['badge_2_text'] ) ) : ?>
								<div class="rushby-trust-badge">
									<div class="rushby-trust-badge-icon">
										<?php \Elementor\Icons_Manager::render_icon( $settings['badge_2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</div>
									<p class="rushby-trust-badge-text"><?php echo esc_html( $settings['badge_2_text'] ); ?></p>
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $settings['badge_3_text'] ) ) : ?>
								<div class="rushby-trust-badge">
									<div class="rushby-trust-badge-icon">
										<?php \Elementor\Icons_Manager::render_icon( $settings['badge_3_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</div>
									<p class="rushby-trust-badge-text"><?php echo esc_html( $settings['badge_3_text'] ); ?></p>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<!-- SKU -->
					<?php if ( 'yes' === $settings['show_sku'] && $product->get_sku() ) : ?>
						<p class="rushby-product-sku">
							<?php esc_html_e( 'SKU:', 'rushby-elementor-widgets' ); ?> <?php echo esc_html( $product->get_sku() ); ?>
						</p>
					<?php endif; ?>
				</div>
			</div>

			<!-- Product Details -->
			<?php if ( 'yes' === $settings['show_features'] || 'yes' === $settings['show_specifications'] ) : ?>
				<div class="rushby-product-details">
					<div class="rushby-product-details-grid">
						<?php
						// Get description for features/specifications
						$description = $product->get_description();
						?>

						<?php if ( 'yes' === $settings['show_features'] && ! empty( $description ) ) : ?>
							<!-- Key Features -->
							<div class="rushby-product-features">
								<h2 class="rushby-details-heading"><?php esc_html_e( 'Key Features', 'rushby-elementor-widgets' ); ?></h2>
								<div class="rushby-features-content">
									<?php echo wp_kses_post( $description ); ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( 'yes' === $settings['show_specifications'] ) : ?>
							<!-- Specifications -->
							<div class="rushby-product-specifications">
								<h2 class="rushby-details-heading"><?php esc_html_e( 'Specifications', 'rushby-elementor-widgets' ); ?></h2>
								<dl class="rushby-specs-list">
									<?php
									// Get product attributes
									$attributes = $product->get_attributes();
									if ( ! empty( $attributes ) ) :
										foreach ( $attributes as $attribute ) :
											if ( ! $attribute->get_variation() ) :
												?>
												<div class="rushby-spec-item">
													<dt class="rushby-spec-label"><?php echo esc_html( wc_attribute_label( $attribute->get_name() ) ); ?></dt>
													<dd class="rushby-spec-value">
														<?php
														$values = [];
														if ( $attribute->is_taxonomy() ) {
															$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), [ 'fields' => 'names' ] );
															foreach ( $attribute_values as $value ) {
																$values[] = esc_html( $value );
															}
														} else {
															$values = $attribute->get_options();
															foreach ( $values as $value ) {
																$values[] = esc_html( $value );
															}
														}
														echo implode( ', ', $values );
														?>
													</dd>
												</div>
												<?php
											endif;
										endforeach;
									else :
										?>
										<p class="rushby-no-specs"><?php esc_html_e( 'No specifications available.', 'rushby-elementor-widgets' ); ?></p>
									<?php endif; ?>
								</dl>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Related Products -->
			<?php if ( 'yes' === $settings['show_related_products'] ) : ?>
				<div class="rushby-related-products">
					<h2 class="rushby-related-heading"><?php echo esc_html( $settings['related_products_title'] ); ?></h2>
					<div class="rushby-related-grid">
						<?php
						$related_limit = isset( $settings['related_products_count'] ) ? absint( $settings['related_products_count'] ) : 3;
						$related_ids = wc_get_related_products( $product_id, $related_limit );

						foreach ( $related_ids as $related_id ) :
							$related_product = wc_get_product( $related_id );
							if ( ! $related_product ) {
								continue;
							}
							?>
							<a href="<?php echo esc_url( $related_product->get_permalink() ); ?>" class="rushby-related-card">
								<div class="rushby-related-image">
									<?php echo $related_product->get_image( 'medium' ); ?>
								</div>
								<div class="rushby-related-info">
									<h3 class="rushby-related-title"><?php echo esc_html( $related_product->get_name() ); ?></h3>
									<p class="rushby-related-price"><?php echo $related_product->get_price_html(); ?></p>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
