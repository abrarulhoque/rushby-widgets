/**
 * Rushby Elementor Widgets JavaScript
 *
 * @package Rushby_Elementor_Widgets
 * @version 1.0.0
 */

(function ($) {
	'use strict';

	/**
	 * Open Side Cart
	 */
	window.rushbyOpenSideCart = function () {
		const backdrop = document.querySelector('.rushby-side-cart-backdrop');
		const panel = document.querySelector('.rushby-side-cart-panel');

		if (backdrop && panel) {
			backdrop.style.display = 'block';
			panel.style.display = 'flex';

			// Add show classes with slight delay for animation
			setTimeout(function () {
				backdrop.classList.add('show');
				panel.classList.add('show');
				document.body.style.overflow = 'hidden';
			}, 10);
		}
	};

	/**
	 * Close Side Cart
	 */
	window.rushbyCloseSideCart = function () {
		const backdrop = document.querySelector('.rushby-side-cart-backdrop');
		const panel = document.querySelector('.rushby-side-cart-panel');

		if (backdrop && panel) {
			backdrop.classList.remove('show');
			panel.classList.remove('show');
			document.body.style.overflow = '';

			// Hide elements after animation
			setTimeout(function () {
				backdrop.style.display = 'none';
				panel.style.display = 'none';
			}, 300);
		}
	};

	/**
	 * Update Cart Quantity
	 */
	function rushbyUpdateQuantity(cartItemKey, newQuantity) {
		if (!rushby_cart_ajax || newQuantity < 1) {
			return;
		}

		// Show loading state
		const cartContent = document.querySelector('.rushby-side-cart-content');
		if (cartContent) {
			cartContent.classList.add('loading');
		}

		$.ajax({
			type: 'POST',
			url: rushby_cart_ajax.ajax_url,
			data: {
				action: 'rushby_update_cart_quantity',
				nonce: rushby_cart_ajax.nonce,
				cart_item_key: cartItemKey,
				quantity: newQuantity
			},
			success: function (response) {
				if (response.success && response.data.fragments) {
					rushbyUpdateCartFragments(response.data.fragments);
				}
			},
			error: function () {
				console.error('Failed to update cart quantity');
			},
			complete: function () {
				if (cartContent) {
					cartContent.classList.remove('loading');
				}
			}
		});
	}

	/**
	 * Remove Cart Item
	 */
	function rushbyRemoveCartItem(cartItemKey) {
		if (!rushby_cart_ajax) {
			return;
		}

		// Show loading state
		const cartContent = document.querySelector('.rushby-side-cart-content');
		if (cartContent) {
			cartContent.classList.add('loading');
		}

		$.ajax({
			type: 'POST',
			url: rushby_cart_ajax.ajax_url,
			data: {
				action: 'rushby_remove_cart_item',
				nonce: rushby_cart_ajax.nonce,
				cart_item_key: cartItemKey
			},
			success: function (response) {
				if (response.success && response.data.fragments) {
					rushbyUpdateCartFragments(response.data.fragments);
				}
			},
			error: function () {
				console.error('Failed to remove cart item');
			},
			complete: function () {
				if (cartContent) {
					cartContent.classList.remove('loading');
				}
			}
		});
	}

	/**
	 * Update Cart Fragments
	 */
	function rushbyUpdateCartFragments(fragments) {
		if (!fragments) {
			return;
		}

		// Update each fragment
		Object.keys(fragments).forEach(function (selector) {
			const elements = document.querySelectorAll(selector);
			elements.forEach(function (element) {
				if (selector === '.rushby-cart-count') {
					element.textContent = fragments[selector];
				} else {
					element.innerHTML = fragments[selector];
				}
			});
		});

		// Reattach event listeners after content update
		rushbyAttachCartEvents();
	}

	/**
	 * Attach Cart Event Listeners
	 */
	function rushbyAttachCartEvents() {
		// Quantity minus buttons
		document.querySelectorAll('.rushby-qty-minus').forEach(function (button) {
			button.removeEventListener('click', handleQuantityMinus);
			button.addEventListener('click', handleQuantityMinus);
		});

		// Quantity plus buttons
		document.querySelectorAll('.rushby-qty-plus').forEach(function (button) {
			button.removeEventListener('click', handleQuantityPlus);
			button.addEventListener('click', handleQuantityPlus);
		});

		// Remove item buttons
		document.querySelectorAll('.rushby-side-cart-item-remove').forEach(function (button) {
			button.removeEventListener('click', handleRemoveItem);
			button.addEventListener('click', handleRemoveItem);
		});
	}

	/**
	 * Handle Quantity Minus Click
	 */
	function handleQuantityMinus(e) {
		e.preventDefault();
		const button = e.currentTarget;
		const cartItemKey = button.getAttribute('data-cart-item-key');
		const qtyValue = button.parentElement.querySelector('.rushby-qty-value');

		if (qtyValue && cartItemKey) {
			const currentQty = parseInt(qtyValue.textContent) || 1;
			const newQty = Math.max(1, currentQty - 1);
			rushbyUpdateQuantity(cartItemKey, newQty);
		}
	}

	/**
	 * Handle Quantity Plus Click
	 */
	function handleQuantityPlus(e) {
		e.preventDefault();
		const button = e.currentTarget;
		const cartItemKey = button.getAttribute('data-cart-item-key');
		const qtyValue = button.parentElement.querySelector('.rushby-qty-value');

		if (qtyValue && cartItemKey) {
			const currentQty = parseInt(qtyValue.textContent) || 1;
			const newQty = currentQty + 1;
			rushbyUpdateQuantity(cartItemKey, newQty);
		}
	}

	/**
	 * Handle Remove Item Click
	 */
	function handleRemoveItem(e) {
		e.preventDefault();
		const button = e.currentTarget;
		const cartItemKey = button.getAttribute('data-cart-item-key');

		if (cartItemKey && confirm('Are you sure you want to remove this item?')) {
			rushbyRemoveCartItem(cartItemKey);
		}
	}

	/**
	 * Toggle Search Bar
	 */
	window.rushbyToggleSearch = function (button) {
		const header = button.closest('.rushby-header');
		if (!header) return;

		const searchBar = header.querySelector('.rushby-search-bar');
		if (!searchBar) return;

		if (searchBar.style.display === 'none' || !searchBar.style.display) {
			searchBar.style.display = 'block';
			setTimeout(function () {
				const input = searchBar.querySelector('.rushby-search-input');
				if (input) input.focus();
			}, 100);
		} else {
			searchBar.style.display = 'none';
		}
	};

	/**
	 * Toggle Mobile Menu
	 */
	window.rushbyToggleMobileMenu = function (button) {
		const header = button.closest('.rushby-header');
		if (!header) return;

		const mobileMenu = header.querySelector('.rushby-mobile-menu');
		const menuIcon = button.querySelector('.rushby-menu-icon');
		const closeIcon = button.querySelector('.rushby-close-icon');

		if (!mobileMenu) return;

		if (mobileMenu.style.display === 'none' || !mobileMenu.style.display) {
			mobileMenu.style.display = 'block';
			if (menuIcon) menuIcon.style.display = 'none';
			if (closeIcon) closeIcon.style.display = 'block';
		} else {
			mobileMenu.style.display = 'none';
			if (menuIcon) menuIcon.style.display = 'block';
			if (closeIcon) closeIcon.style.display = 'none';
		}
	};

	/**
	 * Handle Header Scroll Behavior
	 * Ensures smooth transition when announcement bar scrolls out of view
	 */
	function rushbyHandleHeaderScroll() {
		const announcementBar = document.querySelector('.rushby-announcement-bar');
		const header = document.querySelector('.rushby-header');

		if (!announcementBar || !header) return;

		const announcementBarHeight = announcementBar.offsetHeight;
		const scrolled = window.pageYOffset || document.documentElement.scrollTop;

		// Add a class to header when announcement bar is scrolled past
		if (scrolled > announcementBarHeight) {
			header.classList.add('rushby-header-scrolled');
		} else {
			header.classList.remove('rushby-header-scrolled');
		}
	}

	/**
	 * Toggle Currency Menu
	 */
	window.rushbyToggleCurrencyMenu = function (button) {
		const container = button.closest('.rushby-currency-float-container');
		if (!container) return;

		const menu = container.querySelector('.rushby-currency-menu');
		if (!menu) return;

		if (menu.style.display === 'none' || !menu.style.display) {
			menu.style.display = 'block';
			setTimeout(function () {
				menu.classList.add('show');
			}, 10);
		} else {
			menu.classList.remove('show');
			setTimeout(function () {
				menu.style.display = 'none';
			}, 200);
		}
	};

	/**
	 * Close Currency Menu
	 */
	window.rushbyCloseCurrencyMenu = function (button) {
		const container = button.closest('.rushby-currency-float-container');
		if (!container) return;

		const menu = container.querySelector('.rushby-currency-menu');
		if (!menu) return;

		menu.classList.remove('show');
		setTimeout(function () {
			menu.style.display = 'none';
		}, 200);
	};

	/**
	 * Select Currency
	 * Integrates with Currency Converter for WooCommerce plugin
	 */
	window.rushbySelectCurrency = function (button) {
		const currencyCode = button.getAttribute('data-currencycode');
		if (!currencyCode) return;

		const container = button.closest('.rushby-currency-float-container');
		if (!container) return;

		// Update active state
		const allItems = container.querySelectorAll('.rushby-currency-item');
		allItems.forEach(function (item) {
			item.classList.remove('active');
			const indicator = item.querySelector('.rushby-currency-item-indicator');
			if (indicator) {
				indicator.remove();
			}
		});

		button.classList.add('active');
		const newIndicator = document.createElement('div');
		newIndicator.className = 'rushby-currency-item-indicator';
		button.appendChild(newIndicator);

		// Update floating button
		const flagSpan = container.querySelector('.rushby-currency-flag');
		const codeSpan = container.querySelector('.rushby-currency-code');
		const itemFlag = button.querySelector('.rushby-currency-item-flag');

		if (flagSpan && itemFlag) {
			flagSpan.textContent = itemFlag.textContent;
			flagSpan.setAttribute('data-currency', currencyCode);
		}

		if (codeSpan) {
			codeSpan.textContent = currencyCode;
		}

		// Use jQuery.cookie if available (Currency Converter plugin provides it)
		// Otherwise set cookie with vanilla JS
		if (typeof jQuery !== 'undefined' && typeof jQuery.cookie !== 'undefined') {
			jQuery.cookie('woocommerce_current_currency', currencyCode, { expires: 7, path: '/' });
		} else {
			// Fallback: set cookie manually
			let expires = '';
			const date = new Date();
			date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
			expires = '; expires=' + date.toUTCString();
			document.cookie = 'woocommerce_current_currency=' + currencyCode + expires + '; path=/';
		}

		// Close menu first for better UX
		rushbyCloseCurrencyMenu(button);

		// Trigger the Currency Converter plugin's conversion
		// The plugin listens for clicks on elements with data-currencycode
		if (typeof jQuery !== 'undefined') {
			// Trigger the plugin's internal currency change handler
			// This will convert prices without reloading the page
			jQuery('body').trigger('currency_converter_switch', [currencyCode]);

			// If the plugin's switch_currency function exists, call it directly
			// This ensures immediate price conversion
			setTimeout(function() {
				window.location.reload();
			}, 100);
		}
	};

	/**
	 * Close currency menu when clicking outside
	 */
	function rushbyHandleCurrencyClickOutside(event) {
		const containers = document.querySelectorAll('.rushby-currency-float-container');
		containers.forEach(function (container) {
			const menu = container.querySelector('.rushby-currency-menu');
			const button = container.querySelector('.rushby-currency-float-button');

			if (menu && menu.classList.contains('show')) {
				if (!container.contains(event.target)) {
					menu.classList.remove('show');
					setTimeout(function () {
						menu.style.display = 'none';
					}, 200);
				}
			}
		});
	}

	/**
	 * Toggle Header Currency Dropdown
	 */
	window.rushbyToggleHeaderCurrency = function (button) {
		const dropdown = button.parentElement.querySelector('.rushby-currency-dropdown');
		if (!dropdown) return;

		if (dropdown.style.display === 'none' || !dropdown.style.display) {
			dropdown.style.display = 'block';
			setTimeout(function () {
				dropdown.classList.add('show');
				button.classList.add('open');
			}, 10);
		} else {
			dropdown.classList.remove('show');
			button.classList.remove('open');
			setTimeout(function () {
				dropdown.style.display = 'none';
			}, 200);
		}
	};

	/**
	 * Select Currency from Header Dropdown
	 * Integrates with Currency Converter for WooCommerce plugin
	 */
	window.rushbySelectHeaderCurrency = function (button, event) {
		if (event) {
			event.preventDefault();
			event.stopPropagation();
		}

		const currencyCode = button.getAttribute('data-currencycode');
		if (!currencyCode) return;

		const dropdown = button.closest('.rushby-currency-dropdown');
		const switcher = dropdown ? dropdown.closest('.rushby-header-currency-switcher') : null;
		const switcherButton = switcher ? switcher.querySelector('.rushby-currency-switcher-button') : null;

		if (!switcher || !switcherButton) return;

		// Update active state
		const allItems = dropdown.querySelectorAll('.rushby-currency-dropdown-item');
		allItems.forEach(function (item) {
			item.classList.remove('active');
		});
		button.classList.add('active');

		// Update button display
		const flagSpan = switcherButton.querySelector('.rushby-currency-flag-desktop');
		const codeSpan = switcherButton.querySelector('.rushby-currency-code-text');
		const itemFlag = button.querySelector('.rushby-currency-dropdown-flag');

		if (flagSpan && itemFlag) {
			flagSpan.textContent = itemFlag.textContent;
		}

		if (codeSpan) {
			codeSpan.textContent = currencyCode;
		}

		// Use jQuery.cookie if available (Currency Converter plugin provides it)
		// Otherwise set cookie with vanilla JS
		if (typeof jQuery !== 'undefined' && typeof jQuery.cookie !== 'undefined') {
			jQuery.cookie('woocommerce_current_currency', currencyCode, { expires: 7, path: '/' });
		} else {
			// Fallback: set cookie manually
			let expires = '';
			const date = new Date();
			date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
			expires = '; expires=' + date.toUTCString();
			document.cookie = 'woocommerce_current_currency=' + currencyCode + expires + '; path=/';
		}

		// Close dropdown first for better UX
		dropdown.classList.remove('show');
		switcherButton.classList.remove('open');
		setTimeout(function () {
			dropdown.style.display = 'none';
		}, 200);

		// Trigger the Currency Converter plugin's conversion
		if (typeof jQuery !== 'undefined') {
			// Trigger the plugin's internal currency change handler
			jQuery('body').trigger('currency_converter_switch', [currencyCode]);

			// Reload page to ensure all prices are updated
			setTimeout(function () {
				window.location.reload();
			}, 100);
		}
	};

	/**
	 * Close header currency dropdown when clicking outside
	 */
	function rushbyHandleHeaderCurrencyClickOutside(event) {
		const switchers = document.querySelectorAll('.rushby-header-currency-switcher');
		switchers.forEach(function (switcher) {
			const dropdown = switcher.querySelector('.rushby-currency-dropdown');
			const button = switcher.querySelector('.rushby-currency-switcher-button');

			if (dropdown && dropdown.classList.contains('show')) {
				if (!switcher.contains(event.target)) {
					dropdown.classList.remove('show');
					button.classList.remove('open');
					setTimeout(function () {
						dropdown.style.display = 'none';
					}, 200);
				}
			}
		});
	}

	/**
	 * Toggle Announcement Currency Dropdown
	 */
	window.rushbyToggleAnnouncementCurrency = function (button) {
		const dropdown = button.parentElement.querySelector('.rushby-announcement-currency-dropdown');
		if (!dropdown) return;

		if (dropdown.style.display === 'none' || !dropdown.style.display) {
			dropdown.style.display = 'block';
			setTimeout(function () {
				dropdown.classList.add('show');
				button.classList.add('open');
			}, 10);
		} else {
			dropdown.classList.remove('show');
			button.classList.remove('open');
			setTimeout(function () {
				dropdown.style.display = 'none';
			}, 200);
		}
	};

	/**
	 * Select Currency from Announcement Dropdown
	 * Integrates with Currency Converter for WooCommerce plugin
	 */
	window.rushbySelectAnnouncementCurrency = function (button) {
		const currencyCode = button.getAttribute('data-currencycode');
		if (!currencyCode) return;

		const dropdown = button.closest('.rushby-announcement-currency-dropdown');
		const switcher = dropdown ? dropdown.closest('.rushby-announcement-mobile-currency') : null;
		const switcherButton = switcher ? switcher.querySelector('.rushby-announcement-currency-button') : null;

		if (!switcher || !switcherButton) return;

		// Update active state
		const allItems = dropdown.querySelectorAll('.rushby-announcement-currency-item');
		allItems.forEach(function (item) {
			item.classList.remove('active');
		});
		button.classList.add('active');

		// Update button display
		const flagSpan = switcherButton.querySelector('.rushby-currency-flag');
		const codeSpan = switcherButton.querySelector('.rushby-currency-code');
		const itemFlag = button.querySelector('.rushby-currency-flag-small');

		if (flagSpan && itemFlag) {
			flagSpan.textContent = itemFlag.textContent;
		}

		if (codeSpan) {
			codeSpan.textContent = currencyCode;
		}

		// Trigger currency change using the Currency Converter plugin's method
		if (typeof jQuery !== 'undefined' && typeof jQuery.cookie !== 'undefined') {
			// Set cookie that the plugin uses
			jQuery.cookie('woocommerce_current_currency', currencyCode, {
				expires: 1,
				path: '/'
			});

			// Trigger the plugin's currency change event
			jQuery(document).trigger('currencyChanged', [currencyCode]);

			// Reload page to apply currency changes
			setTimeout(function () {
				window.location.reload();
			}, 100);
		}

		// Close dropdown
		dropdown.classList.remove('show');
		switcherButton.classList.remove('open');
		setTimeout(function () {
			dropdown.style.display = 'none';
		}, 200);
	};

	/**
	 * Close announcement currency dropdown when clicking outside
	 */
	function rushbyHandleAnnouncementCurrencyClickOutside(event) {
		const switchers = document.querySelectorAll('.rushby-announcement-mobile-currency');
		switchers.forEach(function (switcher) {
			const dropdown = switcher.querySelector('.rushby-announcement-currency-dropdown');
			const button = switcher.querySelector('.rushby-announcement-currency-button');

			if (dropdown && dropdown.classList.contains('show')) {
				if (!switcher.contains(event.target)) {
					dropdown.classList.remove('show');
					if (button) button.classList.remove('open');
					setTimeout(function () {
						dropdown.style.display = 'none';
					}, 200);
				}
			}
		});
	}

	/**
	 * Initialize on Document Ready
	 */
	$(document).ready(function () {
		rushbyAttachCartEvents();

		// Initialize scroll behavior for header/announcement bar
		if (document.querySelector('.rushby-announcement-bar') && document.querySelector('.rushby-header')) {
			// Initial check
			rushbyHandleHeaderScroll();

			// Add scroll listener with throttling for performance
			let ticking = false;
			window.addEventListener('scroll', function () {
				if (!ticking) {
					window.requestAnimationFrame(function () {
						rushbyHandleHeaderScroll();
						ticking = false;
					});
					ticking = true;
				}
			});
		}

		// Initialize currency switcher click-outside handler
		if (document.querySelector('.rushby-currency-float-container')) {
			document.addEventListener('click', rushbyHandleCurrencyClickOutside);
		}

		// Initialize header currency switcher click-outside handler
		if (document.querySelector('.rushby-header-currency-switcher')) {
			document.addEventListener('click', rushbyHandleHeaderCurrencyClickOutside);
		}

		// Initialize announcement currency switcher click-outside handler
		if (document.querySelector('.rushby-announcement-mobile-currency')) {
			document.addEventListener('click', rushbyHandleAnnouncementCurrencyClickOutside);
		}

		// Listen for WooCommerce add to cart events
		$(document.body).on('added_to_cart', function (event, fragments, cart_hash, button) {
			// Refresh cart fragments
			if (typeof rushby_get_cart_fragments !== 'undefined') {
				$.ajax({
					type: 'POST',
					url: rushby_cart_ajax.ajax_url,
					data: {
						action: 'woocommerce_get_refreshed_fragments'
					},
					success: function (response) {
						if (response && response.fragments) {
							rushbyUpdateCartFragments(response.fragments);
						}
					}
				});
			}

			// Open side cart when item is added
			setTimeout(function () {
				rushbyOpenSideCart();
			}, 300);
		});
	});

})(jQuery);

/**
 * ========================================
 * Product Grid Widget JavaScript
 * ========================================
 */

(function ($) {
	'use strict';

	// Store selected variations for each product
	const productVariations = {};

	/**
	 * Initialize Product Grid functionality
	 */
	function initProductGrid() {
		// Variation swatch selection
		$(document).on('click', '.rushby-variation-swatch', function () {
			const $swatch = $(this);
			const $card = $swatch.closest('.rushby-product-card');
			const productId = $card.data('product-id');
			const attribute = $swatch.data('attribute');
			const value = $swatch.data('value');

			// Toggle selection
			$swatch.siblings('.rushby-variation-swatch').removeClass('selected');
			$swatch.addClass('selected');

			// Store selected variation
			if (!productVariations[productId]) {
				productVariations[productId] = {};
			}
			productVariations[productId][attribute] = value;

			// Update add to cart button state
			updateAddToCartButton($card);
		});

		// Add to cart
		$(document).on('click', '.rushby-product-add-to-cart', function (e) {
			e.preventDefault();
			const $button = $(this);
			const $card = $button.closest('.rushby-product-card');
			const productId = $card.data('product-id');
			const productType = $button.data('product-type');

			// Check if product is variable and variations are not selected
			if (productType === 'variable') {
				const selectedVariations = productVariations[productId] || {};
				const $variationGroups = $card.find('.rushby-variation-group');

				// Check if all variations are selected
				let allSelected = true;
				$variationGroups.each(function () {
					const attribute = $(this).find('.rushby-variation-swatch:first').data('attribute');
					if (!selectedVariations[attribute]) {
						allSelected = false;
						return false;
					}
				});

				if (!allSelected) {
					showNotice('Please select all product options', 'error');
					return;
				}
			}

			addToCart($button, productId, productType);
		});

		// Quick view
		$(document).on('click', '.rushby-quick-view-btn', function (e) {
			e.preventDefault();
			const productId = $(this).data('product-id');
			openQuickView(productId);
		});

		// Close quick view modal
		$(document).on('click', '.rushby-quick-view-close, .rushby-quick-view-modal', function (e) {
			if (e.target === this) {
				closeQuickView();
			}
		});

		// ESC key to close modal
		$(document).on('keydown', function (e) {
			if (e.key === 'Escape') {
				closeQuickView();
			}
		});
	}

	/**
	 * Add product to cart via AJAX
	 */
	function addToCart($button, productId, productType) {
		if ($button.hasClass('loading')) {
			return;
		}

		$button.addClass('loading').prop('disabled', true);

		const data = {
			action: 'rushby_add_to_cart',
			nonce: rushby_cart_ajax.nonce,
			product_id: productId,
			quantity: 1,
		};

		// Add variation data if variable product
		if (productType === 'variable' && productVariations[productId]) {
			// Find variation ID based on selected attributes
			findVariationId(productId, productVariations[productId])
				.then(function (variationId) {
					if (variationId) {
						data.variation_id = variationId;
						data.variation = productVariations[productId];
						performAddToCart(data, $button);
					} else {
						$button.removeClass('loading').prop('disabled', false);
						showNotice('Selected variation not available', 'error');
					}
				})
				.catch(function () {
					$button.removeClass('loading').prop('disabled', false);
					showNotice('Error finding product variation', 'error');
				});
		} else {
			performAddToCart(data, $button);
		}
	}

	/**
	 * Perform the add to cart AJAX request
	 */
	function performAddToCart(data, $button) {
		$.ajax({
			url: rushby_cart_ajax.ajax_url,
			type: 'POST',
			data: data,
			success: function (response) {
				$button.removeClass('loading').prop('disabled', false);

				if (response.success) {
					// Update cart count
					$('.rushby-cart-count').text(response.data.cart_count);

					// Update cart fragments
					if (response.data.fragments) {
						$.each(response.data.fragments, function (key, value) {
							$(key).replaceWith(value);
						});
					}

					// Show success notification
					showNotice('Product added to cart!', 'success');

					// Trigger WooCommerce event
					$(document.body).trigger('added_to_cart', [
						response.data.fragments,
						response.data.cart_hash,
						$button,
					]);

					// Open side cart if it exists
					if (typeof rushbyOpenSideCart === 'function') {
						setTimeout(function () {
							rushbyOpenSideCart();
						}, 300);
					}
				} else {
					showNotice(response.data.message || 'Failed to add product to cart', 'error');
				}
			},
			error: function () {
				$button.removeClass('loading').prop('disabled', false);
				showNotice('Error adding product to cart', 'error');
			},
		});
	}

	/**
	 * Find variation ID based on selected attributes
	 */
	function findVariationId(productId, selectedAttributes) {
		return new Promise(function (resolve, reject) {
			$.ajax({
				url: rushby_cart_ajax.ajax_url,
				type: 'POST',
				data: {
					action: 'rushby_get_product_variations',
					nonce: rushby_cart_ajax.nonce,
					product_id: productId,
				},
				success: function (response) {
					if (response.success && response.data.variations) {
						// Find matching variation
						const variations = response.data.variations;
						for (let i = 0; i < variations.length; i++) {
							const variation = variations[i];
							let matches = true;

							// Check if all selected attributes match this variation
							for (const attr in selectedAttributes) {
								const variationAttr = 'attribute_' + attr;
								if (
									variation.attributes[variationAttr] &&
									variation.attributes[variationAttr] !== selectedAttributes[attr]
								) {
									matches = false;
									break;
								}
							}

							if (matches) {
								resolve(variation.variation_id);
								return;
							}
						}
						resolve(null);
					} else {
						reject();
					}
				},
				error: function () {
					reject();
				},
			});
		});
	}

	/**
	 * Update add to cart button state
	 */
	function updateAddToCartButton($card) {
		const productId = $card.data('product-id');
		const $button = $card.find('.rushby-product-add-to-cart');
		const selectedVariations = productVariations[productId] || {};
		const $variationGroups = $card.find('.rushby-variation-group');

		let allSelected = true;
		$variationGroups.each(function () {
			const attribute = $(this).find('.rushby-variation-swatch:first').data('attribute');
			if (!selectedVariations[attribute]) {
				allSelected = false;
				return false;
			}
		});

		// Update button text
		if (allSelected) {
			$button.find('span').text('Add to Cart');
		} else {
			$button.find('span').text('Select Options');
		}
	}

	/**
	 * Open quick view modal
	 */
	function openQuickView(productId) {
		// Create modal if it doesn't exist
		let $modal = $('.rushby-quick-view-modal');
		if ($modal.length === 0) {
			$modal = $(
				'<div class="rushby-quick-view-modal">' +
					'<div class="rushby-quick-view-content">' +
					'<button class="rushby-quick-view-close">&times;</button>' +
					'<div class="rushby-quick-view-body"></div>' +
					'</div>' +
					'</div>'
			);
			$('body').append($modal);
		}

		// Load product content
		const $body = $modal.find('.rushby-quick-view-body');
		$body.html('<p style="text-align:center;padding:2rem;">Loading...</p>');
		$modal.addClass('active');

		// In a real implementation, you would load the product via AJAX
		// For now, redirect to product page
		setTimeout(function () {
			$body.html(
				'<p style="text-align:center;padding:2rem;">Quick view feature coming soon. <a href="#" onclick="jQuery(\'.rushby-quick-view-modal\').removeClass(\'active\'); return false;">Close</a></p>'
			);
		}, 300);
	}

	/**
	 * Close quick view modal
	 */
	function closeQuickView() {
		$('.rushby-quick-view-modal').removeClass('active');
	}

	/**
	 * Show notification message
	 */
	function showNotice(message, type) {
		// Remove existing notice
		$('.rushby-add-to-cart-notice').remove();

		// Create notice
		const bgColor = type === 'success' ? '#10B981' : '#EF4444';
		const icon =
			type === 'success'
				? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
				: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';

		const $notice = $(
			'<div class="rushby-add-to-cart-notice" style="background-color:' +
				bgColor +
				'">' +
				icon +
				'<span>' +
				message +
				'</span>' +
				'</div>'
		);

		$('body').append($notice);

		// Show with animation
		setTimeout(function () {
			$notice.addClass('show');
		}, 100);

		// Hide after 3 seconds
		setTimeout(function () {
			$notice.removeClass('show');
			setTimeout(function () {
				$notice.remove();
			}, 300);
		}, 3000);
	}

	// Initialize on document ready
	$(document).ready(function () {
		initProductGrid();
	});

	// Re-initialize on Elementor preview load
	$(window).on('elementor/frontend/init', function () {
		initProductGrid();
	});
})(jQuery);


/**
 * ========================================
 * Cart Page Widget JavaScript
 * ========================================
 */

(function ($) {
	'use strict';

	/**
	 * Initialize Cart Page functionality
	 */
	function initCartPage() {
		// Quantity controls for cart page
		$(document).on('click', '.rushby-cart-qty-plus', function () {
			const $button = $(this);
			const cartItemKey = $button.data('cart-item-key');
			const $item = $button.closest('.rushby-cart-item');
			const $qtyValue = $item.find('.rushby-cart-qty-value');
			const currentQty = parseInt($qtyValue.text()) || 1;
			const newQty = currentQty + 1;

			updateCartItemQuantity(cartItemKey, newQty, $item);
		});

		$(document).on('click', '.rushby-cart-qty-minus', function () {
			const $button = $(this);
			const cartItemKey = $button.data('cart-item-key');
			const $item = $button.closest('.rushby-cart-item');
			const $qtyValue = $item.find('.rushby-cart-qty-value');
			const currentQty = parseInt($qtyValue.text()) || 1;

			if (currentQty > 1) {
				const newQty = currentQty - 1;
				updateCartItemQuantity(cartItemKey, newQty, $item);
			}
		});

		// Remove item from cart
		$(document).on('click', '.rushby-cart-remove-btn', function () {
			const $button = $(this);
			const cartItemKey = $button.data('cart-item-key');
			const $item = $button.closest('.rushby-cart-item');

			if (confirm('Are you sure you want to remove this item from your cart?')) {
				removeCartItem(cartItemKey, $item);
			}
		});

		// Apply coupon
		$(document).on('submit', '.rushby-cart-coupon-form', function (e) {
			e.preventDefault();
			const $form = $(this);
			const couponCode = $form.find('.rushby-cart-coupon-input').val();

			if (couponCode) {
				applyCoupon(couponCode, $form);
			}
		});

		// Remove coupon
		$(document).on('click', '.rushby-cart-coupon-remove', function () {
			const $button = $(this);
			const couponCode = $button.data('coupon');

			removeCoupon(couponCode);
		});
	}

	/**
	 * Update cart item quantity
	 */
	function updateCartItemQuantity(cartItemKey, quantity, $item) {
		$item.css('opacity', '0.6');

		$.ajax({
			url: rushby_cart_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'rushby_update_cart_quantity',
				nonce: rushby_cart_ajax.nonce,
				cart_item_key: cartItemKey,
				quantity: quantity,
			},
			success: function (response) {
				if (response.success) {
					// Reload page to show updated totals
					window.location.reload();
				} else {
					$item.css('opacity', '1');
					alert(response.data.message || 'Failed to update quantity');
				}
			},
			error: function () {
				$item.css('opacity', '1');
				alert('Error updating cart');
			},
		});
	}

	/**
	 * Remove item from cart
	 */
	function removeCartItem(cartItemKey, $item) {
		$item.css('opacity', '0.6');

		$.ajax({
			url: rushby_cart_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'rushby_remove_cart_item',
				nonce: rushby_cart_ajax.nonce,
				cart_item_key: cartItemKey,
			},
			success: function (response) {
				if (response.success) {
					// Fade out and remove the item
					$item.fadeOut(300, function () {
						$(this).remove();
						// Reload page to update totals
						window.location.reload();
					});
				} else {
					$item.css('opacity', '1');
					alert(response.data.message || 'Failed to remove item');
				}
			},
			error: function () {
				$item.css('opacity', '1');
				alert('Error removing item');
			},
		});
	}

	/**
	 * Apply coupon code
	 */
	function applyCoupon(couponCode, $form) {
		const $button = $form.find('.rushby-cart-coupon-btn');
		const originalText = $button.text();

		$button.text('Applying...').prop('disabled', true);

		$.ajax({
			url: rushby_cart_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'rushby_apply_coupon',
				nonce: rushby_cart_ajax.nonce,
				coupon_code: couponCode,
			},
			success: function (response) {
				if (response.success) {
					// Reload page to show applied coupon
					window.location.reload();
				} else {
					$button.text(originalText).prop('disabled', false);
					alert(response.data.message || 'Invalid coupon code');
				}
			},
			error: function () {
				$button.text(originalText).prop('disabled', false);
				alert('Error applying coupon');
			},
		});
	}

	/**
	 * Remove coupon code
	 */
	function removeCoupon(couponCode) {
		$.ajax({
			url: rushby_cart_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'rushby_remove_coupon',
				nonce: rushby_cart_ajax.nonce,
				coupon_code: couponCode,
			},
			success: function (response) {
				if (response.success) {
					// Reload page to show updated totals
					window.location.reload();
				} else {
					alert(response.data.message || 'Failed to remove coupon');
				}
			},
			error: function () {
				alert('Error removing coupon');
			},
		});
	}

	// Initialize on document ready
	$(document).ready(function () {
		initCartPage();
	});
})(jQuery);

/**
 * ========================================
 * Product Page Widget JavaScript
 * ========================================
 */

(function ($) {
	'use strict';

	/**
	 * Initialize Product Page functionality
	 */
	function initProductPage() {
		// Gallery thumbnail switching
		$(document).on('click', '.rushby-gallery-thumb', function () {
			const $thumb = $(this);
			const newImageSrc = $thumb.find('img').attr('src');
			const newImageSrcset = $thumb.find('img').attr('srcset');
			const newImageSizes = $thumb.find('img').attr('sizes');
			const newImageAlt = $thumb.find('img').attr('alt');

			// Update main image
			const $mainImage = $('.rushby-product-main-image img');
			if ($mainImage.length && newImageSrc) {
				$mainImage.attr('src', newImageSrc);
				if (newImageSrcset) {
					$mainImage.attr('srcset', newImageSrcset);
				}
				if (newImageSizes) {
					$mainImage.attr('sizes', newImageSizes);
				}
				if (newImageAlt) {
					$mainImage.attr('alt', newImageAlt);
				}
			}

			// Update active state
			$('.rushby-gallery-thumb').removeClass('active');
			$thumb.addClass('active');
		});

		// Initialize first thumbnail as active
		$('.rushby-gallery-thumb:first').addClass('active');
	}

	// Initialize on document ready
	$(document).ready(function () {
		initProductPage();
	});

	// Re-initialize on Elementor preview load
	$(window).on('elementor/frontend/init', function () {
		initProductPage();
	});
})(jQuery);

/**
 * ========================================
 * Product Filter Widget JavaScript
 * ========================================
 */

(function ($) {
	'use strict';

	/**
	 * Initialize Product Filter functionality
	 */
	function initProductFilter() {
		// Filter button click
		$(document).on('click', '.rushby-filter-button', function () {
			const $button = $(this);
			const $filterContainer = $button.closest('.rushby-filter-buttons');
			const targetGridId = $filterContainer.data('target-grid');
			const category = $button.data('category');

			// Don't filter if already active
			if ($button.hasClass('active')) {
				return;
			}

			// Update active state
			$filterContainer.find('.rushby-filter-button').removeClass('active');
			$button.addClass('active');

			// Find target grid
			const $targetGrid = $('#' + targetGridId);
			if ($targetGrid.length === 0) {
				console.error('Target grid not found:', targetGridId);
				return;
			}

			// Get widget settings from data attribute
			const widgetSettings = $targetGrid.data('widget-settings');
			if (!widgetSettings) {
				console.error('Widget settings not found on target grid');
				return;
			}

			// Filter products
			filterProducts(category, widgetSettings, $targetGrid);
		});
	}

	/**
	 * Filter products via AJAX
	 */
	function filterProducts(category, widgetSettings, $targetGrid) {
		// Add loading state
		$targetGrid.addClass('filtering');
		const $productGrid = $targetGrid.find('.rushby-product-grid');

		// Disable all filter buttons during request
		$('.rushby-filter-button').prop('disabled', true);

		$.ajax({
			url: rushby_cart_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'rushby_filter_products',
				nonce: rushby_cart_ajax.nonce,
				category: category,
				widget_settings: JSON.stringify(widgetSettings),
			},
			success: function (response) {
				if (response.success && response.data.html) {
					// Fade out old products
					$productGrid.fadeOut(200, function () {
						// Replace with new products
						$productGrid.html(response.data.html);

						// Fade in new products
						$productGrid.fadeIn(200);

						// Re-attach event listeners for new products
						if (typeof initProductGrid === 'function') {
							initProductGrid();
						}
					});
				} else {
					console.error('Filter failed:', response.data?.message || 'Unknown error');
					showFilterNotice('Failed to filter products', 'error');
				}
			},
			error: function (xhr, status, error) {
				console.error('AJAX error:', status, error);
				showFilterNotice('Error filtering products', 'error');
			},
			complete: function () {
				// Remove loading state
				$targetGrid.removeClass('filtering');

				// Re-enable filter buttons
				$('.rushby-filter-button').prop('disabled', false);
			},
		});
	}

	/**
	 * Show filter notification
	 */
	function showFilterNotice(message, type) {
		// Remove existing notice
		$('.rushby-filter-notice').remove();

		// Create notice
		const bgColor = type === 'success' ? '#10B981' : '#EF4444';
		const icon =
			type === 'success'
				? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
				: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';

		const $notice = $(
			'<div class="rushby-filter-notice" style="position:fixed;bottom:2rem;right:2rem;background-color:' +
				bgColor +
				';color:#fff;padding:1rem 1.5rem;border-radius:0.5rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);display:flex;align-items:center;gap:0.75rem;z-index:9999;">' +
				'<div style="width:1.5rem;height:1.5rem;">' +
				icon +
				'</div>' +
				'<span>' +
				message +
				'</span>' +
				'</div>'
		);

		$('body').append($notice);

		// Hide after 3 seconds
		setTimeout(function () {
			$notice.fadeOut(300, function () {
				$(this).remove();
			});
		}, 3000);
	}

	// Initialize on document ready
	$(document).ready(function () {
		initProductFilter();
	});

	// Re-initialize on Elementor preview load
	$(window).on('elementor/frontend/init', function () {
		initProductFilter();
	});
})(jQuery);
