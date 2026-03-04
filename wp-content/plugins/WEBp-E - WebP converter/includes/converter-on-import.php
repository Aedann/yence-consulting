<?php
if (!get_option('LICENCE_KEY')) {
// Hook into the upload process
add_filter('wp_handle_upload', 'convert_image_to_webp');

// Main function to handle image conversion
function convert_image_to_webp($upload) {
    $file_path = $upload['file'];
    $file_type = $upload['type'];

    // Only convert if the file is an image (JPEG, JPG, PNG)
    if (strpos($file_type, 'image/jpeg') !== false || strpos($file_type, 'image/png') !== false) {
        $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);

        // Get user settings for compression and resizing
        $quality = (int) get_option('webp_compression_quality', 80);
        $lossless = (bool) get_option('webp_lossless_mode', 0);
        $resize_percentage = (int) get_option('webp_resize_percentage', 100);

        // Convert the image to WebP
        if (convert_to_webp($file_path, $webp_path, $quality, $lossless, $resize_percentage)) {
            // Optionally delete the original file after conversion
            unlink($file_path);

            // Update the file path and type to the WebP file
            $upload['file'] = $webp_path;
            $upload['type'] = 'image/webp';
            $upload['url'] = preg_replace('/\.(jpe?g|png)$/i', '.webp', $upload['url']);
        }
    }

    return $upload;
}

// Function to convert images to WebP
function convert_to_webp($input_path, $output_path, $quality = 80, $lossless = false, $resize_percentage = 100) {
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