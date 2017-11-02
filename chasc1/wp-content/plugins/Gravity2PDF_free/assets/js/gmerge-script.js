jQuery(function($){

	$('.select-2').select2();

	var new_frame;
	$('#upload-pdf').live('click', function(e){
		// Set all variables to be used in scope
    	
    	inputField = $(this);

	    // If the media new_frame already exists, reopen it.
	    if ( new_frame ) {
	      new_frame.open();
	      return;
	    }
	    
	    // Create a new media new_frame
	    new_frame = wp.media({
	      title: 'Select or Upload Media Of Your Chosen Persuasion',
	      button: {
	        text: 'Use this media'
	      },
	      library: { type : 'application/pdf'},
	      multiple: false  // Set to true to allow multiple files to be selected
	    });

	    
	    // When an image is selected in the media new_frame...
	    new_frame.on( 'select', function() {
	      
	      // Get media attachment details from the new_frame state
	      var attachment = new_frame.state().get('selection').first().toJSON();
	      // console.log(attachment.sizes['thumbnail'].url);

	      // Send the attachment URL to our custom image input field.
	      // inputField.val(attachment.url);
	      // imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );

	      getPdfFields(attachment);
	      // console.log(attachment);

	    });

	    // Finally, open the modal on click
	    new_frame.open();
	});

	function getPdfFields(attachment){
		$('.loading-fields').show();
		$.post(
			gmerge.ajaxurl,
			{ 
			data: { 
				'attachment_id'	: attachment.id, 
			},
			action : 'getPdfFields'
			}, 
			function( result, textStatus, xhr ) {
				result = JSON.parse(result);
				if(result.result == 'success'){
					$('#pdf-file-id').val(attachment.id);
					$('#mapped-fields').val(JSON.stringify(result.fields));
					$('#response-message').html('<strong style="color:green">'+attachment.filename+'</strong>');
					$('select[name=gravity_form]').removeAttr('disabled');
					$('.loading-fields').hide();

					if(!$('select[name=gravity_form]').attr('disabled')){
						$('.add-field').remove();

						pdf_options = generatePdfFieldOptions(JSON.parse($('#mapped-fields').val()));
						$('#pdf-fields-wrap').html(pdf_options);

						cloneField();
					}
					
				} 
				else if(result.result == 'fail') {
					$('#response-message').html('<strong style="color:red">No Fields Found.</strong>');
					$('#mapped-fields').val('');
					$('select[name=gravity_form]').attr('disabled', 'disabled');
					$('.loading-fields').hide();
				}
				// console.log(result);
			}).fail(function() {
			console.log('Something went wrong. Try again later.');
			$('.loading-fields').hide();
		});
	}

	$('select[name=gravity_form]').on('change', function(e){
		id = $(this).val();
		$('#area-loading').show();
		$.post(
			gmerge.ajaxurl,
			{ 
			data: { 
				'form_id'	: id, 
			},
			action : 'getGravityFormFields'
			}, 
			function( result, textStatus, xhr ) {
				result = JSON.parse(result);
				if(result.result == 'success'){
					$('.add-field').remove();

					gform_options = generateGravityFieldOptions(result.fields);
					$('#merge-fields-wrap').html(gform_options);

					pdf_options = generatePdfFieldOptions(JSON.parse($('#mapped-fields').val()));
					$('#pdf-fields-wrap').html(pdf_options);

					cloneField();
					$('.add-column-wrap').show();
					$('#area-loading').hide();
				} 
				else if(result.result == 'fail') {
					$('#area-loading').hide();
				}	
			}
		).fail(function() {
			console.log('Something went wrong. Try again later.');
			$('.loading-fields').hide();
		});
	});

	function generateGravityFieldOptions(data){
		result_data = '';
		result_data += '<select class="merge-fields-select">';
		for (var i = 0; i < data.length; i++) {
			result_data += '<option value="'+data[i].field_id+'">'+data[i].label+'</option>'
		}
		result_data += '</select>';

		return result_data;
	}

	function generatePdfFieldOptions(data){
		result_data = '';
		result_data += '<select class="merge-values-select">';
		for (var i = 0; i < data.length; i++) {
			result_data += '<option value="'+data[i].name+'">'+data[i].label+'</option>'
		}
		result_data += '</select>';

		return result_data;
	}

	$('#add-column').on('click', function(e){
		cloneField();
	});

	function cloneField(){
		new_field = $('#clonable-field').clone();
		new_field.attr( 'id', '' );
		new_field.addClass( 'add-field' );
		new_field.find('.merge-fields-select').attr('name', 'merge_fields[]');
		new_field.find('.merge-values-select').attr('name', 'merge_values[]');
		new_field.append('<a href="javascript:;" class="remove-toggle"><span class="dashicons dashicons-minus"></span></a>');
		$('.added-fields').append(new_field);
		$('.add-field select').select2();
	}

	$('.remove-toggle').live('click', function(e){
		$(this).parent('.add-field').fadeOut('slow', function(){
			$(this).remove();
		});
	});

	$('.integration-remove').live('click', function(e){
		$(this).parent('.integration-wrapper').fadeOut('slow', function(){
			$(this).remove();
		});
	});

	$('#add-integration').on('click', function(e){
		val = $('#delivery-type-select').val();
		$('#area-loading').show();
		action = '';
		data = ''
		if( val == 'email' ){
			action = 'emailIntegrationTemplate';
			data = { 'form_id'	: $('select[name=gravity_form]').val() };
		}
		else if( val == 'dropbox' ){
			action = 'dropboxIntegrationTemplate';
		}
		else if( val == 'direct-download' ){
			action = 'directDownloadIntegrationTemplate';
		}
		else if( val == 'googledrive'){
			action = 'googleDriveIntegrationTemplate';
		}
		else if( val == 'ftp'){
			action = 'ftpDriveIntegrationTemplate';
		}
		else if( val == 'adobesign'){
			action = 'adobeSignIntegrationTemplate';
			data = { 'form_id'	: $('select[name=gravity_form]').val() };
		}
		else if( val == 'onedrive'){
			action = 'onedriveIntegrationTemplate';
		}	

		$.post(
			gmerge.ajaxurl,
			{ 
			data : data,
			action : action
			}, 
			function( result, textStatus, xhr ) {
				count = $('.integration-wrapper').length;
				result = result.replace(/%key%/g, count);
				$('#integrations-container').append(result);	
				$('.select-2').select2();
				$('#area-loading').hide();
			}).fail(function() {
			console.log('Something went wrong. Try again later.');
			$('#area-loading').hide();
		});
	});

	$('.email-other').live('change', function(e){
		if($(this).val() == 'other'){
			$(this).parent().find('.email-other-wrapper').show();
		} else {
			$(this).parent().find('.email-other-wrapper').hide();
		}
	});

	$('.adobe-signer').live('change', function(e){
		if($(this).val() == 'other'){
			$(this).parent().find('.email-other-signer').show();
		} else {
			$(this).parent().find('.email-other-signer').hide();
		}
	});

	$('.adobe-sign-method').live('change', function(e){
		if($(this).val() == 'embedded'){
			$(this).parent().find('.signer-type').html('counter');
			$(this).parent().find('.adobe-embedded-recepient').show();
			$(this).parent().find('.adobe-embedded-recepient .adobe-signer').attr('required','required');
			$(this).parent().find('.adobe-signer-wrap .adobe-signer').removeAttr('required');
		} else {
			$(this).parent().find('.signer-type').html('');
			$(this).parent().find('.adobe-embedded-recepient').hide();
			$(this).parent().find('.adobe-embedded-recepient .adobe-signer').removeAttr('required');
			$(this).parent().find('.adobe-signer-wrap .adobe-signer').attr('required','required');
		}
	});

	$('input[name=pdf_password').on('click', function(e){
		if( $(this).val() == 'yes' ){
			$('#pdf-password-wrapper').slideDown();
		} else {
			$('#pdf-password-wrapper').slideUp();
		}
	});

	$('.signers-add').live('click', function(e){
		new_field = $(this).parent().parent().clone();
		new_field.find('.select2-container').remove();
		new_field.find('.email-other-signer').hide();
		new_field.find('input').val('');
		new_field.find('.adobe-signer').val('');
		new_field.insertAfter($(this).parent().parent());
		$('.select-2').select2();
	});

	$('.signers-remove').live('click', function(e){
		new_field = $(this).parent().parent().remove();
	})

});