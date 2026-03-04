<?php 
// Hook to add the admin menu
// Add menu item in the WordPress admin
if (!get_option('LICENCE_KEY')) {
    
function simple_webp_converter_menu() {
    add_options_page(
        'WEBb-E Plugin',
        'WebP Converter',
        'manage_options',
        'webb-e',
        'webp_converter_settings_page_html'
    );
}
add_action('admin_menu', 'simple_webp_converter_menu');

}

// Hook to reload the page when media is deleted from the library
function reload_page_on_media_delete( $post_id ) {
    if ( get_post_type( $post_id ) === 'attachment' ) {
        echo '<script type="text/javascript">
                window.location.reload();
              </script>';
    }
}
add_action( 'delete_attachment', 'reload_page_on_media_delete' );