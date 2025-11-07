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

		// Trigger currency change using the Currency Converter plugin's method
		// The plugin listens for clicks on elements with data-currencycode attribute
		if (typeof jQuery !== 'undefined' && typeof jQuery.cookie !== 'undefined') {
			// Set cookie that the plugin uses
			jQuery.cookie('woocommerce_current_currency', currencyCode, {
				expires: 1,
				path: '/'
			});

			// Trigger the plugin's currency change event
			jQuery(document).trigger('currencyChanged', [currencyCode]);

			// Reload page to apply currency changes
			// The Currency Converter plugin requires a page reload to update all prices
			setTimeout(function () {
				window.location.reload();
			}, 100);
		}

		// Close menu
		rushbyCloseCurrencyMenu(button);
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
	window.rushbySelectHeaderCurrency = function (button) {
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
