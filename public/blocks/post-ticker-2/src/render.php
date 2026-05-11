<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

// Attributes are available as $attributes array
// Map camelCase attributes to match the logic (or use direct access)

$per_page = isset($attributes['perPage']) ? $attributes['perPage'] : 6;
$slidesPerView = $attributes['slidesPerView'] ?? 1;
$slidesPerViewTablet = $attributes['slidesPerViewTablet'] ?? 1;
$slidesPerViewMobile = $attributes['slidesPerViewMobile'] ?? 1;
$slidesPerViewMobileSmall = $attributes['slidesPerViewMobileSmall'] ?? 1;


$slidesToScroll = $attributes['slidesToScroll'] ?? 1;
$spaceBetween = $attributes['spaceBetween'] ?? 20;
$autoplay = $attributes['autoplay'] ? 'true' : 'false';
$autoplay_delay = $attributes['autoplayDelay'] ? $attributes['autoplayDelay'] : 0;
$pauseOnHover = $attributes['pauseOnHover'] ? 'true' : 'false';
$pauseOnInter = $attributes['pauseOnInter'] ? 'true' : 'false';

$centeredSlides = $attributes['centeredSlides'] ? 'true' : 'false';
$speed = $attributes['speed'] ?? 2000;
$effect = $attributes['effect'] ?? 'slide';
$loop = $attributes['loop'] ? 'true' : 'false';
$order = isset($attributes['order']) ? $attributes['order'] : 'ASC';
$orderby = isset($attributes['orderby']) ? $attributes['orderby'] : 'date';
$offset = isset($attributes['offset']) ? $attributes['offset'] : 0;
$style = isset($attributes['sliderStyle']) ? $attributes['sliderStyle'] : 'default';
$is_featured = !empty($attributes['isFeatured']) ? true : false;
$ignore_stikcy_posts = !empty($attributes['ignoreStikcyPosts']) ? 1 : 0;


// Styles attributes
$title_tag = isset($attributes['titleTag']) ? $attributes['titleTag'] : 'h3';
$title_trim = isset($attributes['titleTrim']) ? $attributes['titleTrim'] : 100;
$ticker_label = isset($attributes['tickerLabel']) ? $attributes['tickerLabel'] : 'Trending';

// styles
$responsive_data = [
    'desktop' => [],
    'tablet'  => [],
    'mobile'  => []
];

$col_class = '';

// Gaps (Slider usually handles this in JS, but let's see if SCSS uses them)
BOLDPO_Helper::add_responsive_vars($attributes, $responsive_data, 'itemColGap', 'column-gap');
BOLDPO_Helper::add_responsive_vars($attributes, $responsive_data, 'itemRowGap', 'row-gap');

// Item Styles
$item_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
BOLDPO_Helper::add_responsive_vars($attributes, $item_responsive, 'itemPadding', '', ['top'=>'padding-top','right'=>'padding-right','bottom'=>'padding-bottom','left'=>'padding-left'], true);

$item_desktop = [];
if ( ! empty( $attributes['itemBackgroundColor'] ) ) {
    $item_desktop['background-color'] = $attributes['itemBackgroundColor'];
}
if ( ! empty( $attributes['itemBackgroundColorTwo'] ) ) {
    $item_desktop['background-color'] = $attributes['itemBackgroundColorTwo'];
}
if ( ! empty( $attributes['itemBackgroundGradient'] ) ) {
    $item_desktop['background'] = $attributes['itemBackgroundGradient'];
}
// Hover background
$item_hover = [];
if(!empty($attributes['itemBackgroundColorHover'])) {
    $item_hover['background-color'] = $attributes['itemBackgroundColorHover'] . ' !important';
}
if(!empty($attributes['itemBackgroundGradientHover'])) {
    $item_hover['background'] = $attributes['itemBackgroundGradientHover'] . ' !important';
}

// Title
$title_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
BOLDPO_Helper::add_responsive_vars($attributes, $title_responsive, 'itemTitlePadding', '', ['top'=>'padding-top','right'=>'padding-right','bottom'=>'bottom','left'=>'padding-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $title_responsive, 'itemTitleMargin', '', ['top'=>'margin-top','right'=>'margin-right','bottom'=>'margin-bottom','left'=>'margin-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $title_responsive, 'itemTitleTypography', '', [
    'fontSize'=>'font-size', 
    'fontWeight'=>'font-weight', 
    'lineHeight'=>'line-height', 
    'textTransform'=>'text-transform', 
    'letterSpacing'=>'letter-spacing'
], true);

if ( ! empty( $attributes['itemTitleColor'] ) ) {
    $title_responsive['desktop']['color'] = $attributes['itemTitleColor'];
}

BOLDPO_Helper::add_responsive_vars($attributes, $title_responsive, 'titleTextAlign', 'text-align', [], false);

$title_hover = [];
if(!empty($attributes['itemTitleColorHover'])) {
    $title_hover['color'] = $attributes['itemTitleColorHover'];
}

$title_dot = [];
if(!empty($spaceBetween)) {
    $title_dot['left'] = '-' . ($spaceBetween * 2) . 'px';
}

$label_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
BOLDPO_Helper::add_responsive_vars($attributes, $label_responsive, 'labelPadding', '', ['top'=>'padding-top','right'=>'padding-right','bottom'=>'bottom','left'=>'padding-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $label_responsive, 'labelMargin', '', ['top'=>'margin-top','right'=>'margin-right','bottom'=>'margin-bottom','left'=>'margin-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $label_responsive, 'labelTypography', '', [
    'fontSize'=>'font-size', 
    'fontWeight'=>'font-weight', 
    'lineHeight'=>'line-height', 
    'textTransform'=>'text-transform', 
    'letterSpacing'=>'letter-spacing'
], true);

if ( ! empty( $attributes['labelColor'] ) ) {
    $label_responsive['desktop']['color'] = $attributes['labelColor'];
}

BOLDPO_Helper::add_responsive_vars($attributes, $label_responsive, 'labelTextAlign', 'text-align', [], false);

$label_hover = [];
if(!empty($attributes['labelColorHover'])) {
    $label_hover['color'] = $attributes['labelColorHover'];
}

// Thumbnail Border Radius
$thumbnail_border_radius_styles = [];
$t_border_radius = $attributes['thumbnailBorderRadius'] ?? [];
if ( ! empty( $t_border_radius['top'] ) ) $thumbnail_border_radius_styles['border-top-left-radius'] = BOLDPO_Helper::ensure_unit( $t_border_radius['top'] );
if ( ! empty( $t_border_radius['right'] ) ) $thumbnail_border_radius_styles['border-top-right-radius'] = BOLDPO_Helper::ensure_unit( $t_border_radius['right'] );
if ( ! empty( $t_border_radius['bottom'] ) ) $thumbnail_border_radius_styles['border-bottom-left-radius'] = BOLDPO_Helper::ensure_unit( $t_border_radius['bottom'] );
if ( ! empty( $t_border_radius['left'] ) ) $thumbnail_border_radius_styles['border-bottom-right-radius'] = BOLDPO_Helper::ensure_unit( $t_border_radius['left'] );

$style_handle = 'boldpo-post-ticker-2-style';
$unique_id    = 'boldpo-' . wp_rand( 100, 99999 );
$selector     = '.boldpo-post-ticker-2-block-wrap.' . $unique_id;

$full_responsive_css = BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-post-ticker-2.style-' . $style, $responsive_data);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-post-ticker-2.style-' . $style . ' .boldpo-grid-item', $item_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-post-ticker-2.style-' . $style . ' .boldpo-grid-item .boldpo-blog-title', $title_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-post-ticker-2.style-' . $style . ' .boldpo-ticker-label', $label_responsive);

wp_enqueue_style( $style_handle );
BOLDPO_Helper::add_custom_style( $style_handle, $selector, $full_responsive_css, [
    '.boldpo-post-ticker-2 .boldpo-grid-item'    => BOLDPO_Helper::get_inline_styles($item_desktop),
    '.boldpo-post-ticker-2 .boldpo-grid-item:hover'    => BOLDPO_Helper::get_inline_styles($item_hover),
    '.boldpo-post-ticker-2 .boldpo-grid-item .boldpo-blog-title a:hover' => BOLDPO_Helper::get_inline_styles($title_hover),
    '.boldpo-post-ticker-2 .boldpo-grid-item .boldpo-blog-title::before' => BOLDPO_Helper::get_inline_styles($title_dot),
    '.boldpo-post-ticker-2 .boldpo-grid-item .boldpo-blog-img'   => BOLDPO_Helper::get_inline_styles($thumbnail_border_radius_styles),
] );

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => (int) $per_page,
    'post_status'    => 'publish',
    'order'          => in_array( $order, ['ASC','DESC'], true ) ? $order : 'DESC',
    'orderby'        => $orderby,
    'ignore_sticky_posts' => $ignore_stikcy_posts,
);

if ( ! empty( $offset ) ) {
    $args['offset'] = (int) $offset;
}

if ( ! empty( $attributes['posts'] ) && ! in_array( 'all', $attributes['posts'] ) ) {
    $args['post__in'] = array_map( 'intval', $attributes['posts'] );
    $args['orderby'] = 'post__in';
}

if ( ! empty( $attributes['excludes'] ) && ! in_array( 'no-excludes', $attributes['excludes'] ) ) {
    // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in -- User-controlled exclusion is intentional
    $args['post__not_in'] = array_map( 'intval', $attributes['excludes'] );
}

if ( ! empty( $attributes['categories'] ) && ! in_array( 'all', $attributes['categories'] ) ) {
    $cat_ids = [];

    foreach ( $attributes['categories'] as $cat ) {
        if ( is_numeric( $cat ) ) {
            $cat_ids[] = (int) $cat;
        } else {
            $term = get_term_by( 'slug', $cat, 'category' );
            if ( $term ) {
                $cat_ids[] = (int) $term->term_id;
            }
        }
    }
    $args['category__in'] = array_map( 'intval', $cat_ids );
}


if($is_featured == true) {
    // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
    $args['meta_query'] = array(
        array(
            'key'     => '_is_featured',
            'value'   => '1',
            'compare' => 'IN',
        ),
    );
}

$unique      = wp_rand(2012, 35120);
$query = new WP_Query( $args );

$_data_attrs = array(
    'data-unique'                    => esc_attr($unique),
    'data-slides-per-view'           => esc_attr($slidesPerView),
    'data-slides-per-view-desktop'   => esc_attr($slidesPerView),
    'data-slides-per-view-tablet'    => esc_attr($slidesPerViewTablet),
    'data-slides-per-view-mobile'    => esc_attr($slidesPerViewMobile),
    'data-slides-per-view-mobile-small' => esc_attr($slidesPerViewMobileSmall),
    'data-slides-to-scroll'          => esc_attr($slidesToScroll),
    'data-space-between'             => esc_attr($spaceBetween),
    'data-centered-slides'           => esc_attr($centeredSlides),
    'data-loop'                      => esc_attr($loop),
    'data-effect'                    => esc_attr($effect),
    'data-speed'                     => esc_attr($speed),
    'data-autoplay'                  => esc_attr($autoplay),
    'data-autoplay-delay'            => esc_attr($autoplay_delay),
);

if ( $query->have_posts() ) :

// In the editor, ServerSideRender wraps the PHP output inside the edit component's
// useBlockProps div, which already carries the block support styles (spacing, color).
// Using get_block_wrapper_attributes() here would duplicate those styles on a second
// inner wrapper. Skip it for REST/editor preview and use a plain wrapper instead.
$_is_editor = defined( 'REST_REQUEST' ) && REST_REQUEST;

if ( $_is_editor ) {
    $_extra_attrs = '';
    foreach ( $_data_attrs as $k => $v ) {
        $_extra_attrs .= ' ' . $k . '="' . $v . '"';
    }
    $_wrapper_open = '<div class="boldpo-block boldpo-post-ticker-2-block-wrap ' . esc_attr($unique_id) . '"' . $_extra_attrs . '>';
} else {
    $_wrapper_open = '<div ' . wp_kses_post( get_block_wrapper_attributes( array_merge(
        array( 'class' => 'boldpo-block boldpo-post-ticker-2-block-wrap ' . $unique_id ),
        $_data_attrs
    ) ) ) . '>';
}
?>
    <?php echo $_wrapper_open; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
       
        <div class="boldpo-post-ticker-2 swiper boldpo-post-ticker-2-<?php echo esc_attr($unique); ?> style-<?php echo esc_attr($style); ?>">
            <div class="boldpo-ticker-label">
                <i class="boldpo-icon boldpo-icon-fire"></i>
                <span class="boldpo-ticker-label-text"><?php echo esc_html($ticker_label); ?></span>
            </div>
            <div class="swiper-wrapper swiper-wrapper-<?php echo esc_attr($unique); ?>">
                <?php
                    while ( $query->have_posts() ) : $query->the_post();
                        $item_class = '';
                        if(is_sticky()) {
                            $item_class .= 'boldpo-sticky-post';
                        }

                        if(!empty($anim_style)) {
                            $item_class .= ' ' . $anim_style;
                        }
                        $trimmed_title = wp_trim_words( get_the_title(), $title_trim, '...' );
                    
                        $style_file = BOLDPO_PL_PATH . 'public/template-parts/post-ticker-2/style-' . $style . '.php';

                        if ( file_exists( $style_file ) ) {
                            ?>
                            <div class="swiper-slide">
                                <?php include $style_file; ?>
                            </div>
                            <?php
                        }
                    endwhile;
                ?>
            </div>
        </div>
        
    </div>
<?php
    wp_reset_postdata();
else:
    ?>
    <?php if ( $_is_editor ) : ?>
    <div class="boldpo-block boldpo-post-ticker-2-block-wrap">
        <p><?php esc_html_e('No posts found.', 'boldpost'); ?></p>
    </div>
    <?php else : ?>
    <div <?php echo wp_kses_post(get_block_wrapper_attributes()); ?>>
        <p><?php esc_html_e('No posts found.', 'boldpost'); ?></p>
    </div>
    <?php endif; ?>
    <?php
endif;