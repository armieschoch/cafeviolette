(function( $ ) {
	$(document).ready(function() {
		$( document ).on( 'change', '#itsec-ssl-admin', function( e ) {
			if ( this.checked && ! confirm( itsec_ssl.translations.ssl_warning ) ) {
				$(this).attr( 'checked', false );
			}
		} );
	});
})( jQuery );
