jQuery(document).ready(function($) {
    $('body').on('click', 'button[id^="convert-webp-"]', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const attachmentId = button.attr('id').replace('convert-webp-', '');
        const processInfo = button.siblings('.process-info');

        // Clear previous messages
        processInfo.text('Processing...');

        $.ajax({
            url: webp_ajax.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'convert_to_webp',
                attachment_id: attachmentId,
                nonce: webp_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    processInfo.html('Image converted to WebP successfully !');
                    
                    // Refresh the Media Library page and open the new image
                    setTimeout(function() {
                        const newImageId = response.data.attachment_id; // Ensure attachment ID is returned
                        const libraryPageUrl = wp.media.view.settings.post.id ? `media-upload.php?item=${newImageId}` : `upload.php?item=${newImageId}`;
                        window.location.href = libraryPageUrl;
                    }, 500); // Adjust the delay as needed
                } else {
                    processInfo.text('Failed to convert image: ' + response.data.message);
                }
            },
            error: function(response) {
                processInfo.text('An error occurred during the conversion : ' + response.statusText);
            }
        });
    });
});
