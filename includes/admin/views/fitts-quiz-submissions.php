<div id="quiz_data" class="panel quiz_submission woocommerce-quiz-data" >
	
	<div class="quiz_data_column_container">
		<table class="submission_data_table">
			<thead>
				<tr>
					<td>
						<input type="checkbox" name="select_all_submission" id="select_all_submission_<?php echo wp_kses_post( $post_id ); ?>" class="select_all_submission"><span>Select All</span> 
						<input type="button" name="delete_all_submission" id="delete_all_submission_<?php echo wp_kses_post( $post_id ); ?>" class="button button-secondary delete_all_submission" value="Delete" style="float:right">
					</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$submi_index = 1;
				foreach ( $quiz_submissions as $submission_id => $quiz_submission ) {

					$chunks = count( $quiz_submission ) / 2;
					if ( $chunks < 1 ) {
						$chunks = 1;
					}
					$quiz_submission = array_chunk( $quiz_submission, $chunks );
					$count           = 1;
					?>
				<tr>
					<td>
						<div class="quiz_submissions">
							<div class="quiz_submission_title">
								<input type="checkbox" name="delete_fitts_submission" id="delete_fitts_submission_<?php echo wp_kses_post( $submission_id ); ?>" class="delete_fitts_submission" data-submission-id="<?php echo wp_kses_post( $submission_id ); ?>">
								<p class="submisson_title_text"><?php echo 'Submission ' . wp_kses_post( $submi_index ); ?></p>
								<div class="submisson_title_date">
									<p style="float: left;margin: 3px;">
										<b><?php echo 'Date: '; ?></b><?php echo wp_kses_post( get_the_date( 'yy-m-d h:m:s a', $submission_id ) ); ?>
									</p>
									<p style="float: right;margin: 0px;">
										<span class="dashicons dashicons-arrow-down fq-outer-title-icon fq-submission-title-icon"></span>
									</p>
								</div>
							</div>
							<div class="quiz_submission_body">
							<?php foreach ( $quiz_submission as $quiz_index => $questions ) { ?>
									<div class="quiz_submission_column" style="width: 45%;">
										<?php foreach ( $questions as $que_index => $value ) { ?>
											<div class="details">
												<p>
													<strong><?php echo $count . ') ' . wp_kses_post( $value['question'] ); ?></strong>
													<span style="margin-left: 25px;">
													<?php
													if ( isset( $value['answer'] ) && is_array( $value['answer'] ) ) {
														echo wp_kses_post( implode( ',', $value['answer'] ) );
													} elseif ( isset( $value['answer'] ) && ! is_array( $value['answer'] ) ) {
														echo wp_kses_post( $value['answer'] );
													}
													?>
													</span>
													<?php $count++; ?>
												</p>
											</div>
										<?php } ?>
									</div>
								<?php } ?>
								<div class="quiz_submission_footer">
									<p class="submisson_product_title"><?php echo 'Suggested Product(s): '; ?></p>
									<span class="submisson_product_suggested">
										<?php
										$product_ids = get_post_meta( $submission_id, 'linked_products', true );
										if ( $product_ids ) {
											foreach ( $product_ids as $key => $product_id ) {
												$product = wc_get_product( intval( $product_id ) );
												if ( $product ) {
													echo ' <a href="' . get_permalink( $product_id ) . '">' . $product->get_name() . '</a>,';
												}
											}
										}
										?>
															
									</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				
					<?php
					$submi_index ++;
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="clear"></div>
</div>
