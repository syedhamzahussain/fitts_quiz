<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div class="fitts-quiz-form fitts-quiz-form-<?php echo wp_kses_post( $atts['id'] ); ?>">
	<input type="hidden" name="fitts_quiz_id" class="fitts_quiz_id" value="<?php echo wp_kses_post( $atts['id'] ); ?>">
	<div class="fitts-progress-bar-percentage">
		<?php echo 'Quiz '; ?><span class="fitts-progress-percentage-text">0%</span><?php echo ' Complete'; ?>
		<span class="glyphicon glyphicon-repeat"></span>
	</div>
	<div class="progress">
		<div class="progress-bar fitts-progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" ></div>
	</div> 
	<?php foreach ( $filter_quiz_questions as $key => $value ) { ?>	
		<div class="<?php echo ( 'multiple' == $value['answerType'] ) ? 'fitts-quiz-questions' : 'fitts-open-text'; ?> fitts-quest fitts-question-<?php echo wp_kses_post( $key ); ?>" style="<?php echo ( $key != 0 ) ? 'display:none;' : ''; ?>">
			<div class="fitts-quiz-ques-inner" >
				<div class="fitts-quiz-question">
					<p class="fitts-quiz-question-text"><?php echo wp_kses_post( $value['question'] ); ?></p>
				</div>
				<div class="fitts-quiz-lower">
					<?php if ( 'multiple' == $value['answerType'] ) { ?>
						<?php
						foreach ( $value['options'] as $index => $choice ) {
							if ( empty( $choice['label'] ) && empty( $choice['file'] ) ) {
								continue;
							}
							?>
							<div class="fitts-quiz-choices choice-<?php echo wp_kses_post( $index ); ?>" style="<?php echo ( ( $index % 2 ) != 0 ) ? 'float:right;' : ''; ?>background-image:url('<?php echo $choice['file']; ?>')" >
								<div class="<?php echo ( empty( $choice['file'] ) ) ? 'fitts-no-img-choice' : 'fitts-quiz-choices-upper'; ?>">
									<p class="fitts-quiz-choices-text"><?php echo wp_kses_post( $choice['label'] ); ?></p>
								</div>
								<div class="fitts-quiz-choices-lower fitts-quiz-choices-radio">
									<?php if ( isset( $value['choiceType'] ) && 'singleAns' == $value['choiceType'] ) { ?>	
										<input class="fitts_front_choice" type="radio" name="fitts_choice_<?php echo wp_kses_post( $key ); ?>" id="fitts-choice<?php echo wp_kses_post( $index ); ?>" >
									<?php } else { ?>	
										<input class="fitts_front_choice" type="checkbox" name="fitts_choice_<?php echo wp_kses_post( $key ); ?>" id="fitts-choice<?php echo wp_kses_post( $index ); ?>" >
									<?php } ?>	
									<input type="hidden" class="fitts_linked_product" id="fitts_linked_product-<?php echo wp_kses_post( $index ); ?>" value="<?php echo ( isset( $choice['product'] ) && ! empty( $choice['product'] ) ) ? implode( ',', $choice['product'] ) : ''; ?>">
									<input type="hidden" class="fitts_choice_type" id="fitts_choice_type-<?php echo wp_kses_post( $index ); ?>" value="<?php echo ( isset( $value['choiceType'] ) ) ? $value['choiceType'] : ''; ?>">
									<span class="<?php echo ( isset( $value['choiceType'] ) && 'singleAns' == $value['choiceType'] ) ? 'radiomark' : 'checkmark'; ?>"></span>
								</div>
							</div>
							<img src="" alt="">
						<?php } ?>
					<?php } else { ?>
						<div class="fitts-quiz-open-text">
							<p>
								<input type="<?php echo ( $value['fieldType'] ) ? $value['fieldType'] : 'text'; ?>" id="open-field-<?php echo isset( $value['fieldType'] ) ? $value['fieldType'] : 'text'; ?>" class="open-text-field">
							</p>
						</div>
					<?php } ?>
				</div>
			</div>
			<input type="hidden" class="fitts_isconditional" id="fitts_isconditional-<?php echo wp_kses_post( $key ); ?>" value="<?php echo isset( $value['condition'] ) ? implode( ',', $value['condition'] ) : 0; ?>">
			<input type="hidden" class="fitts_isresponse" id="fitts_isresponse-<?php echo wp_kses_post( $key ); ?>" value="<?php echo ( isset( $value['response'] ) && ! empty( $value['response'] ) ) ? $value['response'] : 0; ?>">
		</div>
		<div class="fitts-clear"></div>
	<?php } ?>
	<?php if ( isset( $value['response'] ) ) { ?>
		<div class="fitts-open-text fitts_response" style="display:none;">
			<p class="fitts-quiz-question-text fitts_response_text">
				
			</p>
		</div>	
	<?php } ?>
	<div class="fitts-question-navigator">
		<span data-curent-quest="0" class="glyphicon glyphicon-circle-arrow-left fitts-prev-quest"></span>
		<span data-curent-quest="0" class="glyphicon glyphicon-circle-arrow-right fitts-next-quest"></span>
	</div>
	<div class="fitts-question-footer" style="<?php echo ( 1 == count( $filter_quiz_questions ) ) ? '' : 'display:none'; ?>">
		<?php if ( 'yes' == get_option( 'gdrp_term_condition' ) ) { ?>
			<input type="checkbox" id="gdrp_term_condition" class="gdrp_term_condition" value="yes" required="required" ><span style="margin-left:15px;"><?php echo __( 'I Accept GDRP Terms And Conditons', 'wc-quiz' ); ?></span><br>
		<?php } ?>
		<input type="button" id="fitts_submit_quiz" class="fitts_submit_quiz" value="Submit" >
		<p class="gdrp_term_condition_error"></p>
	</div>
	<div class="fitts-clear"></div>
</div>
<div class="fitts-quiz-rec-prods fitts-quiz-rec-prods-<?php echo wp_kses_post( $submission_id ); ?>" style="display:none">
	<table class="fitts-products-list">
		<thead>
			<tr>
				<th>
					<span> Recommended Products </span>
					<button class="glyphicon glyphicon-arrow-left fitts-back"> Back</button>
				</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>
