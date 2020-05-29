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

require(__DIR__ . "/src/users.php");
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

    public function init()
    {
        add_filter( 'template_include', array( $this, 'include_template' ) );
        add_filter( 'init', array( $this, 'rewrite_rules' ) );
        $this->addUsersScript();
        $this->addAPIForUsername();
    }

    public function include_template( $template )
    {
        $request = $_SERVER['REQUEST_URI'];
        if ($request == "/users") {
            return __DIR__ . '/src/page/users-page.php';
        }
    }

    public function flush_rules()
    {
        $this->rewrite_rules();
        flush_rewrite_rules();
    }

    public function rewrite_rules()
    {
        add_rewrite_rule( 'account/(.+?)/?$', 'index.php?account_page=$matches[1]', 'top');
        add_rewrite_tag( '%account_page%', '([^&]+)' );
    }

    public function addUsersScript() {
        add_action('wp_enqueue_scripts', function() {
            wp_enqueue_script('users.js', 
              plugins_url('/js/users.js', __FILE__), array('jquery'),
              0.1, false);
        });
        // TODO: Check if the Javascript is loaded?
    }

    public function addAPIForUsername() {
        error_log(Users::USERS_API);
        // register_rest_route('events/', '/blog', array(
        //     'methods' => 'GET',
        //     'callback' => 'musesquare_events_blog',
        //     'args' => [
        //       'url'
        //     ]
        // ));
    }
}


add_action('plugins_loaded', array(new Main, 'init'));

// One time activation functions
register_activation_hook(plugins_url('inpsyde.php'), array(new Main, 'flush_rules'));


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