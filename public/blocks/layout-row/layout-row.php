<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function boldpo_create_block_layout_row_block_init() {
    wp_register_style(
        'boldpo-layout-row-style',
        plugins_url( 'build/style-index.css', __FILE__ ),
        array( 'boldpo-public-style' ),
        BOLDPO_VERSION
    );

    register_block_type( __DIR__ . '/build', array(
        'style'        => 'boldpo-layout-row-style',
        'editor_style' => 'boldpo-layout-row-style',
    ) );
}
add_action( 'init', 'boldpo_create_block_layout_row_block_init' );
