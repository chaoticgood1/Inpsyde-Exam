<?php declare(strict_types=1);
/**
 * Plugin Name: Inpsyde Exam
 * Description: Ways to test skills for qualification
 * Author: Monico Colete
 * Version: 1.0
 * PHP Version 7.2
 *
 * @category Plugin_Inpsyde
 * @package  Plugin_Inpsyde
 * @author   Monico Colete <colete_nico@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/users
 */
require_once plugin_dir_path(__FILE__) . 'Constants.php';

if (defined('IS_AUTOLOADING') && ! IS_AUTOLOADING) {
    require_once plugin_dir_path(__FILE__) . 'vendor/composer/autoload.php';
}

include(INPSYDE_PATH . '/src/Inpsyde.php');

use Inpsyde\Inpsyde;

add_action('plugins_loaded', function () {
    $inpsyde = new Inpsyde();
    $inpsyde->init();
});
