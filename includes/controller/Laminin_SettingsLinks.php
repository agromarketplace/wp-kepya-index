<?php
/**
 * @version 1.0
 ** @see Laminin_BaseController
 */

defined('ABSPATH') || exit;


class Laminin_SettingsLinks extends Laminin_BaseController
{
    public function lum_register()
    {
        add_filter("plugin_action_links_$this->plugin_base", array($this, 'lum_settings_link'));
    }

    public function lum_settings_link($links)
    {
        $settings_link = '<a href="admin.php?page=lum_plugin_page">'.__('Settings','laminin').'</a>';
        array_push($links, $settings_link);
        return $links;
    }

}


