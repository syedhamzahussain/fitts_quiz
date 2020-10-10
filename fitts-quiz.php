<?php
/**
 * Plugin Name: Fitts Quiz
 * Description: Custom WooCommerce product recommendations.
 * Version: 1.1.0
 * Author: GC
 * License: GPL v2 or Later
 * Text Domain: wc-quiz
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

define( 'FQ_PLUGIN_DIR', __DIR__ );
define( 'FQ_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

require FQ_PLUGIN_DIR . '/includes/class-fitts-quiz-settings.php';
require FQ_PLUGIN_DIR . '/includes/class-fitts-quiz-cpt.php';
require FQ_PLUGIN_DIR . '/includes/class-fitts-quiz.php';
require FQ_PLUGIN_DIR . '/includes/fitts-quiz-function.php';
