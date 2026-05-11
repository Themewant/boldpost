<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$text           = isset($attributes['text']) ? $attributes['text'] : '';
$url            = isset($attributes['url']) ? $attributes['url'] : '#';
$open_in_new    = !empty($attributes['openInNewTab']);
$rel            = isset($attributes['rel']) ? $attributes['rel'] : '';
$show_icon      = !empty($attributes['showIcon']) && !empty($attributes['iconType']) && $attributes['iconType'] !== 'none';
$icon_position  = isset($attributes['iconPosition']) ? $attributes['iconPosition'] : 'right';
$icon_type      = isset($attributes['iconType']) ? $attributes['iconType'] : 'chevron-right';
$icon_hover_animation  = isset($attributes['iconHoverAnimation']) ? $attributes['iconHoverAnimation'] : 'none';
$button_width   = isset($attributes['buttonWidth']) ? $attributes['buttonWidth'] : 'auto';
$text_align     = isset($attributes['textAlign']) ? $attributes['textAlign'] : '';

// Button responsive styles
$button_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];

// Typography
BOLDPO_Helper::add_responsive_vars($attributes, $button_responsive, 'typography', '', [
    'fontSize'=>'font-size',
    'fontWeight'=>'font-weight',
    'lineHeight'=>'line-height',
    'textTransform'=>'text-transform',
    'letterSpacing'=>'letter-spacing'
], true);

// Padding (responsive)
BOLDPO_Helper::add_responsive_vars($attributes, $button_responsive, 'buttonPadding', '', [
    'top'=>'padding-top',
    'right'=>'padding-right',
    'bottom'=>'padding-bottom',
    'left'=>'padding-left'
], true);

// Background color
if ( ! empty( $attributes['buttonBackground'] ) ) {
    $button_responsive['desktop']['background-color'] = $attributes['buttonBackground'];
}

// Text color
if ( ! empty( $attributes['textColor'] ) ) {
    $button_responsive['desktop']['color'] = $attributes['textColor'];
}

// Border radius
$b_radius = $attributes['borderRadius'] ?? [];
if ( ! empty( $b_radius['top'] ) )    $button_responsive['desktop']['border-top-left-radius']     = BOLDPO_Helper::ensure_unit( $b_radius['top'] );
if ( ! empty( $b_radius['right'] ) )  $button_responsive['desktop']['border-top-right-radius']    = BOLDPO_Helper::ensure_unit( $b_radius['right'] );
if ( ! empty( $b_radius['bottom'] ) ) $button_responsive['desktop']['border-bottom-right-radius'] = BOLDPO_Helper::ensure_unit( $b_radius['bottom'] );
if ( ! empty( $b_radius['left'] ) )   $button_responsive['desktop']['border-bottom-left-radius']  = BOLDPO_Helper::ensure_unit( $b_radius['left'] );

// Border
if ( ! empty( $attributes['border'] ) ) {
    foreach ( BOLDPO_Helper::border_to_css_props( $attributes['border'] ) as $prop => $val ) {
        $button_responsive['desktop'][$prop] = $val;
    }
}

// Button width
BOLDPO_Helper::add_responsive_vars($attributes, $button_responsive, 'buttonWidth', 'width', [], false);

// Icon gap
if ( ! empty( $attributes['iconGap'] ) ) {
    $button_responsive['desktop']['gap'] = BOLDPO_Helper::ensure_unit( $attributes['iconGap'] );
}

// Icon styles
$icon_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
if ( ! empty( $attributes['iconColor'] ) ) {
    $icon_responsive['desktop']['color'] = $attributes['iconColor'];
}
if ( ! empty( $attributes['iconSize'] ) ) {
    $icon_responsive['desktop']['font-size'] = BOLDPO_Helper::ensure_unit( $attributes['iconSize'] );
}
if ( ! empty( $attributes['iconSizeTablet'] ) ) {
    $icon_responsive['tablet']['font-size'] = BOLDPO_Helper::ensure_unit( $attributes['iconSizeTablet'] );
}
if ( ! empty( $attributes['iconSizeMobile'] ) ) {
    $icon_responsive['mobile']['font-size'] = BOLDPO_Helper::ensure_unit( $attributes['iconSizeMobile'] );
}

// Wrapper styles
$wrapper_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
if ( ! empty( $text_align ) ) {
    $wrapper_responsive['desktop']['text-align'] = $text_align;
}

// Hover styles
$button_hover = [];
if ( ! empty( $attributes['buttonBackgroundHover'] ) ) {
    $button_hover['background-color'] = $attributes['buttonBackgroundHover'] . ' !important';
}
if ( ! empty( $attributes['textColorHover'] ) ) {
    $button_hover['color'] = $attributes['textColorHover'] . ' !important';
}

// Hover border
if ( ! empty( $attributes['borderHover'] ) ) {
    foreach ( BOLDPO_Helper::border_to_css_props( $attributes['borderHover'] ) as $prop => $val ) {
        $button_hover[ $prop ] = $val . ' !important';
    }
}

$icon_hover = [];
if ( ! empty( $attributes['iconColorHover'] ) ) {
    $icon_hover['color'] = $attributes['iconColorHover'] . ' !important';
}

// Generate CSS
$style_handle = 'boldpo-button-style';
$unique_id    = 'boldpo-' . wp_rand( 100, 99999 );
$selector     = '.' . $unique_id;

$full_responsive_css  = BOLDPO_Helper::generate_responsive_css( $selector . ' .boldpo-button', $wrapper_responsive );
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css( $selector . ' .boldpo-button .boldpo-button-link', $button_responsive );
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css( $selector . ' .boldpo-button .boldpo-button-icon', $icon_responsive );

wp_enqueue_style( $style_handle );

$sub_styles = [];
$button_hover_css = BOLDPO_Helper::get_inline_styles( $button_hover );
if ( $button_hover_css ) {
    $sub_styles['.boldpo-button .boldpo-button-link:hover'] = $button_hover_css;
}
$icon_hover_css = BOLDPO_Helper::get_inline_styles( $icon_hover );
if ( $icon_hover_css ) {
    $sub_styles['.boldpo-button .boldpo-button-link:hover .boldpo-button-icon'] = $icon_hover_css;
}

BOLDPO_Helper::add_custom_style( $style_handle, $selector, $full_responsive_css, $sub_styles );

$block_wrap_attr = get_block_wrapper_attributes( array( 'class' => 'boldpo-block boldpo-button-block-wrap ' . $unique_id ) );

// Link attributes
$link_attrs = '';
if ( $open_in_new ) {
    $link_attrs .= ' target="_blank"';
}
if ( ! empty( $rel ) ) {
    $link_attrs .= ' rel="' . esc_attr( $rel ) . '"';
} elseif ( $open_in_new ) {
    $link_attrs .= ' rel="noopener noreferrer"';
}

if ( ! empty( $text ) ) :
?>
    <div <?php echo wp_kses_post( $block_wrap_attr ); ?>>
        <div class="boldpo-button">
            <a href="<?php echo esc_url( $url ); ?>" class="boldpo-button-link icon-<?php echo esc_attr( $icon_position ); ?> icon-animation-<?php echo esc_attr( $icon_hover_animation ); ?>"<?php echo $link_attrs; ?>>
                <?php if ( $show_icon && $icon_position === 'left' ) : ?>
                    <i class="boldpo-button-icon <?php echo esc_attr( $icon_type ); ?>"></i>
                <?php endif; ?>
                <span class="boldpo-button-text"><?php echo esc_html( $text ); ?></span>
                <?php if ( $show_icon && $icon_position === 'right' ) : ?>
                    <i class="boldpo-button-icon <?php echo esc_attr( $icon_type ); ?>"></i>
                <?php endif; ?>
            </a>
        </div>
    </div>
<?php
else:
?>
    <div <?php echo wp_kses_post( get_block_wrapper_attributes() ); ?>>
        <p><?php esc_html_e( 'Add button text', 'boldpost' ); ?></p>
    </div>
<?php
endif;
?>
