<?php

namespace PaintCloud\WP\Settings;

$fields_prefix = "tap_cookies_";

$page = new Page('TAP Cookies', array('type' => 'settings', 'page_title' => 'TAP Cookies', 'slug' => \TAP_Cookies::get_instance()->get_plugin_slug()));

$settings = array();

// Tabs
// ------------------------//
$settings['About'] = array();
$settings['Information Box'] = array();
$settings['Cookies'] = array();

// Tab Information
// ------------------------//
$settings['About']['Description'] = array(
    'info' => 'Display a information message at page\'s bottom (default) about Europe Cookies Law.</p><h3>Settings Tabs</h3><ul style="padding-left: 15px; list-style: disc;"><li>About: This tab (actual tab) is to show information about the plugin.</li><li>Information Box: This tab is where you configure the information box. You can define box title, text and position.</li><li>Cookies: This tab is to add/remove cookies specifications. If some unknow cookies is found, then it are listed to add.</li></ul><p>Additional, you can use the [tap-cookies] or [tap_cookies] shortcodes on page and widgets to display the cookie list registered.</p><h3>More information</h3><ul style="padding-left: 15px; list-style: disc;"><li><a href="http://www.theeucookielaw.com/">Europe Cookie Law</a></li><li><a href="http://www.cookielaw.org/the-cookie-law/">The Cookie Law Explained</a></li></ul><p>'
);
$fields = array();
$settings['About']['Description']['fields'] = $fields;

// Tab Message
// ------------------------//
$settings['Information Box'][''] = array('info' => '');
$fields = array();
$fields[] = array(
    'type' 	=> 'text',
    'name' 	=> $fields_prefix . 'information_box_title',
    'label' => 'Title',
    'value' => \TAP_Cookies::get_instance()->get_information_box_title() // (optional, will default to '')
);
$fields[] = array(
    'type' 	=> 'textarea',
    'name' 	=> $fields_prefix . 'information_box_text',
    'label' => 'Text',
    'value' => \TAP_Cookies::get_instance()->get_information_box_text() // (optional, will default to '')
);
$fields[] = array(
    'type' 	=> 'select',
    'name' 	=> $fields_prefix . 'information_box_position',
    'label' => 'Position',
    'value' => \TAP_Cookies::get_instance()->get_information_box_position(), // (optional, will default to '')
    'select_options' => array(
        array('value'=>'top-left', 'label' => 'Top Left '),
        array('value'=>'top-center', 'label' => 'Top Center'),
        array('value'=>'top-right', 'label' => 'Top Right'),
        array('value'=>'top-full-width', 'label' => 'Top Full Width'),
        array('value'=>'bottom-left', 'label' => 'Bottom Left'),
        array('value'=>'bottom-center', 'label' => 'Bottom Center'),
        array('value'=>'bottom-right', 'label' => 'Bottom Right'),
        array('value'=>'bottom-full-width', 'label' => 'Bottom Full Width')
    )
);
$settings['Information Box']['']['fields'] = $fields;

// Tab Cookies
// ------------------------//
$settings['Cookies'][''] = array(
    'info' => \TAP_Cookies_Admin::get_instance()->unknown_cookies_detected()
);
$fields = array();

$cookies_multi_fields = array();

$cookies_multi_fields[] = array(
    'type' 	=> 'text',
    'name' 	=> 'name',
    'label' => 'Name'
);
$cookies_multi_fields[] = array(
    'type' 	=> 'text',
    'name' 	=> 'group',
    'label' => 'Usage'
);
$cookies_multi_fields[] = array(
    'type' 	=> 'textarea',
    'name' 	=> 'description',
    'label' => 'Description'
);

$fields[] = array(
    'type' 	=> 'multi',
    'name' 	=> $fields_prefix . 'list',
    'label' => 'Cookies',
    'fields' => $cookies_multi_fields
);

$settings['Cookies']['']['fields'] = $fields;

new OptionPageBuilderTabbed($page, $settings);