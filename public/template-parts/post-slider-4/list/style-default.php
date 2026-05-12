<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="boldpo-list-item <?php echo esc_attr($item_class); ?>">
    <div class="boldpo-list-item-inner">
        
        <div class="boldpo-blog-img <?php echo esc_attr( $thumb_anim ); ?> <?php echo esc_attr( $anim_style ); ?>">
            <?php if( $show_meta && in_array('date', $allowed_metas) && $show_date_on_top === 'yes' ): ?>
                <div class="boldpo-blog-date-top">
                    <h4><?php echo esc_html( get_the_time('d') ); ?></h4>
                    <span><?php echo esc_html( get_the_time('M') ); ?></span>
                </div>
            <?php endif; ?>
            <?php if(empty($video_url)){ ?>
                <a href="<?php the_permalink(); ?>">
                <?php
                    if ( has_post_thumbnail() ) {
                        // Simple size for now
                        the_post_thumbnail( $thumbnail_size );
                    } else {
                        echo '<img src="' . BOLDPO_PL_URL . 'public/assets/img/placeholder.png" alt="Placeholder">';
                    }
                ?>
                </a>
            <?php } ?>
            <?php if ('default' == $style ) { ?>
                <div class="boldpo-overlay-all"></div>
            <?php } ?>
            
            <?php if ( ! empty($embed_video) ) { ?>
                <div class="boldpo-video-wrapper">
                    <?php echo $embed_video; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted markup from BOLDPO_Helper::boldpost_get_video_embed(), built from esc_attr/esc_url and wp_oembed_get. ?>
                    <span class="play-icon"></span>
                </div>
            <?php } ?>
        </div>
        <div class="boldpo-blog-content">
            <?php if ( $show_meta && 'up_title' === $meta_position ) include BOLDPO_PL_PATH . 'public/template-parts/post-meta/post-meta.php'; ?>
            
            <<?php echo esc_attr( $title_tag ); ?> class="boldpo-blog-title">
                <a href="<?php the_permalink(); ?>"><?php echo esc_html( $trimmed_title ); ?></a>
            </<?php echo esc_attr( $title_tag ); ?>>

            <?php if ( $show_meta && 'below_title' === $meta_position ) include BOLDPO_PL_PATH . 'public/template-parts/post-meta/post-meta.php'; ?>
            
            <?php if ( $show_excerpt === 'yes' ) : ?>
            <div class="boldpo-blog-excerpt">
                <?php echo esc_html( $trimmed_excerpt ); ?>
            </div>
            <?php endif; ?>
            
            <?php if ( $show_meta && 'below_content' === $meta_position ) include BOLDPO_PL_PATH . 'public/template-parts/post-meta/post-meta.php'; ?>
            <?php if ( $show_read_more === 'yes' && ! empty( $read_more_text ) ) : ?>
            <div class="boldpo-read-more">
                <a href="<?php the_permalink(); ?>" class="boldpo-read-more-link">
                    <?php if ( $read_more_icon_pos === 'before' && !empty($read_more_icon)) echo '<i class="' . esc_attr( $read_more_icon ) . ' boldpo-read-more-icon before"></i>'; ?>
                    <?php echo esc_html( $read_more_text ); ?>
                    <?php if ( $read_more_icon_pos === 'after' && !empty($read_more_icon)) echo '<i class="' . esc_attr( $read_more_icon ) . ' boldpo-read-more-icon after"></i>'; ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
        <span class="pgbr"></span>
    </div>
</div>