<?php 
date_default_timezone_set('America/Mexico_City');
# Fecha como segundos
//$tiempoInicio = strtotime($fechaInicio);
//$tiempoFin = strtotime($fechaFin);
# 24 horas * 60 minutos por hora * 60 segundos por minuto


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

$obj = clientes([ "consulta" => "mapeo"]);
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
<style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        tfoot th { background-color: #f4f4f4; }
    </style>
<div class="tablas">
<table class="display nowrap table table-sm table-bordered table-hover table-responsive-sm" style="text-align: center; width:100%" id="mydatatable" >
	<thead >
		<tr>
			<th>cliente</th>
            <th>codigo_postal</th>
            <th>municipio</th>
            <th>asentamiento</th>
            <th>codigo_postal_registrado</th>
            <th>municipio_registrado</th>
            <th>colonia</th>
            <th>calle</th>
            <th>venta</th>
            <th>utilidad</th>
            <th>porcentaje_utilidad</th>

            <th>estado</th>
            <th>sucursal</th>
            <th>vendedor</th>
       

		</tr>
	</thead>
	<tbody >
		
               
                <?php 
            for ($i=0; $i < count($obj); $i++) { 
                $clientes1=$obj[$i];
                for ($ii=0; $ii < count($clientes1); $ii++) {
					
                 
		?>
                <tr>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'cliente'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'codigo_postal'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'municipio'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'asentamiento'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'codigo_postal_registrado'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'municipio_registrado'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'colonia'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'calle'}; ?></td>
                    

                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'venta'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'utilidad'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'porcentaje_utilidad'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'estado'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'sucursal'}; ?></td>
                    <td style="text-align:left" ><?php echo $clientes1[$ii]->{'vendedor'}; ?></td>

                </tr>
        <?php   
                }
            } 
        ?>
      
	</tbody>
    <tfoot id="pue_depagina">
	
    </tfoot>
</table>
</div>
<script type="text/javascript">
 	 	$(document).ready(function(){
        
		$('#mydatatable').DataTable({
            "dom": "<\'row dom_wrapper fh-fixedHeader\'<\'col-sm col-md\'><\'col-sm col-md\'><\'col-sm col-md\'><\'col-sm col-md\'>f>" +"<\'row\'<\'col-sm col-md\'tr>>" +"<\'row\'<\'col-sm col-md\'i><\'col-sm col-md\'>>",
            "lengthMenu": [[ -1], [ "Todos"]],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "order": [
                [0, "asc"]
            ], 
            "initComplete": function(){swal.close()},       
       
        });
      

     
 	});
     function sumarColumna() {
  // Obtén la tabla y el cuerpo de la tabla
   // Selecciona todas las filas del cuerpo de la tabla
   var suma = 0;
   var suma1 = 0;
   var suma2 = 0;
   var suma3 = 0;


   var suma4 = 0;
   var suma5 = 0;
   var suma6 = 0;
   var suma7 = 0;

   var suma8 = 0;
   var suma9 = 0;
    $('#mydatatable tbody tr').each(function() {
      // Obtiene el valor de la celda con índice 1
      var valor = parseFloat($(this).find('td').eq(1).text());
      if (!isNaN(valor)) {
        suma += valor;
      }
      var valor1 = parseFloat($(this).find('td').eq(2).text());
      if (!isNaN(valor1)) {
        suma1 += valor1;
      }
      var valor2 = parseFloat($(this).find('td').eq(3).text());
      if (!isNaN(valor2)) {
        suma2 += valor2;
      }
      var valor3 = parseFloat($(this).find('td').eq(4).text());
      if (!isNaN(valor3)) {
        suma3 += valor3;
      }


      var valor4 = parseFloat($(this).find('td').eq(5).text());
      if (!isNaN(valor4)) {
        suma4 += valor4;
      }
      var valor5 = parseFloat($(this).find('td').eq(6).text());
      if (!isNaN(valor5)) {
        suma5 += valor5;
      }
      var valor6 = parseFloat($(this).find('td').eq(7).text());
      if (!isNaN(valor6)) {
        suma6 += valor6;
      }
      var valor7 = parseFloat($(this).find('td').eq(8).text());
      if (!isNaN(valor7)) {
        suma7 += valor7;
      }


    var valor8 = parseFloat($(this).find('td').eq(9).text());
      if (!isNaN(valor8)) {
        suma8 += valor8;
      }
      var valor9 = parseFloat($(this).find('td').eq(10).text());
      if (!isNaN(valor9)) {
        suma9 += valor9;
      }
    });

  
            var formattedNumber = formatCurrencyMXN(suma);
            var formattedNumber1 = formatCurrencyMXN(suma1);
            var formattedNumber2 = formatCurrencyMXN(suma2);
            var formattedNumber4 = formatCurrencyMXN(suma4);
            var formattedNumber5 = formatCurrencyMXN(suma5);
            var formattedNumber6 = formatCurrencyMXN(suma6);
  // Muestra el resultado en el elemento con id 'resultado'
  
  var phpMonth = "<?php echo $month; ?>";
  console.log( phpMonth);
  var texto="";
  var divisor=0;
  if(parseInt(phpMonth)==9){
    divisor=8;
     texto = '<th style="text-align:left">'+parseFloat(suma8/divisor).toFixed(2)+'%</th>'+
			'<th style="text-align:left">'+parseFloat(suma9/divisor).toFixed(2)+'%</th>';
}else{
    divisor=7;
	     texto = '<th style="text-align:left">'+parseFloat(suma8/divisor).toFixed(2)+'%</th>'+
			'<th style="text-align:left">'+parseFloat(suma9/divisor).toFixed(2)+'%</th>';
}
console.log(divisor);
  $("#pue_depagina").append('<tr>	'+
            '<th style="text-align:left">Total: </th>'+
            '<th style="text-align:left">'+formattedNumber+'</th>'+
			'<th style="text-align:left">'+formattedNumber1+'</th>'+
			'<th style="text-align:left">'+formattedNumber2+'</th>'+

			'<th style="text-align:left">'+parseFloat((suma2/suma1)*100).toFixed(2)+'%</th>'+

			'<th style="text-align:left">'+formattedNumber4+'</th>'+
			'<th style="text-align:left">'+formattedNumber5+'</th>'+
			'<th style="text-align:left">'+formattedNumber6+'</th>'+texto+


			
			'<th style="text-align:left">'+parseFloat((suma6/suma5)*100).toFixed(2)+'%</th>'+

		
			
		'</tr>')
}
function formatCurrencyMXN(amount) {
    return amount.toLocaleString('es-MX', {
        style: 'currency',
        currency: 'MXN',
        minimumFractionDigits: 2
    });
}

sumarColumna() ;
$('.precio').each(function() {
                var value = parseFloat($(this).text().replace(/,/g, '')); // Elimina comas si existen
                if (!isNaN(value)) {
                    $(this).text(value.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })); // Puedes cambiar 'es-ES' y 'EUR' a tu preferencia
                }
            });
 </script>
