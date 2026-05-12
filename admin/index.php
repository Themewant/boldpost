<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BOLDPO_Admin {
    public static function instance() {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10, 1 );
        add_action( 'enqueue_block_editor_assets', array( $this, 'editor_overrides' ) );
    }



    public function enqueue_scripts($hook) {
       

        $asset_file = include BOLDPO_PL_PATH . 'admin/app/build/index.asset.php';

        $deps = array_map(function($dep) {
            return match($dep) {
                'react', 'react-dom', 'react-jsx-runtime' => 'wp-element',
                'wp-scripts' => 'wp-scripts',
                default => $dep,
            };
        }, $asset_file['dependencies']);

        wp_enqueue_style(
            'boldpo-admin-css',
            BOLDPO_PL_URL . 'admin/app/build/style-index.css',
            [],
            $asset_file['version']
        );

        if ($hook !== 'toplevel_page_boldpost') {
            return;
        }

        wp_enqueue_script(
            'boldpo-admin-js',
            BOLDPO_PL_URL . 'admin/app/build/index.js',
            $deps,
            $asset_file['version'],
            true
        );

        
        $blocks = BOLDPO_Blocks::instance()->get_blocks();
        $is_pro_installed = class_exists( 'BOLDPO_LICENSE' );
        $is_pro_active = $is_pro_installed
            ? (bool) BOLDPO_LICENSE::instance()->is_license_active()
            : false;

        $template_count = wp_count_posts( 'boldpo-template' );
        $total_templates = isset( $template_count->publish ) ? (int) $template_count->publish : 0;

        wp_localize_script( 'boldpo-admin-js', 'boldpo', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'siteUrl' => site_url(),
            'rest_url' => esc_url_raw(rest_url('boldpo/v1/')),
            'nonce' => wp_create_nonce('wp_rest'),
            'blocks' => $blocks,
            'boldpoUrl' => BOLDPO_PL_URL,
            'boldpoPath' => BOLDPO_PL_PATH,
            'isProActive' => $is_pro_active,
            'isProInstalled' => $is_pro_installed,
            'templateCount' => $total_templates,
            'templateLimit' => $is_pro_active ? -1 : 3,
            'proUrl' => 'https://themewant.com/downloads/boldpost-pro',
            'colors' => BOLDPO_API::get_saved_colors(),
            'colorDefaults' => BOLDPO_API::get_color_defaults(),
            'license' => array(
                'key'    => (string) get_option( 'boldpo_license_key', '' ),
                'status' => (string) get_option( 'boldpo_license_status', '' ),
            ),
        ) );
    }

    public function editor_overrides() {
        $screen = get_current_screen();
        if ( ! $screen || $screen->post_type !== 'boldpo-template' ) {
            return;
        }

        $template_page_url = admin_url( 'admin.php?page=boldpost' );

        wp_add_inline_script( 'wp-edit-post', "
            (function() {
                var url = " . wp_json_encode( $template_page_url ) . ";
                function updateLink() {
                    var link = document.querySelector('a.edit-post-fullscreen-mode-close');
                    if (link && link.getAttribute('href') !== url) {
                        link.setAttribute('href', url);
                    }
                }
                var observer = new MutationObserver(updateLink);
                observer.observe(document.body, { childList: true, subtree: true });
                updateLink();
            })();
        " );
    }

}

BOLDPO_Admin::instance();