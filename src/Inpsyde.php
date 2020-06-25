<?php declare(strict_types=1);
namespace Inpsyde;

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
        
        return $template;
    }

    public function rewriteRules()
    {
        add_rewrite_rule('account/(.+?)/?$', 'index.php?account_page=$matches[1]', 'top');
        add_rewrite_tag('%account_page%', '([^&]+)');
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
