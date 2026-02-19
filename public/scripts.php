<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'boldpo_enqueue_block_scripts' );
add_action( 'wp_enqueue_scripts', 'boldpo_enqueue_block_scripts' );
function boldpo_enqueue_block_scripts() {
	wp_enqueue_style( 'boldpo-public-style', BOLDPO_PL_URL . 'public/assets/css/public.css', array(), BOLDPO_VERSION );
}