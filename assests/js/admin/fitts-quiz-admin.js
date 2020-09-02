jQuery( document ).ready( function($) {

	$( '.fq-fields > tbody' ).sortable();

	$( '.table-field-inner-template' ).slideUp();
	$( '.quiz_submission_body' ).slideUp();
	$( ".answer_type" ).each( function( index, value ) {

		if( 'multiple' == $(value).val() ) {
            $(value).closest( 'tr' ).find( '.fitts-field-text-type' ).hide('slow');
            $(value).closest( 'tr' ).find( '.fitts-field-choices' ).show('slow');
            $(value).closest( 'tr' ).find( '.fitts-field-answer' ).show('slow');
        }
        else {
            $(value).closest( 'tr' ).find( '.fitts-field-choices' ).hide('slow');
            $(value).closest( 'tr' ).find( '.fitts-field-answer' ).hide('slow');
            $(value).closest( 'tr' ).find( '.fitts-field-text-type' ).show('slow');
        }

	});

	$( ".fitts_is_conditional" ).each( function( index, value ) {
		if( true == $(value).prop( 'checked' ) ) {
			$(value).closest( 'tr' ).find( '.fitts-field-conditional' ).show('slow');
		}
		else{
			$(value).closest( 'tr' ).find( '.fitts-field-conditional' ).hide('slow');
		}
	});
	var toggle = false;
	$( document.body ).on( 'click', '.fq-outer-title-icon', function() {
	   if( !toggle ) {
		$(this).removeClass('dashicons-arrow-down');
		$(this).addClass('dashicons-arrow-up');
	   	$(this).closest( 'tr' ).find( '.table-field-inner-template' ).slideToggle();	   
		toggle = true;
	   }
		else{
			$(this).removeClass('dashicons-arrow-up');
			$(this).addClass('dashicons-arrow-down');
			$(this).closest( 'tr' ).find( '.table-field-inner-template' ).slideToggle();
			toggle = false;
		}
		
		
	});

	$( '.fq-submission-title-icon' ).on( 'click', function() {
	   
		$(this).closest( '.quiz_submissions' ).find( '.quiz_submission_body' ).slideToggle();
		
	});

	$( document.body ).on( 'change', '.answer_type', function() {

		if( 'multiple' == $(this).val() ) {
			$(this).closest( 'tr' ).find( '.fitts-field-text-type' ).hide('slow');
			$(this).closest( 'tr' ).find( '.fitts-field-choices' ).show('slow');
			$(this).closest( 'tr' ).find( '.fitts-field-answer' ).show('slow');
		}
		else {
			$(this).closest( 'tr' ).find( '.fitts-field-choices' ).hide('slow');
			$(this).closest( 'tr' ).find( '.fitts-field-answer' ).hide('slow');
			$(this).closest( 'tr' ).find( '.fitts-field-text-type' ).show('slow');
		}

	});

	$( document.body ).on( 'click', '#fitts_is_conditional', function() {
		
		if( true == $(this).prop( 'checked' ) ) {
			$(this).closest( 'tr' ).find( '.fitts-field-conditional' ).show('slow');
		}
		else{
			$(this).closest( 'tr' ).find( '.fitts-field-conditional' ).hide('slow');
		}

	}) 
	

	$( '#add-new-fitts-field' ).on('click', function(){

		var old_row = $( ".fq-fields-default-template" ).find( 'tr' );
		var new_row = old_row.clone();

		$( '.fq-fields' ).append( new_row );

	});

	$( '#save-fitts-field' ).on('click', function(){

		var fitts_quiz = [];
		var options = [];
		var fitts_post_id = $( 'input[name="fitts_post_id"]' ).val();
		$( '.fq-fields > tbody > tr' ).each( function( index, value ) {
			var obj = {};
			var condition = {};

			obj['title'] = $( value ).find( '#fitts_field_title' ).val();
			obj['question'] = $( value ).find( '#fitts_question' ).val().trim();
			obj['answerType'] = $( value ).find( 'select[name="answer_type"]' ).val();

			if( 'multiple' == $( value ).find( 'select[name="answer_type"]' ).val() ) {
				$( value ).find( '.inner-fields-multiple-choice' ).each( function( index, value ) {
					var choice = {};

					choice['label'] = $( value ).find( '#fitts_choice_' + parseInt(index+1) ).val();
					choice['file'] = $( value ).find( '#fitts_files_' + parseInt(index+1) ).attr('src');
					choice['product'] = $( value ).find( '#choices_linked_product_' + parseInt(index+1) ).val();
					options = [ ... options, choice ];
					
				});
				obj['options'] = options;
				obj['correctAnswer'] = $( value ).find( 'input[name="correct_answer"]' ).val();
			}
			else {
				obj['fieldType'] = $( value ).find( 'select[name="open_text_type"]' ).val();
			}			
			if( true == $( value ).find('.fitts_is_conditional').prop( 'checked' ) ) {
					
				condition['parent']        =  $( value ).find('#fitts_parent_field').val();
				condition['parentAnswer']  =  $( value ).find('#fitts_parent_field_answer').val();
				obj['condition'] = condition;
			}
			obj['linkedProduct'] = $( value ).find( 'select[name="linked_product"]' ).val();

			fitts_quiz = [...fitts_quiz, obj];
		});
		$.ajax({
			type: "POST",
			url: fitts_quiz_locale.ajaxurl,
			data: {
				action: 'save_fitts_quiz_question',
				'fitts_quiz': fitts_quiz, 
				'fitts_post_id': fitts_post_id, 

			},
			success: function (response) {
				location.reload();
			}
		});
	});


	$( document.body ).on('click', '.remove-fitts-field', function(){
		$(this).closest( 'tr' ).remove();
	});


	if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
		$( document.body ).on('click', '.set_custom_images', function(e) {
			e.preventDefault();
			var button = $(this);
			var id = button.prev();
			wp.media.editor.send.attachment = function(props, attachment) {
				attachmentURL = wp.media.attachment(attachment.id).get("url");
				if( '' != attachmentURL ) {
					id.attr( 'src', attachmentURL );
					id.show()
					button.siblings( '.fitts_remove_image' ).show();
					button.hide();
				}
			};
			wp.media.editor.open(button);
			return false;
		});
	}

	$( document.body ).on( 'click', '.fitts_remove_image', function(){

		$(this).siblings('img').hide();
		$(this).siblings('img').attr( 'src', '' );
		$(this).hide();
		$(this).siblings('.set_custom_images').show();

	});

	$( '.table-field-outer-title' ).css( 'cursor','grab' );
	$( document.body ).on( 'mousedown', '.table-field-outer-title', function() {
		$(this).css( 'cursor','grabbing' );
	});
	$( document.body ).on( 'mouseup', '.table-field-outer-title', function() {
		$(this).css( 'cursor','grab' );
	});

});