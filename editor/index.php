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
    }

    public function enqueue_editor_scripts () {
        $screen = get_current_screen();
        if (!$screen || !$screen->is_block_editor()) {
           return;
        }
        wp_enqueue_script(
            'boldpo-block-editor-js',
            BOLDPO_PL_URL . 'editor/app/build/index.js',
            ['wp-element', 'wp-hooks', 'wp-blocks'],
            BOLDPO_VERSION,
            true
        );
    }

}

BOLDPO_Block_Editor::instance();