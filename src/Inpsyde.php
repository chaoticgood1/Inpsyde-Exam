<?php declare(strict_types=1);
namespace Inpsyde;

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

    /**
     * Adds the necessary filters and adds the users.js
     *
     * @since 1.0
     *
     * @return void
     */
    public function init()
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
                plugins_url('../js/users.js', __FILE__),
                ['jquery'],
                0.1,
                false
            );
        });
    }
}
