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
	<h4 style="text-align:center"><strong>REPORTE DE ARTICULOS DESCONTINUADOS POR MARCA</strong></h4>
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

		<h5 class="m-2 font-weight-bold"><strong>MARCA </strong></h5>
		<div class="p-1 flex-fill bd-highlight">
		
		<select name="marca" id="marca" class="form-select">
		<option value="0	"> Todas </option>
<option value="96"> Foy </option>
<option value="150"> Acero Sueco Palme </option>
<option value="151"> Andres Garcia </option>
<option value="154"> Esperanza Lopez Leon </option>
<option value="100"> Mrs Proveedora </option>
<option value="145"> Hecort </option>
<option value="131"> Araceli Rodriguez </option>
<option value="133"> Cuprum </option>
<option value="134"> El Indio </option>
<option value="136"> Grybim </option>
<option value="137"> Iris Guadalupe </option>
<option value="140"> MR </option>
<option value="152"> Calorex </option>
<option value="153"> Boro </option>
<option value="155"> Fanosa </option>
<option value="160"> Importaciones Alameda </option>
<option value="161"> Impulsora Industrial </option>
<option value="162"> Industrias Presto </option>
<option value="164"> Lamitec </option>
<option value="165"> Prometal Leon </option>
<option value="85"> Ocitec </option>
<option value="87"> Cytsa </option>
<option value="97"> Urrea Herramientas </option>
<option value="10"> Cdc </option>
<option value="2"> Xtools </option>
<option value="4"> Austromex </option>
<option value="38"> Kobrex </option>
<option value="98"> Jyrsa </option>
<option value="68"> Urrea </option>
<option value="45"> Nacobre </option>
<option value="60"> Solaris </option>
<option value="62"> Surtek </option>
<option value="65"> Tenazit </option>
<option value="69"> Vicar </option>
<option value="84"> Protexa </option>
<option value="51"> Porcelanite </option>
<option value="53"> Prodex </option>
<option value="55"> Rotoplas </option>
<option value="57"> Sayer Lack </option>
<option value="58"> Sika </option>
<option value="59"> Simon Electrica </option>
<option value="61"> Square D </option>
<option value="64"> Tecnolite </option>
<option value="70"> Volteck </option>
<option value="77"> Poliducto Naranja </option>
<option value="74"> Cooperwel </option>
<option value="75"> Generico Electrico </option>
<option value="42"> Maxxireja </option>
<option value="43"> Mexalit </option>
<option value="12"> Citijal </option>
<option value="13"> Cocemex </option>
<option value="16"> Condumex </option>
<option value="19"> Deacero </option>
<option value="20"> Dexter </option>
<option value="23"> DTC </option>
<option value="24"> EB Tecnica </option>
<option value="26"> Evans </option>
<option value="28"> Fiero </option>
<option value="17"> Copacabana </option>
<option value="18"> Cruz Azul </option>
<option value="72"> Resistol </option>
<option value="73"> Aksi </option>
<option value="56"> Sali </option>
<option value="63"> Tacsa </option>
<option value="31"> Grambel </option>
<option value="33"> Hilti </option>
<option value="34"> Iusa </option>
<option value="27"> Fepyr </option>
<option value="83"> Sellador Toro </option>
<option value="47"> Panel Rey </option>
<option value="48"> Pennsylvania </option>
<option value="66"> Tuboplus </option>
<option value="67"> Tuk </option>
<option value="76"> Royer </option>
<option value="78"> RyR Mangueras </option>
<option value="79"> Fandeli </option>
<option value="41"> Marlux </option>
<option value="46"> Pacific Standard </option>
<option value="44"> Mueller </option>
<option value="50"> Phillips </option>
<option value="80"> Nexflex </option>
<option value="81"> PTM </option>
<option value="82"> Cinsa </option>
<option value="1"> Truper </option>
<option value="3"> Aislaforte </option>
<option value="5"> Böhler </option>
<option value="6"> Bexel </option>
<option value="7"> Bisagras y Herrahes Atotonilco </option>
<option value="9"> Cato </option>
<option value="15"> Condulac </option>
<option value="21"> Dica </option>
<option value="22"> Double-In </option>
<option value="25"> Elephant </option>
<option value="29"> Foset </option>
<option value="30"> Generico </option>
<option value="32"> Hermex </option>
<option value="37"> Klintek </option>
<option value="39"> Ladesa </option>
<option value="40"> Makita </option>
<option value="36"> Keller </option>
<option value="35"> Jarcimex </option>
<option value="52"> Pretul </option>
<option value="54"> Rejacero </option>
<option value="8"> ByP </option>
<option value="11"> Cempanel </option>
<option value="14"> Coflex </option>
<option value="49"> Perdura </option>
<option value="71"> Plastico Negro </option>
<option value="88"> Calidra </option>
<option value="89"> Yesera Colima </option>
<option value="92"> Grupo Forestal 100 </option>
<option value="90"> La huerta Industrial </option>
<option value="93"> Promotora Dikemh </option>
<option value="103"> todas </option>
<option value="91"> Corepack </option>
<option value="86"> Fortaleza </option>
<option value="121"> Armebe </option>
<option value="168"> Tuvaco </option>
<option value="156"> Ferreteria Indar </option>
<option value="157"> Flexometal </option>
<option value="158"> Gasytanq </option>
<option value="159"> IKG Gratings </option>
<option value="163"> Laminas Ecogreen </option>
<option value="166"> Red Magma </option>
<option value="167"> Triplay y Maderas </option>
<option value="94"> Prisa </option>
<option value="149"> Envases Nacionales </option>
<option value="95"> Linde </option>
<option value="110"> Indasa </option>
<option value="132"> Carlos Alberto Hernandez Mendoza </option>
<option value="138"> Javier Gomez Santiago </option>
<option value="141"> Ripoll </option>
<option value="143"> WD-40 </option>
<option value="144"> Xalos </option>
<option value="99"> Irving </option>
<option value="104"> Truper Expert </option>
<option value="114"> LM </option>
<option value="139"> Martin de la Torre </option>
<option value="135"> Euro Ceramica </option>
<option value="128"> Provher </option>
<option value="129"> Samar </option>
<option value="111"> Novaplastick </option>
<option value="112"> Papalotes </option>
<option value="101"> Copar </option>
<option value="122"> Afamsa </option>
<option value="123"> Calentadores Diaz </option>
<option value="124"> Collado </option>
<option value="142"> Tangit </option>
<option value="102"> Lock </option>
<option value="130"> Ternium </option>
<option value="126"> General de Perfiles </option>
<option value="125"> CSG </option>
<option value="127"> Prominox </option>
<option value="106"> Panel W </option>
<option value="107"> Magnacero </option>
<option value="108"> Guiba Comercial </option>
<option value="109"> Industria Real </option>
<option value="113"> Perfiles LM </option>
<option value="105"> Gfi </option>
<option value="116"> Serviacero </option>
<option value="117"> Simec </option>
<option value="119"> Tmm </option>
<option value="120"> Tumaac </option>
<option value="118"> Stabilit </option>
<option value="115"> Poliestireno MG </option>
<option value="148"> Tabicones y Block del Puerto </option>
<option value="169"> TEJAFLEX </option>
<option value="171"> SOLVEX </option>
<option value="147"> Proceram </option>
<option value="146"> Foncer </option>
<option value="170"> TUBIN </option>
  
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
		
				$.get("reportes/reporte/tabla_descontinuados_marca.php",{fechainicial:fechainicial,fechafinal:fechafinal,sucursal1:sucursal1,marca:marca},function(htmlexterno){$("#mostrartabla").html(htmlexterno);});
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