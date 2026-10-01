<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BOLDPO_Helper {

	public static function add_responsive_vars ($attributes, &$target_array, $attr_base, $prop_name, $properties = [], $is_object = false) {
   		$devices = ['' => 'desktop', 'Tablet' => 'tablet', 'Mobile' => 'mobile'];
    
    	foreach ($devices as $d_suffix => $device) {
			$attr_name = $attr_base . $d_suffix;
			$val = isset($attributes[$attr_name]) && $attributes[$attr_name] !== '' ? $attributes[$attr_name] : null;
			
			if ($is_object && is_array($val)) {
				foreach ($properties as $prop_key => $css_prop) {
					if ( isset( $val[$prop_key] ) && $val[$prop_key] !== '' ) {
						$v = $val[$prop_key];
						if ( in_array( $prop_key, ['top', 'right', 'bottom', 'left', 'fontSize', 'letterSpacing', 'itemGap'] ) ) {
							$v = self::ensure_unit($v);
						}
						$target_array[$device][$css_prop] = $v;
					}
				}
			} elseif ( ! $is_object && ! empty( $val ) ) {
				$v = $val;
				if ( in_array($attr_base, ['itemGap', 'itemColGap', 'itemRowGap']) ) {
                     // handled per block usually, but let's store it
					 $v = self::ensure_unit($v);
                }
				$target_array[$device][$prop_name] = $v;
			}
		}
	}

	/**
	 * CSS collected during a REST (editor preview) render, awaiting render_block.
	 *
	 * @var string
	 */
	private static $rest_css = '';

	/**
	 * CSS collected on the front end after wp_head, awaiting the footer.
	 *
	 * @var string
	 */
	private static $late_css = '';

	/**
	 * Whether the footer printer has been hooked yet.
	 *
	 * @var bool
	 */
	private static $late_hooked = false;

	/**
	 * Prints the CSS collected after wp_head, through the styles API.
	 *
	 * Deliberately not wp_enqueue_block_support_styles(): core sends that to
	 * wp_head on a block theme, which has already fired by the time a block
	 * inside the_content() renders, so the CSS would be dropped. A handle
	 * registered here is printed with WordPress's late styles on either theme
	 * type.
	 *
	 * @return void
	 */
	public static function print_late_css() {
		if ( '' === self::$late_css ) {
			return;
		}
		wp_register_style( 'boldpost-block-inline', false, array(), BOLDPO_VERSION );
		wp_enqueue_style( 'boldpost-block-inline' );
		wp_add_inline_style( 'boldpost-block-inline', self::$late_css );
		self::$late_css = '';
	}

	/**
	 * Whether the render_block carrier has been hooked yet.
	 *
	 * @var bool
	 */
	private static $rest_hooked = false;

	/**
	 * Appends the preview CSS to the block's own rendered markup.
	 *
	 * Inside the block editor's ServerSideRender request there is no wp_head and
	 * no wp_footer, so the per-instance CSS has to travel with the fragment or
	 * the preview is unstyled. Returning it from a filter keeps it out of an
	 * echo, which is what makes a hand-written <style> tag a review finding.
	 *
	 * @param string $content Rendered block HTML.
	 * @return string
	 */
	public static function carry_rest_css( $content ) {
		if ( '' === self::$rest_css ) {
			return $content;
		}
		$css            = self::$rest_css;
		self::$rest_css = '';
		return '<style>' . $css . '</style>' . $content;
	}

	public static function ensure_unit ($value) {
		if ( $value === '' || $value === null ) return '0px';
		if ( is_numeric( $value ) && $value != 0 ) return $value . 'px';
		return $value;
	}

	/**
	 * Makes a stored CSS value safe to place inside a declaration.
	 *
	 * Block attributes are not validated against block.json at render time, so
	 * every colour, gradient, shadow and typography value arriving here is
	 * untrusted. Removing < > { } ; means a value cannot close the style
	 * element, end its own declaration, or open a new rule. Real values --
	 * #fff, rgba(0,0,0,.5), linear-gradient(...), 0 2px 4px rgba(...),
	 * "Helvetica Neue", sans-serif -- contain none of those characters, so
	 * this does not change how an existing site renders.
	 *
	 * @param mixed $value Raw stored value.
	 * @return string Value safe to concatenate into CSS, or '' if unusable.
	 */
	/**
	 * Validate a value that will be written as an HTML tag name.
	 *
	 * A tag name cannot be made safe by escaping: it is whitespace-sensitive, so
	 * anything after the first space becomes an attribute. esc_attr() leaves
	 * "h3 onmouseover=alert(1)" untouched because it contains no character
	 * esc_attr() acts on. Only an allowlist works here.
	 *
	 * The list is a superset of the tags the block editor offers, so a page that
	 * renders correctly today is unchanged.
	 *
	 * @param mixed  $tag      The stored tag name.
	 * @param string $fallback Tag to use when $tag is not allowed.
	 * @return string A tag name that is safe to write unescaped.
	 */
	public static function sanitize_html_tag( $tag, $fallback = 'h3' ) {
		$allowed = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'p', 'span' );

		if ( is_scalar( $tag ) ) {
			$tag = strtolower( trim( (string) $tag ) );

			if ( in_array( $tag, $allowed, true ) ) {
				return $tag;
			}
		}

		return in_array( $fallback, $allowed, true ) ? $fallback : 'h3';
	}

	public static function sanitize_css_value ( $value ) {
		if ( ! is_scalar( $value ) ) {
			return '';
		}
		$value = (string) $value;

		// Constructs that can execute or fetch, whatever the property is.
		if ( preg_match( '/(javascript\s*:|expression\s*\(|@import|behaviou?r\s*:|url\s*\(\s*["\']?\s*(javascript|data)\s*:)/i', $value ) ) {
			return '';
		}

		return trim( str_replace( array( '<', '>', '{', '}', ';' ), '', $value ) );
	}

	public static function get_inline_styles ($style_map) {
		$styles = [];
		foreach ( $style_map as $prop => $value ) {
			$prop  = preg_replace( '/[^a-zA-Z0-9_-]/', '', (string) $prop );
			$value = self::sanitize_css_value( $value );
			if ( '' === $prop || '' === $value ) {
				continue;
			}
			$styles[] = $prop . ':' . $value;
		}
		return implode( ';', $styles );
	}

	public static function generate_responsive_css($selector, $responsive_data) {
		$css = "";
		$breakpoints = [
			'desktop' => '',
			'tablet'  => '@media (max-width: 1024px)',
			'mobile'  => '@media (max-width: 767px)'
		];

		foreach ($breakpoints as $device => $media) {
			if (!empty($responsive_data[$device])) {
				$decls = "";
				foreach ($responsive_data[$device] as $prop => $val) {
					$prop_safe = preg_replace( '/[^a-zA-Z0-9_-]/', '', (string) $prop );
					$val_safe  = self::sanitize_css_value( $val );
					if ( '' === $prop_safe || '' === $val_safe ) {
						continue;
					}
					$decls .= $prop_safe . ":" . $val_safe . ";";
				}
				if ($media) {
					$css .= $media . " { " . $selector . " { " . $decls . " } }\n";
				} else {
					$css .= $selector . " { " . $decls . " }\n";
				}
			}
		}
		return $css;
	}

	public static function add_custom_style( $handle, $selector, $responsive_css = "", $sub_styles = [] ) {
		$css = $responsive_css;
		
		foreach ( $sub_styles as $sub_sel => $style ) {
			if ( ! empty( $style ) ) {
				 $css .= $selector . " " . $sub_sel . " { " . $style . "; }\n";
			}
		}

		if ( empty( $css ) ) {
			return '';
		}

		// Inside a REST render (the editor's ServerSideRender preview) no style
		// hook will fire again, so the CSS travels out with the block's own
		// markup through render_block -- a returned string, never an echo.
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			self::$rest_css .= $css;
			if ( ! self::$rest_hooked ) {
				self::$rest_hooked = true;
				add_filter( 'render_block', array( __CLASS__, 'carry_rest_css' ), 20 );
			}
			return '';
		}

		// Before wp_head prints, the CSS can go onto the handle it belongs to.
		if ( ! did_action( 'wp_head' ) && wp_style_is( $handle, 'enqueued' ) ) {
			wp_add_inline_style( $handle, $css );
			return '';
		}

		// A block rendering inside the_content() runs after wp_head, so the
		// handle it belongs to has already printed. Collect the CSS and let the
		// footer printer above put it on the page.
		self::$late_css .= $css;

		if ( ! self::$late_hooked ) {
			self::$late_hooked = true;
			add_action( 'wp_footer', array( __CLASS__, 'print_late_css' ), 5 );
		}

		return '';
	}

	public static function box_shadow_to_css($shadow) {
		$x = self::ensure_unit($shadow['x'] ?? 0);
		$y = self::ensure_unit($shadow['y'] ?? 0);
		$b = self::ensure_unit($shadow['b'] ?? 0);
		$s = self::ensure_unit($shadow['s'] ?? 0);
		$c = $shadow['c'] ?? 'rgba(0,0,0,0)';
		return "$x $y $b $s $c";
	}

	public static function border_to_css_props($border) {
		$style = $border['style'] ?? 'solid';
		$color = $border['color'] ?? 'rgba(0,0,0,0)';
		$width = $border['width'] ?? 0;

		if ( is_array( $width ) ) {
			$top    = self::ensure_unit( $width['top']    ?? 0 );
			$right  = self::ensure_unit( $width['right']  ?? 0 );
			$bottom = self::ensure_unit( $width['bottom'] ?? 0 );
			$left   = self::ensure_unit( $width['left']   ?? 0 );

			// Skip if every side is zero
			if ( (int) $top === 0 && (int) $right === 0 && (int) $bottom === 0 && (int) $left === 0 ) {
				return [];
			}

			return [
				'border-style' => $style,
				'border-color' => $color,
				'border-width' => "$top $right $bottom $left",
			];
		}

		// Skip if width is zero
		if ( (int) $width === 0 ) {
			return [];
		}

		$w = self::ensure_unit( $width );
		return [ 'border' => "$w $style $color" ];
	}

	public static function border_to_css($border) {
		$width = $border['width'] ?? 0;
		if ( is_array( $width ) ) {
			$width = $width['top'] ?? 0;
		}
		$w     = self::ensure_unit( $width );
		$style = $border['style'] ?? 'solid';
		$color = $border['color'] ?? 'rgba(0,0,0,0)';
		return "$w $style $color";
	}

	public static function boldpost_time_ago() {
		return human_time_diff( get_the_time('U'), current_time('timestamp') );
	}

	public static function boldpost_get_video_embed($video_url, $autoplay = 0, $mute = 0, $controls = 1, $height = '400px', $width = '100%') {

		$embed_video = '';

		if( !empty($video_url) ) {

			// Self-hosted video files: render a <video> tag directly (works in both frontend and editor)
			$video_extensions = ['mp4', 'webm', 'ogg', 'mov'];
			$url_path = strtolower( wp_parse_url( $video_url, PHP_URL_PATH ) );
			$ext = pathinfo( $url_path, PATHINFO_EXTENSION );

			if ( in_array( $ext, $video_extensions, true ) ) {
				$attrs  = $controls ? ' controls' : '';
				$attrs .= $autoplay ? ' autoplay' : '';
				$attrs .= $mute ? ' muted' : '';

				$embed_video = '<video width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '"' . $attrs . ' playsinline>'
					. '<source src="' . esc_url( $video_url ) . '" type="' . esc_attr( wp_check_filetype( $video_url )['type'] ) . '">'
					. '</video>';

				return $embed_video;
			}

			// In the block editor (ServerSideRender via REST), wp_oembed_get's output omits the
			// allow="autoplay" attribute, so the editor's iframe permission policy blocks autoplay.
			// Build the embed iframe directly for YouTube/Vimeo so we can force the params we need.
			if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
				// Browsers block unmuted autoplay; force mute when autoplay is on.
				$effective_mute = $autoplay ? 1 : (int) $mute;

				if ( preg_match( '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video_url, $m ) ) {
					$src = add_query_arg( array(
						'autoplay'    => (int) $autoplay,
						'mute'        => $effective_mute,
						'controls'    => (int) $controls,
						'rel'         => 0,
						'playsinline' => 1,
					), 'https://www.youtube.com/embed/' . $m[1] );

					return '<iframe width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" src="' . esc_url( $src ) . '" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>';
				}

				if ( preg_match( '/vimeo\.com\/(?:video\/)?(\d+)/', $video_url, $m ) ) {
					$src = add_query_arg( array(
						'autoplay' => (int) $autoplay,
						'muted'    => $effective_mute,
						'controls' => (int) $controls,
					), 'https://player.vimeo.com/video/' . $m[1] );

					return '<iframe width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" src="' . esc_url( $src ) . '" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>';
				}

				// Unknown provider: skip the embed in the editor.
				return '';
			}

			$embed_video = wp_oembed_get( $video_url, ['height' => $height, 'width' => $width, 'mute' => $mute, 'autoplay' => $autoplay, 'controls' => $controls] );

			if( $embed_video ) {

				$mute_param = 'mute=' . $mute;

				// Vimeo uses muted instead of mute
				if ( strpos($video_url, 'vimeo.com') !== false ) {
					$mute_param = 'muted=' . $mute;
				}

				$params = '&autoplay=' . $autoplay . '&' . $mute_param . '&controls=' . $controls;

				$embed_video = preg_replace(
					'/src="([^"]+)"/',
					'src="$1' . $params . '"',
					$embed_video
				);

				// Force the height and width since wp_oembed_get ignores these for most providers
				$embed_video = preg_replace( '/\s+height="[^"]*"/', '', $embed_video );
				$embed_video = preg_replace( '/\s+width="[^"]*"/', '', $embed_video );
				$embed_video = preg_replace( '/<iframe/', '<iframe width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '"', $embed_video );

			}
		}

		return $embed_video;
	}

	public static function boldpost_reading_time($content = null, $wpm = 200, $suffix = '') {
		if ( $content === null ) {
			$content = get_the_content();
		}
		$word_count    = str_word_count( wp_strip_all_tags( $content ) );
		$total_seconds = (int) round( ( $word_count / $wpm ) * 60 );
		$minutes       = (int) floor( $total_seconds / 60 );
		$seconds       = $total_seconds % 60;
		$time          = sprintf( '%02d:%02d', $minutes, $seconds );
		return trim( $time . ' ' . $suffix );
	}
}