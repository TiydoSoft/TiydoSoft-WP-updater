<?php
    /*
    Plugin Name: TiydoSoft-WP-updater
    Plugin URI: https://tiydosoft.tech/plugins/WP-updater
    Description: A simple PHP library for WordPress Theme and Plugin Auto Update.
    Version: 1.0.0
    Author: TiydoSoft
    Author URI: https://tiydosoft.tech/
    */

// Set your GitHub information
$ts_github_username = 'your-github-username';
$ts_github_repository = 'your-github-repository-name';
$ts_github_access_token = 'your-github-access-token';
    
require plugin_dir_path( __FILE__ ) . '/updater/ts-plugin-updater.php'; //use it for plugin updater! :)
require get_template_directory() . '/updater/ts-theme-updater.php'; //use it for theme updater! :)

