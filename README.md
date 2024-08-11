
# ZBClub Social Media Wall Module

## Module Overview

### Introduction
The ZBClub Social Media Wall module is designed to aggregate and display social media posts from Facebook platforms on your Drupal website. It allows site administrators to create a dynamic, interactive social media wall that pulls in content from social media page and displays them in a visually appealing manner.

### Features
- Aggregate posts from facebook social media platforms.
- Display social media posts in a grid or list format.
- Customize the appearance of the social media wall using CSS.
- Configure which social media post to include on the basis of filter by hashtag.

### Dependencies
- Drupal 9 or higher.
- PHP 8.0 or higher.

## Installation

### Requirements
Before installing the ZBClub Social Media Wall module, ensure that your Drupal installation meets the following requirements:
- A functioning Drupal site.
- Access to the site's codebase and the ability to install modules.

### Installation Steps
1. Download the ZBClub Social Media Wall module and extract it into your Drupal site's `modules/custom/` directory.
2. Navigate to the Extend page (`/admin/modules`) on your Drupal site.
3. Enable the ZBClub Social Media Wall module by selecting the checkbox and clicking "Install".
4. Clear the site cache to ensure the module is fully integrated.

### Configuration
1. Go to the configuration page for the ZBClub Social Media Wall module (`/admin/config/zbclub_facebook_api`).
2. Enter the necessary API keys for the Facebook platforms.
3. Customize the display settings and the #hashtags for filter.
4. Save the configuration.

## Usage

### How to Use the Module
After the ZBClub Social Media Wall module is installed and configured, you need to add the zbclub_social_media_wall_block to the desired page where you want the social media wall to be displayed. This can be done by navigating to the block layout page in your Drupal site, placing the block in the appropriate region, and saving the changes. Once the block is placed, it will automatically start displaying posts from the configured social media platforms.

### Admin Settings
- **API Settings:** Configure API keys for each social media platform.
- **Display Settings:** Control how posts are displayed, filtering by hashtags.

### Permissions
The module includes permissions to control who can configure the social media wall and who can access its features:
  - **administer site configuration:** Allows users to configure the ZB Club Facebook API settings.
  - **access content:** Allows users to access the ZB Club Facebook API Cron endpoint, which is used for managing scheduled tasks related to the social media wall.

This update aligns with the permissions specified in the zbclub_social_media_wall.settings and zbclub_social_media_wall.zbcron routes.

## Code Explanation

### zbclub_social_media_wall.info.yml
  - **Name:** Defines the module's name as "ZB Club social media wall."
  - **Type:** Specifies the type as "module."
  - **Description:** Briefly describes the module as providing integration with the Facebook Graph API and creating a block for the social media wall.
  - **Core Version Requirement:** Indicates compatibility with Drupal 9.
  - **Libraries:** Lists the required libraries, including zbclub_social_media_wall/listing for additional assets.

#### Summary
This file is essential for registering the module in Drupal and ensuring it is recognized and properly categorized in the admin interface.

### zbclub_social_media_wall.module

`zbclub_social_media_wall_theme()`
- **Purpose:** Defines a custom theme hook for the module, specifying the variables that can be used within the theme templates.
- **Explanation:** This function allows the module to use custom templates for rendering the social media wall block.

`zbclub_social_media_wall_preprocess_page()`
- **Purpose:** Preprocesses the page variables for pages with a specific URL pattern (`/zbclub`), attaching necessary libraries and settings.
- **Explanation:** This function ensures that the required CSS and JavaScript files are loaded on pages where the social media wall is displayed.

#### Summary
This file is responsible for defining custom theming and attaching necessary assets to ensure the ZB Club Social Media Wall is rendered correctly on specified pages. It enhances the module's flexibility and ensures that the correct resources are loaded where needed.

### zbclub_social_media_wall.routing.yml

`zbclub_social_media_wall.settings`
- **Path:** `/admin/config/zbclub_facebook_api`
- **Purpose:** Points to the settings form for configuring the ZB Club Facebook API integration.
- **Permissions:** Requires `administer site configuration` permission.

`zbclub_social_media_wall.zbcron`
- **Path:** `/zbclub-social-media-wall/zbcron`
- **Purpose:** Points to the controller method responsible for executing the cron tasks related to the ZB Club Social Media Wall.
- **Permissions:** Requires `access content` permission.

#### Summary
This file is responsible for defining routes that allow users to access the ZB Club Facebook API settings and execute cron tasks. It ensures that only authorized users can modify the configuration or run scheduled tasks.

### zbclub_social_media_wall.links.menu.yml

`zbclub_social_media_wall.settings`
- **Route Name:** `zbclub_social_media_wall.settings`
- **Parent:** `sph.admin_config`
- **Title:** `ZB Club social media wall configuration`
- **Description:** `Configure ZB Club Social wall Facebook API and other variables related to it.`

#### Summary
This file adds a menu link to the Drupal admin interface under the "sph.admin_config" section. The link leads to the ZB Club Social Media Wall configuration page, where users can set up the Facebook API and related settings.

### zbclub_social_media_wall.libraries.yml

`listing`
- **Version:** `1.x`
- **JS:** Includes the `js/listing.js` file.
- **CSS:** Includes the `css/listing.css` file under the theme category.
- **Dependencies:** Specifies `core/jquery` as a dependency, ensuring jQuery is loaded when this library is used.

#### Summary
This file defines the `listing` library, which includes JavaScript and CSS assets required for the ZB Club Social Media Wall module. It ensures these assets are properly managed and loaded with the necessary dependencies.

### drush.services.yml

`zbclub_social_media_wall.command`
- **Class:** `Drupal\zbclub_social_media_wall\Commands\ZbclubFacebookApiCommands`
- **Arguments:** Injects services like `@config.factory`, `@http_client`, `@file_system`, and `@logger.factory` into the command class.
- **Tags:** Registers the service as a Drush command using the `drush.command` tag.

#### Summary
This file registers a custom Drush command for the ZB Club Social Media Wall module, enabling it to perform tasks like interacting with the Facebook API via the command line. The service class is injected with necessary dependencies such as configuration, HTTP client, file system, and logging services.

## Theming

### CSS/JS Inclusions
- The module includes a CSS file (`listing.css`) for styling the social media wall.
- JavaScript is used to handle dynamic loading of posts.

### Templates
- The module provides templates for customizing the display of individual posts. These can be overridden in your theme by copying the template files to your theme's directory.

## Troubleshooting

### Common Issues
- **Issue:** The social media wall is not displaying any posts.
  - **Solution:** Ensure that the API keys are correctly configured and that the site can connect to the social media platforms.

- **Issue:** The layout is broken or does not appear as expected.
  - **Solution:** Check the CSS file for conflicts with your theme's styles.

### Debugging Tips
- Enable Drupal's error reporting to see if there are any PHP errors or warnings related to the module.
- Use the Devel module to inspect the data being fetched and displayed by the social media wall.

## FAQ

### Frequently Asked Questions
- **Q:** Can I display posts from multiple accounts?
  - **A:** No, the module allows you to aggregate posts from Facebook page of your account.

- **Q:** Can I customize the appearance of the social media wall?
  - **A:** Yes, you can customize the CSS and override the provided templates in your theme.

## Changelog

### Version History
- **1.0.0:** Initial release with basic social media aggregation and display features.
