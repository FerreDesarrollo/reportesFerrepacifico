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
  
        $fechainicio = strtotime($fechainicio);
    
    
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
	$year.'-01-10', //Navidad
	$year.'-18-11', //Navidad
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
$obj = clientes([ "consulta" => "comision","f_ini" => date('d/m/Y',strtotime($_GET['fechainicial'])),"f_fin" => date('d/m/Y',strtotime($_GET['fechafinal'])),"vendedor" => $vendedor,"sucursal"=>$sucursal]);
$obj=json_decode($obj);
//print_r($obj);
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
			<th>VENTA PROMEDIO TRIMESTRAL</th>
			<th>VENTA OBJETIVO MENSUAL</th>
			<th>VENTA OBJETIVO AL DIA</th>
			<th>VENTA REAL AL DIA</th>
            <th>PORCENTAJE DE VENTA</th>
			<th>UTILIDAD PROMEDIO TRIMESTRAL</th>
            <th>UTILIDAD OBJETIVO MENSUAL</th>
			<th>UTILIDAD OBJETIVO AL DIA</th>
			<th>UTILIDAD REAL AL DIA</th>
            <th>PORCENTAJE DE UTILIDAD</th>
			<th>VENTA CLASIFICACIÓN A</th>
			<th>UTILIDAD CLASIFICACIÓN A</th>
			<th>A S/U</th>
            <th>VENTA CLASIFICACIÓN B</th>
			<th>UTILIDAD CLASIFICACIÓN B</th>
			<th>B S/U</th>
            <th>VENTA CLASIFICACIÓN C</th>
			<th>UTILIDAD CLASIFICACIÓN C</th>
			<th>C S/U</th>
            <th>VENTA TOP LOW</th>
			<th>UTILIDAD TOP LOW</th>
			<th>TOP LOW S/V</th>
            <th>VENTA ARTICULO NUEVO</th>
			<th>UTILIDAD ARTICULO NUEVO</th>
			<th>AN S/V</th>
            <th>VENTA CLIENTE NUEVO</th>
			<th>UTILIDAD CLIENTE NUEVO</th>
			<th>CN S/U</th>
			<th>VENTA CLASIFICACIÓN</th>
			<th>UTILIDAD CLASIFICACIÓN</th>
			<th>X S/U</th>
			<th>NOTAS CREDITO</th>
			<th>VENTA PS</th>
			<th>UTILIDAD PS</th>
			<th>BONO PS</th>
			<th>BONO</th>
			<th>COMISIÓN</th>
		</tr>
	</thead>
	<tbody >
		<?php 
            for ($i=0; $i < count($obj); $i++) { 
                $clientes1=$obj[$i];
                for ($ii=0; $ii < count($clientes1); $ii++) {
					// Para el cálculo de porcentaje
$denominador1 = ($clientes1[$ii]->{'venta_objetivo_mensual'} / count($diastotal)) * count($diastranscurridos);
if ($denominador1 != 0) {
    $porcentaje = number_format(($clientes1[$ii]->{'venta_real_al_dia'} / $denominador1) * 100, 2);
} else {
    $porcentaje = 0; // o el valor que desees asignar cuando la división es por cero
}

// Para el cálculo de porcentaje2
$denominador2 = ($clientes1[$ii]->{'utilidad_objetivo_mensual'} / count($diastotal)) * count($diastranscurridos);
if ($denominador2 != 0) {
    $porcentaje2 = number_format(($clientes1[$ii]->{'utilidad_real_al_dia'} / $denominador2) * 100, 2);
} else {
    $porcentaje2 = 0; // o el valor que desees asignar cuando la división es por cero
}

// Para el cálculo de bono2
if ($clientes1[$ii]->{'venta_ps'} != 0) {
    $bono2 = $clientes1[$ii]->{'venta_ps'} / 50000;
} else {
    $bono2 = 0; // o el valor que desees asignar cuando la venta_ps es cero
}
					if (intval($bono2)>=1) {
						$bono2=(intval($bono2)*1000)+1000;
					}
					else{
						$bono2=0;
					}
					if ($porcentaje<=89.99) {
						$color="#FF0000";
						$bono=0;
						$comision=0;
					}
					else if ($porcentaje>=90 && $porcentaje<=99.99) {
						$color="#F2FF00";
						$bono=2500;
						
					}
					else if ($porcentaje>=100 && $porcentaje<=109.99) {
						$color="#00FF2A";
						$bono=5000;
					}
					else {
						$color="#00FF2A";
						$bono=7000;
					}
					if ($porcentaje2<=89.99) {
						$color2="#FF0000";
					}
					else if ($porcentaje2>=90 && $porcentaje2<=99.99) {
						$color2="#F2FF00";
					}
					else {
						$color2="#00FF2A";
					}
					if($porcentaje>=80){
						$comision=($clientes1[$ii]->{'utilidad_clasificacion_a'}*$clientes1[$ii]->{'a'})+($clientes1[$ii]->{'utilidad_clasificacion_b'}*$clientes1[$ii]->{'b'})+($clientes1[$ii]->{'utilidad_clasificacion_c'}*$clientes1[$ii]->{'c'})+($clientes1[$ii]->{'venta_top_low'}*$clientes1[$ii]->{'toplow'})+($clientes1[$ii]->{'venta_articulo_nuevo'}*$clientes1[$ii]->{'an'})+($clientes1[$ii]->{'utilidad_cliente_nuevo'}*$clientes1[$ii]->{'cn'})+($clientes1[$ii]->{'utilidad_clasificacion'}*$clientes1[$ii]->{'x'})+$bono+$bono2;
					}
		?>
                <tr>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'vendedor'}; ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_promedio_trimestral'}, 2); ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_objetivo_mensual'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format(($clientes1[$ii]->{'venta_objetivo_mensual'}/count($diastotal))*count($diastranscurridos),2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_real_al_dia'},2) ?></td>
                    <td style="text-align:right;background-color:<?php echo $color ?>"><?php echo $porcentaje."%" ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_promedio_trimestral'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_objetivo_mensual'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format(($clientes1[$ii]->{'utilidad_objetivo_mensual'}/count($diastotal))*count($diastranscurridos),2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_real_al_dia'},2) ?></td>
                    <td style="text-align:right;background-color:<?php echo $color2 ?>"><?php echo $porcentaje2."%" ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_clasificacion_a'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_clasificacion_a'},2) ?></td>
                    <td style="text-align:right"><?php echo number_format($clientes1[$ii]->{'a'}*100,2)."%" ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_clasificacion_b'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_clasificacion_b'},2) ?></td>
                    <td style="text-align:right"><?php echo number_format($clientes1[$ii]->{'b'}*100,2)."%" ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_clasificacion_c'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_clasificacion_c'},2) ?></td>
                    <td style="text-align:right"><?php echo number_format($clientes1[$ii]->{'c'}*100,2)."%" ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_top_low'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_top_low'},2) ?></td>
                    <td style="text-align:right"><?php echo number_format($clientes1[$ii]->{'toplow'}*100,2)."%" ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_articulo_nuevo'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_articulo_nuevo'},2) ?></td>
                    <td style="text-align:right"><?php echo number_format($clientes1[$ii]->{'an'}*100,2)."%" ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_cliente_nuevo'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_cliente_nuevo'},2) ?></td>
                    <td style="text-align:right"><?php echo number_format($clientes1[$ii]->{'cn'}*100,2)."%" ?></td>
					<td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_clasificacion'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_clasificacion'},2) ?></td>
                    <td style="text-align:right"><?php echo number_format($clientes1[$ii]->{'x'}*100,2)."%" ?></td>
                    <td style="text-align:right"><?php echo "$".number_format(($clientes1[$ii]->{'utilidad_clasificacion'}*$clientes1[$ii]->{'x'}),2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'venta_ps'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($clientes1[$ii]->{'utilidad_ps'},2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($bono2,2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($bono,2) ?></td>
                    <td style="text-align:right"><?php echo "$".number_format($comision,2) ?></td>
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

					// Total over this page
							pageTotal4 = api
								.column(4, { page: "current" })
								.data()
								.reduce(function (a, b) {
								return intVal(a) + intVal(b);
							}, 0);
	
					// Update footer
							$(api.column(4).footer()).html("Suma de total bombeo");
							$(api.column(4).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal4) + "</b> ");
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
				/*		total = api
							.column(3)
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);*/

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
				/*		total = api
							.column(3)
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);*/

				// Total over this page
						pageTotal8 = api
							.column(9, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(9).footer()).html("Suma de total bombeo");
						$(api.column(9).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8) + "</b> ");
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
				/*		total = api
							.column(3)
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);*/

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
							.column(14, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(14).footer()).html("Suma de total bombeo");
						$(api.column(14).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal11) + "</b> ");
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
							.column(17, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(17).footer()).html("Suma de total bombeo");
						$(api.column(17).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal13) + "</b> ");
				// Total over this page
						pageTotal14 = api
							.column(18, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(18).footer()).html("Suma de total bombeo");
						$(api.column(18).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal14) + "</b> ");
				// Total over this page
						pageTotal15 = api
							.column(20, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(20).footer()).html("Suma de total bombeo");
						$(api.column(20).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal15) + "</b> ");
				// Total over this page
						pageTotal16 = api
							.column(21, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(21).footer()).html("Suma de total bombeo");
						$(api.column(21).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal16) + "</b> ");
				// Total over this page
						pageTotal17 = api
							.column(23, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(23).footer()).html("Suma de total bombeo");
						$(api.column(23).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal17) + "</b> ");
				// Total over this page
						pageTotal18 = api
							.column(24, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(24).footer()).html("Suma de total bombeo");
						$(api.column(24).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal18) + "</b> ");
				// Total over this page
						pageTotal19 = api
							.column(26, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(26).footer()).html("Suma de total bombeo");
						$(api.column(26).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal19) + "</b> ");
				// Total over this page
						pageTotal20 = api
							.column(27, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(27).footer()).html("Suma de total bombeo");
						$(api.column(27).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal20) + "</b> ");
				// Total over this page
						pageTotal21 = api
							.column(29, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(29).footer()).html("Suma de total bombeo");
						$(api.column(29).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal21) + "</b> ");
				// Total over this page
						pageTotal22 = api
							.column(30, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(30).footer()).html("Suma de total bombeo");
						$(api.column(30).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal22) + "</b> ");
				// Total over this page
						pageTotal22 = api
							.column(32, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(32).footer()).html("Suma de total bombeo");
						$(api.column(32).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal22) + "</b> ");
				// Total over this page
						pageTotal22 = api
							.column(33, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(33).footer()).html("Suma de total bombeo");
						$(api.column(33).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal22) + "</b> ");
				// Total over this page
				pageTotal22 = api
							.column(34, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(34).footer()).html("Suma de total bombeo");
						$(api.column(34).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal22) + "</b> ");
						pageTotal22 = api
							.column(35, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(35).footer()).html("Suma de total bombeo");
						$(api.column(35).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal22) + "</b> ");
						pageTotal22 = api
							.column(36, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(36).footer()).html("Suma de total bombeo");
						$(api.column(36).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal22) + "</b> ");
						pageTotal22 = api
							.column(37, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(37).footer()).html("Suma de total bombeo");
						$(api.column(37).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal22) + "</b> ");
				// Update footer
						$(api.column(5).footer()).html("Suma de total bombeo");
						$(api.column(5).footer()).html(" <b>" + $.fn.dataTable.render.number(",", ".", 2, "").display((pageTotal4/pageTotal3)*100) + "%</b> ");
						$(api.column(10).footer()).html("Suma de total bombeo");
						$(api.column(10).footer()).html(" <b>" + $.fn.dataTable.render.number(",", ".", 2, "").display((pageTotal8/pageTotal7)*100) + "%</b> ");
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
