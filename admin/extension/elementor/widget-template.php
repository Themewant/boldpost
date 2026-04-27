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
            'posts_per_page' => -1,
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
                    . '</div>'
                    . '<script>'
                    . '(function(){'
                    . '  function updateEditBtn(){'
                    . '    var sel = document.querySelector("[data-setting=\"template_id\"]");'
                    . '    var btn = document.getElementById("boldpo-edit-template-btn");'
                    . '    if(!sel || !btn) return;'
                    . '    var id = sel.value;'
                    . '    if(id){'
                    . '      btn.href = "' . esc_url( admin_url( 'post.php' ) ) . '?post="+id+"&action=edit";'
                    . '      btn.style.opacity = "1";'
                    . '      btn.style.pointerEvents = "auto";'
                    . '    } else {'
                    . '      btn.href = "#";'
                    . '      btn.style.opacity = "0.5";'
                    . '      btn.style.pointerEvents = "none";'
                    . '    }'
                    . '  }'
                    . '  updateEditBtn();'
                    . '  var obs = new MutationObserver(updateEditBtn);'
                    . '  var panel = document.querySelector(".elementor-panel");'
                    . '  if(panel) obs.observe(panel, {childList:true, subtree:true, attributes:true});'
                    . '})();'
                    . '</script>',
                'content_classes' => 'boldpo-template-actions',
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings    = $this->get_settings_for_display();
        $template_id = absint( $settings['template_id'] );

        if ( $template_id ) {
            $is_editor = isset( $_GET['action'] ) || isset( $_POST['action'] ); //phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.NonceVerification.Recommended

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

        } elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'elementor' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
            echo '<p style="text-align:center; padding:20px; background:#f0f0f0; border:1px dashed #ccc; border-radius:4px; color:#666;">Please select a BoldPost template.</p>';
        }
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
        $css_urls[] = BOLDPO_PL_URL . 'assets/lib/bootstrap/bootstrap-grid.min.css';
        $css_urls[] = BOLDPO_PL_URL . 'assets/lib/swiper/swiper-bundle.min.css';

        // Collect block-specific styles
        $blocks = parse_blocks( $post->post_content );
        $this->collect_block_style_urls( $blocks, $css_urls );

        // Print link tags
        foreach ( $css_urls as $url ) {
            echo '<link rel="stylesheet" href="' . esc_url( $url ) . '" />' . "\n";
        }

        // Theme global styles (CSS variables, presets)
        if ( function_exists( 'wp_get_global_stylesheet' ) ) {
            $global_css = wp_get_global_stylesheet();
            if ( ! empty( $global_css ) ) {
                echo '<style id="boldpo-global-styles">' . wp_strip_all_tags( $global_css ) . '</style>' . "\n";
            }
        }

        // Swiper JS
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
