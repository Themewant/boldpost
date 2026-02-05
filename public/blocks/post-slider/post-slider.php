<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function boldpo_create_block_post_slider_block_init() {
	// Register block-specific styles manually to be sure
	wp_register_style(
		'boldpo-post-slider-style',
		plugins_url( 'build/style-index.css', __FILE__ ),
		array('boldpo-public-style'),
		BOLDPO_VERSION
	);

	register_block_type( __DIR__ . '/build', array(
		'style'         => 'boldpo-post-slider-style',
		'editor_style'  => 'boldpo-post-slider-style',
	) );
}
add_action( 'init', 'boldpo_create_block_post_slider_block_init' );