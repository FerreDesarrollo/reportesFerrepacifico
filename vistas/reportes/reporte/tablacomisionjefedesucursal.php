<?php 
date_default_timezone_set('America/Mexico_City');
# Fecha como segundos
//$tiempoInicio = strtotime($fechaInicio);
//$tiempoFin = strtotime($fechaFin);
# 24 horas * 60 minutos por hora * 60 segundos por minuto
$dia = 86400;
$f=explode("-",$_GET['fechainicial']);
$year=$f[0];
$month=$f[1];
function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
    // Convirtiendo en timestamp las fechas
    $fechainicio = strtotime($fechainicio);
    $fechafin = strtotime($fechafin);
   
    // Incremento en 1 dia
    $diainc = 24*60*60;
   
    // Arreglo de dias habiles, inicianlizacion
    $diashabiles = array();
   
    // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
    for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
            // Si el dia indicado, no es sabado o domingo es habil
            if (!in_array(date('N', $midia), array(7))) { // DOC: http://www.php.net/manual/es/function.date.php
                    // Si no es un dia feriado entonces es habil
                    if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                            array_push($diashabiles, date('Y-m-d', $midia));
                    }
            }
    }
   
    return $diashabiles;
}
function diastranscurridos($fechainicio, $fechafin, $diasferiados = array()) {
    // Verificamos si la fecha de inicio es el 1 de octubre de 2024
    if (date('Y-m-d', strtotime($fechainicio)) == '2024-10-01') {
        // Si es el 1 de octubre de 2024, empezamos desde el 2 de octubre
        $fechainicio = strtotime($fechainicio . ' +1 day');
    } else {
        // Si no es el 1 de octubre de 2024, usamos la fecha de inicio tal cual
        $fechainicio = strtotime($fechainicio);
    }
    
    $fechafin = strtotime($fechafin);

    // Incremento en 1 día
    $diainc = 24*60*60;

    // Arreglo de días hábiles, inicialización
    $diashabiles = array();

    // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 día
    for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
        // Si el día indicado no es domingo es hábil
        if (!in_array(date('N', $midia), array(7))) { 
            // Si no es un día feriado entonces es hábil
            if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                array_push($diashabiles, date('Y-m-d', $midia));
            }
        }
    }

    return $diashabiles;
}

function primerfebrero($years){
    $my_date = new DateTime();
    $my_date->modify('first monday of february '.$years);
    return $my_date->format('Y-m-d');
}
function tercerLunesDeMarzo($years){
    $my_date = new DateTime();
    $my_date->modify('third monday of march '.$years);
    return $my_date->format('Y-m-d');
} // Tercer lunes de marzo
function tercerLunesDeNoviembre($years){
    $my_date = new DateTime();
    $my_date->modify('third monday of november '.$years);
    return $my_date->format('Y-m-d');
} // Tercer lunes de noviembre
$diasFeriados = [
    $year.'-01-01', //Año nuevo
    primerfebrero($year),
    tercerLunesDeMarzo($year),
    $year.'-05-01', //Día del trabajador
    $year.'-09-16', //Declaración de la Independencia,
    tercerLunesDeNoviembre($year),
    //$year.'-12-01', //Depende de periodo electoral
    $year.'-12-25', //Navidad
    /* DIAS SANTOS*/ 
    $year.'-03-28', //Navidad
    $year.'-03-29', //Navidad
    $year.'-03-30', //Navidad
];
function _data_last_month_day($months,$years) { 
    $day = date("d", mktime(0,0,0, $months+1, 0, $years));

    return date('Y-m-d', mktime(0,0,0, $months, $day, $years));
};
//print_r($diasFeriados);
//echo $year;
$diastotal=getDiasHabiles($year.'-'.$month.'-01', _data_last_month_day($month,$year),$diasFeriados );
$diastranscurridos=diastranscurridos($_GET['fechainicial'],$_GET['fechafinal'],$diasFeriados );
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
$obj = clientes([ "consulta" => "comision_jefe","f_ini" => date('d/m/Y',strtotime($_GET['fechainicial'])),"f_fin" => date('d/m/Y',strtotime($_GET['fechafinal'])),"vendedor" => $vendedor,"sucursal"=>$sucursal]);

    // Si no es un array, puedes intentar decodificarlo (aunque debería ser una cadena JSON)
    $obj = json_decode($obj);
   

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
			<th>SUCURSAL</th>
			<th>VENTA ASIGNADA</th>
			<th>VENTA OBJETIVO AL DIA</th>
			<th>VENTA REAL</th>
            <th>PORCENTAJE DE VENTA</th>
            <th>BONO POR CUMPLIMIENTO</th>
            <th>UTILIDAD ASIGNADA</th>
			<th>UTILIDAD OBJETIVO AL DIA</th>
			<th>UTILIDAD REAL</th>
            <th>PORCENTAJE DE UTILIDAD</th>
            <th>BONO POR CUMPLIMIENTO</th>
            <th>TOPLOW ASIGNADA</th>
			<th>TOPLOW OBJETIVO AL DIA</th>
			<th>TOPLOW REAL</th>
            <th>PORCENTAJE DE TOPLOW</th>
            <th>BONO POR CUMPLIMIENTO</th>
            <th>OBJETIVO PACIFIC</th>
			<th>PACIFIC OBJETIVO AL DIA</th>
			<th>PACIFIC REAL</th>
            <th>PORCENTAJE DE PACIFIC</th>
            <th>BONO POR CUMPLIMIENTO</th>
            <th>COMISION</th>
		</tr>
	</thead>
	<tbody >
		<?php 
            for ($i=0; $i < count($obj); $i++) { 
                $clientes1=$obj[$i];
                for ($ii=0; $ii < count($clientes1); $ii++) {
				// Validación para $porcentaje1
$venta_divisor = ($clientes1[$ii]->{'venta'} / count($diastotal));
if ($venta_divisor != 0) {
    $porcentaje1 = number_format(($clientes1[$ii]->{'venta_real'} / ($venta_divisor * count($diastranscurridos))) * 100, 2);
} else {
    // Definir valor alternativo cuando el divisor es cero
    $porcentaje1 = 0; // O el valor que consideres apropiado
}

// Validación para $porcentaje2
$utilidad_divisor = ($clientes1[$ii]->{'utilidad'} / count($diastotal));
if ($utilidad_divisor != 0) {
    $porcentaje2 = number_format(($clientes1[$ii]->{'utilidad_real'} / ($utilidad_divisor * count($diastranscurridos))) * 100, 2);
} else {
    // Definir valor alternativo cuando el divisor es cero
    $porcentaje2 = 0; // O el valor que consideres apropiado
}

// Validación para $porcentaje3
$toplow_divisor = ($clientes1[$ii]->{'toplow'} / count($diastotal));
if ($toplow_divisor != 0) {
    $porcentaje3 = number_format(($clientes1[$ii]->{'venta_real_toplow'} / ($toplow_divisor * count($diastranscurridos))) * 100, 2);
} else {
    // Definir valor alternativo cuando el divisor es cero
    $porcentaje3 = 0; // O el valor que consideres apropiado
}

// Validación para $porcentaje4
$obj_pacific_divisor = ($clientes1[$ii]->{'objetivo_pacific'} / count($diastotal));
if ($obj_pacific_divisor != 0) {
    $porcentaje4 = number_format(($clientes1[$ii]->{'venta_real_pacific'} / ($obj_pacific_divisor * count($diastranscurridos))) * 100, 2);
} else {
    // Definir valor alternativo cuando el divisor es cero
    $porcentaje4 = 0; // O el valor que consideres apropiado
}
   for ($i=1; $i < 5; $i++) { 
                        if($i==1 || $i==2){
                            if(${"porcentaje" . $i}>100){
                                ${"b" . $i}=2500;
                            }
                            elseif(${"porcentaje" . $i}>=95 && ${"porcentaje" . $i}<=100){
                                ${"b" . $i}=2000;
                            }
                            elseif(${"porcentaje" . $i}>=90 && ${"porcentaje" . $i}<95){
                                ${"b" . $i}=1000;
                            }
                            else{
                                ${"b" . $i}=0;
                            }
                        }
                        else{
                            if(${"porcentaje" . $i}>100){
                                ${"b" . $i}=4000;
                            }
                            elseif(${"porcentaje" . $i}>=90 && ${"porcentaje" . $i}<=100){
                                ${"b" . $i}=3000;
                            }
                            elseif(${"porcentaje" . $i}>=80 && ${"porcentaje" . $i}<90){
                                ${"b" . $i}=2000;
                            }
                            else{
                                ${"b" . $i}=0;
                            }
                        }
                    }
                    
					
		?>
                <tr>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'sucursal'}; ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta'}, 2); ?></td>
                    <td style="text-align:right"><?php echo "$".number_format(($clientes1[$ii]->{'venta'}/count($diastotal))*count($diastranscurridos),2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_real'},2) ?></td>
                    <td style="text-align:right;"><?php echo $porcentaje1."%" ?></td>
                    <td style="text-align:right;"><?php echo "$".number_format($b1,2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format(($clientes1[$ii]->{'utilidad'}/count($diastotal))*count($diastranscurridos),2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_real'},2) ?></td>
                    <td style="text-align:right;"><?php echo $porcentaje2."%" ?></td>
                    <td style="text-align:right;"><?php echo "$".number_format($b2,2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'toplow'}, 2); ?></td>
                    <td style="text-align:right"><?php echo "$".number_format(($clientes1[$ii]->{'toplow'}/count($diastotal))*count($diastranscurridos),2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_real_toplow'},2) ?></td>
                    <td style="text-align:right;"><?php echo $porcentaje3."%" ?></td>
                    <td style="text-align:right;"><?php echo "$".number_format($b3,2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'objetivo_pacific'}, 2); ?></td>
                    <td style="text-align:right"><?php echo "$".number_format(($clientes1[$ii]->{'objetivo_pacific'}/count($diastotal))*count($diastranscurridos),2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_real_pacific'},2) ?></td>
                    <td style="text-align:right;"><?php echo $porcentaje4."%" ?></td>
                    <td style="text-align:right;"><?php echo "$".number_format($b4,2) ?></td>
                    <td style="text-align:right;"><?php echo "$".number_format($b1+$b2+$b3+$b4,2) ?></td>
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
				pageTotal1 = api
					.column(1, { page: "current" })
					.data()
					.reduce(function (a, b) {
					    return intVal(a) + intVal(b);
                    }, 0);

				// Update footer
				$(api.column(1).footer()).html("Suma de total bombeo");
				$(api.column(1).footer()).html("<b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal1) + "</b> "); 
                
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
				

					// Total over this page
							pageTotal4 = api
								.column(5, { page: "current" })
								.data()
								.reduce(function (a, b) {
								return intVal(a) + intVal(b);
							}, 0);
	
					// Update footer
							$(api.column(5).footer()).html("Suma de total bombeo");
							$(api.column(5).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal4) + "</b> ");
                // Total over this page
						pageTotal5 = api
							.column(6, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(6).footer()).html("Suma de total bombeo");
						$(api.column(6).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal5) + "</b> ");
				// Total over all pages
				

				// Total over this page
						pageTotal6 = api
							.column(7, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(7).footer()).html("Suma de total bombeo");
						$(api.column(7).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal6) + "</b> ");
                // Total over this page
						pageTotal7 = api
							.column(8, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(8).footer()).html("Suma de total bombeo");
						$(api.column(8).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal7) + "</b> ");
				// Total over all pages
				

				// Total over this page
						pageTotal8 = api
							.column(10, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(10).footer()).html("Suma de total bombeo");
						$(api.column(10).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8) + "</b> ");

                // Total over this page
						pageTotal9 = api
							.column(11, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(11).footer()).html("Suma de total bombeo");
						$(api.column(11).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal9) + "</b> ");
				// Total over all pages
				

				// Total over this page
						pageTotal10 = api
							.column(12, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(12).footer()).html("Suma de total bombeo");
						$(api.column(12).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal10) + "</b> ");
                // Total over this page
						pageTotal11 = api
							.column(13, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(13).footer()).html("Suma de total bombeo");
						$(api.column(13).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal11) + "</b> ");
				// Total over all pages
				

				// Total over this page
						pageTotal12 = api
							.column(15, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(15).footer()).html("Suma de total bombeo");
						$(api.column(15).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal12) + "</b> ");

                // Total over this page
						pageTotal13 = api
							.column(16, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(16).footer()).html("Suma de total bombeo");
						$(api.column(16).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal13) + "</b> ");
				// Total over all pages
				

				// Total over this page
						pageTotal14 = api
							.column(17, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(17).footer()).html("Suma de total bombeo");
						$(api.column(17).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal14) + "</b> ");
                // Total over this page
						pageTotal15 = api
							.column(18, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

				// Update footer
						$(api.column(18).footer()).html("Suma de total bombeo");
						$(api.column(18).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal15) + "</b> ");
				// Total over all pages
				

				// Total over this page
						pageTotal16 = api
							.column(20, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(20).footer()).html("Suma de total bombeo");
						$(api.column(20).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal16) + "</b> ");
                // Total over this page
						pageTotal17 = api
							.column(21, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(21).footer()).html("Suma de total bombeo");
						$(api.column(21).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal17) + "</b> ");
               
				// Update footer
						$(api.column(4).footer()).html("Suma de total bombeo");
						$(api.column(4).footer()).html(" <b>" + $.fn.dataTable.render.number(",", ".", 2, "").display((pageTotal3/pageTotal2)*100) + "%</b> ");
						$(api.column(9).footer()).html("Suma de total bombeo");
						$(api.column(9).footer()).html(" <b>" + $.fn.dataTable.render.number(",", ".", 2, "").display((pageTotal7/pageTotal6)*100) + "%</b> ");
                // Update footer
						$(api.column(14).footer()).html("Suma de total bombeo");
						$(api.column(14).footer()).html(" <b>" + $.fn.dataTable.render.number(",", ".", 2, "").display((pageTotal11/pageTotal10)*100) + "%</b> ");
						$(api.column(19).footer()).html("Suma de total bombeo");
						$(api.column(19).footer()).html(" <b>" + $.fn.dataTable.render.number(",", ".", 2, "").display((pageTotal14/pageTotal13)*100) + "%</b> ");
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
