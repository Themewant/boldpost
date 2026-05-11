<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'boldpost/category-list',
		'version' => '0.1.0',
		'title' => 'Category List',
		'category' => 'boldpost',
		'icon' => 'category',
		'description' => 'Display a list of categories with customizable styles',
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
			'listStyle' => array(
				'type' => 'string',
				'default' => 'default'
			),
			'columns' => array(
				'type' => 'string'
			),
			'columnsTablet' => array(
				'type' => 'string',
				'default' => '1'
			),
			'columnsMobile' => array(
				'type' => 'string',
				'default' => '1'
			),
			'perPage' => array(
				'type' => 'string',
				'default' => '9'
			),
			'order' => array(
				'type' => 'string',
				'default' => 'ASC'
			),
			'orderby' => array(
				'type' => 'string',
				'default' => 'name'
			),
			'hideEmpty' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showCount' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showEmptyCount' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showDescription' => array(
				'type' => 'boolean',
				'default' => false
			),
			'excludes' => array(
				'type' => 'array',
				'default' => array(
					'no-excludes'
				)
			),
			'includes' => array(
				'type' => 'array',
				'default' => array(
					'all'
				)
			),
			'itemPadding' => array(
				'type' => 'object'
			),
			'itemPaddingTablet' => array(
				'type' => 'object',
				'default' => array(
					'top' => '10px',
					'right' => '10px',
					'bottom' => '10px',
					'left' => '10px'
				)
			),
			'itemPaddingMobile' => array(
				'type' => 'object',
				'default' => array(
					'top' => '10px',
					'right' => '10px',
					'bottom' => '10px',
					'left' => '10px'
				)
			),
			'itemBorderRadius' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'itemGap' => array(
				'type' => 'string',
				'default' => '1'
			),
			'itemGapTablet' => array(
				'type' => 'string',
				'default' => '1'
			),
			'itemGapMobile' => array(
				'type' => 'string',
				'default' => '1'
			),
			'itemRowGap' => array(
				'type' => 'string',
				'default' => '2'
			),
			'itemRowGapTablet' => array(
				'type' => 'string',
				'default' => '2'
			),
			'itemRowGapMobile' => array(
				'type' => 'string',
				'default' => '1'
			),
			'itemTitleMargin' => array(
				'type' => 'object'
			),
			'itemTitleMarginTablet' => array(
				'type' => 'object'
			),
			'itemTitleMarginMobile' => array(
				'type' => 'object'
			),
			'itemDescriptionMargin' => array(
				'type' => 'object',
				'default' => array(
					'top' => '10px',
					'right' => '0px',
					'bottom' => '0px',
					'left' => '0px'
				)
			),
			'itemDescriptionMarginTablet' => array(
				'type' => 'object',
				'default' => array(
					'top' => '10px',
					'right' => '0px',
					'bottom' => '0px',
					'left' => '0px'
				)
			),
			'itemDescriptionMarginMobile' => array(
				'type' => 'object',
				'default' => array(
					'top' => '10px',
					'right' => '0px',
					'bottom' => '0px',
					'left' => '0px'
				)
			),
			'itemTitleTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '18px',
					'fontWeight' => '600',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '1.4',
					'letterSpacing' => ''
				)
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
			'itemDescriptionTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '14px',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '1.6',
					'letterSpacing' => ''
				)
			),
			'itemDescriptionTypographyTablet' => array(
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
			'itemDescriptionTypographyMobile' => array(
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
			'countTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '14px',
					'fontWeight' => '500',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
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
			'itemTitleColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemTitleColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemDescriptionColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'countColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'countBackgroundColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'countPadding' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'countBorderRadius' => array(
				'type' => 'object',
				'default' => array(
					'top' => '12px',
					'right' => '12px',
					'bottom' => '12px',
					'left' => '12px'
				)
			),
			'titleTag' => array(
				'type' => 'string',
				'default' => 'h3'
			),
			'thumbnailSize' => array(
				'type' => 'string',
				'default' => 'medium'
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
			'detailsBtnLabel' => array(
				'type' => 'string',
				'default' => 'Visit'
			),
			'detailsBtnTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '14px',
					'fontWeight' => '500',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'detailsBtnColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'detailsBtnColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'detailsBtnBackgroundColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'detailsBtnBackgroundColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'detailsBtnBackgroundGradient' => array(
				'type' => 'string',
				'default' => ''
			),
			'detailsBtnBackgroundGradientHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'detailsBtnPadding' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnPaddingTablet' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnPaddingMobile' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnMargin' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnMarginTablet' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnMarginMobile' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnBorderRadius' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnBorderRadiusTablet' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnBorderRadiusMobile' => array(
				'type' => 'object',
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => ''
				)
			),
			'detailsBtnBorder' => array(
				'type' => 'object',
				'default' => array(
					'width' => 0,
					'color' => '',
					'style' => 'solid'
				)
			),
			'detailsBtnBorderHover' => array(
				'type' => 'object',
				'default' => array(
					'width' => 0,
					'color' => '',
					'style' => 'solid'
				)
			),
			'contentAlign' => array(
				'type' => 'string',
				'default' => 'left'
			)
		)
	)
);
