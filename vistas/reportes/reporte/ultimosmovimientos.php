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

$obj = clientes([ "consulta" => "Reporte_ultimosMovimientos"]);
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
.fila-roja {
  background-color: red;
  color: white;
}
</style>

<div class="tablas">
<table class="display nowrap table table-sm table-bordered table-hover table-responsive-sm" style="text-align: center; width:100%" id="resultsTable" >
	<thead >
	<tr style="width:33%" role="row">
        <th > <span>Documento</span></th>
        <th > <span>sucursal</span></th>
        <th > <span>Fecha del movimiento</span></th>
        <th > <span>fecha de creasion en netsuite</span></th>

        
    
</tr>
    </thead>
	<tbody >
	<?php 
            for ($i=0; $i < count($obj); $i++) { 
                $clientes1=$obj[$i];
                for ($ii=0; $ii < count($clientes1); $ii++) {
        ?>
                <tr>
                    
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'tranid'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'fullname'}; ?></td>
                 
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'fecha_del_movimiento'}; ?></td>
                    <td id="fecha-<?php echo $ii; ?>" style="text-align:left"><?php echo $clientes1[$ii]->{'fecha_de_creado_netsuite'}; ?></td>

                </tr>
        <?php   }
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
      function actualizarTabla() {
  const tabla = document.getElementById('resultsTable');
  const filas = tabla.getElementsByTagName('tr');
  
  // Recorremos las filas de la tabla (ignoramos la primera fila de encabezados)
  for (let i = 1; i < filas.length; i++) {
    const celdaFecha = filas[i].cells[2]; // Columna 3
    const fechaHora = celdaFecha.textContent.trim();
    
    // Convertimos la fecha y hora a un objeto Date
    const fecha = new Date(fechaHora.split(' ')[0].split('-').reverse().join('-') + 'T' + fechaHora.split(' ')[1]);
console.log(fecha);
    // Obtenemos el tiempo actual
    const ahora = new Date();
    console.log(ahora);
    // Calculamos la diferencia en minutos
    const diferenciaMinutos = (ahora - fecha) / 60000;

    // Si han pasado más de 30 minutos, pintamos la fila de rojo
    if (diferenciaMinutos > 30) {
      filas[i].classList.add('fila-roja');
    } else {
      filas[i].classList.remove('fila-roja');
    }
  }
}

// Llamamos a la función para actualizar la tabla
actualizarTabla();

// Si deseas que se actualice en intervalos regulares (por ejemplo, cada minuto), puedes hacerlo así:
setInterval(actualizarTabla, 60000);

   }); 
      

</script>

