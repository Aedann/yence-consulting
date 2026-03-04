<?php
ob_start();
/**
 * Plugin Name: WEBb-E - Simple WebP converter
 * Description: Automatically converts uploaded images (JPEG, PNG) to WebP format with adjustable compression settings. Convert PNG and JPG files directly from media library.
 * Version: 1.0
 * Author: Aubin Cortacero
 */


// Handle menu parameters
// require_once plugin_dir_path(__FILE__) . 'includes/licence.php';
// Handle menu parameters
require_once plugin_dir_path(__FILE__) . 'includes/menu-parameters.php';

  //CHECK LICENCE KEY
  if (!get_option('LICENCE_KEY')) {

// Display settings page HTML
function webp_converter_settings_page_html() {

    ?>

    <div class="wrap custom-plugin-ac"> 
        <div class="header">
            <h1><svg xmlns="http://www.w3.org/2000/svg" width="108.319" height="96.572" viewBox="0 0 108.319 96.572"><g transform="translate(-1777.501 -412.318)"><path d="M26.713,7.893A18.82,18.82,0,1,0,40.02,13.4,18.7,18.7,0,0,0,26.713,7.893m0-7.893A26.713,26.713,0,1,1,0,26.713,26.713,26.713,0,0,1,26.713,0Z" transform="translate(1819.596 426.549)" fill="#6321e1"/><path d="M11.935,7.893a4.043,4.043,0,1,0,4.043,4.043,4.047,4.047,0,0,0-4.043-4.043m0-7.893A11.935,11.935,0,1,1,0,11.935,11.935,11.935,0,0,1,11.935,0Z" transform="translate(1834.373 441.326)" fill="#6321e1"/><path d="M-12402.169-19701.7a5.525,5.525,0,0,1,5.384,4.3c.14.619,13.565,62.328-35.4,84.609-11.182,5.086-21.494,7.666-30.654,7.666-27.188,0-39.916-22.088-40.468-43.986-.676-26.891,24.188-41.145,25.247-41.74a5.5,5.5,0,0,1,1.944-.654l73.182-10.139A5.327,5.327,0,0,1-12402.169-19701.7Zm-60.668,85.523c7.569,0,16.343-2.244,26.078-6.676,33.792-15.377,31.945-53.383,30.058-67.117l-66.75,9.246c-3.758,2.424-19.255,13.527-18.808,31.332C-12491.872-19634.062-12483.936-19616.172-12462.837-19616.172Z" transform="translate(14280.819 20114.014)" fill="#6321e1"/></g></svg>
            WEBb-E - Simple WebP converter</h1>
            <p class="message-result-api">License Activated</p>
            <p class="description">Set parameters and convert PNG and JPG files in the simplest way.</p>
        </div>
        <div class="flex">
        <div class="col-left">


        <div class="col">
            <h2>Converter Settings</h2>
            <form method="post" action="options.php">
                <input type="hidden" name="action" value="save_custom_options">
                <?php
                settings_fields('webp_converter_settings_group');
                do_settings_sections('webp_converter_settings_group');
                ?>
                <div class="settings-container">
                    <div class="setting">
                        <div class="label-setting"><span><svg xmlns="http://www.w3.org/2000/svg" width="56.192" height="60.186" viewBox="0 0 56.192 60.186">
  <g id="Groupe_588" data-name="Groupe 588" transform="translate(13725.186 17901.594)">
    <g id="noun-pixels-4735508" transform="translate(-13720.725 -17897.664)">
      <g id="Groupe_581" data-name="Groupe 581" transform="translate(0 0)">
        <path id="Tracé_2721" data-name="Tracé 2721" d="M39.324,57.191h-7a.968.968,0,0,1-1-1v-6a.968.968,0,0,1,1-1h7a.968.968,0,0,0,1-1v-7a.968.968,0,0,0-1-1h-7a.968.968,0,0,1-1-1v-6c0-.579.421-2,1-2h7a.968.968,0,0,0,1-1v-6a.968.968,0,0,0-1-1h-7a.968.968,0,0,1-1-1v-7a.968.968,0,0,0-1-1h-15a.968.968,0,0,0-1,1v50a.968.968,0,0,0,1,1h24a.968.968,0,0,0,1-1v-7A1.012,1.012,0,0,0,39.324,57.191Z" transform="translate(-14.6 -14.528)" fill="#081e34"/>
        <path id="Tracé_2722" data-name="Tracé 2722" d="M58.1,63.221a.968.968,0,0,0-1-1h-6a.968.968,0,0,0-1,1v6a.968.968,0,0,0,1,1h6a.968.968,0,0,0,1-1Z" transform="translate(-24.372 -27.556)" fill="#081e34"/>
        <path id="Tracé_2723" data-name="Tracé 2723" d="M81.61,14.164h-7a.968.968,0,0,0-1,1v7a.968.968,0,0,0,1,1h7a.968.968,0,0,0,1-1v-7A.966.966,0,0,0,81.61,14.164Z" transform="translate(-30.886 -14.5)" fill="#081e34"/>
        <path id="Tracé_2725" data-name="Tracé 2725" d="M81.61,37.705h-7c-.579,0-1,1.421-1,2v6a.968.968,0,0,0,1,1h7a.968.968,0,0,0,1-1v-6C82.683,39.126,82.19,37.705,81.61,37.705Z" transform="translate(-30.886 -21.042)" fill="#081e34"/>
        <path id="Tracé_2726" data-name="Tracé 2726" d="M69.354,73.477h-7a.968.968,0,0,0-1,1v7a.968.968,0,0,0,1,1h7a.967.967,0,0,0,1-1v-7A1.012,1.012,0,0,0,69.354,73.477Z" transform="translate(-27.629 -30.813)" fill="#081e34"/>
        <path id="Tracé_2727" data-name="Tracé 2727" d="M57.1,37.705h-6c-.579,0-1,1.421-1,2v6a.968.968,0,0,0,1,1h6a.968.968,0,0,0,1-1v-6C58.1,39.126,57.676,37.705,57.1,37.705Z" transform="translate(-24.372 -21.042)" fill="#081e34"/>
        <path id="Tracé_2728" data-name="Tracé 2728" d="M51.1,23.191h6a.968.968,0,0,0,1-1v-7a.968.968,0,0,0-1-1h-6a.968.968,0,0,0-1,1v7A1.012,1.012,0,0,0,51.1,23.191Z" transform="translate(-24.372 -14.528)" fill="#081e34"/>
      </g>
    </g>
    <path id="Soustraction_26" data-name="Soustraction 26" d="M22.186,61.186H14.669A13.669,13.669,0,0,1,1,47.516V14.669A13.671,13.671,0,0,1,14.669,1h7.517V6.334H14.669a8.344,8.344,0,0,0-8.335,8.335V47.516a8.344,8.344,0,0,0,8.335,8.335h7.517v5.333Z" transform="translate(-13726.186 -17902.594)" fill="#081e34"/>
  </g>
</svg>

WebP Compression Quality</span><p class="description">Set the quality level for lossy compression, 0 bad quality, 100 good quality,</p>
</div>
<div class="value-setting">
                        <label for="webp_compression_quality_slider">Compression Quality: </label>
<input type="range" id="webp_compression_quality_slider" name="webp_compression_quality" value="<?php echo esc_attr(get_option('webp_compression_quality', 70)); ?>" min="1" max="100" oninput="document.getElementById('compression_value').textContent = this.value">
<span class="value-slider"><span id="compression_value"><?php echo esc_attr(get_option('webp_compression_quality', 70)); ?></span>%</span>
</div>
                    </div>
                    <div class="setting">
                    <div class="label-setting"><span><svg xmlns="http://www.w3.org/2000/svg" width="60.709" height="60.684" viewBox="0 0 60.709 60.684">
  <g id="Groupe_589" data-name="Groupe 589" transform="translate(13859.469 17902.648)">
    <g id="Groupe_584" data-name="Groupe 584" transform="translate(-13859.469 -17902.648)">
      <path id="Soustraction_27" data-name="Soustraction 27" d="M39.941,51.915H11.975A11.975,11.975,0,0,1,0,39.941V11.975A11.975,11.975,0,0,1,11.975,0H39.941A11.974,11.974,0,0,1,51.915,11.975V39.941A11.975,11.975,0,0,1,39.941,51.915ZM11.975,5.216a6.766,6.766,0,0,0-6.758,6.758V39.941A6.767,6.767,0,0,0,11.975,46.7H39.941A6.767,6.767,0,0,0,46.7,39.941V11.975a6.767,6.767,0,0,0-6.759-6.758Z" transform="translate(0 0)" fill="#081e34"/>
      <path id="Soustraction_24" data-name="Soustraction 24" d="M32.117,42.033H9.912A9.917,9.917,0,0,1,0,32.431H4.963a4.965,4.965,0,0,0,4.948,4.644h22.2a4.964,4.964,0,0,0,4.958-4.958V9.912a4.966,4.966,0,0,0-4.643-4.948V0a9.917,9.917,0,0,1,9.6,9.912v22.2a9.917,9.917,0,0,1-9.917,9.917Z" transform="translate(18.675 18.65)" fill="#081e34"/>
      <path id="Soustraction_28" data-name="Soustraction 28" d="M13909.466,17943.648h-36v-6h18a10.013,10.013,0,0,0,10-10v-15a9.94,9.94,0,0,0-.832-4h8.829v35h0Z" transform="translate(-13852 -17887)" fill="#081e34"/>
    </g>
    <path id="Tracé_2734" data-name="Tracé 2734" d="M0,14.779,14.781,0" transform="translate(-13827.091 -17885.08) rotate(90)" fill="none" stroke="#081e34" stroke-linecap="round" stroke-width="4"/>
    <path id="Tracé_2735" data-name="Tracé 2735" d="M0,0,8.9,8.907,17.8,0" transform="translate(-13838.489 -17869.254) rotate(-45)" fill="none" stroke="#081e34" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
  </g>
</svg>

Resize Percentage</span><p class="description">Resize images by this percentage while maintaining aspect ratio (1-100%).</p>
</div>
<div class="value-setting">
                        <label for="webp_resize_percentage_slider">Resize Percentage: </label>
<input type="range" id="webp_resize_percentage_slider" name="webp_resize_percentage" value="<?php echo esc_attr(get_option('webp_resize_percentage', 100)); ?>" min="1" max="100" oninput="document.getElementById('slider_value').textContent = this.value">
<span class="value-slider"><span id="slider_value"><?php echo esc_attr(get_option('webp_resize_percentage', 100)); ?></span>%</span>
</div>
                        </div>
                        <div class="setting">
                        <div class="label-setting"><span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60.186" height="60.186" viewBox="0 0 60.186 60.186"><defs><clipPath id="a"><rect width="43" height="44" transform="translate(-13782 -17893.648)" fill="#081e34" stroke="#081e34" stroke-width="1"/></clipPath></defs><g transform="translate(13791 17901.594)"><g transform="translate(-1 -0.352)" clip-path="url(#a)"><g transform="translate(-13784.92 -17891.5)"><path d="M14.592,6.057a2,2,0,0,1,3.815,0l1.829,5.806a2,2,0,0,0,1.273,1.3L27.327,15.1a2,2,0,0,1,0,3.794L21.51,20.842a2,2,0,0,0-1.273,1.3l-1.829,5.806a2,2,0,0,1-3.815,0l-1.829-5.806a2,2,0,0,0-1.273-1.3L5.673,18.9a2,2,0,0,1,0-3.794l5.817-1.945a2,2,0,0,0,1.273-1.3Z" transform="translate(-0.08 2.852)" fill="#081e34"/><path d="M10.045,3.077a1,1,0,0,1,1.91,0L13.544,8.2a1,1,0,0,0,.634.651l5.031,1.707a1,1,0,0,1,0,1.894l-5.031,1.707a1,1,0,0,0-.634.651l-1.589,5.119a1,1,0,0,1-1.91,0L8.456,14.8a1,1,0,0,0-.634-.651L2.791,12.447a1,1,0,0,1,0-1.894L7.822,8.846A1,1,0,0,0,8.456,8.2Z" transform="translate(25.92 -0.148)" fill="#081e34"/><path d="M8.567,2.421a1,1,0,0,1,1.866,0l1.213,3.147a1,1,0,0,0,.67.605l3.155.862a1,1,0,0,1,0,1.929l-3.155.862a1,1,0,0,0-.67.605l-1.213,3.147a1,1,0,0,1-1.866,0L7.354,10.432a1,1,0,0,0-.67-.605L3.53,8.965a1,1,0,0,1,0-1.929l3.155-.862a1,1,0,0,0,.67-.605Z" transform="translate(22.92 23.852)" fill="#081e34"/></g></g><path d="M47.516,61.186H14.669A13.669,13.669,0,0,1,1,47.516V14.669A13.671,13.671,0,0,1,14.669,1H47.516A13.671,13.671,0,0,1,61.186,14.669V47.516A13.669,13.669,0,0,1,47.516,61.186ZM14.669,6.334a8.344,8.344,0,0,0-8.335,8.335V47.516a8.344,8.344,0,0,0,8.335,8.335H47.516a8.344,8.344,0,0,0,8.335-8.335V14.669a8.344,8.344,0,0,0-8.334-8.335Z" transform="translate(-13792 -17902.594)" fill="#081e34"/></g></svg>
                        Enable Lossless Compression</span><p class="description">Check to use lossless compression for WebP images.</p>
                        </div>
                        <div class="value-setting">
                            <label for="webp_lossless_mode" class="<?php echo get_option('webp_lossless_mode') ? 'active' : ''; ?> checkbox-custom">
                              <input type="checkbox" name="webp_lossless_mode" value="1" <?php checked(1, get_option('webp_lossless_mode'), true); ?> />  
                              <span>Lossless Compression</span>
                            </label>
                        </div>
                      </div>
                </div>

            <!-- </form> -->
        </div>

        <div class="flex">
            <!-- <div class="col">
                <h2>Convert all media library images</h2>
                <p class="description">Image will be duplicated and converted in WebP format with your settings</p>
                <button id="convert-all-images" class="button button-primary" type="button">Convert All Images to WebP</button>
                <div class="process-info"></div>
            </div> -->
            <div class="col">
                <h2><span><svg xmlns="http://www.w3.org/2000/svg" width="60.186" height="63.346" viewBox="0 0 60.186 63.346"><g transform="translate(14051.323 17904.754)"><path d="M47.516,61.186H14.669A13.669,13.669,0,0,1,1,47.516V17.669A13.671,13.671,0,0,1,14.669,4H47.516A13.671,13.671,0,0,1,61.186,17.669V47.516A13.669,13.669,0,0,1,47.516,61.186ZM14.669,9.335a8.344,8.344,0,0,0-8.335,8.334V47.516a8.344,8.344,0,0,0,8.335,8.335H47.516a8.344,8.344,0,0,0,8.335-8.335V17.669a8.343,8.343,0,0,0-8.334-8.334Z" transform="translate(-14052.323 -17902.594)" fill="#081e34"/><path d="M12.5,46.1.772,34.366A2.635,2.635,0,1,1,4.5,30.639l7.1,7.1V2.635a2.635,2.635,0,0,1,5.271,0V38.008l7.366-7.371a2.635,2.635,0,0,1,3.728,3.726L16.232,46.1a2.637,2.637,0,0,1-3.728,0Z" transform="translate(-14035.597 -17900.754)" fill="#081e34"/><path d="M14.365,46.873a2.645,2.645,0,0,0,1.868-.772L27.962,34.363a2.635,2.635,0,0,0-3.728-3.726l-7.366,7.371V2.636a2.635,2.635,0,0,0-5.271,0v35.1l-7.1-7.1A2.635,2.635,0,1,0,.772,34.366L12.5,46.1a2.632,2.632,0,0,0,1.861.772m0,4h0a6.589,6.589,0,0,1-4.689-1.944L-2.057,37.194a6.634,6.634,0,0,1,0-9.384,6.591,6.591,0,0,1,4.691-1.942,6.594,6.594,0,0,1,4.691,1.942l.27.27V2.635A6.636,6.636,0,0,1,14.233-4a6.643,6.643,0,0,1,6.635,6.636V28.346l.536-.537a6.635,6.635,0,0,1,9.387,9.381L19.062,48.928A6.594,6.594,0,0,1,14.368,50.873Z" transform="translate(-14035.597 -17900.754)" fill="#e4e4e4"/></g></svg>
Convert image directly on import</span></h2>
                <p class="description">Drag and drop your images in library and convert them automatically, using global compression parameters settings </br>Check for enable import conversion.</p>
                            <label for="webp_import_converter_enable" class="<?php echo get_option('webp_import_converter_enable') ? 'active' : ''; ?> checkbox-custom">
                              <input type="checkbox" name="webp_import_converter_enable" value="1" <?php checked(1, get_option('webp_import_converter_enable'), true); ?> />  
                              <span>Enable import auto convert</span>
                            </label>
            </div>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                const labels = document.querySelectorAll('.checkbox-custom');
                labels.forEach(label => {
                  label.addEventListener('click', function() {
                    this.classList.toggle('active');
                  });
                }); 
              });
            </script>
            <div class="col">
                <h2><span><svg xmlns="http://www.w3.org/2000/svg" width="60.709" height="60.684" viewBox="0 0 60.709 60.684"><g transform="translate(13859.469 17902.649)"><g transform="translate(-13859.469 -17902.648)"><path d="M39.941,51.915H11.975A11.975,11.975,0,0,1,0,39.941V11.975A11.975,11.975,0,0,1,11.975,0H39.941A11.974,11.974,0,0,1,51.915,11.975V39.941A11.975,11.975,0,0,1,39.941,51.915ZM11.975,5.216a6.766,6.766,0,0,0-6.758,6.758V39.941A6.767,6.767,0,0,0,11.975,46.7H39.941A6.767,6.767,0,0,0,46.7,39.941V11.975a6.767,6.767,0,0,0-6.759-6.758Z" transform="translate(0 0)" fill="#081e34"/><path d="M32.117,42.033H9.912A9.917,9.917,0,0,1,0,32.431H4.963a4.965,4.965,0,0,0,4.948,4.644h22.2a4.964,4.964,0,0,0,4.958-4.958V9.912a4.966,4.966,0,0,0-4.643-4.948V0a9.917,9.917,0,0,1,9.6,9.912v22.2a9.917,9.917,0,0,1-9.917,9.917Z" transform="translate(18.675 18.65)" fill="#081e34"/><path d="M13909.466,17943.648h-36v-6h18a10.013,10.013,0,0,0,10-10v-15a9.94,9.94,0,0,0-.832-4h8.829v35h0Z" transform="translate(-13852 -17887)" fill="#081e34"/></g><path d="M8.9,10.907h-.07a2,2,0,0,1-1.44-.688L1.851,3.833A2,2,0,1,1,4.872,1.211L9.006,5.975,16.39-1.414a2,2,0,0,1,2.828,0,2,2,0,0,1,0,2.828l-8.9,8.907A2,2,0,0,1,8.9,10.907Z" transform="translate(-13843.888 -17875.883) rotate(-18)" fill="#081e34"/></g></svg>
Convert image directly from library</span></h2>
                <p class="description">You can convert and compress image directly from the media library, using same global compression parameters.</p>
                <p class="description">Multi select conversion available.</p>
            </div>
        </div>



            <!-- <div class="col lazyload">
                <h2>Enable LazyLoad Image Settings (load speed)</h2>
                <p class="description">Click the buttons below to add or remove LazyLoad on all images of your website to increase or revert loading speed improvements.</p>

                    <table class="form-table">
                        <tr valign="top">
                            <td><div class="<?php echo get_option('webp_lazyload_enabled') ? 'active' : ''; ?>">
                            <input type="checkbox" name="webp_lazyload_enabled" value="1" <?php checked(1, get_option('webp_lazyload_enabled'), true); ?> />  
                            <label for="webp_lazyload_enabled">Check for enable LazyLoad</label>
                            </div></td>
                        </tr>
                    </table>
            </div> -->
           
            </div>
        <div class="col-right">
                <div class="col">
                        <h2>Save settings</h2>
                        <p class="description">Please save before leaving settings</p>
                        <?php submit_button(); ?>
                        </form>
                    </div>
            </div>
            </div>
        </div>
        <?php
  }

            // Handle menu parameters
            require_once plugin_dir_path(__FILE__) . 'includes/register-parameters.php';
            // Handle bulk conversion multi select
            require_once plugin_dir_path(__FILE__) . 'includes/bulk-converter-multi-select.php';
            // Handle library button image conversion
            require_once plugin_dir_path(__FILE__) . 'includes/inside-library-converter.php';
            //Check if import is enable, if not do nothing
            if(get_option('webp_import_converter_enable')) {
                require_once plugin_dir_path(__FILE__) . 'includes/converter-on-import.php'; // ERREUR SITE LAEDENNILAULER TROUVER POURQUOI ?
            }
}
else{
  // Display settings page HTML
  function webp_converter_settings_page_html() {
    ?>
      <div class="wrap custom-plugin-ac"> 
          <div class="header">
              <h1><svg xmlns="http://www.w3.org/2000/svg" width="108.319" height="96.572" viewBox="0 0 108.319 96.572"><g transform="translate(-1777.501 -412.318)"><path d="M26.713,7.893A18.82,18.82,0,1,0,40.02,13.4,18.7,18.7,0,0,0,26.713,7.893m0-7.893A26.713,26.713,0,1,1,0,26.713,26.713,26.713,0,0,1,26.713,0Z" transform="translate(1819.596 426.549)" fill="#6321e1"/><path d="M11.935,7.893a4.043,4.043,0,1,0,4.043,4.043,4.047,4.047,0,0,0-4.043-4.043m0-7.893A11.935,11.935,0,1,1,0,11.935,11.935,11.935,0,0,1,11.935,0Z" transform="translate(1834.373 441.326)" fill="#6321e1"/><path d="M-12402.169-19701.7a5.525,5.525,0,0,1,5.384,4.3c.14.619,13.565,62.328-35.4,84.609-11.182,5.086-21.494,7.666-30.654,7.666-27.188,0-39.916-22.088-40.468-43.986-.676-26.891,24.188-41.145,25.247-41.74a5.5,5.5,0,0,1,1.944-.654l73.182-10.139A5.327,5.327,0,0,1-12402.169-19701.7Zm-60.668,85.523c7.569,0,16.343-2.244,26.078-6.676,33.792-15.377,31.945-53.383,30.058-67.117l-66.75,9.246c-3.758,2.424-19.255,13.527-18.808,31.332C-12491.872-19634.062-12483.936-19616.172-12462.837-19616.172Z" transform="translate(14280.819 20114.014)" fill="#6321e1"/></g></svg>
              Please activate licence</h1></br>
              <p class="message-result-api">No licence</p>
              <p class="description">Activate your licence (given after you bought the plugin)</p></br>
              <a href="<?php echo site_url(); ?>/wp-admin/options-general.php?page=webb-e-license" class="custom-primary-button">Activate licence</a>
          </div>
      </div>
    <?php
  }
}





ob_end_flush();