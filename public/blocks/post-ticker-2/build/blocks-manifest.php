<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'boldpost/post-ticker-2',
		'version' => '0.1.0',
		'title' => 'Post ticker 2',
		'category' => 'boldpost',
		'icon' => 'slider',
		'description' => 'Post ticker 2 Block',
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
		'script' => 'file:./view.js',
		'viewScript' => 'file:./view.js',
		'render' => 'file:./render.php',
		'attributes' => array(
			'ignoreStikcyPosts' => array(
				'type' => 'boolean',
				'default' => true
			),
			'isFeatured' => array(
				'type' => 'boolean',
				'default' => false
			),
			'sliderStyle' => array(
				'type' => 'string',
				'default' => 'default'
			),
			'perPage' => array(
				'type' => 'string',
				'default' => '6'
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
			'tickerLabel' => array(
				'type' => 'string',
				'default' => 'Trending:'
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
				'type' => 'object'
			),
			'itemTitlePadding' => array(
				'type' => 'object'
			),
			'itemTitlePaddingTablet' => array(
				'type' => 'object'
			),
			'itemTitlePaddingMobile' => array(
				'type' => 'object'
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
			'labelPadding' => array(
				'type' => 'object'
			),
			'labelPaddingTablet' => array(
				'type' => 'object'
			),
			'labelPaddingMobile' => array(
				'type' => 'object'
			),
			'itemTitleTypography' => array(
				'type' => 'object',
				'default' => array(
					'fontFamily' => '',
					'fontSize' => '0.95rem',
					'fontWeight' => '',
					'fontStyle' => '',
					'textTransform' => '',
					'lineHeight' => '',
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
			),
			'labelTypographyTablet' => array(
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
			'labelTypographyMobile' => array(
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
			'itemTitleColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'itemTitleColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'labelColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'showThumbnail' => array(
				'type' => 'boolean',
				'default' => true
			),
			'titleTag' => array(
				'type' => 'string',
				'default' => 'h3'
			),
			'showLabel' => array(
				'type' => 'boolean',
				'default' => true
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
				'default' => '100'
			),
			'labelTrim' => array(
				'type' => 'string',
				'default' => '12'
			),
			'animStyle' => array(
				'type' => 'string',
				'default' => ''
			),
			'thumbAnim' => array(
				'type' => 'boolean',
				'default' => true
			),
			'slidesPerView' => array(
				'type' => 'string',
				'default' => '1'
			),
			'slidesPerViewTablet' => array(
				'type' => 'string',
				'default' => '1'
			),
			'slidesPerViewMobile' => array(
				'type' => 'string',
				'default' => '1'
			),
			'slidesPerViewMobileSmall' => array(
				'type' => 'string',
				'default' => '1'
			),
			'slidesToScroll' => array(
				'type' => 'string',
				'default' => '1'
			),
			'spaceBetween' => array(
				'type' => 'string',
				'default' => '20'
			),
			'centeredSlides' => array(
				'type' => 'boolean',
				'default' => false
			),
			'effect' => array(
				'type' => 'string',
				'default' => 'slide'
			),
			'speed' => array(
				'type' => 'string',
				'default' => '500'
			),
			'loop' => array(
				'type' => 'boolean',
				'default' => true
			),
			'autoplay' => array(
				'type' => 'boolean',
				'default' => true
			),
			'autoplayDelay' => array(
				'type' => 'string',
				'default' => '0'
			),
			'pauseOnHover' => array(
				'type' => 'boolean',
				'default' => false
			),
			'pauseOnInter' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showNav' => array(
				'type' => 'boolean',
				'default' => true
			),
			'navBgColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'navBgColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'navColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'navColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'navBorderRadius' => array(
				'type' => 'object'
			),
			'navIconSize' => array(
				'type' => 'string',
				'default' => ''
			),
			'navPadding' => array(
				'type' => 'object'
			),
			'showDots' => array(
				'type' => 'boolean',
				'default' => false
			),
			'dotsBgColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'dotsBgColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'dotsColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'dotsColorHover' => array(
				'type' => 'string',
				'default' => ''
			),
			'dotsBorderRadius' => array(
				'type' => 'object'
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
			'labelTextAlign' => array(
				'type' => 'string',
				'default' => ''
			),
			'labelTextAlignTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'labelTextAlignMobile' => array(
				'type' => 'string',
				'default' => ''
			)
		)
	)
);
