<?php
/**
 * Function to get submission count.
 *
 * @param int $quiz_id Quiz Id.
 */
function get_quiz_submissions( $quiz_id = -1 ) {

	$args = array(
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'post_parent'    => $quiz_id,
		'post_type'      => 'post',
	);

	$childrens = get_children( $args );

	if ( $childrens ) {
		return $childrens;
	}
	return array();
}
