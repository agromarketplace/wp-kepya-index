<?php
/**
 * @version 1.0
 *
 */

defined('ABSPATH') || exit;


class Laminin_TableCallbacks extends Laminin_BaseController
{

    public function lum_index_produto()
    {
        return require_once("$this->plugin_path/templates/produto.php");
    }
    public function lum_index_consult()
    {
        return require_once("$this->plugin_path/templates/consult.php");
    }
    public function lum_index_history()
    {
        return require_once("$this->plugin_path/templates/history.php");
    }
}

