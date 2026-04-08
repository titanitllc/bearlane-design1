/**
 * BearLane Design — WooCommerce JS
 *
 * Handles: Quick View modal, AJAX product filtering, AJAX add-to-cart feedback.
 * Depends on: jQuery (via WC), bearLane (localised from wp_localize_script)
 *
 * @version 1.0.0
 */

( function ( $, bearLane ) {
	'use strict';

	if ( ! bearLane ) return;

	const { ajaxUrl, nonce, strings } = bearLane;

	// -------------------------------------------------------------------------
	// Quick View Modal
	// -------------------------------------------------------------------------

	const modal     = document.getElementById( 'quick-view-modal' );
	const modalBody = modal ? modal.querySelector( '.quick-view__body' ) : null;

	function openModal() {
		if ( ! modal ) return;
		modal.classList.add( 'is-open' );
		modal.setAttribute( 'aria-hidden', 'false' );
		document.body.style.overflow = 'hidden';

		// Focus the close button.
		const closeBtn = modal.querySelector( '.js-modal-close' );
		if ( closeBtn ) setTimeout( () => closeBtn.focus(), 300 );
	}

	function closeModal() {
		if ( ! modal ) return;
		modal.classList.remove( 'is-open' );
		modal.setAttribute( 'aria-hidden', 'true' );
		document.body.style.overflow = '';

		// Return focus to trigger.
		if ( window.__qvTrigger ) {
			window.__qvTrigger.focus();
			window.__qvTrigger = null;
		}
	}

	// Close on overlay / button click.
	document.querySelectorAll( '.js-modal-close' ).forEach( btn => {
		btn.addEventListener( 'click', closeModal );
	} );

	// Close on Escape key.
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' && modal && modal.classList.contains( 'is-open' ) ) {
			closeModal();
		}
	} );

	// Quick View trigger.
	document.addEventListener( 'click', function ( e ) {
		const trigger = e.target.closest( '.quick-view-trigger' );
		if ( ! trigger ) return;

		const productId = trigger.dataset.productId;
		if ( ! productId ) return;

		e.preventDefault();
		window.__qvTrigger = trigger;

		// Show modal with spinner.
		if ( modalBody ) {
			modalBody.innerHTML = '<div class="loading-spinner" aria-hidden="true"></div>';
		}
		openModal();

		// Fetch product data via AJAX.
		$.ajax( {
			url:    ajaxUrl,
			method: 'POST',
			data:   { action: 'bearlane_quick_view', nonce, product_id: productId },
			success: function ( response ) {
				if ( response.success && modalBody ) {
					modalBody.innerHTML = response.data.html;
					// Init WC variation forms if present.
					if ( $.fn.wc_variation_form ) {
						$( modalBody ).find( 'form.variations_form' ).wc_variation_form();
					}
				} else {
					modalBody.innerHTML = '<p style="text-align:center;padding:2rem;">' + strings.loading + '</p>';
				}
			},
			error: function () {
				if ( modalBody ) {
					modalBody.innerHTML = '<p style="text-align:center;padding:2rem;color:var(--color-error);">Error loading product.</p>';
				}
			},
		} );
	} );

	// -------------------------------------------------------------------------
	// AJAX Add to Cart feedback
	// -------------------------------------------------------------------------

	$( document.body ).on( 'added_to_cart', function () {
		// Highlight the cart icon briefly.
		const cartBtn = document.querySelector( '.js-cart-toggle' );
		if ( cartBtn ) {
			cartBtn.classList.add( 'cart-added' );
			setTimeout( () => cartBtn.classList.remove( 'cart-added' ), 1200 );
		}
	} );

	// Inject CSS for cart-added pulse.
	( function () {
		const s = document.createElement( 'style' );
		s.textContent = `
			@keyframes cartPulse {
				0%   { transform: scale(1); }
				50%  { transform: scale(1.15); }
				100% { transform: scale(1); }
			}
			.cart-added { animation: cartPulse 0.4s ease; }
			.cart-added .cart-count { background-color: var(--color-success); }
		`;
		document.head.appendChild( s );
	} )();

	// -------------------------------------------------------------------------
	// AJAX Product Filtering
	// -------------------------------------------------------------------------

	( function initAjaxFilter() {
		const container = document.getElementById( 'products-container' );
		const form      = document.querySelector( '.woocommerce-ordering' );
		if ( ! container || ! form ) return;

		let currentPage = 1;

		/**
		 * Collect filter values and fire AJAX request.
		 *
		 * @param {number} page
		 */
		function fetchProducts( page ) {
			page = page || 1;
			currentPage = page;

			const data = {
				action:  'bearlane_filter_products',
				nonce,
				page,
			};

			// Orderby.
			const orderSelect = document.querySelector( '.woocommerce-ordering select' );
			if ( orderSelect ) data.orderby = orderSelect.value;

			// Category (from sidebar widget links).
			const activeCat = document.querySelector( '.product-categories .current-cat > a' );
			if ( activeCat ) {
				data.category = activeCat.getAttribute( 'data-slug' ) || '';
			}

			container.classList.add( 'is-loading' );

			$.ajax( {
				url:     ajaxUrl,
				method:  'POST',
				data,
				success: function ( response ) {
					container.classList.remove( 'is-loading' );
					if ( response.success ) {
						container.innerHTML = response.data.html;
						// Scroll to top of products area.
						container.scrollIntoView( { behavior: 'smooth', block: 'start' } );
					}
				},
				error: function () {
					container.classList.remove( 'is-loading' );
				},
			} );
		}

		// Bind sort dropdown.
		const orderSelect = document.querySelector( '.woocommerce-ordering select' );
		if ( orderSelect ) {
			orderSelect.addEventListener( 'change', () => fetchProducts( 1 ) );
		}

		// Bind category filter links.
		document.querySelectorAll( '.product-categories a' ).forEach( link => {
			link.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				document.querySelectorAll( '.product-categories li' ).forEach( li => li.classList.remove( 'current-cat' ) );
				this.closest( 'li' ).classList.add( 'current-cat' );
				fetchProducts( 1 );
			} );
		} );

	} )();

	// -------------------------------------------------------------------------
	// Product gallery image swap (simple)
	// -------------------------------------------------------------------------

	( function initGallery() {
		document.querySelectorAll( '.woocommerce-product-gallery .thumbnails a' ).forEach( thumb => {
			thumb.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				const mainImg = document.querySelector( '.woocommerce-product-gallery__image img' );
				if ( mainImg && this.dataset.large_image ) {
					mainImg.src = this.dataset.large_image;
				}
			} );
		} );
	} )();

} )( jQuery, window.bearLane );
