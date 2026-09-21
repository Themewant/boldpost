<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Local template variables.

$allowed_tags = [ 'div', 'section', 'article', 'aside' ];
$tag          = isset( $attributes['htmlTag'] ) && in_array( $attributes['htmlTag'], $allowed_tags, true )
    ? $attributes['htmlTag']
    : 'div';

$width_type   = isset( $attributes['widthType'] ) ? $attributes['widthType'] : 'percentage';
$vertical     = isset( $attributes['verticalAlign'] ) ? $attributes['verticalAlign'] : '';
$custom_class = isset( $attributes['customClass'] ) ? trim( (string) $attributes['customClass'] ) : '';
$unique_id    = ! empty( $attributes['blockId'] )
    ? sanitize_html_class( $attributes['blockId'] )
    : 'boldpo-col-' . wp_rand( 100, 99999 );

$selector = '.' . $unique_id;

$col_responsive = [ 'desktop' => [], 'tablet' => [], 'mobile' => [] ];

// Explicit per-device (Tablet/Mobile) width declarations are captured here so they
// can be re-emitted with a boosted selector + !important below. The parent row
// (layout-row/src/style.scss) force-stacks every column to 100% under 767px with an
// !important, higher-specificity rule, which otherwise cancels any Tablet/Mobile
// width the user sets on the column.
$width_override = [ 'tablet' => [], 'mobile' => [] ];

// Width handling per type.
$devices = [ '' => 'desktop', 'Tablet' => 'tablet', 'Mobile' => 'mobile' ];
foreach ( $devices as $suffix => $device ) {
    $width_decls = [];
    if ( $width_type === 'percentage' || $width_type === 'custom' ) {
        $w = isset( $attributes[ 'width' . $suffix ] ) ? trim( (string) $attributes[ 'width' . $suffix ] ) : '';
        if ( $w !== '' ) {
            if ( $width_type === 'percentage' ) {
                // Subtract this column's share of the row gap so columns total exactly
                // 100% of the row regardless of gap. Math runs in CSS via vars set by
                // the parent row (see layout-row/src/render.php): --bp-cols, --bp-gap.
                //   calc(W% - (cols - 1) * gap * W / 100)
                $w_num = (float) $w; // "50%" -> 50
                $calc  = sprintf(
                    'calc(%s - (var(--bp-cols, 1) - 1) * var(--bp-gap, 0px) * %s / 100)',
                    $w,
                    rtrim( rtrim( number_format( $w_num, 4, '.', '' ), '0' ), '.' )
                );
                $width_decls['flex']      = '0 1 ' . $calc;
                $width_decls['max-width'] = $calc;
            } else {
                $width_decls['width'] = $w;
                $width_decls['flex']  = '0 0 auto';
            }
        }
    } elseif ( $width_type === 'flex' ) {
        $grow  = isset( $attributes[ 'flexGrow' . $suffix ] ) ? trim( (string) $attributes[ 'flexGrow' . $suffix ] ) : '';
        $basis = isset( $attributes[ 'flexBasis' . $suffix ] ) ? trim( (string) $attributes[ 'flexBasis' . $suffix ] ) : '';
        if ( $grow !== '' )  $width_decls['flex-grow']  = (float) $grow;
        if ( $basis !== '' ) $width_decls['flex-basis'] = $basis;
    }
    foreach ( $width_decls as $prop => $val ) {
        $col_responsive[ $device ][ $prop ] = $val;
        if ( $device !== 'desktop' ) {
            $width_override[ $device ][ $prop ] = $val;
        }
    }
}

BOLDPO_Helper::add_responsive_vars( $attributes, $col_responsive, 'minHeight', 'min-height' );

// Padding / margin.
BOLDPO_Helper::add_responsive_vars( $attributes, $col_responsive, 'padding', '', [
    'top'    => 'padding-top',
    'right'  => 'padding-right',
    'bottom' => 'padding-bottom',
    'left'   => 'padding-left',
], true );
BOLDPO_Helper::add_responsive_vars( $attributes, $col_responsive, 'margin', '', [
    'top'    => 'margin-top',
    'right'  => 'margin-right',
    'bottom' => 'margin-bottom',
    'left'   => 'margin-left',
], true );

// Background.
if ( ! empty( $attributes['background'] ) ) {
    $col_responsive['desktop']['background-color'] = $attributes['background'];
}
if ( ! empty( $attributes['backgroundGradient'] ) ) {
    $col_responsive['desktop']['background-image'] = $attributes['backgroundGradient'];
}

// Border.
if ( ! empty( $attributes['border'] ) ) {
    foreach ( BOLDPO_Helper::border_to_css_props( $attributes['border'] ) as $prop => $val ) {
        $col_responsive['desktop'][ $prop ] = $val;
    }
}

// Border radius.
$radius = isset( $attributes['borderRadius'] ) ? $attributes['borderRadius'] : [];
if ( ! empty( $radius['top'] ) )    $col_responsive['desktop']['border-top-left-radius']     = BOLDPO_Helper::ensure_unit( $radius['top'] );
if ( ! empty( $radius['right'] ) )  $col_responsive['desktop']['border-top-right-radius']    = BOLDPO_Helper::ensure_unit( $radius['right'] );
if ( ! empty( $radius['bottom'] ) ) $col_responsive['desktop']['border-bottom-right-radius'] = BOLDPO_Helper::ensure_unit( $radius['bottom'] );
if ( ! empty( $radius['left'] ) )   $col_responsive['desktop']['border-bottom-left-radius']  = BOLDPO_Helper::ensure_unit( $radius['left'] );

// Box shadow.
if ( ! empty( $attributes['boxShadow'] ) && ! empty( $attributes['boxShadow']['c'] ) && $attributes['boxShadow']['c'] !== 'rgba(0,0,0,0)' ) {
    $col_responsive['desktop']['box-shadow'] = BOLDPO_Helper::box_shadow_to_css( $attributes['boxShadow'] );
}

if ( $vertical ) {
    $col_responsive['desktop']['align-self'] = $vertical;
}

// Content flexbox — the inner wrapper becomes a flex container ONLY when the user
// sets at least one flex option (otherwise it stays normal block flow, so the empty
// appender / stacked content is not disturbed).
$inner_selector   = $selector . ' > .boldpo-column__inner';
$inner_responsive = [ 'desktop' => [], 'tablet' => [], 'mobile' => [] ];
BOLDPO_Helper::add_responsive_vars( $attributes, $inner_responsive, 'flexDirection',  'flex-direction' );
BOLDPO_Helper::add_responsive_vars( $attributes, $inner_responsive, 'justifyContent', 'justify-content' );
BOLDPO_Helper::add_responsive_vars( $attributes, $inner_responsive, 'alignItems',     'align-items' );
BOLDPO_Helper::add_responsive_vars( $attributes, $inner_responsive, 'alignContent',   'align-content' );
BOLDPO_Helper::add_responsive_vars( $attributes, $inner_responsive, 'flexWrap',       'flex-wrap' );
BOLDPO_Helper::add_responsive_vars( $attributes, $inner_responsive, 'contentGap',     'gap' );
if ( ! empty( $inner_responsive['desktop'] ) || ! empty( $inner_responsive['tablet'] ) || ! empty( $inner_responsive['mobile'] ) ) {
    $inner_responsive['desktop'] = array_merge( [ 'display' => 'flex' ], $inner_responsive['desktop'] );
}

// Compile CSS.
$style_handle = 'boldpo-column-style';
$css  = BOLDPO_Helper::generate_responsive_css( $selector, $col_responsive );
$css .= BOLDPO_Helper::generate_responsive_css( $inner_selector, $inner_responsive );

// Re-emit any explicit Tablet/Mobile width with a boosted selector + !important so
// it wins over the row's blanket mobile stacking rule (which is !important and has
// specificity 0,3,0). Stacking three of the column's own classes matches that
// specificity, and this rule is printed after it, so the cascade resolves in favour
// of the user's width. Only emitted when a Tablet/Mobile width is actually set, so
// desktop output and columns without a per-device width are untouched. Breakpoints
// mirror BOLDPO_Helper::generate_responsive_css().
$override_selector = $selector . '.boldpo-column.boldpo-block';
$override_media    = [ 'tablet' => '@media (max-width: 1024px)', 'mobile' => '@media (max-width: 767px)' ];
foreach ( $override_media as $device => $media ) {
    if ( ! empty( $width_override[ $device ] ) ) {
        $decls = '';
        foreach ( $width_override[ $device ] as $prop => $val ) {
            $decls .= $prop . ':' . wp_strip_all_tags( $val ) . ' !important;';
        }
        $css .= $media . ' { ' . $override_selector . ' { ' . $decls . ' } }' . "\n";
    }
}

wp_enqueue_style( $style_handle );
BOLDPO_Helper::add_custom_style( $style_handle, $selector, $css, [] );

$classes = [
    'boldpo-block',
    'boldpo-column',
    $unique_id,
];
if ( $vertical ) $classes[] = 'is-self-' . sanitize_html_class( $vertical );
if ( ! empty( $attributes['hideDesktop'] ) ) $classes[] = 'boldpo-hide-desktop';
if ( ! empty( $attributes['hideTablet'] ) )  $classes[] = 'boldpo-hide-tablet';
if ( ! empty( $attributes['hideMobile'] ) )  $classes[] = 'boldpo-hide-mobile';
if ( $custom_class ) {
    foreach ( explode( ' ', $custom_class ) as $c ) {
        $c = sanitize_html_class( $c );
        if ( $c ) $classes[] = $c;
    }
}

$wrapper_attrs = get_block_wrapper_attributes( [ 'class' => implode( ' ', $classes ) ] );

printf(
    '<%1$s %2$s><div class="boldpo-column__inner">%3$s</div></%1$s>',
    tag_escape( $tag ),
    $wrapper_attrs, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from get_block_wrapper_attributes()
    $content        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $content is pre-rendered inner blocks HTML
);
