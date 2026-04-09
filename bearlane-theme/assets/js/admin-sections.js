/*
 * BearLane Design — Homepage Sections Admin UI
 *
 * Drives Appearance → Homepage Sections. Handles:
 *   - Expand / collapse section rows
 *   - Drag-drop reordering (sections + repeater rows)
 *   - Media uploader integration for image fields
 *   - Repeater add / remove with unique index rewriting
 *   - SVG live preview
 *
 * Dependencies: jQuery, jQuery UI Sortable, wp.media.
 */

( function ( $ ) {
	'use strict';

	$( function () {

		var $list = $( '#bearlane-sections-list' );
		if ( ! $list.length ) {
			return;
		}

		/* -----------------------------------------------------
		 * Expand / collapse section rows
		 * --------------------------------------------------- */
		$list.on( 'click', '.bearlane-section-row__expand', function () {
			var $btn  = $( this );
			var $row  = $btn.closest( '.bearlane-section-row' );
			var $body = $row.find( '> .bearlane-section-row__body' );
			var open  = $btn.attr( 'aria-expanded' ) === 'true';
			$btn.attr( 'aria-expanded', open ? 'false' : 'true' );
			if ( open ) {
				$body.prop( 'hidden', true );
			} else {
				$body.prop( 'hidden', false );
			}
		} );

		/* -----------------------------------------------------
		 * Disabled state visual
		 * --------------------------------------------------- */
		function syncEnabledState( $row ) {
			var checked = $row.find( '> header .bearlane-section-row__toggle input[type="checkbox"]' ).prop( 'checked' );
			$row.toggleClass( 'is-disabled', ! checked );
		}
		$list.find( '.bearlane-section-row' ).each( function () {
			syncEnabledState( $( this ) );
		} );
		$list.on( 'change', '.bearlane-section-row__toggle input[type="checkbox"]', function () {
			syncEnabledState( $( this ).closest( '.bearlane-section-row' ) );
		} );

		/* -----------------------------------------------------
		 * Sortable sections
		 * --------------------------------------------------- */
		$list.sortable( {
			handle: '> .bearlane-section-row__header > .bearlane-section-row__handle',
			axis: 'y',
			placeholder: 'ui-sortable-placeholder',
			forcePlaceholderSize: true,
			tolerance: 'pointer',
			start: function ( e, ui ) { ui.item.addClass( 'is-dragging' ); },
			stop:  function ( e, ui ) { ui.item.removeClass( 'is-dragging' ); }
		} );

		/* -----------------------------------------------------
		 * Image field — wp.media picker
		 * --------------------------------------------------- */
		$( document ).on( 'click', '.bearlane-image-field__choose', function ( e ) {
			e.preventDefault();
			var $wrap   = $( this ).closest( '.bearlane-image-field' );
			var $input  = $wrap.find( '.bearlane-image-field__id' );
			var $preview= $wrap.find( '.bearlane-image-field__preview' );
			var $remove = $wrap.find( '.bearlane-image-field__remove' );

			var frame = wp.media( {
				title: bearlaneSectionsAdmin.i18n.chooseImage,
				button: { text: bearlaneSectionsAdmin.i18n.useImage },
				library: { type: 'image' },
				multiple: false
			} );

			frame.on( 'select', function () {
				var att = frame.state().get( 'selection' ).first().toJSON();
				$input.val( att.id );
				var url = ( att.sizes && att.sizes.medium ) ? att.sizes.medium.url : att.url;
				$preview.html( '<img src="' + url + '" alt="">' );
				$remove.prop( 'hidden', false );
			} );

			frame.open();
		} );

		$( document ).on( 'click', '.bearlane-image-field__remove', function ( e ) {
			e.preventDefault();
			var $wrap = $( this ).closest( '.bearlane-image-field' );
			$wrap.find( '.bearlane-image-field__id' ).val( '' );
			$wrap.find( '.bearlane-image-field__preview' ).empty();
			$( this ).prop( 'hidden', true );
		} );

		/* -----------------------------------------------------
		 * Repeaters — add / remove / sortable / reindex
		 * --------------------------------------------------- */
		function nextIndex( $repeater ) {
			var max = -1;
			$repeater.find( '> .bearlane-repeater__rows > .bearlane-repeater__row' ).each( function () {
				var idx = parseInt( $( this ).attr( 'data-index' ), 10 );
				if ( ! isNaN( idx ) && idx > max ) {
					max = idx;
				}
			} );
			return max + 1;
		}

		function reindexRows( $repeater ) {
			$repeater.find( '> .bearlane-repeater__rows > .bearlane-repeater__row' ).each( function ( i ) {
				$( this ).attr( 'data-index', i );
				$( this ).find( '> .bearlane-repeater__row-header .bearlane-repeater__row-num' ).text( i + 1 );
			} );
		}

		/**
		 * Initialise all top-level repeaters as sortable.
		 * Nested repeaters are initialised on demand via initRepeater().
		 */
		function initRepeater( $repeater ) {
			if ( $repeater.data( 'bearlaneInit' ) ) {
				return;
			}
			$repeater.data( 'bearlaneInit', true );
			$repeater.find( '> .bearlane-repeater__rows' ).sortable( {
				handle: '> .bearlane-repeater__row > .bearlane-repeater__row-header > .bearlane-repeater__row-handle',
				axis: 'y',
				tolerance: 'pointer',
				placeholder: 'ui-sortable-placeholder',
				forcePlaceholderSize: true,
				start: function ( e, ui ) { ui.item.addClass( 'is-dragging' ); },
				stop:  function ( e, ui ) {
					ui.item.removeClass( 'is-dragging' );
					reindexRows( $repeater );
				}
			} );
		}
		$( '.bearlane-repeater' ).each( function () {
			initRepeater( $( this ) );
		} );

		// Add row.
		$( document ).on( 'click', '.bearlane-repeater__add', function ( e ) {
			e.preventDefault();
			var $repeater = $( this ).closest( '.bearlane-repeater' );
			var $template = $repeater.find( '> .bearlane-repeater__template' );
			if ( ! $template.length ) {
				return;
			}
			var html = $template.html();
			var idx  = nextIndex( $repeater );
			// Replace the __INDEX__ placeholder with a real index.
			// Use a global regex so every occurrence (name attrs) is updated.
			html = html.replace( /__INDEX__/g, idx );

			var $row = $( html );
			$row.attr( 'data-index', idx );
			$repeater.find( '> .bearlane-repeater__rows' ).append( $row );

			// Initialise nested repeaters inside the new row.
			$row.find( '.bearlane-repeater' ).each( function () {
				initRepeater( $( this ) );
			} );

			reindexRows( $repeater );
		} );

		// Remove row.
		$( document ).on( 'click', '.bearlane-repeater__row-remove', function ( e ) {
			e.preventDefault();
			if ( ! window.confirm( bearlaneSectionsAdmin.i18n.confirmDelete ) ) {
				return;
			}
			var $row      = $( this ).closest( '.bearlane-repeater__row' );
			var $repeater = $( this ).closest( '.bearlane-repeater' );
			$row.remove();
			reindexRows( $repeater );
		} );

		/* -----------------------------------------------------
		 * SVG live preview
		 * --------------------------------------------------- */
		$( document ).on( 'input', '.bearlane-field__svg', function () {
			var $preview = $( this ).siblings( '.bearlane-field__svg-preview' );
			// Basic XSS protection: only render if it looks like <svg ...>.
			var value = $( this ).val() || '';
			if ( /^<svg[\s>]/.test( value ) ) {
				$preview.html( value );
			}
		} );

	} );

} )( jQuery );
