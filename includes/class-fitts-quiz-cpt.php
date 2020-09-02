<?php
/**
 * File For Quiz Post type.
 * 
 * @package fitts-Quiz
 * @since Date: 8-25-2020
 */

if ( ! defined('ABSPATH') ) {
	return;
} 

if ( ! class_exists( 'Fitts_Quiz_Post_Type' ) ) {

	/**
	 * Main Class For Fitts Quiz.
	 */
	class Fitts_Quiz_Post_Type {
		
		/**
		 * Main Function.
		 */
		public function __construct() {

			add_action( 'init', array( __CLASS__, 'register_fitts_quiz_post_type' ), 0 );
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 30 );
			// add_action( 'save_post', array( $this, 'save_meta_boxes' ), 1, 2 );
			add_action( 'wp_ajax_save_fitts_quiz_question', array( $this, 'save_fitts_quiz_question' ) );
			add_action( 'wp_ajax_nopriv_save_fitts_quiz_question', array( $this, 'save_fitts_quiz_question' ) );
			add_action ( 'admin_enqueue_scripts', [ $this, 'add_media_button'] );

			add_filter( 'manage_posts_custom_column', array( $this, 'fq_quiz_table_row' ), 10, 2 );
			add_filter( 'manage_posts_columns', array( $this, 'fq_quiz_table' ), 10, 2 );
			
		}

		public function add_media_button() {

			wp_enqueue_media ();

		}

		/**
		 * Register core post types.
		 */
		public static function register_fitts_quiz_post_type() {

			$labels = array(
				'name'               => _x( 'Fitts Quiz', 'post type general name', 'wc-quiz' ),
				'singular_name'      => _x( 'Quiz', 'post type singular name', 'wc-quiz' ),
				'menu_name'          => _x( 'Fitts Quiz', 'admin menu', 'wc-quiz' ),
				'name_admin_bar'     => _x( 'Fitts Quiz', 'add new on admin bar', 'wc-quiz' ),
				'add_new'            => _x( 'Add New', 'quiz', 'wc-quiz' ),
				'add_new_item'       => __( 'Add New Quiz', 'wc-quiz' ),
				'new_item'           => __( 'New Quiz', 'wc-quiz' ),
				'edit_item'          => __( 'Edit Quiz', 'wc-quiz' ),
				'view_item'          => __( 'View Quiz', 'wc-quiz' ),
				'all_items'          => __( 'All Quizes', 'wc-quiz' ),
				'search_items'       => __( 'Search Quizes', 'wc-quiz' ),
				'parent_item_colon'  => __( 'Parent Quizes:', 'wc-quiz' ),
				'not_found'          => __( 'No quizs found.', 'wc-quiz' ),
				'not_found_in_trash' => __( 'No quizs found in Trash.', 'wc-quiz' ),
			);
			$args   = array(
				'labels'             => $labels,
				'description'        => __( 'Quizes for WooCommerce products.', 'wc-quiz' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'quiz' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 30,
				'menu_icon'          => 'dashicons-media-text',
				'supports'           => array( 'title' ),
			);
			register_post_type( 'fitts-quiz', $args );
		}

		/**
		 * Add WC Meta boxes.
		 */
		public function add_meta_boxes() {
			
			if( isset( $_GET['post'] ) ) {
				add_meta_box( 'fq-quiz-details', sprintf( __( 'Quiz Details', 'wc-quiz' ) ), [ $this, 'fitts_quiz_details' ], 'fitts-quiz', 'normal', 'high' );
				add_meta_box( 'fq-quiz-fields', sprintf( __( "Quiz Fields", 'wc-quiz' ) ), [ $this, 'fitts_quiz_fields' ], 'fitts-quiz', 'normal', 'high' );
				add_meta_box( 'fq-quiz-submissions', sprintf( __( 'Quiz Submissions', 'wc-quiz' ) ), [ $this, 'fitts_quiz_submissions' ], 'fitts-quiz', 'normal', 'high' );
				add_meta_box( 'fq-quiz-shortcode', sprintf( __( 'Quiz Shortcode', 'wc-quiz' ) ), [ $this, 'fitts_quiz_shortcode' ], 'fitts-quiz', 'side', 'low' );
			}

		}

		/**
		 * Function to render fields.
		 */
		public function fitts_quiz_fields() {

			$post_id = $_GET['post'];
			$filter_quiz_questions = get_post_meta( $post_id, 'filter_quiz_questions', true );
			if( empty( $filter_quiz_questions ) ) {
				$filter_quiz_questions = array(
					array(
						'title' => '',
						'question' => '',
						'answerType' => '',
						'options' => array(
								array(
										'label' => '',
										'file' => '',
								),
								array(
										'label' => '',
										'file' => '',
								),
								array(
										'label' => '',
										'file' => '',
								),
								array(
										'label' => '',
										'file' => '',
								),
							),
						'correctAnswer' => '',
						'linkedProduct' => '',
					),
				);
			}
			$args = array(
				'status' => 'publish',  
				'limit'  =>	'-1',
			);
			$products = wc_get_products( $args );
			 
			include FQ_PLUGIN_DIR . '/includes/admin/views/fitts-quiz-template.php';

		}

		/**
		 * Function to render submissions.
		 */
		public function fitts_quiz_shortcode() {
		
			include FQ_PLUGIN_DIR . '/includes/admin/views/fitts-quiz-shortcode.php';
			
		}

		/**
		 * Function to render submissions.
		 */
		public function fitts_quiz_details() {

			$post_id = $_GET['post'];
			$post    = get_post( $post_id );
			$author  = get_userdata($post->post_author);

			$quiz_title       = $post->post_title;
			$author_email     = $author->data->user_email;
			$quiz_posted_date = $post->post_date;
			$quiz_submissions = get_option( 'fitts_quiz_submissions' );

			include FQ_PLUGIN_DIR . '/includes/admin/views/fitts-quiz-details.php';
			
		}

		/**
		 * Function to render submissions.
		 */
		public function fitts_quiz_submissions() {

			$quiz_submissions = array(
				array(
					array(
						'question' => 'What is your favorite Product?',
						'answer' => 'Beanie with logo',
						'type' => '',
					),
					array(
						'question' => 'What is your Name?',
						'answer' => 'Shaheer',
						'type' => '',
					),
					array(
						'question' => 'What is your Email?',
						'answer' => 'test@gmail.com',
						'type' => '',
					),
					array(
						'question' => 'What is your Hobby?',
						'answer' => 'Football,BasketBall, Drawing,Painting',
						'type' => '',
					),
				),
				array(
					array(
						'question' => 'What is your favorite Product?',
						'answer' => 'Beanie with logo',
						'type' => '',
					),
					array(
						'question' => 'What is your Name?',
						'answer' => 'Shaheer',
						'type' => '',
					),
					array(
						'question' => 'What is your Email?',
						'answer' => 'test@gmail.com',
						'type' => '',
					),
					array(
						'question' => 'What is your Hobby?',
						'answer' => 'Football,BasketBall, Drawing,Painting',
						'type' => '',
					),
				),
			);
			
// 			include FQ_PLUGIN_DIR . '/includes/admin/views/fitts-quiz-submissions.php';

		}

		/**
		 * Function to save quiz questions.
		 */
		public function save_fitts_quiz_question() {

			$filter_quiz_questions = filter_input( INPUT_POST, 'fitts_quiz', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY ) ;
			$post_id = $_POST['fitts_post_id'];
	
			
			if( $filter_quiz_questions ) {
				
				delete_post_meta( $post_id, 'filter_quiz_questions' );
				update_post_meta( $post_id, 'filter_quiz_questions', $filter_quiz_questions );
				
			}
		}

		/**
		 * Filter Functionality.
		 *
		 * @param array $column Column Array.
		 */
		public function fq_quiz_table( $post_columns, $post_type ) {
			if( "fitts-quiz" == $post_type ) {
				unset( $post_columns['date'] );
				$post_columns['fitts_submissions'] = 'Quiz Submission(s)';
				$post_columns['date'] = 'Date';
			}
			return $post_columns;
		}
		
		/**
		 * Filter Functionality.
		 *
		 * @param string $val Value.
		 * @param string $column_name Column Name.
		 * @param int    $user_id User Id.
		 */
		public function fq_quiz_table_row( $post_columns, $post_id ) {

			if( 'fitts_submissions' == $post_columns ) {
				$quiz_submissions = get_option( 'fitts_quiz_submissions' );
				if( ! empty( $quiz_submissions ) ) {
					$val = $quiz_submissions;
				}
				else{
					$val = 0;
				}
				
				echo $val;
			}

		}

	}
	new Fitts_Quiz_Post_Type();
}