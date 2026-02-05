<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function boldpo_create_block_category_list_block_init() {
	// Register block-specific styles
	wp_register_style(
		'boldpo-category-list-style',
		plugins_url( 'build/style-index.css', __FILE__ ),
		array('boldpo-public-style'),
		BOLDPO_VERSION
	);

	register_block_type( __DIR__ . '/build', array(
		'style'         => 'boldpo-category-list-style',
		'editor_style'  => 'boldpo-category-list-style',
	) );
}
add_action( 'init', 'boldpo_create_block_category_list_block_init' );
