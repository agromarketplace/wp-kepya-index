<?php
/**
 * @version 1.0
 *
 */

defined('ABSPATH') || exit;


final class Laminin_Init
{

    public static function lum_registerServices()
    {

        foreach (self::lum_getServices() as $class) {
            $service = self::lum_instantiate($class);
            if (method_exists($service, 'lum_register')) {
                $service->lum_register();
            }
        }
    }


    public static function lum_getServices()
    {
        return [
            Laminin_Dashboard::class,
            Laminin_Enqueue::class,
            Laminin_SettingsLinks::class,
            Laminin_TableController::class,
        ];
    }


    private static function lum_instantiate($class)
    {
        $service = new $class();

        return $service;
    }
}


function lt_get_template_part( $slug, $name = null, $load = true ) {

    do_action( 'get_template_part_' . $slug, $slug, $name );

    $load_template = apply_filters( 'lt_allow_template_part_' . $slug . '_' . $name, true );
    if ( false === $load_template ) {
        return '';
    }

    // Setup possible parts
    $templates = array();
    if ( isset( $name ) )
        $templates[] = $slug . '-' . $name . '.php';
    $templates[] = $slug . '.php';

    $templates = apply_filters( 'lt_get_template_part', $templates, $slug, $name );

    return lt_locate_template( $templates, $load, false );
}


function lt_get_theme_template_paths() {

    $template_dir = lt_get_theme_template_dir_name();

    $file_paths = array(
        1 => trailingslashit( get_stylesheet_directory() ) . $template_dir,
        10 => trailingslashit( get_template_directory() ) . $template_dir,
        100 => lt_get_templates_dir()
    );

    $file_paths = apply_filters( 'lt_template_paths', $file_paths );

    ksort( $file_paths, SORT_NUMERIC );

    return array_map( 'trailingslashit', $file_paths );
}


function lt_locate_template( $template_names, $load = false, $require_once = true ) {

    $located = false;

    foreach ( (array) $template_names as $template_name ) {


        if ( empty( $template_name ) )
            continue;

        $template_name = ltrim( $template_name, '/' );

        foreach( lt_get_theme_template_paths() as $template_path ) {

            if( file_exists( $template_path . $template_name ) ) {
                $located = $template_path . $template_name;
                break;
            }
        }

        if( $located ) {
            break;
        }
    }

    if ( ( true == $load ) && ! empty( $located ) )
        load_template( $located, $require_once );

    return $located;
}

function lt_get_theme_template_dir_name() {
    return trailingslashit( apply_filters( 'lt_templates_dir', 'lt_templates' ) );
}

function LT_get_templates_dir() {
    $file_paths = new Laminin_BaseController();
    return $file_paths->plugin_path . 'templates';
}


function lt_get_success_page_uri( $query_string = null ) {
    $page_id = get_option( 'lt_option' )['lumsuccess_page'];
    $page_id = absint( $page_id );

    $success_page = get_permalink( $page_id );

    if ( $query_string ) {
        $success_page .= $query_string;
    }

    return apply_filters( 'lt_get_success_page_uri', $success_page );
}
