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
 * Helper: Return cache-busting version based on file mtime when possible.
 */
function rushby_get_asset_version( string $relative_path ): string {
	$absolute = RUSHBY_ELEMENTOR_PATH . ltrim( $relative_path, '/' );
	return file_exists( $absolute ) ? (string) filemtime( $absolute ) : RUSHBY_ELEMENTOR_VERSION;
}

/**
 * Helper: Map widget slugs to their relative style paths.
 */
function rushby_get_widget_style_files(): array {
	return [
		'announcement-bar' => 'assets/css/widgets/announcement-bar.css',
		'header' => 'assets/css/widgets/header.css',
		'hero' => 'assets/css/widgets/hero.css',
		'currency-switcher' => 'assets/css/widgets/currency-switcher.css',
		'product-grid' => 'assets/css/widgets/product-grid.css',
		'product-filter' => 'assets/css/widgets/product-filter.css',
		'product-page' => 'assets/css/widgets/product-page.css',
		'footer' => 'assets/css/widgets/footer.css',
		'about' => 'assets/css/widgets/about.css',
		'cart-page' => 'assets/css/widgets/cart-page.css',
	];
}

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
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/product-filter-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/product-page-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/footer-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/about-widget.php' );
	require_once( RUSHBY_ELEMENTOR_PATH . 'widgets/cart-page-widget.php' );

	// Register widgets
	$widgets_manager->register( new \Rushby_Announcement_Bar_Widget() );
	$widgets_manager->register( new \Rushby_Hero_Widget() );
	$widgets_manager->register( new \Rushby_Header_Widget() );
	$widgets_manager->register( new \Rushby_Floating_Currency_Switcher_Widget() );
	$widgets_manager->register( new \Rushby_Product_Grid_Widget() );
	$widgets_manager->register( new \Rushby_Product_Filter_Widget() );
	$widgets_manager->register( new \Rushby_Product_Page_Widget() );
	$widgets_manager->register( new \Rushby_Footer_Widget() );
	$widgets_manager->register( new \Rushby_About_Widget() );
	$widgets_manager->register( new \Rushby_Cart_Page_Widget() );

}
add_action( 'elementor/widgets/register', 'register_rushby_elementor_widgets' );

/**
 * Register frontend widget styles so individual widgets can enqueue on demand.
 */
function rushby_register_widget_styles() {
	wp_register_style(
		'rushby-widgets-common',
		RUSHBY_ELEMENTOR_URL . 'assets/css/common.css',
		[],
		rushby_get_asset_version( 'assets/css/common.css' )
	);

	foreach ( rushby_get_widget_style_files() as $slug => $relative_path ) {
		wp_register_style(
			'rushby-widget-' . $slug,
			RUSHBY_ELEMENTOR_URL . $relative_path,
			[ 'rushby-widgets-common' ],
			rushby_get_asset_version( $relative_path )
		);
	}
}
add_action( 'elementor/frontend/before_register_styles', 'rushby_register_widget_styles' );
add_action( 'elementor/editor/before_enqueue_styles', 'rushby_register_widget_styles' );

/**
 * Ensure Elementor editor previews have access to all widget styles.
 */
function rushby_elementor_editor_styles() {
	wp_enqueue_style( 'rushby-widgets-common' );
	foreach ( array_keys( rushby_get_widget_style_files() ) as $slug ) {
		wp_enqueue_style( 'rushby-widget-' . $slug );
	}

	wp_enqueue_style(
		'rushby-widgets-editor',
		RUSHBY_ELEMENTOR_URL . 'assets/css/editor.css',
		[],
		rushby_get_asset_version( 'assets/css/editor.css' )
	);
}
add_action( 'elementor/editor/after_enqueue_styles', 'rushby_elementor_editor_styles' );

/**
 * Register widget frontend script once so widgets can declare it as a dependency.
 */
function rushby_register_widget_scripts() {
	wp_register_script(
		'rushby-widgets-frontend',
		RUSHBY_ELEMENTOR_URL . 'assets/js/widgets.js',
		[ 'jquery' ],
		rushby_get_asset_version( 'assets/js/widgets.js' ),
		true
	);

	wp_localize_script( 'rushby-widgets-frontend', 'rushby_cart_ajax', array(
		'ajax_url'    => admin_url( 'admin-ajax.php' ),
		'nonce'       => wp_create_nonce( 'rushby_cart_nonce' ),
		'wc_ajax_url' => WC_AJAX::get_endpoint( '%%endpoint%%' ),
	) );
}
add_action( 'elementor/frontend/before_register_scripts', 'rushby_register_widget_scripts' );
add_action( 'elementor/editor/before_enqueue_scripts', 'rushby_register_widget_scripts' );

/**
 * Force Currency Converter plugin to load when our widgets are on the page.
 * The plugin only loads when its own widget/shortcode is detected, but we need
 * it to load for our custom currency switchers to work properly.
 */
function rushby_force_currency_converter_load() {
	// Only run on frontend
	if ( is_admin() || ! class_exists( 'WC_Currency_Converter' ) ) {
		return;
	}

	// Get the current post
	global $post;
	if ( ! $post ) {
		return;
	}

	// Check if Elementor is used on this page
	if ( ! \Elementor\Plugin::$instance->db->is_built_with_elementor( $post->ID ) ) {
		return;
	}

	// Get Elementor document data
	$document = \Elementor\Plugin::$instance->documents->get( $post->ID );
	if ( ! $document ) {
		return;
	}

	// Get all elements from the page
	$elements_data = $document->get_elements_data();

	// Check if header or currency switcher widgets are used
	$has_currency_widget = false;

	array_walk_recursive( $elements_data, function( $value, $key ) use ( &$has_currency_widget ) {
		if ( 'widgetType' === $key && in_array( $value, [ 'rushby_header', 'rushby_floating_currency_switcher' ], true ) ) {
			$has_currency_widget = true;
		}
	});

	// If our currency widgets are found, add a hidden shortcode to make the plugin think it's active
	if ( $has_currency_widget ) {
		add_filter( 'the_content', 'rushby_inject_currency_converter_shortcode', 999 );
	}
}
add_action( 'wp_enqueue_scripts', 'rushby_force_currency_converter_load', 20 );

/**
 * Inject a hidden currency converter shortcode to trick the plugin into loading
 */
function rushby_inject_currency_converter_shortcode( $content ) {
	// Add hidden shortcode at the end of content
	// This makes the plugin's is_active() check return true
	$content .= '<div style="display:none !important; visibility:hidden !important; height:0 !important; overflow:hidden !important;">';
	$content .= do_shortcode( '[woocommerce_currency_converter currency_codes="USD, EUR, GBP, ZAR, CAD, AUD"]' );
	$content .= '</div>';

	// Remove this filter after first use to avoid multiple injections
	remove_filter( 'the_content', 'rushby_inject_currency_converter_shortcode', 999 );

	return $content;
}

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
 * AJAX handler to apply coupon
 */
function rushby_apply_coupon() {
	check_ajax_referer( 'rushby_cart_nonce', 'nonce' );

	if ( ! isset( $_POST['coupon_code'] ) ) {
		wp_send_json_error( array( 'message' => 'Invalid coupon code' ) );
	}

	$coupon_code = sanitize_text_field( $_POST['coupon_code'] );

	if ( ! WC()->cart->apply_coupon( $coupon_code ) ) {
		wp_send_json_error( array( 'message' => 'Invalid coupon code' ) );
	}

	wp_send_json_success( array(
		'message' => 'Coupon applied successfully',
	) );
}
add_action( 'wp_ajax_rushby_apply_coupon', 'rushby_apply_coupon' );
add_action( 'wp_ajax_nopriv_rushby_apply_coupon', 'rushby_apply_coupon' );

/**
 * AJAX handler to remove coupon
 */
function rushby_remove_coupon() {
	check_ajax_referer( 'rushby_cart_nonce', 'nonce' );

	if ( ! isset( $_POST['coupon_code'] ) ) {
		wp_send_json_error( array( 'message' => 'Invalid parameters' ) );
	}

	$coupon_code = sanitize_text_field( $_POST['coupon_code'] );

	if ( ! WC()->cart->remove_coupon( $coupon_code ) ) {
		wp_send_json_error( array( 'message' => 'Failed to remove coupon' ) );
	}

	wp_send_json_success( array(
		'message' => 'Coupon removed successfully',
	) );
}
add_action( 'wp_ajax_rushby_remove_coupon', 'rushby_remove_coupon' );
add_action( 'wp_ajax_nopriv_rushby_remove_coupon', 'rushby_remove_coupon' );

/**
 * AJAX handler to filter products by category
 */
function rushby_filter_products() {
	check_ajax_referer( 'rushby_cart_nonce', 'nonce' );

	if ( ! isset( $_POST['category'] ) || ! isset( $_POST['widget_settings'] ) ) {
		wp_send_json_error( array( 'message' => 'Invalid parameters' ) );
	}

	$category = sanitize_text_field( $_POST['category'] );
	$widget_settings = json_decode( stripslashes( $_POST['widget_settings'] ), true );

	if ( ! $widget_settings ) {
		wp_send_json_error( array( 'message' => 'Invalid widget settings' ) );
	}

	// Build query args
	$args = [
		'post_type' => 'product',
		'posts_per_page' => $widget_settings['products_per_page'] ?? 12,
		'post_status' => 'publish',
		'orderby' => $widget_settings['orderby'] ?? 'date',
		'order' => $widget_settings['order'] ?? 'DESC',
	];

	// Add category filter if not "all"
	if ( 'all' !== $category ) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'product_cat',
				'field' => 'term_id',
				'terms' => absint( $category ),
			],
		];
	}

	// Handle orderby special cases
	if ( 'price' === $widget_settings['orderby'] ) {
		$args['meta_key'] = '_price';
		$args['orderby'] = 'meta_value_num';
	} elseif ( 'popularity' === $widget_settings['orderby'] ) {
		$args['meta_key'] = 'total_sales';
		$args['orderby'] = 'meta_value_num';
	} elseif ( 'rating' === $widget_settings['orderby'] ) {
		$args['meta_key'] = '_wc_average_rating';
		$args['orderby'] = 'meta_value_num';
	}

	$products_query = new WP_Query( $args );

	if ( ! $products_query->have_posts() ) {
		ob_start();
		echo '<div class="rushby-no-products"><p>' . esc_html__( 'No products found in this category.', 'rushby-elementor-widgets' ) . '</p></div>';
		$html = ob_get_clean();
		wp_send_json_success( array(
			'html' => $html,
			'count' => 0,
		) );
	}

	// Generate products HTML
	ob_start();
	while ( $products_query->have_posts() ) {
		$products_query->the_post();
		global $product;

		// Include the product card template
		rushby_render_product_card( $product, $widget_settings );
	}
	wp_reset_postdata();

	$html = ob_get_clean();

	wp_send_json_success( array(
		'html' => $html,
		'count' => $products_query->found_posts,
	) );
}
add_action( 'wp_ajax_rushby_filter_products', 'rushby_filter_products' );
add_action( 'wp_ajax_nopriv_rushby_filter_products', 'rushby_filter_products' );

/**
 * Render product card HTML (used by AJAX and widget render)
 */
function rushby_render_product_card( $product, $settings ) {
	if ( ! $product ) {
		return;
	}

	$product_id = $product->get_id();
	$product_link = get_permalink( $product_id );
	$product_title = $product->get_name();
	$product_price = $product->get_price_html();
	$product_image_id = $product->get_image_id();
	$product_image_url = wp_get_attachment_image_url( $product_image_id, 'medium' );

	// Get categories
	$categories = get_the_terms( $product_id, 'product_cat' );
	$category_name = '';
	if ( $categories && ! is_wp_error( $categories ) ) {
		$category = array_shift( $categories );
		$category_name = $category->name;
	}

	// Get rating
	$rating_count = $product->get_rating_count();
	$average_rating = $product->get_average_rating();

	// Get badge
	$badge_text = '';
	if ( $product->is_on_sale() ) {
		$badge_text = esc_html__( 'Sale', 'rushby-elementor-widgets' );
	} elseif ( $product->is_featured() ) {
		$badge_text = esc_html__( 'Featured', 'rushby-elementor-widgets' );
	}

	$image_ratio = $settings['image_ratio'] ?? '1-1';
	?>
	<div class="rushby-product-card" data-product-id="<?php echo esc_attr( $product_id ); ?>">
		<!-- Product Image -->
		<div class="rushby-product-image-wrapper ratio-<?php echo esc_attr( $image_ratio ); ?>">
			<a href="<?php echo esc_url( $product_link ); ?>" class="rushby-product-image-link">
				<?php if ( $product_image_url ) : ?>
					<img src="<?php echo esc_url( $product_image_url ); ?>" alt="<?php echo esc_attr( $product_title ); ?>" loading="lazy">
				<?php else : ?>
					<img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" alt="<?php echo esc_attr( $product_title ); ?>" loading="lazy">
				<?php endif; ?>
			</a>

			<?php if ( ! empty( $badge_text ) ) : ?>
				<div class="rushby-product-badge-wrapper">
					<span class="rushby-product-badge"><?php echo esc_html( $badge_text ); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<!-- Product Info -->
		<div class="rushby-product-info">
			<!-- Meta -->
			<div class="rushby-product-meta">
				<?php if ( ! empty( $category_name ) ) : ?>
					<span class="rushby-product-category"><?php echo esc_html( $category_name ); ?></span>
				<?php endif; ?>

				<?php if ( $rating_count > 0 ) : ?>
					<div class="rushby-product-rating">
						<svg class="star" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
						</svg>
						<span class="rating-value"><?php echo esc_html( number_format( $average_rating, 1 ) ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Title -->
			<h3 class="rushby-product-title">
				<a href="<?php echo esc_url( $product_link ); ?>"><?php echo esc_html( $product_title ); ?></a>
			</h3>

			<!-- Price & Add to Cart -->
			<div class="rushby-product-price-cart">
				<div class="rushby-product-price-wrapper">
					<div class="rushby-product-price"><?php echo wp_kses_post( $product_price ); ?></div>
				</div>

				<button class="rushby-product-add-to-cart" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-type="<?php echo esc_attr( $product->get_type() ); ?>">
					<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
					</svg>
					<span><?php esc_html_e( 'Add to Cart', 'rushby-elementor-widgets' ); ?></span>
				</button>
			</div>
		</div>
	</div>
	<?php
}

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
