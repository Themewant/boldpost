<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$boldpo_allowed_metas = isset($attributes['allowedMetas']) ? $attributes['allowedMetas'] : [];
$boldpo_meta_html = '';
$boldpo_meta_position = isset($attributes['metaPosition']) ? $attributes['metaPosition'] : 'up_title';

if(empty($boldpo_allowed_metas)) {
    return;
}

if ( in_array( 'author', $boldpo_allowed_metas ) ) {
        $author_icon = '<i class="boldpo-meta-icon boldpo-icon-user-avatar"></i>';
        if($meta_style == '1') {
            $author_icon = '';
        }else if($meta_style == '2' || $meta_style == '3') {
            $author_id = get_the_author_meta('ID');
            $avatar_url = get_avatar_url($author_id, array(
                'size' => 150
            ));

            $author_icon = '<img src="'. esc_url( $avatar_url )  .'">';
        }
        $boldpo_meta_html .= '<span class="bldpost-meta">' . $author_icon . '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html( $attributes['authorPrefix'] ) . ' ' . esc_html( get_the_author() ) . '</a></span>';
}

$boldpo_date_html = '';
if ( in_array( 'date', $boldpo_allowed_metas ) && empty($attributes['showDateOnTop'])) {
    $date_icon = '<i class="boldpo-meta-icon boldpo-icon-calendar-two"></i>';
    $date = get_the_date();
    if(in_array($meta_style, ['1', '2'])) {
        $date_icon = '';
    }
    if(in_array($meta_style, ['2', '3'])) {
        $date = BOLDPO_Helper::boldpost_time_ago();
    }
    $boldpo_date_html = '<span class="bldpost-meta">' . $date_icon . esc_html( $date ) . '</span>';
}

$boldpo_category_html = '';
if ( in_array( 'category', $boldpo_allowed_metas ) ) {
    $boldpo_categories = get_the_category();
    if ( ! empty($boldpo_categories) ) {
        $cat_links = [];
        foreach ($boldpo_categories as $boldpo_category) {
            if ( $boldpo_category->slug === 'uncategorized' ) {
                continue;
            }
            $cat_links[] = '<a href="' . esc_url(get_category_link($boldpo_category->term_id)) . '" class="boldpo-meta-cat">' . esc_html( $boldpo_category->name ) . '</a>';
        }
        if ( ! empty( $cat_links ) ) {
            $boldpo_category_html  = '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-notification-status"></i>';
            $boldpo_category_html .= implode( ', ', $cat_links );
            $boldpo_category_html .= '</span>';
        }
    }
}

if ( $meta_style == '3' ) {
    $boldpo_meta_html .= $boldpo_category_html . $boldpo_date_html;
} else {
    $boldpo_meta_html .= $boldpo_date_html . $boldpo_category_html;
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

if ( in_array( 'comments_count', $boldpo_allowed_metas ) ) {
    $boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-chat"></i>';
    $boldpo_meta_html .= get_comments_number();
    $boldpo_meta_html .= '</span>';
}
?>
<div class="boldpo-post-metas boldpo-post-metas-style-<?php echo esc_attr( $meta_style ); ?> boldpo-post-meta-position-<?php echo esc_attr( $boldpo_meta_position ); ?>">
    <?php 
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped during generation
    echo wp_kses_post( $boldpo_meta_html ); 
    ?>
</div>