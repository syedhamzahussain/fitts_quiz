<table class="fq-fields" >
	<tbody>
		<?php foreach ( $filter_quiz_questions as $key => $filter_quiz_question ) { ?>
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

						<p class="fitts-field-text-type inner-field-wrapper">
							<label for=""><b>Open Text Type :</b></label><br>
							<select name="open_text_type" id="open_text_type" class="open_text_type" >
								<option <?php echo ( isset( $filter_quiz_question['fieldType'] ) && 'multiple' == $filter_quiz_question['fieldType'] ) ? 'selected' : ''; ?> value="text">Regular</option>
								<option <?php echo ( isset( $filter_quiz_question['fieldType'] ) && 'multiple' == $filter_quiz_question['fieldType'] ) ? 'selected' : ''; ?> value="number">Number</option>
								<option <?php echo ( isset( $filter_quiz_question['fieldType'] ) && 'multiple' == $filter_quiz_question['fieldType'] ) ? 'selected' : ''; ?> value="email">Email</option>
							</select>
						</p>

						<div class="fitts-field-choices">
							<label for=""><b>Multiple Choice :</b></label>
							<p class="inner-fields-multiple-choice">
								<span class="fitts_remove_image" style="<?php echo ( $filter_quiz_question['options'][0]['file'] ) ? '' : 'display:none'; ?>">X</span>
								<input type="text" name="fitts_choice[1]" id="fitts_choice_1" class="fitts_choices" value="<?php echo ( $filter_quiz_question['options'][0]['label'] ) ? wp_kses_post( $filter_quiz_question['options'][0]['label'] ) : ''; ?>">
								<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_1">
									<option value="">Select a product...</option>
									<?php foreach ( $products as $key => $product ) { ?>
										<option <?php echo ( isset( $filter_quiz_question['options'][0]['product'] ) && $product->get_id() == $filter_quiz_question['options'][0]['product'] ) ? 'selected' : ''; ?> value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
									<?php } ?>
								</select>
								<img id="fitts_files_1" src="<?php echo ( $filter_quiz_question['options'][0]['file'] ) ? wp_kses_post( $filter_quiz_question['options'][0]['file'] ) : ''; ?>" width="60px" height="60px" style="<?php echo ( $filter_quiz_question['options'][0]['file'] ) ? '' : 'display:none'; ?>">
								<button class="set_custom_images button" style="<?php echo ( $filter_quiz_question['options'][0]['file'] ) ? 'display:none' : ''; ?>">Upload</button>
							</p>
							<p class="inner-fields-multiple-choice">
								<span class="fitts_remove_image" style="<?php echo ( $filter_quiz_question['options'][1]['file'] ) ? '' : 'display:none'; ?>">X</span>
								<input type="text" name="fitts_choice[2]" id="fitts_choice_2" class="fitts_choices" value="<?php echo ( $filter_quiz_question['options'][1]['label'] ) ? wp_kses_post( $filter_quiz_question['options'][1]['label'] ) : ''; ?>">
								<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_2">
									<option value="">Select a product...</option>
									<?php foreach ( $products as $key => $product ) { ?>
										<option <?php echo ( isset( $filter_quiz_question['options'][1]['product'] ) &&  $product->get_id() == $filter_quiz_question['options'][1]['product'] ) ? 'selected' : ''; ?> value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
									<?php } ?>
								</select>
								<img id="fitts_files_2" src="<?php echo ( $filter_quiz_question['options'][1]['file'] ) ? wp_kses_post( $filter_quiz_question['options'][1]['file'] ) : ''; ?>" width="60px" height="60px" style="<?php echo ( $filter_quiz_question['options'][1]['file'] ) ? '' : 'display:none'; ?>">
								<button class="set_custom_images button" style="<?php echo ( $filter_quiz_question['options'][1]['file'] ) ? 'display:none' : ''; ?>">Upload</button>
							</p>
							<p class="inner-fields-multiple-choice">
								<span class="fitts_remove_image" style="<?php echo ( $filter_quiz_question['options'][2]['file'] ) ? '' : 'display:none'; ?>">X</span>
								<input type="text" name="fitts_choice[3]" id="fitts_choice_3" class="fitts_choices" value="<?php echo ( $filter_quiz_question['options'][2]['label'] ) ? wp_kses_post( $filter_quiz_question['options'][2]['label'] ) : ''; ?>">
								<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_3">
									<option value="">Select a product...</option>
									<?php foreach ( $products as $key => $product ) { ?>
										<option <?php echo ( isset( $filter_quiz_question['options'][2]['product'] ) &&  $product->get_id() == $filter_quiz_question['options'][2]['product'] ) ? 'selected' : ''; ?> value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
									<?php } ?>
								</select>
								<img id="fitts_files_3" src="<?php echo ( $filter_quiz_question['options'][2]['file'] ) ? wp_kses_post( $filter_quiz_question['options'][2]['file'] ) : ''; ?>" width="60px" height="60px" style="<?php echo ( $filter_quiz_question['options'][2]['file'] ) ? '' : 'display:none'; ?>">
								<button class="set_custom_images button" style="<?php echo ( $filter_quiz_question['options'][2]['file'] ) ? 'display:none' : ''; ?>">Upload</button>
							</p>
							<p class="inner-fields-multiple-choice">
								<span class="fitts_remove_image" style="<?php echo ( $filter_quiz_question['options'][3]['file'] ) ? '' : 'display:none'; ?>">X</span>
								<input type="text" name="fitts_choice[4]" id="fitts_choice_4" class="fitts_choices" value="<?php echo ( $filter_quiz_question['options'][3]['label'] ) ? wp_kses_post( $filter_quiz_question['options'][3]['label'] ) : ''; ?>">
								<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_4">
									<option value="">Select a product...</option>
									<?php foreach ( $products as $key => $product ) { ?>
										<option <?php echo ( isset( $filter_quiz_question['options'][3]['product'] ) && $product->get_id() == $filter_quiz_question['options'][3]['product'] ) ? 'selected' : ''; ?> value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
									<?php } ?>
								</select>

								<img id="fitts_files_4" src="<?php echo ( $filter_quiz_question['options'][3]['file'] ) ? wp_kses_post( $filter_quiz_question['options'][3]['file'] ) : ''; ?>" width="60px" height="60px" style="<?php echo ( $filter_quiz_question['options'][3]['file'] ) ? '' : 'display:none'; ?>">
								<button class="set_custom_images button" style="<?php echo ( $filter_quiz_question['options'][3]['file'] ) ? 'display:none' : ''; ?>">Upload</button>
							</p>
							<hr>
						</div>

						<p class="fitts-field-conditional_check">
							<input type="checkbox" name="fitts_is_conditional" id="fitts_is_conditional" class="fitts_is_conditional" <?php echo isset( $filter_quiz_question['condition'] ) ? 'checked' : ''; ?> ><?php echo 'Is Conditional?'; ?>
						</p>
						<p class="fitts-field-conditional">

							<?php echo 'Show If '; ?>
							<input type="text" name="fitts_parent_field" id="fitts_parent_field" value="<?php echo ( isset( $filter_quiz_question['condition'] ) && $filter_quiz_question['condition']['parent'] ) ? wp_kses_post( $filter_quiz_question['condition']['parent'] ) : ''; ?>" placeholder="Type Field Title" >
							<?php echo 'answer is '; ?>
							<input type="text" name="fitts_parent_field_answer" id="fitts_parent_field_answer" value="<?php echo ( isset( $filter_quiz_question['condition'] ) && $filter_quiz_question['condition']['parentAnswer'] ) ? wp_kses_post( $filter_quiz_question['condition']['parentAnswer'] ) : ''; ?>">

						</p>		
							
						<p class="fitts-field-answer ">
							<label for=""><b>Link Product :</b></label><br>
							<select multiple name="linked_product" id="linked_product">
									<option value="">Select a product...</option>
								<?php foreach ( $products as $key => $product ) { ?>
									<option <?php echo ( isset( $filter_quiz_question['linkedProduct'] ) && $product->get_id() == $filter_quiz_question['linkedProduct'] ) ? 'selected' : ''; ?> value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
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

				<p class="fitts-field-text-type inner-field-wrapper">
					<label for=""><b>Open Text Type :</b></label><br>
					<select name="open_text_type" id="open_text_type" class="open_text_type" >
						<option value="text">Regular</option>
						<option value="number">Number</option>
						<option value="email">Email</option>
					</select>
				</p>

				<div class="fitts-field-choices">
					<label for=""><b>Multiple Choice :</b></label>
					<p class="inner-fields-multiple-choice">
						<span class="fitts_remove_image" style="display:none">X</span>
						<input type="text" name="fitts_choice[1]" id="fitts_choice_1" class="fitts_choices">
						<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_1">
							<option value="">Select a product...</option>
							<?php foreach ( $products as $key => $product ) { ?>
								<option value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
							<?php } ?>
						</select>
						<img id="fitts_files_1" src="" width="60px" height="60px" style="display:none">
						<button class="set_custom_images button">Upload</button>
					</p>
					<p class="inner-fields-multiple-choice">
						<span class="fitts_remove_image" style="display:none">X</span>
						<input type="text" name="fitts_choice[2]" id="fitts_choice_2" class="fitts_choices">
						<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_2">
							<option value="">Select a product...</option>
							<?php foreach ( $products as $key => $product ) { ?>
								<option value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
							<?php } ?>
						</select>
						<img id="fitts_files_2" src="" width="60px" height="60px" style="display:none">
						<button class="set_custom_images button">Upload</button>
					</p>
					<p class="inner-fields-multiple-choice">
						<span class="fitts_remove_image" style="display:none">X</span>
						<input type="text" name="fitts_choice[3]" id="fitts_choice_3" class="fitts_choices">
						<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_3">
							<option value="">Select a product...</option>
							<?php foreach ( $products as $key => $product ) { ?>
								<option value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
							<?php } ?>
						</select>
						<img id="fitts_files_3" src="" width="60px" height="60px" style="display:none">
						<button class="set_custom_images button">Upload</button>
					</p>
					<p class="inner-fields-multiple-choice">
						<span class="fitts_remove_image" style="display:none">X</span>
						<input type="text" name="fitts_choice[4]" id="fitts_choice_4" class="fitts_choices">
						<select multiple style=" width: auto;" name="choices_linked_product" id="choices_linked_product_4">
							<option value="">Select a product...</option>
							<?php foreach ( $products as $key => $product ) { ?>
								<option value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
							<?php } ?>
						</select>
						<img id="fitts_files_4" src="" width="60px" height="60px" style="display:none">
						<button class="set_custom_images button">Upload</button>
					</p>
					<hr>
				</div>
					
				<p class="fitts-field-conditional_check">
					<input type="checkbox" name="fitts_is_conditional" id="fitts_is_conditional" class="fitts_is_conditional"><?php echo 'Is Conditional?'; ?>
				</p>
				<p class="fitts-field-conditional">

					<?php echo 'Show If '; ?>
					<input type="text" name="fitts_parent_field" id="fitts_parent_field" placeholder="Type Field Title" >
					<?php echo 'answer is '; ?>
					<input type="text" name="fitts_parent_field_answer" id="fitts_parent_field_answer">

				</p>		

				<p class="fitts-field-answer">
					<label for=""><b>Link Product :</b></label><br>
					<select multiple name="linked_product" id="linked_product">
						<option value="">Select a product...</option>
						<?php foreach ( $products as $key => $product ) { ?>
							<option value="<?php echo wp_kses_post( $product->get_id() ); ?>"><?php echo wp_kses_post( $product->get_name() ); ?></option>
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