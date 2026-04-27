<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'boldpost/post-list-3',
		'version' => '0.1.0',
		'title' => 'Post list 3',
		'category' => 'boldpost',
		'icon' => 'list',
		'description' => 'Post list 3 Block',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'spacing' => array(
				'padding' => true,
				'margin' => true
			),
			'color' => array(
				'background' => true,
				'text' => false,
				'gradients' => true
			)
		),
		'textdomain' => 'boldpost',
		'editorScript' => 'file:./index.js',
		'viewScript' => 'file:./view.js',
		'render' => 'file:./render.php',
		'attributes' => array(
			'blockId' => array(
				'type' => 'string',
				'default' => ''
			),
			'ignoreStikcyPosts' => array(
				'type' => 'boolean',
				'default' => true
			),
			'isFeatured' => array(
				'type' => 'boolean',
				'default' => false
			),
			'listStyle' => array(
				'type' => 'string',
				'default' => 'default'
			),
			'thumbnailOneSize' => array(
				'type' => 'string',
				'default' => 'medium'
			),
			'thumbnailTwoSize' => array(
				'type' => 'string',
				'default' => 'thumbnail'
			),
			'thumbnailOneHeight' => array(
				'type' => 'string',
				'default' => ''
			),
			'thumbnailOneHeightTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'thumbnailOneHeightMobile' => array(
				'type' => 'string',
				'default' => ''
			),
			'thumbnailTwoHeight' => array(
				'type' => 'string',
				'default' => ''
			),
			'thumbnailTwoHeightTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'thumbnailTwoHeightMobile' => array(
				'type' => 'string',
				'default' => ''
			),
			'perPage' => array(
				'type' => 'string'
			),
			'order' => array(
				'type' => 'string',
				'default' => 'ASC'
			),
			'orderby' => array(
				'type' => 'string',
				'default' => 'date'
			),
			'offset' => array(
				'type' => 'string',
				'default' => ''
			),
			'categories' => array(
				'type' => 'array',
				'default' => array(
					'all'
				)
			),
			'excludes' => array(
				'type' => 'array',
				'default' => array(
					'no-excludes'
				)
			),
			'posts' => array(
				'type' => 'array',
				'default' => array(
					'all'
				)
			),
			'itemPadding' => array(
				'type' => 'object'
			),
			'itemBorderRadius' => array(
				'type' => 'object'
			),
			'itemBoxShadow' => array(
				'type' => 'object',
				'default' => array(
					'x' => 0,
					'y' => 0,
					'b' => 0,
					's' => 0,
					'c' => 'rgba(0, 0, 0, 0)'
				)
			),
			'itemBorder' => array(
				'type' => 'object',
				'default' => array(
					'width' => 0,
					'color' => '',
					'style' => 'solid'
				)
			),
			'itemTitlePadding' => array(
				'type' => 'object'
			),
			'itemTitleMargin' => array(
				'type' => 'object'
			),
			'itemExcerptPadding' => array(
				'type' => 'object'
			),
			'itemExcerptMargin' => array(
				'type' => 'object'
			),
			'itemTitleOneTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '24px',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'itemTitleTwoTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '1.025rem',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'itemExcerptTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'readMorePadding' => array(
				'type' => 'object'
			),
			'readMoreMargin' => array(
				'type' => 'object'
			),
			'readMoreTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'readMoreBorderRadius' => array(
				'type' => 'object'
			),
			'readMoreBorder' => array(
				'type' => 'object',
				'default' => array(
					'width' => 0,
					'color' => '',
					'style' => 'solid'
				)
			),
			'itemBackgroundColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemBackgroundColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemBackgroundGradient' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemBackgroundGradientHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemOverlayBackgroundColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemOverlayBackgroundColorHover' => array(
				'type' => 'string',
				'default' => 'var(--eshb-primary-color)'
			),
			'itemOverlayBackgroundGradient' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemOverlayBackgroundGradientHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemOverlayBackgroundGradientTwo' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemOverlayBackgroundGradientTwoHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemGap' => array(
				'type' => 'string',
				'default' => '4'
			),
			'itemTitleColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemTitleColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemExcerptColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'contentPadding' => array(
				'type' => 'object'
			),
			'contentTwoPadding' => array(
				'type' => 'object'
			),
			'readMoreBackgroundColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'readMoreBackgroundColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'readMoreBackgroundGradient' => array(
				'type' => 'string',
				'default' => ''
			),
			'readMoreBackgroundGradientHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'readMoreColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'readMoreColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'showThumbnail' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showMeta' => array(
				'type' => 'boolean',
				'default' => true
			),
			'allowedMetas' => array(
				'type' => 'array',
				'default' => array(
					'author',
					'date'
				)
			),
			'authorPrefix' => array(
				'type' => 'string',
				'default' => 'by'
			),
			'metaPosition' => array(
				'type' => 'string',
				'default' => 'below_title'
			),
			'metaColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'metaColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'metaIconColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'metaIconColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'metaMargin' => array(
				'type' => 'object'
			),
			'metaStyle' => array(
				'type' => 'string',
				'default' => 'default'
			),
			'TitleOneTag' => array(
				'type' => 'string',
				'default' => 'h2'
			),
			'TitleTwoTag' => array(
				'type' => 'string',
				'default' => 'h4'
			),
			'showExcerpt' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showReadMore' => array(
				'type' => 'boolean',
				'default' => false
			),
			'readMoreText' => array(
				'type' => 'string',
				'default' => 'Read More'
			),
			'readMoreIcon' => array(
				'type' => 'string',
				'default' => ''
			),
			'readMoreIconPosition' => array(
				'type' => 'string',
				'default' => 'after'
			),
			'onlyIconShow' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showDateOnTop' => array(
				'type' => 'boolean',
				'default' => false
			),
			'topDateBackgroundColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'topDateColor' => array(
				'type' => 'string',
				'default' => '#ffffff'
			),
			'titleTrim' => array(
				'type' => 'string',
				'default' => '30'
			),
			'excerptTrim' => array(
				'type' => 'string',
				'default' => '60'
			),
			'animStyle' => array(
				'type' => 'string',
				'default' => ''
			),
			'thumbAnim' => array(
				'type' => 'boolean',
				'default' => true
			),
			'contentAlignVertical' => array(
				'type' => 'string',
				'default' => 'center'
			),
			'itemContentPadding' => array(
				'type' => 'object'
			),
			'pagination' => array(
				'type' => 'boolean',
				'default' => true
			),
			'paginationColor' => array(
				'type' => 'string',
				'default' => 'var(--boldpo-preset-color-contrast-2)'
			),
			'paginationColorHover' => array(
				'type' => 'string',
				'default' => 'var(--boldpo-preset-color-white)'
			),
			'paginationBackgroundColor' => array(
				'type' => 'string',
				'default' => 'var(--boldpo-preset-color-tertiary)'
			),
			'paginationBackgroundColorHover' => array(
				'type' => 'string',
				'default' => 'var(--boldpo-preset-color-primary)'
			),
			'itemRowGap' => array(
				'type' => 'string',
				'default' => '4'
			),
			'itemRowGapTablet' => array(
				'type' => 'string',
				'default' => '3'
			),
			'itemRowGapMobile' => array(
				'type' => 'string',
				'default' => '3'
			),
			'itemPaddingTablet' => array(
				'type' => 'object'
			),
			'itemPaddingMobile' => array(
				'type' => 'object'
			),
			'itemTitlePaddingTablet' => array(
				'type' => 'object'
			),
			'itemTitlePaddingMobile' => array(
				'type' => 'object'
			),
			'itemTitleMarginTablet' => array(
				'type' => 'object'
			),
			'itemTitleMarginMobile' => array(
				'type' => 'object'
			),
			'itemTitleTypographyTablet' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'itemTitleTypographyMobile' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'itemExcerptTypographyTablet' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'itemExcerptTypographyMobile' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'itemExcerptPaddingTablet' => array(
				'type' => 'object'
			),
			'itemExcerptPaddingMobile' => array(
				'type' => 'object'
			),
			'itemExcerptMarginTablet' => array(
				'type' => 'object'
			),
			'itemExcerptMarginMobile' => array(
				'type' => 'object'
			),
			'contentTextAlign' => array(
				'type' => 'string',
				'default' => 'left'
			),
			'contentTextAlignTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'contentTextAlignMobile' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleTextAlign' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleTextAlignTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleTextAlignMobile' => array(
				'type' => 'string',
				'default' => ''
			),
			'excerptTextAlign' => array(
				'type' => 'string',
				'default' => ''
			),
			'excerptTextAlignTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'excerptTextAlignMobile' => array(
				'type' => 'string',
				'default' => ''
			),
			'buttonTextAlign' => array(
				'type' => 'string',
				'default' => ''
			),
			'buttonTextAlignTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'buttonTextAlignMobile' => array(
				'type' => 'string',
				'default' => ''
			),
			'thumbnailBorderRadius' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'categoryColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'categoryColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'categoryBackgroundColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'categoryBackgroundColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'categoryPadding' => array(
				'type' => 'object'
			),
			'categoryMargin' => array(
				'type' => 'object'
			)
		)
	)
);
