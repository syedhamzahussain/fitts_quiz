jQuery( document ).ready(
	function ($) {

		var prev_answer_text = [];

		var curent_quest = $( '.fitts-prev-quest' ).attr( 'data-curent-quest' );
		if ( 0 == parseInt( curent_quest ) ) {
			$( '.fitts-prev-quest' ).hide();
		}
		if ( parseInt( curent_quest ) == $( '.fitts-quest' ).length - 1 ) {
			$( '.fitts-next-quest' ).hide();
		}

		$( '.fitts-prev-quest' ).on(
			'click',
			function () {

				var curent_quest = $( this ).attr( 'data-curent-quest' );
				var complete     = 0;

				$( this ).closest( '.fitts-quiz-form' ).find( '.fitts-question-' + curent_quest ).hide();
				// if( 0 !==  parseInt( $( '#fitts_isconditional-'+ ( parseInt( curent_quest )-1 ) ).val() ) ) {
				// curent_quest = parseInt(curent_quest)-1;
				// }
				$( this ).closest( '.fitts-quiz-form' ).find( '.fitts-question-' + ( parseInt( curent_quest ) - 1 ) ).show();
				$( this ).attr( 'data-curent-quest', ( parseInt( curent_quest ) - 1 ) );
				$( '.fitts-next-quest' ).attr( 'data-curent-quest', ( parseInt( curent_quest ) - 1 ) );

				if ( 0 == ( parseInt( curent_quest ) - 1 ) ) {
					$( this ).hide();
				} else {
					$( this ).show();
				}
				$( '.fitts-question-footer' ).hide();
				$( '.fitts-next-quest' ).show();

				complete = ( ( parseInt( curent_quest ) - 1 ) / ( $( '.fitts-quest' ).length - 1) ) * 100;
				$( '.fitts-progress-bar' ).css( {"width": parseInt( complete ) + "%"} );
				$( '.fitts-progress-percentage-text' ).text( parseInt( complete ) + '%' );

				prev_answer_text = [];

			}
		);

		$( '.fitts-next-quest' ).on(
			'click',
			function () {

				var curent_quest = $( this ).attr( 'data-curent-quest' );
				var complete     = 0;
				var prev_quest   = $( this ).closest( '.fitts-quiz-form' ).find( '.fitts-question-' + curent_quest );

				curent_quest = next_quest_to_show( curent_quest, prev_answer_text );
				if ( curent_quest == $( '.fitts-quest' ).length - 1 ) {
					$( this ).hide();
					$( '.fitts-question-footer' ).show();
					$( '.fitts-prev-quest' ).show();

					complete = ( ( parseInt( curent_quest ) ) / ( $( '.fitts-quest' ).length - 1) ) * 100;
					$( '.fitts-progress-bar' ).css( {"width": parseInt( complete ) + "%"} );
					$( '.fitts-progress-percentage-text' ).text( parseInt( complete ) + '%' );

					return;
				}

				prev_quest.hide();
				if ( 0 !== parseInt( $( '#fitts_isresponse-' + ( parseInt( curent_quest ) ) ).val() ) ) {
					$( '.fitts-question-navigator' ).hide();

					var response_answer = prev_quest.find( '.open-text-field' ).val();
					$( '.fitts_response_text' ).text( $( '#fitts_isresponse-' + ( parseInt( curent_quest ) ) ).val().replace( "{answer}", response_answer ) );
					$( '.fitts_response' ).fadeIn( 2000 );
					$( '.fitts_response' ).fadeOut( 1000 );
					setTimeout(
						() => {
                        $( this ).closest( '.fitts-quiz-form' ).find( '.fitts-question-' + ( parseInt( curent_quest ) + 1 ) ).show();
                        $( '.fitts-question-navigator' ).show();
                        if ( ( parseInt( curent_quest ) + 1 ) == $( '.fitts-quest' ).length - 1 ) {
                            $( this ).hide();
                            $( '.fitts-question-footer' ).show();
                        } else {
								$( this ).show();
                        }
						},
						3000
					);
				} else {
					$( this ).closest( '.fitts-quiz-form' ).find( '.fitts-question-' + ( parseInt( curent_quest ) + 1 ) ).show();
					if ( ( parseInt( curent_quest ) + 1 ) == $( '.fitts-quest' ).length - 1 ) {
						$( this ).hide();
						$( '.fitts-question-footer' ).show();
					} else {
						$( this ).show();
					}
				}
				$( this ).attr( 'data-curent-quest', ( parseInt( curent_quest ) + 1 ) );
				$( '.fitts-prev-quest' ).attr( 'data-curent-quest', ( parseInt( curent_quest ) + 1 ) );

				$( '.fitts-prev-quest' ).show();

				complete = ( ( parseInt( curent_quest ) + 1 ) / ( $( '.fitts-quest' ).length - 1) ) * 100;
				$( '.fitts-progress-bar' ).css( {"width": parseInt( complete ) + "%"} );
				$( '.fitts-progress-percentage-text' ).text( parseInt( complete ) + '%' );

			}
		);

		$( '.glyphicon-repeat' ).on(
			'click',
			function() {
				location.reload();
			}
		);

		$( '.fitts-back' ).on(
			'click',
			function() {
				location.reload();
			}
		);

		$( '.fitts_submit_quiz' ).on(
			'click',
			function() {
				var quiz_submissions = [];
				var linked_products  = [];
				var fitts_quiz_id    = $( '.fitts_quiz_id' ).val();
				var customer_email   = '';

				if ( true == $( '.gdrp_term_condition' ).prop( "required" ) && false == $( '.gdrp_term_condition' ).prop( "checked" ) ) {
					$( '.gdrp_term_condition' ).addClass( 'f-error' );
					$( '.gdrp_term_condition_error' ).text( "You need to accpet the terms and conditions!" );
					return;
				}

				$( this ).attr( "disabled",true );

				$( '.fitts-quiz-ques-inner' ).each(
					function( index, value ) {
						var object = {};

						if ( null !== $( value ).find( '.fitts-quiz-question-text' ).text() ) {
							  object['question'] = $( value ).find( '.fitts-quiz-question-text' ).text();
						}
						if ( 'singleAns' == $( value ).find( '.fitts_choice_type' ).val() ) {
							$( value ).find( 'input[type="radio"]' ).each(
								function( key, choice ) {
									if ( true == $( choice ).prop( 'checked' ) ) {
											object['answer'] = $( choice ).closest( '.fitts-quiz-choices' ).find( '.fitts-quiz-choices-text' ).text();
											linked_products  = [...linked_products, $( choice ).siblings( '.fitts_linked_product' ).val() ];
									}
								}
							);
						} else if ( 'multiAns' == $( value ).find( '.fitts_choice_type' ).val() ) {
							var multiChoices = [];
							$( value ).find( 'input[type="checkbox"]' ).each(
								function( key, choice ) {
									if ( true == $( choice ).prop( 'checked' ) ) {
										  multiChoices    = [ ...multiChoices, $( choice ).closest( '.fitts-quiz-choices' ).find( '.fitts-quiz-choices-text' ).text() ];
										  linked_products = [...linked_products, $( choice ).siblings( '.fitts_linked_product' ).val() ];
									}
								}
							);
							object['answer'] = multiChoices;
						}
						if ( '' !== $.trim( $( value ).find( 'input[type="email"]' ).val() ) ) {
							object['answer'] = $( value ).find( 'input[type="email"]' ).val();
							object['type']   = 'email';
							customer_email   = $( value ).find( 'input[type="email"]' ).val();
						} else if ( '' !== $.trim( $( value ).find( 'input[type="text"]' ).val() ) ) {
							object['answer'] = $( value ).find( 'input[type="text"]' ).val();
							object['type']   = 'text';
						} else if ( '' !== $.trim( $( value ).find( 'input[type="number"]' ).val() ) ) {
							object['answer'] = $( value ).find( 'input[type="number"]' ).val();
							object['type']   = 'number';
						}
						quiz_submissions = [...quiz_submissions, object ];

					}
				);

				$.ajax(
					{
						type: "POST",
						url: fitts_quiz_front.ajaxurl,
						data: {
							action: 'save_submissions',
							'quiz_submissions': quiz_submissions,
							'parent_id' : fitts_quiz_id,
							'linked_products' : linked_products,
							'customer_email' : customer_email,
						},
						success: function (response) {

							if (  "success" == JSON.parse( response ).status ) {
								window.location.href = JSON.parse( response ).url;
							}

						}
					}
				);
			}
		)

	}
);

function next_quest_to_show( curent_quest, prev_answer_text ) {
	$( '.fitts-question-' + parseInt( curent_quest ) ).find( '.fitts_front_choice' ).each(
		function( key, element ) {
			if ( true == $( element ).prop( 'checked' ) ) {
				  prev_answer_text.push( $( element ).closest( '.fitts-quiz-choices' ).find( '.fitts-quiz-choices-text' ).text().trim() );
			}
		}
	)
	if ( 0 !== parseInt( $( '#fitts_isconditional-' + ( parseInt( curent_quest ) + 1 ) ).val() ) ) {

		var conditional = $( '#fitts_isconditional-' + ( parseInt( curent_quest ) + 1 ) ).val();
		if ( 'undefined' !== typeof conditional ) {
			var cond_quest      = conditional.split( ',' )[0];
			var cond_answer     = conditional.split( ',' )[1];
			var prev_quest_text = $( '.fitts-question-' + parseInt( curent_quest ) + 1 ).find( '.fitts-quiz-question-text' ).text().trim();

			if ( ( -1 == parseInt( $.inArray( cond_answer.trim(), prev_answer_text ) ) )  ) {
				curent_quest = parseInt( curent_quest ) + 1;
				curent_quest = next_quest_to_show( curent_quest, prev_answer_text );
			}
		}
	}
	return curent_quest;
}
