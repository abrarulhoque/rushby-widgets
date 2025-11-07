<?php
/**
 * Cart Page Widget
 *
 * @package Rushby_Elementor_Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Rushby_Cart_Page_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name(): string {
		return 'rushby_cart_page';
	}

	/**
	 * Get widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Rushby Cart Page', 'rushby-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-cart';
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
		return [ 'cart', 'woocommerce', 'shopping', 'basket', 'rushby' ];
	}

	/**
	 * Get style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'elementor-icons-fa-solid', 'elementor-icons-fa-regular' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// Content Settings
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content Settings', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'page_title',
			[
				'label' => esc_html__( 'Page Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Shopping Cart', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'empty_cart_title',
			[
				'label' => esc_html__( 'Empty Cart Title', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your cart is empty', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'empty_cart_text',
			[
				'label' => esc_html__( 'Empty Cart Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Add some products to get started', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'continue_shopping_text',
			[
				'label' => esc_html__( 'Continue Shopping Button', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Continue Shopping', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'continue_shopping_url',
			[
				'label' => esc_html__( 'Continue Shopping URL', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => wc_get_page_permalink( 'shop' ),
				],
			]
		);

		$this->add_control(
			'checkout_button_text',
			[
				'label' => esc_html__( 'Checkout Button Text', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'PROCEED TO CHECKOUT', 'rushby-elementor-widgets' ),
			]
		);

		$this->add_control(
			'show_coupon',
			[
				'label' => esc_html__( 'Show Coupon Field', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		// Icon Settings
		$this->start_controls_section(
			'icon_section',
			[
				'label' => esc_html__( 'Icon Settings', 'rushby-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'qty_minus_icon',
			[
				'label' => esc_html__( 'Quantity Minus Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-minus',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'qty_plus_icon',
			[
				'label' => esc_html__( 'Quantity Plus Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'remove_icon',
			[
				'label' => esc_html__( 'Remove Item Icon', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-times',
					'library' => 'fa-solid',
				],
			]
		);

		$this->end_controls_section();

		// Style - Colors
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
				'default' => '#DC2626',
				'selectors' => [
					'{{WRAPPER}} .rushby-cart-checkout-btn' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .rushby-cart-remove-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rushby-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .rushby-cart-page' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style - Typography
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
				'label' => esc_html__( 'Page Title', 'rushby-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .rushby-cart-page-title',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output
	 */
	protected function render(): void {
		if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
			echo '<p>' . esc_html__( 'WooCommerce is not active. Please install and activate WooCommerce.', 'rushby-elementor-widgets' ) . '</p>';
			return;
		}

		$settings = $this->get_settings_for_display();
		$cart = WC()->cart;
		$cart_items = $cart->get_cart();

		// Ensure the selected icon libraries are loaded before rendering.
		$icon_controls = [ 'qty_minus_icon', 'qty_plus_icon', 'remove_icon' ];
		$icon_libraries = [];
		foreach ( $icon_controls as $icon_control ) {
			if ( empty( $settings[ $icon_control ]['library'] ) ) {
				continue;
			}
			$icon_libraries[ $settings[ $icon_control ]['library'] ] = true;
		}

		if ( \Elementor\Icons_Manager::is_migration_allowed() ) {
			foreach ( array_keys( $icon_libraries ) as $library ) {
				wp_enqueue_style( 'elementor-icons-' . $library );
			}
		} elseif ( ! empty( $icon_libraries ) ) {
			\Elementor\Icons_Manager::enqueue_shim();
		}
		?>
		<div class="rushby-cart-page">
			<div class="rushby-cart-container">
				<!-- Page Title -->
				<h1 class="rushby-cart-page-title"><?php echo esc_html( $settings['page_title'] ); ?></h1>

				<?php if ( empty( $cart_items ) ) : ?>
					<!-- Empty Cart State -->
					<div class="rushby-cart-empty">
						<svg class="rushby-cart-empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
						</svg>
						<h3 class="rushby-cart-empty-title"><?php echo esc_html( $settings['empty_cart_title'] ); ?></h3>
						<p class="rushby-cart-empty-text"><?php echo esc_html( $settings['empty_cart_text'] ); ?></p>
						<a href="<?php echo esc_url( $settings['continue_shopping_url']['url'] ); ?>" class="rushby-cart-continue-btn">
							<?php echo esc_html( $settings['continue_shopping_text'] ); ?>
						</a>
					</div>
				<?php else : ?>
					<!-- Cart Content -->
					<div class="rushby-cart-content">
						<!-- Cart Items -->
						<div class="rushby-cart-items-section">
							<div class="rushby-cart-items">
								<?php foreach ( $cart_items as $cart_item_key => $cart_item ) :
									$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

									if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
										$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										?>
										<div class="rushby-cart-item" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
											<!-- Product Image -->
											<div class="rushby-cart-item-image">
												<?php
												$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'thumbnail' ), $cart_item, $cart_item_key );
												if ( ! $product_permalink ) {
													echo $thumbnail;
												} else {
													printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
												}
												?>
											</div>

											<!-- Product Details -->
											<div class="rushby-cart-item-details">
												<h3 class="rushby-cart-item-name">
													<?php
													if ( ! $product_permalink ) {
														echo wp_kses_post( $_product->get_name() );
													} else {
														echo wp_kses_post( sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ) );
													}
													?>
												</h3>
												<?php
												// Variation data
												if ( ! empty( $cart_item['variation'] ) ) {
													echo '<p class="rushby-cart-item-variant">' . wc_get_formatted_cart_item_data( $cart_item ) . '</p>';
												}
												?>
											</div>

											<!-- Unit Price -->
											<div class="rushby-cart-item-price">
												<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
											</div>

											<!-- Quantity Controls -->
											<div class="rushby-cart-item-quantity">
												<div class="rushby-cart-quantity-controls">
													<button type="button" class="rushby-cart-qty-btn rushby-cart-qty-minus" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
														<?php
														if ( ! empty( $settings['qty_minus_icon']['value'] ) ) {
															\Elementor\Icons_Manager::render_icon( $settings['qty_minus_icon'], [ 'aria-hidden' => 'true' ] );
														} else {
															echo '<i class="fas fa-minus" aria-hidden="true"></i>';
														}
														?>
													</button>
													<span class="rushby-cart-qty-value"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
													<button type="button" class="rushby-cart-qty-btn rushby-cart-qty-plus" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
														<?php
														if ( ! empty( $settings['qty_plus_icon']['value'] ) ) {
															\Elementor\Icons_Manager::render_icon( $settings['qty_plus_icon'], [ 'aria-hidden' => 'true' ] );
														} else {
															echo '<i class="fas fa-plus" aria-hidden="true"></i>';
														}
														?>
													</button>
												</div>
											</div>

											<!-- Item Total -->
											<div class="rushby-cart-item-total">
												<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
											</div>

											<!-- Remove Button -->
											<button type="button" class="rushby-cart-remove-btn" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
												<?php
												if ( ! empty( $settings['remove_icon']['value'] ) ) {
													\Elementor\Icons_Manager::render_icon( $settings['remove_icon'], [ 'aria-hidden' => 'true' ] );
												} else {
													echo '<i class="fas fa-times" aria-hidden="true"></i>';
												}
												?>
											</button>
										</div>
										<?php
									endif;
								endforeach; ?>
							</div>

							<!-- Continue Shopping -->
							<div class="rushby-cart-actions">
								<a href="<?php echo esc_url( $settings['continue_shopping_url']['url'] ); ?>" class="rushby-cart-continue-link">
									<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
									</svg>
									<?php echo esc_html( $settings['continue_shopping_text'] ); ?>
								</a>
							</div>
						</div>

						<!-- Cart Totals Sidebar -->
						<div class="rushby-cart-totals-section">
							<div class="rushby-cart-totals">
								<h3 class="rushby-cart-totals-title"><?php esc_html_e( 'Cart Totals', 'rushby-elementor-widgets' ); ?></h3>

								<!-- Coupon Code -->
								<?php if ( 'yes' === $settings['show_coupon'] && wc_coupons_enabled() ) : ?>
									<div class="rushby-cart-coupon">
										<form class="rushby-cart-coupon-form">
											<input
												type="text"
												name="coupon_code"
												class="rushby-cart-coupon-input"
												placeholder="<?php esc_attr_e( 'Coupon code', 'rushby-elementor-widgets' ); ?>"
											/>
											<button type="submit" class="rushby-cart-coupon-btn">
												<?php esc_html_e( 'Apply', 'rushby-elementor-widgets' ); ?>
											</button>
										</form>
									</div>
								<?php endif; ?>

								<!-- Applied Coupons -->
								<?php if ( $cart->get_applied_coupons() ) : ?>
									<div class="rushby-cart-applied-coupons">
										<?php foreach ( $cart->get_applied_coupons() as $code ) : ?>
											<div class="rushby-cart-coupon-tag">
												<span><?php echo esc_html( $code ); ?></span>
												<button type="button" class="rushby-cart-coupon-remove" data-coupon="<?php echo esc_attr( $code ); ?>">
													<?php
													if ( ! empty( $settings['remove_icon']['value'] ) ) {
														\Elementor\Icons_Manager::render_icon( $settings['remove_icon'], [ 'aria-hidden' => 'true' ] );
													} else {
														echo '<i class="fas fa-times" aria-hidden="true"></i>';
													}
													?>
												</button>
											</div>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>

								<!-- Totals Breakdown -->
								<div class="rushby-cart-totals-breakdown">
									<!-- Subtotal -->
									<div class="rushby-cart-total-row">
										<span><?php esc_html_e( 'Subtotal', 'rushby-elementor-widgets' ); ?></span>
										<span><?php echo $cart->get_cart_subtotal(); ?></span>
									</div>

									<!-- Shipping -->
									<?php if ( $cart->needs_shipping() && $cart->show_shipping() ) : ?>
										<div class="rushby-cart-total-row">
											<span><?php esc_html_e( 'Shipping', 'rushby-elementor-widgets' ); ?></span>
											<span>
												<?php
												if ( $cart->get_shipping_total() > 0 ) {
													echo wc_price( $cart->get_shipping_total() );
												} else {
													esc_html_e( 'Calculated at checkout', 'rushby-elementor-widgets' );
												}
												?>
											</span>
										</div>
									<?php endif; ?>

									<!-- Tax -->
									<?php if ( wc_tax_enabled() && ! $cart->display_prices_including_tax() ) : ?>
										<div class="rushby-cart-total-row">
											<span><?php esc_html_e( 'Tax', 'rushby-elementor-widgets' ); ?></span>
											<span><?php echo $cart->get_total_tax() > 0 ? wc_price( $cart->get_total_tax() ) : esc_html__( 'Calculated at checkout', 'rushby-elementor-widgets' ); ?></span>
										</div>
									<?php endif; ?>

									<!-- Total -->
									<div class="rushby-cart-total-row rushby-cart-total-final">
										<span><?php esc_html_e( 'Total', 'rushby-elementor-widgets' ); ?></span>
										<span><?php echo $cart->get_total(); ?></span>
									</div>
								</div>

								<!-- Checkout Button -->
								<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="rushby-cart-checkout-btn">
									<?php echo esc_html( $settings['checkout_button_text'] ); ?>
									<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
									</svg>
								</a>

								<!-- Shipping Note -->
								<p class="rushby-cart-shipping-note">
									<?php esc_html_e( 'Shipping and taxes calculated at checkout', 'rushby-elementor-widgets' ); ?>
								</p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
