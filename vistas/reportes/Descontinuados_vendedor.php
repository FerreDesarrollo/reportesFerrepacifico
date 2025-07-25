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
	<h4 style="text-align:center"><strong>REPORTE DE ARTICULOS DESCONTINUADOS POR VENDEDOR</strong></h4>
	<div class="d-flex bd-highlight">
		<h5 class="m-2 font-weight-bold"><strong>FECHA DEL </strong></h5>
		<div class="p-1 flex-fill bd-highlight">
			<input type="date" class="form-control input-sm" name="fechaini" id="fechaini" value="<?php echo date('Y-m-d')?>"></input>
		</div>
		<h5 class="m-2 font-weight-bold"><strong>AL</strong></h5>
		<div class="p-1 flex-fill bd-highlight">
			<input type="date" class="form-control input-sm" name="fechafin" id="fechafin" value="<?php echo date('Y-m-d')?>"></input>
		</div>


		<h5 class="m-2 font-weight-bold"><strong>SUCURSAL </strong></h5>
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

		<h5 class="m-2 font-weight-bold"><strong>Vendedor </strong></h5>
		<div class="p-1 flex-fill bd-highlight">
		
		<select name="marca" id="marca" class="form-select"><option value="0"> Todos </option>
<option value="ABRAHAM HELI TRUJILLO TRUJILLO"> ABRAHAM HELI TRUJILLO TRUJILLO </option>
<option value="ADHARA AIDEE DE LOS PALOS JARAMILLO"> ADHARA AIDEE DE LOS PALOS JARAMILLO </option>
<option value="ALEJANDRO ANDRADE REYES"> ALEJANDRO ANDRADE REYES </option>
<option value="ALMA DELIA GORDILLO FLORES"> ALMA DELIA GORDILLO FLORES </option>
<option value="ANA ELENA GARCIA JUAREZ"> ANA ELENA GARCIA JUAREZ </option>
<option value="ANA KAREN SERRANO SOLIS"> ANA KAREN SERRANO SOLIS </option>
<option value="ANA LILIA RAMIREZ SANCHEZ"> ANA LILIA RAMIREZ SANCHEZ </option>
<option value="ANGEL SANTANA MARTINEZ"> ANGEL SANTANA MARTINEZ </option>
<option value="AURORA CATALINA DOMINGUEZ ISLAS"> AURORA CATALINA DOMINGUEZ ISLAS </option>
<option value="CESAR EDUARDO GARCIA AGUILAR"> CESAR EDUARDO GARCIA AGUILAR </option>
<option value="DANA KHORKINA C LOPEZ"> DANA KHORKINA C LOPEZ </option>
<option value="DANIELA YESENIA CANALES RAMOS"> DANIELA YESENIA CANALES RAMOS </option>
<option value="DIANA SOREL QUEVEDO JIMENEZ"> DIANA SOREL QUEVEDO JIMENEZ </option>
<option value="DIEGO ALONSO ESQUIVEL GUZMAN"> DIEGO ALONSO ESQUIVEL GUZMAN </option>
<option value="EDER RIGOBERTO MORALES CORONADO"> EDER RIGOBERTO MORALES CORONADO </option>
<option value="EDUARDO FERNANDO LOPEZ SANCHEZ"> EDUARDO FERNANDO LOPEZ SANCHEZ </option>
<option value="EFREN TORRES ALVAREZ"> EFREN TORRES ALVAREZ </option>
<option value="ERICK DANIEL SANCHEZ CORONA"> ERICK DANIEL SANCHEZ CORONA </option>
<option value="ESMERALDA F QUIÑONES"> ESMERALDA F QUIÑONES </option>
<option value="ESTEBAN BENCOMO LOMELI"> ESTEBAN BENCOMO LOMELI </option>
<option value="EURIDICE NEGRETE MORALES"> EURIDICE NEGRETE MORALES </option>
<option value="FABIOLA CANALES RAMOS"> FABIOLA CANALES RAMOS </option>
<option value="FERNANDO FLORES PARKMAN CACHO"> FERNANDO FLORES PARKMAN CACHO </option>
<option value="GABRIEL TRELLES LARA"> GABRIEL TRELLES LARA </option>
<option value="GEMMA MARGARITA GARCIA CORTES"> GEMMA MARGARITA GARCIA CORTES </option>
<option value="GILBERTO RIVAS MARES"> GILBERTO RIVAS MARES </option>
<option value="GONZALO ARIEL BENCARDINO"> GONZALO ARIEL BENCARDINO </option>
<option value="ISRAEL VERA MARQUEZ"> ISRAEL VERA MARQUEZ </option>
<option value="JADE RUBI PEREZ VICTORIO"> JADE RUBI PEREZ VICTORIO </option>
<option value="JAVIER BECERRA LUNA"> JAVIER BECERRA LUNA </option>
<option value="JENNIFER YAMILET ARREZOLA JAIMES"> ENNIFER YAMILET ARREZOLA JAIMES </option>
<option value="JOSE ANTONIO CAPRISTO VILLASEÑOR"> JOSE ANTONIO CAPRISTO VILLASEÑOR </option>
<option value="JOSE ENRIQUE BARTOLEÑO SANCHEZ"> JOSE ENRIQUE BARTOLEÑO SANCHEZ </option>
<option value="JOSE JIMENEZ BELTRAN"> JOSE JIMENEZ BELTRAN </option>
<option value="JOSE LUIS TRELLES LARA"> JOSE LUIS TRELLES LARA </option>
<option value="JOSE MANUEL LOPEZ VILLALBA"> JOSE MANUEL LOPEZ VILLALBA </option>
<option value="JUAN CARLOS M CASTILLO"> JUAN CARLOS M CASTILLO </option>
<option value="JUAN RENE MARTINEZ BECERRIL"> JUAN RENE MARTINEZ BECERRIL </option>
<option value="JULIO RANGEL GUZMAN"> JULIO RANGEL GUZMAN </option>
<option value="KALIA AZUCENA OROZCO VILLAMAR"> KALIA AZUCENA OROZCO VILLAMAR </option>
<option value="KARLA LIZBETH MENA FERNANDEZ"> KARLA LIZBETH MENA FERNANDEZ </option>
<option value="LAURA VIANEY GARCIA RIOS"> LAURA VIANEY GARCIA RIOS </option>
<option value="LUIS FERNANDO MALDONADO TENA"> LUIS FERNANDO MALDONADO TENA </option>
<option value="LUIS IXTA ZUÑIGA"> LUIS IXTA ZUÑIGA </option>
<option value="LUIS MIGUEL CHAVEZ OROZCO"> LUIS MIGUEL CHAVEZ OROZCO </option>
<option value="LUIS RAMON JUAREZ MARTINEZ"> LUIS RAMON JUAREZ MARTINEZ </option>
<option value="LUIZ FELIPE VARGAS AGUILAR"> LUIZ FELIPE VARGAS AGUILAR </option>
<option value="MA. MAGNOLIA REAL RODRIGUEZ"> MA. MAGNOLIA REAL RODRIGUEZ </option>
<option value="MARCOS JAVIER LOZA GARCIA"> MARCOS JAVIER LOZA GARCI </option>
<option value="MARIA MARISOL ABARCA MACIAS"> MARIA MARISOL ABARCA MACIAS </option>
<option value="MARTINEZ CENTENO, ALEJANDRA MAGDALENA"> MARTINEZ CENTENO, ALEJANDRA MAGDALENA </option>
<option value="MAURA GRACIELA MARTINEZ SANCHEZ"> MAURA GRACIELA MARTINEZ SANCHEZ </option>
<option value="MICHEL DANAE AVENDAÑO MARTINEZ"> MICHEL DANAE AVENDAÑO MARTINEZ </option>
<option value="MILDRED PRECIADO RODRIGUEZ"> MILDRED PRECIADO RODRIGUEZ </option>
<option value="MIRIAM ROSALINA SANCHEZ RIZO"> MIRIAM ROSALINA SANCHEZ RIZO </option>
<option value="NESTOR OROZCO PELAYO"> NESTOR OROZCO PELAYO </option>
<option value="NUBIA AZUCENA MARTINEZ BALTAZAR"> NUBIA AZUCENA MARTINEZ BALTAZAR </option>
<option value="OMAR ALEJANDRO TRELLES ZARATE"> OMAR ALEJANDRO TRELLES ZARATE </option>
<option value="OSCAR PEREZ ESCOBAR"> OSCAR PEREZ ESCOBAR </option>
<option value="RAMIRO ALVARADO HERRERA"> RAMIRO ALVARADO HERRERA </option>
<option value="RAUL MORALES GONZALEZ"> RAUL MORALES GONZALEZ </option>
<option value="ROBERTO RANGEL GUZMAN"> ROBERTO RANGEL GUZMAN </option>
<option value="ROSA ELENA GUZMAN CAMACHO"> ROSA ELENA GUZMAN CAMACHO </option>
<option value="ROSA VALERIA CABRERA VIGIL"> ROSA VALERIA CABRERA VIGIL </option>
<option value="SANDRA GUADALUPE PEREZ DURAN"> SANDRA GUADALUPE PEREZ DURAN </option>
<option value="SILVINO DE LA CRUZ GOMEZ"> SILVINO DE LA CRUZ GOMEZ </option>
<option value="THALIA LIZETTE TORRES MAGAÑA"> THALIA LIZETTE TORRES MAGAÑA </option>
<option value="VALERIA CRISTINA CAMPOS SANDOVAL"> VALERIA CRISTINA CAMPOS SANDOVAL </option>
<option value="VANIA GUADALUPE RODRIGUEZ CONTRERAS"> VANIA GUADALUPE RODRIGUEZ CONTRERAS </option>
<option value="VERONICA MEDINA VACA"> VERONICA MEDINA VACA </option>
<option value="VICTOR MANUEL PELAYO RAMOS"> VICTOR MANUEL PELAYO RAMOS </option>
<option value="YOLANDA VERONICA VILLA MONTES"> YOLANDA VERONICA VILLA MONTES </option>
<option value="YOLTIC MIRAMONTES VILLALVAZO"> OLTIC MIRAMONTES VILLALVAZO </option>
  
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

			var marca = $('#marca').val()
			var sucursal1= $('#sucursal').val()
			 
			var nombre= "<?php echo $nom;?>";
			var sucursal= "<?php echo $sucursal;?>";
			var puesto= "<?php echo $puesto;?>";
			f1=fechainicial.split("-")
			f2=fechafinal.split("-")
			if (f1[1]!=f2[1]) {
				alertify.alert("Las fechas no son del mismo mes","El rango de fechas deben de ser del mismo mes");
			} else {
		
				$.get("reportes/reporte/tabla_descontinuados_vendedor.php",{fechainicial:fechainicial,fechafinal:fechafinal,sucursal1:sucursal1,marca:marca},function(htmlexterno){$("#mostrartabla").html(htmlexterno);});
				delay();
				console.log(fechainicial)
				console.log(fechafinal)
			}
			
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