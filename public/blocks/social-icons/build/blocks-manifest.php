<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'boldpost/social-icons',
		'version' => '0.1.0',
		'title' => 'Social Icons',
		'category' => 'boldpost',
		'icon' => 'share',
		'description' => 'Display social media icons with links',
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
						'icon' => 'boldpo-icon-facebook-f',
						'url' => '#',
						'label' => 'Facebook',
						'openNewTab' => true
					),
					array(
						'icon' => 'boldpo-icon-twitter-x',
						'url' => '#',
						'label' => 'Twitter',
						'openNewTab' => true
					),
					array(
						'icon' => 'boldpo-icon-logo-youtube',
						'url' => '#',
						'label' => 'Youtube',
						'openNewTab' => true
					),
					array(
						'icon' => 'boldpo-icon-logo-instagram',
						'url' => '#',
						'label' => 'Instagram',
						'openNewTab' => true
					)
				)
			),
			'layoutStyle' => array(
				'type' => 'string',
				'default' => '1'
			),
			'iconSize' => array(
				'type' => 'number',
				'default' => 20
			),
			'iconSizeTablet' => array(
				'type' => 'number'
			),
			'iconSizeMobile' => array(
				'type' => 'number'
			),
			'gap' => array(
				'type' => 'number',
				'default' => 5
			),
			'gapTablet' => array(
				'type' => 'number'
			),
			'gapMobile' => array(
				'type' => 'number'
			),
			'alignment' => array(
				'type' => 'string',
				'default' => 'left'
			),
			'iconColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'iconColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'iconBgColor' => array(
				'type' => 'string'
			),
			'iconBgColorHover' => array(
				'type' => 'string'
			),
			'iconBorderColor' => array(
				'type' => 'string'
			),
			'iconBorderColorHover' => array(
				'type' => 'string'
			),
			'iconBorderWidth' => array(
				'type' => 'number'
			),
			'iconBorderRadius' => array(
				'type' => 'string'
			),
			'iconPadding' => array(
				'type' => 'object'
			),
			'showLabel' => array(
				'type' => 'boolean',
				'default' => false
			),
			'labelColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'labelColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'labelTypography' => array(
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
			)
		)
	)
);
