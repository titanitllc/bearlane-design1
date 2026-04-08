/**
 * BearLane Design — Main JS
 *
 * Handles: sticky header, navigation, dark mode, search panel,
 *          mini-cart drawer, scroll animations, view toggle.
 *
 * @version 1.0.0
 */

( function () {
	'use strict';

	// -------------------------------------------------------------------------
	// State
	// -------------------------------------------------------------------------

	const state = {
		navOpen:    false,
		searchOpen: false,
		cartOpen:   false,
		darkMode:   false,
	};

	// -------------------------------------------------------------------------
	// DOM selectors (cached)
	// -------------------------------------------------------------------------

	const header        = document.getElementById( 'site-header' );
	const navToggle     = document.querySelector( '.js-nav-toggle' );
	const primaryNav    = document.getElementById( 'site-navigation' );
	const searchToggle  = document.querySelector( '.js-search-toggle' );
	const searchPanel   = document.getElementById( 'site-search' );
	const searchClose   = document.querySelector( '.js-search-close' );
	const searchInput   = document.getElementById( 'header-search-input' );
	const cartToggle    = document.querySelector( '.js-cart-toggle' );
	const cartClose     = document.querySelectorAll( '.js-cart-close' );
	const miniCart      = document.getElementById( 'mini-cart' );
	const darkModeToggle = document.querySelector( '.js-dark-mode-toggle' );

	// -------------------------------------------------------------------------
	// Utility
	// -------------------------------------------------------------------------

	/**
	 * Trap focus within a container element.
	 */
	function trapFocus( container ) {
		const focusable = container.querySelectorAll(
			'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
		);
		const first = focusable[0];
		const last  = focusable[ focusable.length - 1 ];

		container.addEventListener( 'keydown', function handleKeydown( e ) {
			if ( e.key !== 'Tab' ) return;
			if ( e.shiftKey ) {
				if ( document.activeElement === first ) { e.preventDefault(); last.focus(); }
			} else {
				if ( document.activeElement === last ) { e.preventDefault(); first.focus(); }
			}
		} );
	}

	// -------------------------------------------------------------------------
	// Sticky Header + Shadow on scroll
	// -------------------------------------------------------------------------

	( function initStickyHeader() {
		if ( ! header ) return;
		let lastY = 0;
		window.addEventListener( 'scroll', function () {
			const y = window.scrollY;
			if ( y > 0 ) {
				header.classList.add( 'site-header--scrolled' );
			} else {
				header.classList.remove( 'site-header--scrolled' );
			}
			lastY = y;
		}, { passive: true } );
	} )();

	// Add CSS rule for scrolled state (box-shadow).
	( function () {
		const style = document.createElement( 'style' );
		style.textContent = '.site-header--scrolled { box-shadow: 0 1px 8px rgb(0 0 0/.08); }';
		document.head.appendChild( style );
	} )();

	// -------------------------------------------------------------------------
	// Mobile Navigation
	// -------------------------------------------------------------------------

	function openNav() {
		state.navOpen = true;
		document.body.classList.add( 'nav-open' );
		if ( navToggle ) navToggle.setAttribute( 'aria-expanded', 'true' );
		if ( primaryNav ) primaryNav.setAttribute( 'aria-hidden', 'false' );
		document.addEventListener( 'keydown', handleNavEscape );
	}

	function closeNav() {
		state.navOpen = false;
		document.body.classList.remove( 'nav-open' );
		if ( navToggle ) navToggle.setAttribute( 'aria-expanded', 'false' );
		if ( primaryNav ) primaryNav.setAttribute( 'aria-hidden', 'true' );
		document.removeEventListener( 'keydown', handleNavEscape );
	}

	function handleNavEscape( e ) {
		if ( e.key === 'Escape' ) closeNav();
	}

	if ( navToggle ) {
		navToggle.addEventListener( 'click', function () {
			state.navOpen ? closeNav() : openNav();
		} );
	}

	// -------------------------------------------------------------------------
	// Search Panel
	// -------------------------------------------------------------------------

	function openSearch() {
		state.searchOpen = true;
		if ( searchPanel ) {
			searchPanel.classList.add( 'is-open' );
			searchPanel.setAttribute( 'aria-hidden', 'false' );
		}
		if ( searchToggle ) searchToggle.setAttribute( 'aria-expanded', 'true' );
		if ( searchInput ) {
			setTimeout( () => searchInput.focus(), 200 );
		}
		document.addEventListener( 'keydown', handleSearchEscape );
	}

	function closeSearch() {
		state.searchOpen = false;
		if ( searchPanel ) {
			searchPanel.classList.remove( 'is-open' );
			searchPanel.setAttribute( 'aria-hidden', 'true' );
		}
		if ( searchToggle ) {
			searchToggle.setAttribute( 'aria-expanded', 'false' );
			searchToggle.focus();
		}
		document.removeEventListener( 'keydown', handleSearchEscape );
	}

	function handleSearchEscape( e ) {
		if ( e.key === 'Escape' ) closeSearch();
	}

	if ( searchToggle ) {
		searchToggle.addEventListener( 'click', function () {
			state.searchOpen ? closeSearch() : openSearch();
		} );
	}
	if ( searchClose ) {
		searchClose.addEventListener( 'click', closeSearch );
	}

	// -------------------------------------------------------------------------
	// Mini Cart Drawer
	// -------------------------------------------------------------------------

	function openCart() {
		state.cartOpen = true;
		if ( miniCart ) {
			miniCart.classList.add( 'is-open' );
			miniCart.setAttribute( 'aria-hidden', 'false' );
		}
		if ( cartToggle ) cartToggle.setAttribute( 'aria-expanded', 'true' );
		document.body.style.overflow = 'hidden';
		document.addEventListener( 'keydown', handleCartEscape );
		if ( miniCart ) trapFocus( miniCart );
	}

	function closeCart() {
		state.cartOpen = false;
		if ( miniCart ) {
			miniCart.classList.remove( 'is-open' );
			miniCart.setAttribute( 'aria-hidden', 'true' );
		}
		if ( cartToggle ) {
			cartToggle.setAttribute( 'aria-expanded', 'false' );
			cartToggle.focus();
		}
		document.body.style.overflow = '';
		document.removeEventListener( 'keydown', handleCartEscape );
	}

	function handleCartEscape( e ) {
		if ( e.key === 'Escape' ) closeCart();
	}

	if ( cartToggle ) {
		cartToggle.addEventListener( 'click', function () {
			state.cartOpen ? closeCart() : openCart();
		} );
	}
	if ( cartClose ) {
		cartClose.forEach( btn => btn.addEventListener( 'click', closeCart ) );
	}

	// -------------------------------------------------------------------------
	// Dark Mode Toggle
	// -------------------------------------------------------------------------

	( function initDarkMode() {
		const STORAGE_KEY = 'bearlaneDarkMode';
		const saved       = localStorage.getItem( STORAGE_KEY );
		const prefersDark = window.matchMedia( '(prefers-color-scheme: dark)' ).matches;

		function setDark( enabled ) {
			state.darkMode = enabled;
			document.documentElement.setAttribute( 'data-theme', enabled ? 'dark' : 'light' );
			localStorage.setItem( STORAGE_KEY, enabled ? '1' : '0' );
			if ( darkModeToggle ) {
				darkModeToggle.setAttribute( 'aria-pressed', String( enabled ) );
			}
		}

		// Apply saved preference or system preference.
		if ( saved === '1' ) {
			setDark( true );
		} else if ( saved === null && prefersDark ) {
			setDark( true );
		}

		if ( darkModeToggle ) {
			darkModeToggle.addEventListener( 'click', function () {
				setDark( ! state.darkMode );
			} );
		}

		// Listen for OS-level changes.
		window.matchMedia( '(prefers-color-scheme: dark)' ).addEventListener( 'change', function ( e ) {
			if ( localStorage.getItem( STORAGE_KEY ) === null ) {
				setDark( e.matches );
			}
		} );
	} )();

	// -------------------------------------------------------------------------
	// View Toggle (grid / list)
	// -------------------------------------------------------------------------

	( function initViewToggle() {
		const grid    = document.querySelector( '.js-view-grid' );
		const list    = document.querySelector( '.js-view-list' );
		const container = document.querySelector( '.woocommerce ul.products, .products-ajax-wrapper' );

		if ( ! grid || ! list || ! container ) return;

		function setView( view ) {
			if ( view === 'list' ) {
				container.classList.add( 'product-grid--list' );
				grid.classList.remove( 'is-active' );
				list.classList.add( 'is-active' );
				grid.setAttribute( 'aria-pressed', 'false' );
				list.setAttribute( 'aria-pressed', 'true' );
			} else {
				container.classList.remove( 'product-grid--list' );
				list.classList.remove( 'is-active' );
				grid.classList.add( 'is-active' );
				grid.setAttribute( 'aria-pressed', 'true' );
				list.setAttribute( 'aria-pressed', 'false' );
			}
			localStorage.setItem( 'bearlaneView', view );
		}

		const savedView = localStorage.getItem( 'bearlaneView' );
		if ( savedView ) setView( savedView );

		grid.addEventListener( 'click', () => setView( 'grid' ) );
		list.addEventListener( 'click', () => setView( 'list' ) );
	} )();

	// -------------------------------------------------------------------------
	// Filter Sidebar Toggle (mobile)
	// -------------------------------------------------------------------------

	( function initFilterToggle() {
		const btn   = document.querySelector( '.js-filter-toggle' );
		const panel = document.getElementById( 'filter-panel' );
		if ( ! btn || ! panel ) return;

		btn.addEventListener( 'click', function () {
			const open = panel.classList.toggle( 'is-open' );
			btn.setAttribute( 'aria-expanded', String( open ) );
		} );
	} )();

	// -------------------------------------------------------------------------
	// Scroll-reveal animation (Intersection Observer)
	// -------------------------------------------------------------------------

	( function initScrollReveal() {
		const items = document.querySelectorAll( '.product-card, .category-card, .usp-item, .testimonial-card, .value-card' );
		if ( ! items.length ) return;

		const observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.style.animation = 'fadeInUp 0.5s ease both';
					observer.unobserve( entry.target );
				}
			} );
		}, { threshold: 0.1 } );

		items.forEach( item => observer.observe( item ) );
	} )();

	// -------------------------------------------------------------------------
	// Smooth anchor scrolling
	// -------------------------------------------------------------------------

	document.querySelectorAll( 'a[href^="#"]' ).forEach( anchor => {
		anchor.addEventListener( 'click', function ( e ) {
			const target = document.querySelector( this.getAttribute( 'href' ) );
			if ( ! target ) return;
			e.preventDefault();
			target.scrollIntoView( { behavior: 'smooth', block: 'start' } );
		} );
	} );

	// -------------------------------------------------------------------------
	// newsletter form (lightweight)
	// -------------------------------------------------------------------------

	( function initNewsletterForm() {
		document.querySelectorAll( '.newsletter-form' ).forEach( function ( form ) {
			form.addEventListener( 'submit', function ( e ) {
				e.preventDefault();
				const btn   = form.querySelector( '.newsletter-form__btn' );
				const input = form.querySelector( '.newsletter-form__input' );
				if ( ! input || ! input.value || ! input.value.includes( '@' ) ) return;
				btn.textContent = '✓ Subscribed!';
				btn.disabled    = true;
				input.disabled  = true;
			} );
		} );
	} )();

	// -------------------------------------------------------------------------
	// FAQ Accordion
	// -------------------------------------------------------------------------

	( function initFaqAccordion() {
		const triggers = document.querySelectorAll( '.js-faq-trigger' );
		if ( ! triggers.length ) return;

		triggers.forEach( function ( trigger ) {
			trigger.addEventListener( 'click', function () {
				const expanded = this.getAttribute( 'aria-expanded' ) === 'true';
				const panel    = document.getElementById( this.getAttribute( 'aria-controls' ) );

				// Close all others (accordion behaviour).
				triggers.forEach( function ( t ) {
					const p = document.getElementById( t.getAttribute( 'aria-controls' ) );
					t.setAttribute( 'aria-expanded', 'false' );
					if ( p ) p.hidden = true;
				} );

				// Toggle this one.
				if ( ! expanded ) {
					this.setAttribute( 'aria-expanded', 'true' );
					if ( panel ) panel.hidden = false;
				}
			} );
		} );

		// Keyboard navigation.
		document.querySelectorAll( '.faq-accordion' ).forEach( function ( accordion ) {
			accordion.addEventListener( 'keydown', function ( e ) {
				const all = Array.from( accordion.querySelectorAll( '.js-faq-trigger' ) );
				const idx = all.indexOf( document.activeElement );
				if ( idx === -1 ) return;
				if ( e.key === 'ArrowDown' ) { e.preventDefault(); ( all[ idx + 1 ] || all[ 0 ] ).focus(); }
				if ( e.key === 'ArrowUp' )   { e.preventDefault(); ( all[ idx - 1 ] || all[ all.length - 1 ] ).focus(); }
				if ( e.key === 'Home' )       { e.preventDefault(); all[ 0 ].focus(); }
				if ( e.key === 'End' )        { e.preventDefault(); all[ all.length - 1 ].focus(); }
			} );
		} );
	} )();

	// -------------------------------------------------------------------------
	// Product Tabs (Best Sellers / New Arrivals / Staff Picks)
	// -------------------------------------------------------------------------

	( function initProductTabs() {
		const tabSets = document.querySelectorAll( '[role="tablist"]' );
		if ( ! tabSets.length ) return;

		tabSets.forEach( function ( tablist ) {
			const tabs   = Array.from( tablist.querySelectorAll( '[role="tab"]' ) );
			const panels = tabs.map( t => document.getElementById( t.getAttribute( 'aria-controls' ) ) );

			function activate( idx ) {
				tabs.forEach( ( t, i ) => {
					const selected = i === idx;
					t.setAttribute( 'aria-selected', String( selected ) );
					t.classList.toggle( 'is-active', selected );
					if ( panels[ i ] ) {
						panels[ i ].hidden    = ! selected;
						panels[ i ].classList.toggle( 'is-active', selected );
					}
				} );
			}

			tabs.forEach( function ( tab, i ) {
				tab.addEventListener( 'click', () => activate( i ) );
				tab.addEventListener( 'keydown', function ( e ) {
					if ( e.key === 'ArrowRight' ) { activate( ( i + 1 ) % tabs.length ); tabs[ ( i + 1 ) % tabs.length ].focus(); }
					if ( e.key === 'ArrowLeft' )  { activate( ( i - 1 + tabs.length ) % tabs.length ); tabs[ ( i - 1 + tabs.length ) % tabs.length ].focus(); }
				} );
			} );
		} );
	} )();

	// -------------------------------------------------------------------------
	// Scroll-reveal animation (Intersection Observer) — extended targets
	// -------------------------------------------------------------------------

	( function initScrollRevealExtended() {
		const items = document.querySelectorAll(
			'.how-it-works-step, .embroidery-quality-item, .bulk-use-case, ' +
			'.faq-item, .testimonial-card, .product-card, .category-card, ' +
			'.usp-item, .value-card'
		);
		if ( ! items.length ) return;

		const observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.style.animation = 'fadeInUp 0.45s ease both';
					observer.unobserve( entry.target );
				}
			} );
		}, { threshold: 0.08 } );

		items.forEach( item => observer.observe( item ) );
	} )();

	// -------------------------------------------------------------------------
	// Sticky Add-to-Cart (mobile — single product page)
	// -------------------------------------------------------------------------

	( function initStickyAtc() {
		const stickyBar = document.querySelector( '.sticky-atc' );
		const anchor    = document.getElementById( 'product-add-to-cart-anchor' );
		if ( ! stickyBar || ! anchor ) return;

		const observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				stickyBar.classList.toggle( 'is-visible', ! entry.isIntersecting );
			} );
		}, { threshold: 0 } );

		observer.observe( anchor );

		// Scroll to add-to-cart on sticky bar click.
		const stickyBtn = stickyBar.querySelector( '.sticky-atc__btn' );
		if ( stickyBtn ) {
			stickyBtn.addEventListener( 'click', function () {
				const form = document.querySelector( 'form.cart' );
				if ( form ) {
					form.scrollIntoView( { behavior: 'smooth', block: 'center' } );
					const btn = form.querySelector( '[type="submit"]' );
					if ( btn ) setTimeout( () => btn.focus(), 300 );
				}
			} );
		}
	} )();

	// -------------------------------------------------------------------------
	// Thread color swatch selection
	// -------------------------------------------------------------------------

	( function initThreadSwatches() {
		document.querySelectorAll( '.thread-color-swatches' ).forEach( function ( group ) {
			const swatches = group.querySelectorAll( '.thread-swatch' );
			const input    = group.parentElement ? group.parentElement.querySelector( 'input[type="hidden"]' ) : null;

			swatches.forEach( function ( swatch ) {
				swatch.addEventListener( 'click', function () {
					swatches.forEach( s => s.classList.remove( 'is-selected' ) );
					this.classList.add( 'is-selected' );
					if ( input ) input.value = this.dataset.color || this.title || '';
				} );
				swatch.addEventListener( 'keydown', function ( e ) {
					if ( e.key === 'Enter' || e.key === ' ' ) { e.preventDefault(); this.click(); }
				} );
			} );
		} );
	} )();

} )();
