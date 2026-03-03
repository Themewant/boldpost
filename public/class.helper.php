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

	public static function ensure_unit ($value) {
		if ( $value === '' || $value === null ) return '0px';
		if ( is_numeric( $value ) && $value != 0 ) return $value . 'px';
		return $value;
	}

	public static function get_inline_styles ($style_map) {
		$styles = [];
		foreach ( $style_map as $prop => $value ) {
			//if ( $value !== '' && $value !== null && $value !== 'inherit' && $value !== '0px' ) {
				$styles[] = $prop . ':' . $value;
			//}
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
					$decls .= $prop . ":" . wp_strip_all_tags( $val ) . ";";
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

		if ( ! empty( $css ) ) {
			if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS values are sanitized via wp_strip_all_tags() during generation
				echo '<style>' . $css . '</style>';
			} else {
				wp_add_inline_style( $handle, $css );
			}
		}
	}

	public static function box_shadow_to_css($shadow) {
		$x = self::ensure_unit($shadow['x'] ?? 0);
		$y = self::ensure_unit($shadow['y'] ?? 0);
		$b = self::ensure_unit($shadow['b'] ?? 0);
		$s = self::ensure_unit($shadow['s'] ?? 0);
		$c = $shadow['c'] ?? 'rgba(0,0,0,0)';
		return "$x $y $b $s $c";
	}

	public static function border_to_css($border) {
		$width = self::ensure_unit($border['width'] ?? 0);
		$style = $border['style'] ?? 'solid';
		$color = $border['color'] ?? 'rgba(0,0,0,0)';
		return "$width $style $color";
	}

	public static function boldpo_get_meta_html($attributes) {    
		$boldpo_allowed_metas = isset($attributes['allowedMetas']) ? $attributes['allowedMetas'] : [];
		$boldpo_meta_html = '';
		if ( in_array( 'date', $boldpo_allowed_metas ) && empty($attributes['showDateOnTop'])) {
			$boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-calendar-two"></i>' . esc_html( get_the_date() ) . '</span>';
		}
		if ( in_array( 'author', $boldpo_allowed_metas ) ) {
				$boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-user-avatar"></i><a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html( $attributes['authorPrefix'] ) . ' ' . esc_html( get_the_author() ) . '</a></span>';
		}
		if ( in_array( 'category', $boldpo_allowed_metas ) ) {
			$boldpo_categories = get_the_category();
			if ( ! empty($boldpo_categories) ) {
				$cat_links = [];
				foreach ($boldpo_categories as $boldpo_category) {
					if ( $boldpo_category->slug === 'uncategorized' ) {
						continue;
					}
					$cat_links[] = '<a href="' . esc_url(get_category_link($boldpo_category->term_id)) . '">' . esc_html( $boldpo_category->name ) . '</a>';
				}
				if ( ! empty( $cat_links ) ) {
					$boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-notification-status"></i>';
					$boldpo_meta_html .= implode( ', ', $cat_links );
					$boldpo_meta_html .= '</span>';
				}
			}
		}
		if ( in_array( 'tag', $boldpo_allowed_metas ) ) {
			$boldpo_tags = get_the_tags();
			if ( $boldpo_tags ) {
				$boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-tags"></i>';
				$tag_links = [];
				foreach ($boldpo_tags as $boldpo_tag) {
					$tag_links[] = '<a href="' . esc_url(get_tag_link($boldpo_tag->term_id)) . '">' . esc_html( $boldpo_tag->name ) . '</a>';
				}
				$boldpo_meta_html .= implode( ', ', $tag_links );
				$boldpo_meta_html .= '</span>';
			}
		}
		?>
		<div class="boldpo-blog-metas">
			<?php 
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped during generation
			echo wp_kses_post( $boldpo_meta_html ); 
			?>
		</div>
		<?php
	}

	public static function boldpo_get_category_html($attributes, $style = 'default') {   
		$boldpo_allowed_metas = isset($attributes['allowedMetas']) ? $attributes['allowedMetas'] : [];
		$boldpo_meta_html = '';
		if ( in_array( 'category', $boldpo_allowed_metas ) ) {
			$boldpo_categories = get_the_category();
			if ( ! empty($boldpo_categories) ) {
				$cat_links = [];
				foreach ($boldpo_categories as $boldpo_category) {
					if ( $boldpo_category->slug === 'uncategorized' ) {
						continue;
					}
					if($style == 'default') {
						$cat_links[] = '<a href="' . esc_url(get_category_link($boldpo_category->term_id)) . '">' . esc_html( $boldpo_category->name ) . '</a>';
					} else {
						$cat_color = get_term_meta($boldpo_category->term_id, 'category_color', true);
						$dot_style = $cat_color ? 'background-color: ' . esc_attr( $cat_color ) : '';
						$cat_links[] = '<span class="bldpost-meta"><span class="boldpo-cat-dot" style="' . $dot_style . '"></span><a href="' . esc_url(get_category_link($boldpo_category->term_id)) . '">' . esc_html( $boldpo_category->name ) . '</a></span>';
					}
				}
				if ( ! empty( $cat_links ) ) {
					if($style == 'default') {
						$boldpo_meta_html .= '<span class="bldpost-meta"><i class="boldpo-meta-icon boldpo-icon-notification-status"></i>';
						$boldpo_meta_html .= implode( ', ', $cat_links );
						$boldpo_meta_html .= '</span>';
					} else {
						// Each cat_link is already a full <span>, so just join them
						$boldpo_meta_html .= implode( '', $cat_links );
					}
				}
			}
		}
		?>
		<div class="boldpo-blog-categories">
			<?php 
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped during generation
			echo wp_kses_post( $boldpo_meta_html ); 
			?>
		</div>
		<?php
	}
}