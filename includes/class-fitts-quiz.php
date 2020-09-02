<?php
/**
 * Main File For The Frontend stuff.
 * 
 * @package fitts-plugin
 * @since Date: 8-25-2020
 */

if ( ! defined('ABSPATH') ) 
	return;

if ( ! class_exists( 'Fitts_Quiz' ) ) {

	/**
	 * Main Class For Fitts Quiz.
	 */
	class Fitts_Quiz {

		/**
		 * Constructor Function.
		 */
		public function __construct() {

			// add_shortcode( "fitts_plugin", [ $this, 'fitts_plugin_shortcode' ] );

		}

		/**
		 * Constructor Function.
		 */
		public function fitts_plugin_shortcode() {


        }

	}
}
new Fitts_Quiz();