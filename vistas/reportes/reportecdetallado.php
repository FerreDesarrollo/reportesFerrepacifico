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
	if ($nom == "KEVIN JESUS GONZALEZ MARTINEZ" || $nom == "BLANCA ELISA MUÑOZ BENITEZ"){
		$sucursal = '1,2,3,4,5,6,23';
	}
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
<div class="row" >
	<h4 style="text-align:center"><strong>FERREPACIFICO</strong></h4>
	<h4 style="text-align:center"><strong>VENTAS POR CLIENTE DETALLADO PRODUCTO</strong></h4>
	<div class="d-flex bd-highlight">
		<h5 class="m-2 font-weight-bold"><strong>FECHA DEL </strong></h5>
		<div class="p-1 flex-fill bd-highlight">
			<input type="date" class="form-control input-sm" name="fechaini" id="fechaini" value="<?php echo date('Y-m-d')?>"></input>
		</div>
		<h5 class="m-2 font-weight-bold"><strong>AL</strong></h5>
		<div class="p-1 flex-fill bd-highlight">
			<input type="date" class="form-control input-sm" name="fechafin" id="fechafin" value="<?php echo date('Y-m-d')?>"></input>
		</div>
		<h5 class="m-2 font-weight-bold"><strong>CLIENTE</strong></h5>
		<div class="p-1 flex-fill bd-highlight">
			<input type="text" class="form-control " id="productoVenta" name="productoVenta">
			<input type="hidden" class="form-control " id="idcliente" name="idcliente">
		</div>
		<h5 class="m-2 font-weight-bold"><strong>FILTRAR POR</strong></h5>
		<div class="p-1 flex-fill bd-highlight">
			<select class="form-control input-sm" name="meses" id="meses">
				<option value="cdetalladoa">Articulos</option>
				<option value="cdetalladov">Facturas</option>
			</select>
		</div>
		<div class="p-1 flex-fill bd-highlight">
			<input type="submit" class='btn btn-success' name="fechas" id="fechas" value="Generar Reporte" onclick='btnMinformacion();' ></input>
		</div>
	</div>
	<div class="col-sm-10">
	</div>
</div>
<!-- AQUÍ COMIENZA LA TABLA-->
<div id="mostrartabla"></div>

<!--SCRIPT DE CAMBIAR DE PANTALLA Y DAR VALIDACIÓN A LAS FECHAS INICIALES Y FINALES-->
<script type="text/javascript">
		function btnMinformacion(){
			var fechainicial = $('#fechaini').val()
			var fechafinal= $('#fechafin').val()
			var meses= $('#meses').val()
			var cliente= $('#idcliente').val()
			var nombre= "<?php echo $nom;?>";
			var sucursal= "<?php echo $sucursal;?>";
			var puesto= "<?php echo $puesto;?>";
			f1=fechainicial.split("-")
			f2=fechafinal.split("-")
			
			swal({
				title:"", 
				text:"Loading...",
				icon: "https://www.boasnotas.com/img/loading2.gif",
				buttons: false,      
				closeOnClickOutside: false,
				//icon: "success"
			});
			$.get("reportes/reporte/tablacdetallado.php",{fechainicial:fechainicial,fechafinal:fechafinal,vendedor:nombre,sucursal:sucursal,puesto:puesto,mes:meses,cliente:cliente},function(htmlexterno){$("#mostrartabla").html(htmlexterno);});
			delay();
			console.log(fechainicial)
			console.log(fechafinal)
			
			
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
	
 	$(document).ready(function(){
		$( "#productoVenta" ).autocomplete({
			
			source:function(request,response){
				var g=$("#productoVenta").val();
				//var gg=$("#tipo").val();
				$.ajax({
					type: "POST",
					url: "../procesos/consultafiltros/clientes.php",
					data: {'nombre': g},//capturo array  
					success: function(data){
						var clientes=$.parseJSON(data);
						console.log(clientes);
						let ar=clientes[0].split(' - ');
						var lista=[];
						for (var i = 0; i < clientes.length; i++) {
							let ar=clientes[i].split(' - ');
							var arrecliend={"value":ar[1],"label":ar[1],"description":clientes[i]}
							lista.push(arrecliend);	
						}
						response(lista)
						//console.log(lista)*/
					}
				});
			},
			select:function(event, ui){
				let ar= ui.item.description.split(' - ');
				
				$('#idcliente').val(ar[0]);
				
			}
						
		});
	});
 </script>