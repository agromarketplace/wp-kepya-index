<?php
/**
 * @version 1.0
 *
 */

defined('ABSPATH') || exit;


class Laminin_BaseController
{
    public $plugin_path;

    public $plugin_url;

    public $plugin_base;

    public $managers = array();

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin_base = plugin_basename(dirname(__FILE__, 3)) . '/laminin.php';
        add_action('init', array( $this, 'lum_load_textdomain'));
        

        $this->managers = array(
            'tableindex_manager' => __('Kepya Index ', 'laminin'),
        );
    }
    

    public function lum_activated(string $key)
    {
        $option = get_option('lum_option');

        return isset($option[$key]) ? $option[$key] : false;
    }

    
// Load plugin textdomain.

    public function lum_load_textdomain()
    {
        unload_textdomain('laminin');
        load_plugin_textdomain('laminin', false, plugin_basename(dirname(__FILE__, 3)) . '/languages');
    }

}