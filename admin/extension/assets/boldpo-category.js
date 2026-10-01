/**
 * Category image and colour fields on the term edit screens.
 *
 * Moved out of class.category.php, where it was printed as an inline <script> on
 * admin_footer. The code is unchanged apart from the two translated strings,
 * which now come from the localized boldpoCategory object.
 */
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
            title: boldpoCategory.chooseImage,
            button: {
                text: boldpoCategory.chooseImage
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
