<?php
$ts_theme_name = wp_get_theme()->get('Name');
$ts_theme_version = wp_get_theme()->get('Version');

// Define the GitHub API function 
function ts_set_github_api() {
    global $ts_github_username, $ts_github_repository, $ts_github_access_token, $ts_theme_name;

    // Define the GitHub API URL
    $ts_github_api_url = "https://api.github.com/repos/$ts_github_username/$ts_github_repository/releases/latest";

    // Set the API request headers
    // $ts_api_request_headers = array(
    //     'Accept' => 'application/vnd.github.v3+json',
    //     'User-Agent' => $ts_theme_name,
    //     'Authorization' => "token $ts_github_access_token"
    // );
    $ts_api_request_headers = array(
        'Accept' => 'application/vnd.github.v3+json',
        'User-Agent' => $ts_theme_name
    );
    
    if (!empty($ts_github_access_token)) {
        $ts_api_request_headers['Authorization'] = "token $ts_github_access_token";
    }    

    // Send the API request to GitHub
    $ts_api_response = wp_remote_get( $ts_github_api_url, array( 'headers' => $ts_api_request_headers ) );

    // Check if the API request was successful
    if ( is_wp_error( $ts_api_response ) ) {
        // Handle error
        return false;
    }
    
    return $ts_api_response;
}

// Define the update checking function
function ts_check_for_updates() {
    global $ts_theme_version, $ts_update;
    
    // Get the latest release version from GitHub
    $ts_api_response = ts_set_github_api();
    if ( $ts_api_response ) {
        $ts_api_response_data = json_decode( wp_remote_retrieve_body( $ts_api_response ) );
        $ts_latest_version = $ts_api_response_data->tag_name;
    }

    // Compare the versions and set the update flag if necessary
    if ( isset( $ts_latest_version ) && version_compare( $ts_latest_version, $ts_theme_version, '>' ) ) {
        $ts_update = true;
        set_transient( 'ts_latest_version', $ts_latest_version, 12 * HOUR_IN_SECONDS );
    } else {
        $ts_update = false;
    }
}

/**
 * for debug :)
 */
add_action( 'wp', 'ts_schedule_update_check' );
function ts_schedule_update_check() {
    if ( ! wp_next_scheduled( 'ts_check_for_updates' ) ) {
        wp_schedule_event( time(), 'every_30_minutes', 'ts_check_for_updates' );
    }
}
/**
 * for debug End :)
 */

// // Schedule the update check to run every 12 hours
// add_action( 'wp', 'ts_schedule_update_check' );
// function ts_schedule_update_check() {
//     if ( ! wp_next_scheduled( 'ts_check_for_updates' ) ) {
//         wp_schedule_event( time(), 'twicedaily', 'ts_check_for_updates' );
//     }
// }

add_action( 'ts_check_for_updates', 'ts_check_for_updates' );

function ts_updater_run() {
    global $ts_theme_folder, $ts_update;

    // Check for updates
    ts_check_for_updates();

    // If an update is available, update the theme
    if ( $ts_update ) {
        // Get the theme update file URL from GitHub
        $ts_api_response = ts_set_github_api();
        if ( $ts_api_response ) {
            $ts_api_response_data = json_decode( wp_remote_retrieve_body( $ts_api_response ) );
            $ts_update_file_url = $ts_api_response_data->zipball_url;
        }

        // Update the theme
        $theme_folder = get_theme_root() . '/' . $ts_theme_folder;
        $update = ts_update_theme( $theme_folder, $ts_update_file_url );

        // Display a success or error message
        if ( is_wp_error( $update ) ) {
            // Handle error
        } else {
            // Display success message
        }
    }
}

// Helper function to update the theme
function ts_update_theme( $theme_folder, $update_file_url ) {
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

    $skin = new \WP_Ajax_Upgrader_Skin();
    $upgrader = new \Theme_Upgrader( $skin );

    $result = $upgrader->run( array(
        'package' => $update_file_url,
        'destination' => $theme_folder,
        'clear_destination' => false,
        'clear_working' => true,
        'hook_extra' => array(),
    ) );

    return $result;
}
?>