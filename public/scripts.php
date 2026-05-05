<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'boldpo_enqueue_block_scripts' );
add_action( 'wp_enqueue_scripts', 'boldpo_enqueue_block_scripts' );
function boldpo_enqueue_block_scripts() {
	wp_enqueue_style( 'boldpo-public-style', BOLDPO_PL_URL . 'public/assets/css/public.css', array(), BOLDPO_VERSION );

	if ( ! class_exists( 'BOLDPO_API' ) ) {
		require_once BOLDPO_PL_PATH . 'admin/api.php';
	}

	$colors  = BOLDPO_API::get_saved_colors();
	$css_map = array(
		'primary'    => '--boldpo-preset-color-primary',
		'secondary'  => '--boldpo-preset-color-secondary',
		'tertiary'   => '--boldpo-preset-color-tertiary',
		'white'      => '--boldpo-preset-color-white',
		'contrast_1' => '--boldpo-preset-color-contrast-1',
		'contrast_2' => '--boldpo-preset-color-contrast-2',
		'border'     => '--boldpo-preset-color-border',
	);

	$declarations = '';
	foreach ( $css_map as $key => $var ) {
		if ( ! empty( $colors[ $key ] ) ) {
			$declarations .= $var . ':' . esc_attr( $colors[ $key ] ) . ';';
		}
	}

	if ( $declarations !== '' ) {
		wp_add_inline_style( 'boldpo-public-style', ':root{' . $declarations . '}' );
	}
}
