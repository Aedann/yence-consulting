=== Simple Converter ===
Contributors: Aubin Cortacero
Tags: image conversion, webp, bulk conversion, media library
Requires at least: 5.0
Tested up to: 6.3
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Simple Converter plugin allows you to bulk convert images in your media library to WebP format. 
This helps optimize your WordPress site by reducing image file sizes, improving loading times and overall site performance.

== Description ==

The **Simple Converter** plugin provides an easy way to convert all images in your WordPress media library to the WebP format. 
The plugin supports bulk conversion of images and can automatically convert images upon upload. 
It also provides an option to enable or disable conversion on image upload from the settings page.

Key Features:
* Bulk conversion of selected images to WebP format.
* Automatic conversion of images upon upload (configurable).
* Customizable settings to enable/disable conversion.
* Fast and lightweight.

== Installation ==

1. Download the plugin zip file from the WordPress Plugin Repository or manually.
2. Upload the plugin folder to the `/wp-content/plugins/` directory or install it directly through the WordPress plugin manager.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Enable "import conversion" in plugin settings to start importing media and convert them automatically.
4. Go to the 'Media' section in your admin dashboard to start bulk converting images.

== Frequently Asked Questions ==

= How does the bulk conversion work? =

After activation, you can navigate to the media library. 
There, select multiple images and use the 'Convert to WebP' button added to the toolbar to perform bulk conversion. 
You can also configure auto-conversion on image uploads via the plugin settings.

= How can I disable automatic conversion on image uploads? =

Go to **Settings -> Simple Converter** and toggle the option for automatic conversion during image uploads.

= Will this plugin alter my original images? =

No, the plugin converts copies of the original images to WebP format and stores them alongside the originals. 
Your original images will remain untouched.
Excpeted for uploaded files, those are directly formatted in WebP format and original image is not kept.

= What if my server doesn't support WebP? =

The plugin requires server-side support for WebP image generation (typically via GD or Imagick extensions). 
If your server doesn't support this, you will need to contact your hosting provider to enable WebP support.

== Screenshots ==

1. **Bulk Conversion Option** - Select multiple images in the media library and convert them to WebP.
2. **Settings Page** - Enable or disable automatic conversion upon image upload.
3. **Conversion Notification** - Receive feedback on conversion status in real-time.

== Changelog ==

= 1.0.0 =
* Initial release of Simple Converter plugin.
* Added bulk conversion of media library images to WebP.
* Added option to enable/disable WebP conversion on image upload.

== Upgrade Notice ==

= 1.0.0 =
Initial release. No upgrades required.

== License ==

This plugin is licensed under the GNU General Public License v2.0 or later.
