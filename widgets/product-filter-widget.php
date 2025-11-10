<?php
/**
 * Product Filter Widget
 *
 * @package Rushby_Elementor_Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Rushby_Product_Filter_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name(): string {
		return 'rushby_product_filter';
	}

	/**
	 * Get widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Product Filter', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-filter';
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
		return [ 'filter', 'category', 'product', 'woocommerce', 'rushby' ];
	}

	public function get_style_depends(): array {
		return [ 'rushby-widget-product-filter' ];
	}

	public function get_script_depends(): array {
		return [ 'rushby-widgets-frontend' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {

		// Filter Settings
		$this->start_controls_section(
			'filter_settings',
			[
				'label' => esc_html__( 'Filter Settings', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'filter_layout',
			[
				'label' => esc_html__( 'Layout', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'rushby-elementor-widgets' ),
					'vertical' => esc_html__( 'Vertical', 'rushby-elementor-widgets' ),
				],
			]
		);

		$this->add_control(
			'show_all_button',
			[
				'label' => esc_html__( 'Show "All" Button', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'all_button_text',
			[
				'label' => esc_html__( 'All Button Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'All Products', 'rushby-elementor-widgets' ),
				'condition' => [
					'show_all_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_count',
			[
				'label' => esc_html__( 'Show Product Count', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'target_grid_id',
			[
				'label' => esc_html__( 'Target Grid ID', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'rushby-product-grid',
				'description' => esc_html__( 'Enter the CSS ID of the product grid to filter (without #)', 'rushby-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// Categories to Display
		$this->start_controls_section(
			'categories_section',
			[
				'label' => esc_html__( 'Categories', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'category_source',
			[
				'label' => esc_html__( 'Category Source', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all' => esc_html__( 'All Categories', 'rushby-elementor-widgets' ),
					'selected' => esc_html__( 'Selected Categories', 'rushby-elementor-widgets' ),
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
			'selected_categories',
			[
				'label' => esc_html__( 'Select Categories', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $product_categories,
				'condition' => [
					'category_source' => 'selected',
				],
			]
		);

		$this->end_controls_section();

		// Style Controls
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Button Style', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_style',
			[
				'label' => esc_html__( 'Button Style', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'pill',
				'options' => [
					'pill' => esc_html__( 'Pill', 'rushby-elementor-widgets' ),
					'rounded' => esc_html__( 'Rounded', 'rushby-elementor-widgets' ),
					'square' => esc_html__( 'Square', 'rushby-elementor-widgets' ),
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
					'{{WRAPPER}} .rushby-filter-button.active' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .rushby-filter-button:hover' => 'border-color: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// Get categories to display
		$categories = [];
		if ( 'all' === $settings['category_source'] ) {
			$categories = get_terms( [
				'taxonomy' => 'product_cat',
				'hide_empty' => true,
			] );
		} elseif ( ! empty( $settings['selected_categories'] ) ) {
			$categories = get_terms( [
				'taxonomy' => 'product_cat',
				'include' => $settings['selected_categories'],
				'hide_empty' => true,
			] );
		}

		if ( is_wp_error( $categories ) || empty( $categories ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<p>' . esc_html__( 'No product categories found. Please add some products with categories.', 'rushby-elementor-widgets' ) . '</p>';
			}
			return;
		}

		$layout_class = 'layout-' . $settings['filter_layout'];
		$button_style_class = 'button-style-' . $settings['button_style'];
		$target_grid_id = ! empty( $settings['target_grid_id'] ) ? $settings['target_grid_id'] : 'rushby-product-grid';
		?>
		<div class="rushby-product-filter-container <?php echo esc_attr( $layout_class . ' ' . $button_style_class ); ?>">
			<div class="rushby-filter-buttons" data-target-grid="<?php echo esc_attr( $target_grid_id ); ?>">

				<?php if ( $settings['show_all_button'] === 'yes' ) : ?>
					<button
						class="rushby-filter-button active"
						data-category="all"
						aria-label="<?php echo esc_attr( $settings['all_button_text'] ); ?>"
					>
						<span class="rushby-filter-label"><?php echo esc_html( $settings['all_button_text'] ); ?></span>
					</button>
				<?php endif; ?>

				<?php foreach ( $categories as $category ) : ?>
					<?php
					$count = $category->count;
					?>
					<button
						class="rushby-filter-button"
						data-category="<?php echo esc_attr( $category->term_id ); ?>"
						aria-label="<?php echo esc_attr( $category->name ); ?>"
					>
						<span class="rushby-filter-label"><?php echo esc_html( $category->name ); ?></span>
						<?php if ( $settings['show_count'] === 'yes' ) : ?>
							<span class="rushby-filter-count">(<?php echo esc_html( $count ); ?>)</span>
						<?php endif; ?>
					</button>
				<?php endforeach; ?>

			</div>

			<!-- Loading Indicator -->
			<div class="rushby-filter-loading" style="display: none;">
				<div class="rushby-filter-spinner"></div>
			</div>
		</div>
		<?php
	}
}
