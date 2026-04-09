<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function boldpo_create_block_post_grid_3_block_init() {
	// Register block-specific styles manually to be sure
	wp_register_style(
		'boldpo-post-grid-3-style',
		plugins_url( 'build/style-index.css', __FILE__ ),
		array('boldpo-public-style'),
		BOLDPO_PRO_VERSION
	);

	register_block_type( __DIR__ . '/build', array(
		'style'         => 'boldpo-post-grid-3-style',
		'editor_style'  => 'boldpo-post-grid-3-style',
	) );
}
add_action( 'init', 'boldpo_create_block_post_grid_3_block_init' );