<?php


if (get_option('LICENCE_KEY')) {
    add_action('admin_enqueue_scripts', 'enqueue_multi_convert_webp_js');
    function enqueue_multi_convert_webp_js($hook) {
        if ($hook !== 'upload.php') {
            return;
        }
        wp_enqueue_script('convert-webp-multi', plugin_dir_url(__DIR__) . 'js/convert-webp-multi.js', array('jquery'), null, true);

        // Pass AJAX URL and nonce to the JavaScript file
        wp_localize_script('convert-webp-multi', 'bulk_webp', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('webp_convert_nonce')
        ));
    }


// Handle the AJAX request to convert selected images to WebP
add_action('wp_ajax_bulk_convert_to_webp', 'bulk_convert_to_webp_ajax');
function bulk_convert_to_webp_ajax() {
    // Check for nonce (for security purposes, if you're using one in your JS)
    check_ajax_referer('webp_convert_nonce', 'nonce');

    // Check if the selected image IDs are sent via POST
    if (!isset($_POST['attachment_ids'])) {
        wp_send_json_error('No images selected');
    }

   // Sanitize the incoming attachment IDs
    $attachment_ids = array_map('intval', $_POST['attachment_ids']);
    // Convert array to string for display purposes
    $attachment_ids_string = implode(', ', $attachment_ids);

    // Display the attachment IDs
    // wp_die("Selected Images (wp-die): " . $attachment_ids_string);

    foreach ($attachment_ids as $attachment_id) {
        $file_path = get_attached_file($attachment_id);
        $file_type = get_post_mime_type($attachment_id);
        // wp_die("File Path: " . $file_path . "<br>");

        // Only convert if it's a JPEG or PNG
        if (strpos($file_type, 'image/jpeg') !== false || strpos($file_type, 'image/png') !== false) {
            $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);

            // Get user settings for compression and resizing (default values used here)
            $quality = (int) get_option('webp_compression_quality', 80);
            $lossless = (bool) get_option('webp_lossless_mode', 0);
            $resize_percentage = (int) get_option('webp_resize_percentage', 100);

            // Convert the image to WebP
            if (convert_to_webp_for_multiple($file_path, $webp_path, $quality, $lossless, $resize_percentage)) {
                // Duplicate the attachment
                $upload = wp_upload_bits(basename($webp_path), null, file_get_contents($webp_path));
                if ($upload['error']) {
                    wp_send_json_error(array('message' => 'Failed to upload WebP image.'));
                    continue; // Skip and move to the next one
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
                }else {
                    wp_send_json_error(array('message' => 'Failed to create attachment.'));
                }
            }else {
                wp_send_json_error(array('message' => 'Failed to convert image to WebP.'));
            }
        }
    }

    wp_send_json_success(array('message' => 'Selected images have been converted to WebP.'));
}



// Function to convert images to WebP
function convert_to_webp_for_multiple($input_path, $output_path, $quality = 80, $lossless = false, $resize_percentage = 100) {
    // Check if the GD library is available
    if (!extension_loaded('gd')) {
        error_log('GD library is not available.');
        return false;
    }

    // Load the image based on its format
    $image = null;
    $image_info = getimagesize($input_path);
    $mime = $image_info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($input_path);
            break;
        case 'image/png':
            $image = imagecreatefrompng($input_path);
            break;
        default:
            return false; // Unsupported format
    }

    // If the image could not be loaded, return false
    if (!$image) {
        return false;
    }

    // Resize the image if needed
    if ($resize_percentage < 100) {
        $new_width = imagesx($image) * ($resize_percentage / 100);
        $new_height = imagesy($image) * ($resize_percentage / 100);
        $resized_image = imagescale($image, $new_width, $new_height, IMG_BICUBIC);

        // Free the original image memory
        imagedestroy($image);
        $image = $resized_image;
    }

    // Convert the image to WebP with specified quality and mode
    if ($lossless) {
        $result = imagewebp($image, $output_path, 100); // Lossless, set quality to 100
    } else {
        $result = imagewebp($image, $output_path, $quality); // Lossy, adjust quality (0-100)
    }

    // Free up memory
    imagedestroy($image);

    return $result;
}
}else{
    echo "Please enter the licence key";
}