<?php
/**
 * @version 1.0
 *
 * @see Laminin_BaseController
 */

defined('ABSPATH') || exit;


class Laminin_TableController extends Laminin_BaseController
{
    public $settings;

    public $callbacks;

    public function lum_register()
    {
        $this->settings = new Laminin_SettingsApi();

        $this->callbacks = new Laminin_TableCallbacks();

        //        add_shortcode( 'laminin-table' , array($this , 'lum_laminin_table_front') );
        add_action( 'init' , array($this , 'purchase_shortcode_output') );

        add_action( 'wp_ajax_submit_producto' , array($this , 'submit_producto') );
        add_action( 'wp_ajax_nopriv_submit_producto' , array($this , 'submit_producto') );

        add_action( 'wp_ajax_submit_mercado' , array($this , 'submit_mercado') );
        add_action( 'wp_ajax_nopriv_submit_mercado' , array($this , 'submit_mercado') );

        add_action( 'wp_ajax_submit_colaborador' , array($this , 'submit_colaborador') );
        add_action( 'wp_ajax_nopriv_submit_colaborador' , array($this , 'submit_colaborador') );

        add_action( 'wp_ajax_submit_history' , array($this , 'submit_history') );
        add_action( 'wp_ajax_nopriv_submit_history' , array($this , 'submit_history') );

        add_action('wp_ajax_delete_item', array($this, 'delete_item') );
        add_action('wp_ajax_nopriv_delete_item', array($this, 'delete_item') );

        add_action('wp_ajax_delete_colaborador', array($this, 'delete_colaborador') );
        add_action('wp_ajax_nopriv_delete_colaborador', array($this, 'delete_colaborador') );

        add_action('wp_ajax_submit_kepya', array($this, 'submit_kepya') );
        add_action('wp_ajax_nopriv_submit_kepya', array($this, 'submit_kepya') );

    }

    public function purchase_shortcode_output()
    {
        ob_start();
        lt_get_template_part( 'kepya', 'post' );
        return ob_get_clean();


    }

    public function lt_laminin_cpt()
    {
        $labels = array(
            'name' => 'Kepya Index',
            'singular_name' => __('Kepya Index', 'laminin')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-table-col-after',
            'exclude_from_search' => false,
            'publicly_queryable' => false,
            'supports' => false,
            'show_in_rest' => false
        );

        register_post_type('laminin', $args);
    }

    function submit_producto()
    {
        if (!check_ajax_referer( 'producto-nonce' , 'nonce' )) {
            $this->lum_return_json( 'error' );
        }

        global $wpdb;

        $tablename = $wpdb->prefix . 'lum_product';
        if (empty( $_POST['product_name'] )) {
            $this->lum_return_json( 'error' );

        }

        $respons = $wpdb->insert( $tablename , array(
            'product_name' => $_POST['product_name']) , NULL
        );
        if ($respons) {
            $this->lum_return_json( 'success' );
        }

        $this->lum_return_json( 'error' );


    }
    function submit_mercado()
    {
        if (!check_ajax_referer( 'mercado-nonce' , 'nonce' )) {
            $this->lum_return_json( 'error' );
        }

        global $wpdb;

        $tablename = $wpdb->prefix . 'lum_mercado';
        if (empty( $_POST['mercado_name'] )) {
            $this->lum_return_json( 'error' );

        }

        $respons = $wpdb->insert( $tablename , array(
            'mercado_name' => $_POST['mercado_name']) , NULL
        );
        if ($respons) {
            $this->lum_return_json( 'success' );
        }

        $this->lum_return_json( 'error' );


    }

    public function submit_history()
    {
        if (!check_ajax_referer( 'history-nonce' , 'nonce' )) {
            $this->lum_return_json( 'error' );
        }

        global $wpdb;

        $tablename = $wpdb->prefix . 'lum_history';

        if (empty( $_POST['mercado_id'] ) || empty( $_POST['product_price'] ) || empty( $_POST['product_date_start'] )) {
            $this->lum_return_json( 'error' );

        }

        $respons = $wpdb->insert( $tablename , array(
            'colaborador_id' => $_POST['colaborador_id'] ,
            'product_id' => $_POST['product_id'] ,
            'mercado_id' => $_POST['mercado_id'] ,
            'product_price' => $_POST['product_price'] ,
            'product_date_start' => $_POST['product_date_start'] ,
            'product_date_end' => $_POST['product_date_end'] ,

        ) , NULL
        );
        if ($respons) {
            $this->lum_return_json( 'success' );
        }

        $this->lum_return_json( 'error' );


    }

    public function submit_colaborador()
    {
        if (!check_ajax_referer( 'colaborador-nonce' , 'nonce' )) {
            $this->lum_return_json( 'error' );
        }

        global $wpdb;

        $tablename = $wpdb->prefix . 'lum_colaborador';

        if (empty( $_POST['colaborador_name'] )) {
            $this->lum_return_json( 'error' );

        }
        $respons = $wpdb->insert( $tablename , array(
            'colaborador_name' => $_POST['colaborador_name'] ,
        ) , NULL
        );
        if ($respons) {
            $this->lum_return_json( 'success' );
        }

        $this->lum_return_json( 'error' );

    }

    function delete_colaborador()
    {

        if (!wp_verify_nonce( $_REQUEST['nonce'] , 'colaborador_nonce_del' )) {
            exit();
        }

        if (!empty( $_REQUEST['colaborador_id'] )) {
            $id = $_REQUEST['colaborador_id'];
            $this->delete_row_colaborador($id);

        }

        if (empty( $_SERVER['HTTP_X_REQUSTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUSTED_WITH'] ) == 'XMLHttpRequest') {
            header( "Location: " . $_SERVER['HTTP_REFERER'] );
        }

    }

    function delete_item()
    {

        if (!wp_verify_nonce( $_REQUEST['nonce'] , 'produto_nonce_del' )) {
            exit();
        }

        if (!empty( $_REQUEST['product_id'] )) {
            $id = $_REQUEST['product_id'];
            $this->delete_row_product($id);

        }
        if (!empty( $_REQUEST['colaborador_id'] )) {
            $id = $_REQUEST['colaborador_id'];
            $this->delete_row_colaborador($id);

        }

        if (empty( $_SERVER['HTTP_X_REQUSTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUSTED_WITH'] ) == 'XMLHttpRequest') {
            header( "Location: " . $_SERVER['HTTP_REFERER'] );
        }

    }

    function delete_row_product( $id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'lum_product';
        return $wpdb->query(
            $wpdb->prepare(
                "
            DELETE FROM $table_name
     WHERE product_id = %d",
                $id
            )
        );
    }
    function delete_row_colaborador( $id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'lum_colaborador';
        return $wpdb->query(
            $wpdb->prepare(
                "
            DELETE FROM $table_name
     WHERE colaborador_id = %d",
                $id
            )
        );
    }

    function submit_kepya()
    {

        if (!wp_verify_nonce( $_REQUEST['nonce'] , 'betweenReports_nonce' )) {
            $this->lum_return_json( 'error' );
        }

        global $wpdb;

        $datasearch =  $_POST['datasearch'] ?? false;
        $mercado_nome =   $_POST['mercado_name'] ?? false;
        $dataAtual =  date("Y-m-d");
        setcookie("datasearch_kepia", $datasearch, time()+360, '/');
        setcookie("mercado_kepia", $mercado_nome, time()+360, '/');
        setcookie("dataAtual_kepya", $dataAtual, time()+360, '/');

        $data_history = $wpdb->get_results("SELECT ".$wpdb->prefix ."lum_product.product_name as product_name, MIN(".$wpdb->prefix ."lum_history.product_price) AS min_price, MAX(".$wpdb->prefix ."lum_history.product_price) AS max_price, AVG(".$wpdb->prefix ."lum_history.product_price) med_price, AVG(".$wpdb->prefix ."lum_history.product_price) AS med_1_price FROM ".$wpdb->prefix ."lum_history INNER JOIN ".$wpdb->prefix ."lum_product ON ".$wpdb->prefix ."lum_product.product_id = ".$wpdb->prefix ."lum_history.product_id WHERE  ".$wpdb->prefix ."lum_history.product_date_end =  '$datasearch' AND ".$wpdb->prefix ."lum_mercado.mercado_id = 1 group by product_name");

        if ($data_history) {
            $this->lum_return_json( $datasearch );
        }

        $this->lum_return_json( 'error' );


    }
    public function lum_return_json($status)
    {
        $return = array(
            'status' => $status
        );
        wp_send_json( $return );

        wp_die();
    }
}