<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$items     = isset( $attributes['items'] ) ? $attributes['items'] : array();
$style     = isset( $attributes['layoutStyle'] ) ? $attributes['layoutStyle'] : 'default';
$title_tag = isset( $attributes['titleTag'] ) ? $attributes['titleTag'] : 'h4';
$image_size = isset( $attributes['imageSize'] ) ? $attributes['imageSize'] : 'thumbnail';

$style_handle = 'boldpo-info-box-style';
$unique_id    = 'boldpo-' . wp_rand( 100, 99999 );
$selector     = '.boldpo-info-box-block-wrap.' . $unique_id;

// Columns -> bootstrap grid classes
$c_desktop = isset( $attributes['columns'] ) ? (int) $attributes['columns'] : 3;
$c_tablet  = isset( $attributes['columnsTablet'] ) ? (int) $attributes['columnsTablet'] : $c_desktop;
$c_mobile  = isset( $attributes['columnsMobile'] ) ? (int) $attributes['columnsMobile'] : 1;

$bs_col_lg = $c_desktop > 0 ? (int) ( 12 / $c_desktop ) : 4;
$bs_col_md = $c_tablet > 0 ? (int) ( 12 / $c_tablet ) : 6;
$bs_col_xs = $c_mobile > 0 ? (int) ( 12 / $c_mobile ) : 12;

$col_class = "boldpo-col-lg-{$bs_col_lg} boldpo-col-md-{$bs_col_md} boldpo-col-{$bs_col_xs}";

// Gaps
$g_desktop = isset( $attributes['itemGap'] ) ? $attributes['itemGap'] : '4';
$g_tablet  = isset( $attributes['itemGapTablet'] ) ? $attributes['itemGapTablet'] : $g_desktop;
$g_mobile  = isset( $attributes['itemGapMobile'] ) ? $attributes['itemGapMobile'] : $g_tablet;

if ( $g_desktop == $g_tablet && $g_tablet == $g_mobile ) {
    $gap_class = 'boldpo-gx-' . $g_desktop;
} else {
    $gap_class = 'boldpo-gx-lg-' . $g_desktop . ' boldpo-gx-md-' . $g_tablet . ' boldpo-gx-sm-' . $g_mobile;
}

$gr_desktop = isset( $attributes['itemRowGap'] ) ? $attributes['itemRowGap'] : '4';
$gr_tablet  = isset( $attributes['itemRowGapTablet'] ) ? $attributes['itemRowGapTablet'] : $gr_desktop;
$gr_mobile  = isset( $attributes['itemRowGapMobile'] ) ? $attributes['itemRowGapMobile'] : $gr_tablet;

if ( $gr_desktop == $gr_tablet && $gr_tablet == $gr_mobile ) {
    $gap_row_class = 'boldpo-gy-' . $gr_desktop;
} else {
    $gap_row_class = 'boldpo-gy-lg-' . $gr_desktop . ' boldpo-gy-md-' . $gr_tablet . ' boldpo-gy-sm-' . $gr_mobile;
}

// Item box styles
$item_responsive = array( 'desktop' => array(), 'tablet' => array(), 'mobile' => array() );
BOLDPO_Helper::add_responsive_vars(
    $attributes,
    $item_responsive,
    'itemPadding',
    '',
    array(
        'top'    => 'padding-top',
        'right'  => 'padding-right',
        'bottom' => 'padding-bottom',
        'left'   => 'padding-left',
    ),
    true
);

$item_desktop_extra = array();
if ( ! empty( $attributes['itemBackgroundColor'] ) ) {
    $item_desktop_extra['background-color'] = $attributes['itemBackgroundColor'];
}
if ( ! empty( $attributes['itemBackgroundGradient'] ) ) {
    $item_desktop_extra['background'] = $attributes['itemBackgroundGradient'];
}

$item_border_radius = isset( $attributes['itemBorderRadius'] ) ? $attributes['itemBorderRadius'] : array();
if ( ! empty( $item_border_radius['top'] ) ) {
    $item_desktop_extra['border-top-left-radius'] = BOLDPO_Helper::ensure_unit( $item_border_radius['top'] );
}
if ( ! empty( $item_border_radius['right'] ) ) {
    $item_desktop_extra['border-top-right-radius'] = BOLDPO_Helper::ensure_unit( $item_border_radius['right'] );
}
if ( ! empty( $item_border_radius['bottom'] ) ) {
    $item_desktop_extra['border-bottom-left-radius'] = BOLDPO_Helper::ensure_unit( $item_border_radius['bottom'] );
}
if ( ! empty( $item_border_radius['left'] ) ) {
    $item_desktop_extra['border-bottom-right-radius'] = BOLDPO_Helper::ensure_unit( $item_border_radius['left'] );
}

$item_responsive['desktop'] = array_merge( $item_responsive['desktop'], $item_desktop_extra );

// Item hover
$item_hover = array();
if ( ! empty( $attributes['itemBackgroundColorHover'] ) ) {
    $item_hover['background-color'] = $attributes['itemBackgroundColorHover'] . ' !important';
}
if ( ! empty( $attributes['itemBackgroundGradientHover'] ) ) {
    $item_hover['background'] = $attributes['itemBackgroundGradientHover'] . ' !important';
}

// Image gap (between image and content) — flex gap on item
$image_gap_responsive = array( 'desktop' => array(), 'tablet' => array(), 'mobile' => array() );
$ig_desktop = isset( $attributes['imageGap'] ) ? $attributes['imageGap'] : '';
$ig_tablet  = isset( $attributes['imageGapTablet'] ) ? $attributes['imageGapTablet'] : '';
$ig_mobile  = isset( $attributes['imageGapMobile'] ) ? $attributes['imageGapMobile'] : '';
if ( $ig_desktop !== '' ) {
    $image_gap_responsive['desktop']['gap'] = BOLDPO_Helper::ensure_unit( $ig_desktop );
}
if ( $ig_tablet !== '' ) {
    $image_gap_responsive['tablet']['gap'] = BOLDPO_Helper::ensure_unit( $ig_tablet );
}
if ( $ig_mobile !== '' ) {
    $image_gap_responsive['mobile']['gap'] = BOLDPO_Helper::ensure_unit( $ig_mobile );
}

// Image size
$image_responsive = array( 'desktop' => array(), 'tablet' => array(), 'mobile' => array() );
$iw_desktop = isset( $attributes['imageWidth'] ) ? $attributes['imageWidth'] : '';
$iw_tablet  = isset( $attributes['imageWidthTablet'] ) ? $attributes['imageWidthTablet'] : '';
$iw_mobile  = isset( $attributes['imageWidthMobile'] ) ? $attributes['imageWidthMobile'] : '';
$ih_desktop = isset( $attributes['imageHeight'] ) ? $attributes['imageHeight'] : '';
$ih_tablet  = isset( $attributes['imageHeightTablet'] ) ? $attributes['imageHeightTablet'] : '';
$ih_mobile  = isset( $attributes['imageHeightMobile'] ) ? $attributes['imageHeightMobile'] : '';
if ( $iw_desktop !== '' ) {
    $image_responsive['desktop']['width'] = BOLDPO_Helper::ensure_unit( $iw_desktop );
}
if ( $iw_tablet !== '' ) {
    $image_responsive['tablet']['width'] = BOLDPO_Helper::ensure_unit( $iw_tablet );
}
if ( $iw_mobile !== '' ) {
    $image_responsive['mobile']['width'] = BOLDPO_Helper::ensure_unit( $iw_mobile );
}
if ( $ih_desktop !== '' ) {
    $image_responsive['desktop']['height'] = BOLDPO_Helper::ensure_unit( $ih_desktop );
}
if ( $ih_tablet !== '' ) {
    $image_responsive['tablet']['height'] = BOLDPO_Helper::ensure_unit( $ih_tablet );
}
if ( $ih_mobile !== '' ) {
    $image_responsive['mobile']['height'] = BOLDPO_Helper::ensure_unit( $ih_mobile );
}

$image_radius = isset( $attributes['imageBorderRadius'] ) ? $attributes['imageBorderRadius'] : array();
$image_radius_styles = array();
if ( ! empty( $image_radius['top'] ) ) {
    $image_radius_styles['border-top-left-radius'] = BOLDPO_Helper::ensure_unit( $image_radius['top'] );
}
if ( ! empty( $image_radius['right'] ) ) {
    $image_radius_styles['border-top-right-radius'] = BOLDPO_Helper::ensure_unit( $image_radius['right'] );
}
if ( ! empty( $image_radius['bottom'] ) ) {
    $image_radius_styles['border-bottom-left-radius'] = BOLDPO_Helper::ensure_unit( $image_radius['bottom'] );
}
if ( ! empty( $image_radius['left'] ) ) {
    $image_radius_styles['border-bottom-right-radius'] = BOLDPO_Helper::ensure_unit( $image_radius['left'] );
}

// Title
$title_responsive = array( 'desktop' => array(), 'tablet' => array(), 'mobile' => array() );
BOLDPO_Helper::add_responsive_vars(
    $attributes,
    $title_responsive,
    'titleMargin',
    '',
    array(
        'top'    => 'margin-top',
        'right'  => 'margin-right',
        'bottom' => 'margin-bottom',
        'left'   => 'margin-left',
    ),
    true
);
BOLDPO_Helper::add_responsive_vars(
    $attributes,
    $title_responsive,
    'titleTypography',
    '',
    array(
        'fontSize'      => 'font-size',
        'fontWeight'    => 'font-weight',
        'lineHeight'    => 'line-height',
        'textTransform' => 'text-transform',
        'letterSpacing' => 'letter-spacing',
    ),
    true
);

if ( ! empty( $attributes['titleColor'] ) ) {
    $title_responsive['desktop']['color'] = $attributes['titleColor'];
}

$title_hover = array();
if ( ! empty( $attributes['titleColorHover'] ) ) {
    $title_hover['color'] = $attributes['titleColorHover'] . ' !important';
}

// Subtitle
$subtitle_responsive = array( 'desktop' => array(), 'tablet' => array(), 'mobile' => array() );
BOLDPO_Helper::add_responsive_vars(
    $attributes,
    $subtitle_responsive,
    'subtitleMargin',
    '',
    array(
        'top'    => 'margin-top',
        'right'  => 'margin-right',
        'bottom' => 'margin-bottom',
        'left'   => 'margin-left',
    ),
    true
);
BOLDPO_Helper::add_responsive_vars(
    $attributes,
    $subtitle_responsive,
    'subtitleTypography',
    '',
    array(
        'fontSize'      => 'font-size',
        'fontWeight'    => 'font-weight',
        'lineHeight'    => 'line-height',
        'textTransform' => 'text-transform',
        'letterSpacing' => 'letter-spacing',
    ),
    true
);

if ( ! empty( $attributes['subtitleColor'] ) ) {
    $subtitle_responsive['desktop']['color'] = $attributes['subtitleColor'];
}

$full_css  = BOLDPO_Helper::generate_responsive_css( $selector . ' .boldpo-info-box-list.style-' . $style . ' .boldpo-info-box-item', $item_responsive );
$full_css .= BOLDPO_Helper::generate_responsive_css( $selector . ' .boldpo-info-box-list.style-' . $style . ' .boldpo-info-box-item', $image_gap_responsive );
$full_css .= BOLDPO_Helper::generate_responsive_css( $selector . ' .boldpo-info-box-list.style-' . $style . ' .boldpo-info-box-image', $image_responsive );
$full_css .= BOLDPO_Helper::generate_responsive_css( $selector . ' .boldpo-info-box-list.style-' . $style . ' .boldpo-info-box-title', $title_responsive );
$full_css .= BOLDPO_Helper::generate_responsive_css( $selector . ' .boldpo-info-box-list.style-' . $style . ' .boldpo-info-box-subtitle', $subtitle_responsive );

wp_enqueue_style( $style_handle );
BOLDPO_Helper::add_custom_style(
    $style_handle,
    $selector,
    $full_css,
    array(
        '.boldpo-info-box-list.style-' . $style . ' .boldpo-info-box-item:hover'                  => BOLDPO_Helper::get_inline_styles( $item_hover ),
        '.boldpo-info-box-list.style-' . $style . ' .boldpo-info-box-item:hover .boldpo-info-box-title a' => BOLDPO_Helper::get_inline_styles( $title_hover ),
        '.boldpo-info-box-list.style-' . $style . ' .boldpo-info-box-image'                       => BOLDPO_Helper::get_inline_styles( $image_radius_styles ),
    )
);

$block_wrap_attr = get_block_wrapper_attributes( array( 'class' => 'boldpo-block boldpo-info-box-block-wrap ' . $unique_id ) );

$template_pl_path = BOLDPO_PL_PATH;
if ( $style !== 'default' && defined( 'BOLDPO_PRO_PL_PATH' ) ) {
    $template_pl_path = BOLDPO_PRO_PL_PATH;
}

if ( empty( $items ) || ! is_array( $items ) ) {
    return;
}
?>
<div <?php echo wp_kses_post( $block_wrap_attr ); ?>>
    <div class="boldpo-info-box-list style-<?php echo esc_attr( $style ); ?> boldpo-row <?php echo esc_attr( $gap_class ); ?> <?php echo esc_attr( $gap_row_class ); ?>">
        <?php
        foreach ( $items as $item ) :
            $item_title    = isset( $item['title'] ) ? $item['title'] : '';
            $item_subtitle = isset( $item['subtitle'] ) ? $item['subtitle'] : '';
            $item_image_id = isset( $item['imageId'] ) ? (int) $item['imageId'] : 0;
            $item_image_url = isset( $item['imageUrl'] ) ? $item['imageUrl'] : '';
            $item_image_alt = isset( $item['imageAlt'] ) ? $item['imageAlt'] : '';
            $item_url      = isset( $item['url'] ) && $item['url'] !== '' ? $item['url'] : '#';
            $item_new_tab  = ! empty( $item['openNewTab'] );

            // Prefer registered size when imageId is available
            if ( $item_image_id ) {
                $resolved = wp_get_attachment_image_url( $item_image_id, $image_size );
                if ( $resolved ) {
                    $item_image_url = $resolved;
                }
                if ( empty( $item_image_alt ) ) {
                    $item_image_alt = get_post_meta( $item_image_id, '_wp_attachment_image_alt', true );
                }
            }

            $style_file = $template_pl_path . 'public/template-parts/info-box/style-' . $style . '.php';
            if ( file_exists( $style_file ) ) {
                include $style_file;
            }
        endforeach;
        ?>
    </div>
</div>
