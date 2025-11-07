<?php
/**
 * Plugin Name: Rushby Elementor Widgets
 * Description: Custom Elementor widgets for Rushby CZ firearm accessories website - converts React components to Elementor widgets
 * Plugin URI: https://rushby.com/
 * Version: 1.0.0
 * Author: Abrar
 * Author URI: https://abrarulhoque.com
 * Text Domain: rushby-elementor-widgets
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define plugin constants
 */
define( 'RUSHBY_ELEMENTOR_VERSION', '1.0.0' );
define( 'RUSHBY_ELEMENTOR_FILE', __FILE__ );
define( 'RUSHBY_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'RUSHBY_ELEMENTOR_URL', plugins_url( '/', __FILE__ ) );

/**
 * Register Rushby Elementor Widgets
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_rushby_elementor_widgets( $widgets_manager ) {

	// Include widget files
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/announcement-bar-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/hero-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/header-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/floating-currency-switcher-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/product-grid-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/footer-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/about-widget.php' );

	// Register widgets
	$widgets_manager->register( new \Rushby_Announcement_Bar_Widget() );
	$widgets_manager->register( new \Rushby_Hero_Widget() );
	$widgets_manager->register( new \Rushby_Header_Widget() );
	$widgets_manager->register( new \Rushby_Floating_Currency_Switcher_Widget() );
	$widgets_manager->register( new \Rushby_Product_Grid_Widget() );
	$widgets_manager->register( new \Rushby_Footer_Widget() );
	$widgets_manager->register( new \Rushby_About_Widget() );

}
add_action( 'elementor/widgets/register', 'register_rushby_elementor_widgets' );

/**
 * Enqueue widget styles
 */
function rushby_elementor_widget_styles() {
	wp_enqueue_style( 'rushby-widgets', RUSHBY_ELEMENTOR_URL . 'assets/css/widgets.css', array(), RUSHBY_ELEMENTOR_VERSION );
}
add_action( 'elementor/frontend/after_enqueue_styles', 'rushby_elementor_widget_styles' );

/**
 * Enqueue Elementor icons on frontend
 */
function rushby_enqueue_elementor_icons() {
	// Enqueue Elementor's icon libraries
	wp_enqueue_style( 'elementor-icons-fa-solid' );
	wp_enqueue_style( 'elementor-icons-fa-regular' );
	wp_enqueue_style( 'elementor-icons-fa-brands' );
}
add_action( 'wp_enqueue_scripts', 'rushby_enqueue_elementor_icons' );

/**
 * Enqueue editor styles
 */
function rushby_elementor_editor_styles() {
	wp_enqueue_style( 'rushby-widgets', RUSHBY_ELEMENTOR_URL . 'assets/css/widgets.css', array(), RUSHBY_ELEMENTOR_VERSION );
	wp_enqueue_style( 'rushby-widgets-editor', RUSHBY_ELEMENTOR_URL . 'assets/css/editor.css', array(), RUSHBY_ELEMENTOR_VERSION );
}
add_action( 'elementor/editor/after_enqueue_styles', 'rushby_elementor_editor_styles' );

/**
 * Enqueue widget scripts
 */
function rushby_elementor_widget_scripts() {
	wp_enqueue_script( 'rushby-widgets', RUSHBY_ELEMENTOR_URL . 'assets/js/widgets.js', array( 'jquery' ), RUSHBY_ELEMENTOR_VERSION, true );

	// Localize script for AJAX
	wp_localize_script( 'rushby-widgets', 'rushby_cart_ajax', array(
		'ajax_url'     => admin_url( 'admin-ajax.php' ),
		'nonce'        => wp_create_nonce( 'rushby_cart_nonce' ),
		'wc_ajax_url'  => WC_AJAX::get_endpoint( '%%endpoint%%' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'rushby_elementor_widget_scripts' );

/**
 * AJAX handler to update cart item quantity
 */
function rushby_update_cart_quantity() {
	check_ajax_referer( 'rushby_cart_nonce', 'nonce' );

	if ( ! isset( $_POST['cart_item_key'] ) || ! isset( $_POST['quantity'] ) ) {
		wp_send_json_error( array( 'message' => 'Invalid parameters' ) );
	}

	$cart_item_key = sanitize_text_field( $_POST['cart_item_key'] );
	$quantity = absint( $_POST['quantity'] );

	if ( $quantity < 1 ) {
		wp_send_json_error( array( 'message' => 'Invalid quantity' ) );
	}

	WC()->cart->set_quantity( $cart_item_key, $quantity, true );

	wp_send_json_success( array(
		'cart_hash'  => WC()->cart->get_cart_hash(),
		'fragments'  => rushby_get_cart_fragments(),
	) );
}
add_action( 'wp_ajax_rushby_update_cart_quantity', 'rushby_update_cart_quantity' );
add_action( 'wp_ajax_nopriv_rushby_update_cart_quantity', 'rushby_update_cart_quantity' );

/**
 * AJAX handler to remove cart item
 */
function rushby_remove_cart_item() {
	check_ajax_referer( 'rushby_cart_nonce', 'nonce' );

	if ( ! isset( $_POST['cart_item_key'] ) ) {
		wp_send_json_error( array( 'message' => 'Invalid parameters' ) );
	}

	$cart_item_key = sanitize_text_field( $_POST['cart_item_key'] );

	WC()->cart->remove_cart_item( $cart_item_key );

	wp_send_json_success( array(
		'cart_hash'  => WC()->cart->get_cart_hash(),
		'fragments'  => rushby_get_cart_fragments(),
	) );
}
add_action( 'wp_ajax_rushby_remove_cart_item', 'rushby_remove_cart_item' );
add_action( 'wp_ajax_nopriv_rushby_remove_cart_item', 'rushby_remove_cart_item' );

/**
 * AJAX handler to add product to cart
 */
function rushby_add_to_cart() {
	check_ajax_referer( 'rushby_cart_nonce', 'nonce' );

	if ( ! isset( $_POST['product_id'] ) ) {
		wp_send_json_error( array( 'message' => 'Invalid product ID' ) );
	}

	$product_id = absint( $_POST['product_id'] );
	$quantity = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;
	$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
	$variation = isset( $_POST['variation'] ) ? (array) $_POST['variation'] : array();

	// Remove slashes
	$variation = array_map( 'stripslashes_deep', $variation );

	// Add to cart
	if ( $variation_id ) {
		$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );
	} else {
		$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity );
	}

	if ( $cart_item_key ) {
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );

		wp_send_json_success( array(
			'cart_hash'     => WC()->cart->get_cart_hash(),
			'cart_count'    => WC()->cart->get_cart_contents_count(),
			'fragments'     => rushby_get_cart_fragments(),
			'cart_item_key' => $cart_item_key,
		) );
	} else {
		wp_send_json_error( array( 'message' => 'Failed to add product to cart' ) );
	}
}
add_action( 'wp_ajax_rushby_add_to_cart', 'rushby_add_to_cart' );
add_action( 'wp_ajax_nopriv_rushby_add_to_cart', 'rushby_add_to_cart' );

/**
 * AJAX handler to get product variations
 */
function rushby_get_product_variations() {
	check_ajax_referer( 'rushby_cart_nonce', 'nonce' );

	if ( ! isset( $_POST['product_id'] ) ) {
		wp_send_json_error( array( 'message' => 'Invalid product ID' ) );
	}

	$product_id = absint( $_POST['product_id'] );
	$product = wc_get_product( $product_id );

	if ( ! $product || ! $product->is_type( 'variable' ) ) {
		wp_send_json_error( array( 'message' => 'Invalid variable product' ) );
	}

	$variations = $product->get_available_variations();

	wp_send_json_success( array(
		'variations' => $variations,
	) );
}
add_action( 'wp_ajax_rushby_get_product_variations', 'rushby_get_product_variations' );
add_action( 'wp_ajax_nopriv_rushby_get_product_variations', 'rushby_get_product_variations' );

/**
 * Get cart fragments for AJAX updates
 */
function rushby_get_cart_fragments() {
	$fragments = array();

	ob_start();
	rushby_render_side_cart_content();
	$fragments['.rushby-side-cart-content'] = ob_get_clean();

	$fragments['.rushby-cart-count'] = WC()->cart->get_cart_contents_count();

	return $fragments;
}

/**
 * Render side cart content (used for AJAX fragments)
 */
function rushby_render_side_cart_content() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return;
	}

	$cart_items = WC()->cart->get_cart();
	$cart_count = WC()->cart->get_cart_contents_count();
	?>
	<!-- Cart Items -->
	<div class="rushby-side-cart-items">
		<?php if ( empty( $cart_items ) ) : ?>
			<div class="rushby-side-cart-empty">
				<svg class="rushby-empty-cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
				</svg>
				<h3 class="rushby-empty-cart-title">Your cart is empty</h3>
				<p class="rushby-empty-cart-text">Add some products to get started</p>
				<button onclick="rushbyCloseSideCart()" class="rushby-btn rushby-btn-primary">
					Continue Shopping
				</button>
			</div>
		<?php else : ?>
			<?php foreach ( $cart_items as $cart_item_key => $cart_item ) : ?>
				<?php
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<div class="rushby-side-cart-item" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
						<!-- Product Image -->
						<div class="rushby-side-cart-item-image">
							<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
							if ( ! $product_permalink ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
							}
							?>
						</div>

						<!-- Product Details -->
						<div class="rushby-side-cart-item-details">
							<h3 class="rushby-side-cart-item-name">
								<?php
								if ( ! $product_permalink ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) );
								} else {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								}
								?>
							</h3>
							<?php
							// Variation data
							if ( ! empty( $cart_item['variation'] ) ) {
								echo '<p class="rushby-side-cart-item-variant">' . wc_get_formatted_cart_item_data( $cart_item ) . '</p>';
							}
							?>
							<div class="rushby-side-cart-item-price-row">
								<!-- Quantity Controls -->
								<div class="rushby-quantity-controls">
									<button type="button" class="rushby-qty-btn rushby-qty-minus" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
										<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
										</svg>
									</button>
									<span class="rushby-qty-value"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
									<button type="button" class="rushby-qty-btn rushby-qty-plus" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
										<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
										</svg>
									</button>
								</div>
								<!-- Item Total Price -->
								<div class="rushby-side-cart-item-total">
									<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
								</div>
							</div>
						</div>

						<!-- Remove Button -->
						<button type="button" class="rushby-side-cart-item-remove" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
							<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
							</svg>
						</button>
					</div>
					<?php
				}
			endforeach;
			?>
		<?php endif; ?>
	</div>

	<!-- Footer -->
	<?php if ( ! empty( $cart_items ) ) : ?>
	<div class="rushby-side-cart-footer">
		<!-- Subtotal -->
		<div class="rushby-side-cart-subtotal">
			<span><?php esc_html_e( 'Subtotal:', 'rushby-elementor-widgets' ); ?></span>
			<span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		</div>

		<!-- Shipping Note -->
		<p class="rushby-side-cart-note">
			<?php esc_html_e( 'Shipping and taxes calculated at checkout', 'rushby-elementor-widgets' ); ?>
		</p>

		<!-- Action Buttons -->
		<div class="rushby-side-cart-actions">
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="rushby-btn rushby-btn-primary rushby-btn-checkout">
				<?php esc_html_e( 'CHECKOUT', 'rushby-elementor-widgets' ); ?>
				<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
				</svg>
			</a>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="rushby-btn rushby-btn-secondary">
				<?php esc_html_e( 'View Full Cart', 'rushby-elementor-widgets' ); ?>
			</a>
		</div>

		<!-- Continue Shopping -->
		<button onclick="rushbyCloseSideCart()" class="rushby-continue-shopping">
			<?php esc_html_e( 'Continue Shopping', 'rushby-elementor-widgets' ); ?>
		</button>
	</div>
	<?php endif; ?>
	<?php
}
