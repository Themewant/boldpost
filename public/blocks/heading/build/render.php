<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

// Attributes are available as $attributes array
$style = isset($attributes['layoutStyle']) ? $attributes['layoutStyle'] : '1';
$show_description = !empty($attributes['showDescription']) ? true : false;
$title_tag = isset($attributes['titleTag']) ? $attributes['titleTag'] : 'h3';

// styles
$responsive_data = [
    'desktop' => [],
    'tablet'  => [],
    'mobile'  => []
];

// Title
$title_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
BOLDPO_Helper::add_responsive_vars($attributes, $title_responsive, 'titleMargin', '', ['top'=>'margin-top','right'=>'margin-right','bottom'=>'margin-bottom','left'=>'margin-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $title_responsive, 'titleTypography', '', [
    'fontSize'=>'font-size', 
    'fontWeight'=>'font-weight', 
    'lineHeight'=>'line-height', 
    'textTransform'=>'text-transform', 
    'letterSpacing'=>'letter-spacing'
], true);

if ( ! empty( $attributes['titleColor'] ) ) {
    $title_responsive['desktop']['color'] = $attributes['titleColor'];
}

// Title padding (non-responsive)
$t_padding = $attributes['titlePadding'] ?? [];
if ( ! empty( $t_padding['top'] ) )    $title_responsive['desktop']['padding-top']    = BOLDPO_Helper::ensure_unit( $t_padding['top'] );
if ( ! empty( $t_padding['right'] ) )  $title_responsive['desktop']['padding-right']  = BOLDPO_Helper::ensure_unit( $t_padding['right'] );
if ( ! empty( $t_padding['bottom'] ) ) $title_responsive['desktop']['padding-bottom'] = BOLDPO_Helper::ensure_unit( $t_padding['bottom'] );
if ( ! empty( $t_padding['left'] ) )   $title_responsive['desktop']['padding-left']   = BOLDPO_Helper::ensure_unit( $t_padding['left'] );

// Title hover
$item_hover = [];
if ( ! empty( $attributes['titleColorHover'] ) ) {
    $item_hover['color'] = $attributes['titleColorHover'] . ' !important';
}

// Description
$description_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
BOLDPO_Helper::add_responsive_vars($attributes, $description_responsive, 'descriptionMargin', '', ['top'=>'margin-top','right'=>'margin-right','bottom'=>'margin-bottom','left'=>'margin-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $description_responsive, 'descriptionTypography', '', [
    'fontSize'=>'font-size',
    'fontWeight'=>'font-weight',
    'lineHeight'=>'line-height',
    'textTransform'=>'text-transform',
    'letterSpacing'=>'letter-spacing'
], true);

if ( ! empty( $attributes['descriptionColor'] ) ) {
    $description_responsive['desktop']['color'] = $attributes['descriptionColor'];
}

// Description padding (non-responsive)
$d_padding = $attributes['descriptionPadding'] ?? [];
if ( ! empty( $d_padding['top'] ) )    $description_responsive['desktop']['padding-top']    = BOLDPO_Helper::ensure_unit( $d_padding['top'] );
if ( ! empty( $d_padding['right'] ) )  $description_responsive['desktop']['padding-right']  = BOLDPO_Helper::ensure_unit( $d_padding['right'] );
if ( ! empty( $d_padding['bottom'] ) ) $description_responsive['desktop']['padding-bottom'] = BOLDPO_Helper::ensure_unit( $d_padding['bottom'] );
if ( ! empty( $d_padding['left'] ) )   $description_responsive['desktop']['padding-left']   = BOLDPO_Helper::ensure_unit( $d_padding['left'] );

// Text alignment
if ( ! empty( $attributes['textAlign'] ) ) {
    $responsive_data['desktop']['text-align'] = $attributes['textAlign'];
}

$style_handle = 'boldpo-heading-style';
$unique_id    = 'boldpo-' . wp_rand( 100, 99999 );
$selector     = '.' . $unique_id;

// Border line & dot (style 2 only)
$border_line_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
$dot_responsive         = ['desktop' => [], 'tablet' => [], 'mobile' => []];
if ( $style === '2' ) {
    if ( ! empty( $attributes['borderLineColor'] ) ) {
        $border_line_responsive['desktop']['background-color'] = $attributes['borderLineColor'];
    }
    if ( ! empty( $attributes['borderLineWidth'] ) ) {
        $border_line_responsive['desktop']['width'] = intval( $attributes['borderLineWidth'] ) . 'px';
    }
    if ( ! empty( $attributes['borderLineHeight'] ) ) {
        $border_line_responsive['desktop']['height'] = intval( $attributes['borderLineHeight'] ) . 'px';
    }
    if ( ! empty( $attributes['dotColor'] ) ) {
        $dot_responsive['desktop']['background-color'] = $attributes['dotColor'];
    }
    if ( ! empty( $attributes['dotSize'] ) ) {
        $dot_size = intval( $attributes['dotSize'] ) . 'px';
        $dot_responsive['desktop']['width']  = $dot_size;
        $dot_responsive['desktop']['height'] = $dot_size;
    }
}

$full_responsive_css  = BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-heading.style-' . $style, $responsive_data);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-heading.style-' . $style . ' .boldpo-heading-title-wrap', $title_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-heading.style-' . $style . ' .boldpo-heading-description', $description_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-heading.style-' . $style . ' .boldpo-heading-border-line', $border_line_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-heading.style-' . $style . ' .boldpo-heading-dot', $dot_responsive);

wp_enqueue_style( $style_handle );
BOLDPO_Helper::add_custom_style( $style_handle, $selector, $full_responsive_css, [
    $selector . ' .boldpo-heading.style-' . $style . ' .boldpo-heading-title:hover' => BOLDPO_Helper::get_inline_styles($item_hover),
] );

$block_wrap_attr = get_block_wrapper_attributes( array( 'class' => 'boldpo-block boldpo-heading-block-wrap ' . $unique_id ) );

if ( ! empty( $attributes['title'] ) ) :
?>
    <div <?php echo wp_kses_post($block_wrap_attr); ?>>
        <div class="boldpo-heading style-<?php echo esc_attr($style); ?>">
            <?php
            if($style == '1') {
                ?>
                <div class="boldpo-heading-title-wrap">
                    <<?php echo esc_attr($title_tag); ?> class="boldpo-heading-title"><?php echo esc_html($attributes['title']); ?></<?php echo esc_attr($title_tag); ?>>
                </div>
                <?php if($attributes['showDescription']) { ?>
                    <p class="boldpo-heading-description"><?php echo esc_html($attributes['description']); ?></p>
                <?php } ?>
                <?php
            }else{
                ?>
                <div class="boldpo-heading-title-wrap">
                    <span class="boldpo-heading-dot"></span>
                    <<?php echo esc_attr($title_tag); ?> class="boldpo-heading-title"><?php echo esc_html($attributes['title']); ?></<?php echo esc_attr($title_tag); ?>>
                    <span class="boldpo-heading-border-line"></span>
                </div>
                <?php if($attributes['showDescription']) { ?>
                    <p class="boldpo-heading-description"><?php echo esc_html($attributes['description']); ?></p>
                <?php } ?>
                <?php
            }
            ?>
        </div>
    </div>
<?php
else:
    ?>
    <div <?php echo wp_kses_post(get_block_wrapper_attributes()); ?>>
        <p><?php esc_html_e('Add a title', 'boldpost'); ?></p>
    </div>
    <?php
endif;
?>
