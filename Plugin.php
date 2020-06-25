<?php declare(strict_types=1);
/**
 * Plugin Name: Inpsyde Exam
 * Description: Ways to test skills for qualification
 * Author: Monico Colete
 * Version: 1.0
 * PHP Version 7.2
 *
 * @category  Plugin_Inpsyde
 * @package   Plugin_Inpsyde
 * @author    Monico Colete <colete_nico@yahoo.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://homeurl/users
 */

require "vendor/autoload.php";

use Inpsyde\Inpsyde;

add_action('plugins_loaded', function () {
    $inpsyde = new Inpsyde();
    $inpsyde->init();
});

/** TODO */
// Rethinking the solutions
// #phpDoc: 
//  - Put documentation to all classess and functions
// #use WordPress API, not 3rd Party like Guzzle: Replace
//  - Remove all Guzzle instances
//  - Remove in composer
//  - Find a way to implement HTTP caching in WP API
//  - I think it is automated, but have to find a explicit way to do it
// #Unit Tests, no User Tests
//  - Should I add more unit tests?
//  - I think what I did was not a Unit Tests?
//  - What does "no User Tests" mean?
// Ask for clarification, faster than guessing
