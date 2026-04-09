<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$boldpo_allowed_metas = isset($attributes['allowedMetas']) ? $attributes['allowedMetas'] : [];
$boldpo_meta_html = '';

if ( in_array( 'category', $boldpo_allowed_metas ) ) {
    $boldpo_categories = get_the_category();
    if ( ! empty($boldpo_categories) ) {
        $cat_links = [];
        foreach ($boldpo_categories as $boldpo_category) {
            if ( $boldpo_category->slug === 'uncategorized' ) {
                continue;
            }
            $cat_color = get_term_meta($boldpo_category->term_id, 'category_color', true);
            $dot_style = $cat_color ? 'background-color: ' . esc_attr( $cat_color ) : '';
            $cat_links[] = '<span class="boldpo-cat-dot" style="' . $dot_style . '"></span><a href="' . esc_url(get_category_link($boldpo_category->term_id)) . '">' . esc_html( $boldpo_category->name ) . '</a>';
            
        }
        if ( ! empty( $cat_links ) ) {
            $boldpo_meta_html = '<span class="bldpost-meta">';
            $boldpo_meta_html .= implode( ', ', $cat_links );
            $boldpo_meta_html .= '</span>';
        }
    }
}
?>
<div class="boldpo-blog-categories boldpo-blog-categories-style-<?php echo esc_attr( $cat_style ); ?>">
    <?php 
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped during generation
    echo wp_kses_post( $boldpo_meta_html ); 
    ?>
</div>