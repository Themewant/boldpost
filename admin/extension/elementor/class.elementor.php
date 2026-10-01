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
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_panel_script' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
    }

    /**
     * Loads the widget panel behaviour in the Elementor editor.
     *
     * This used to be a <script> embedded in a Controls_Manager::RAW_HTML value.
     * The admin URL the script needs is localized rather than interpolated into
     * the JavaScript.
     *
     * @return void
     */
    public function enqueue_panel_script() {

        wp_enqueue_script(
            'boldpo-elementor-panel',
            BOLDPO_PL_URL . 'admin/extension/assets/boldpo-elementor-panel.js',
            array(),
            BOLDPO_VERSION,
            true
        );

        wp_localize_script(
            'boldpo-elementor-panel',
            'boldpoElementorPanel',
            array( 'editUrl' => esc_url_raw( admin_url( 'post.php' ) ) )
        );
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
