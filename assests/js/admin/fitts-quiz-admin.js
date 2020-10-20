jQuery( document ).ready(
	function($) {

		$( '.fq-fields > tbody' ).sortable();

		$( '.table-field-inner-template' ).slideUp();
		$( '.quiz_submission_body' ).slideUp();
		$( ".answer_type" ).each(
			function( index, value ) {

				if ( 'multiple' == $( value ).val() ) {
					  $( value ).closest( 'tr' ).find( '.fitts-field-text-type' ).hide( 'slow' );
					  $( value ).closest( 'tr' ).find( '.fitts-field-choices' ).show( 'slow' );
					  $( value ).closest( 'tr' ).find( '.fitts-field-answer' ).show( 'slow' );
					  $( value ).closest( 'tr' ).find( '.fitts-field-choice-type' ).show( 'slow' );
				} else {
					$( value ).closest( 'tr' ).find( '.fitts-field-choices' ).hide( 'slow' );
					$( value ).closest( 'tr' ).find( '.fitts-field-answer' ).hide( 'slow' );
					$( value ).closest( 'tr' ).find( '.fitts-field-choice-type' ).hide( 'slow' );
					$( value ).closest( 'tr' ).find( '.fitts-field-text-type' ).show( 'slow' );
				}

			}
		);

		$( '.fq-fields' ).find( '.table-field-inner-template' ).each(
			function( index, value ) {
				var quest = $( value ).find( '#fitts_question' );
				$( '.table-field-inner-template' ).find( '#fitts_parent_field' ).append( '<option value="' + quest.text() + '">' + quest.text() + '</option>' );
			}
		);

		$( ".fitts_is_conditional" ).each(
			function( index, value ) {
				if ( true == $( value ).prop( 'checked' ) ) {
					  $( value ).closest( 'tr' ).find( '.fitts-field-conditional' ).show( 'slow' );
				} else {
					$( value ).closest( 'tr' ).find( '.fitts-field-conditional' ).hide( 'slow' );
				}
			}
		);

		var toggle = false;
		$( document.body ).on(
			'click',
			'.fq-outer-title-icon',
			function() {
				if ( ! toggle ) {
					$( this ).removeClass( 'dashicons-arrow-down' );
					$( this ).addClass( 'dashicons-arrow-up' );
					$( this ).closest( 'tr' ).find( '.table-field-inner-template' ).slideToggle();
					toggle = true;
				} else {
					 $( this ).removeClass( 'dashicons-arrow-up' );
					 $( this ).addClass( 'dashicons-arrow-down' );
					 $( this ).closest( 'tr' ).find( '.table-field-inner-template' ).slideToggle();
					 toggle = false;
				}

			}
		);

		$( '.fq-submission-title-icon' ).on(
			'click',
			function() {

				$( this ).closest( '.quiz_submissions' ).find( '.quiz_submission_body' ).slideToggle();

			}
		);

		$( document.body ).on(
			'change',
			'.answer_type',
			function() {

				if ( 'multiple' == $( this ).val() ) {
					  $( this ).closest( 'tr' ).find( '.fitts-field-text-type' ).hide( 'slow' );
					  $( this ).closest( 'tr' ).find( '.fitts-field-choices' ).show( 'slow' );
					  $( this ).closest( 'tr' ).find( '.fitts-field-answer' ).show( 'slow' );
					  $( this ).closest( 'tr' ).find( '.fitts-field-choice-type' ).show( 'slow' );
				} else {
					 $( this ).closest( 'tr' ).find( '.fitts-field-choices' ).hide( 'slow' );
					 $( this ).closest( 'tr' ).find( '.fitts-field-answer' ).hide( 'slow' );
					 $( this ).closest( 'tr' ).find( '.fitts-field-choice-type' ).hide( 'slow' );
					 $( this ).closest( 'tr' ).find( '.fitts-field-text-type' ).show( 'slow' );
				}

			}
		);

		$( document.body ).on(
			'click',
			'#fitts_is_conditional',
			function() {

				if ( true == $( this ).prop( 'checked' ) ) {
					  $( this ).closest( 'tr' ).find( '.fitts-field-conditional' ).show( 'slow' );
				} else {
					 $( this ).closest( 'tr' ).find( '.fitts-field-conditional' ).hide( 'slow' );
				}

			}
		)

		$( '#add-new-fitts-field' ).on(
			'click',
			function(){

				var old_row = $( ".fq-fields-default-template" ).find( 'tr' );
				var new_row = old_row.clone();

				$( '.fq-fields' ).append( new_row );

			}
		);

		$( document.body ).on(
			'click',
			'.add-multi-choices',
			function() {

				var old_row = $( ".fitts-field-choices-template" ).find( '.inner-fields-multiple-choice' );
				var new_row = old_row.clone();

				var new_id = parseInt( $( this ).closest( '.fitts-field-choices' ).find( '.inner-fields-multiple-choice' ).length ) + 1;

				new_row.find( '.fitts_choices' ).attr( 'id', 'fitts_choice_' + new_id );
				new_row.find( '.fitts_choices' ).attr( 'name', 'fitts_choice[' + new_id + ']' );
				new_row.find( 'select' ).attr( 'id', 'choices_linked_product_' + new_id );
				new_row.find( 'img' ).attr( 'id', 'fitts_files_' + new_id );

				$( this ).closest( '.fitts-field-choices' ).append( new_row );

			}
		);

		$( document.body ).on(
			'click',
			'.remove_choice_field',
			function(){

				$( this ).closest( '.inner-fields-multiple-choice' ).remove();

			}
		);

		$( '#save-fitts-field' ).on(
			'click',
			function(){

				var fitts_quiz      = [];
				var linked_products = [];
				var fitts_post_id   = $( 'input[name="fitts_post_id"]' ).val();
				$( '.fq-fields > tbody > tr' ).each(
					function( index, value ) {
						var options   = [];
						var obj       = {};
						var condition = {};

						obj['title']      = $( value ).find( '#fitts_field_title' ).val();
						obj['question']   = $( value ).find( '#fitts_question' ).val().trim();
						obj['sub_text']   = $( value ).find( '#fitts_sub_text' ).val().trim();
						obj['answerType'] = $( value ).find( 'select[name="answer_type"]' ).val();

						if ( 'multiple' == $( value ).find( 'select[name="answer_type"]' ).val() ) {

								 obj['choiceType'] = $( value ).find( 'select[name="choice_type"]' ).val();

								$( value ).find( '.inner-fields-multiple-choice' ).each(
									function( index, value ) {
										var choice = {};

										choice['label']   = $( value ).find( '#fitts_choice_' + parseInt( index + 1 ) ).val();
										choice['file']    = $( value ).find( '#fitts_files_' + parseInt( index + 1 ) ).attr( 'src' );
										choice['product'] = $( value ).find( '#choices_linked_product_' + parseInt( index + 1 ) ).val();
										options           = [ ... options, choice ];
										linked_products   = [...linked_products, $( value ).find( '#choices_linked_product_' + parseInt( index + 1 ) ).val() ];

									}
								);
								 obj['options'] = options;
						} else {
							obj['fieldType'] = $( value ).find( 'select[name="open_text_type"]' ).val();
						}
						if ( true == $( value ).find( '.fitts_is_conditional' ).prop( 'checked' ) ) {

							condition['parent']       = $( value ).find( '#fitts_parent_field' ).val();
							condition['parentAnswer'] = $( value ).find( '#fitts_parent_field_answer' ).val();
							obj['condition']          = condition;
						}
						obj['linkedProduct'] = $( value ).find( 'select[name="linked_product"]' ).val();
						linked_products      = [...linked_products, $( value ).find( 'select[name="linked_product"]' ).val() ];
						obj['response']      = $( value ).find( 'input[name="fitts_answer_response"]' ).val();

						fitts_quiz = [...fitts_quiz, obj];
					}
				);

				var goodToGo = false;
				$.each(
					linked_products,
					function (indexInArray, valueOfElement) {
						if ( null !== valueOfElement ) {
							   goodToGo = true;
						}
					}
				);

				if ( ! goodToGo ) {
						alert( 'Please select one ore more products for this quiz' );
						return;
				}

				$.ajax(
					{
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
					}
				);
			}
		);

		$( document.body ).on(
			'click',
			'.remove-fitts-field',
			function(){
				$( this ).closest( 'tr' ).remove();
			}
		);

		if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
			$( document.body ).on(
				'click',
				'.set_custom_images',
				function(e) {
					e.preventDefault();
					var button                      = $( this );
					var id                          = button.prev();
					wp.media.editor.send.attachment = function(props, attachment) {
						attachmentURL = wp.media.attachment( attachment.id ).get( "url" );
						if ( '' != attachmentURL ) {
							id.attr( 'src', attachmentURL );
							id.show()
							button.siblings( '.fitts_remove_image' ).show();
							button.hide();
						}
					};
					wp.media.editor.open( button );
					return false;
				}
			);
		}

		$( document.body ).on(
			'click',
			'.fitts_remove_image',
			function(){

				$( this ).siblings( 'img' ).hide();
				$( this ).siblings( 'img' ).attr( 'src', '' );
				$( this ).hide();
				$( this ).siblings( '.set_custom_images' ).show();

			}
		);

		$( document.body ).on(
			'click',
			'.select_all_submission',
			function(){

				if ( true == $( this ).prop( "checked" ) ) {
					$( '.delete_fitts_submission' ).each(
						function( index, value ) {
							$( value ).prop( "checked", true );
						}
					);
				} else {
					$( '.delete_fitts_submission' ).each(
						function( index, value ) {
							$( value ).prop( "checked", false );
						}
					);
				}

			}
		);

		$( document.body ).on(
			'click',
			'.delete_all_submission',
			function() {

				var result = confirm( "Are you sure you want to delete these submissions?" );
				$( '.select_all_submission' ).prop( "checked", false );
				if ( result ) {
					  var submission_ids = [];
					$( '.delete_fitts_submission' ).each(
						function( index, value ) {
							if ( true == $( value ).prop( 'checked' ) ) {
								submission_ids = [...submission_ids, $( value ).attr( 'data-submission-id' ) ];
							}
						}
					);

					$.ajax(
						{
							type: "POST",
							url: fitts_quiz_locale.ajaxurl,
							data: {
								action: 'delete_fitts_submissions',
								'submission_ids': submission_ids,
							},
							success: function (response) {
								  location.reload();
							}
						}
					);
				}

			}
		);

		$( '.table-field-outer-title' ).css( 'cursor','grab' );
		$( document.body ).on(
			'mousedown',
			'.table-field-outer-title',
			function() {
				$( this ).css( 'cursor','grabbing' );
			}
		);
		$( document.body ).on(
			'mouseup',
			'.table-field-outer-title',
			function() {
				$( this ).css( 'cursor','grab' );
			}
		);

		$( '.submission_data_table' ).DataTable(
			{
				"lengthMenu": [[10, 20,50,100, -1], [10, 20,50,100, "All"]],
				"ordering": false,
			}
		);

	}
);
