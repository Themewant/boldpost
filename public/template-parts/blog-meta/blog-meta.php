<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$boldpo_allowed_metas = isset($attributes['allowedMetas']) ? $attributes['allowedMetas'] : [];
$boldpo_meta_html = '';

if ( in_array( 'author', $boldpo_allowed_metas ) ) {
        $author_icon = '<i class="boldpo-meta-icon boldpo-icon-user-avatar"></i>';
        if($meta_style == '1') {
            $author_icon = '';
        }else if($meta_style == '2') {
            $author_id = get_the_author_meta('ID');
            $avatar_url = get_avatar_url($author_id, array(
                'size' => 150
            ));

            $author_icon = '<img src="'. esc_url( $avatar_url )  .'">';
        }
        $boldpo_meta_html .= '<span class="bldpost-meta">' . $author_icon . '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html( $attributes['authorPrefix'] ) . ' ' . esc_html( get_the_author() ) . '</a></span>';
}

if ( in_array( 'date', $boldpo_allowed_metas ) && empty($attributes['showDateOnTop'])) {
    $date_icon = '<i class="boldpo-meta-icon boldpo-icon-calendar-two"></i>';
    $date = get_the_date();
    if(in_array($meta_style, ['1', '2'])) {
        $date_icon = '';
    }
    if(in_array($meta_style, ['2'])) {
        $date = BOLDPO_Helper::boldpost_time_ago();
    }
    $boldpo_meta_html .= '<span class="bldpost-meta">' . $date_icon . esc_html( $date ) . '</span>';
}

if ( in_array( 'category', $boldpo_allowed_metas ) ) {
    $boldpo_categories = get_the_category();
    if ( ! empty($boldpo_categories) ) {
        $cat_links = [];
        foreach ($boldpo_categories as $boldpo_category) {
            if ( $boldpo_category->slug === 'uncategorized' ) {
                continue;
            }
            $cat_links[] = '<a href="' . esc_url(get_category_link($boldpo_category->term_id)) . '">' . esc_html( $boldpo_category->name ) . '</a>';
        }
        if ( ! empty( $cat_links ) ) {
            $boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-notification-status"></i>';
            $boldpo_meta_html .= implode( ', ', $cat_links );
            $boldpo_meta_html .= '</span>';
        }
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
        $boldpo_meta_html .= implode( ',&nbsp;', $tag_links );
        $boldpo_meta_html .= '</span>';
    }
}
?>
<div class="boldpo-blog-metas boldpo-blog-metas-style-<?php echo esc_attr( $meta_style ); ?>">
    <?php 
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped during generation
    echo wp_kses_post( $boldpo_meta_html ); 
    ?>
</div>