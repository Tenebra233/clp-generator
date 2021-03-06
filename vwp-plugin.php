<?php
/**
 * @wordpress-plugin
 * Plugin Name:       CLP-Generator
 * Plugin URI:        https://www.clpgenerator.com
 * Description:       Generates custom landing pages power by vue.js
 * Version:           1.0.0
 * Author:            Roberto Urbani
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       clpg
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class VwpPlugin
{
    public $plugin;

    function __construct()
    {
        $this->plugin = plugin_basename(__FILE__);
    }

    function register()
    {
        add_action('admin_menu', array($this, 'add_admin_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
        add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
    }

    public function settings_link($links)
    {
        $settings_link = '<a href="admin.php?page=vwp_plugin">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

    function enqueue_assets()
    {
        wp_enqueue_style("$this->plugin-css", plugins_url('/public/styles.css', __FILE__));
        wp_enqueue_script("$this->plugin-js", plugins_url('/public/scripts.js', __FILE__), null, null, true);
        wp_enqueue_style('material-icons', 'https://cdn.materialdesignicons.com/5.3.45/css/materialdesignicons.min.css');
        wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css');
    }

    public function add_admin_page()
    {
        add_menu_page("Vue WordPress", 'Vue WordPress', 'manage_options', 'vwp_plugin', array($this, 'admin_index'), '');
    }

    public function admin_index()
    {
        require_once plugin_dir_path(__FILE__) . 'templates/admin/index.php';
    }


}

if (class_exists('VwpPlugin')) {
    $vwpPlugin = new VwpPlugin();
    $vwpPlugin->register();
}

// Activation
require_once plugin_dir_path(__FILE__) . 'inc/vwp-plugin-activate.php';
register_activation_hook(__FILE__, array('VwpPluginActivate', 'activate'));

// Deactivation
require_once plugin_dir_path(__FILE__) . 'inc/vwp-plugin-deactivate.php';
register_deactivation_hook(__FILE__, array('VwpPluginDeactivate', 'deactivate'));
