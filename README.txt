=== TAP Cookies ===
Contributors: mrbrazzi, todoapuestas
Donate link: http://todoapuestas.org/
Tags: cookies, europe cookie law
Requires at least: 3.5.1
Tested up to: 4.2.2
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a information message about Europe Cookies Law


== Description ==

Display a information message at page's bottom (default) about Europe Cookies Law.

= Settings Tabs =

* About: This tab is to show information about the plugin.
* Information Box: This tab is where you configure the information box. You can define box title, text and position.
* Cookies: This tab is to add/remove cookies specifications. If some unknow cookies is found, then it are listed to add.

Additional, you can use the [tap-cookies] or [tap_cookies] shortcodes on page and widgets to display the cookie list registered.

= More information =
* [Europe Cookie Law](http://www.theeucookielaw.com/)
* [The Cookie Law Explained](http://www.cookielaw.org/the-cookie-law/)


== Installation ==

This section describes how to install the plugin and get it working.

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'plugin-name'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `plugin-name.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `plugin-name.zip`
2. Extract the `plugin-name` directory to your computer
3. Upload the `plugin-name` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Frequently Asked Questions ==

Nothing for now


== Screenshots ==

Nothing for now


== Changelog ==

= 1.2.1 =
* Minor update, on TAP_Cookies class added restriction to show information box only if the current browser not runs on a mobile device

= 1.2 =
* On TAP_Cookies class apply the following refactored:
  1. updated get_unknown_cookies method
  2. updated get_cookies method
  3. changed method get_cookie_message_text to get_information_box_text
  4. changed method get_cookie_message_title to get_information_box_title
  5. added method get_information_box_position
  6. updated single_activate method
  7. updated single_deactivate method
  8. updated enqueue_scripts method
  9. updated enqueue_scripts_footer method
  10. deleted methods check_cookies, clear_cookies, init
  11. updated cookies_table method
* On class TAP_Cookies_Admin apply the following refactored:
  1. changed settings page from single page to tabs page [Using Wordpress Settings Library](https://github.com/dobbyloo/Wordpress-Settings-Library)
  2. deleted methods enqueue_admin_styles, enqueue_admin_scripts, add_plugin_admin_menu, display_plugin_admin_page, add_action_links, validate_settings, edit_options, settings_field_cookie_message, settings_field_cookies, register_settings
  3. updated method unknown_cookies_detected_dashboard_widget
  4. updated method dashboard_setu

= 1.0 =
* Initial release.


== Upgrade Notice ==

You must upgrade as soon as posible to version 1.2 or later. See Changelog section for details.


== Arbitrary section ==

Nothing for now


== Updates ==

The basic structure of this plugin was cloned from the [WordPress-Plugin-Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate) project.
This plugin supports the [GitHub Updater](https://github.com/afragen/github-updater) plugin, so if you install that, this plugin becomes automatically updateable direct from GitHub. Any submission to WP.org repo will make this redundant.
