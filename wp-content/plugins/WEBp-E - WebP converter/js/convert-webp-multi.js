jQuery(document).ready(function($) {
    // Add custom button to media toolbar

    var $convertButton = '<button disabled="disabled" class="button button-primary custom-primary-button" id="bulk-convert-webp" style="border-radius: 100px"><svg xmlns="http://www.w3.org/2000/svg" width="68.664" height="67.598" viewBox="0 0 68.664 67.598"><g transform="translate(13976.711 18033.703)"><path d="M12.143,6.071a6.078,6.078,0,0,0-6.071,6.071v27.19A6.078,6.078,0,0,0,12.143,45.4h27.19A6.078,6.078,0,0,0,45.4,39.332V12.143a6.078,6.078,0,0,0-6.071-6.071H12.143m0-6.071h27.19A12.143,12.143,0,0,1,51.475,12.143v27.19A12.143,12.143,0,0,1,39.332,51.475H12.143A12.143,12.143,0,0,1,0,39.332V12.143A12.143,12.143,0,0,1,12.143,0Z" transform="translate(-13976.711 -18033.703)" fill="#fff"/><path d="M-68.853,154.85a12.106,12.106,0,0,1-8.01-3.019h-.118v-.1A12.1,12.1,0,0,1-81,142.716v-9.622h6.073v1.738H-50.48V109.449h-.8v-6.072h9.622a12.154,12.154,0,0,1,12.136,12.147v27.192A12.148,12.148,0,0,1-41.663,154.85Z" transform="translate(-13878.52 -18120.955)" fill="#fff"/></g></svg>Compress and Convert to WebP</button>'
    $('.media-toolbar .media-toolbar-secondary').prepend($convertButton);

        // Select the button you want to observe
        // var deleteButton = document.querySelector('.media-toolbar-secondary button.delete-selected-button');
// Select the button you want to enable/disable
var convertButton = document.getElementById('bulk-convert-webp');
var selectedCount = 0;
var converting = false;

// Function to check how many media items are selected and update button text
function updateButtonState() {
    if(!converting){
        var selectedItems = document.querySelectorAll('.media-frame-content .attachment[aria-checked="true"]');
        selectedCount = selectedItems.length;

        // Update the button's text with the number of selected images
        convertButton.textContent = `Convert to WebP (${selectedCount} selected)`;

        // Enable or disable the button based on the number of selected images
        if (selectedCount > 0) {
            convertButton.disabled = false;  // Enable the button if at least one item is selected
        } else {
            convertButton.disabled = true;   // Disable the button if no items are selected
        }
        setTimeout(() => {
            updateButtonState();
        }, 150);
    }
}

// Use MutationObserver to monitor changes in aria-checked attribute of media items
var mediaItemsContainer = document.querySelector('.media-frame-content');

var observer = new MutationObserver(function(mutationsList) {
    mutationsList.forEach(function(mutation) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'aria-checked') {
            updateButtonState();  // Check and update the button's state and text when selection changes
        }
    });
});

// Start observing all media items for attribute changes
mediaItemsContainer.querySelectorAll('.attachment').forEach(function(item) {
    observer.observe(item, {
        attributes: true, // Observe changes to attributes
        attributeFilter: ['aria-checked'] // Only watch for 'aria-checked' attribute changes
    });
});

// Initial check in case there are already selected items
updateButtonState();
 
    // Handle the button click event
    $('#bulk-convert-webp').on('click', function() {
        // alert("Button clicked"); // Log that button was clicked

        var selectedAttachments = document.querySelectorAll('.media-frame-content .attachment[aria-checked="true"]');
        // var selectedAttachments = wp.media.frame.state().get('selection').toJSON();
        console.log("Selected Attachments:", selectedAttachments); // Log selected attachments

        if (selectedAttachments.length === 0) {
            alert('Please select some images');
            return;
        }

        var attachmentIds = Array.from(selectedAttachments).map(function(attachment) {
            return attachment.getAttribute('data-id');
        });

        console.log("Attachment IDs:", attachmentIds); // Log selected attachment IDs --- We got good IDs
        converting = true;
        $('#bulk-convert-webp').text("Converting "+selectedCount+" images..."); // Change button text to indicate conversion process

        // Perform AJAX request to convert selected images
        $.ajax({
            url: webp_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'bulk_convert_to_webp',
                attachment_ids: attachmentIds,
                nonce: webp_ajax.nonce
            },
            success: function(response) {
                console.log("AJAX Success Response:", response); // Log success response
                $('#bulk-convert-webp').text("Converted "+selectedCount+" images !"); // Change button text to indicate conversion process
                if (response.success) {
                    // alert('Images successfully converted to WebP.');
                    // Refresh the Media Library page and open the new image
                    setTimeout(function() {
                        const libraryPageUrl = '/wp-admin/upload.php';
                        window.location.href = libraryPageUrl;
                    }, 500); // Adjust the delay as needed
                } else {
                    console.error('Error Message:', response.data.message); // Log the error message
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error); // Log the AJAX error
                alert('An error occurred while processing the images.');
            }
        });
    });
});
