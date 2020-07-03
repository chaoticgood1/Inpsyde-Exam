<?php declare(strict_types=1);
namespace InpsydeExam;

/**
 * Plugin Name: Inpsyde Exam
 * Description: Ways to test skills for qualification
 * Author: Monico Colete
 * Version: 1.0
 * PHP Version 7.2
 *
 * @category  InpsydeExam
 * @package   InpsydeExam
 * @author    Monico Colete <colete_nico@yahoo.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://homeurl/users
 */

/**
 * Manages how the files required to run /users path
 *
 * @since 1.0
 *
 * @package   Inpsyde
 * @author    Monico Colete <colete_nico@yahoo.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */
class Inpsyde
{
    public function __construct()
    {
        add_action('plugins_loaded', [ $this, 'pluginLoaded' ]);
    }

    /**
     * Adds the necessary filters and adds the users.js
     *
     * @since 1.0
     *
     * @return void
     */
    public function pluginLoaded(): void
    {
        add_filter('template_include', [ $this, 'includeTemplate' ]);
        $this->addUsersScript();
    }
        
    /**
     * Includes the template for the /users
     *
     * @param  mixed $template Default template
     * @return string Template to show, will be UserPage.php if the path is /users
     */
    public function includeTemplate(string $template): string
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $request = esc_url_raw($_SERVER['REQUEST_URI']);
            error_log($request);
            if ($request === "/users") {
                return INPSYDE_PATH . '/src/page/UserPage.php';
            }
        }
        
        return $template;
    }

    /**
     * Adds the scripts to show the users on the front-end
     *
     * @since 1.0
     *
     * @return void
     */
    private function addUsersScript()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script(
                'users.js',
                plugins_url('/js/users.js', __FILE__),
                ['jquery'],
                0.1,
                false
            );
        });
    }
    
}

$inpsyde = new Inpsyde();
