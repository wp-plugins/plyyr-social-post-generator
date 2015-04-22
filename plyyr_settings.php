<?php

if (!class_exists('Plyyr_Settings')) {

  class Plyyr_Settings
  {

    /**
     * Construct the plugin object
     */
    public function __construct()
    {
      // register actions

      add_action('admin_init', array(&$this, 'admin_init'));
      add_action('admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
      add_action('admin_menu', array(&$this, 'add_menu'));


    }

 /**
     * hook into WP's admin_scripts action hook
     */
    public function admin_scripts()
    {
      // register your plugin's css
       wp_register_style( 'plyyr-admin',     plugins_url( 'css/admin.css',     __FILE__ ), false, '0.1.0' );
       wp_enqueue_style(  'plyyr-admin' );
       wp_enqueue_script( 'plyyr-admin' );
    }

    /**
     * hook into WP's admin_init action hook
     */
    public function admin_init()
    {
      // register your plugin's settings
      register_setting('plyyr-group', 'plyyr_setting_portal');
      
      // add description section
      add_settings_section(
              'plyyr-section', '', array(&$this, 'settings_section_plyyr'), 'plyyr'
      );
    }
    
    public function settings_section_plyyr()
    {
      // add your setting's fields
      add_settings_field(
              'plyyr_setting_portal', 'Portal Code', array(&$this, 'settings_portal_code'), 'plyyr', 'plyyr-section', array(
          'field' => 'plyyr_setting_portal'
              )
      );
    }

    /**
     * This function provides text inputs for settings fields
     */
    public function settings_portal_code($args)
    {
      $help = '';
      // Get the field name from the $args array
      $field = $args['field'];
      
      // Get the value of this setting
      $value = get_option($field);

      // echo a proper input type="text"
      echo sprintf('<input type="text" name="%s" id="%s" value="%s" placeholder="" />'
              . '<p>%s</p>', $field, $field, $value, $help);
    }

    /**
     * add a menu
     */
    public function add_menu()
    {
      // Add a page to manage this plugin's settings
      add_options_page(
              'Plyyr Settings', 'Plyyr', 'manage_options', 'plyyr', array(&$this, 'plugin_settings_page')
      );
    }

    /**
     * Menu Callback
     */
    public function plugin_settings_page()
    {
      if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
      }
      
      // Load settings
      $options = get_option($this->get_option_name());

      // Set default tab
      $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'start';

      // Check if feedback mail was sent
      $feedback = isset($_GET['mail']) ? $_GET['mail'] : 'false';

      // Render the settings template
      include(sprintf("%s/templates/settings_full.php", dirname(__FILE__)));
    }
    
    public function get_option_name() {
		return 'plyyr';
	}
  }
  

}
