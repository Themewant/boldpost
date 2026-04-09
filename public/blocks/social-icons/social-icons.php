<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function boldpo_create_block_social_icons_block_init() {
	wp_register_style(
		'boldpo-social-icons-style',
		plugins_url( 'build/style-index.css', __FILE__ ),
		array( 'boldpo-public-style' ),
		BOLDPO_VERSION
	);

	register_block_type( __DIR__ . '/build', array(
		'style'        => 'boldpo-social-icons-style',
		'editor_style' => 'boldpo-social-icons-style',
	) );
}
add_action( 'init', 'boldpo_create_block_social_icons_block_init' );
