<?php
/**
 * Product Grid Widget
 *
 * @package Rushby_Elementor_Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Rushby_Product_Grid_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name(): string {
		return 'rushby_product_grid';
	}

	/**
	 * Get widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Product Grid', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-products';
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
		return [ 'product', 'woocommerce', 'shop', 'grid', 'rushby' ];
	}

	public function get_style_depends(): array {
		return [ 'rushby-widget-product-grid' ];
	}

	public function get_script_depends(): array {
		return [ 'rushby-widgets-frontend' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// Section Header Controls
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_header',
			[
				'label' => esc_html__( 'Show Header', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Premium Products', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => esc_html__( 'Section Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Featured Products', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'section_description',
			[
				'label' => esc_html__( 'Description', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Precision-engineered CZ accessories crafted from aircraft-grade materials. Every product comes with our lifetime warranty.', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Product Query Controls
		$this->start_controls_section(
			'product_query',
			[
				'label' => esc_html__( 'Product Query', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'product_source',
			[
				'label' => esc_html__( 'Product Source', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all' => esc_html__( 'All Products', 'rushby-elementor-widgets' ),
					'featured' => esc_html__( 'Featured Products', 'rushby-elementor-widgets' ),
					'sale' => esc_html__( 'Sale Products', 'rushby-elementor-widgets' ),
					'category' => esc_html__( 'By Category', 'rushby-elementor-widgets' ),
					'tag' => esc_html__( 'By Tag', 'rushby-elementor-widgets' ),
				],
			]
		);

		// Get product categories
		$product_categories = [];
		if ( function_exists( 'wc_get_product_category_list' ) ) {
			$terms = get_terms( [
				'taxonomy' => 'product_cat',
				'hide_empty' => true,
			] );
			if ( ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$product_categories[ $term->term_id ] = $term->name;
				}
			}
		}

		$this->add_control(
			'product_categories',
			[
				'label' => esc_html__( 'Select Categories', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $product_categories,
				'condition' => [
					'product_source' => 'category',
				],
			]
		);

		// Get product tags
		$product_tags = [];
		if ( function_exists( 'wc_get_product_tag_list' ) ) {
			$terms = get_terms( [
				'taxonomy' => 'product_tag',
				'hide_empty' => true,
			] );
			if ( ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$product_tags[ $term->term_id ] = $term->name;
				}
			}
		}

		$this->add_control(
			'product_tags',
			[
				'label' => esc_html__( 'Select Tags', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $product_tags,
				'condition' => [
					'product_source' => 'tag',
				],
			]
		);

		$this->add_control(
			'products_per_page',
			[
				'label' => esc_html__( 'Products Per Page', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'min' => 1,
				'max' => 100,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => esc_html__( 'Date', 'rushby-elementor-widgets' ),
					'title' => esc_html__( 'Title', 'rushby-elementor-widgets' ),
					'price' => esc_html__( 'Price', 'rushby-elementor-widgets' ),
					'popularity' => esc_html__( 'Popularity', 'rushby-elementor-widgets' ),
					'rating' => esc_html__( 'Rating', 'rushby-elementor-widgets' ),
					'rand' => esc_html__( 'Random', 'rushby-elementor-widgets' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__( 'Ascending', 'rushby-elementor-widgets' ),
					'DESC' => esc_html__( 'Descending', 'rushby-elementor-widgets' ),
				],
			]
		);

		$this->end_controls_section();

		// Layout Controls
		$this->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__( 'Layout', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-product-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column Gap', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .rushby-product-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_ratio',
			[
				'label' => esc_html__( 'Image Ratio', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1-1',
				'options' => [
					'1-1' => '1:1',
					'4-3' => '4:3',
					'3-4' => '3:4',
					'16-9' => '16:9',
				],
			]
		);

		$this->end_controls_section();

		// Product Card Settings
		$this->start_controls_section(
			'card_settings',
			[
				'label' => esc_html__( 'Product Card Settings', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
			'show_compatibility',
			[
				'label' => esc_html__( 'Show Compatibility', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__( 'Shows product short description as compatibility info', 'rushby-elementor-widgets' ),
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
			'stock_shipping_text',
			[
				'label' => esc_html__( 'In Stock Shipping Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'In Stock - Ships in 1-3 days',
				'placeholder' => esc_html__( 'In Stock - Ships in 1-3 days', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_stock_status' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_quick_view',
			[
				'label' => esc_html__( 'Show Quick View', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_variations',
			[
				'label' => esc_html__( 'Show Variation Swatches', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__( 'Display variation swatches for variable products', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// View All Button
		$this->start_controls_section(
			'view_all_section',
			[
				'label' => esc_html__( 'View All Button', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_view_all',
			[
				'label' => esc_html__( 'Show View All Button', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label' => esc_html__( 'Button Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'View All Products', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_view_all' => 'yes',
				],
			]
		);

		$this->add_control(
			'view_all_link',
			[
				'label' => esc_html__( 'Button Link', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'rushby-elementor-widgets' ),
				'default' => [
					'url' => wc_get_page_permalink( 'shop' ),
				],
				'condition' => [
					'show_view_all' => 'yes',
				],
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
			'primary_color',
			[
				'label' => esc_html__( 'Primary Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#556b2f',
				'selectors' => [
					'{{WRAPPER}} .rushby-product-badge' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .rushby-product-category' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rushby-product-add-to-cart' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .rushby-product-rating .star' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_background',
			[
				'label' => esc_html__( 'Card Background', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .rushby-product-card' => 'background-color: {{VALUE}};',
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
				'label' => esc_html__( 'Section Title', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-product-section-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'product_title_typography',
				'label' => esc_html__( 'Product Title', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-product-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => esc_html__( 'Price', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-product-price',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get products query
	 */
	private function get_products_query( array $settings ): \WP_Query {
		$args = [
			'post_type' => 'product',
			'posts_per_page' => $settings['products_per_page'],
			'post_status' => 'publish',
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
		];

		// Handle different product sources
		switch ( $settings['product_source'] ) {
			case 'featured':
				$args['tax_query'] = [
					[
						'taxonomy' => 'product_visibility',
						'field' => 'name',
						'terms' => 'featured',
					],
				];
				break;

			case 'sale':
				$args['meta_query'] = [
					'relation' => 'OR',
					[
						'key' => '_sale_price',
						'value' => 0,
						'compare' => '>',
						'type' => 'NUMERIC',
					],
					[
						'key' => '_min_variation_sale_price',
						'value' => 0,
						'compare' => '>',
						'type' => 'NUMERIC',
					],
				];
				break;

			case 'category':
				if ( ! empty( $settings['product_categories'] ) ) {
					$args['tax_query'] = [
						[
							'taxonomy' => 'product_cat',
							'field' => 'term_id',
							'terms' => $settings['product_categories'],
						],
					];
				}
				break;

			case 'tag':
				if ( ! empty( $settings['product_tags'] ) ) {
					$args['tax_query'] = [
						[
							'taxonomy' => 'product_tag',
							'field' => 'term_id',
							'terms' => $settings['product_tags'],
						],
					];
				}
				break;
		}

		// Handle orderby special cases
		if ( 'price' === $settings['orderby'] ) {
			$args['meta_key'] = '_price';
			$args['orderby'] = 'meta_value_num';
		} elseif ( 'popularity' === $settings['orderby'] ) {
			$args['meta_key'] = 'total_sales';
			$args['orderby'] = 'meta_value_num';
		} elseif ( 'rating' === $settings['orderby'] ) {
			$args['meta_key'] = '_wc_average_rating';
			$args['orderby'] = 'meta_value_num';
		}

		return new \WP_Query( $args );
	}

	/**
	 * Get product badge text
	 */
	private function get_product_badge( $product ): string {
		if ( $product->is_on_sale() ) {
			return esc_html__( 'Sale', 'rushby-elementor-widgets' );
		}

		if ( $product->is_featured() ) {
			return esc_html__( 'Featured', 'rushby-elementor-widgets' );
		}

		// Check if product is new (less than 30 days old)
		$created = strtotime( $product->get_date_created() );
		$now = time();
		$diff_days = floor( ( $now - $created ) / ( 60 * 60 * 24 ) );

		if ( $diff_days < 30 ) {
			return esc_html__( 'New', 'rushby-elementor-widgets' );
		}

		// Check if popular (high sales)
		$total_sales = $product->get_total_sales();
		if ( $total_sales > 20 ) {
			return esc_html__( 'Best Seller', 'rushby-elementor-widgets' );
		} elseif ( $total_sales > 10 ) {
			return esc_html__( 'Popular', 'rushby-elementor-widgets' );
		}

		return '';
	}

	/**
	 * Get product variations for variable products
	 */
	private function get_product_variations( $product ): array {
		if ( ! $product->is_type( 'variable' ) ) {
			return [];
		}

		$variations = [];
		$available_variations = $product->get_available_variations();

		foreach ( $available_variations as $variation ) {
			$variation_obj = wc_get_product( $variation['variation_id'] );
			$attributes = $variation_obj->get_variation_attributes();

			foreach ( $attributes as $attr_name => $attr_value ) {
				$taxonomy = str_replace( 'attribute_', '', $attr_name );

				if ( ! isset( $variations[ $taxonomy ] ) ) {
					$variations[ $taxonomy ] = [
						'label' => wc_attribute_label( $taxonomy ),
						'options' => [],
					];
				}

				if ( ! in_array( $attr_value, $variations[ $taxonomy ]['options'] ) ) {
					$variations[ $taxonomy ]['options'][] = $attr_value;
				}
			}
		}

		return $variations;
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

		$query = $this->get_products_query( $settings );

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No products found.', 'rushby-elementor-widgets' ) . '</p>';
			return;
		}

		$image_ratio_class = 'ratio-' . $settings['image_ratio'];

		// Prepare settings for filter widget integration
		$widget_settings_json = wp_json_encode( [
			'products_per_page' => $settings['products_per_page'],
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
			'image_ratio' => $settings['image_ratio'],
			'show_badge' => $settings['show_badge'],
			'show_category' => $settings['show_category'],
			'show_rating' => $settings['show_rating'],
			'show_compatibility' => $settings['show_compatibility'],
			'show_variations' => $settings['show_variations'],
			'show_stock_status' => $settings['show_stock_status'],
			'stock_shipping_text' => $settings['stock_shipping_text'],
			'show_quick_view' => $settings['show_quick_view'],
		] );
		?>
		<section class="rushby-product-grid-section" id="rushby-product-grid" data-widget-settings="<?php echo esc_attr( $widget_settings_json ); ?>">
			<div class="rushby-product-grid-container">
			<?php if ( 'yes' === $settings['show_header'] ) : ?>
				<!-- Section Header -->
				<div class="rushby-product-section-header">
					<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<div class="rushby-product-section-badge">
							<svg class="rushby-badge-icon" fill="currentColor" viewBox="0 0 20 20">
								<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
							</svg>
							<?php echo esc_html( $settings['badge_text'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['section_title'] ) ) : ?>
						<h2 class="rushby-product-section-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $settings['section_description'] ) ) : ?>
						<p class="rushby-product-section-description"><?php echo esc_html( $settings['section_description'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<!-- Product Grid -->
			<div class="rushby-product-grid">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					global $product;

					$product_id = $product->get_id();
					$product_badge = $this->get_product_badge( $product );
					$product_variations = $this->get_product_variations( $product );
					?>
					<div class="rushby-product-card" data-product-id="<?php echo esc_attr( $product_id ); ?>">
						<!-- Product Image -->
						<div class="rushby-product-image-wrapper <?php echo esc_attr( $image_ratio_class ); ?>">
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="rushby-product-image-link">
								<?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
							</a>

							<?php if ( 'yes' === $settings['show_badge'] && ! empty( $product_badge ) ) : ?>
								<div class="rushby-product-badge-wrapper">
									<span class="rushby-product-badge"><?php echo esc_html( $product_badge ); ?></span>
								</div>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_quick_view'] ) : ?>
								<div class="rushby-product-quick-view-overlay">
									<button class="rushby-quick-view-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>">
										<?php esc_html_e( 'Quick View', 'rushby-elementor-widgets' ); ?>
									</button>
								</div>
							<?php endif; ?>
						</div>

						<!-- Product Info -->
						<div class="rushby-product-info">
							<!-- Category & Rating -->
							<div class="rushby-product-meta">
								<?php if ( 'yes' === $settings['show_category'] ) : ?>
									<span class="rushby-product-category">
										<?php
										$categories = $product->get_category_ids();
										if ( ! empty( $categories ) ) {
											$category = get_term( $categories[0], 'product_cat' );
											echo esc_html( $category->name );
										}
										?>
									</span>
								<?php endif; ?>

								<?php if ( 'yes' === $settings['show_rating'] ) : ?>
									<div class="rushby-product-rating">
										<?php
										$rating_count = $product->get_rating_count();
										$average_rating = $product->get_average_rating();
										if ( $rating_count > 0 ) :
											?>
											<svg class="star" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
											</svg>
											<span class="rating-value"><?php echo esc_html( number_format( $average_rating, 1 ) ); ?></span>
											<span class="rating-count">(<?php echo esc_html( $rating_count ); ?>)</span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>

							<!-- Product Name -->
							<h3 class="rushby-product-title">
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php echo esc_html( $product->get_name() ); ?>
								</a>
							</h3>

							<?php if ( 'yes' === $settings['show_compatibility'] && $product->get_short_description() ) : ?>
								<div class="rushby-product-compatibility">
									<?php echo wp_kses_post( wp_trim_words( $product->get_short_description(), 10 ) ); ?>
								</div>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_variations'] && ! empty( $product_variations ) ) : ?>
								<!-- Variation Swatches -->
								<div class="rushby-product-variations">
									<?php foreach ( $product_variations as $attr_name => $attr_data ) : ?>
										<div class="rushby-variation-group">
											<span class="rushby-variation-label"><?php echo esc_html( $attr_data['label'] ); ?>:</span>
											<div class="rushby-variation-swatches">
												<?php foreach ( $attr_data['options'] as $option ) : ?>
													<button
														type="button"
														class="rushby-variation-swatch"
														data-attribute="<?php echo esc_attr( $attr_name ); ?>"
														data-value="<?php echo esc_attr( $option ); ?>"
														title="<?php echo esc_attr( $option ); ?>">
														<?php echo esc_html( $option ); ?>
													</button>
												<?php endforeach; ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<!-- Price & Add to Cart -->
							<div class="rushby-product-price-cart">
								<div class="rushby-product-price-wrapper">
									<span class="rushby-product-price"><?php echo $product->get_price_html(); ?></span>
								</div>
								<button
									class="rushby-product-add-to-cart"
									data-product-id="<?php echo esc_attr( $product_id ); ?>"
									data-product-type="<?php echo esc_attr( $product->get_type() ); ?>">
									<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
									</svg>
									<span><?php esc_html_e( 'Add', 'rushby-elementor-widgets' ); ?></span>
								</button>
							</div>

							<?php if ( 'yes' === $settings['show_stock_status'] ) : ?>
								<!-- Stock Status -->
								<div class="rushby-product-stock">
									<?php if ( $product->is_on_backorder() ) : ?>
										<div class="rushby-stock-indicator on-backorder"></div>
										<span class="rushby-stock-text">
											<?php esc_html_e( 'Available on Backorder', 'rushby-elementor-widgets' ); ?>
										</span>
									<?php elseif ( $product->is_in_stock() ) : ?>
										<div class="rushby-stock-indicator in-stock"></div>
										<span class="rushby-stock-text">
											<?php echo esc_html( $settings['stock_shipping_text'] ); ?>
										</span>
									<?php else : ?>
										<div class="rushby-stock-indicator out-of-stock"></div>
										<span class="rushby-stock-text">
											<?php esc_html_e( 'Out of Stock', 'rushby-elementor-widgets' ); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<?php if ( 'yes' === $settings['show_view_all'] && ! empty( $settings['view_all_text'] ) ) : ?>
				<!-- View All Button -->
				<div class="rushby-product-view-all">
					<a href="<?php echo esc_url( $settings['view_all_link']['url'] ); ?>" class="rushby-view-all-btn">
						<?php echo esc_html( $settings['view_all_text'] ); ?>
					</a>
				</div>
			<?php endif; ?>
			</div><!-- .rushby-product-grid-container -->
		</section>
		<?php
	}
}
