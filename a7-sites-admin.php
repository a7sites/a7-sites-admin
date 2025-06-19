<?php
/*
Plugin Name: A7 Sites Admin
Description: Personaliza a página de login do WordPress com a identidade visual da A7 Sites.
Version: 2.4
Author: A7 Sites
Author URI: https://a7site.com.br
Text Domain: a7-sites-admin
*/

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

// Define plugin constants
define('A7_SITES_ADMIN_VERSION', '2.3');
define('A7_SITES_ADMIN_URL', 'https://a7site.com.br');
define('A7_SITES_ADMIN_PATH', plugin_dir_path(__FILE__));
define('A7_SITES_ADMIN_ASSETS_URL', plugin_dir_url(__FILE__) . 'assets/images');

class A7_Sites_Admin
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Ensure assets directory exists
        $this->ensure_assets_directory();

        add_action('login_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('login_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('login_header', [$this, 'custom_layout'], 1);
        add_action('login_footer', [$this, 'footer_content']);
        add_filter('login_headerurl', [$this, 'header_url']);
        add_filter('login_headertext', [$this, 'header_text']);
    }

    /**
     * Ensure assets directory exists
     */
    private function ensure_assets_directory()
    {
        $assets_path = A7_SITES_ADMIN_PATH . 'assets/images';
        if (!file_exists($assets_path)) {
            wp_mkdir_p($assets_path);
        }
    }

    /**
     * Enqueue styles
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'quicksand-font',
            'https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&display=swap',
            [],
            A7_SITES_ADMIN_VERSION
        );
        wp_enqueue_style(
            'a7-sites-admin-login',
            plugin_dir_url(__FILE__) . 'assets/css/a7-sites-admin-login.css',
            ['quicksand-font'],
            A7_SITES_ADMIN_VERSION
        );
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts()
    {
?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                // Placeholder setup
                const userInput = document.getElementById('user_login');
                const passInput = document.getElementById('user_pass');
                if (userInput) userInput.placeholder = 'Usuário';
                if (passInput) passInput.placeholder = 'Senha';

                // Form title
                const loginForm = document.querySelector('#loginform');
                if (loginForm) {
                    const title = document.createElement('h2');
                    title.textContent = 'Administração do Usuário';
                    loginForm.insertBefore(title, loginForm.firstChild);
                }

                // Add loading state to button on submit
                if (loginForm) {
                    loginForm.addEventListener('submit', function() {
                        const submitButton = this.querySelector('.button-primary');
                        if (submitButton) {
                            submitButton.value = 'Entrando...';
                            submitButton.style.opacity = '0.7';
                        }
                    });
                }
            });
        </script>
    <?php
    }

    /**
     * Custom layout for login page
     */
    public function custom_layout()
    {
    ?>
        <div class="a7sites-container">
            <div class="a7sites-logo">
                <img src="<?php echo esc_url(A7_SITES_ADMIN_ASSETS_URL . '/a7site.svg'); ?>" alt="A7 Sites">
            </div>
            <div class="a7sites-form-container">
            <?php
        }

        /**
         * Footer content
         */
        public function footer_content()
        {
            ?>
            </div>
            <div class="a7sites-footer-link">
                <a href="<?php echo esc_url(A7_SITES_ADMIN_URL); ?>" target="_blank" rel="noopener noreferrer">
                    Precisa de ajuda? Visite nosso site
                </a>
            </div>
        </div>
<?php
        }

        /**
         * Custom header URL
         */
        public function header_url()
        {
            return A7_SITES_ADMIN_URL;
        }

        /**
         * Custom header text
         */
        public function header_text()
        {
            return esc_html__('A7 Sites - O futuro da sua marca começa aqui', 'a7-sites-admin');
        }
    }

<<<<<<< HEAD
    // Initialize the plugin
    new A7_Sites_Admin();
=======
    /**
     * Custom header URL
     */
    public function header_url() {
        return A7_SITES_ADMIN_URL;
    }

    /**
     * Custom header text
     */
    public function header_text() {
        return esc_html__('A7 Sites - O futuro da sua marca começa aqui', 'a7-sites-admin');
    }
}

// Initialize the plugin
new A7_Sites_Admin();
>>>>>>> df9db7e4a093fb8254912c111508376d0833a528
