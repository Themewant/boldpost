<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function boldpo_create_block_column_block_init() {
    wp_register_style(
        'boldpo-column-style',
        plugins_url( 'build/style-index.css', __FILE__ ),
        array( 'boldpo-public-style' ),
        BOLDPO_VERSION
    );

    register_block_type( __DIR__ . '/build', array(
        'style'        => 'boldpo-column-style',
        'editor_style' => 'boldpo-column-style',
    ) );
}
add_action( 'init', 'boldpo_create_block_column_block_init' );
