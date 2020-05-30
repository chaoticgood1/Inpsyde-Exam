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


/**
 * Implements Exam
 * 
 * @category Plugin_Inpsyde
 * @package  Plugin_Inpsyde
 * @author   Monico Colete <colete_nico@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Inpsyde
{

    public function init()
    {
        add_filter( 'template_include', array( $this, 'include_template' ) );
        add_filter( 'init', array( $this, 'rewrite_rules' ) );
        $this->addUsersScript();
    }

    public function include_template( $template )
    {
        $request = $_SERVER['REQUEST_URI'];
        if ($request == "/users") {
            return INPSYDE_PATH . '/src/page/UserPage.php';
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
}

add_action('plugins_loaded', array(new Inpsyde, 'init'));

// One time activation functions
register_activation_hook(plugins_url('Inpsyde.php'), array(new Inpsyde, 'flush_rules'));


/** 
 * TODO:
 * - Create custom Endpoint(Not a REST), it is a simple routing... (Done)
 * - Call to REST endpoint to https://jsonplaceholder.typicode.com/users (Done)
 * - Parse JSON, build table (Done)
 * - Row contains id, name, username, arranged chronologically (Done)
 * - (CSS beautify optional)
 * - When clicking on any column, it should show more of user details(Not posts, etc) (Done)
 * - Show max one user, reload when clicking on the other (Done)
 * - Cache HTTP requests, rationale should be documented in the README
 * - Error Handling for the external HTTP requests (Done)
 * - Navigation shouldn't be disrupted (Done)
 * - Update README, in Markdown-formatting explain usage
 * - And decisiions behind the implementation
 * - Inpsyde code style (Use the installed package)
 * - Automated tests
 * - Create LICENSE file
 * - Extra features(Optional)
 * - Unit tests (Use Brain Monkey package) (Dropped the idea, PHPUnit is enough)
 * - Other tests (Optional)
 * - Explain installed packages in README
 * - Load composer autoload in wp-config.php
 **/
?>