<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function boldpo_create_block_heading_block_init() {
	// Register block-specific styles
	wp_register_style(
		'boldpo-heading-style',
		plugins_url( 'build/style-index.css', __FILE__ ),
		array('boldpo-public-style'),
		BOLDPO_VERSION
	);

	register_block_type( __DIR__ . '/build', array(
		'style'         => 'boldpo-heading-style',
		'editor_style'  => 'boldpo-heading-style',
	) );
}
add_action( 'init', 'boldpo_create_block_heading_block_init' );
