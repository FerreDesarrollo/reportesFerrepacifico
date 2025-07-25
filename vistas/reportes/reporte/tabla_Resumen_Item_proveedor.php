<?php 
date_default_timezone_set('America/Mexico_City');

    
    

function clientes($sql){
    if (!defined('NETSUITE_DEPLOYMENT_URL')) {
        define("NETSUITE_DEPLOYMENT_URL", 'https://5017898.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=1376&deploy=1');
    }
    if (!defined('NETSUITE_URL')) {
        define("NETSUITE_URL", 'https://5017898..restletsapi.netsuite.com');
    }
    if (!defined('NETSUITE_REST_URL')) {
        define("NETSUITE_REST_URL", 'https://5017898.restlets.api.netsuite.com/app/site/hosting/restlet.nl');
    }
    if (!defined('NETSUITE_SCRIPT_ID')) {
        define("NETSUITE_SCRIPT_ID", '1376');
    }
    if (!defined('NETSUITE_DEPLOY_ID')) {
        define("NETSUITE_DEPLOY_ID", '1');
    }
    if (!defined('NETSUITE_ACCOUNT')) {
        define("NETSUITE_ACCOUNT", '5017898');
    }
    if (!defined('NETSUITE_CONSUMER_KEY')) {
        define("NETSUITE_CONSUMER_KEY", '4a8b80dd03087c6b3e7ffa5c6f2bb1dc55de7c14b43f4785e5efe3d2b38cf323');
    }
    if (!defined('NETSUITE_CONSUMER_SECRET')) {
        define("NETSUITE_CONSUMER_SECRET", 'a1560b11b878ab97e492eab1ac2c235370a23ab0c6f426a699d9e32ec42412ed');
    }
    if (!defined('NETSUITE_TOKEN_ID')) {
        define("NETSUITE_TOKEN_ID", '3ff82fb87941c6287268a66db5c1d54fc7af6ad556cc8d0f6154d7b0b393b87a');
    }
    if (!defined('NETSUITE_TOKEN_SECRET')) {
        define("NETSUITE_TOKEN_SECRET", '6d4475bb3addd3a581e50dd001d5114189a5fcea981c8b05408eaa222a8b364c');
    }
    
    $encoded = json_encode($sql);
    $data_string = $encoded;
    $oauth_nonce = md5(mt_rand());
    $oauth_timestamp = time();
    $oauth_signature_method = 'HMAC-SHA256';
    $oauth_version = "1.0";
    
    $base_string =
        "POST&".urlencode(NETSUITE_REST_URL)."&".
            urlencode(
                "deploy=".NETSUITE_DEPLOY_ID
                    ."&oauth_consumer_key=".NETSUITE_CONSUMER_KEY
                ."&oauth_nonce=".$oauth_nonce
                ."&oauth_signature_method=".$oauth_signature_method
                ."&oauth_timestamp=".$oauth_timestamp
                ."&oauth_token=".NETSUITE_TOKEN_ID
                ."&oauth_version=".$oauth_version
                ."&script=".NETSUITE_SCRIPT_ID
            );
    
    $key = rawurlencode(NETSUITE_CONSUMER_SECRET).'&'.rawurlencode(NETSUITE_TOKEN_SECRET);
    $signature = base64_encode(hash_hmac("sha256", $base_string, $key, true));
    $auth_header = 'OAuth '
        .'realm="'.rawurlencode(NETSUITE_ACCOUNT).'",'
            .'oauth_consumer_key="'.rawurlencode(NETSUITE_CONSUMER_KEY).'",'
                .'oauth_token="'.rawurlencode(NETSUITE_TOKEN_ID).'",'
                    .'oauth_signature_method="'.rawurlencode($oauth_signature_method).'",'
                        .'oauth_timestamp="'.rawurlencode($oauth_timestamp).'",'
                            .'oauth_nonce="'.rawurlencode($oauth_nonce).'",'
                                .'oauth_version="'.rawurlencode($oauth_version).'",'
                                    .'oauth_signature="'.rawurlencode($signature).'"';
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => NETSUITE_DEPLOYMENT_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data_string,
        CURLOPT_HTTPHEADER => array(
            'Authorization: '.$auth_header,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}
$c=array();

$sucursal=  $_GET['sucursal'] ;

$obj = clientes([ "consulta" => "items_por_proveedor_resumen","sucursal" =>$sucursal]);
$obj=json_decode($obj);

?>
<style>
    .tablas{
    /*Cambiar el color del borde del contenedor*/
  border: 1px solid #eee;
   /*Cambiar el ancho de acuerdo a sus necesidades, siempre en porcentaje, si quiere que cubra toda la ventana coloquele un 100%*/
  width: 100%;
  overflow: auto;
  white-space: nowrap;
}
</style>

<div class="tablas">
<table class="display nowrap table table-sm table-bordered table-hover table-responsive-sm" style="text-align: center; width:100%" id="resultsTable" >
	<thead >
	<tr style="width:33%" role="row">
        <th > <span>proveedor</span></th>
        <th > <span>numero_items</span></th>
        <th > <span>valor_items</span></th>
        <th > <span>activos</span></th>
        <th > <span>valor_activos</span></th>
        <th > <span>activos_para_la_compra</span></th>
        <th > <span>valor_activos_para_la_compra</span></th>
        <th > <span>inactivos_para_la_compra</span></th>
        <th > <span>valor_inactivos_para_la_compra</span></th>
        <th > <span>sobrepedido</span></th>
        <th > <span>valor_sobrepedido</span></th>
        <th > <span>sin_sobrepedido</span></th>
        <th > <span>valor_sin_sobrepedido</span></th>
        <th > <span>descontinuados</span></th>
        <th > <span>valor_descontinuados</span></th>
    
        
    
</tr>
    </thead>
    <tbody>
    <?php 
        // Verificar si las funciones ya están declaradas para evitar errores
   
    
       
        // Calcular el total de ventas y stock_ps antes de mostrar las filas
      

        // Ahora recorremos de nuevo para mostrar las filas
        for ($i = 0; $i < count($obj); $i++) { 
            $clientes1 = $obj[$i];
            for ($ii = 0; $ii < count($clientes1); $ii++) {
      
    ?>
                <tr>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'proveedor'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'numero_items'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'valor_items'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'activos'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'valor_activos'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'activos_para_la_compra'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'valor_activos_para_la_compra'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'inactivos_para_la_compra'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'valor_inactivos_para_la_compra'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'sobrepedido'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'valor_sobrepedido'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'sin_sobrepedido'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'valor_sin_sobrepedido'}; ?></td>
                    
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'descontinuados'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'valor_descontinuados'}; ?></td>

              </tr>
    <?php   
            }
        }
    ?>
</tbody>

<tfoot id="ttf">
   
</tfoot>


</table>
</div>
<script type="text/javascript">
         $("#submitter").click(function(){$("#myModal").modal("show")});
    $(document).ready(function() { 
     $("#resultsTable").DataTable({
        "order": [[3, "desc"]],
        "pageLength": 500,
        "initComplete": function(){
          $("#resultsDiv").show(); 
        },
        "language": {"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},
        "dom": "Bfrtip",
        "buttons": [
          {
            "extend": "excelHtml5",
            "text": "Exportar a Excel",
            "title": "Articulos descontinuados",
            "messageTop": "Articulos descontinuados"
          }
        ]
      });



   }); 
   
   $(document).ready(function(){ 
       $('#resultsTable tr').each(function(){ 
           var col7 = $(this).find('td:eq(7)'); 
           var value7 = parseFloat(col7.text()).toFixed(0);   
           col7.text(value7); 
           var col9 = $(this).find('td:eq(9)'); 
           var value9 = parseFloat(col9.text()).toFixed(0); 
           col9.text(value9); 
           var col11 = $(this).find('td:eq(11)'); 
           var value11 = parseFloat(col11.text()).toFixed(0); 
           col11.text(value11); 
           var col13 = $(this).find('td:eq(13)'); 
           var value13 = parseFloat(col13.text()).toFixed(0); 
           col13.text(value11); 
       }); 
    var $tabla = $('#resultsTable'); 
    var $tfoot = $('<tfoot><tr><td>Total</td></tr></tfoot>'); 
    for (var i = 1; i <= 14; i++) { 
        var total = 0; 
        $tabla.find('tbody tr').each(function() { 
            var $td = $(this).find('td:eq(' + i + ')'); 
            var valor = parseFloat($td.text()); 
            if (!isNaN(valor)) { 
                total += valor; 
            } 
            if (i % 2 === 0) { 
                $td.addClass('precio'); 
            } 
        }); 
        var $totalTd = $('<td>' + total + '</td>'); 
        if (i % 2 === 0) { 
            $totalTd.addClass('precio'); 
        } 
        $tfoot.find('tr').append($totalTd); 
    } 
    $tabla.append($tfoot); 
      $('#resultsTable tbody tr').each(function(){
     $(this).find('td').eq(2).addClass('precio');  
     $(this).find('td').eq(4).addClass('precio');  
     $(this).find('td').eq(6).addClass('precio');  
     $(this).find('td').eq(8).addClass('precio');  
     $(this).find('td').eq(10).addClass('precio');  
     $(this).find('td').eq(12).addClass('precio');
     $(this).find('td').eq(14).addClass('precio');
      });  
var precios = document.querySelectorAll(".precio");
 precios.forEach(function(precio) {
 var valor = parseFloat(precio.textContent);
 if (isNaN(valor)) { 
  precio.textContent = precio.textContent;
 } else { 
  precio.textContent = valor.toLocaleString("en-US", { style: "currency", currency: "USD" });
 } 
 });
     $("#Resumen").on("click", function() {               
         var valores = []; 
         $("#resultsTable tfoot tr td").each(function(index) {                
           if (index >= 1 && index <= 14) { 
            valores.push($(this).text());
         } 
        }); 
       var nombresCampos = [
            "numero_items", "Valor_items", "activos", "valor_activos", "descontinuados", "valor_descontinuados", 
            "activos_para_la_compra", "valor_activos_para_la_compra", 
            "inactivos_para_la_compra", "valor_inactivos_para_la_compra", 
            "sobrepedido", "valor_sobrepedido", 
             "sin_sobrepedido", "valor_sin_sobrepedido" 
       ]; 
       var valoresReordenados = [
           valores[0], valores[1], valores[2], valores[3], valores[12], valores[13], 
            valores[4], valores[5], valores[6], valores[7], 
            valores[8], valores[9], valores[10], valores[11] 
      ]; 
        var colores = [
          "#4a915b", "#74c086", "#296597", "#749dc0", "#296597", "#749dc0", 
          "#ae4d0b", "#e78c4d", "#ae4d0b", "#e78c4d", "#7e33a7", "#a15fc6", 
          "#7e33a7", "#a15fc6"
      ]; 
        var tablaHTML = "<table style=\'width:100%;border-collapse:collapse;border:1px solid black;\'><tr><th></th><th></th></tr>"; 
        for (var i = 0; i < nombresCampos.length; i++) { 
          var colorFondo = colores[i]; 
          tablaHTML += "<tr style=\'background-color:" + colorFondo + ";\'>" + 
                       "<td style=\'border:1px solid black;padding:5px;text-align:left;\'>" + nombresCampos[i] + "</td>" + 
                       "<td style=\'border:1px solid black;padding:5px;text-align:left;\'>" + valoresReordenados[i] + "</td></tr>"; 
      } 
      tablaHTML += "</table>"; 
      Swal.fire({ 
        title: "Totales :", 
        html: tablaHTML, 
        confirmButtonText: "Aceptar" 
      }); 
    }); 
   var table = document.getElementById("resultsTable"); 
   for (var i = 1; i < table.rows.length; i++) { 
     for (var j = 1; j <= 14; j++) { 
       table.rows[i].cells[j].style.backgroundColor = obtenerColor(j); 
     } 
   } 
   function obtenerColor(indice) { 
     const colores = ["#4a915b", "#74c086", "#296597", "#749dc0", "#ae4d0b", "#e78c4d", "#ae4d0b", "#e78c4d", "#7e33a7", "#a15fc6", "#7e33a7", "#a15fc6", "#296597", "#749dc0"]; 
     return colores[indice - 1];  
   } 
   }); 
      
 </script>
