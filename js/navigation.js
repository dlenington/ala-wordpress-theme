/**
 * navigation.js
 */
( function( $ ) {

	$(document).ready(function($){
		/* Menu */
		var body, masthead, menuToggle, siteNavigation, socialNavigation, siteHeaderMenu, resizeTimer;

		function initMainNavigation( container ) {

			// Add dropdown toggle that displays child menu items.
			var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false })
				.append( $( '<span />', { 'class': 'screen-reader-text', text: EducationHubScreenReaderText.expand.expand }) );

			container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

			// Toggle buttons and submenu items with active children menu items.
			container.find( '.current-menu-ancestor > button' ).addClass( 'toggled-on' );
			container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

			// Add menu items with submenus to aria-haspopup="true".
			container.find( '.menu-item-has-children, .page_item_has_children' ).attr( 'aria-haspopup', 'true' );

			container.find( '.dropdown-toggle' ).click( function( e ) {
				var _this            = $( this ),
					screenReaderSpan = _this.find( '.screen-reader-text' );

				e.preventDefault();
				_this.toggleClass( 'toggled-on' );

				// jscs:disable
				_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
				// jscs:enable
				screenReaderSpan.text( screenReaderSpan.text() === EducationHubScreenReaderText.expand.expand ? EducationHubScreenReaderText.expand.collapse : EducationHubScreenReaderText.expand.expand );
			} );
		}

		initMainNavigation( $( '.main-navigation' ) );

		masthead         = $( '#main-nav' );
		menuToggle       = masthead.find( '.menu-toggle' );
		siteNavigation   = masthead.find( '#site-navigation' );
		quickLinks   = $( '.quick-links' );

		// Enable menuToggle.
		( function() {

			// Assume the initial scroll position is 0.
			var scroll = 0;

			// Return early if menuToggle is missing.
			if ( ! menuToggle.length ) {
				return;
			}

			menuToggle.on( 'click.educationHub', function() {
				// jscs:disable
				$( this ).add( siteNavigation ).attr( 'aria-expanded', $( this ).add( siteNavigation ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
				// jscs:enable
			} );


			// Add an initial values for the attribute.
			menuToggle.add( siteNavigation ).attr( 'aria-expanded', 'false' );

			// Wait for a click on one of our menu toggles.
			menuToggle.on( 'click.educationHub', function() {

				// Assign this (the button that was clicked) to a variable.
				var button = this;

				// Gets the actual menu (parent of the button that was clicked).
				var menu = $( this ).parents( '.wrap-menu-content' );

				// Remove selected classes from other menus.
				$( '.menu-toggle' ).not( button ).removeClass( 'selected' );
				$( '.wrap-menu-content' ).not( menu ).removeClass( 'is-open' );

				// Toggle the selected classes for this menu.
				$( button ).toggleClass( 'selected' );
				$( menu ).toggleClass( 'is-open' );

				// Is the menu in an open state?
				var is_open = $( menu ).hasClass( 'is-open' );

				// If the menu is open and there wasn't a menu already open when clicking.
				if ( is_open && ! jQuery( 'body' ).hasClass( 'menu-open' ) ) {

					// Get the scroll position if we don't have one.
					if ( 0 === scroll ) {
						scroll = $( 'body' ).scrollTop();
					}

					// Add a custom body class.
					$( 'body' ).addClass( 'menu-open' );

				// If we're closing the menu.
				} else if ( ! is_open ) {

					$( 'body' ).removeClass( 'menu-open' );
					$( 'body' ).scrollTop( scroll );
					scroll = 0;
				}

				$( ".wrap-menu-content" ).toggle( 'slow' );
				$( "#site-navigation" ).toggleClass( 'toggled-on' );
			} );

			// Close menus when somewhere else in the document is clicked.
			$( document ).on( 'click touchstart', function() {
				$( 'body' ).removeClass( 'menu-open' );
				$( '.menu-toggle' ).removeClass( 'selected' );
				$( '.wrap-menu-content' ).removeClass( 'is-open' );
			} );

			// Stop propagation if clicking inside of our main menu.
			$( '.site-header-menu,.menu-toggle, .dropdown-toggle, .search-field, #site-navigation, #social-search-wrapper, #social-navigation .search-submit' ).on( 'click touchstart', function( e ) {
				e.stopPropagation();
			} );
		} )();

		// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
		( function() {
			if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
				return;
			}

			// Toggle `focus` class to allow submenu access on tablets.
			function toggleFocusClassTouchScreen() {
				if ( window.innerWidth >= 910 ) {
					$( document.body ).on( 'touchstart.educationHub', function( e ) {
						if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
							$( '.main-navigation li' ).removeClass( 'focus' );
						}
					} );
					siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).on( 'touchstart.educationHub', function( e ) {
						var el = $( this ).parent( 'li' );

						if ( ! el.hasClass( 'focus' ) ) {
							e.preventDefault();
							el.toggleClass( 'focus' );
							el.siblings( '.focus' ).removeClass( 'focus' );
						}
					} );
				} else {
					siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.educationHub' );
				}
			}

			if ( 'ontouchstart' in window ) {
				$( window ).on( 'resize.educationHub', toggleFocusClassTouchScreen );
				toggleFocusClassTouchScreen();
			}

			siteNavigation.find( 'a' ).on( 'focus.educationHub blur.educationHub', function() {
				$( this ).parents( '.menu-item' ).toggleClass( 'focus' );
			} );

			$('.main-navigation button.dropdown-toggle').click(function() {
				$(this).toggleClass('active');
				$(this).parent().find('.children, .sub-menu').first().toggleClass('toggled-on');
			});
		} )();

		( function() {
			if ( ! quickLinks.length || ! quickLinks.children().length ) {
				return;
			}

			quickLinks.find( 'a' ).on( 'focus.educationHub blur.educationHub', function() {
				quickLinks.toggleClass( 'focus' );
			} );
		} )();


		$( document ).ready( function() {
			body = $( document.body );

			$( window )
				.on( 'load.educationsoul resize.educationsoul', function() {
				if ( window.innerWidth < 768 ) {
					$('#site-navigation .wrap-menu-content').on('focusout', function () {
						var $elem = $(this);

					    // let the browser set focus on the newly clicked elem before check
					    setTimeout(function () {
					        if ( ! $elem.find(':focus').length ) {
					            $( '#site-navigation .menu-toggle' ).trigger('click');
					        }
					    }, 0);
					});
				}
			} );
		});
	});
} )( jQuery );
