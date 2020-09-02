<?php
/**
 * Main File For The Settings Page stuff.
 * 
 * @package fitts-Quiz
 * @since Date: 8-25-2020
 */

if ( ! defined('ABSPATH') ) {
    return;
} 

if ( ! class_exists( 'Fitts_Quiz_Settings' ) ) {

	/**
	 * Main Class For Fitts Quiz.
	 */
	class Fitts_Quiz_Settings {
		
        /**
		 * Main Function.
		 */
		public function __construct() {

			add_filter( 'woocommerce_settings_tabs_array', [ $this, 'fitts_quiz_settings_tab' ], 50 );
			add_action( 'woocommerce_settings_fitts-quiz', [ $this, 'fitts_quiz_settings' ] );
			add_action( 'woocommerce_update_options_fitts-quiz', [ $this, 'fitts_quiz_save_settings' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'fitts_admin_scripts' ] );
		}

		/**
		 * Function to enqueue admin scripts.
		 */
		public function fitts_admin_scripts() {
		
			wp_enqueue_style( 'fitts-admin-style', FQ_PLUGIN_DIR_URL . '/assests/css/admin/fitts-quiz-admin.css', true );
			wp_enqueue_script( 'fitts-admin-script', FQ_PLUGIN_DIR_URL . '/assests/js/admin/fitts-quiz-admin.js', array( 'jquery' ), true );
			wp_localize_script( 
				'fitts-admin-script',
				'fitts_quiz_locale', 
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				)
			);

		}

		/**
		 * Function to create settings tab.
		 * 
		 * @param array $settings_tabs Settings Tab slug.
		 * @return array
		 */
		public function fitts_quiz_settings_tab( $settings_tabs ) {

			$settings_tabs[ 'fitts-quiz' ] = __( 'Fitts Quiz', 'wc-quiz' );
			return $settings_tabs;

		}

		/**
		 * Function to render settings.
		 */
		public function fitts_quiz_settings() {

			woocommerce_admin_fields( $this->get_fitts_quiz_settings() );

		}

		/**
		 * Function to save settings.
		 */
		public function fitts_quiz_save_settings() {

			woocommerce_update_options( $this->get_fitts_quiz_settings() );

		}

		/**
		 * Function to return settings page fields.
		 */
		public function get_fitts_quiz_settings() {

			$settings = array(
				array(
					'title' => __( 'Fitts Quiz Settings', 'wc-quiz' ),
					'desc'  => 'Settings for Fiits Quiz',
					'type'  => 'title',
					'id'    => 'fitts_quiz_settigs_title',
				),

				array(
					'name'     => __( 'Email results', 'wc-quiz' ),
					'type'     => 'checkbox',
					'desc'     => __( 'E-mails can only be send if a email question is included in the quiz', 'wc-quiz' ),
					'id'       => 'fitts_allow_email_product',
					'class'    => 'fitts_allow_email_product',
				),

				array(
					'type' => 'sectionend',
					'id'   => 'fitts_quiz_settigs_title_section_end',
				),
			);
			return apply_filters( 'fitts_quiz_settings', $settings );

		}

    }
    new Fitts_Quiz_Settings();
}