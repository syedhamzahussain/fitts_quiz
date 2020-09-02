<div id="quiz_data" class="panel woocommerce-quiz-data" >
	<div class="quiz_data_column_container">
		<div class="quiz_data_column">
			<div class="details">
				<p>
					<strong>Quiz Title:</strong>
					<?php echo wp_kses_post( $quiz_title ); ?>
				</p>
				<p>
					<strong>Quiz Submissions:</strong>
					<?php echo ( $quiz_submissions ) ? wp_kses_post( $quiz_submissions ) : 0; ?>
				</p>
			</div>
		</div>
		<div class="quiz_data_column">
			<div class="details">
				<p>
					<strong>Quiz Posted By:</strong>
					<a href="<?php echo wp_kses_post( get_edit_user_link($post->post_author) ) ?>"><?php echo wp_kses_post( $author_email ); ?></a>
				</p>
				<p>
					<strong>Quiz Posted On:</strong>
					<?php echo wp_kses_post( $quiz_posted_date ); ?>
				</p>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>