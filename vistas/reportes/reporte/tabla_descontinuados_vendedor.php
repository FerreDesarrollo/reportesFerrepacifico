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
$sucursal1=$_GET['sucursal1'];
$marca=$_GET['marca'];

$obj = clientes([ "consulta" => "descontinuados_vendedor","f_ini" => date('d/m/Y',strtotime($_GET['fechainicial'])),"f_fin" => date('d/m/Y',strtotime($_GET['fechafinal'])),"sucursal"=>$sucursal1,"marca"=>$marca]);
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
		<tr>
        <th>codigo</th>
			<th>articulo</th>
        
            <th>cantidad</th>
            <th>venta</th>
            <th>utilidad_enpesos</th>
            <th>utilidad_porcentaje</th>
            <th>stock</th>
            <th>stock_en_Pesos</th>
            <th>días_de_inventario</th>
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
                <td style="text-align:left"><?php echo $clientes1[$ii]->{'codigo'}; ?></td>
                    <td style="text-align:left"><?php echo $clientes1[$ii]->{'articulo'}; ?></td>   
         
            <td style="text-align:left"><?php echo $clientes1[$ii]->{'cantidad'}; ?></td>
            <td style="text-align:left"><?php echo $clientes1[$ii]->{'venta'}; ?></td>
            <td style="text-align:left"><?php echo $clientes1[$ii]->{'utilidad_enpesos'}; ?></td>
            <td style="text-align:left"><?php echo $clientes1[$ii]->{'utilidad_porcentaje'}; ?></td>
            <td style="text-align:left"><?php echo $clientes1[$ii]->{'stock'}; ?></td>
            <td style="text-align:left"><?php echo $clientes1[$ii]->{'stps'}; ?></td>
            <td style="text-align:left"><?php echo $clientes1[$ii]->{'dias_de_inventario'}; ?></td>
            <td style="text-align:left"><?php echo $clientes1[$ii]->{'vendedor'}; ?></td>

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



        function separarMiles(numero) {
            return numero.toString().replace(/\\B(?=(\\d{3})+(?!\\d))/g, ",")
        }
       function formatearMoneda(numero) {
        return numero.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }).replace('MXN', '').trim(); 
     }
      
       var totaldd=0;var dia = 10; $("#resultsTable").on("search.dt", function() {
             var searchValue = $("#resultsTable_filter input").val();
        
        
             var data = $("#resultsTable").DataTable().rows({ search: "applied" }).data();
                 var col1=0;
                 var col2=0;
                 var col3=0;
    
                 var col4=0;
                 var col5=0;
                 var col6=0;
    
                 var col5=0;
                 var col6=0;
                 var col7=0;
    
                 var col8=0;
                 var col9=0;
        
        
        
             data.each(function(value, index) { 
        

        
                 for (var prop in value) {
       
          if(prop==2){
             var agregar=parseFloat(value[prop]);  if (isNaN(agregar)) {  agregar=0;}            col2+=agregar; 
                 }
         else if(prop==3){
             var agregar=parseFloat(value[prop]);  if (isNaN(agregar)) {  agregar=0;}           col3+=agregar; 
                 }
         else if(prop==4){
             var agregar=parseFloat(value[prop]);  if (isNaN(agregar)) {  agregar=0;}           col4+=agregar; 
                 }
         else if(prop==5){
            var agregar=parseFloat(value[prop]);  if (isNaN(agregar)) {  agregar=0;}            col5+=agregar; 
                 }
         else if(prop==6){
            var agregar=parseFloat(value[prop]);  if (isNaN(agregar)) {  agregar=0;}            col6+=agregar; 
                 }
         else if(prop==7){
          var agregar=parseFloat(value[prop]);  if (isNaN(agregar)) {  agregar=0;}              col7+=agregar; 
                 }
         else if(prop==8){
            var agregar=parseFloat(value[prop]);  if (isNaN(agregar)) {  agregar=0;}            col8+=agregar; 
                 }
         else if(prop==9){
           var agregar=parseFloat(value[prop]);  if (isNaN(agregar)) {  agregar=0;}             col9+=agregar; 
                 }
        html 
                 }
           }); 
    
        var porcent1 = parseInt((col4/col3)*100);var porcent2 = (col4/col3)*100 ; var margen=parseInt((col7/col3)*100);     if (isNaN(col7) || col7 === "") {   col7=0;                }  
        
        var valor_de_dia=col7/(col3/dia );   col3 = col3.toLocaleString("en-US", { style: "currency", currency: "USD" }); 
           col4 = col4.toLocaleString("en-US", { style: "currency", currency: "USD" });
           col7 = col7.toLocaleString("en-US", { style: "currency", currency: "USD" }); if(isNaN(parseInt(porcent1))) { porcent1 = 0;}if(isNaN(parseInt(valor_de_dia))) { valor_de_dia = 0;}
       $("#ttf").empty(); $("#ttf").append( `<tr><td  ></td><td  ></td><td  class="text-right ">`+separarMiles(col2)+` </td>  <td  class="text-right precio">`+col3+` </td> <td  class="text-right ">`+col4+` </td>  <td  class="text-right ">`+porcent2.toFixed(2)+`% </td><td  class="text-right ">`+separarMiles(col6)+`  </td>  <td  class="text-right ">`+ col7 +` </td> <td  class="text-right "> </td>  </tr>` ); 
         });
        
        document.addEventListener("DOMContentLoaded", function() { 
       
       
  
         var table = document.getElementById('resultsTable');
  
          let total = 0; 
  for (let i = 1; i < table.rows.length - 1; i++) {  
    var cell = table.rows[i].cells[2]; 
  
  var value = parseFloat(cell.textContent) || 0; 
     total += value; 
 } 

  
        $('#resultsTable tbody tr').each(function(){
  

       $(this).find('td').eq(3).addClass('precio'); 
       $(this).find('td').eq(4).addClass('precio'); 
       $(this).find('td').eq(8).addClass('precio'); 
       $(this).find('td').eq(5).addClass('porcentaje'); 
        $(this).find('td').eq(7).addClass('int'); 
           $(this).find('td').eq(9).addClass('int'); 
  /*     $(this).find('td').eq(indiceColumna).addClass('precio'); 
       $(this).find('td').eq(indiceColumna5).addClass('precio'); "  
       $(this).find('td').eq(indiceColumna6).addClass('porcentaje'); "*/
     });  
  

  
       for (var i = 1; i < table.rows.length; i++) { 
           const row = table.rows[i]; 
           const cell = row.cells[6]; 
           if (cell) {   // Verificamos que la celda exista
               const cellValue = parseInt(cell.innerText); 
               if (cellValue == 0) { 
                   cell.style.backgroundColor = "#f78d92"; 
               } 
                
                
           } 
       } 
      


       });
     
  
  	

$('#resultsTable thead tr th').eq(11).addClass('hidden-col');   
$('#resultsTable thead tr th').eq(12).addClass('hidden-col');  
$('#resultsTable thead tr th').eq(13).addClass('hidden-col');  
$('#resultsTable tbody tr').each(function() { 
	$(this).find('td').eq(11).addClass('hidden-col');  
	$(this).find('td').eq(12).addClass('hidden-col');   
	$(this).find('td').eq(13).addClass('hidden-col');   
}); 

  var table = document.getElementById('resultsTable')
 for (var i = 1; i < table.rows.length; i++) { 
     const row = table.rows[i]; 
     const cell = row.cells[6]; 
     if (cell) { 
         const cellValue = parseInt(cell.innerText); 
         if (cellValue == 0) { 
             cell.style.backgroundColor = "#f78d92"; 
         } 
          
          
     } 
 } 
var ints = document.querySelectorAll(".int");
 ints.forEach(function(int) {
 var valor = parseFloat(int.textContent);
 if (isNaN(valor)) {
  int.textContent = int.textContent;
 } else { 
  int.textContent = parseInt(valor)
} 
});

 $('#resultsTable tbody tr').each(function() { 
   var celda = $(this).find('td').eq(6);  
   var numero = parseInt(celda.text(), 10); 
   celda.text(separarMiles(numero)); 
    }); 


 $('#resultsTable tbody tr').each(function() { 
   var celda2 = $(this).find('td').eq(2); 
   var numero2 = parseInt(celda2.text(), 10); 
   celda2.text(separarMiles(numero2)); 
   var celda3 = $(this).find('td').eq(3);   
   var numero3 = parseInt(celda3.text(), 10); 
   celda3.text(formatearMoneda(numero3));  
   var celda4 = $(this).find('td').eq(4); 
   var numero4 = parseInt(celda4.text(), 10); 
   celda4.text(formatearMoneda(numero4));  
   var celda5 = $(this).find('td').eq(5); 
   var numero5 = parseInt(celda5.text(), 10); 
   celda5.text(numero5 + '%'); 
   var celda7 = $(this).find('td').eq(7);  
   var numero7 = parseInt(celda7.text(), 10); 
   celda7.text(formatearMoneda(numero7));  

}); 


 function formatNumber(number) { 
     return number.toLocaleString();   
 } 
 function formatCurrency(number) { 
     return number.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' });  
 } 
 for (let i = 0; i < resultsTable.length; i++) { 
     let row = resultsTable[i]; 
     row[2] = formatNumber(row[2]); 
     row[3] = formatCurrency(row[3]); 
     row[4] = formatCurrency(row[4]); 
     row[5] = formatCurrency(row[5]); 
 } 



   }); 
      
 </script>
