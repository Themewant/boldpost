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
        wp_localize_script( 'boldpo-admin-js', 'boldpo', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'siteUrl' => site_url(),
            'rest_url' => esc_url_raw(rest_url('boldpo/v1/')),
            'nonce' => wp_create_nonce('wp_rest'),
            'blocks' => $blocks,
            'boldpoUrl' => BOLDPO_PL_URL,
            'boldpoPath' => BOLDPO_PL_PATH,
        ) );
    }

}

BOLDPO_Admin::instance();