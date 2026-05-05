<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'boldpost/button',
		'version' => '0.1.0',
		'title' => 'Button',
		'category' => 'boldpost',
		'icon' => 'button',
		'description' => 'A customizable button block with icon support',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'spacing' => array(
				'padding' => true,
				'margin' => true
			),
			'color' => array(
				'background' => false,
				'text' => false,
				'gradients' => false
			)
		),
		'textdomain' => 'boldpost',
		'editorScript' => 'file:./index.js',
		'viewScript' => 'file:./view.js',
		'render' => 'file:./render.php',
		'attributes' => array(
			'buttonStyle' => array(
				'type' => 'string',
				'default' => 'default'
			),
			'text' => array(
				'type' => 'string',
				'default' => 'Click Me'
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'openInNewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'rel' => array(
				'type' => 'string',
				'default' => ''
			),
			'showIcon' => array(
				'type' => 'boolean',
				'default' => true
			),
			'iconPosition' => array(
				'type' => 'string',
				'default' => 'right'
			),
			'iconType' => array(
				'type' => 'string',
				'default' => 'boldpo-icon-chevron-right'
			),
			'iconSize' => array(
				'type' => 'string',
				'default' => ''
			),
			'iconSizeTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'iconSizeMobile' => array(
				'type' => 'string',
				'default' => ''
			),
			'iconGap' => array(
				'type' => 'string',
				'default' => ''
			),
			'buttonBackground' => array(
				'type' => 'string',
				'default' => ''
			),
			'buttonBackgroundHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'textColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'textColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'iconColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'iconColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'borderRadius' => array(
				'type' => 'object',
				'default' => array(
					'top' => '0px',
					'right' => '0px',
					'bottom' => '0px',
					'left' => '0px'
				)
			),
			'buttonPadding' => array(
				'type' => 'object',
				'default' => array(
					'top' => '14px',
					'right' => '30px',
					'bottom' => '14px',
					'left' => '30px'
				)
			),
			'buttonPaddingTablet' => array(
				'type' => 'object',
				'default' => array(
					'top' => '14px',
					'right' => '30px',
					'bottom' => '14px',
					'left' => '30px'
				)
			),
			'buttonPaddingMobile' => array(
				'type' => 'object',
				'default' => array(
					'top' => '12px',
					'right' => '24px',
					'bottom' => '12px',
					'left' => '24px'
				)
			),
			'typography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '',
					'fontWeight' => '600',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
					'letterSpacing' => ''
				)
			),
			'typographyTablet' => array(
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
			'typographyMobile' => array(
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
			'textAlign' => array(
				'type' => 'string',
				'default' => ''
			),
			'buttonWidth' => array(
				'type' => 'string',
				'default' => 'auto'
			),
			'borderType' => array(
				'type' => 'string',
				'default' => 'none'
			),
			'borderWidth' => array(
				'type' => 'number',
				'default' => 0
			),
			'borderColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'borderColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'iconHoverAnimation' => array(
				'type' => 'string',
				'default' => 'none'
			)
		)
	)
);
