<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;

}

require_once BOLDPO_PL_PATH . 'admin/blocks.php';

add_action( 'enqueue_block_editor_assets', 'boldpo_enqueue_block_styles' );
add_action( 'enqueue_block_assets', 'boldpo_enqueue_block_styles' );
function boldpo_enqueue_block_styles() {
	

    // if swier not existing
	//if (!wp_style_is('swiper-css', 'enqueued')) { 
		wp_enqueue_style( 'swiper-css', BOLDPO_PL_URL . 'assets/lib/swiper/swiper-bundle.min.css', array(), BOLDPO_VERSION, 'all' ); 
	//}
	//if (!wp_script_is('swiper-js', 'enqueued')) { 
		wp_enqueue_script( 'swiper-js', BOLDPO_PL_URL . 'assets/lib/swiper/swiper-bundle.min.js', array(),'12.0.3',false ); 
	//}

	// enqueue bootstrap grid
	wp_enqueue_style( 'boldpo-bootstrap-grid', BOLDPO_PL_URL . 'assets/lib/bootstrap/bootstrap-grid.min.css', array(), BOLDPO_VERSION, 'all' );

    // register plugin style if not registered	
	if (!wp_style_is('boldpo-public-style', 'registered')) {
		wp_register_style( 
			'boldpo-public-style', 
			BOLDPO_PL_URL . 'public/assets/css/public.css', 
			array(), 
			BOLDPO_VERSION 
		);
	}

    
}

$boldpo_blocks_instance = BOLDPO_Blocks::instance();
$boldpo_blocks = $boldpo_blocks_instance->get_blocks();

foreach ($boldpo_blocks as $boldpo_block) {
	if ($boldpo_block['status'] == 'disable') {
		continue;
	}
	require_once __DIR__ . '/' . $boldpo_block['id'] . '/' . $boldpo_block['id'] . '.php';
}
