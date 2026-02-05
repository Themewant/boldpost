<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$boldpo_allowed_metas = isset($attributes['allowedMetas']) ? $attributes['allowedMetas'] : [];
$boldpo_meta_html = '';
if ( in_array( 'date', $boldpo_allowed_metas ) && empty($attributes['showDateOnTop'])) {
    $boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-calendar-two"></i>' . esc_html( get_the_date() ) . '</span>';
}
if ( in_array( 'author', $boldpo_allowed_metas ) ) {
    $boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-user-avatar"></i>' . esc_html( get_the_author() ) . '</span>';
}
if ( in_array( 'category', $boldpo_allowed_metas ) ) {
    $boldpo_categories = get_the_category();
    $boldpo_first_category = !empty($boldpo_categories) ? $boldpo_categories[0] : ''; 
    if($boldpo_first_category) {
        $boldpo_meta_html .= '<span class="bldpost-meta"><a href="' . esc_url(get_category_link($boldpo_first_category->term_id)) . '"><i class="boldpo-meta-icon boldpo-icon-notification-status"></i>' . esc_html( $boldpo_first_category->name ) . '</a></span>';
    }
    
}
if ( in_array( 'tag', $boldpo_allowed_metas ) ) {
    $boldpo_tags = get_the_tags();
    $boldpo_first_tag = !empty($boldpo_tags) ? $boldpo_tags[0] : '';  
    if($boldpo_first_tag) {
        $boldpo_meta_html .= '<a href="' . esc_url(get_tag_link($boldpo_first_tag->term_id)) . '"><i class="boldpo-meta-icon boldpo-icon-tags"></i>' . esc_html( $boldpo_first_tag->name ) . '</a>';
    }
}
?>
<div class="boldpo-blog-metas">
    <?php 
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped during generation
    echo wp_kses_post( $boldpo_meta_html ); 
    ?>
</div>