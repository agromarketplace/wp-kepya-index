<div class="wrap">
    <h2 class="text-center">CONSULTA INDEX</h2>

    <table id="myTable4" class="wp-list-table widefat fixed striped posts">
        <thead>
        <tr>
            <th id="columnname" class="manage-column column-columnname" scope="col">Produto</th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Preço mais Baixo</th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Preço mais Alto</th>
            <th id="columnname" class="manage-column column-columnname num" scope="col">Média</th> <!-- "num" added because the column contains numbers -->
            <th id="columnname" class="manage-column column-columnname" scope="col">Média n-1</th>

        </tr>
        </thead>

        <tfoot>
        <tr>
            <th id="columnname" class="manage-column column-columnname" scope="col">Produto</th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Preço mais Baixo</th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Preço mais Alto</th>
            <th id="columnname" class="manage-column column-columnname num" scope="col">Média</th> <!-- "num" added because the column contains numbers -->
            <th id="columnname" class="manage-column column-columnname" scope="col">Média n-1</th>

        </tr>
        </tfoot>

        <tbody>
        <?php
        global $wpdb;
        $data_history = $wpdb->get_results("SELECT ".$wpdb->prefix ."lum_product.product_name as product_name, MIN(".$wpdb->prefix ."lum_history.product_price) AS min_price, MAX(".$wpdb->prefix ."lum_history.product_price) AS max_price, ROUND(AVG(".$wpdb->prefix ."lum_history.product_price), 2) AS med_price FROM ".$wpdb->prefix ."lum_history INNER JOIN ".$wpdb->prefix ."lum_product ON ".$wpdb->prefix ."lum_product.product_id = ".$wpdb->prefix ."lum_history.product_id where week(".$wpdb->prefix ."lum_history.product_date_start) = week(NOW()) group by product_name");
        foreach ($data_history as $keys => $history) {

            ?>
            <tr class="alternate">
                <td class="column-columnname"><?php echo $history->product_name; ?></td>
                <td class="column-columnname"><?php echo $history->min_price; ?></td>
                <td class="column-columnname"><?php echo $history->max_price; ?></td>
                <td class="column-columnname"><?php echo $history->med_price; ?></td>
                <td id="media_n_1-<?php echo $keys; ?>" class="column-columnname"></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <br>
    <br>
    <br>

    
<script>

    document.addEventListener('DOMContentLoaded', ()=> {

        let index = 0;
        var data =  <?php echo json_encode( get_media_n_1() );?>;

        for (let i = 0; i < data.length ; i++) {
            var last_price = document.getElementById("media_n_1-" + i).textContent = data[i].med_1_price;
          
        }

    });


        jQuery(document).ready( function () {

            jQuery('#myTable4').DataTable({
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
            jQuery('#myTable5').DataTable({
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

        });
    </script>
