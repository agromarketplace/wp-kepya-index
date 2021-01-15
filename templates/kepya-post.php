<?php

function lum_table_index($attrs, $content=''){
    ob_start();

?>
<form id="keypaForm" method="post" action="#" data-url="<?php echo admin_url('admin-ajax.php'); ?>" >
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputCity">Data</label>
            <input type="date" class="form-control" name="datasearch" id="inputCity">
        </div>
        <div class="form-group col-md-4">
            <label for="inputState">Mercado</label>
            <select name="mercado_name" id="mercado_name" required>
                <option>Escolhe um Mercado</option>
                <?php
                global $wpdb;
                $mercados = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."lum_mercado ");
                foreach ($mercados as $mercado) {?>
                    <option value="<?php echo $mercado->mercado_name ;?>"><?php echo $mercado->mercado_name ;?></option>

                <?php  }?>

            </select>
        </div>
    </div>
    <br>
    <input type="hidden" name="action" value="submit_kepya">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("betweenReports_nonce") ?>">
    <button type="submit" class="btn btn-primary">Buscar</button>
</form>

<br>
    <div class="form-group col-md-6">
    <input type="text" class="fa-search" id="myInputTextField" placeholder="Pesquisar">
    </div>
<br>
<hr>
<div class="flex-container text-center">
    <div class="keypia_flex">Kepya</div>
    <div class="keypia_flex" id="kepya_index"></div>
    <div class="keypia_flex"><h4 class="mercado_index_color">Mercado do(a) <?php echo $_COOKIE['mercado_kepia'] ?? null;?></div>
</div>
<div class="flex-container text-center">
    <div class="keypia_flex2">Index</div>
    <div class="keypia_flex3" id="kepya_index"><i class="index_icon fa fa-1x"></i></div>
    <div class="keypia_flex2"><h4 class="title_index">VARIAÇÃO SEMANAL DA MÉDIA DE PREÇOS</h4></div>
</div>
    <div class="flex-container text-center">
<div class="data_index text-center lastTap bg-dark">
           <?php echo lum_data(); ?>
</div>
    </div>

    <table id="myTable6" class="lastTap table-hover rwd-table stripe" style="width:100%">

        <thead>
        <tr>
            <th id="columnname" class="manage-column column-columnname" scope="col">Produto</th>
            <th id="columnname" class="column-columnname" scope="col">Preço Ant. Kz/Kg</th>
            <th id="columnname" class="column-columnname" scope="col">Preço Act. Kz/Kg</th>
            <th id="columnname" class="column-columnname" scope="col">Preço MIN Kz/Kg</th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Preço MAX. Kz/Kg</th>
            <th id="columnname" class="manage-column column-columnname num" scope="col">Tendencia</th> <!-- "num" added because the column contains numbers -->
            <th id="columnname" class="manage-column column-columnname" scope="col">Variação %</th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Variação KZ</th>

        </tr>
        </thead>
        <tbody>
        <?php

        foreach (getInfo() as $key => $history) {

            ?>
            <tr class="text-center">
                <td class="tlastTap table-dark column-columnname"><?php echo $history->product_name; ?></td>
                <td id="price_anterior-<?php echo $key; ?>" class="lastTap table-dark column-columnname"></td>
                <td id="current_price-<?php echo $key; ?>" data-current_price="<?php echo $history->med_price; ?>" class="lastTap table-dark column-columnname"><?php echo $history->med_price; ?></td>
                <td class="lastTap table-dark column-columnname"><?php echo $history->min_price; ?></td>
                <td class="lastTap table-dark column-columnname"><?php echo $history->max_price; ?></td>
                <td id="trand-<?php echo $key; ?>" class="lastTap table-dark column-columnname"><i class="trand-<?php echo $key; ?> fa fa-2x"></i></td>
                <td  id="vari_em_porse-<?php echo $key; ?>" class="table-dark column-columnname"></td>
                <td  id="vari_em_kz-<?php echo $key; ?>" class="lastTap table-dark column-columnname"></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>


<script>

    document.addEventListener('DOMContentLoaded', ()=> {

        let index = 0;
        var data =  <?php echo json_encode( getLastPrice() );?>;

        for (let i = 0; i < data.length ; i++) {
            var last_price = document.getElementById("price_anterior-" + i).textContent = data[i].med_1_price;
            var current_price = document.getElementById("current_price-" + i).textContent;

            var result_porcentagem = (parseInt(current_price) - parseInt(last_price)) / parseInt(last_price)

            index += result_porcentagem;

            document.getElementById("vari_em_porse-" + i).innerText = (Math.round(result_porcentagem) + "%");

            var vari_em_kz = document.getElementById("vari_em_kz-" + i).innerText = parseInt(current_price) - parseInt(last_price);

            if (vari_em_kz > 0) {
                document.querySelector(".trand-" + i).classList.add("fa-sort-up");
                var color = document.querySelector(".trand-" + i);
                color.style.color = "red";
            }
            if (vari_em_kz < 0) {
                document.querySelector(".trand-" + i).classList.add("fa-sort-desc");
                var color = document.querySelector(".trand-" + i);
                color.style.color = "green";
            }
            if (vari_em_kz == 0) {
                document.querySelector(".trand-" + i).classList.add("fa-exchange");
                var color = document.querySelector(".trand-" + i);
                color.style.color = "yellow";
            }

            document.querySelector("#kepya_index").innerHTML = Math.round(index / data.length)
            var media_index = Math.round(index / data.length);
            document.querySelector("#kepya_index").innerHTML = media_index + "%";
            if (media_index > 0) {
                document.querySelector(".index_icon").classList.add("fa-sort-up");
                var color_index = document.querySelector(".index_icon");
                color_index.style.color = "red";
            }
            if (media_index < 0) {
                document.querySelector(".index_icon").classList.add("fa-sort-desc");
                var color_index = document.querySelector(".index_icon");
                color_index.style.color = "green";
            }
            if (media_index == 0) {
                document.querySelector(".index_icon").classList.add("fa-exchange");
                var color_index = document.querySelector(".index_icon");
                color_index.style.color = "yellow";
            }
        }

    });

    jQuery(document).ready( function () {

       var oTable = jQuery('#myTable6').DataTable({

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
           "paging":   false,
           "ordering": true,
           "info":     true,
           "sDom":     'ltipr',
    });
        jQuery('#myInputTextField').keyup(function(){
            oTable.search(jQuery(this).val()).draw() ;
        });
      });

</script>
<?php

    return ob_get_clean();
}
    add_shortcode( 'laminin-table' ,  'lum_table_index') ;
