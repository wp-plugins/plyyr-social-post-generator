<?php

/*
  Plugin Name: Plyyr Social Post Generator
  Description: Plugin for embedding customized social quizzes, polls and other content from Plyyr in your WordPress site. Captures requests that contain the plyyr shortcodes and generates a new post with the corresponding quiz and other content embedded on it. Customize your settings at http://plyyr.com . Use it to generate instant content for your site.
  Version: 0.1
  Author: Game Cloud, inc.
 */

/*  Copyright 2015 GameCloud, Inc <mail@gamecloudnetwork.com>

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if (!class_exists('Plyyr')) {

  class Plyyr
  {

    protected static $option_name = 'plyyr';
    protected static $data = array(
        // General
        'key' => 'default',
        // items
        'info' => '1',
        'shares' => '1',
        'comments' => '1',
        'recommend' => '1',
        'margin-top' => '0',
        'embeddedon' => 'content',
        // Recommendations
        'active' => 'false',
        'show' => 'footer',
        'view' => 'large_images',
        'items' => '3',
        'links' => 'https://www.plyyr.com',
        'section-page' => '',
        // Tags
        'tags-mix' => '1',
        'tags-fun' => '',
        'tags-pop' => '',
        'tags-geek' => '',
        'tags-sports' => '',
        'tags-news' => '',
        'more-tags' => '',
    );

    /**
     * Construct the plugin object
     */
    public function __construct()
    {
      // Initialize Settings
      require_once(sprintf("%s/plyyr_settings.php", dirname(__FILE__)));
      $Plyyr_Settings = new Plyyr_Settings();

      // Register custom post types
      require_once(sprintf("%s/post-types/plyyr_template.php", dirname(__FILE__)));
      $Plyyr_Template = new Plyyr_Template();

      // Register shortcodes
      require_once(sprintf("%s/shortcodes/plyyr_shortcodes.php", dirname(__FILE__)));
      $Plyyr_Shortcodes = new Plyyr_Shortcodes();

      $plugin = plugin_basename(__FILE__);
      add_filter("plugin_action_links_$plugin", array($this, 'plugin_settings_link'));
                  
      // Admin sub-menu    
      add_action('admin_menu', array($this, 'submenu_settings'));
    }

    /**
     * Add settings link on the plyyr's custom type
     */
    public function submenu_settings()
    {
      add_submenu_page('edit.php?post_type=plyyr', 'plyyr', 'Settings', 'activate_plugins', basename(__FILE__), 'plyyr_redirect_to_settings');
    }
    

    /**
     * Activate the plugin
     */
    public static function activate()
    {
      // Do nothing
    }

    /**
     * Deactivate the plugin
     */
    public static function deactivate()
    {
      flush_rewrite_rules();
    }

    /**
     * Add the settings link to the plugins page
     */
    function plugin_settings_link($links)
    {
      $settings_link = '<a href="options-general.php?page=plyyr">Settings</a>';
      array_unshift($links, $settings_link);
      return $links;
    }

  }

}

if (class_exists('Plyyr')) {
  // Installation and uninstallation hooks
  register_activation_hook(__FILE__, array('Plyyr', 'activate'));
  register_deactivation_hook(__FILE__, array('Plyyr', 'deactivate'));

  // instantiate the plugin class
  $wp_plugin_template = new Plyyr();
}

function plyyr_redirect_to_settings()
{
  require_once(sprintf("%s/plyyr_settings.php", dirname(__FILE__)));
  $Plyyr_Settings = new Plyyr_Settings();
  $Plyyr_Settings->plugin_settings_page();
}
