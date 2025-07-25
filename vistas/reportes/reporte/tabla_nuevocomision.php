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
    $year.'-04-18', //Navidad
    $year.'-04-17', //Navidad
    $year.'-04-19', //Navidad
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


$puesto=$_GET['puesto'];
$vent="";

$vendedor=$_GET['vendedor'];

if($puesto=='Jefe de sucursal'){
$vent="99999";
} else {
    $vent=$vendedor;
}


	$sucursal=$_GET['sucursal'];
	$dias_transcurridos1=$_GET['dias_transcurridos'];
    $dias_del_mes1=$_GET['dias_del_mes'];

$obj = clientes([ "consulta" => "Nueva_Ncomicio","f_ini" => date('d/m/Y',strtotime($_GET['fechainicial'])),"f_fin" => date('d/m/Y',strtotime($_GET['fechafinal'])),"vendedor" => $vent,"sucursal"=>$sucursal]);
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
			<th>no empleado</th>
            
			<th>vendedor</th>
            
<th>venta_promedio_trimestral</th>
<th>venta_objetivo_mensual</th>
<th>venta_objetivo_al_dia</th>
<th>venta_real_al_dia</th>
<th>% Venta</th>
<th>utilidad_promedio_trimestral</th>
<th>utilidad_objetivo_mensual</th>
<th>utilidad_objetivo_al_dia</th>
<th>utilidad_real_al_dia</th>
<th>margen_venta</th>
<th>porcentaje_utilidad</th>
<th>bono_venta</th>
<th>pacific_standard</th>
<th>bono_ps</th>
<th>descontinuado</th>
<th>bono_descontinuado</th>
<th>bono_total</th>
<th>marge</th>
            
		</tr>
	</thead>
	<tbody >
		<?php 
            for ($i=0; $i < count($obj); $i++) { 
                $clientes1=$obj[$i];
                for ($ii=0; $ii < count($clientes1); $ii++) {
				
					
		?>

        <?php
    // Obtener valores necesarios
    $venta_real_al_dia       = (float)$clientes1[$ii]->{'venta_real_al_dia'};
    $venta_objetivo_mensual  = (float)$clientes1[$ii]->{'venta_objetivo_mensual'};
    $utilidad_real_al_dia    = (float)$clientes1[$ii]->{'utilidad_real_al_dia'};
    $noempleado              = trim($clientes1[$ii]->{'no_empleado'});

    // Días
    $diastotal = (int)$dias_del_mes1;
    $diastranscurridos = (int)$dias_transcurridos1;

    // Cálculo de porcentaje de cumplimiento (ventas2)
    $ventas2 = 0;
    if ($diastotal > 0) {
        $objetivo_dia = ($venta_objetivo_mensual / $diastotal) * $diastranscurridos;
        if ($objetivo_dia > 0) {
            $ventas2 = ($venta_real_al_dia / $objetivo_dia) * 100;
        }
    }
    $ventas2 = is_numeric($ventas2) ? $ventas2 : 0;

    // Colores por nivel de cumplimiento
    $bgColor = '#FFFFFF'; // color por defecto
    if ($ventas2 <= 79.99) {
        $bgColor = '#FF0000';
    } elseif ($ventas2 <= 89.99) {
        $bgColor = '#F2FF00';
    } elseif ($ventas2 <= 99.99) {
        $bgColor = '#00FF2A';
    } elseif ($ventas2 <= 109.99) {
        $bgColor = '#cdcdcd';
    } elseif ($ventas2 >= 110.00) {
        $bgColor = '#d6af66';
    }

    
?>

               <tr style="background-color: <?php echo $bgColor; ?>;">
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'no_empleado'}; ?></td>
                    
                  <td style="text-align:left"><?php echo $clientes1[$ii]->{'vendedor'}; ?></td>

<td style="text-align:right">
    $<?php echo number_format((float)$clientes1[$ii]->{'venta_promedio_trimestral'}, 2); ?>
</td>

<td style="text-align:right">
    $<?php echo number_format((float)$clientes1[$ii]->{'venta_objetivo_mensual'}, 2); ?>
</td>

<td style="text-align:right">
  <?php
    $venta_objetivo_mensual = $clientes1[$ii]->{'venta_objetivo_mensual'};
    $objetivo_al_dia_calculado = 0;

    // Asegura que ambos valores sean enteros por seguridad
    $diastotal = (int)$dias_del_mes1;
    $diastranscurridos = (int)$dias_transcurridos1;

    if ($diastotal > 0) {
        $objetivo_al_dia_calculado = ($venta_objetivo_mensual / $diastotal) * $diastranscurridos;
    }

    echo '$' . number_format($objetivo_al_dia_calculado, 2);
  ?>
</td>




<td style="text-align:right">
    $<?php echo number_format((float)$clientes1[$ii]->{'venta_real_al_dia'}, 2); ?>
</td>

<td style="text-align:left">
    <?php
        $venta_objetivo_mensual = $clientes1[$ii]->{'venta_objetivo_mensual'};
        $venta_real_al_dia = $clientes1[$ii]->{'venta_real_al_dia'};

        // Seguridad: convertir a números
        $diastotal = (int)$dias_del_mes1;
        $diastranscurridos = (int)$dias_transcurridos1;

        $objetivo_al_dia_calculado = 0;
        $porcentaje = 0;

        if ($diastotal > 0) {
            $objetivo_al_dia_calculado = ($venta_objetivo_mensual / $diastotal) * $diastranscurridos;
        }

        if ($objetivo_al_dia_calculado > 0) {
            $porcentaje = ($venta_real_al_dia / $objetivo_al_dia_calculado) * 100;
        }

        echo number_format($porcentaje, 2) . '%';
    ?>
</td>
<td style="text-align:right">
  <?php echo '$' . number_format($clientes1[$ii]->{'utilidad_promedio_trimestral'}, 2); ?>
</td>

<td style="text-align:right">
  <?php echo '$' . number_format($clientes1[$ii]->{'utilidad_objetivo_mensual'}, 2); ?>
</td>

<td style="text-align:right">
  <?php
    $utilidad_objetivo_mensual = $clientes1[$ii]->{'utilidad_objetivo_mensual'};
    $objetivo_al_dia_calculado = 0;

    $diastotal = (int)$dias_del_mes1;
    $diastranscurridos = (int)$dias_transcurridos1;

    if ($diastotal > 0) {
        $objetivo_al_dia_calculado = ($utilidad_objetivo_mensual / $diastotal) * $diastranscurridos;
    }

    echo '$' . number_format($objetivo_al_dia_calculado, 2);
  ?>
</td>

<td style="text-align:right">
  <?php echo '$' . number_format($clientes1[$ii]->{'utilidad_real_al_dia'}, 2); ?>
</td>

<?php
    // Datos base
    $venta_real_al_dia = (float)$clientes1[$ii]->{'venta_real_al_dia'};
    $venta_objetivo_mensual = (float)$clientes1[$ii]->{'venta_objetivo_mensual'};
    $noempleado = trim($clientes1[$ii]->{'no_empleado'});

    // Convertir días a enteros seguros
    $diastotal = (int)$dias_del_mes1; // Total de días del mes
    $diastranscurridos = (int)$dias_transcurridos1; // Días transcurridos

    // Calcular objetivo al día
    $objetivo_dia = 0;
    if ($diastotal > 0) {
        $objetivo_dia = ($venta_objetivo_mensual / $diastotal) * $diastranscurridos;
    }

    // Calcular porcentaje de avance
    $ventas = 0;
    if ($objetivo_dia > 0) {
        $ventas = ($venta_real_al_dia / $objetivo_dia) * 100;
    }

    // Inicializar variables
    $operacion = 0;
    $bgColor = '#FFFFFF'; // Blanco por defecto
    $especiales = ['811', '3477', '026', '45', '3381', '3504', '2191', '3285', '5'];

    // Lógica de asignación
    if ($ventas <= 79.99) {
        $bgColor = '#FF0000';
        $operacion = in_array($noempleado, $especiales) ? 1.00 : 0.50;
    } elseif ($ventas <= 89.99) {
        $bgColor = '#F2FF00';
        $operacion = in_array($noempleado, $especiales) ? 1.50 : 1.00;
    } elseif ($ventas <= 99.99) {
        $bgColor = '#00FF2A';
        $operacion = in_array($noempleado, $especiales) ? 2.00 : 1.50;
    } elseif ($ventas <= 109.99) {
        $bgColor = '#cdcdcd';
        $operacion = in_array($noempleado, $especiales) ? 2.50 : 2.00;
    } elseif ($ventas >= 110.00) {
        $bgColor = '#d6af66';
        $operacion = in_array($noempleado, $especiales) ? 3.00 : 2.50;
    }

    // Formatear el número
    $operacion_formateada = number_format($operacion, 2);
?>

<!-- Celda con color y porcentaje -->
<td style="text-align:right; background-color:<?php echo $bgColor; ?>;">
    <?php echo $operacion_formateada; ?>%
</td>



<td style="text-align:left">
    <?php
        $venta_objetivo_mensual = $clientes1[$ii]->{'utilidad_objetivo_mensual'};
        $venta_real_al_dia = $clientes1[$ii]->{'utilidad_real_al_dia'};

        // Seguridad: convertir a números
        $diastotal = (int)$dias_del_mes1;
        $diastranscurridos = (int)$dias_transcurridos1;

        $objetivo_al_dia_calculado = 0;
        $porcentaje = 0;

        if ($diastotal > 0) {
            $objetivo_al_dia_calculado = ($venta_objetivo_mensual / $diastotal) * $diastranscurridos;
        }

        if ($objetivo_al_dia_calculado > 0) {
            $porcentaje = ($venta_real_al_dia / $objetivo_al_dia_calculado) * 100;
        }

        echo number_format($porcentaje, 2) . '%';
    ?>
</td><?php
    // Datos base
    $venta_real_al_dia = (float)$clientes1[$ii]->{'venta_real_al_dia'};
    $venta_objetivo_mensual = (float)$clientes1[$ii]->{'venta_objetivo_mensual'};
    $bono_venta = (float)$clientes1[$ii]->{'bono_venta'};
    $noempleado = trim($clientes1[$ii]->{'no_empleado'});

    // Días
    $diastotal = (int)$dias_del_mes1;
    $diastranscurridos = (int)$dias_transcurridos1;

    // Calcular objetivo al día
    $objetivo_dia = 0;
    if ($diastotal > 0) {
        $objetivo_dia = ($venta_objetivo_mensual / $diastotal) * $diastranscurridos;
    }

    // Calcular porcentaje de cumplimiento
    $ventas = 0;
    if ($objetivo_dia > 0) {
        $ventas = ($venta_real_al_dia / $objetivo_dia) * 100;
    }

    // Validación
    if (!is_numeric($ventas)) {
        $ventas = 0;
    }
    if (!is_numeric($bono_venta)) {
        $bono_venta = 0;
    }

    // Definir condiciones
    $bgColor = '#FFFFFF';
    $operacion = 0;
    $especiales = ['811', '3477', '026', '45', '3381', '3504', '2191', '3285', '5'];

    // Lógica del bono
    if ($ventas <= 79.99) {
        $bgColor = '#FF0000';
        $operacion = $bono_venta * (in_array($noempleado, $especiales) ? 1.0 : 0.5) / 100;
    } elseif ($ventas <= 89.99) {
        $bgColor = '#F2FF00';
        $operacion = $bono_venta * (in_array($noempleado, $especiales) ? 1.5 : 1.0) / 100;
    } elseif ($ventas <= 99.99) {
        $bgColor = '#00FF2A';
        $operacion = $bono_venta * (in_array($noempleado, $especiales) ? 2.0 : 1.5) / 100;
    } elseif ($ventas <= 109.99) {
        $bgColor = '#cdcdcd';
        $operacion = $bono_venta * (in_array($noempleado, $especiales) ? 2.5 : 2.0) / 100;
    } elseif ($ventas >= 110.00) {
        $bgColor = '#d6af66';
        $operacion = $bono_venta * (in_array($noempleado, $especiales) ? 3.0 : 2.5) / 100;
    }

    // Formato monetario
    $bono_final = '$' . number_format($operacion, 2);
?>

<!-- Celda con color y bono calculado -->
<td style="text-align:right; background-color:<?php echo $bgColor; ?>;">
    <?php echo $bono_final; ?>
</td>

<td style="text-align:right">
  <?php echo '$' . number_format($clientes1[$ii]->{'pacific_standard'}, 2); ?>
</td>

<td style="text-align:right">
  <?php echo '$' . number_format($clientes1[$ii]->{'bono_ps'}, 2); ?>
</td>

<td style="text-align:right">
  <?php echo '$' . number_format($clientes1[$ii]->{'descontinuado'}, 2); ?>
</td>

<td style="text-align:right">
  <?php echo '$' . number_format($clientes1[$ii]->{'bono_descontinuado'}, 2); ?>
</td>

<?php
    // Datos base
    $venta_real_al_dia   = (float)$clientes1[$ii]->{'venta_real_al_dia'};
    $venta_objetivo_mensual = (float)$clientes1[$ii]->{'venta_objetivo_mensual'};

    $bono_total          = (float)$clientes1[$ii]->{'bono_total'}; // utilidad base
    $bono_descontinuado  = (float)$clientes1[$ii]->{'bono_descontinuado'};
    $bono_ps             = (float)$clientes1[$ii]->{'bono_ps'};

    $noempleado          = trim($clientes1[$ii]->{'no_empleado'});

    // Días
    $diastotal = (int)$dias_del_mes1;
    $diastranscurridos = (int)$dias_transcurridos1;

    // Calcular objetivo al día
    $objetivo_dia = 0;
    if ($diastotal > 0) {
        $objetivo_dia = ($venta_objetivo_mensual / $diastotal) * $diastranscurridos;
    }

    // Calcular porcentaje de cumplimiento
    $ventas = 0;
    if ($objetivo_dia > 0) {
        $ventas = ($venta_real_al_dia / $objetivo_dia) * 100;
    }

    // Validación
    $ventas        = is_numeric($ventas) ? $ventas : 0;
    $bono_total    = is_numeric($bono_total) ? $bono_total : 0;
    $bono_ps       = is_numeric($bono_ps) ? $bono_ps : 0;
    $bono_descont  = is_numeric($bono_descontinuado) ? $bono_descontinuado : 0;

    $bgColor = '#FFFFFF';
    $operacion = 0;
    $especiales = ['811', '3477', '026', '45', '3381', '3504', '2191', '3285', '5'];

    // Lógica del bono total con condiciones
    if ($ventas <= 79.99) {
        $bgColor = '#FF0000';
        $operacion = ($bono_total * (in_array($noempleado, $especiales) ? 1.0 : 0.5) / 100) + $bono_descont + $bono_ps;
    } elseif ($ventas <= 89.99) {
        $bgColor = '#F2FF00';
        $operacion = ($bono_total * (in_array($noempleado, $especiales) ? 1.5 : 1.0) / 100) + $bono_descont + $bono_ps;
    } elseif ($ventas <= 99.99) {
        $bgColor = '#00FF2A';
        $operacion = ($bono_total * (in_array($noempleado, $especiales) ? 2.0 : 1.5) / 100) + $bono_descont + $bono_ps;
    } elseif ($ventas <= 109.99) {
        $bgColor = '#cdcdcd';
        $operacion = ($bono_total * (in_array($noempleado, $especiales) ? 2.5 : 2.0) / 100) + $bono_descont + $bono_ps;
    } elseif ($ventas >= 110.00) {
        $bgColor = '#d6af66';
        $operacion = ($bono_total * (in_array($noempleado, $especiales) ? 3.0 : 2.5) / 100) + $bono_descont + $bono_ps;
    }

    // Formatear número como moneda
    $bono_final = '$' . number_format($operacion, 2);
?>

<!-- Celda HTML -->
<td style="text-align:right; background-color:<?php echo $bgColor; ?>;">
    <?php echo $bono_final; ?>
</td>
<?php
    // Obtener valores necesarios
    $venta_real_al_dia       = (float)$clientes1[$ii]->{'venta_real_al_dia'};
    $venta_objetivo_mensual  = (float)$clientes1[$ii]->{'venta_objetivo_mensual'};
    $utilidad_real_al_dia    = (float)$clientes1[$ii]->{'utilidad_real_al_dia'};
    $noempleado              = trim($clientes1[$ii]->{'no_empleado'});

    // Días
    $diastotal = (int)$dias_del_mes1;
    $diastranscurridos = (int)$dias_transcurridos1;

    // Cálculo de porcentaje de cumplimiento (ventas2)
    $ventas2 = 0;
    if ($diastotal > 0) {
        $objetivo_dia = ($venta_objetivo_mensual / $diastotal) * $diastranscurridos;
        if ($objetivo_dia > 0) {
            $ventas2 = ($venta_real_al_dia / $objetivo_dia) * 100;
        }
    }
    $ventas2 = is_numeric($ventas2) ? $ventas2 : 0;

    // Colores por nivel de cumplimiento
    $bgColor = '#FFFFFF'; // color por defecto
    if ($ventas2 <= 79.99) {
        $bgColor = '#FF0000';
    } elseif ($ventas2 <= 89.99) {
        $bgColor = '#F2FF00';
    } elseif ($ventas2 <= 99.99) {
        $bgColor = '#00FF2A';
    } elseif ($ventas2 <= 109.99) {
        $bgColor = '#cdcdcd';
    } elseif ($ventas2 >= 110.00) {
        $bgColor = '#d6af66';
    }

    // Cálculo de margen: utilidad / venta
    $ventas = 0;
    if ($venta_real_al_dia > 0) {
        $ventas = ($utilidad_real_al_dia / $venta_real_al_dia) * 100;
    }
    $ventas = is_numeric($ventas) ? $ventas : 0;
    $margen_format = number_format($ventas, 2);
?>

<!-- Celda HTML -->
<td style="text-align:right; background-color:<?php echo $bgColor; ?>;">
    <?php echo $margen_format; ?>%
</td>


                    
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
							.column(9, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
				// Update footer
						$(api.column(9).footer()).html("Suma de total bombeo");
						$(api.column(9).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8) + "</b> ");
               
				// Update footer

                pageTotal844 = api
							.column(5, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
						$(api.column(5).footer()).html("Suma de total bombeo");
						$(api.column(5).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal844) + "</b> ");
              
              
              

                        	pageTotal8222 = api
							.column(10, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
                        $(api.column(10).footer()).html("Suma de total bombeo");	$(api.column(5).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal844) + "</b> ");
              $(api.column(10).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8222) + "</b> ");
              

              
                        	pageTotal8222 = api
							.column(10, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
                        $(api.column(10).footer()).html("Suma de total bombeo");	$(api.column(5).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal844) + "</b> ");
              $(api.column(10).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8222) + "</b> ");
              
              
                        	pageTotal82222 = api
							.column(13, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
                                    $(api.column(13).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal82222) + "</b> ");
              
              
                        	pageTotal8222333 = api
							.column(14, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
                             $(api.column(14).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8222333) + "</b> ");
              
              
                        	pageTotal8222sdf = api
							.column(15, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
              $(api.column(15).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8222sdf) + "</b> ");
              
              
                        	pageTotal8222zff = api
							.column(16, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
             $(api.column(16).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8222zff) + "</b> ");
              
              
                        	pageTotal8222cvcxv = api
							.column(17, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
             $(api.column(17).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8222cvcxv) + "</b> ");

             
             	pageTotal8222cvcxvas = api
							.column(18, { page: "current" })
							.data()
							.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);
             $(api.column(18).footer()).html(" <b>$" + $.fn.dataTable.render.number(",", ".", 2, "").display(pageTotal8222cvcxvas) + "</b> ");
              
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
