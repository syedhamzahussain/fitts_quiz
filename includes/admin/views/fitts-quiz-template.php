<table class="fq-fields" >
	<tbody>
		<?php
		foreach ( $filter_quiz_questions as $key => $filter_quiz_question ) { ?>
			<tr>
				<td>
					<p class="table-field-outer-title" >
						<span class="fq-outer-title" >
							<?php echo ( $filter_quiz_question['title'] ) ? wp_kses_post( $filter_quiz_question['title'] ) . ': ' : 'Title'; ?>
							<?php echo ( $filter_quiz_question['question'] ) ? wp_kses_post( sanitize_text_field( wp_unslash( $filter_quiz_question['question'] ) ) ) : ''; ?>
						</span>
						<span class="dashicons dashicons-arrow-down fq-outer-title-icon"></span>
					</p>
					<div class="table-field-inner-template">
						
						<p class="fitts-field-title inner-field-wrapper">
							<label for=""><b>Field Title :</b></label><br>
							<input type="text" name="fitts_field_title" id="fitts_field_title" class="fitts_field_title" value="<?php echo ( $filter_quiz_question['title'] ) ? wp_kses_post( $filter_quiz_question['title'] ) : ''; ?>">
						</p>
						
						<p class="fitts-field-question inner-field-wrapper">
							<label for=""><b>Question :</b></label><br>
							<textarea name="fitts_question" id="fitts_question" cols="41" rows="1"><?php echo ( $filter_quiz_question['question'] ) ? wp_kses_post( sanitize_text_field( wp_unslash( $filter_quiz_question['question'] ) ) ) : ''; ?></textarea>
						</p>

						<p class="fitts-field-ans-type inner-field-wrapper">
							<label for=""><b>Answer Type :</b></label><br>
							<select name="answer_type" id="answer_type_id" class="answer_type" >
								<option <?php echo ( 'multiple' == $filter_quiz_question['answerType'] ) ? 'selected' : ''; ?> value="multiple">Multiple choice</option>
								<option <?php echo ( 'open_text' == $filter_quiz_question['answerType'] ) ? 'selected' : ''; ?> value="open_text">Open Text</option>
							</select>
						</p>

						<p class="fitts-field-choice-type inner-field-wrapper">
							<label for=""><b>Choice Type :</b></label><br>
							<select name="choice_type" id="choice_type_id" class="choice_type" >
								<option <?php echo ( 'multiple' == $filter_quiz_question['answerType'] && isset( $filter_quiz_question['choiceType'] ) && 'singleAns' == $filter_quiz_question['choiceType'] ) ? 'selected' : ''; ?> value="singleAns">Single Answer</option>
								<option <?php echo ( 'multiple' == $filter_quiz_question['answerType'] && isset( $filter_quiz_question['choiceType'] ) && 'multiAns' == $filter_quiz_question['choiceType'] ) ? 'selected' : ''; ?> value="multiAns">Multiple Answer</option>
							</select>
						</p>

						<p class="fitts-field-text-type inner-field-wrapper">
							<label for=""><b>Open Text Type :</b></label><br>
							<select name="open_text_type" id="open_text_type" class="open_text_type" >
								<option <?php echo ( isset( $filter_quiz_question['fieldType'] ) && 'text' == $filter_quiz_question['fieldType'] ) ? 'selected' : ''; ?> value="text">Regular</option>
								<option <?php echo ( isset( $filter_quiz_question['fieldType'] ) && 'number' == $filter_quiz_question['fieldType'] ) ? 'selected' : ''; ?> value="number">Number</option>
								<option <?php echo ( isset( $filter_quiz_question['fieldType'] ) && 'email' == $filter_quiz_question['fieldType'] ) ? 'selected' : ''; ?> value="email">Email</option>
							</select>
						</p>

						<div class="fitts-field-choices">
							<label style="display:block;height:40px">
								<b>Multiple Choice :</b>
								<span style="float:right" class="button button-deafualt add-multi-choices"> Add more </span>
							</label>
							<?php if ( 'multiple' == $filter_quiz_question['answerType'] && isset( $filter_quiz_question['options'] ) ) { ?>
								<?php foreach ( $filter_quiz_question['options'] as $index => $value ) { ?>
									<p class="inner-fields-multiple-choice">
										<span class="fitts_remove_image" style="<?php echo ( 'multiple' == $filter_quiz_question['answerType'] && $value['file'] ) ? '' : 'display:none'; ?>">X</span>
										<input type="text" name="fitts_choice[<?php echo wp_kses_post( $index + 1 ); ?>]" id="fitts_choice_<?php echo wp_kses_post( $index + 1 ); ?>" class="fitts_choices" value="<?php echo ( 'multiple' == $filter_quiz_question['answerType'] && $value['label'] ) ? wp_kses_post( $value['label'] ) : ''; ?>">
										<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_<?php echo wp_kses_post( $index + 1 ); ?>">
											<option value="">Select a product...</option>
											<?php foreach ( $products as $key => $product ) { ?>
												<option <?php echo ( 'multiple' == $filter_quiz_question['answerType'] && is_array( $value['product'] ) && in_array( $product->ID, $value['product'] ) ) ? 'selected' : ''; ?> value="<?php echo wp_kses_post( $product->ID ); ?>"><?php echo wp_kses_post( $product->post_title ); ?></option>
											<?php } ?>
										</select>
										<img id="fitts_files_<?php echo wp_kses_post( $index + 1 ); ?>" src="<?php echo ( 'multiple' == $filter_quiz_question['answerType'] && $value['file'] ) ? wp_kses_post( $value['file'] ) : ''; ?>" width="60px" height="60px" style="<?php echo ( 'multiple' == $filter_quiz_question['answerType'] && $value['file'] ) ? '' : 'display:none'; ?>">
										<button class="set_custom_images button-primary" style="<?php echo ( 'multiple' == $filter_quiz_question['answerType'] && $value['file'] ) ? 'display:none' : ''; ?>">Upload</button>
										<button class="remove_choice_field button" >Delete</button>
									</p>
								<?php } ?>
							<?php } ?>
						</div>
						<hr>

						<p class="fitts-field-conditional_check">
							<input type="checkbox" name="fitts_is_conditional" id="fitts_is_conditional" class="fitts_is_conditional" <?php echo isset( $filter_quiz_question['condition'] ) ? 'checked' : ''; ?> ><b><?php echo 'Is Conditional?'; ?></b>
						</p>
						<p class="fitts-field-conditional">

							<?php echo 'Show If '; ?>
							<select name="fitts_parent_field" id="fitts_parent_field" placeholder="Type Previous Question" >
								<?php if ( isset( $filter_quiz_question['condition'] ) && $filter_quiz_question['condition']['parent'] ) { ?>
									<option value="<?php echo wp_kses_post( $filter_quiz_question['condition']['parent'] ); ?>"><?php echo wp_kses_post( $filter_quiz_question['condition']['parent'] ); ?></option>
								<?php } else { ?>
									<option value=""><?php echo wp_kses_post( 'Select the very previous question' ); ?></option>
								<?php } ?>
							</select>
							<br><br>
							<?php echo 'answer is '; ?>
							<input type="text" placeholder="Type Previous Answer" name="fitts_parent_field_answer" id="fitts_parent_field_answer" value="<?php echo ( isset( $filter_quiz_question['condition'] ) && $filter_quiz_question['condition']['parentAnswer'] ) ? wp_kses_post( $filter_quiz_question['condition']['parentAnswer'] ) : ''; ?>">

						</p>		
						
						<p class="fitts-field-response">
							<label for=""><b>Response :</b></label><br>
							<input type="text" name="fitts_answer_response" id="fitts_answer_response" style="width: 436px;" value="<?php echo ( isset( $filter_quiz_question['response'] ) ) ? wp_kses_post( $filter_quiz_question['response'] ) : ''; ?>">
						</p>

						<p class="fitts-field-answer ">
							<label for=""><b>Link Product :</b></label><br>
							<select multiple name="linked_product" id="linked_product">
								<option value="">Select a product...</option>
								<?php foreach ( $products as $key => $product ) { ?>
									<option <?php echo ( isset( $filter_quiz_question['linkedProduct'] ) && $product->ID == $filter_quiz_question['linkedProduct'] ) ? 'selected' : ''; ?> value="<?php echo wp_kses_post( $product->ID ); ?>"><?php echo wp_kses_post( $product->post_title ); ?></option>
								<?php } ?>
							</select>							
						</p>

						<p class="fitts-field-remove">
							<input type="button" class="button-secondary remove-fitts-field" value="Remove" >
						</p>

					</div>
				</td>
			</tr>			
		<?php } ?>
	</tbody>
</table>
<div class="fitts-quiz-action-buttons">
	<input type="button" id="add-new-fitts-field" class="fitts-quiz-buttons button-secondary" value="Add New Field">
	<input type="button" id="save-fitts-field" class="fitts-quiz-buttons button-primary" value="Save">
	<input type="hidden" name="fitts_post_id" value="<?php echo wp_kses_post( $_GET['post'] ); ?>">
</div>

<!-- template -->
<table class="fq-fields-default-template" style="display:none;">
	<tr>
		<td>
			<p class="table-field-outer-title" >
				<span class="fq-outer-title" >Title</span>
				<span class="dashicons dashicons-arrow-down fq-outer-title-icon"></span>
			</p>
			<div class="table-field-inner-template">
				
				<p class="fitts-field-title inner-field-wrapper">
					<label for=""><b>Field Title :</b></label><br>
					<input type="text" name="fitts_field_title" id="fitts_field_title">
				</p>

				<p class="fitts-field-question inner-field-wrapper">
					<label for=""><b>Question :</b></label><br>
					<textarea name="fitts_question" id="fitts_question" cols="41" rows="1"></textarea>
				</p>

				<p class="fitts-field-ans-type inner-field-wrapper">
					<label for=""><b>Answer Type :</b></label><br>
					<select name="answer_type" id="answer_type_id" class="answer_type" >
						<option value="multiple">Multiple choice</option>
						<option value="open_text">Open Text</option>
					</select>
				</p>

				<p class="fitts-field-ans-type inner-field-wrapper">
					<label for=""><b>Choice Type :</b></label><br>
					<select name="choice_type" id="choice_type_id" class="choice_type" >
						<option value="multiple">Single Answer</option>
						<option value="open_text">Multiple Answer</option>
					</select>
				</p>

				<p class="fitts-field-text-type inner-field-wrapper">
					<label for=""><b>Open Text Type :</b></label><br>
					<select name="open_text_type" id="open_text_type" class="open_text_type" >
						<option value="text">Regular</option>
						<option value="number">Number</option>
						<option value="email">Email</option>
					</select>
				</p>

				<div class="fitts-field-choices">
					<label style="display:block;height:40px">
						<b>Multiple Choice :</b>
						<span style="float:right" class="button button-deafualt add-multi-choices"> Add more </span>
					</label>
					<p class="inner-fields-multiple-choice">
						<span class="fitts_remove_image" style="display:none">X</span>
						<input type="text" name="fitts_choice[1]" id="fitts_choice_1" class="fitts_choices">
						<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_1">
							<option value="">Select a product...</option>
							<?php foreach ( $products as $key => $product ) { ?>
								<option value="<?php echo wp_kses_post( $product->ID ); ?>"><?php echo wp_kses_post( $product->post_title ); ?></option>
							<?php } ?>
						</select>
						<img id="fitts_files_1" src="" width="60px" height="60px" style="display:none">
						<button class="set_custom_images button">Upload</button>
						<button class="remove_choice_field button" >Delete</button>
					</p>
				</div>
				<hr>
					
				<p class="fitts-field-conditional_check">
					<input type="checkbox" name="fitts_is_conditional" id="fitts_is_conditional" class="fitts_is_conditional"><?php echo 'Is Conditional?'; ?>
				</p>
				<p class="fitts-field-conditional">

					<?php echo 'Show If '; ?>
					<select name="fitts_parent_field" id="fitts_parent_field" placeholder="Type Previous Question" >
						<option value=""><?php echo wp_kses_post( 'Select the very previous question' ); ?></option>
					</select>
					<br><br>
					<?php echo 'answer is '; ?>
					<input type="text" placeholder="Type Previous Answer" name="fitts_parent_field_answer" id="fitts_parent_field_answer">

				</p>		

				<p class="fitts-field-response">
					<label for=""><b>Response :</b></label><br>
					<input type="text" name="fitts_answer_response" id="fitts_answer_response" style="width: 436px;" value="">
				</p>

				<p class="fitts-field-answer">
					<label for=""><b>Link Product :</b></label><br>
					<select multiple name="linked_product" id="linked_product">
						<option value="">Select a product...</option>
						<?php foreach ( $products as $key => $product ) { ?>
							<option value="<?php echo wp_kses_post( $product->ID ); ?>"><?php echo wp_kses_post( $product->post_title ); ?></option>
						<?php } ?>
					</select>		
				</p>
				
				<p class="fitts-field-remove">
					<input type="button" class="button-secondary remove-fitts-field" value="Remove" >
				</p>

			</div>
		</td>
	</tr>			
</table>

<!-- Template to clone-->

<div class="fitts-field-choices-template" style="display:none;">
	<p class="inner-fields-multiple-choice">
		<span class="fitts_remove_image" style="display:none">X</span>
		<input type="text" name="fitts_choice[1]" id="fitts_choice_1" class="fitts_choices">
		<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_1">
			<option value="">Select a product...</option>
			<?php foreach ( $products as $key => $product ) { ?>
				<option value="<?php echo wp_kses_post( $product->ID ); ?>"><?php echo wp_kses_post( $product->post_title ); ?></option>
			<?php } ?>
		</select>
		<img id="fitts_files_1" src="" width="60px" height="60px" style="display:none">
		<button class="set_custom_images button">Upload</button>
		<button class="remove_choice_field button" >Delete</button>
	</p>
	<hr>
</div>
