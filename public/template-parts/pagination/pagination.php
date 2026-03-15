<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="boldpost-pagination-container">
    <?php
    if($pagination == true && $query->max_num_pages > 1) {
        $pagination_html = '';
        
        if ($pagination_type === 'numeric') {
            $pagination_html = paginate_links( array(
                'base'      => is_archive() ? str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ) : str_replace( '999999999', '%#%', add_query_arg( $page_key, '999999999' ) ),
                'format'    => is_archive() ? '?paged=%#%' : '',
                'current'   => $paged,
                'total'     => $query->max_num_pages,
                'prev_text' => '<i class="boldpo-icon-chevron-left"></i>',
                'next_text' => '<i class="boldpo-icon-chevron-right"></i>',
            ) );

            if ($pagination_html) {
                $pagination_html = '<div class="boldpo-pagination">' . $pagination_html . '</div>';
            }
        }

        echo apply_filters('boldpost_pagination_html', $pagination_html, $query, $attributes, $paged, $page_key);
    } 
    ?>
</div>