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

/**
 * Implements Exam
 * 
 * @category Plugin_Main
 * @package  Plugin_Main
 * @author   Monico Colete <colete_nico@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Main
{

    /**
     * Detects the /users endpoint to reroute to intended php file
     * 
     * @return null
     */
    public function detectEndpointForRouting() 
    {
        $request = $_SERVER['REQUEST_URI'];

        error_log(__DIR__);
        if ($request == "/users") {
            include __DIR__ . '/src/users.php';
        }
    }

    public function addUsersScript() {
        add_action('wp_enqueue_scripts', function() {
            wp_enqueue_script('users.js', 
              plugins_url('/js/users.js', __FILE__), array('jquery'),
              WP_VERSION, false);
        });
        // Check if the Javascript is loaded?
    }
}

$main = new Main();
$main->detectEndpointForRouting();
$main->addUsersScript();


/** 
 * TODO:
 * - Create custom Endpoint(Not a REST), it is a simple routing...
 * - Call to REST endpoint to https://jsonplaceholder.typicode.com/users
 * - Parse JSON, build table
 * - Row contains id, name, username, arranged chronologically
 * - (CSS beautify optional)
 * - When clicking on any column, it should show more of user details(Not posts, etc)
 * - Show max one user, reload when clicking on the other
 * - Cache HTTP requests, rationale should be documented in the README 
 * - Error Handling for the external HTTP requests
 * - Navigation shouldn't be disrupted
 * - Update README, in Markdown-formatting explain usage
 * - And decisiions behind the implementation
 * - Inpsyde code style (Use the installed package)
 * - Automated tests
 * - Create LICENSE file
 * - Extra features(Optional)
 * - Unit tests (Use Brain Monkey package)
 * - Other tests (Optional)
 * - Explain installed packages in README
 **/
?>