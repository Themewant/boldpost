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
                'title'       => 'Post Grid 3',
                'id'        => 'post-grid-3',
                'description' => 'Post Grid Block',
                'iconName'        => 'grid.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post Grid 4',
                'id'        => 'post-grid-4',
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
                'iconName'        => 'post-ticker.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Post Ticker 2',
                'id'        => 'post-ticker-2',
                'description' => 'Post Ticker 2',
                'iconName'        => 'post-ticker-2.svg',
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
            ],
            [
                'title'       => 'Heading',
                'id'        => 'heading',
                'description' => 'Heading Block',
                'iconName'        => 'heading.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Social Icons',
                'id'          => 'social-icons',
                'description' => 'Social Icons Block',
                'iconName'    => 'social-icons.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Button',
                'id'          => 'button',
                'description' => 'Button Block',
                'iconName'    => 'button.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Info Box',
                'id'          => 'info-box',
                'description' => 'Info Box Block',
                'iconName'    => 'info-box.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Row',
                'id'          => 'layout-row',
                'description' => 'Flexible row/section container holding columns.',
                'iconName'    => 'grid.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
            [
                'title'       => 'Column',
                'id'          => 'column',
                'description' => 'Child column inside a BoldPost Row.',
                'iconName'    => 'grid.svg',
                'status'      => 'enable',
                "isPro"       => false,
            ],
        ];

        // Default-enabled IDs: any block we want available without the user toggling it on first.
        $default_enabled = [ 'layout-row', 'column' ];

        // Merge status from DB
        foreach ($blocks as &$block) {
            $default = in_array( $block['id'], $default_enabled, true ) ? 'enable' : 'disable';
            $block['status'] = get_option('boldpo_block_' . $block['id'], $default);
        }
        unset($block);

        $blocks = apply_filters('boldpost_blocks', $blocks);

        return $blocks;
    }

    public function register_blocks() {
    }


}   