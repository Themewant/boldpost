<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$target_attr = $item_new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';

$image_src = ! empty( $item_image_url )
    ? $item_image_url
    : BOLDPO_PL_URL . 'public/assets/img/placeholder.png';
$image_alt = ! empty( $item_image_alt ) ? $item_image_alt : $item_title;
?>
<div class="<?php echo esc_attr( $col_class ); ?>">
    <div class="boldpo-info-box-item">
        <a href="<?php echo esc_url( $item_url ); ?>" class="boldpo-info-box-image"<?php echo $item_new_tab ? ' target="_blank" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" />
        </a>
        <div class="boldpo-info-box-content">
            <?php if ( ! empty( $item_subtitle ) ) : ?>
                <span class="boldpo-info-box-subtitle"><?php echo esc_html( $item_subtitle ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $item_title ) ) : ?>
                <<?php echo esc_attr( $title_tag ); ?> class="boldpo-info-box-title">
                    <a href="<?php echo esc_url( $item_url ); ?>"<?php echo $item_new_tab ? ' target="_blank" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                        <?php echo esc_html( $item_title ); ?>
                    </a>
                </<?php echo esc_attr( $title_tag ); ?>>
            <?php endif; ?>
        </div>
    </div>
</div>
