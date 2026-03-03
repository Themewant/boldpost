<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BOLDPO_Category {
    public static function instance() {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    public function __construct() {
        add_action( 'category_edit_form_fields', array( $this, 'category_image_color_field' ) );
        add_action( 'category_add_form_fields', array( $this, 'category_image_color_field' ) );
        add_action( 'edited_category', array( $this, 'save_category_image_color' ) );
        add_action( 'created_category', array( $this, 'save_category_image_color' ) );
        add_action( 'admin_footer', array( $this, 'category_image_color_enqueue' ) );
    }
    
    // Category Image and Color Metabox
    function category_image_color_enqueue() {
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

        ?>
        <script>
            jQuery(document).ready(function($) {
                var mediaUploader;

                $('.category-color-picker').wpColorPicker();

                $('.category_image_button').click(function(e) {
                    e.preventDefault();

                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }

                    mediaUploader = wp.media.frames.file_frame = wp.media({
                        title: '<?php esc_html_e( "Choose Image", "dnews" ); ?>',
                        button: {
                            text: '<?php esc_html_e( "Choose Image", "dnews" ); ?>'
                        },
                        multiple: false
                    });

                    mediaUploader.on('select', function() {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        $('#category_image').val(attachment.id);
                        $('#category_image_preview').html('<img src="' + attachment.url + '" style="max-width:100px;"/>');
                    });

                    mediaUploader.open();
                });

                $('.category_image_remove_button').click(function(e) {
                    e.preventDefault();
                    $('#category_image').val('');
                    $('#category_image_preview').html('');
                });
            });
        </script>
        <?php
    }

    function category_image_color_field( $term ) {
        $category_image_id = '';
        $category_color = '';

        // Check if $term is an object before accessing properties
        if ( is_object( $term ) ) {
            $category_image_id = get_term_meta( $term->term_id, 'category_image', true );
            $category_color = get_term_meta( $term->term_id, 'category_color', true );
        }

        $category_image_url = '';
        if ( $category_image_id ) {
            $category_image_url = wp_get_attachment_image_url( $category_image_id, 'thumbnail' );
        }
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="category_image"><?php esc_html_e( 'Image', 'dnews' ); ?></label>
            </th>
            <td>
                <div id="category_image_preview">
                    <?php if ( $category_image_url ) : ?>
                        <img src="<?php echo esc_url( $category_image_url ); ?>" style="max-width: 100px;" />
                    <?php endif; ?>
                </div>
                <input type="hidden" id="category_image" name="category_image" value="<?php echo esc_attr( $category_image_id ); ?>" />
                <button type="button" class="button category_image_button"><?php esc_html_e( 'Upload Image', 'dnews' ); ?></button>
                <button type="button" class="button category_image_remove_button"><?php esc_html_e( 'Remove Image', 'dnews' ); ?></button>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="category_color"><?php esc_html_e( 'Color', 'dnews' ); ?></label>
            </th>
            <td>
                <input type="text" id="category_color" name="category_color" class="category-color-picker" value="<?php echo esc_attr( $category_color ); ?>" />
            </td>
        </tr>
        <?php
    }

    function save_category_image_color( $term_id ) {
        if ( isset( $_POST['category_image'] ) ) {
            update_term_meta( $term_id, 'category_image', sanitize_text_field( $_POST['category_image'] ) );
        }
        if ( isset( $_POST['category_color'] ) ) {
            update_term_meta( $term_id, 'category_color', sanitize_hex_color( $_POST['category_color'] ) );
        }
    }
}
BOLDPO_Category::instance();