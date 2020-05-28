<?php
/**
 * Plugin Name: Inpsyde Exam
 * Description: Ways to test skills for qualification
 * Author: Monico Colete
 * Version: 0.1
 */

require_once __DIR__ . "/router.php";


/**
 * Currently router detector
 */
class Main
{

    public function detectEndpointForRouting() 
    {
        $request = $_SERVER['REQUEST_URI'];
        if ($request == "/users") {
            include __DIR__ . '/users.php';
        }
    }
}

$main = new Main();
$main->detectEndpointForRouting();

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