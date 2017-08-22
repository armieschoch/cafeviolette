jQuery(function($){
	
	$('#test-dropbox').on('click', function(e){
		$('.dropbox-loading-fields').show();
		$('#dropbox-response-message').html('');
		dropbox_token = $('#dropbox_authorazation').val();
		$.post(
			gmerge.ajaxurl,
			{
				data: { 
					'dropbox_token'	: dropbox_token
				},
				action : 'testDropbox'
			}, 
			function( result, textStatus, xhr ) {
				result = JSON.parse(result);
				if( result.result == 'success' ){
					$('#dropbox-response-message').html('<strong style="color:green">'+result.message+'</strong>')
				} else {
					$('#dropbox-response-message').html('<strong style="color:red">'+result.message+'</strong>')
				}
				$('.dropbox-loading-fields').hide();
			}).fail(function() {
				console.log('Something went wrong. Try again later.');
				$('.dropbox-loading-fields').hide();
			});
	});

});