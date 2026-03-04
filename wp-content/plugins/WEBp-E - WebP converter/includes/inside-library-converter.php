<?php 
if (!get_option('LICENCE_KEY')) {

// Add custom button to media edit page
add_filter('attachment_fields_to_edit', 'add_convert_to_webp_button', 10, 2);
function add_convert_to_webp_button($form_fields, $post) {
    $file_type = get_post_mime_type($post->ID);
    if (strpos($file_type, 'image/jpeg') !== false || strpos($file_type, 'image/png') !== false) {
        $form_fields['convert_to_webp'] = array(
            'label' => 'Convert to WebP',
            'input' => 'html',
            'html'  => '<button type="button" class="button custom-primary-button button-primary" id="convert-webp-' . $post->ID . '">Convert & Compress to WebP</button>
                        <div class="process-info" style="margin-top: 10px; color: #0073aa;"></div>',
        );
    }

    return $form_fields;
}


// Enqueue JavaScript for handling the button click for converting to WebP in library
add_action('admin_enqueue_scripts', 'enqueue_convert_webp_scripts');
function enqueue_convert_webp_scripts($hook) {
    if ($hook !== 'upload.php') {
        return;
    }
    wp_enqueue_script('convert-webp', plugin_dir_url(__DIR__) . 'js/convert-webp.js', array('jquery'), null, true);

    // Pass AJAX URL to the script
    wp_localize_script('convert-webp', 'webp_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('webp_convert_nonce'),
    ));
}

// Handle the AJAX request
add_action('wp_ajax_convert_to_webp', 'convert_to_webp_ajax');
function convert_to_webp_ajax() {
    check_ajax_referer('webp_convert_nonce', 'nonce');

    $attachment_id = intval($_POST['attachment_id']);
    $file_path = get_attached_file($attachment_id);
    $file_type = get_post_mime_type($attachment_id);

    // Only convert if it's a JPEG or PNG
    if (strpos($file_type, 'image/jpeg') !== false || strpos($file_type, 'image/png') !== false) {
        $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);

        // Get user settings for compression and resizing
        $quality = (int) get_option('webp_compression_quality', 80);
        $lossless = (bool) get_option('webp_lossless_mode', 0);
        $resize_percentage = (int) get_option('webp_resize_percentage', 100);

        // Convert the image to WebP
        if (convert_to_webp($file_path, $webp_path, $quality, $lossless, $resize_percentage)) {
            // Duplicate the attachment
            $upload = wp_upload_bits(basename($webp_path), null, file_get_contents($webp_path));
            if ($upload['error']) {
                wp_send_json_error(array('message' => 'Failed to upload WebP image.'));
                return;
            }

            // Create a new attachment for the WebP image
            $attachment = array(
                'post_mime_type' => 'image/webp',
                'post_title'     => sanitize_text_field(pathinfo($upload['file'], PATHINFO_FILENAME)),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'guid'           => $upload['url'],
            );

            $new_attachment_id = wp_insert_attachment($attachment, $upload['file']);
            if (!is_wp_error($new_attachment_id)) {
                // Generate attachment metadata and update the attachment
                $metadata = wp_generate_attachment_metadata($new_attachment_id, $upload['file']);
                wp_update_attachment_metadata($new_attachment_id, $metadata);

                // Return the new WebP URL and attachment ID
                $webp_url = wp_get_attachment_url($new_attachment_id);
                wp_send_json_success(array(
                    'webp_url' => $webp_url,
                    'attachment_id' => $new_attachment_id
                ));
            } else {
                wp_send_json_error(array('message' => 'Failed to create attachment.'));
            }
        } else {
            wp_send_json_error(array('message' => 'Failed to convert image to WebP.'));
        }
    } else {
        wp_send_json_error(array('message' => 'File type not supported.'));
    }
}
}else{
    echo "Please enter the licence key";
}