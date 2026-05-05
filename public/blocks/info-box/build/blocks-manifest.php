<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'boldpost/info-box',
		'version' => '0.1.0',
		'title' => 'Info Box',
		'category' => 'boldpost',
		'icon' => 'format-aside',
		'description' => 'Display a list of info boxes with image, subtitle and linked title',
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
			'items' => array(
				'type' => 'array',
				'default' => array(
					array(
						'title' => 'Your title goes here',
						'subtitle' => 'Subtitle',
						'imageId' => 0,
						'imageUrl' => '',
						'imageAlt' => '',
						'url' => '#',
						'openNewTab' => false
					)
				)
			),
			'layoutStyle' => array(
				'type' => 'string',
				'default' => 'default'
			),
			'columns' => array(
				'type' => 'string',
				'default' => '3'
			),
			'columnsTablet' => array(
				'type' => 'string',
				'default' => '2'
			),
			'columnsMobile' => array(
				'type' => 'string',
				'default' => '1'
			),
			'itemGap' => array(
				'type' => 'string',
				'default' => '4'
			),
			'itemGapTablet' => array(
				'type' => 'string',
				'default' => '3'
			),
			'itemGapMobile' => array(
				'type' => 'string',
				'default' => '2'
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
				'default' => '2'
			),
			'itemPadding' => array(
				'type' => 'object'
			),
			'itemPaddingTablet' => array(
				'type' => 'object'
			),
			'itemPaddingMobile' => array(
				'type' => 'object'
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
			'titleTag' => array(
				'type' => 'string',
				'default' => 'h4'
			),
			'titleColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleMargin' => array(
				'type' => 'object',
				'default' => array(
					'top' => '0px',
					'right' => '0px',
					'bottom' => '0px',
					'left' => '0px'
				)
			),
			'titleMarginTablet' => array(
				'type' => 'object'
			),
			'titleMarginMobile' => array(
				'type' => 'object'
			),
			'titleTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '18px',
					'fontWeight' => '500',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '1.4',
					'letterSpacing' => ''
				)
			),
			'titleTypographyTablet' => array(
				'type' => 'object'
			),
			'titleTypographyMobile' => array(
				'type' => 'object'
			),
			'subtitleColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'subtitleMargin' => array(
				'type' => 'object',
				'default' => array(
					'top' => '0px',
					'right' => '0px',
					'bottom' => '8px',
					'left' => '0px'
				)
			),
			'subtitleMarginTablet' => array(
				'type' => 'object'
			),
			'subtitleMarginMobile' => array(
				'type' => 'object'
			),
			'subtitleTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '14px',
					'fontWeight' => '400',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '1.4',
					'letterSpacing' => ''
				)
			),
			'subtitleTypographyTablet' => array(
				'type' => 'object'
			),
			'subtitleTypographyMobile' => array(
				'type' => 'object'
			),
			'imageSize' => array(
				'type' => 'string',
				'default' => 'thumbnail'
			),
			'imageWidth' => array(
				'type' => 'string',
				'default' => '80'
			),
			'imageWidthTablet' => array(
				'type' => 'string'
			),
			'imageWidthMobile' => array(
				'type' => 'string'
			),
			'imageHeight' => array(
				'type' => 'string',
				'default' => '80'
			),
			'imageHeightTablet' => array(
				'type' => 'string'
			),
			'imageHeightMobile' => array(
				'type' => 'string'
			),
			'imageGap' => array(
				'type' => 'string',
				'default' => '16'
			),
			'imageGapTablet' => array(
				'type' => 'string'
			),
			'imageGapMobile' => array(
				'type' => 'string'
			),
			'imageBorderRadius' => array(
				'type' => 'object',
				'default' => array(
					'top' => '50%',
					'right' => '50%',
					'bottom' => '50%',
					'left' => '50%'
				)
			)
		)
	)
);
