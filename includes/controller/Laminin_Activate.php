<?php
/**
 * @version 1.0
 ** @see Laminin_BaseController
 */

defined('ABSPATH') || exit;


class Laminin_Activate
{
    public static function lum_activate()
    {
        flush_rewrite_rules( );

        $default = array();

        if (!get_option('lum_option')) {
            update_option('lum_option', $default);
        }

        if (!get_option('lum_version')) {
            update_option( 'lum_version', $default );
        }


    }


}


function getInfo(){
    global $wpdb;
    $mercados = $wpdb->get_results("SELECT ".$wpdb->prefix ."lum_mercado.mercado_name FROM ".$wpdb->prefix ."lum_mercado ");

    $datasearch_kepia = $_COOKIE['datasearch_kepia'] ??  date("Y-m-d");
    $mercado_kepia = $_COOKIE['mercado_kepia'] ?? $mercados[0]->mercado_name;

    return $wpdb->get_results("SELECT week(".$wpdb->prefix ."lum_history.product_date_start) AS data_start, ".$wpdb->prefix ."lum_product.product_name as product_name, MIN(".$wpdb->prefix ."lum_history.product_price) AS min_price, MAX(".$wpdb->prefix ."lum_history.product_price) AS max_price, ROUND( AVG(".$wpdb->prefix ."lum_history.product_price)) med_price, AVG(".$wpdb->prefix ."lum_history.product_price) AS med_1_price FROM ".$wpdb->prefix ."lum_history INNER JOIN ".$wpdb->prefix ."lum_product ON ".$wpdb->prefix ."lum_product.product_id = ".$wpdb->prefix ."lum_history.product_id INNER JOIN ".$wpdb->prefix ."lum_mercado ON ".$wpdb->prefix ."lum_mercado.mercado_id = ".$wpdb->prefix ."lum_history.mercado_id WHERE ".$wpdb->prefix ."lum_mercado.mercado_name = '$mercado_kepia' AND week( ".$wpdb->prefix ."lum_history.product_date_start) = week('$datasearch_kepia') group by product_name, data_start");

}

function getLastPrice(){
    global $wpdb;

    $mercados = $wpdb->get_results("SELECT ".$wpdb->prefix ."lum_mercado.mercado_name FROM ".$wpdb->prefix ."lum_mercado ");
    $datasearch_kepia = $_COOKIE['datasearch_kepia'] ??  date("Y-m-d");
    $mercado_kepia = $_COOKIE['mercado_kepia'] ?? $mercados[0]->mercado_name;

    $time = new DateTime( $datasearch_kepia );
    $time-> sub( new DateInterval( 'P7D' ) );
    $data_7_anterior = $time->format( 'Y-m-d' );

    return $wpdb->get_results("SELECT ".$wpdb->prefix ."lum_product.product_name AS names, ROUND( AVG(".$wpdb->prefix ."lum_history.product_price)) AS med_1_price FROM ".$wpdb->prefix ."lum_history INNER JOIN ".$wpdb->prefix ."lum_product ON ".$wpdb->prefix ."lum_product.product_id = ".$wpdb->prefix ."lum_history.product_id INNER JOIN ".$wpdb->prefix ."lum_mercado ON ".$wpdb->prefix ."lum_mercado.mercado_id = ".$wpdb->prefix ."lum_history.mercado_id WHERE ".$wpdb->prefix ."lum_mercado.mercado_name = '$mercado_kepia' AND week( ".$wpdb->prefix ."lum_history.product_date_start) = week('$data_7_anterior') group by names");
}


function get_media_n_1(){

    global $wpdb;
        return $wpdb->get_results("SELECT ".$wpdb->prefix ."lum_product.product_name as product_name,  ROUND(AVG(".$wpdb->prefix ."lum_history.product_price), 2) AS med_1_price FROM ".$wpdb->prefix ."lum_history INNER JOIN ".$wpdb->prefix ."lum_product ON ".$wpdb->prefix ."lum_product.product_id = ".$wpdb->prefix ."lum_history.product_id where week(".$wpdb->prefix ."lum_history.product_date_start)  <= week(DATE_SUB(CURDATE(), INTERVAL 7 DAY)) group by product_name");


}

function lum_data(){
    $datasearch_kepia = $_COOKIE['datasearch_kepia'] ??  date("Y-m-d");

    $time = new DateTime( $datasearch_kepia );
    $time-> sub( new DateInterval( 'P7D' ) );
    $data_7_anterior = $time->format( 'Y-m-d' );
    ?>
            ENTRE  <?php echo $datasearch_kepia;?>  E   <?php echo $data_7_anterior; ?>
<?php
}
