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
    <h4 style="text-align:center"><strong>Consulta de Articulos</strong></h4>

    <div class="row">
  

        <div class="col-md-6">
            <div class="d-flex bd-highlight">
                <h5 class="m-2 font-weight-bold"><strong>Codigo UPC</strong></h5>
                <div class="p-1 flex-fill bd-highlight">
			<input type="text" class="form-control" id="item" name="item">
                </div>
       </div>
        </div>
 
      
        <div class="col-md-6">     
            <div class="p-1 flex-fill bd-highlight">
                <input type="submit" class="btn btn-success" name="fechas" id="fechas" value="Generar Reporte" onclick="btnMinformacion();">
            </div>
        </div>
	
    </div>
</div>


<!-- AQUÍ COMIENZA LA TABLA-->
<div id="Datos">
<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<h5>Codigo para mostrar</h5>
			<input type="text" class="form-control" id="codigo_Item" name="codigo_item"> 
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<h5>Articulo</h5>
			<input type="text" class="form-control" id="art_Item" name="art_Item">
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<h5>Unidad de medida</h5>
			<input type="text" class="form-control" id="unt_Item" name="unt_Item">
		</div>
	</div>
	<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	</div>
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	<img id="imagenProducto" src="" alt="Imagen del producto">
	</div>

	
	</div>
</div>

</div>

<!--SCRIPT DE CAMBIAR DE PANTALLA Y DAR VALIDACIÓN A LAS FECHAS INICIALES Y FINALES-->

<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
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
		
		
				
				var item=$('#item').val();




				$.get("reportes/reporte/reporteitemstbl.php"
				,
				{
					parametro1:item

				},
				function(htmlexterno){
				console.log(htmlexterno);
			
			
				cadenaJSON=htmlexterno;
				   // Parsear el string como JSON
				   let arreglo = JSON.parse(cadenaJSON);

// Tomar el primer elemento del arreglo
let cadena = arreglo[0];

// Separar por guiones
let partes = cadena.split('//T// ').map(p => $.trim(p));

// Asignar a variables
let id = partes[0];             // "19114"
let descripcion = partes[1];    // "CARTUCHO P/MEZCLADORA IZQ. CERAMICO GDE R280046 URREA"
let url_imagen = partes[2];     // "https://5017...."
let unidad = partes[3];         // "PIEZA"

// Mostrar resultados
console.log("ID:", id);
console.log("Descripción:", descripcion);
console.log("URL Imagen:", url_imagen);
console.log("Unidad:", unidad);
		
$('#art_Item').val(descripcion);
$('#codigo_Item').val(id);	
$('#unt_Item').val(unidad);	
$('#imagenProducto').attr('src', url_imagen);
			});
				delay();


			

			
			
			
		}
</script>

<script type="text/javascript">
	function sleep(time) {
    	return new Promise(resolve => setTimeout(resolve, time));
	}
 
	async function delay() {
		console.log('Sleeping…');
		await sleep(1500);
		
		
	}

 </script>