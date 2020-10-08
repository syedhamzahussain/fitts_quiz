<?php
/**
 * Main File For The Frontend stuff.
 *
 * @package fitts-plugin
 * @since Date: 8-25-2020
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! class_exists( 'Fitts_Quiz' ) ) {

	/**
	 * Main Class For Fitts Quiz.
	 */
	class Fitts_Quiz {

		/**
		 * Constructor Function.
		 */
		public function __construct() {

			add_action( 'wp_enqueue_scripts', array( $this, 'fitts_frontend_scripts' ), 1, 10 );
			add_action( 'init', array( $this, 'wpdocs_add_custom_shortcode' ) );
			add_action( 'template_redirect', array( $this, 'show_recommended_products' ), 10, 1 );
			add_action( 'wp_ajax_save_submissions', array( $this, 'save_submissions' ) );
			add_action( 'wp_ajax_nopriv_save_submissions', array( $this, 'save_submissions' ) );

		}

		/**
		 * Function to add shortcode.
		 */
		public function wpdocs_add_custom_shortcode() {
			add_shortcode( 'fitts_quiz', array( $this, 'fitts_plugin_shortcode' ) );
		}

		/**
		 * Funtion to create submission logs.
		 */
		public function save_submissions() {
			$quiz_submissions = ! empty( $_POST['quiz_submissions'] ) ? $_POST['quiz_submissions'] : '';
			$parent_id        = ! empty( $_POST['parent_id'] ) ? $_POST['parent_id'] : '';
			$linked_products  = ! empty( $_POST['linked_products'] ) ? $_POST['linked_products'] : '';
			$all_products     = array();

			if ( $quiz_submissions ) {

				if ( $linked_products ) {

					foreach ( $linked_products as $key => $value ) {

						if ( $value ) {
							$all_products = array_merge( $all_products, explode( ',', $value ) );
						}
					}
					$all_products = array_unique( $all_products );
					foreach ( $all_products as $key => $product_id ) {
						$product             = wc_get_product( $product_id );
						$product_image       = wp_get_attachment_url( $product->get_image_id() );
						$attachments[]       = $product_image;
						$recomend_products[] = '<a href="' . $product->get_permalink( $product->get_id() ) . '">' . $product->get_name() . '</a>';

						$products[] = '<center><img src="' . $product_image . '" height="auto" width="200"></center><br>' .
						'<p>' . $product->get_name() . '</p>' .
						'<p>' . $product->get_short_description() . '</p>' .
						'<a href="' . $product->get_permalink( $product->get_id() ) . '">'.__('More Information','wc-quiz').'</a>';
					}

					if ( isset( $_POST['customer_email'] ) && 'yes' == get_option( 'fitts_allow_email_product' ) ) {
						$to      = sanitize_text_field( wp_unslash( $_POST['customer_email'] ) );
						$subject = 'Recommended Products';

						$message .= '<p><b>Recommended Products</b></p>';
						foreach ( $recomend_products as $key => $product ) {
							$message .= '<p>' . $product . '</p>';
						}
						// Always set content-type when sending HTML email
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";

						wp_mail( $to, $subject, $message, $headers );
					}
				}

				$post_arr = array(
					'post_title'  => 'Fitts Quiz Submission',
					'post_status' => 'draft',
					'post_type'   => 'post',
					'post_author' => get_current_user_id(),
					'post_parent' => $parent_id,
					'meta_input'  => array(
						'fitts_quiz_submission' => $quiz_submissions,
					),
				);

				$post_id = wp_insert_post( $post_arr );

				if ( ! is_wp_error( $post_id ) ) {

					update_post_meta( $post_id, 'linked_products', $all_products );
					foreach ( $all_products as $key => $product_id ) {

						$quantity      = 1;
						$cart_item_key = wc()->cart->add_to_cart( $product_id, $quantity, $cart_item_data );

					}
					echo json_encode(
						array(
							'status' => 'success',
							'url'    => site_url() . '/cart?from=quiz',
						)
					);
				} else {
					echo $post_id->get_error_message();
				}
			}
			wp_die();
		}

		/**
		 * Function to show recommended products.
		 */
		public function show_recommended_products() {

			$submission_id = isset( $_GET['fitts_submission'] ) ? $_GET['fitts_submission'] : '';
			if ( $submission_id ) {

				$product_ids = get_post_meta( $submission_id, 'linked_products', true );
				include FQ_PLUGIN_DIR . '/template/fitts-recommended-products.php';

			}

		}

		/**
		 * Function to render quiz based on shortcode.
		 */
		public function fitts_plugin_shortcode( $atts ) {

			if ( ! isset( $atts['id'] ) ) {
				return;
			}

			$post_id               = $atts['id'];
			$filter_quiz_questions = get_post_meta( $post_id, 'filter_quiz_questions', true );

			if ( ! $filter_quiz_questions ) {
				echo "<p style='text-align:center;'>". __( 'No Questions Added in this Quiz', 'wc-quiz' )."</p>";
				return;
			}
			include FQ_PLUGIN_DIR . '/template/fitts-quiz-front.php';

		}

		/**
		 * Enqueue Frontend scripts.
		 */
		public function fitts_frontend_scripts() {

			wp_enqueue_style( 'fitts-front-style', FQ_PLUGIN_DIR_URL . '/assests/css/fitts-quiz.css', true );
			wp_enqueue_script( 'fitts-front-script', FQ_PLUGIN_DIR_URL . '/assests/js/fitts-quiz.js', array( 'jquery' ), true );
			wp_localize_script(
				'fitts-front-script',
				'fitts_quiz_front',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				)
			);
		}

	}
}
new Fitts_Quiz();
