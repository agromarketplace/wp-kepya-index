<?php
/**
 * @see lum_install
 */


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

    flush_rewrite_rules( false );


    update_option( 'lumversion', lum_VERSION );


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