<?php declare(strict_types=1);
namespace Inpsyde;

/**
 * Plugin Name: Inpsyde Exam
 * Description: Ways to test skills for qualification
 * Author: Monico Colete
 * Version: 0.1
/**
 * Implements Exam
 *
 * @category Plugin_Inpsyde
 * @package  Plugin_Inpsyde
 * @author   Monico Colete <colete_nico@yahoo.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     http://localhost/
 */
class Inpsyde
{
    public function init()
    {
        add_filter('template_include', [ $this, 'includeTemplate' ]);
        add_filter('init', [ $this, 'rewriteRules' ]);
        $this->addUsersScript();
    }

    public function includeTemplate(string $template): string
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $request = esc_url_raw($_SERVER['REQUEST_URI']);
            if ($request === "/users") {
                return INPSYDE_PATH . '/src/page/UserPage.php';
            }
        }
        
        return "";
    }

    public function flushRules()
    {
        $this->rewriteRules();
        flush_rewrite_rules();
    }

    public function rewriteRules()
    {
        add_rewrite_rule('account/(.+?)/?$', 'index.php?account_page=$matches[1]', 'top');
        add_rewrite_tag('%account_page%', '([^&]+)');
    }

    public function addUsersScript()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script(
                'users.js',
                plugins_url('inpsyde-exam/js/users.js', INPSYDE_PATH),
                ['jquery'],
                0.1,
                false
            );
        });
    }
}