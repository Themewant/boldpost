<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BOLDPO_Elementor_Template_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'boldpo-template';
    }

    public function get_title() {
        return 'BoldPost Template';
    }

    public function get_icon() {
        return 'eicon-document-file';
    }

    public function get_categories() {
        return array( 'boldpost' );
    }

    public function get_keywords() {
        return array( 'template', 'boldpost', 'saved', 'block' );
    }

    private function get_templates_list() {
        $templates = get_posts( array(
            'post_type'      => 'boldpo-template',
            // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostsPerPage_posts_per_page -- This fills the Elementor widget's template dropdown, which has to list every template the user has saved; a cap would silently hide some of them. No row count or object caches are requested, and it only runs inside the Elementor editor.
            'posts_per_page' => -1,
            'no_found_rows'  => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ) );

        $options = array( '' => '— Select Template —' );
        foreach ( $templates as $template ) {
            $options[ $template->ID ] = $template->post_title;
        }

        return $options;
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_template',
            array(
                'label' => 'Template',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'template_id',
            array(
                'label'   => 'Select Template',
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_templates_list(),
                'default' => '',
            )
        );

        $this->add_control(
            'template_actions',
            array(
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw'  => '<div style="display:flex; gap:8px;">'
                    . '<a href="' . esc_url( admin_url( 'post-new.php?post_type=boldpo-template' ) ) . '" target="_blank" style="padding:8px 16px; display:inline-flex; align-items:center; background:#a216ff; color:#fff; border-radius:3px; text-decoration:none; text-align:center; flex:1; justify-content:center;font-size:12px;">'
                    . '<i class="eicon-plus" style="margin-right:5px;"></i> Add New'
                    . '</a>'
                    . '<a id="boldpo-edit-template-btn" href="#" target="_blank" style="padding:8px 16px; display:inline-flex; align-items:center; background:#555; color:#fff; border-radius:3px; text-decoration:none; text-align:center; flex:1; justify-content:center;font-size:12px;">'
                    . '<i class="eicon-edit" style="margin-right:5px;"></i> Edit Template'
                    . '</a>'
                    . '</div>',
                'content_classes' => 'boldpo-template-actions',
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings    = $this->get_settings_for_display();
        $template_id = absint( $settings['template_id'] );

        if ( $template_id ) {
            $is_editor = $this->is_elementor_editor();

            // In Elementor editor/AJAX context, print base styles before content
            if ( $is_editor ) {
                $this->print_inline_styles( $template_id );
            }

            echo '<div class="boldpo-template-content" data-postid="' . esc_attr( $template_id ) . '">';
            $the_query = new \WP_Query( array(
                'p'         => $template_id,
                'post_type' => 'boldpo-template',
            ) );
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    the_content();
                }
                wp_reset_postdata();
            }
            echo '</div>';

            // Print block style variation CSS after content render (it's built during the_content)
            if ( $is_editor ) {
                $this->print_block_variation_styles();
            }

        } elseif ( $this->is_elementor_editor() ) {
            echo '<p style="text-align:center; padding:20px; background:#f0f0f0; border:1px dashed #ccc; border-radius:4px; color:#666;">Please select a BoldPost template.</p>';
        }
    }

    /**
     * Whether this render is happening inside the Elementor editor.
     *
     * The preview emitter below writes <link>, <style> and <script> tags by hand
     * because Elementor's editor iframe has no enqueue pipeline. That is only
     * acceptable while it cannot happen on a page a visitor is looking at, so
     * the check is Elementor's own, not a guess at a query argument.
     *
     * @return bool
     */
    private function is_elementor_editor() {

        if ( ! did_action( 'elementor/loaded' ) || ! class_exists( '\\Elementor\\Plugin' ) ) {
            return false;
        }

        $elementor = \Elementor\Plugin::$instance;

        if ( isset( $elementor->editor ) && $elementor->editor->is_edit_mode() ) {
            return true;
        }

        if ( isset( $elementor->preview ) && $elementor->preview->is_preview_mode() ) {
            return true;
        }

        // Elementor also re-renders a single widget over admin-ajax, where
        // neither of the above reports true. Gate that on the capability editing
        // requires so a visitor cannot reach it by naming the action.
        return wp_doing_ajax() && current_user_can( 'edit_posts' );
    }

    private function print_inline_styles( $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post ) {
            return;
        }

        $css_urls = array();

        // WordPress core block library
        $css_urls[] = includes_url( 'css/dist/block-library/style.min.css' );

        // Theme stylesheet
        $css_urls[] = get_stylesheet_uri();

        // BoldPost base styles
        $css_urls[] = BOLDPO_PL_URL . 'public/assets/css/public.css';
        $css_urls[] = BOLDPO_PL_URL . 'assets/lib/bootstrap/bootstrap-grid.css';
        $css_urls[] = BOLDPO_PL_URL . 'assets/lib/swiper/swiper-bundle.min.css';

        // Collect block-specific styles
        $blocks = parse_blocks( $post->post_content );
        $this->collect_block_style_urls( $blocks, $css_urls );

        // Print link tags — this is a custom HTML preview emitter, not the standard front-end render path,
        // so wp_enqueue_style() cannot be used here.
        foreach ( $css_urls as $url ) {
            // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet -- Inline preview emitter; wp_enqueue_style() is not applicable here.
            echo '<link rel="stylesheet" href="' . esc_url( $url ) . '" />' . "\n";
        }

        // Theme global styles (CSS variables, presets)
        if ( function_exists( 'wp_get_global_stylesheet' ) ) {
            $global_css = wp_get_global_stylesheet();
            if ( ! empty( $global_css ) ) {
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS content stripped of tags via wp_strip_all_tags; HTML-escaping is not appropriate inside a <style> block.
                echo '<style id="boldpo-global-styles">' . wp_strip_all_tags( $global_css ) . '</style>' . "\n";
            }
        }

        // Swiper JS
        // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Inline preview emitter; wp_enqueue_script() is not applicable here.
        echo '<script src="' . esc_url( BOLDPO_PL_URL . 'assets/lib/swiper/swiper-bundle.min.js' ) . '"></script>' . "\n";
    }

    private function print_block_variation_styles() {
        $styles = wp_styles();
        if ( ! isset( $styles->registered['block-style-variation-styles'] ) ) {
            return;
        }

        $inline = $styles->get_data( 'block-style-variation-styles', 'after' );
        if ( ! empty( $inline ) ) {
            $css = is_array( $inline ) ? implode( "\n", $inline ) : $inline;
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS content stripped of tags via wp_strip_all_tags; HTML-escaping is not appropriate inside a <style> block.
            echo '<style id="boldpo-block-style-variation-styles">' . wp_strip_all_tags( $css ) . '</style>' . "\n";
        }
    }

    private function collect_block_style_urls( $blocks, &$css_urls ) {
        foreach ( $blocks as $block ) {
            if ( ! empty( $block['blockName'] ) && strpos( $block['blockName'], 'boldpost/' ) === 0 ) {
                $block_slug = str_replace( 'boldpost/', '', $block['blockName'] );
                $css_file = BOLDPO_PL_PATH . 'public/blocks/' . $block_slug . '/build/style-index.css';
                if ( file_exists( $css_file ) ) {
                    $css_urls[] = BOLDPO_PL_URL . 'public/blocks/' . $block_slug . '/build/style-index.css';
                }
            }

            // Recurse into inner blocks
            if ( ! empty( $block['innerBlocks'] ) ) {
                $this->collect_block_style_urls( $block['innerBlocks'], $css_urls );
            }
        }
    }
}
