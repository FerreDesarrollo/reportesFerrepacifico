<?php 
date_default_timezone_set('America/Mexico_City');

function clientes($sql){
    if (!defined('NETSUITE_DEPLOYMENT_URL')) {
        define("NETSUITE_DEPLOYMENT_URL", 'https://5017898.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=1034&deploy=1');
    }
    if (!defined('NETSUITE_URL')) {
        define("NETSUITE_URL", 'https://5017898.restlets.api.netsuite.com');
    }
    if (!defined('NETSUITE_REST_URL')) {
        define("NETSUITE_REST_URL", 'https://5017898.restlets.api.netsuite.com/app/site/hosting/restlet.nl');
    }
    if (!defined('NETSUITE_SCRIPT_ID')) {
        define("NETSUITE_SCRIPT_ID", '1034');
    }
    if (!defined('NETSUITE_DEPLOY_ID')) {
        define("NETSUITE_DEPLOY_ID", '1');
    }
    if (!defined('NETSUITE_ACCOUNT')) {
        define("NETSUITE_ACCOUNT", '5017898');
    }
    if (!defined('NETSUITE_CONSUMER_KEY')) {
        define("NETSUITE_CONSUMER_KEY", '7a32d839d61838063cc87fbb2b04a6df1b511bd611b55bde2c5e7b443486b5fa');
    }
    if (!defined('NETSUITE_CONSUMER_SECRET')) {
        define("NETSUITE_CONSUMER_SECRET", '8b3538a523a67911f96b250129d6d293e6b03617433fe32204a68880bbcaa728');
    }
    if (!defined('NETSUITE_TOKEN_ID')) {
        define("NETSUITE_TOKEN_ID", '4c6e59c8ba85c62ec45fbd4bcd21d177ab4e520fffa545b5e29750237f06c329');
    }
    if (!defined('NETSUITE_TOKEN_SECRET')) {
        define("NETSUITE_TOKEN_SECRET", '1ee2bef0c14feaf55cbf29292ac8a0aa36c496d7d8951710d45a0d0150d658a7');
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
$sucursal=$_GET['sucursal'];
$vendors=$_GET['vendors'];
$obj = clientes([ "consulta" => "transacciones_vendedores","f_ini" => date('d/m/Y',strtotime($_GET['fechainicial'])),"f_fin" => date('d/m/Y',strtotime($_GET['fechafinal'])),"vendors" => $vendors,"sucursal"=>$sucursal]);

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
			<th>vendedor</th>
			<th>cliente</th>
            <th>documento</th>


            <th>tipo</th>
			<th>fecha</th>
            <th>venta</th>

            <th>porcentaje_utilidad</th>
			<th>id</th>
      
	</thead>
	<tbody >
		<?php 
            for ($i=0; $i < count($obj); $i++) { 
                $clientes1=$obj[$i];
                for ($ii=0; $ii < count($clientes1); $ii++) {
					
		?>
                <tr>
                    <td style="text-align:left;font-size:15px"><?php echo $clientes1[$ii]->{'vendedor'}; ?></td>
                    <td style="text-align:left;font-size:15px"><?php echo $clientes1[$ii]->{'cliente'}; ?></td>
                    <td style="text-align:left;font-size:15px"><?php echo $clientes1[$ii]->{'documento'}; ?></td>

                    <td style="text-align:left;font-size:15px"><?php echo $clientes1[$ii]->{'tipo'}; ?></td>
                    <td style="text-align:left;font-size:15px"><?php echo $clientes1[$ii]->{'fecha'}; ?></td>
                    <td style="text-align:left;font-size:15px"><?php echo $clientes1[$ii]->{'venta'}; ?></td>

                    <td style="text-align:left;font-size:15px"><?php echo $clientes1[$ii]->{'porcentaje_utilidad'}; ?></td>
                    <td style="text-align:left;font-size:15px"><?php echo $clientes1[$ii]->{'id'}; ?></td>
         
                    
                </tr>
        <?php   
                }
            } 
        ?>
	</tbody>
   <tfoot>
		<tr>
			<th style="text-align:right"></th>
			<th style="text-align:right"></th>
			<th style="text-align:right"></th>	
			<th style="text-align:right"></th>	
			<th style="text-align:right"></th>	
			<th style="text-align:right"></th>	
			<th style="text-align:right"></th>	
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
                [6, "desc"]
            ], 
            "initComplete": function(){swal.close()},       
            "footerCallback": function (row, data, start, end, display) {
				var api = this.api();

				// Remove the formatting to get integer data for summation
				var intVal = function (i) {
				    return typeof i === "string" ? i.replace(/[\$,]/g, "") * 1 : typeof i === "number" ? i : 0;
				};

				// Total over this page
				pageTotal1 = api
					.column(6, { page: "current" })
					.data()
					.reduce(function (a, b) {
					    return intVal(a) + intVal(b);
                    }, 0);

				// Update footer
				$(api.column(6).footer()).html("Suma de total bombeo");
				$(api.column(6).footer()).html("<b></b>" + $.fn.dataTable.render.number(",", ".", 0, "").display(pageTotal1) + "</b> "); 
                
					// Total over this page
						pageTotal2 = api
							.column(7, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(7).footer()).html("Suma de total bombeo");
						$(api.column(7).footer()).html(" <b>" + $.fn.dataTable.render.number(",", ".", 0, "").display(pageTotal2) + "</b> ");
				// Total over all pages
			

					// Total over this page
						pageTotal3 = api
							.column(8, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(8).footer()).html("Suma de total bombeo");
						$(api.column(8).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal3) + "</b> ");
	
							pageTotal4 = api
								.column(9, { page: "current" })
								.data()
								.reduce(function (a, b) {
								return intVal(a) + intVal(b);
							}, 0);
	
					// Update footer
							$(api.column(9).footer()).html("Suma de total bombeo");
							$(api.column(9).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal4) + "</b> ");
                    // Total over this page
						pageTotal5 = api
							.column(10, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(10).footer()).html("Suma de total bombeo");
						$(api.column(10).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal5) + "</b> ");
               
            }
        });
 
 	});
 </script>
