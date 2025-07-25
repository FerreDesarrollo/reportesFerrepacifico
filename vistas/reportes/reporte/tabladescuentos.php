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

if($_GET['puesto']=="Jefe de sucursal"){
	$vendedor="";
	$sucursal=$_GET['sucursal'];
}
else{
	$vendedor=$_GET['vendedor'];
	$sucursal="";
}
$obj = clientes([ "consulta" => "descuentos","f_ini" => date('d/m/Y',strtotime($_GET['fechainicial'])),"f_fin" => date('d/m/Y',strtotime($_GET['fechafinal'])),"vendedor" => $vendedor,"sucursal"=>$sucursal]);
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
<table class="display nowrap table table-sm table-bordered table-hover table-responsive-sm" style="text-align: center; width:100%" id="mydatatable" >
	<thead >
		<tr>
			<th>VENDEDOR</th>
			<th>FOLIO MICROSIP</th>
			<th>VENTA</th>
			<th>UTILIDAD</th>
		</tr>
	</thead>
	<tbody >
		<?php 
            for ($i=0; $i < count($obj); $i++) { 
                $clientes1=$obj[$i];
                for ($ii=0; $ii < count($clientes1); $ii++) {
        ?>
                <tr>
                    
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'vendedor'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'folio_microsip'}; ?></td>
                    <td style="text-align:right"><?php echo "$".number_format(($clientes1[$ii]->{'venta'}),2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad'},2) ?></td>
                   
                </tr>
        <?php   }
            }
        ?>
	</tbody>
   <tfoot>
		<tr>
			<th style="text-align:right"></th>
			<th style="text-align:right"></th>
			<th style="text-align:right"></th>	
			<th style="text-align:right"></th>	
				
		</tr>
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
            "footerCallback": function (row, data, start, end, display) {
				var api = this.api();

				// Remove the formatting to get integer data for summation
				var intVal = function (i) {
				    return typeof i === "string" ? i.replace(/[\$,]/g, "") * 1 : typeof i === "number" ? i : 0;
				};

				
                
					// Total over this page
						pageTotal2 = api
							.column(2, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(2).footer()).html("Suma de total bombeo");
						$(api.column(2).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal2) + "</b> ");
				// Total over all pages
				/*		total = api
							.column(3)
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);*/

					// Total over this page
						pageTotal3 = api
							.column(3, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(3).footer()).html("Suma de total bombeo");
						$(api.column(3).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal3) + "</b> ");
				// Total over all pages
				/*		total = api
							.column(3)
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);*/
				
            }
        });
        /*function llenartabla(){
			
			$.ajax({
				type:"POST",
				data:"datoscred",
				url:"../procesos/credito/obtenerdatoscred.php",
				success:function(r){
					console.log(r)
                    var clientes=$.parseJSON(r);
					
					let ar=clientes[0].split(' - ');
					console.log(ar)	
						
					var lista=[];
					for (var i = 0; i < clientes.length; i++) {
						let ar=clientes[i].split(' - ');
						nuevoTr = "<tr>\
                            <td>"+ar[0]+" "+ar[1]+"</td>\
                            <td>"+ar[3]+"</td>\
                            <td>"+ar[2]+"</td>\
                            </tr>";
                        $('#mydatatable').append(  nuevoTr );
					}
                    
				}
			});
		}
        llenartabla();*/
 	});
 </script>
