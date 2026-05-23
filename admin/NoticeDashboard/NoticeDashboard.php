<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'BOLDPO_NOTICE_SOURCE_URL' ) ) {
    define( 'BOLDPO_NOTICE_SOURCE_URL', 'https://reactheme.com/products/license/' );
}

class BOLDPO_NoticeDashboard {

    /**
     * Slug this plugin identifies itself as when calling the notice API.
     * Each consuming plugin MUST set its own slug here — using a global
     * constant breaks when multiple notice-consuming plugins are activated
     * (the first one to load wins, and others request notices for the
     * wrong slug).
     */
    const PLUGIN_SLUG = 'boldpost';

    /**
     * Display names for known plugin slugs. Used as a fallback when the
     * API response doesn't include a sub_title — we derive the name from
     * whichever plugin is currently consuming this NoticeDashboard.
     */
    private static $plugin_slug_titles = array(
        'boldpost'                  => 'boldpost',
        'easy-bookmark'             => 'Easy bookmark',
        'easy-currency'             => 'Easy Currency',
        'easy-elements'             => 'Easy Elements',
        'easy-hotel'                => 'easy hotel',
        'easy-menu-icons'           => 'easy menu icons',
        'easy-wishlist'             => 'easy wishlist',
        'themewant-product-gallery' => 'Easy Product Gallery',
        'rt-mega-menu'              => 'RT Mega Menu',
    );

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'admin_notices', array( $this, 'BOLDPO_notice_add_to_notice_bar' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'BOLDPO_notice_add_to_dashboard_widget' ), 9999 );
        add_action( 'wp_ajax_BOLDPO_notice_ignore_plugin_notice', array( $this, 'BOLDPO_notice_ignore_plugin_notice' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'BOLDPO_notice_enqueue_widget_assets' ) );
    }

    /**
     * Load CSS on every admin page so notice-bar (which can render
     * anywhere) is styled correctly. Dashboard widget styles are also
     * included in the same file — harmless on non-dashboard pages.
     */
    public function BOLDPO_notice_enqueue_widget_assets( $hook ) {
        wp_register_style(
            'boldpo-notice-admin-style',
            BOLDPO_DIR_URL . 'admin/NoticeDashboard/notice.css',
            array( 'dashicons' ),
            BOLDPO_VERSION
        );
        wp_enqueue_style( 'boldpo-notice-admin-style' );

        wp_register_script(
            'boldpo-notice-admin-script',
            BOLDPO_DIR_URL . 'admin/NoticeDashboard/notice.js',
            array( 'jquery' ),
            BOLDPO_VERSION,
            true
        );
        wp_localize_script( 'boldpo-notice-admin-script', 'BOLDPONoticeData', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'BOLDPO_notice_nonce' ),
        ) );
        wp_enqueue_script( 'boldpo-notice-admin-script' );
    }

    public function BOLDPO_notice_ignore_plugin_notice() {

        $user_id = get_current_user_id();

        check_ajax_referer( 'BOLDPO_notice_nonce', 'nonce' );

        if ( isset( $_POST['notice_id'] ) && ! empty( $_POST['notice_id'] ) ) {

            $notice_id = sanitize_text_field( wp_unslash( $_POST['notice_id'] ) );

            // NOTE: user_meta key kept as `thewtmc_notice_ignore_*` for
            // backward compatibility with previously dismissed notices.
            if ( $user_id && ! get_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id, true ) ) {
                add_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id, 'true', true );
            } else {
                update_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id, 'true' );
            }

            wp_send_json_success();
        }

        wp_die();
    }

    public function get_notice_status( $notice_id ) {
        $user_id = get_current_user_id();
        return get_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id, true );
    }

    /**
     * Return the display name for the currently consuming plugin (based on
     * PLUGIN_SLUG). Empty string if the slug isn't in the known list.
     */
    public function get_active_plugin_display_name() {
        if ( isset( self::$plugin_slug_titles[ self::PLUGIN_SLUG ] ) ) {
            return self::$plugin_slug_titles[ self::PLUGIN_SLUG ];
        }
        return '';
    }

    /**
     * Fetch notices from the central source. Always tags requests with this
     * plugin's own slug so the API returns global + plugin-targeted notices.
     */
    public function BOLDPO_notice_get_notices( $args = array() ) {

        if ( empty( $args['plugin'] ) ) {
            $args['plugin'] = self::PLUGIN_SLUG;
        }

        // API endpoint path stays as `/get_thewtmc` because it's the server
        // contract; renaming it would break the connection to the API.
        $notice_source_url = trailingslashit( BOLDPO_NOTICE_SOURCE_URL ) . 'wp-json/reacthemes/v1/get_thewtmc';

        $response = wp_remote_post(
            $notice_source_url,
            array(
                'headers'     => array( 'Content-Type' => 'application/json' ),
                'timeout'     => 30,
                'redirection' => 5,
                'blocking'    => true,
                'sslverify'   => false,
                'data_format' => 'body',
                'body'        => wp_json_encode( $args ),
            )
        );

        if ( is_wp_error( $response ) ) {
            return '';
        }

        return wp_remote_retrieve_body( $response );
    }

    public function expire_notice_by_date( $notice_id, $expire_timestamp ) {

        $today_date      = gmdate( 'Y-m-d' );
        $today_timestamp = strtotime( $today_date );

        if ( $today_timestamp >= $expire_timestamp ) {
            $user_id = get_current_user_id();
            delete_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id );
        }
    }

    public function BOLDPO_notice_add_to_notice_bar() {

        $args = array( 'screen' => 'notice-bar' );

        $all_notice = $this->BOLDPO_notice_get_notices( $args );

        if ( empty( $all_notice ) ) {
            return;
        }

        $today_date      = gmdate( 'Y-m-d' );
        $today_timestamp = strtotime( $today_date );
        $all_notice      = json_decode( $all_notice, true );

        if ( ! is_array( $all_notice ) ) {
            return;
        }

        foreach ( $all_notice as $notice ) {

            $notice_id        = isset( $notice['notice_id'] ) ? $notice['notice_id'] : '';
            $thumbnail_url    = isset( $notice['thumbnail_url'] ) ? $notice['thumbnail_url'] : '';
            $thumbnail_link   = isset( $notice['thumbnail_link'] ) ? $notice['thumbnail_link'] : '';
            $content          = isset( $notice['content'] ) ? $notice['content'] : '';
            $action_buttons   = isset( $notice['action_buttons'] ) ? $notice['action_buttons'] : array();
            $expire_timestamp = isset( $notice['expire_date'] ) ? strtotime( $notice['expire_date'] ) : '';

            $this->expire_notice_by_date( $notice_id, $expire_timestamp );

            $notice_ignore_status = $this->get_notice_status( $notice_id );

            if ( $notice_ignore_status !== 'true' && $today_timestamp <= $expire_timestamp ) :
                ?>
                <div data-notice_id="<?php echo esc_attr( $notice_id ); ?>" id="boldpo-notice-<?php echo esc_attr( $notice_id ); ?>" class="boldpo-notice notice is-dismissible">

                    <?php if ( ! empty( $thumbnail_url ) ) : ?>
                        <?php if ( ! empty( $thumbnail_link ) ) : ?>
                            <a href="<?php echo esc_url( $thumbnail_link ); ?>" class="notice-logo-link" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $thumbnail_link ); ?>">
                                <img class="notice-logo" src="<?php echo esc_url( $thumbnail_url ); ?>" alt="">
                            </a>
                        <?php else : ?>
                            <img class="notice-logo" src="<?php echo esc_url( $thumbnail_url ); ?>" alt="">
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="notice-right-container">
                        <div class="notice-contents">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>

                        <div class="boldpo-notice-action-buttons">
                            <?php if ( ! empty( $action_buttons ) ) : ?>
                                <?php foreach ( $action_buttons as $button ) :
                                    $action_url   = isset( $button['url'] ) ? $button['url'] : '';
                                    $action_title = isset( $button['title'] ) ? $button['title'] : '';
                                    if ( empty( $action_url ) ) {
                                        continue;
                                    }
                                    ?>
                                    <a href="<?php echo esc_url( $action_url ); ?>" class="boldpo-notice-button" target="_blank">
                                        <?php echo esc_html( $action_title ); ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <button type="button" class="boldpo-notice-maybe-later" data-notice_id="<?php echo esc_attr( $notice_id ); ?>">Maybe Later</button>
                        </div>

                    </div>

                    <div style="clear:both"></div>
                </div>
                <?php
            endif;
        }
    }

    public function BOLDPO_notice_add_to_dashboard_widget() {

        // Register into the 'high' priority bucket — WP renders dashboard
        // widgets in order: high → core → default → low. Putting ours in
        // 'high' guarantees it appears above any widget registered with
        // 'core' or lower priority.
        wp_add_dashboard_widget(
            'BOLDPO_notice_widget',
            'ThemeWant Stories',
            array( $this, 'BOLDPO_notice_widget_callback' ),
            null,
            null,
            'normal',
            'high'
        );

        global $wp_meta_boxes;

        if ( ! isset( $wp_meta_boxes['dashboard']['normal']['high']['BOLDPO_notice_widget'] ) ) {
            return;
        }

        $my_widget = array(
            'BOLDPO_notice_widget' => $wp_meta_boxes['dashboard']['normal']['high']['BOLDPO_notice_widget'],
        );

        unset( $wp_meta_boxes['dashboard']['normal']['high']['BOLDPO_notice_widget'] );

        // Prepend so our widget sits at the very top of the 'high' bucket,
        // above any other plugin/core widget that also registered here.
        $wp_meta_boxes['dashboard']['normal']['high'] =
            $my_widget + $wp_meta_boxes['dashboard']['normal']['high'];
    }

    public function BOLDPO_notice_widget_callback() {

        $args = array( 'screen' => 'in-widget' );

        $all_notice = $this->BOLDPO_notice_get_notices( $args );

        if ( empty( $all_notice ) ) {
            echo '<p class="boldpo-notice-widget-empty">No stories available right now.</p>';
            return;
        }

        $today_date      = gmdate( 'Y-m-d' );
        $today_timestamp = strtotime( $today_date );
        $all_notice      = json_decode( $all_notice, true );

        if ( ! is_array( $all_notice ) ) {
            echo '<p class="boldpo-notice-widget-empty">No stories available right now.</p>';
            return;
        }

        echo '<div class="boldpo-notice-widget">';

        foreach ( $all_notice as $notice ) {

            $notice_id        = isset( $notice['notice_id'] ) ? $notice['notice_id'] : '';
            $sub_title        = isset( $notice['sub_title'] ) ? $notice['sub_title'] : '';
            $thumbnail_url    = isset( $notice['thumbnail_url'] ) ? $notice['thumbnail_url'] : '';
            $thumbnail_link   = isset( $notice['thumbnail_link'] ) ? $notice['thumbnail_link'] : '';
            $content          = isset( $notice['content'] ) ? $notice['content'] : '';
            $action_buttons   = isset( $notice['action_buttons'] ) ? $notice['action_buttons'] : array();
            $expire_timestamp = isset( $notice['expire_date'] ) ? strtotime( $notice['expire_date'] ) : '';

            if ( empty( $sub_title ) ) {
                $sub_title = $this->get_active_plugin_display_name();
            }

            $this->expire_notice_by_date( $notice_id, $expire_timestamp );

            $notice_ignore_status = $this->get_notice_status( $notice_id );

            if ( $notice_ignore_status !== 'true' && $today_timestamp <= $expire_timestamp ) :
                ?>
                <div class="boldpo-notice-widget-card">

                    <?php if ( ! empty( $sub_title ) ) : ?>
                        <div class="boldpo-notice-widget-eyebrow"><?php echo esc_html( $sub_title ); ?></div>
                    <?php endif; ?>

                    <?php if ( ! empty( $thumbnail_url ) ) : ?>
                        <div class="boldpo-notice-widget-thumb<?php echo ! empty( $thumbnail_link ) ? ' has-link' : ''; ?>">
                            <?php if ( ! empty( $thumbnail_link ) ) : ?>
                                <a href="<?php echo esc_url( $thumbnail_link ); ?>" class="boldpo-notice-widget-thumb-link" target="_blank" rel="noopener noreferrer">
                                    <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="">
                                    <span class="boldpo-notice-widget-thumb-overlay">
                                        <span class="boldpo-notice-widget-thumb-overlay-text">
                                            <span class="dashicons dashicons-external" aria-hidden="true"></span>
                                        </span>
                                    </span>
                                </a>
                            <?php else : ?>
                                <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $content ) ) : ?>
                        <div class="boldpo-notice-widget-content">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $action_buttons ) ) : ?>
                        <div class="boldpo-notice-widget-actions">
                            <?php foreach ( $action_buttons as $button ) :
                                $action_url   = isset( $button['url'] ) ? $button['url'] : '';
                                $action_title = isset( $button['title'] ) ? $button['title'] : '';
                                if ( empty( $action_url ) ) {
                                    continue;
                                }
                                ?>
                                <a href="<?php echo esc_url( $action_url ); ?>" class="boldpo-notice-widget-action" target="_blank" rel="noopener noreferrer">
                                    <span class="boldpo-notice-widget-action-text"><?php echo esc_html( $action_title ); ?></span>
                                    <span aria-hidden="true" class="dashicons dashicons-external"></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
                <?php
            endif;
        }

        echo '</div>';
    }
}
if ( is_admin() ) {
    new BOLDPO_NoticeDashboard();
}