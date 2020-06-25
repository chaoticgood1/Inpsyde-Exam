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
        // add_filter('init', [ $this, 'rewriteRules' ]);
        $this->addUsersScript();
    }

    /**
     * includes the template for the /users
     * 
     * @since 1.0
     * 
     * @return void
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
