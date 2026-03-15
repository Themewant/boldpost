<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="boldpo-grid-item <?php echo esc_attr( $item_class ); ?>">
    <div class="boldpo-grid-item-inner">
        <div class="boldpo-blog-content">
            <<?php echo esc_attr( $title_tag ); ?> class="boldpo-blog-title">
                <a href="<?php the_permalink(); ?>"><?php echo esc_html( $trimmed_title ); ?></a>
            </<?php echo esc_attr( $title_tag ); ?>>
        </div>
    </div>
</div>