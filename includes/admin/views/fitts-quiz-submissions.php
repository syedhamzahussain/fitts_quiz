<div id="quiz_data" class="panel quiz_submission woocommerce-quiz-data" >
    <div class="quiz_data_column_container">
        <?php foreach ( $quiz_submissions as $key => $quiz_submission ) { 
            $chunks = count($quiz_submission)/2;
			$quiz_submission = array_chunk( $quiz_submission, $chunks );
            $count = 1;
        ?>
        <div class="quiz_submissions">
            <div class="quiz_submission_title">
                <p class="submisson_title_text"><?php echo 'Submission ' . wp_kses_post( $key+1 ); ?></p>
                <div class="submisson_title_date">
                    <p style="float: left;margin: 3px;">
                        <b><?php echo 'Date: '; ?></b><?php echo '2020-08-29 17:43:03'; ?>
                    </p>
                    <p style="float: right;margin: 0px;">
                        <span class="toggle-indicator fq-submission-title-icon"></span>
                    </p>
                </div>
            </div>
            <div class="quiz_submission_body">
                <?php foreach ( $quiz_submission as $quiz_index => $questions ) { ?>
                    <div class="quiz_submission_column" style="width: 45%;">
                        <?php foreach ( $questions as $que_index => $value ) { ?>
                            <div class="details">
                                <p>
                                    <strong><?php echo $count  . ') ' . wp_kses_post( $value['question'] ); ?></strong>
                                    <span style="margin-left: 25px;"><?php echo wp_kses_post( $value['answer'] ); ?></span>
                                    <?php $count++; ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="quiz_submission_footer">
                    <p class="submisson_product_title"><?php echo 'Suggested Product(s): '; ?></p>
                    <p class="submisson_product_suggested"></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
	<div class="clear"></div>
</div>