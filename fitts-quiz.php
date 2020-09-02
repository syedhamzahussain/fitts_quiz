<?php
/**
 * Plugin Name: Fitts Quiz
 * Description: A custom plugin for Fitts Quiz.
 * Version: 1.0.0
 * Author: Syed Hamza Hussain
 * Author URI: https://1clickhostings.com
 * License: GPL v2 or Later
 * Text Domain: wc-quiz
*/

if ( ! defined( 'ABSPATH' ) ) 
    return;

define( 'FQ_PLUGIN_DIR', __DIR__ );
define( 'FQ_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

require_once FQ_PLUGIN_DIR .'/includes/class-fitts-quiz-settings.php';
require_once FQ_PLUGIN_DIR .'/includes/class-fitts-quiz-cpt.php';
// require_once FQ_PLUGIN_DIR. '/includes/class-fitts-quiz.php';