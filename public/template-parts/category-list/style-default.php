<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="<?php echo esc_attr($col_class); ?>">
    <div class="boldpo-category-item">
        <a href="<?php echo esc_url( $category_link ); ?>" class="boldpo-category-link">
            <div class="boldpo-category-content">
                <?php if ( ! empty( $category_image ) ) : ?>
                    <div class="boldpo-category-image">
                        <img src="<?php echo esc_url( $category_image ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" />
                    </div>
                <?php endif; ?>
                <div class="boldpo-category-content-text">
                    <<?php echo esc_attr($title_tag); ?> class="boldpo-category-title">
                        <?php echo esc_html( $category->name ); ?>
                    </<?php echo esc_attr($title_tag); ?>>
                    <?php if ( $show_description && ! empty( $category->description ) ) : ?>
                        <div class="boldpo-category-description">
                            <?php echo esc_html( $category->description ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            
                <?php if ( $show_count && ( $category->count > 0 || $show_empty_count ) ) : ?>
                    <span class="boldpo-category-count">
                        <?php echo esc_html( $category->count ); ?>
                    </span>
                <?php endif; ?>
            </div>
        </a>
    </div>
</div>