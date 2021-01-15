
<?php /** settings manager */ ?>

<div class="wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1"><?php _e('Histórico', 'laminin'); ?></a></li>
        <li><a href="#tab-2"><?php _e('Criar Produtos', 'laminin'); ?></a></li>
        <li><a href="#tab-3"><?php _e( 'Criar Colaboradores', 'laminin' ); ?></a></li>
        <li><a href="#tab-4"><?php _e( 'Criar Mercado', 'laminin' ); ?></a></li>
        <li><a href="#tab-5"><?php _e( 'Criar Histórico', 'laminin' ); ?></a></li>
    </ul>
    <div class="tab-content">

        <div id="tab-1" class="tab-pane active">
            <h1 class="text-center"> Histórico</h1>
            <table id="myTable1" class="wp-list-table widefat fixed striped posts">
                <thead>
                <tr>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Produto</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Mercado</th>
                    <th id="columnname" class="manage-column column-columnname num" scope="col">Início</th> <!-- "num" added because the column contains numbers -->
                    <th id="columnname" class="manage-column column-columnname" scope="col">Valor Kz/Kg</th>
                    <th id="columnname" class="manage-column column-columnname num" scope="col">Colaborador</th> <!-- "num" added because the column contains numbers -->
                    <th id="columnname" class="manage-column column-columnname num" scope="col">Fim</th> <!-- "num" added because the column contains numbers -->

                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Produto</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Mercado</th>
                    <th id="columnname" class="manage-column column-columnname num" scope="col">Início</th> <!-- "num" added because the column contains numbers -->
                    <th id="columnname" class="manage-column column-columnname" scope="col">Valor Kz/Kg</th>
                    <th id="columnname" class="manage-column column-columnname num" scope="col">Colaborador</th> <!-- "num" added because the column contains numbers -->
                    <th id="columnname" class="manage-column column-columnname num" scope="col">Fim</th> <!-- "num" added because the column contains numbers -->

                </tr>
                </tfoot>

                <tbody>
                <?php
                global $wpdb;
                $data_history = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."lum_mercado  INNER JOIN ".$wpdb->prefix ."lum_history ON ".$wpdb->prefix ."lum_history.mercado_id = ".$wpdb->prefix ."lum_mercado.mercado_id INNER JOIN ".$wpdb->prefix ."lum_product ON ".$wpdb->prefix ."lum_history.product_id =".$wpdb->prefix ."lum_product.product_id INNER JOIN ".$wpdb->prefix ."lum_colaborador ON ".$wpdb->prefix ."lum_history.colaborador_id = ".$wpdb->prefix ."lum_colaborador.colaborador_id");
                foreach ($data_history as $history) {

                    ?>
                    <tr class="alternate">
                        <td class="column-columnname"><?php echo $history->product_name; ?></td>
                        <td class="column-columnname"><?php echo $history->mercado_name; ?></td>
                        <td class="column-columnname"><?php echo $history->product_date_start; ?></td>
                        <td class="column-columnname"><?php echo $history->product_price; ?></td>
                        <td class="column-columnname"><?php echo $history->colaborador_name; ?></td>
                        <td class="column-columnname"><?php echo $history->product_date_end; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
        <div id="tab-2" class="tab-pane">
            <form id="produtoForm" method="post" action="#" data-url="<?php echo admin_url('admin-ajax.php'); ?>" class="lastTap col-lg-5">
                <div class="lastTap form-group">
                    <label for="exampleInputEmail1">Produto</label>
                    <input type="text" class="form-control" name="product_name"  aria-describedby="emailHelp">
                </div>
                <input type="hidden" name="action" value="submit_producto">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("producto-nonce") ?>">
                <br />
                <div>
                <button type="submit" name="teste" class="button button-primary">CRIAR</button>
                    <span class="spiner spinner"></span>
                </div>
            </form>
            <br />
            <div>
                <table id="myTable2" class="wp-list-table widefat fixed striped posts">
                    <thead>
                    <tr>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Produto</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Excluir</th>

                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Produto</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Excluir</th>

                    </tr>
                    </tfoot>

                    <tbody>
                    <?php
                    global $wpdb;
                    $produtos = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."lum_product ");

                    foreach ($produtos as $produto) {

                        ?>
                        <tr class="alternate">
                            <td class="column-columnname"><?php echo $produto->product_name; ?></td>
                            <td class="column-columnname">

                                <?php
                                $nonce = wp_create_nonce( "produto_nonce_del" );
                                $link = admin_url( 'admin-ajax.php?action=delete_item&product_id='.$produto->product_id.'&nonce='.$nonce );
                                echo '<a class="fa fa-trash delete_item" data-nonce="'.$nonce.'" data-product_id="'.$produto->product_id.'" href="'.$link.'">Excluir</a>';


                                ?>


                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div id="tab-3" class="tab-pane">
            <form id="colaboradorForm" method="post" action="#" data-url="<?php echo admin_url('admin-ajax.php'); ?>" >
                <div class="lastTap form-group">
                    <label for="exampleInputEmail1">Nome do Colaborador</label>
                    <input type="text" class="form-control" name="colaborador_name"  aria-describedby="emailHelp">
                </div>
                <input type="hidden" name="action" value="submit_colaborador">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("colaborador-nonce") ?>">
                <br />
                <div>
                    <button type="submit" name="teste2"  class="button button-primary">CRIAR</button>
                    <span class="spiner spinner"></span>
                </div>
            </form>
            <br />
            <div>
                <table id="myTable3" class="wp-list-table widefat fixed striped posts">
                    <thead>
                    <tr>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Colaboradores</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Excluir</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Editar</th>

                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Colaboradores</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Excluir</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Editar</th>

                    </tr>
                    </tfoot>

                    <tbody>
                    <?php
                    global $wpdb;
                    $colaboradors = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."lum_colaborador ");

                    foreach ($colaboradors as $colaborador) {

                        ?>
                        <tr class="alternate">
                            <td class="column-columnname"><?php echo $colaborador->colaborador_name; ?></td>
                            <td class="column-columnname">

                                <?php
                                $nonce = wp_create_nonce( "colaborador_nonce_del" );
                                $link = admin_url( 'admin-ajax.php?action=delete_colaborador&colaborador_id='.$colaborador->colaborador_id.'&nonce='.$nonce );
                                echo '<a class="fa fa-trash delete_colaborador" data-nonce="'.$nonce.'" data-colaborador_id="'.$colaborador->colaborador_id.'" href="'.$link.'">Excluir</a>';
                                ?>

                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>
        <div id="tab-4" class="tab-pane">
            <form id="mercadoForm" method="post" action="#" data-url="<?php echo admin_url('admin-ajax.php'); ?>" >
                <div class="lastTap form-group">
                    <label for="exampleInputEmail1">Nome do Mercado</label>
                    <input type="text" class="form-control" name="mercado_name"  aria-describedby="emailHelp">
                </div>
                <input type="hidden" name="action" value="submit_mercado">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("mercado-nonce") ?>">
                <br />
                                <div>
                    <button type="submit" name="teste2"  class="button button-primary">CRIAR</button>
                    <span class="spiner spinner"></span>
                </div>
            </form>
        </div>

        <div id="tab-5" class="tab-pane">
            <div class='wrap'>
                <form id="historyForm" method="post" action="#" data-url="<?php echo admin_url('admin-ajax.php'); ?>" class="lastTap col-lg-5" >
                    <div class="lastTap form-group">
                        <select name="product_id" id="product_id">
                            <option>Escolhe um produto</option>
                            <?php
                            $produtos = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."lum_product ");
                            foreach ($produtos as $produto) {?>
                                <option value="<?php echo $produto->product_id ;?>"><?php echo $produto->product_name ;?></option>

                            <?php  }?>

                        </select>
                    </div>
                    <div class="lastTap form-group">
                        <select name="colaborador_id" id="colaborador_id">
                            <option>Escolhe um Colaborador</option>
                            <?php
                            $colaboradores = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."lum_colaborador ");
                            foreach ($colaboradores as $colaborador) {?>
                                <option value="<?php echo $colaborador->colaborador_id ;?>"><?php echo $colaborador->colaborador_name ;?></option>

                            <?php  }?>

                        </select>
                    </div>

                    <div class="lastTap form-group">
                        <select name="mercado_id" id="mercado_id">
                            <option>Escolhe um Mercado</option>
                            <?php
                            $mercados = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."lum_mercado ");
                            foreach ($mercados as $mercado) {?>
                                <option value="<?php echo $mercado->mercado_id ;?>"><?php echo $mercado->mercado_name ;?></option>

                            <?php  }?>

                        </select>
                    </div>
                    <div class="lastTap form-group">
                        <label for="exampleInputEmail1">Preço Kz/Kg</label>
                        <input type="text" class="form-control" name="product_price"  aria-describedby="emailHelp">
                    </div>
                    <div class="lastTap form-group">
                        <label for="exampleInputEmail1">Data do Inicio</label>
                        <input type="date" class="form-control" name="product_date_start"  aria-describedby="emailHelp">
                    </div>
                    <div class="lastTap form-group">
                        <label for="exampleInputEmail1">Data do Fim</label>
                        <input type="date" class="form-control" name="product_date_end"  aria-describedby="emailHelp">
                    </div>
                    <input type="hidden" name="action" value="submit_history">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("history-nonce") ?>">
                    <br />
                    <div>
                    <button type="submit" name="teste3" class="button button-primary">CRIAR</button>
                        <span class="spiner spinner"></span>
                    </div>
                </form>

            </div>
        </div><!-- tab-3 -->
    </div><!-- tab-content -->
</div><!-- wrap  -->

<script>
    jQuery(document).ready( function () {

        jQuery('#myTable1').DataTable({
            "language": {

                "sProcessing": "A processar...",
                "sLengthMenu": "Mostrar _MENU_ registos",
                "sZeroRecords": "Não foram encontrados resultados",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                "sInfoPostFix": "",
                "sSearch": "Procurar:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Seguinte",
                    "sLast": "Último"
                }
            },
        });
        jQuery('#myTable2').DataTable({
            "language": {

                "sProcessing": "A processar...",
                "sLengthMenu": "Mostrar _MENU_ registos",
                "sZeroRecords": "Não foram encontrados resultados",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                "sInfoPostFix": "",
                "sSearch": "Procurar:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Seguinte",
                    "sLast": "Último"
                }
            },
        });
        jQuery('#myTable3').DataTable({
            "language": {

                "sProcessing": "A processar...",
                "sLengthMenu": "Mostrar _MENU_ registos",
                "sZeroRecords": "Não foram encontrados resultados",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                "sInfoPostFix": "",
                "sSearch": "Procurar:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Seguinte",
                    "sLast": "Último"
                }
            },
        });

        var url = "<?php echo admin_url('admin-ajax.php'); ?>";
        jQuery('.delete_item').click(function(e) {
            e.preventDefault();
            var product_id = jQuery(this).attr("data-product_id");
            var nonce = jQuery(this).attr("data-nonce");
            jQuery.ajax({
                method: "GET",
                url: url,
                data: {action: "delete_item", product_id: product_id, nonce: nonce},
                success: function (response) {
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }

            });
        });

            jQuery('.delete_colaborador').click(function(e) {
                e.preventDefault();
                var colaborador_id = jQuery(this).attr("data-colaborador_id");
                var nonce = jQuery(this).attr("data-nonce");
                jQuery.ajax({
                    method: "GET",
                    url: url,
                    data: {action: "delete_colaborador", colaborador_id: colaborador_id, nonce: nonce},
                    success: function (response) {
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }

                });
            });

        });

</script>
