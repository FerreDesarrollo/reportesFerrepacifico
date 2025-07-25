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
$dias_transcurridos=  $_GET['dias_transcurridos'] ;
$dias_del_mes=  $_GET['dias_del_mes'] ;

$sucursal=  $_GET['sucursal'] ;
$solucion=  $_GET['solucion'] ;
$grupo=  $_GET['grupo'] ;
$linea=  $_GET['linea'] ;
$sublinea=  $_GET['sublinea'] ;
 $Estatus=  $_GET['Estatus'] ;
  $sobrepedido=  $_GET['sobrepedido'] ;
   $Proveedor=  $_GET['Proveedor'] ;
    $Proveedo_A_compra=  $_GET['Proveedo_A_compra'] ;
     $Proveedor_in_C=  $_GET['Proveedor_in_C'] ;
      $comprador=  $_GET['comprador'] ;
       $marca=  $_GET['marca'] ;
        $estatus_proveedor=  $_GET['estatus_proveedor'] ;
        $codigo_upc=  $_GET['codigo_upc'] ;
$obj = clientes([ "consulta" => "Catalogo_Ferre","f_ini" => date('d/m/Y',strtotime($_GET['fechainicial'])),"f_fin" => date('d/m/Y',strtotime($_GET['fechafinal'])),"sucursal" =>$sucursal,"solucion" =>$solucion,"grupo" =>$grupo,"linea" =>$linea,"sublinea" =>$sublinea,"Estatus" =>$Estatus,"sobrepedido" =>$sobrepedido,"Proveedor" =>$Proveedor,"Proveedo_A_compra" =>$Proveedo_A_compra,"Proveedor_in_C" =>$Proveedor_in_C,"comprador" =>$comprador,"marca" =>$marca,"estatus_proveedor" =>$estatus_proveedor,"codigo_upc" =>$codigo_upc]);
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
        <th > <span>codigo</span></th>
        <th > <span>articulo</span></th>
        <th > <span>cantidad</span></th>
        <th > <span>venta</span></th>
        <th > <span>utilidad_ps</span></th>
        <th > <span>utilidad_porcent</span></th>
        <th > <span>stock</span></th>
        <th > <span>stock_ps</span></th>
        <th > <span>dias_inv</span></th>
        <th > <span>comprador</span></th>
        <th > <span>participacion de venta</span></th>
        <th > <span>participacion de stock</span></th>
        
    
</tr>
    </thead>
    <tbody>
    <?php 
        // Verificar si las funciones ya están declaradas para evitar errores
        if (!function_exists('format_number')) {
            function format_number($num) {
                return number_format($num); // Formato con separadores de miles
            }
        }

        if (!function_exists('format_money')) {
            function format_money($num) {
                return '$' . number_format($num, 2, '.', ','); // Formato de moneda
            }
        }

        if (!function_exists('format_percent')) {
            function format_percent($num) {
                return number_format($num, 2) . '%'; // Formato de porcentaje
            }
        }

        // Inicializamos las variables para los totales
        $total_cantidad = 0;
        $total_venta = 0;
        $total_utilidad_ps = 0;
        $total_stock = 0;
        $total_stock_ps = 0;

        // Calcular el total de ventas y stock_ps antes de mostrar las filas
        for ($i = 0; $i < count($obj); $i++) { 
            $clientes1 = $obj[$i];
            for ($ii = 0; $ii < count($clientes1); $ii++) {
                $venta = isset($clientes1[$ii]->{'venta'}) ? $clientes1[$ii]->{'venta'} : 0;
                $stock_ps = isset($clientes1[$ii]->{'stock_ps'}) ? $clientes1[$ii]->{'stock_ps'} : 0;
                // Acumulamos los totales
                $total_venta += $venta;
                $total_stock_ps += $stock_ps;
            }
        }

        // Ahora recorremos de nuevo para mostrar las filas
        for ($i = 0; $i < count($obj); $i++) { 
            $clientes1 = $obj[$i];
            for ($ii = 0; $ii < count($clientes1); $ii++) {
                // Asegurarnos de que los valores existen antes de sumarlos
                $cantidad = isset($clientes1[$ii]->{'cantidad'}) ? $clientes1[$ii]->{'cantidad'} : 0;
                $venta = isset($clientes1[$ii]->{'venta'}) ? $clientes1[$ii]->{'venta'} : 0;
                $utilidad_ps = isset($clientes1[$ii]->{'utilidad_ps'}) ? $clientes1[$ii]->{'utilidad_ps'} : 0;
                $stock = isset($clientes1[$ii]->{'stock'}) ? $clientes1[$ii]->{'stock'} : 0;
                $stock_ps = isset($clientes1[$ii]->{'stock_ps'}) ? $clientes1[$ii]->{'stock_ps'} : 0;

                // Acumulamos los totales
                $total_cantidad += $cantidad;
                $total_utilidad_ps += $utilidad_ps;
                $total_stock += $stock;

                // Calcular la participación de venta
                $participacion_venta = $total_venta > 0 ? ($venta / $total_venta) * 100 : 0;
                // Calcular la participación de stock_ps
                $participacion_stock_ps = $total_stock_ps > 0 ? ($stock_ps / $total_stock_ps) * 100 : 0;
    ?>
                <tr>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'codigo'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'articulo'}; ?></td>
                    <td style="text-align:left"><?php echo format_number($cantidad); ?></td>
                    <td style="text-align:left"><?php echo format_money($venta); ?></td>
                    <td style="text-align:left"><?php echo format_money($utilidad_ps); ?></td>
                    <td style="text-align:left"><?php echo format_percent($clientes1[$ii]->{'utilidad_porcent'}); ?></td>
                    <td style="text-align:left"><?php echo format_number($stock); ?></td>
                    <td style="text-align:left"><?php echo format_money($stock_ps); ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'dias_inv'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'comprador'}; ?></td>
                    <!-- Nueva columna de participación de venta -->
                    <td style="text-align:left"><?php echo format_percent($participacion_venta); ?></td>
                    <!-- Nueva columna de participación de stock_ps -->
                    <td style="text-align:left"><?php echo format_percent($participacion_stock_ps); ?></td>
                </tr>
    <?php   
            }
        }
    ?>
</tbody>

<tfoot id="ttf">
    <tr>
        <td colspan="2" style="text-align:right; font-weight:bold;">Totales</td>
        <td style="text-align:left; font-weight:bold;"><?php echo format_number($total_cantidad); ?></td>
        <td style="text-align:left; font-weight:bold;"><?php echo format_money($total_venta); ?></td>
        <td style="text-align:left; font-weight:bold;"><?php echo format_money($total_utilidad_ps); ?></td>
        <td style="text-align:left; font-weight:bold;">&nbsp;</td> <!-- La columna de porcentaje no tiene total -->
        <td style="text-align:left; font-weight:bold;"><?php echo format_number($total_stock); ?></td>
        <td style="text-align:left; font-weight:bold;"><?php echo format_money($total_stock_ps); ?></td>
        <td style="text-align:left; font-weight:bold;">&nbsp;</td> <!-- La columna de días no tiene total -->
        <td style="text-align:left; font-weight:bold;">&nbsp;</td> <!-- La columna de comprador no tiene total -->
        <!-- Nueva columna de participación de venta total -->
        <td style="text-align:left; font-weight:bold;"><?php echo format_percent(100); ?></td> <!-- El total es 100% -->
        <!-- Nueva columna de participación de stock_ps total -->
        <td style="text-align:left; font-weight:bold;"><?php echo format_percent(100); ?></td> <!-- El total es 100% -->
    </tr>
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
      
 </script>
