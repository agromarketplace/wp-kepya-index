<?php
/**
 * @version 1.0*
 * @see Laminin_BaseController
 */

defined('ABSPATH') || exit;


class Laminin_Enqueue extends Laminin_BaseController
{
    public function lum_register()
    {
        add_action('admin_init', array($this, 'lum_enqueue_admin_js'));
        add_action('admin_enqueue_scripts', array($this, 'lum_enqueue'));
        add_action('wp_head', array($this, 'lum_enqueue_public'));

    }

    public function lum_enqueue()
    {
        // enqueue all our scripts
        wp_enqueue_script('media-upload');
        wp_enqueue_media();
    
        wp_enqueue_style('lastTap_pluginstyle', $this->plugin_url . 'assets/lt-style.css');
        wp_enqueue_style('lastTap_css3', $this->plugin_url . 'assets/css/lt-account.css');
        wp_enqueue_script('lastTap_pluginscript', $this->plugin_url . 'assets/lt-script.js');
        
    }

    public function lum_enqueue_admin_js()
    {
        wp_enqueue_style('datatables-css_admin', $this->plugin_url . 'assets/DataTables/datatables.min.css');
        wp_enqueue_script( 'laminin' , $this->plugin_url . 'assets/laminin.js' );
        wp_enqueue_style( 'boostrap-admin' , $this->plugin_url . 'assets/css/bootstrap.css' );
        wp_enqueue_style('awesomeicons_', $this->plugin_url . 'assets/css/font-awesome.min.css');
        wp_enqueue_script( 'boostrap_js_admin' , $this->plugin_url . 'assets/js/bootstrap.js' );
        wp_enqueue_script('datatable_admin', $this->plugin_url. 'assets/DataTables/datatables.min.js', array('jquery'), '1.0.0', false);

    }
    public function lum_enqueue_public()
    {

        wp_enqueue_style('styles-lastTap', $this->plugin_url . 'assets/css/lt-account.css', array(),  filemtime( $this->plugin_url  . 'assets/css/lt-account.css' ));
        wp_enqueue_style('boostrap-lastTap', $this->plugin_url . 'assets/css/bootstrap.css');
        wp_enqueue_style('awesomeicons', $this->plugin_url . 'assets/css/font-awesome.min.css');
        wp_enqueue_style('ionicons', $this->plugin_url . 'assets/fonts/ionicons.min.css');
        wp_enqueue_script( 'laminin_' , $this->plugin_url . 'assets/front.js' );

        wp_enqueue_style('datatables_public', $this->plugin_url . 'assets/DataTables/datatables.min.css');
        wp_enqueue_script('bootstrap_js_pulic', $this->plugin_url. 'assets/js/bootstrap.js', array('jquery'), '1.0.0', false);
        wp_enqueue_script('datatables_js_public', $this->plugin_url. 'assets/DataTables/datatables.min.js', array('jquery'), '1.0.0', false);
        wp_enqueue_script('custom_js_public', $this->plugin_url . 'assets/js/my-account.js',array( 'jquery'));

    }
}