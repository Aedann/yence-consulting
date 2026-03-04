<?php 
// Register settings
add_action('admin_init', 'webp_converter_register_settings');
function webp_converter_register_settings() {
    register_setting('webp_converter_settings_group', 'webp_compression_quality');
    register_setting('webp_converter_settings_group', 'webp_lossless_mode');
    register_setting('webp_converter_settings_group', 'webp_resize_percentage');
    register_setting('webp_converter_settings_group', 'webp_lazyload_enabled', array(
        'type' => 'boolean',
        'sanitize_callback' => 'intval'
    ));
    register_setting('webp_converter_settings_group', 'webp_import_converter_enable', array(
        'type' => 'boolean',
        'sanitize_callback' => 'intval'
    ));
}

