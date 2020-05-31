<?php
/**
 * Plugin Name: Inpsyde Exam
 * Description: Ways to test skills for qualification
 * Author: Monico Colete
 * Version: 0.1
 * PHP Version 7.2
 * 
 * @category Plugin_Inpsyde
 * @package  Plugin_Inpsyde
 * @author   Monico Colete <colete_nico@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

define('INPSYDE_PATH', plugin_dir_path(__FILE__));

include(INPSYDE_PATH . '/src/Inpsyde.php');

use Inpsyde\Inpsyde;

add_action('plugins_loaded', array(new Inpsyde, 'init'));

// One time activation functions
register_activation_hook(plugins_url('/src/Inpsyde.php'), array(new Inpsyde, 'flush_rules'));