<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'boldpost/heading',
		'version' => '0.1.0',
		'title' => 'Heading',
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
			'layoutStyle' => array(
				'type' => 'string',
				'default' => '1'
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleMargin' => array(
				'type' => 'object'
			),
			'titleMarginTablet' => array(
				'type' => 'object'
			),
			'titleMarginMobile' => array(
				'type' => 'object'
			),
			'descriptionMargin' => array(
				'type' => 'object'
			),
			'descriptionMarginTablet' => array(
				'type' => 'object'
			),
			'descriptionMarginMobile' => array(
				'type' => 'object'
			),
			'titleTypography' => array(
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
			'titleTypographyTablet' => array(
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
			'titleTypographyMobile' => array(
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
			'titleColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleTag' => array(
				'type' => 'string',
				'default' => 'h2'
			),
			'showDescription' => array(
				'type' => 'boolean',
				'default' => false
			),
			'description' => array(
				'type' => 'string',
				'default' => ''
			),
			'descriptionTypography' => array(
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
			'descriptionTypographyTablet' => array(
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
			'descriptionTypographyMobile' => array(
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
			'descriptionColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'descriptionColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'titlePadding' => array(
				'type' => 'object',
				'default' => array(
					'top' => '0px',
					'right' => '0px',
					'bottom' => '0px',
					'left' => '0px'
				)
			),
			'descriptionPadding' => array(
				'type' => 'object',
				'default' => array(
					'top' => '0px',
					'right' => '0px',
					'bottom' => '0px',
					'left' => '0px'
				)
			),
			'textAlign' => array(
				'type' => 'string',
				'default' => ''
			),
			'borderLineColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'borderLineColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'borderLineWidth' => array(
				'type' => 'number'
			),
			'borderLineHeight' => array(
				'type' => 'number',
				'default' => 3
			),
			'dotColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'dotColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'dotSize' => array(
				'type' => 'number',
				'default' => 12
			)
		)
	)
);
