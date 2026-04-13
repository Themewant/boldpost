<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BOLDPO_Block_Editor {
    
    public static function instance() {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    public function __construct() {
        add_action( 'enqueue_block_editor_assets', [$this, 'enqueue_editor_scripts'] );
        add_filter( 'admin_body_class', [$this, 'admin_body_class'] );
    }

    public function enqueue_editor_scripts () {
        $screen = get_current_screen();
        if (!$screen || !$screen->is_block_editor()) {
           return;
        }


        
        $asset_file = include BOLDPO_PL_PATH . 'editor/app/build/index.asset.php';

        wp_enqueue_script(
            'boldpo-block-editor-js',
            BOLDPO_PL_URL . 'editor/app/build/index.js',
            $asset_file['dependencies'],
            $asset_file['version'],
            true
        );

        wp_enqueue_style(
            'boldpo-block-editor-css',
            BOLDPO_PL_URL . 'editor/app/build/index.css',
            array( 'wp-components' ),
            $asset_file['version']
        );

        wp_localize_script(
            'boldpo-block-editor-js',
            'boldpoEditor',
            [
                'plugin_url' => BOLDPO_PL_URL,
                'api_url'    => 'https://themewant.com/greenaura/wp-json/boldpost/v1',
                'nonce'      => wp_create_nonce( 'wp_rest' ),
            ]
        );
    }

    public function admin_body_class( $classes ) {
        global $pagenow;
        if (!$pagenow || 'post.php' !== $pagenow) {
           return $classes;
        }
        $classes .= ' boldpo-block-editor';
        return $classes;
    }

}

BOLDPO_Block_Editor::instance();