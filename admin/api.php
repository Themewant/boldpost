<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BOLDPO_API {
    public static function instance() {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    public function register_routes() {
        register_rest_route( 'boldpo/v1', '/update-block-status', array(
            'methods' => 'POST',
            'callback' => array( $this, 'update_block_status' ),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            }
        ) );

        // Templates endpoints
        register_rest_route( 'boldpo/v1', '/templates', array(
            array(
                'methods'  => 'GET',
                'callback' => array( $this, 'get_templates' ),
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ),
            array(
                'methods'  => 'POST',
                'callback' => array( $this, 'create_template' ),
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ),
        ) );

        register_rest_route( 'boldpo/v1', '/templates/(?P<id>\d+)', array(
            array(
                'methods'  => 'GET',
                'callback' => array( $this, 'get_template' ),
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ),
            array(
                'methods'  => 'PUT,PATCH',
                'callback' => array( $this, 'update_template' ),
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ),
            array(
                'methods'  => 'DELETE',
                'callback' => array( $this, 'delete_template' ),
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ),
        ) );

        register_rest_route( 'boldpo/v1', '/templates/bulk-delete', array(
            'methods'  => 'POST',
            'callback' => array( $this, 'bulk_delete_templates' ),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
        ) );
    }

    public function update_block_status( $request ) {
        $block_id = $request->get_param( 'blockId' );
        $status = $request->get_param( 'status' );


        
        // Update the block status in the database
        update_option( 'boldpo_block_' . $block_id, $status );

        $saved_status = get_option( 'boldpo_block_' . $block_id );
        
        return rest_ensure_response( array( 'status' => 'success', 'saved_status' => $saved_status ) );
    }

    // Templates CRUD

    public function get_templates( $request ) {
        $page     = (int) $request->get_param('page') ?: 1;
        $per_page = (int) $request->get_param('per_page') ?: 10;
        $search   = sanitize_text_field( $request->get_param('search') ?: '' );
        $orderby  = sanitize_text_field( $request->get_param('orderby') ?: 'date' );
        $order    = sanitize_text_field( $request->get_param('order') ?: 'DESC' );

        $args = array(
            'post_type'      => 'boldpo-template',
            'posts_per_page' => $per_page,
            'paged'          => $page,
            'orderby'        => $orderby,
            'order'          => strtoupper($order) === 'ASC' ? 'ASC' : 'DESC',
            'post_status'    => 'publish',
        );

        if ( ! empty( $search ) ) {
            $args['s'] = $search;
        }

        $query = new WP_Query( $args );
        $templates = array();

        foreach ( $query->posts as $post ) {
            $templates[] = $this->format_template( $post );
        }

        return rest_ensure_response( array(
            'templates' => $templates,
            'total'     => (int) $query->found_posts,
            'pages'     => (int) $query->max_num_pages,
            'page'      => $page,
            'per_page'  => $per_page,
        ) );
    }

    public function get_template( $request ) {
        $id   = (int) $request->get_param('id');
        $post = get_post( $id );

        if ( ! $post || $post->post_type !== 'boldpo-template' ) {
            return new WP_Error( 'not_found', 'Template not found', array( 'status' => 404 ) );
        }

        return rest_ensure_response( $this->format_template( $post ) );
    }

    public function create_template( $request ) {
        // Check template limit for free version
        $is_pro = false;
        if ( class_exists( 'BOLDPO_Pro' ) ) {
            $is_pro = (bool) BOLDPO_Pro::instance()->is_license_active();
        }

        if ( ! $is_pro ) {
            $count = wp_count_posts( 'boldpo-template' );
            $total = isset( $count->publish ) ? (int) $count->publish : 0;
            if ( $total >= 3 ) {
                return new WP_Error( 'template_limit', 'Free version allows up to 3 templates. Upgrade to Pro for unlimited templates.', array( 'status' => 403 ) );
            }
        }

        $title = sanitize_text_field( $request->get_param('title') );

        if ( empty( $title ) ) {
            return new WP_Error( 'missing_title', 'Template title is required', array( 'status' => 400 ) );
        }

        $post_id = wp_insert_post( array(
            'post_title'  => $title,
            'post_type'   => 'boldpo-template',
            'post_status' => 'publish',
            'post_content' => '',
        ), true );

        if ( is_wp_error( $post_id ) ) {
            return $post_id;
        }

        $post = get_post( $post_id );
        return rest_ensure_response( $this->format_template( $post ) );
    }

    public function update_template( $request ) {
        $id    = (int) $request->get_param('id');
        $post  = get_post( $id );

        if ( ! $post || $post->post_type !== 'boldpo-template' ) {
            return new WP_Error( 'not_found', 'Template not found', array( 'status' => 404 ) );
        }

        $update_args = array( 'ID' => $id );

        $title = $request->get_param('title');
        if ( $title !== null ) {
            $update_args['post_title'] = sanitize_text_field( $title );
        }

        $content = $request->get_param('content');
        if ( $content !== null ) {
            $update_args['post_content'] = wp_kses_post( $content );
        }

        $result = wp_update_post( $update_args, true );

        if ( is_wp_error( $result ) ) {
            return $result;
        }

        $post = get_post( $id );
        return rest_ensure_response( $this->format_template( $post ) );
    }

    public function delete_template( $request ) {
        $id   = (int) $request->get_param('id');
        $post = get_post( $id );

        if ( ! $post || $post->post_type !== 'boldpo-template' ) {
            return new WP_Error( 'not_found', 'Template not found', array( 'status' => 404 ) );
        }

        wp_delete_post( $id, true );

        return rest_ensure_response( array( 'status' => 'success', 'id' => $id ) );
    }

    public function bulk_delete_templates( $request ) {
        $ids = $request->get_param('ids');

        if ( ! is_array( $ids ) || empty( $ids ) ) {
            return new WP_Error( 'missing_ids', 'Template IDs are required', array( 'status' => 400 ) );
        }

        $deleted = array();
        foreach ( $ids as $id ) {
            $id   = (int) $id;
            $post = get_post( $id );
            if ( $post && $post->post_type === 'boldpo-template' ) {
                wp_delete_post( $id, true );
                $deleted[] = $id;
            }
        }

        return rest_ensure_response( array( 'status' => 'success', 'deleted' => $deleted ) );
    }

    private function format_template( $post ) {
        $author = get_userdata( $post->post_author );
        return array(
            'id'         => $post->ID,
            'title'      => $post->post_title,
            'content'    => $post->post_content,
            'date'       => $post->post_date,
            'modified'   => $post->post_modified,
            'author'     => $author ? $author->display_name : '',
            'status'     => $post->post_status,
            'editUrl'    => admin_url( 'post.php?post=' . $post->ID . '&action=edit' ),
        );
    }
}

BOLDPO_API::instance();