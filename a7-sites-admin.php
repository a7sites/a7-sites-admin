<?php
/*
Plugin Name: A7 Sites Admin
Description: Personaliza a página de login do WordPress com a identidade visual da A7 Sites.
Version: 2.3
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

class A7_Sites_Admin {
    /**
     * Constructor
     */
    public function __construct() {
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
    private function ensure_assets_directory() {
        $assets_path = A7_SITES_ADMIN_PATH . 'assets/images';
        if (!file_exists($assets_path)) {
            wp_mkdir_p($assets_path);
        }
    }

    /**
     * Enqueue styles
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            'quicksand-font',
            'https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&display=swap',
            [],
            A7_SITES_ADMIN_VERSION
        );
        ?>
        <style type="text/css">
        :root {
            --a7-primary: #571e7a;
            --a7-primary-hover: #300948;
            --a7-text: #333333;
            --a7-background: #ffffff;
            --a7-border: #e2e2e2;
            --a7-shadow: rgba(0, 0, 0, 0.45);
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --a7-text: #ffffff;
                --a7-background: #1a1a1a;
                --a7-border: #333333;
                --a7-shadow: rgba(0, 0, 0, 0.3);
            }
        }

        .login #nav,
        .login #backtoblog,
        #language-switcher,
        .forgetmenot,
        .login h1 {
            display: none !important;
        }

        html {
            background: none !important;
            overflow: hidden;
        }

        body.login {
            background: #f5f5f5 url('<?php echo esc_url(A7_SITES_ADMIN_ASSETS_URL . '/bg.png'); ?>') repeat center center fixed !important;
            font-family: 'Quicksand', sans-serif !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--a7-text);
            position: relative;
            padding: 40px 20px;
            overflow: hidden;
            max-height: 100vh;
            box-sizing: border-box;
        }

        #login {
            width: 100%;
            padding: 0;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .a7sites-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            padding: 40px;
            flex-wrap: wrap;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            box-sizing: border-box;
        }

        .a7sites-logo {
            width: 400px;
            max-width: 100%;
            text-align: center;
        }

        .a7sites-logo img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            transition: transform 0.3s ease;
        }

        .a7sites-logo img:hover {
            transform: scale(1.02);
        }

        .a7sites-form-container {
            width: 350px;
            max-width: 100%;
        }

        .a7sites-form-container form {
            background: var(--a7-background);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px var(--a7-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #810e9e;
        }

        .a7sites-form-container form:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 25px var(--a7-shadow);
            border-color: #f5f5f5;
        }

        .a7sites-form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: var(--a7-text);
            font-size: 24px;
        }

        .a7sites-form-container label {
            display: none !important;
        }

        .a7sites-form-container input[type="text"],
        .a7sites-form-container input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            border-radius: 20px;
            border: 2px solid var(--a7-border);
            margin-bottom: 20px;
            font-size: 16px;
            font-family: 'Quicksand', sans-serif;
            background: var(--a7-background);
            color: #413c3c;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .a7sites-form-container input[type="text"]::placeholder,
        .a7sites-form-container input[type="password"]::placeholder {
            color: #666 !important;
            font-size: 18px;
            font-family: 'Quicksand', sans-serif;
            padding-left: 20px;
            font-weight: 500 !important;
            opacity: 1 !important;
        }

        /* Adicionando suporte para navegadores mais antigos */
        .a7sites-form-container input[type="text"]::-webkit-input-placeholder,
        .a7sites-form-container input[type="password"]::-webkit-input-placeholder {
            color: #666 !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            opacity: 1 !important;
        }

        .a7sites-form-container input[type="text"]::-moz-placeholder,
        .a7sites-form-container input[type="password"]::-moz-placeholder {
            color: #666 !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            opacity: 1 !important;
        }

        .a7sites-form-container input[type="text"]:-ms-input-placeholder,
        .a7sites-form-container input[type="password"]:-ms-input-placeholder {
            color: #666 !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            opacity: 1 !important;
        }

        .a7sites-form-container input:focus {
            border-color: var(--a7-primary);
            box-shadow: 0 0 0 3px rgba(87, 30, 122, 0.1);
            outline: none;
        }

        .wp-core-ui .button-primary {
            width: 100% !important;
            border-radius: 50px !important;
            padding: 8px 0 !important;
            font-size: 18px !important;
            background-color: var(--a7-primary) !important;
            border: none !important;
            color: #fff !important;
            transition: all 0.3s ease;
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;
            cursor: pointer;
        }

        .wp-core-ui .button-primary:hover {
            background-color: var(--a7-primary-hover) !important;
            transform: translateY(-1px);
        }

        .a7sites-footer-link {
            text-align: center;
            width: 100%;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(87, 30, 122, 0.1);
        }

        .a7sites-footer-link a {
            color: var(--a7-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 14px;
            opacity: 0.8;
        }

        .a7sites-footer-link a:hover {
            color: var(--a7-primary-hover);
            text-decoration: none;
            opacity: 1;
        }

        @media (max-width: 768px) {
            body.login {
                padding: 20px;
            }

            .a7sites-container {
                gap: 30px;
                padding: 30px 20px;
            }

            .a7sites-logo {
                width: 300px;
            }

            .a7sites-form-container {
                width: 100%;
                max-width: 350px;
            }

            .a7sites-footer-link {
                margin-top: 20px;
                padding-top: 15px;
            }
        }
        </style>
        <?php
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
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
    public function custom_layout() {
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
    public function footer_content() {
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