<?php
/**
 * Responsive visibility for every BoldPost block.
 *
 * Rather than repeating the option in 28 blocks, the three attributes are
 * injected into every `boldpost/*` block type and the matching classes are
 * appended at render time. Breakpoints match Helper::generate_responsive_css()
 * ( tablet <= 1024px, mobile <= 767px ), so hiding lines up with every other
 * per-device setting in the plugin.
 *
 * @package BoldPost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Attribute name => class emitted on the block wrapper.
 *
 * @return array<string,string>
 */
function boldpo_visibility_map() {
	return array(
		'hideDesktop' => 'boldpo-hide-desktop',
		'hideTablet'  => 'boldpo-hide-tablet',
		'hideMobile'  => 'boldpo-hide-mobile',
	);
}

/**
 * Give every BoldPost block the three visibility attributes. Blocks that
 * already declare them ( Row, Column ) keep their own declaration.
 *
 * @param array  $args Block type args.
 * @param string $name Block name.
 * @return array
 */
function boldpo_register_visibility_attributes( $args, $name ) {
	if ( 0 !== strpos( (string) $name, 'boldpost/' ) ) {
		return $args;
	}
	if ( ! isset( $args['attributes'] ) || ! is_array( $args['attributes'] ) ) {
		$args['attributes'] = array();
	}
	foreach ( array_keys( boldpo_visibility_map() ) as $key ) {
		if ( ! isset( $args['attributes'][ $key ] ) ) {
			$args['attributes'][ $key ] = array(
				'type'    => 'boolean',
				'default' => false,
			);
		}
	}
	return $args;
}
add_filter( 'register_block_type_args', 'boldpo_register_visibility_attributes', 10, 2 );

/**
 * Append the visibility classes to the block's outer element.
 *
 * Uses the HTML API when available so only the first tag is touched and the
 * class is never duplicated ( Row and Column already print their own ).
 *
 * @param string $content Rendered block HTML.
 * @param array  $block   Parsed block.
 * @return string
 */
function boldpo_render_block_visibility( $content, $block ) {
	if ( empty( $block['blockName'] ) || 0 !== strpos( (string) $block['blockName'], 'boldpost/' ) ) {
		return $content;
	}
	if ( '' === trim( (string) $content ) ) {
		return $content;
	}

	$attrs   = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
	$classes = array();
	foreach ( boldpo_visibility_map() as $attr => $class ) {
		if ( ! empty( $attrs[ $attr ] ) ) {
			$classes[] = $class;
		}
	}
	if ( empty( $classes ) ) {
		return $content;
	}

	if ( class_exists( 'WP_HTML_Tag_Processor' ) ) {
		$tags = new WP_HTML_Tag_Processor( $content );
		if ( ! $tags->next_tag() ) {
			return $content;
		}
		foreach ( $classes as $class ) {
			$tags->add_class( $class ); // Idempotent — a class already present is not repeated.
		}
		return $tags->get_updated_html();
	}

	// WordPress < 6.2 fallback: add to the first opening tag only.
	$needed = array();
	foreach ( $classes as $class ) {
		if ( false === strpos( $content, $class ) ) {
			$needed[] = $class;
		}
	}
	if ( empty( $needed ) ) {
		return $content;
	}
	$added = implode( ' ', $needed );
	if ( preg_match( '/^(\s*<[a-zA-Z][^>]*?\sclass=")/', $content, $m ) ) {
		return preg_replace( '/^(\s*<[a-zA-Z][^>]*?\sclass=")/', '$1' . $added . ' ', $content, 1 );
	}
	return preg_replace( '/^(\s*<[a-zA-Z][a-zA-Z0-9-]*)/', '$1 class="' . $added . '"', $content, 1 );
}
add_filter( 'render_block', 'boldpo_render_block_visibility', 20, 2 );

/**
 * The rules themselves, attached to the shared public stylesheet so they are
 * available to every block on the page.
 */
function boldpo_visibility_inline_css() {
	wp_add_inline_style(
		'boldpo-public-style',
		'@media (min-width:1025px){.boldpo-hide-desktop{display:none !important}}'
		. '@media (min-width:768px) and (max-width:1024px){.boldpo-hide-tablet{display:none !important}}'
		. '@media (max-width:767px){.boldpo-hide-mobile{display:none !important}}'
	);
}
add_action( 'wp_enqueue_scripts', 'boldpo_visibility_inline_css', 20 );

/**
 * Editor canvas feedback.
 *
 * Since WP 6.3 the canvas is an iframe that is really resized for the Tablet /
 * Mobile preview, so the same breakpoints apply there. Hiding outright would
 * make the block impossible to select and un-hide, so it is faded and outlined
 * instead — you can see it will not show, and still click it.
 */
function boldpo_visibility_editor_preview_css() {
	if ( ! is_admin() ) {
		return;
	}
	wp_register_style( 'boldpo-visibility-editor', false, array(), BOLDPO_VERSION );
	wp_enqueue_style( 'boldpo-visibility-editor' );

	$fade = 'opacity:.45;outline:1px dashed #d63638;outline-offset:2px;';
	wp_add_inline_style(
		'boldpo-visibility-editor',
		'@media (min-width:1025px){.boldpo-hide-desktop{' . $fade . '}}'
		. '@media (min-width:768px) and (max-width:1024px){.boldpo-hide-tablet{' . $fade . '}}'
		. '@media (max-width:767px){.boldpo-hide-mobile{' . $fade . '}}'
	);
}
add_action( 'enqueue_block_assets', 'boldpo_visibility_editor_preview_css' );

/**
 * The editor control that writes those attributes — one "Responsive" panel added
 * to every BoldPost block.
 */
function boldpo_visibility_editor_script() {
	wp_enqueue_script(
		'boldpo-responsive-visibility',
		BOLDPO_PL_URL . 'public/assets/js/responsive-visibility.js',
		array( 'wp-blocks', 'wp-hooks', 'wp-compose', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		BOLDPO_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'boldpo_visibility_editor_script', 1 );
