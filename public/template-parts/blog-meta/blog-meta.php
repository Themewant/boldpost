<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$boldpo_allowed_metas = isset($attributes['allowedMetas']) ? $attributes['allowedMetas'] : [];
$boldpo_meta_html = '';
if ( in_array( 'date', $boldpo_allowed_metas ) && empty($attributes['showDateOnTop'])) {
    $boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-calendar-two"></i>' . esc_html( get_the_date() ) . '</span>';
}
if ( in_array( 'author', $boldpo_allowed_metas ) ) {
    $boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-user-avatar"></i><a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html( get_the_author() ) . '</a></span>';
}
if ( in_array( 'category', $boldpo_allowed_metas ) ) {
    $boldpo_categories = get_the_category();
    if ( ! empty($boldpo_categories) ) {
        $boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-notification-status"></i>';
        $cat_links = [];
        foreach ($boldpo_categories as $boldpo_category) {
            $cat_links[] = '<a href="' . esc_url(get_category_link($boldpo_category->term_id)) . '">' . esc_html( $boldpo_category->name ) . '</a>';
        }
        $boldpo_meta_html .= implode( ', ', $cat_links );
        $boldpo_meta_html .= '</span>';
    }
}
if ( in_array( 'tag', $boldpo_allowed_metas ) ) {
    $boldpo_tags = get_the_tags();
    if ( $boldpo_tags ) {
        $boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-tags"></i>';
        $tag_links = [];
        foreach ($boldpo_tags as $boldpo_tag) {
            $tag_links[] = '<a href="' . esc_url(get_tag_link($boldpo_tag->term_id)) . '">' . esc_html( $boldpo_tag->name ) . '</a>';
        }
        $boldpo_meta_html .= implode( ', ', $tag_links );
        $boldpo_meta_html .= '</span>';
    }
}
?>
<div class="boldpo-blog-metas">
    <?php 
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped during generation
    echo wp_kses_post( $boldpo_meta_html ); 
    ?>
</div>