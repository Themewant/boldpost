<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BOLDPO_Elementor {
    public static function instance() {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    public function __construct() {
        add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
    }

    public function register_category( $elements_manager ) {
        $elements_manager->add_category(
            'boldpost',
            array(
                'title' => 'BoldPost',
                'icon'  => 'eicon-posts-grid',
            )
        );
    }

    public function register_widgets( $widgets_manager ) {
        require_once __DIR__ . '/widget-template.php';
        $widgets_manager->register( new BOLDPO_Elementor_Template_Widget() );
    }
}

BOLDPO_Elementor::instance();
