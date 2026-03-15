<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BOLDPO_Blocks {
    public static function instance() {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    public function __construct() {
        add_action( 'init', array( $this, 'register_blocks' ) );
    }

    public function get_blocks() {
        $blocks = [
            [
                'title'       => 'Post Grid',
                'id'        => 'post-grid',
                'description' => 'Post Grid Block',
                'iconName'        => 'grid.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post Grid 2',
                'id'        => 'post-grid-2',
                'description' => 'Post Grid Block',
                'iconName'        => 'grid.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post List',
                'id'        => 'post-list',
                'description' => 'Post List Block',
                'iconName'    => 'list.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post List 2',
                'id'        => 'post-list-2',
                'description' => 'Post List Block',
                'iconName'    => 'list.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post List 3',
                'id'        => 'post-list-3',
                'description' => 'Post List Block',
                'iconName'    => 'list.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post List 4',
                'id'        => 'post-list-4',
                'description' => 'Post List Block',
                'iconName'    => 'list.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post Slider',
                'id'        => 'post-slider',
                'description' => 'Post Slider Block',
                'iconName'        => 'slider.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post Slider 2',
                'id'        => 'post-slider-2',
                'description' => 'Post Slider 2 Block',
                'iconName'        => 'slider.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post Slider 3',
                'id'        => 'post-slider-3',
                'description' => 'Post Slider 3 Block',
                'iconName'        => 'slider.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post Slider 4',
                'id'        => 'post-slider-4',
                'description' => 'Post Slider 4 Block',
                'iconName'        => 'slider.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post Ticker',
                'id'        => 'post-ticker',
                'description' => 'Post Ticker',
                'iconName'        => 'slider.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Category List',
                'id'        => 'category-list',
                'description' => 'Category List Block',
                'iconName'        => 'category.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ]
        ];

        // Merge status from DB
        foreach ($blocks as &$block) {
            $block['status'] = get_option('boldpo_block_' . $block['id'], 'disable');
        }
        unset($block);

        $blocks = apply_filters('boldpost_blocks', $blocks);

        return $blocks;
    }

    public function register_blocks() {
    }


}   