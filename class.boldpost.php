<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BOLDPO_Main {
    public static function instance() {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    public function init() {
        // Initialize the plugin
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_menu', array( $this, 'add_menu' ) );
        add_filter( 'plugin_action_links_' . BOLDPO_PLUGIN_BASE, array( $this, 'plugin_action_links' ), 10, 4 );
        $this->includes();
    }

    public function register_settings() {
        register_setting( 'boldpo_settings', 'boldpo_version', 'sanitize_text_field' );
    }

    public function includes() {
        require_once BOLDPO_PL_PATH . 'public/class.helper.php';
        require_once BOLDPO_PL_PATH . 'admin/extension/class.category.php';
        require_once BOLDPO_PL_PATH . 'admin/api.php';
        require_once BOLDPO_PL_PATH . 'admin/blocks.php';
        require_once BOLDPO_PL_PATH . 'editor/featured-posts.php';
        require_once BOLDPO_PL_PATH . 'editor/video.php';
        require_once BOLDPO_PL_PATH . 'admin/index.php';
        require_once BOLDPO_PL_PATH . 'public/scripts.php';

        // Elementor integration
        if ( did_action( 'elementor/loaded' ) ) {
            require_once BOLDPO_PL_PATH . 'admin/extension/elementor/class.elementor.php';
        }
    }

    public function add_menu() {
        add_menu_page(
            'BoldPost',
            'BoldPost',
            'manage_options',
            'boldpost',
            array( $this, 'render_menu_page' ),
            BOLDPO_PL_URL . 'public/assets/img/icons/plugin-icon-18_18.svg', // image icon
            26
        );
    }

    public function render_menu_page() {
        echo '<div class="boldpo-options-wrap">';
        echo '<div id="boldpo-dashboard"></div>';
        echo '</div>';
    }

    public function render_blocks_page() {
        echo '<div class="boldpo-options-wrap">';
        echo '<div id="boldpo-blocks">BoldPost Blocks</div>';
        echo '</div>';
    }

    public static function activate() {
        update_option( 'boldpo_version', BOLDPO_VERSION );

        // enable all blocks 
        $blocks = BOLDPO_Blocks::instance()->get_blocks();
        foreach ( $blocks as $block ) {
            // update option if option not exist
            if (!get_option('boldpo_block_' . $block['id'])) {
                update_option('boldpo_block_' . $block['id'], 'enable');
            }
        }
    }

    public static function deactivate() {
        delete_option( 'boldpo_version' );
    }

    public function plugin_action_links( $plugin_actions, $plugin_file, $plugin_data, $context ) {

		$new_actions = array();
		/* translators: 1: Settings Text */
		$new_actions['boldpost_plugin_actions_setting'] = sprintf( __( '<a href="%s" target="_self">Settings</a>', 'boldpost' ), esc_url( admin_url( 'admin.php?page=boldpost' ) ) );
		
		/* translators: 1: Upgrade to pro text. */
		$new_actions['boldpost_plugin_actions_upgrade'] = sprintf( __( '<a href="%s" style="color: #39b54a; font-weight: bold;"  target="_blank">Upgrade to Pro</a>', 'boldpost' ), esc_url( 'https://themewant.com/downloads/boldpost-pro/' ) );
		return array_merge( $new_actions, $plugin_actions );

	}
}