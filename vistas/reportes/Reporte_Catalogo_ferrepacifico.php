<?php 
session_start();
if(!isset($_SESSION['nombre'])){
    
  }
  $user=$_SESSION["usuario"]; 
  include '../../clases/Conexion.php';
  $db=new Conect_MySql();
  $sql = "SELECT usu_nombres,sucursal,puesto FROM `usuarios` WHERE `usuario`='$user'";
  $query = $db->execute($sql);
  while($datos=$db->fetch_row($query)){
    $nom=$datos['usu_nombres'];
    $sucursal=$datos['sucursal'];
    $puesto=$datos['puesto'];
  }
  /*if(isset($_POST['subirfecha'])){
	$db=new Conect_MySql();
	$sql = "SELECT fecha_programa FROM `programa_logistica`";
	$query = $db->execute($sql);
  }*/
  //Menú arriba de lo que tendrá al momento de pasar a otra pestaña.
date_default_timezone_set('America/Mexico_City');
	$c= new Conect_MySql();
	/*$sql="SELECT t1.folio, SUM(t3.total), t1.fecha_programa, t1.fecha_salida, t1.fecha_entrada, t4.unidad, t5.nombre FROM `programa_logistica` t1 left JOIN `logistica`t3 on t3.id_programa=t1.id left JOIN `unidades`t4 on t1.id_unidad=t4.id left join `chofer`t5 on t5.id=t1.id_chofer where t1.fecha_entrada!='0000-00-00 00:00:00' GROUP BY t1.id; ";
	$result=$c->execute($sql);*/
 ?>

<!-- Boton -->
<div class="container">
    <h4 style="text-align:center"><strong>FERREPACIFICO</strong></h4>
    <h4 style="text-align:center"><strong>Catálogo Ferrepacifico</strong></h4>

    <div class="row">
        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>FECHA DEL</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <input type="date" class="form-control input-sm" name="fechaini" id="fechaini" value="<?php echo date('Y-m-d')?>">
                </div>
                <h5 class="m-2 font-weight-bold"><strong>AL</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <input type="date" class="form-control input-sm" name="fechafin" id="fechafin" value="<?php echo date('Y-m-d')?>">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Sucursal</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
				<select name="sucursal" id="sucursal" class="form-select">
  <option value="1,2,3,4,5,6,23,12,32,25,21,26">TODAS</option>
  <option value="1">Tlaquepaque</option>
  <option value="2">La Huerta</option>
  <option value="3">Melaque</option>
  <option value="4">Villa Purificación</option>
  <option value="5">Fondeport</option>
  <option value="6">Cantamar</option>
  <option value="23">Mayoreo</option>

</select></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Solucion</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Solucion" id="Solucion" class="form-control"></select>
                </div>
                <h5 class="m-2 font-weight-bold"><strong>Grupo</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Grupo" id="Grupo" class="form-control"></select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Linea</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Linea" id="Linea" class="form-control"></select>
                </div>
                <h5 class="m-2 font-weight-bold"><strong>Estatus</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Estatus" id="Estatus" class="form-control">
  				<option value=0>Todos</option>
				  <option value=1>Activo para la compra</option>
				  <option value=2>Inactivo para la compra </option></select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Sobrepedido</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="sobrepedido" id="sobrepedido" class="form-control">
                <option value=0>Todo</option>
				<option value=1>Sin sobre Pedido</option>
				<option value=2>Con sobre Pedido</option></select>
				</div>
                <h5 class="m-2 font-weight-bold"><strong>Sublinea</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="sublinea" id="sublinea" class="form-control"></select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Proveedor</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Proveedor" id="Proveedor" class="form-control"></select>
                </div>
                <h5 class="m-2 font-weight-bold"><strong>Marca</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
				<select name="marca" id="marca" class="form-select">
</select>
	
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Comprador</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Comprador" id="Comprador" class="form-control"></select>
                </div>
                <h5 class="m-2 font-weight-bold"><strong>Estatus Proveedor</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Estatus_proveedor" id="Estatus_proveedor" class="form-control">
               <option value="0">Todos</option>
			   <option value="1">inactivo para la compra</option>
			   <option value="2">activo para la compra</option></select>
				</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Código UPC</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="codigo_upc" id="codigo_upc" class="form-control">
					<option value="0">Todo</option>
					<option value="1">Con codigo</option>
					<option value="2">Sin codigo</option></select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Proveedor Activo para la compra</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Proveedo_A_compra" id="Proveedo_A_compra" class="form-control"></select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Proveedor Inactivo para la compra</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
                    <select name="Proveedor_in_C" id="Proveedor_in_C" class="form-control"></select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="p-1 flex-fill bd-highlight">
                <input type="submit" class="btn btn-success" name="fechas" id="fechas" value="Generar Reporte" onclick="btnMinformacion();">
            </div>
        </div>
    </div>
</div>

	<div class="col-sm-10">
	</div>
</div>
<!-- AQUÍ COMIENZA LA TABLA-->
<div id="mostrartabla"></div>

<!--SCRIPT DE CAMBIAR DE PANTALLA Y DAR VALIDACIÓN A LAS FECHAS INICIALES Y FINALES-->
<script type="text/javascript">
	function fechaHoy() {
			var today = new Date();
			var fecha = parseInt(today.getDate()) < 10 ? '0' + today.getDate() : today.getDate();
			fecha += '/';
			fecha += parseInt(today.getMonth() + 1) < 10 ? '0' + parseInt(today.getMonth() + 1) : parseInt(today.getMonth() + 1);
			fecha += '/';
			fecha += today.getFullYear();
			return fecha;
		}
		function validar_mismo_mes(f1, f2) {
			const fecha = new Date(f1); //¡se hace esto para no modificar la fecha original!
			const fecha2 = new Date(f2); //¡se hace esto para no modificar la fecha original!
			const mes = fecha.getMonth();
			const mes2 = fecha2.getMonth();

			if (mes == mes2) {
				a = true
			} else {
				a = false
			}
			return a;
		}
		function dias_TranscurridosDelMes(f1, f2) {
			// Obtén la fecha actual
			var fechaActual = new Date(f2);
			// Obtén el primer día del mes actual
			var mes_actual = fechaActual.getMonth();

			var primerDiaDelMes = new Date(f1);

			// Inicializa el contador de días sin contar domingos y días festivos
			var diasSinDomingos = 0;
			// Itera sobre cada día desde el primer día del mes hasta la fecha actual
			for (var i = primerDiaDelMes.getDate(); i <= fechaActual.getDate(); i++) {
				// Crea una nueva fecha para el día actual del mes
				var fecha = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), i);

				// Verifica si el día actual no es domingo (0 es domingo en JavaScript)
				if (fecha.getDay() !== 0) {
					// Verifica si el día actual no es un día festivo adicional
					if (!esDiaFestivoAdicional(fecha)) {
						// Incrementa el contador de días sin domingos ni días festivos
						diasSinDomingos++;
					}
				}
			}


			// Muestra el resultado en la consola o en algún elemento HTML
			if (mes_actual == 1) {
				return 24;
			}
			if (mes_actual == 12) {
				return 24;
			}
			if (mes_actual == 2) {
				return diasSinDomingos - 1;
			}

			if (mes_actual == 10) {
				return diasSinDomingos;
			}
			else {
				return diasSinDomingos;
			}

		}


		function dias_Habiles_del_mes(customrecord687) {
			// Obtén la fecha actual
			var fechaActual = new Date(customrecord687);
			//var mes_actual = customrecord687


			// Obtén el primer día del mes actual
			var primerDiaDelMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);

			// Obtén el último día del mes actual
			var ultimoDiaDelMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);

			// Inicializa el contador de días sin contar los domingos y días festivos
			var diasSinDomingos = 0;
			// Itera sobre cada día del mes
			for (var i = primerDiaDelMes.getDate(); i <= ultimoDiaDelMes.getDate(); i++) {
				// Crea una nueva fecha para el día actual del mes
				var fecha = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), i);

				// Verifica si el día actual no es domingo (0 es domingo en JavaScript)
				if (fecha.getDay() !== 0) {
					// Verifica si el día actual no es un día festivo adicional
					if (!esDiaFestivoAdicional(fecha)) {
						// Incrementa el contador de días sin domingos ni días festivos
						diasSinDomingos++;
					}
				}
			}

			// Muestra el resultado en la consola o en algún elemento HTML

			// Muestra el resultado en la consola o en algún elemento HTML
			return diasSinDomingos;


		}

		// Función para verificar si una fecha es un día festivo adicional
		function esDiaFestivoAdicional(fecha) {
			var festivosAdicionales = [
				new Date(fecha.getFullYear(), 0, 1), // 1 de enero
				primerLunesDeFebrero(fecha.getFullYear()), // Primer lunes de febrero
				tercerLunesDeMarzo(fecha.getFullYear()), // Tercer lunes de marzo
				new Date(fecha.getFullYear(), 4, 1), // 1 de mayo
				new Date(fecha.getFullYear(), 8, 16), // 16 de septiembre
				tercerLunesDeNoviembre(fecha.getFullYear()), // Tercer lunes de noviembre
				new Date(2022, 11, 1), // 1 de diciembre de 2022 (puedes ajustar el año)
				new Date(fecha.getFullYear(), 11, 25), // 25 de diciembre
				new Date(fecha.getFullYear(), 10, 18), // 25 de diciembre
				new Date(fecha.getFullYear(), 9, 1), // 25 de diciembre
				/* DIAS SANTOS */
				new Date(fecha.getFullYear(), 2, 28), // 25 de diciembre
				new Date(fecha.getFullYear(), 2, 29), // 25 de diciembre
				new Date(fecha.getFullYear(), 2, 30) // 25 de diciembre
			];

			return festivosAdicionales.some(function (festivo) {
				return fecha.getTime() === festivo.getTime();
			});
		}

		// Función para obtener el primer lunes de febrero
		function primerLunesDeFebrero(anio) {
			var primerDiaDeFebrero = new Date(anio, 1, 1);
			var diaDeLaSemana = primerDiaDeFebrero.getDay();
			var diasHastaLunes = (diaDeLaSemana === 1) ? 0 : (8 - diaDeLaSemana);
			var primerLunes = new Date(anio, 1, 1 + diasHastaLunes);
			return primerLunes;
		}

		// Función para obtener el tercer lunes de marzo
		function tercerLunesDeMarzo(anio) {
			var primerDiaDeMarzo = new Date(anio, 2, 1);
			var diaDeLaSemana = primerDiaDeMarzo.getDay();
			var diasHastaLunes = (diaDeLaSemana === 1) ? 14 : (22 - diaDeLaSemana);
			var tercerLunes = new Date(anio, 2, 1 + diasHastaLunes);

			return tercerLunes;
		}

		// Función para obtener el tercer lunes de noviembre
		function tercerLunesDeNoviembre(anio) {
			var primerDiaDeNoviembre = new Date(anio, 10, 1);
			var diaDeLaSemana = primerDiaDeNoviembre.getDay();
			var diasHastaLunes = (diaDeLaSemana === 1) ? 14 : (21 - diaDeLaSemana);
			var tercerLunes = new Date(anio, 10, 1 + diasHastaLunes);
			return tercerLunes;
		}

		function modificarMes(fechaOrigen, meses) {
			const fecha = new Date(fechaOrigen); //¡se hace esto para no modificar la fecha original!
			const mes = fecha.getMonth();
			fecha.setMonth(fecha.getMonth() + meses);
			while (fecha.getMonth() === mes) {
				fecha.setDate(fecha.getDate() - 1);
			}
			return fecha;
		}

	function obtenerTrimestre(fecha) {
	    const mes = fecha.getMonth(); 
	    if (mes >= 0 && mes <= 2) return 1; // Enero - Marzo
	    if (mes >= 3 && mes <= 5) return 2; // Abril - Junio
	    if (mes >= 6 && mes <= 8) return 3; // Julio - Septiembre
	    if (mes >= 9 && mes <= 11) return 4; // Octubre - Diciembre
	}

	function obtenerTrimestreAnterior(fecha) {
	    const trimestreActual = obtenerTrimestre(fecha);
	    let año = fecha.getFullYear();
	    let trimestreAnterior = trimestreActual - 1;

	    if (trimestreAnterior === 0) {
	        trimestreAnterior = 4; 
	        año -= 1;
	    }

	    let inicio, fin;

	    switch (trimestreAnterior) {
	        case 1:
	            inicio = new Date(año, 0, 1); // 1 de Enero
	            fin = new Date(año, 2, 31);  // 31 de Marzo
	            break;
	        case 2:
	            inicio = new Date(año, 3, 1); // 1 de Abril
	            fin = new Date(año, 5, 30);  // 30 de Junio
	            break;
	        case 3:
	            inicio = new Date(año, 6, 1); // 1 de Julio
	            fin = new Date(año, 8, 30);  // 30 de Septiembre
	            break;
	        case 4:
	            inicio = new Date(año, 9, 1); // 1 de Octubre
	            fin = new Date(año, 11, 31); // 31 de Diciembre
	            break;
	    }

	    return { inicio, fin, trimestreAnterior };
	}

		function btnMinformacion(){
			var fechainicial = $('#fechaini').val()
			var fechafinal= $('#fechafin').val()
			console.log(fechainicial)
			console.log(fechafinal)
			f1 = fechainicial.split("-")
				f2 = fechafinal.split("-")
	var dias_transcurridos = dias_TranscurridosDelMes(f1[1] + "/" + f1[2] + "/" + f1[0], f2[1] + "/" + f2[2] + "/" + f2[0])
					var dias_del_mes  = dias_Habiles_del_mes(f1[1] + "/" + f1[2] + "/" + f1[0])
				console.log(dias_transcurridos);
				console.log(dias_del_mes);
		
				
				var sucursal=$('#sucursal').val();
var solucion=$('#Solucion').val();
var grupo=$('#Grupo').val();
var linea= $('#Linea').val();
var sublinea=$('#sublinea').val();
var Estatus=$('#Estatus').val(); 
var sobrepedido=$('#sobrepedido').val(); 

var Proveedor = $('#Proveedor').val(); 
var Proveedo_A_compra= $('#Proveedo_A_compra').val(); 
var Proveedor_in_C= $('#Proveedor_in_C').val(); 
var comprador=$('#Comprador').val(); 
var marca =$('#marca').val(); 
var estatus_proveedor=$('#Estatus_proveedor').val();  
var codigo_upc=$('#codigo_upc').val();   


console.log("solucion "+ solucion)
console.log("grupo "+ grupo)
console.log("linea "+ linea)
console.log("sublinea "+ sublinea)
console.log("Estatus "+ Estatus)
console.log("sobrepedido "+ sobrepedido)
console.log("Proveedor "+ Proveedor)
console.log("Proveedo_A_compra "+ Proveedo_A_compra)
console.log("Proveedor_in_C "+ Proveedor_in_C)
console.log("comprador "+ comprador)
console.log("marca "+ marca)
console.log("estatus_proveedor "+ estatus_proveedor)
console.log("codigo_upc "+ codigo_upc)

				$.get("reportes/reporte/tabla_Reporte_Catalogo_ferrepacifico.php"
				,
				{fechainicial:fechainicial,
					fechafinal:fechafinal,
					dias_transcurridos:dias_transcurridos,
					dias_del_mes:dias_del_mes,
					sucursal:sucursal,
solucion:solucion,
grupo:grupo,
linea:linea,
sublinea:sublinea,
Estatus:Estatus,
sobrepedido:sobrepedido,
Proveedor :Proveedor,
Proveedo_A_compra:Proveedo_A_compra,
Proveedor_in_C: Proveedor_in_C,
comprador:comprador,
marca :marca,
estatus_proveedor : estatus_proveedor,
codigo_upc:codigo_upc

				},
				function(htmlexterno){
				$("#mostrartabla").html(htmlexterno);});
				delay();
				console.log(fechainicial)
				console.log(fechafinal)

				
				

			

			
			
			
		}
		$(document).ready(function() {


		
			$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "Sol",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#Solucion').append('<option value="0">Todas</option>');
        
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#Solucion').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});



				$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "group",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#Grupo').append('<option value="0">Todas</option>');
        
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#Grupo').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});


				$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "filtro_linea",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#Linea').append('<option value="0">Todas</option>');
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#Linea').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});


				
				$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "filtro_sublinea",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#sublinea').append('<option value="0">Todas</option>');
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#sublinea').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});



					
				$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "filtro_proveedor",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#Proveedor').append('<option value="0">Todos</option>');
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#Proveedor').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});


					
				$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "filtro_proveedorac",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#Proveedo_A_compra').append('<option value="0">Todos</option>');
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#Proveedo_A_compra').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});


					
				$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "filtro_proveedorinc",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#Proveedor_in_C').append('<option value="0">Todos</option>');
					
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#Proveedor_in_C').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});
			
				$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "filtro_marca",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#marca').append('<option value="0">todas</option>');
					
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#marca').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});
				


				
				$.ajax({
					type: "GET",
					url: "reportes/reporte/Filtros_catalogo.php",
					data: {  // Datos que se enviarán con la solicitud
        parametro1: "filtro_comprador",  // Primer parámetro con su valor
        parametro2: "valor2"   // Segundo parámetro con su valor
    },
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						$('#Comprador').append('<option value="0">todos</option>');
						clientes.forEach(function(opcion) {
        // Separar el valor del texto
        var partes = opcion.split(' - ');
        var valor = partes[0]; // El número
        var texto = partes[1]; // El texto

        // Agregar la opción al select usando append
        $('#Comprador').append('<option value="' + valor + '">' + texto + '</option>');
    });
					}
				});
				
		});
</script>

<script type="text/javascript">
	function sleep(time) {
    	return new Promise(resolve => setTimeout(resolve, time));
	}
 
	async function delay() {
		console.log('Sleeping…');
		await sleep(1500);
		
		
	}
 	/*$(document).ready(function(){
		tabletoday=$('#mydatatable').DataTable({
            "dom": '<"float-left"l><"float-right"f>t<"float-left"i><"float-right"p><"clearfix">',
            "responsive": false,
            
            "language": {
            	"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "order": [
            	[0, "asc"]
            ],
                
        });
		
		$("#openModal").on("click",function(){
			$('#addUnidad').modal('show');
		});
		$('#mydatatable tbody').on('click', 'tr', function () {
			var data = tabletoday.row( this ).data();
			var a=$(this).attr('id').split("-");
			var aa=a[1]
			$('#editUnidad').modal('show');
			//alert( 'Record ID: ' +  a);
			$('#id').val(aa);
			$('#clave1').val(data[0]);
			$('#descripcion1').val(data[1]);
			$('#placas1').val(data[2]);
			$('#peso1').val(data[3]);
			if(data[4]=="ACTIVO")
				$('#estado1').prop('checked', true);
			
		} );
		$('#btnAddUnidad').click(function(){

			datos=$('#frmaddUnidad').serialize();
			datos=datos+"&Unidad=1";
			console.log(datos)
			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/logistica/unidadesychoferes.php",
				success:function(r){

					if(r==1){
						
						alertify.success("Actualizado con exito :D");
						alertify.success("").delay(800);
						location.href ="logistica.php?unidades"
						//$('#tablaUnidades').load('logistica/tablaUnidad.php');
					}else{
						alertify.error("No se pudo actualizar :(");
					}
				}
			});
		});
		$('#btnEditUnidad').click(function(){

			datos=$('#frmeditUnidad').serialize();
			datos=datos+"&Unidad=2";
			console.log(datos)
			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/logistica/unidadesychoferes.php",
				success:function(r){

					if(r==1){
						
						alertify.success("Actualizado con exito :D");
						alertify.success("").delay(800);
						location.href ="logistica.php?unidades"
					}else{
						alertify.error("No se pudo actualizar :(");
					}
				}
			});
		});
		
 	});*/
 </script>