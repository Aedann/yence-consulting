<?php
// This is the secret key for API authentication. You configured it in the settings menu of the license manager plugin.

// Enqueue style.css
add_action('admin_enqueue_scripts', 'enqueue_style_css');
function enqueue_style_css() {
    wp_enqueue_style('style', plugin_dir_url(__DIR__) . 'css/style.css');
}


define('YOUR_LICENSE_SERVER_URL', 'https://aubincortacero.fr'); // URL of your license server
define('SECRET_KEY', '66ea998d71d7b8.71673048'); // Secret key for communication between your server and the license server
define('SECRET_VERIFICATION_KEY', '66ea998d71d825.67478680'); // Secret key for communication between your server and the license server 

// This is a value that will be recorded in the license manager data so you can identify licenses for this item/product.
define('YOUR_ITEM_REFERENCE', 'webb-e plugin'); //Rename this constant name so it is specific to your plugin or theme.

add_action('admin_menu', 'webbe_license_menu');
function webbe_license_menu() {
    add_options_page(
    'WEBb-E License Activation Menu', 
    'WEBb-E License', 
    'manage_options', 
    'webb-e-license', 
    'webbe_license_management_page');
}

function webbe_license_management_page() {
    echo '<div class="wrap custom-plugin-ac">';
    echo '<h1><svg xmlns="http://www.w3.org/2000/svg" width="108.319" height="96.572" viewBox="0 0 108.319 96.572"><g transform="translate(-1777.501 -412.318)"><path d="M26.713,7.893A18.82,18.82,0,1,0,40.02,13.4,18.7,18.7,0,0,0,26.713,7.893m0-7.893A26.713,26.713,0,1,1,0,26.713,26.713,26.713,0,0,1,26.713,0Z" transform="translate(1819.596 426.549)" fill="#6321e1"/><path d="M11.935,7.893a4.043,4.043,0,1,0,4.043,4.043,4.047,4.047,0,0,0-4.043-4.043m0-7.893A11.935,11.935,0,1,1,0,11.935,11.935,11.935,0,0,1,11.935,0Z" transform="translate(1834.373 441.326)" fill="#6321e1"/><path d="M-12402.169-19701.7a5.525,5.525,0,0,1,5.384,4.3c.14.619,13.565,62.328-35.4,84.609-11.182,5.086-21.494,7.666-30.654,7.666-27.188,0-39.916-22.088-40.468-43.986-.676-26.891,24.188-41.145,25.247-41.74a5.5,5.5,0,0,1,1.944-.654l73.182-10.139A5.327,5.327,0,0,1-12402.169-19701.7Zm-60.668,85.523c7.569,0,16.343-2.244,26.078-6.676,33.792-15.377,31.945-53.383,30.058-67.117l-66.75,9.246c-3.758,2.424-19.255,13.527-18.808,31.332C-12491.872-19634.062-12483.936-19616.172-12462.837-19616.172Z" transform="translate(14280.819 20114.014)" fill="#6321e1"/></g></svg>
            WEBb-E License activation</h1>';
            if (!get_option('LICENCE_KEY')) {
            echo '<p class="message-result-api">License Activated</p>';
            }else{
                echo '<p class="message-result-api">No License</p>';  
            }
    /*** License ACTIVATE button was clicked ***/
    if (isset($_REQUEST['activate_license'])) {
        $license_key = sanitize_text_field( $_REQUEST['LICENCE_KEY'] );

        // API query parameters
        $api_params = array(
            'slm_action' => 'slm_activate',
            'secret_key' => SECRET_VERIFICATION_KEY,
            'license_key' => $license_key,
            'registered_domain' => $_SERVER['SERVER_NAME'],
            'item_reference' => YOUR_ITEM_REFERENCE,
        );

        // Send query to the license manager server
        $query = esc_url_raw(add_query_arg($api_params, YOUR_LICENSE_SERVER_URL));
        $response = wp_remote_get($query, array('timeout' => 20, 'sslverify' => false));

        // Check for error in the response
        if (is_wp_error($response)){
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response

        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));

        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data

        if($license_data->result == 'success'){//Success was returned for the license activation

            //Uncomment the followng line to see the message that returned from the license server
            echo '<p class="message-result-api">'.$license_data->message.'</p>';

            //Save the license key in the options table
            update_option('LICENCE_KEY', $license_key);
            // Wait for 1 second
            sleep(1);
            // Redirect to the license management page
            wp_redirect(admin_url('options-general.php?page=webb-e'));
            exit;
        }
        else{
            //Show error to the user. Probably entered incorrect license key.

            //Uncomment the followng line to see the message that returned from the license server
            echo '<p class="message-result-api">'.$license_data->message.'</p>';
        }

    }
    /*** End of license activation ***/





    /*** License DEACTIVATE button was clicked ***/
    if (isset($_REQUEST['deactivate_license'])) {
        $license_key = sanitize_text_field( $_REQUEST['LICENCE_KEY'] );

        // API query parameters
        $api_params = array(
            'slm_action' => 'slm_deactivate',
            'secret_key' => SECRET_VERIFICATION_KEY,
            'license_key' => $license_key,
            'registered_domain' => $_SERVER['SERVER_NAME'],
            'item_reference' => YOUR_ITEM_REFERENCE,
        );

        // Send query to the license manager server
        $query = esc_url_raw(add_query_arg($api_params, YOUR_LICENSE_SERVER_URL));
        $response = wp_remote_get($query, array('timeout' => 20, 'sslverify' => false));

        // Check for error in the response
        if (is_wp_error($response)){
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response

        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));

        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data

        if($license_data->result == 'success'){//Success was returned for the license activation

            //Uncomment the followng line to see the message that returned from the license server
            echo '<p class="message-result-api">'.$license_data->message.'</p>';
            //Remove the licensse key from the options table. It will need to be activated again.
            update_option('LICENCE_KEY', '');
                        // Wait for 1 second
                        sleep(1);
                        // Redirect to the license management page
                        wp_redirect(admin_url('options-general.php?page=webb-e-license'));
        }
        else{
            //Show error to the user. Probably entered incorrect license key.

            //Uncomment the followng line to see the message that returned from the license server
            echo '<p class="message-result-api">'.$license_data->message.'</p>';
        }

    }
    /*** End of sample license deactivation ***/

    ?>
    <p>Please enter the license key for this product to activate it. </br>You were given a license key when you purchased this item. </br> If you didn't bought our plugin, go to <a target="_blank" href="https://aubincortacero.fr/produit/webb-e-plugin/">WEBb-E Plugin page</a></p>
    <form action="" method="post">
        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="LICENCE_KEY">License Key</label></th>
                <td ><input class="regular-text" type="text" id="LICENCE_KEY" name="LICENCE_KEY"  value="<?php echo get_option('LICENCE_KEY'); ?>" ></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="activate_license" value="Activate" class="custom-primary-button" />
            <input type="submit" name="deactivate_license" value="Deactivate" class="custom-secondary-button" />
        </p>
    </form>
    <?php

    echo '</div>';
}