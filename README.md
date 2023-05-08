TiydoSoft-WP-updater
====================
[GitHub release](https://github.com/TiydoSoft/TiydoSoft-WP-updater/releases/latest) 
  
**TiydoSoft-WP-updater is a simple PHP library for WordPress Theme and Plugin Auto Update using GitHub API. So your plugin or theme should be GitHub hosted.**  


## Support

For support, visit [TiydoSoft Support](https://tiydosoft.tech/support) center.


## Authors

- [@TiydoSoft](https://www.github.com/TiydoSoft)




Installation
------------

### Use as WordPress Plugin

You can use this library as a WordPress plugin to auto-update your plugin or theme.

*   Download the latest release of the plugin from [GitHub](https://github.com/TiydoSoft/TiydoSoft-WP-updater/releases/latest).
*   Upload the `tiydosoft-wp-updater` folder to the `/wp-content/plugins/` directory.
*   Activate the plugin through the 'Plugins' menu in WordPress.
*   Add and modify the following code based on your requirements.
    *   For WordPress plugin, include the following code in your plugin main file:
        ```php
        $ts_github_username = 'your-github-username';  
        $ts_github_repository = 'your-github-repository-name';  
        // $ts_github_access_token = 'your-github-access-token'; // Uncomment this if you're not using a public repositories

        require ABSPATH . '/wp-contents/plugins/tiydosoft-wp-updater/updater/ts-plugin-updater.php';
        ```

    *   For WordPress theme, include the following code in your `functions.php` file:
        ```php
        $ts_github_username = 'your-github-username';  
        $ts_github_repository = 'your-github-repository-name';  
        // $ts_github_access_token = 'your-github-access-token'; // Uncomment this if you're not using a public repositories  
          
        require ABSPATH . '/wp-contents/plugins/tiydosoft-wp-updater/updater/ts-theme-updater.php';
        ```

### Using as a standalone PHP library

You can use this library in your WordPress plugin or theme to auto-update your plugin or theme.

*   Download the latest release of the plugin from [GitHub](https://github.com/TiydoSoft/TiydoSoft-WP-updater/releases/latest).
*   Unzip it on your plugin's or theme's directory.
*   Add and modify the following code based on your requirements.
    *   For WordPress plugin, include the following code in your plugin main file:
        ```php
        $ts_github_username = 'your-github-username';  
        $ts_github_repository = 'your-github-repository-name';  
        // $ts_github_access_token = 'your-github-access-token'; // Uncomment this line if you're not using a public repositories  
          
        require plugin_dir_path( __FILE__ ) . '/tiydosoft-wp-updater/updater/ts-plugin-updater.php';
        ```

    *   For WordPress theme, include the following code in your `functions.php` file:
        ```php
        $ts_github_username = 'your-github-username';  
        $ts_github_repository = 'your-github-repository-name';  
        // $ts_github_access_token = 'your-github-access-token'; // Uncomment this line if you're not using a public repositories  
          
        require get_template_directory() . '/tiydosoft-wp-updater/updater/ts-theme-updater.php';
        ```



Usage
-----

Once you have installed the TiydoSoft-WP-updater library, it will automatically check for updates for your plugin or theme every 12 hours by default. You can change the frequency of the update checks by changing the cron schedule in the `ts_schedule_update_check()` function.  
For plugin you can foind the `ts_schedule_update_check()` function in the `updater/ts-plugin-updater.php` file. And for the theme you can foind the `ts_schedule_update_check()` function in the `updater/ts-theme-updater.php` file.  

```php
// Schedule the update check to run every 12 hours  
add_action( 'wp', 'ts_schedule_update_check' );  
function ts_schedule_update_check() {  
    if ( ! wp_next_scheduled( 'ts_check_for_updates' ) ) {  
            wp_schedule_event( time(), 'twicedaily', 'ts_check_for_updates' );  
        }  
    }
```

You also need to define your GitHub repository information. Set the following variables to match your GitHub repository information:

```php
$ts_github_username = 'your-github-username';  
$ts_github_repository = 'your-github-repository-name';  
// $ts_github_access_token = 'your-github-access-token'; // Uncomment this line if you're not using a public repositories
```

Remenber, If you are using a private repository, you need to provide a GitHub access token.

### To generate a new access token, follow these steps:

*   Go to your GitHub Settings page.
*   Click on "Generate new token".
*   Enter a name for the token.
*   Select the "repo" scope.
*   Click on "Generate token".
*   Copy the token and paste it into the $ts_github_access_token variable.

### Creating a Release in GitHub

To use this library, you need to create new release every time you want to update your Plugin or Theme in your GitHub repository.

*   In your GitHub repository, click the "Releases" tab.
*   Click the "Create a new release" button.
*   Set the "Tag version" to the version of your release.
*   Set the "Release title" to a descriptive title for your release.
*   Add any release notes you want to include.
*   Upload the zip file of your plugin or theme.
*   Click the "Publish release" button.



FAQs
----

**How to create a zip file of my plugin or theme?**

To create a zip file of your plugin or theme, follow these steps:

*   Go to the root directory of your plugin or theme.
*   Select all the files and folders inside.
*   Right-click and select "Compress".
*   Choose "Zip" format.
*   Name the zip file with your plugin or theme name.

Troubleshooting
---------------

**\*\*\* Please let us know if there is any error! \*\*\***

**The plugin is not checking for updates.**  
Make sure you have set the `$ts_github_username`, `$ts_github_repository`, and `$ts_github_access_token` variables correctly in the `TiydoSoft-WP-updater/updater/ts-plugin-updater.php` or `TiydoSoft-WP-updater/updater/ts-theme-updater.php` file.

**The plugin is not updating.**  
Make sure you have created a release in your GitHub repository and uploaded the zip file of your plugin or theme. Also, make sure the version of the release matches the version number in your plugin or theme header.

**The plugin is not working.**  
If you encounter any other issues, please open an issue on the GitHub repository for this library.


