<?php

/*
Plugin Name: Kepya Index
Plugin URI: https://marciozebedeu.com
Description: Kepyia index é um plugin para exibição da variação de preços nos mercados de Luanda.

Version: 1.0
Author: Marcio Zebedeu
Author URI: https://marciozebedeu.com
License: A "Slug" license name e.g. GPL2
*/


/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

// If this file is called directly, abort!!!
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');
// Plugin version.
if ( ! defined( 'lum_VERSION' ) ) {
    define( 'lum_VERSION', '1.0.0' );
}

/**
 * @property LastTap_MessageManager messenger;
 */
final class LumKpyaIndex
{
    private static $instance;
    /**
     * @var void
     */
    public $info;

    /**
     * @var Laminin_SettingsLinks
     */

    public static function instances()
    {
        if (!isset( self::$instance ) && !(self::$instance instanceof LumKpyaIndex)) {
            self::$instance = new LumKpyaIndex();

            self::includes();
            self::initialize();
        }
        return self::$instance;
    }

    private static function includes()
    {
        require_once(dirname( __FILE__ ) . '/includes/Laminin_Init.php');
        require_once(dirname( __FILE__ ) . '/includes/controller/Laminin_Activate.php');
        require_once(dirname( __FILE__ ) . '/includes/controller/Laminin_Deactivate.php');
        include_once(dirname( __FILE__ ) . '/includes/controller/Laminin_BaseController.php');
        require_once(dirname( __FILE__ ) . '/includes/api/Laminin_SettingsApi.php');
        require_once(dirname( __FILE__ ) . '/includes/pages/Laminin_Dashboard.php');
        require_once(dirname( __FILE__ ) . '/includes/controller/Laminin_SettingsLinks.php');
        require_once(dirname( __FILE__ ) . '/includes/callbacks/Laminin_ManagerCallbacks.php');
        require_once(dirname( __FILE__ ) . '/includes/callbacks/Laminin_TableCallbacks.php');
        require_once(dirname( __FILE__ ) . '/includes/controller/Laminin_Enqueue.php');
        require_once(dirname( __FILE__ ) . '/includes/controller/Laminin_TableController.php');



    }

    private static function initialize()
    {

        /**
         * Initialize all the core classes of the plugin
         */
        if (class_exists( 'Laminin_Init' )) {
            return Laminin_Init::lum_registerServices();
        }
    }
}

function lum_install( $network_wide = false)
{

    global $wpdb;

    if (is_multisite() && $network_wide) {
        foreach ($wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs LIMIT 100" ) as $blog_id) {
            switch_blog( $blog_id );
            lum_run_install();
            restore_current_blog();
        }
    } else {
        lum_run_install();
    }
}

function lum_run_install() {


    // clear the permalinks

    flush_rewrite_rules( false );

    update_option( 'lum_version', lum_VERSION );
    flush_rewrite_rules();

}

function lum_after_install()
{

    if (!is_admin()) {
        return;
    }

    $lum_options = get_transient( '_lum_installed' );
    if ( false !== $lum_options ) {
        // Delete the transient
        delete_transient( '_lum_installed' );
    }

}
register_activation_hook(__FILE__, 'lum_install');

function lum_new_blog_create( $blog ) {
    if( ! is_plugin_active_for_network( plugin_basename( __FILE__ ) )) {
        return;
    }
    if( ! is_init( $blog ) ) {
        $blog = $blog->id;
    }
    switch_blog( $blog );
    lum_install();
    restore_current_blog();
}

if( version_compare( get_bloginfo( 'version'), '5.1', '>=' ) ) {
    add_action('wp_initialize_site', 'lum_new_blog_create');
}else{
    add_action('wpmu_new_blog', 'lum_new_blog_create');

}
/**
 * The code that runs during plugin activation
 */
function activate_lum_plugin()
{
    Laminin_Activate::lum_activate();
    add_action( 'admin_init', 'lum_after_install' );

}

register_activation_hook( __FILE__ , 'activate_lum_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_lump_lugin()
{
    Laminin_Deactivate::lum_deactivate();
}

register_deactivation_hook( __FILE__ , 'deactivate_lum_plugin' );

function sports_bench_create_db()
{
    global $wpdb;



    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    //* Create the teams table
    $lum_product = $wpdb->prefix . 'lum_product';
    $sql = "CREATE TABLE IF NOT EXISTS $lum_product (
      product_id int NOT NULL AUTO_INCREMENT,
  product_name varchar(100) NOT NULL,
  PRIMARY KEY (product_id),
  UNIQUE KEY product_name_UNIQUE (product_name) )
 $charset_collate;";
    dbDelta( $sql );

    $lum_colaborador = $wpdb->prefix . 'lum_colaborador';
    $sql1 = "CREATE TABLE IF NOT EXISTS $lum_colaborador (
    colaborador_id INTEGER NOT NULL AUTO_INCREMENT,
    colaborador_name TEXT NOT NULL,
    PRIMARY KEY (colaborador_id)
 ) $charset_collate;";
    dbDelta( $sql1 );

    $lum_mercado = $wpdb->prefix . 'lum_mercado';

    $sql2 = "CREATE TABLE IF NOT EXISTS $lum_mercado (
  mercado_id int NOT NULL AUTO_INCREMENT,
  mercado_name varchar(100) NOT NULL,
  PRIMARY KEY (mercado_id),
  UNIQUE KEY mercado_name_UNIQUE (mercado_name)
) $charset_collate;";
    dbDelta( $sql2 );

    $table_name = $wpdb->prefix . 'lum_history';

    $sql3 ="CREATE TABLE IF NOT EXISTS $table_name (
history_id int NOT NULL AUTO_INCREMENT,
  product_price double DEFAULT NULL,
  product_date_end date DEFAULT NULL,
  product_date_start varchar(45),
  mercado_id int NOT NULL,
  product_id int NOT NULL,
  colaborador_id int NOT NULL,
  PRIMARY KEY (history_id,mercado_id,product_id,colaborador_id),
  KEY fk_wp_lum_history_wp_lum_mercado_idx (mercado_id),
  KEY fk_wp_lum_history_wp_lum_product1_idx (product_id),
  KEY fk_wp_lum_history_wp_lum_colaborador1_idx (colaborador_id),
  CONSTRAINT fk_wp_lum_history_wp_lum_colaborador1 FOREIGN KEY (colaborador_id) REFERENCES $lum_colaborador (colaborador_id),
  CONSTRAINT fk_wp_lum_history_wp_lum_mercado FOREIGN KEY (mercado_id) REFERENCES $lum_mercado (mercado_id),
  CONSTRAINT fk_wp_lum_history_wp_lum_product1 FOREIGN KEY (product_id) REFERENCES $lum_product (product_id)
) $charset_collate;";
    dbDelta( $sql3 );
}
register_activation_hook( __FILE__, 'sports_bench_create_db' );


function LT()
{
    return LumKpyaIndex::instances();
}
$GLOBALS['LumKpyaIndex'] = LT();
