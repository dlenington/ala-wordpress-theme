( function( $ ) {

	$( document ).ready(function( $ ) {

		// Search in Header.
		if( $('.search-toggle').length > 0 ) {
			$('.search-toggle').click(function(e){
				e.preventDefault();
				$(this).parent().toggleClass( 'toggled-on' );
			});

			$( window )
				.on( 'load.educationsoul resize.educationsoul', function() {
				if ( window.innerWidth > 767 ) {
					$('#primary-search-form').on('focusout', function () {
						var $elem = $(this);

					    // let the browser set focus on the newly clicked elem before check
					    setTimeout(function () {
					        if ( ! $elem.find(':focus').length ) {
					        	$( '.primary-search-wrapper .search-toggle' ).trigger('click');
					        }
					    }, 0);
					});
				}
			} );
		}

		// Implement go to top.
		var $scroll_obj = $( '#btn-scrollup' );
		if ( $scroll_obj.length > 0 ) {
			$( window ).scroll( function() {
				if ( $( this ).scrollTop() > 100 ) {
					$scroll_obj.fadeIn();
				} else {
				$scroll_obj.fadeOut();
				}
			});

			$scroll_obj.click( function() {
				$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
				
				return false;
			});
		}
	});

} )( jQuery );
