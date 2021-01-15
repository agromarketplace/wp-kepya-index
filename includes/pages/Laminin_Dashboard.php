<?php
/**
 * @version 1.0
 *
 * @package LastTapEvents/includes/controller
 * @see Laminin_BaseController
 */

defined('ABSPATH') || exit;


class Laminin_Dashboard extends Laminin_BaseController
{
    public $settings;

    public $admin_callbacks;

    public $callbacks_mngr;

    public $pages = array();

    public function lum_register()
    {
        $this->settings = new Laminin_SettingsApi();
        $this->callbacks_mngr = new Laminin_ManagerCallbacks();
        $this->callbacks = new Laminin_TableCallbacks();

        $this->lum_setPages();
        $this->lum_setShortcodePage();

        $this->settings->lum_addPages($this->pages)->lum_register();

    }
    public function lum_setPages(){
        $this->pages = array(
            array(
                'page_title' => 'KEPYA INDEX',
                'menu_title' => 'KEPIA INDEX',
                'capability' => 'manage_options',
                'menu_slug'  => 'kepya_plugin_page',
                'callback'  => array($this->callbacks, 'lum_index_consult'),
                'icon_url'   => 'dashicons-table-col-after',
                'position'   => 110,
            )
        );
    }

    public function lum_setShortcodePage()
    {
        $subpage = array(
            array(
                'parent_slug' => 'kepya_plugin_page' ,
                'page_title' => 'Histórico' ,
                'menu_title' => 'Histórico' ,
                'capability' => 'manage_options' ,
                'menu_slug' => 'lum_history' ,
                'callback' => array($this->callbacks , 'lum_index_history')
            )
        );

        $this->settings->lum_addSubPages( $subpage )->lum_register();
    }

    public function lum_dashboard(){

    }

}