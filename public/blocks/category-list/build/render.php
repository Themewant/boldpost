<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

// Attributes are available as $attributes array
$per_page = isset($attributes['perPage']) ? $attributes['perPage'] : 9;
$order = isset($attributes['order']) ? $attributes['order'] : 'ASC';
$orderby = isset($attributes['orderby']) ? $attributes['orderby'] : 'name';
$columns = isset($attributes['columns']) ? $attributes['columns'] : '';
$style = isset($attributes['listStyle']) ? $attributes['listStyle'] : '1';
$hide_empty = !empty($attributes['hideEmpty']) ? true : false;
$show_count = !empty($attributes['showCount']) ? true : false;
$show_empty_count = !empty($attributes['showEmptyCount']) ? true : false;
$show_description = !empty($attributes['showDescription']) ? true : false;
$title_tag = isset($attributes['titleTag']) ? $attributes['titleTag'] : 'h3';
$thumbnail_size = isset($attributes['thumbnailSize']) ? $attributes['thumbnailSize'] : 'medium';
$details_btn_text = isset($attributes['detailsBtnLabel']) ? $attributes['detailsBtnLabel'] : 'Details';

// styles
$responsive_data = [
    'desktop' => [],
    'tablet'  => [],
    'mobile'  => []
];

// Columns
if (in_array($style, ['1', '2'])) {
    $default_column = 6;
} else {
    $default_column = 1;
}
$c_desktop = isset($attributes['columns']) ? (int)$attributes['columns'] : $default_column;
$c_tablet  = isset($attributes['columnsTablet']) ? (int)$attributes['columnsTablet'] : $c_desktop;
$c_mobile  = isset($attributes['columnsMobile']) ? (int)$attributes['columnsMobile'] : 1;

// Use calc()-based widths so any column count 1–12 lays out correctly.
// Bootstrap's 12-col grid only divides cleanly for 1, 2, 3, 4, 6, 12.
$col_class = 'boldpo-category-col';

$column_responsive = [
    'desktop' => [
        'flex'      => '0 0 auto',
        'width'     => 'calc(100% / ' . max(1, $c_desktop) . ')',
        'max-width' => 'calc(100% / ' . max(1, $c_desktop) . ')',
    ],
    'tablet' => [
        'flex'      => '0 0 auto',
        'width'     => 'calc(100% / ' . max(1, $c_tablet) . ')',
        'max-width' => 'calc(100% / ' . max(1, $c_tablet) . ')',
    ],
    'mobile' => [
        'flex'      => '0 0 auto',
        'width'     => 'calc(100% / ' . max(1, $c_mobile) . ')',
        'max-width' => 'calc(100% / ' . max(1, $c_mobile) . ')',
    ],
];

// Gaps
$g_desktop = isset($attributes['itemGap']) ? $attributes['itemGap'] : '';

if (empty($g_desktop) && $style === '2') {
    $g_desktop = 3;
}else{
    $g_desktop = 4;
}

$g_tablet = isset($attributes['itemGapTablet']) ? $attributes['itemGapTablet'] : $g_desktop;
$g_mobile = isset($attributes['itemGapMobile']) ? $attributes['itemGapMobile'] : 0;

$gap_class = '';
if ($g_desktop == $g_tablet && $g_tablet == $g_mobile) {
    $gap_class = 'boldpo-gx-' . $g_desktop;
} else {
    $gap_class = 'boldpo-gx-lg-' . $g_desktop . ' boldpo-gx-md-' . $g_tablet . ' boldpo-gx-sm-' . $g_mobile;
}

$g_row_desktop = isset($attributes['itemRowGap']) ? $attributes['itemRowGap'] : '4';
$g_row_tablet = isset($attributes['itemRowGapTablet']) ? $attributes['itemRowGapTablet'] : $g_row_desktop;
$g_row_mobile = isset($attributes['itemRowGapMobile']) ? $attributes['itemRowGapMobile'] : 0;

$gap_row_class = '';
if ($g_row_desktop == $g_row_tablet && $g_row_tablet == $g_row_mobile) {
    $gap_row_class = 'boldpo-gy-' . $g_row_desktop;
} else {
    $gap_row_class = 'boldpo-gy-lg-' . $g_row_desktop . ' boldpo-gy-md-' . $g_row_tablet . ' boldpo-gy-sm-' . $g_row_mobile;
}

// Item Styles
$item_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
BOLDPO_Helper::add_responsive_vars($attributes, $item_responsive, 'itemPadding', '', ['top'=>'padding-top','right'=>'padding-right','bottom'=>'padding-bottom','left'=>'padding-left'], true);

$item_desktop = [];
if ( ! empty( $attributes['itemBackgroundColor'] ) ) {
    $item_desktop['background-color'] = $attributes['itemBackgroundColor'];
}
if ( ! empty( $attributes['itemBackgroundGradient'] ) ) {
    $item_desktop['background'] = $attributes['itemBackgroundGradient'];
}

$i_border_radius = $attributes['itemBorderRadius'] ?? [];
if ( ! empty( $i_border_radius['top'] ) ) $item_desktop['border-top-left-radius'] = BOLDPO_Helper::ensure_unit( $i_border_radius['top'] );
if ( ! empty( $i_border_radius['right'] ) ) $item_desktop['border-top-right-radius'] = BOLDPO_Helper::ensure_unit( $i_border_radius['right'] );
if ( ! empty( $i_border_radius['bottom'] ) ) $item_desktop['border-bottom-left-radius'] = BOLDPO_Helper::ensure_unit( $i_border_radius['bottom'] );
if ( ! empty( $i_border_radius['left'] ) ) $item_desktop['border-bottom-right-radius'] = BOLDPO_Helper::ensure_unit( $i_border_radius['left'] );

$item_responsive['desktop'] = array_merge($item_responsive['desktop'], $item_desktop);

// Hover background
$item_hover = [];
if(!empty($attributes['itemBackgroundColorHover'])) {
    $item_hover['background-color'] = $attributes['itemBackgroundColorHover'] . ' !important';
}
if(!empty($attributes['itemBackgroundGradientHover'])) {
    $item_hover['background'] = $attributes['itemBackgroundGradientHover'] . ' !important';
}

// content align
$content_align_class = '';


if ( ! empty( $attributes['contentAlign'] ) ) {
    $content_align_class = 'boldpo-text-' . $attributes['contentAlign'];
}

// Title
$title_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
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

// Description
$description_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
BOLDPO_Helper::add_responsive_vars($attributes, $description_responsive, 'itemDescriptionMargin', '', ['top'=>'margin-top','right'=>'margin-right','bottom'=>'margin-bottom','left'=>'margin-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $description_responsive, 'itemDescriptionTypography', '', [
    'fontSize'=>'font-size', 
    'fontWeight'=>'font-weight', 
    'lineHeight'=>'line-height', 
    'textTransform'=>'text-transform', 
    'letterSpacing'=>'letter-spacing'
], true);

if ( ! empty( $attributes['itemDescriptionColor'] ) ) {
    $description_responsive['desktop']['color'] = $attributes['itemDescriptionColor'];
}

// Count Badge Styles
$count_styles = [];
if ( ! empty( $attributes['countColor'] ) ) {
    $count_styles['color'] = $attributes['countColor'];
}
if ( ! empty( $attributes['countBackgroundColor'] ) ) {
    $count_styles['background-color'] = $attributes['countBackgroundColor'];
}
$c_padding = $attributes['countPadding'] ?? [];
if ( ! empty( $c_padding['top'] ) ) $count_styles['padding-top'] = BOLDPO_Helper::ensure_unit( $c_padding['top'] );
if ( ! empty( $c_padding['right'] ) ) $count_styles['padding-right'] = BOLDPO_Helper::ensure_unit( $c_padding['right'] );
if ( ! empty( $c_padding['bottom'] ) ) $count_styles['padding-bottom'] = BOLDPO_Helper::ensure_unit( $c_padding['bottom'] );
if ( ! empty( $c_padding['left'] ) ) $count_styles['padding-left'] = BOLDPO_Helper::ensure_unit( $c_padding['left'] );

$c_border_radius = $attributes['countBorderRadius'] ?? [];
if ( ! empty( $c_border_radius['top'] ) ) $count_styles['border-top-left-radius'] = BOLDPO_Helper::ensure_unit( $c_border_radius['top'] );
if ( ! empty( $c_border_radius['right'] ) ) $count_styles['border-top-right-radius'] = BOLDPO_Helper::ensure_unit( $c_border_radius['right'] );
if ( ! empty( $c_border_radius['bottom'] ) ) $count_styles['border-bottom-left-radius'] = BOLDPO_Helper::ensure_unit( $c_border_radius['bottom'] );
if ( ! empty( $c_border_radius['left'] ) ) $count_styles['border-bottom-right-radius'] = BOLDPO_Helper::ensure_unit( $c_border_radius['left'] );

$c_typo = $attributes['countTypography'] ?? [];
if ( ! empty( $c_typo['fontSize'] ) ) $count_styles['font-size'] = $c_typo['fontSize'];
if ( ! empty( $c_typo['fontWeight'] ) ) $count_styles['font-weight'] = $c_typo['fontWeight'];
if ( ! empty( $c_typo['lineHeight'] ) ) $count_styles['line-height'] = $c_typo['lineHeight'];
if ( ! empty( $c_typo['textTransform'] ) ) $count_styles['text-transform'] = $c_typo['textTransform'];
if ( ! empty( $c_typo['letterSpacing'] ) ) $count_styles['letter-spacing'] = $c_typo['letterSpacing'];

// Thumbnail Styles
$thumbnail_styles = [];
$t_border_radius = $attributes['thumbnailBorderRadius'] ?? [];
if ( ! empty( $t_border_radius['top'] ) ) $thumbnail_styles['border-top-left-radius'] = BOLDPO_Helper::ensure_unit( $t_border_radius['top'] );
if ( ! empty( $t_border_radius['right'] ) ) $thumbnail_styles['border-top-right-radius'] = BOLDPO_Helper::ensure_unit( $t_border_radius['right'] );
if ( ! empty( $t_border_radius['bottom'] ) ) $thumbnail_styles['border-bottom-left-radius'] = BOLDPO_Helper::ensure_unit( $t_border_radius['bottom'] );
if ( ! empty( $t_border_radius['left'] ) ) $thumbnail_styles['border-bottom-right-radius'] = BOLDPO_Helper::ensure_unit( $t_border_radius['left'] );



// Details Button
$details_btn_responsive = ['desktop' => [], 'tablet' => [], 'mobile' => []];
BOLDPO_Helper::add_responsive_vars($attributes, $details_btn_responsive, 'detailsBtnPadding', '', ['top'=>'padding-top','right'=>'padding-right','bottom'=>'padding-bottom','left'=>'padding-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $details_btn_responsive, 'detailsBtnTypography', '', [
    'fontSize'=>'font-size', 
    'fontWeight'=>'font-weight', 
    'lineHeight'=>'line-height', 
    'textTransform'=>'text-transform', 
    'letterSpacing'=>'letter-spacing'
], true);
BOLDPO_Helper::add_responsive_vars($attributes, $details_btn_responsive, 'detailsBtnMargin', '', ['top'=>'margin-top','right'=>'margin-right','bottom'=>'margin-bottom','left'=>'margin-left'], true);
BOLDPO_Helper::add_responsive_vars($attributes, $details_btn_responsive, 'detailsBtnBorderRadius', '', ['top'=>'border-top-left-radius','right'=>'border-top-right-radius','bottom'=>'border-bottom-left-radius','left'=>'border-bottom-right-radius'], true);

if ( ! empty( $attributes['detailsBtnColor'] ) ) {
    $details_btn_responsive['desktop']['color'] = $attributes['detailsBtnColor'];
}
if ( ! empty( $attributes['detailsBtnBackgroundColor'] ) ) {
    $details_btn_responsive['desktop']['background-color'] = $attributes['detailsBtnBackgroundColor'];
}
if ( ! empty( $attributes['detailsBtnBackgroundGradient'] ) ) {
    $details_btn_responsive['desktop']['background'] = $attributes['detailsBtnBackgroundGradient'];
}
if ( ! empty( $attributes['detailsBtnBorder'] ) ) {
    foreach ( BOLDPO_Helper::border_to_css_props( $attributes['detailsBtnBorder'] ) as $prop => $val ) {
        $details_btn_responsive['desktop'][$prop] = $val;
    }
}

// Details Button Hover
$details_btn_hover = [];
if(!empty($attributes['detailsBtnBackgroundColorHover'])) {
    $details_btn_hover['background-color'] = $attributes['detailsBtnBackgroundColorHover'] . ' !important';
}
if(!empty($attributes['detailsBtnBackgroundGradientHover'])) {
    $details_btn_hover['background'] = $attributes['detailsBtnBackgroundGradientHover'] . ' !important';
}
if(!empty($attributes['detailsBtnColorHover'])) {
    $details_btn_hover['color'] = $attributes['detailsBtnColorHover'] . ' !important';
}
if ( ! empty( $attributes['detailsBtnBorderHover'] ) ) {
    foreach ( BOLDPO_Helper::border_to_css_props( $attributes['detailsBtnBorderHover'] ) as $prop => $val ) {
        $details_btn_hover[$prop] = $val . ' !important';
    }
}

$style_handle = 'boldpo-category-list-style';
$unique_id    = 'boldpo-' . wp_rand( 100, 99999 );
$selector     = '.boldpo-category-list-block-wrap.' . $unique_id;

$full_responsive_css = BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-category-list', $responsive_data);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-category-list > .boldpo-category-col', $column_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-category-list.style-' . $style . ' .boldpo-category-item', $item_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-category-list.style-' . $style . ' .boldpo-category-item .boldpo-category-content .boldpo-category-content-text .boldpo-category-title', $title_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-category-list.style-' . $style . ' .boldpo-category-item .boldpo-category-content .boldpo-category-content-text .boldpo-category-description', $description_responsive);
$full_responsive_css .= BOLDPO_Helper::generate_responsive_css($selector . ' .boldpo-category-list.style-' . $style . ' .boldpo-category-item .boldpo-category-content .boldpo-category-content-text .boldpo-category-details-btn', $details_btn_responsive);


wp_enqueue_style( $style_handle );
BOLDPO_Helper::add_custom_style( $style_handle, $selector, $full_responsive_css, [
    '.boldpo-category-list.style-' . $style . ' .boldpo-category-item .boldpo-category-item:hover'  => BOLDPO_Helper::get_inline_styles($item_hover),
    '.boldpo-category-list.style-' . $style . ' .boldpo-category-item .boldpo-category-content .boldpo-category-count' => BOLDPO_Helper::get_inline_styles($count_styles),
    '.boldpo-category-list.style-' . $style . ' .boldpo-category-item .boldpo-category-content .boldpo-category-content-text .boldpo-category-image' => BOLDPO_Helper::get_inline_styles($thumbnail_styles),
    '.boldpo-category-list.style-' . $style . ' .boldpo-category-item .boldpo-category-content .boldpo-category-content-text .boldpo-category-details-btn:hover' => BOLDPO_Helper::get_inline_styles($details_btn_hover),
] );

// Build query arguments
$args = array(
    'taxonomy'   => 'category',
    'number'     => (int) $per_page,
    'hide_empty' => $hide_empty,
    'order'      => in_array( $order, ['ASC','DESC'], true ) ? $order : 'ASC',
    'orderby'    => $orderby,
);

if ( ! empty( $attributes['includes'] ) && ! in_array( 'all', $attributes['includes'] ) ) {
    $args['include'] = array_map( 'intval', $attributes['includes'] );
}

if ( ! empty( $attributes['excludes'] ) && ! in_array( 'no-excludes', $attributes['excludes'] ) ) {
    // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- User-controlled exclusion is intentional
    $args['exclude'] = array_map( 'intval', $attributes['excludes'] );
}

$categories = get_terms( $args );
$block_wrap_attr = get_block_wrapper_attributes( array( 'class' => 'boldpo-block boldpo-category-list-block-wrap ' . $unique_id ) );

$template_pl_path = BOLDPO_PL_PATH;
if($style !== 'default' && defined('BOLDPO_PRO_PL_PATH')) {
    $template_pl_path = BOLDPO_PRO_PL_PATH;
}

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
?>
    <div <?php echo wp_kses_post($block_wrap_attr); ?>>
        <div class="boldpo-category-list style-<?php echo esc_attr($style); ?> boldpo-row <?php echo esc_attr($gap_class); ?> <?php echo esc_attr($gap_row_class); ?>">
            <?php
            foreach ( $categories as $category ) :
                $category_link = get_term_link( $category );
                if ( is_wp_error( $category_link ) ) {
                    continue;
                }
                $category_image_id = get_term_meta( $category->term_id, 'category_image', true );
                $category_image = wp_get_attachment_image_url( $category_image_id, $thumbnail_size );
                $placeholderImage = BOLDPO_PL_URL . 'public/assets/img/placeholder.png';
                $category_image = $category_image ? $category_image : $placeholderImage;
                $category_color = get_term_meta( $category->term_id, 'category_color', true );
                $category_gradient = 'linear-gradient(to top, '.$category_color.', rgba(255, 255, 255, 0))';
                $style_file = $template_pl_path . 'public/template-parts/category-list/style-' . $style . '.php';
                if ( file_exists( $style_file ) ) {
                    include $style_file;
                }
            endforeach;
            ?>
        </div>
    </div>
<?php
else:
    ?>
    <div <?php echo wp_kses_post(get_block_wrapper_attributes()); ?>>
        <p><?php esc_html_e('No categories found.', 'boldpost'); ?></p>
    </div>
    <?php
endif;
?>