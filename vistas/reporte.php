<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['usuario'])){
    
	$fecha=date('d/m/Y');
?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Reportes</title>
		<?php require_once "menu.php";
		 ?>
		
	</head>
	<body>
		
			
		
				<?php if(isset($_GET['desempeño'])){?>
					<div class="">
						<div id="tablaDesChofer"></div>
					</div>
				<?php } elseif(isset($_GET['inventario'])){?>
					<div class="">
						<div id="tablaMedLogistica"></div>
					</div>
				<?php } elseif(isset($_GET['proyeccion'])){?>
					<div class="">
						<div id="tablaMedLogisticas"></div>
					</div>
				<?php } elseif(isset($_GET['comparativocliente'])){?>
					<div class="">
						<div id="tablaMedLogisticass"></div>
					</div>
				<?php } elseif(isset($_GET['comparativoproveedor'])){?>
					<div class="">
						<div id="tablaMedLogisticasss"></div>
					</div>
				<?php } elseif(isset($_GET['toplow'])){?>
					<div class="">
						<div id="tablatoplow"></div>
					</div>
				<?php } elseif(isset($_GET['devoluciones'])){?>
					<div class="">
						<div id="devoluciones"></div>
					</div>
				<?php } elseif(isset($_GET['descuentos'])){?>
					<div class="">
						<div id="descuentos"></div>
					</div>
				<?php } elseif(isset($_GET['proyeccion_articulo'])){?>
					<div class="">
						<div id="proyeccion_articulo"></div>
					</div>
				<?php } elseif(isset($_GET['proyeccion_cliente'])){?>
					<div class="">
						<div id="proyeccion_cliente"></div>
					</div>
				<?php } elseif(isset($_GET['proyeccion_proveedores'])){?>
					<div class="">
						<div id="proyeccion_proveedores"></div>
					</div>
				<?php } elseif(isset($_GET['articulos_clasificacion'])){?>
					<div class="">
						<div id="articulos_clasificacion"></div>
					</div>
				<?php } elseif(isset($_GET['resumen_ventas'])){?>
					<div class="">
						<div id="resumen_ventas"></div>
					</div>
				<?php } elseif(isset($_GET['comision_jefe'])){?>
					<div class="">
						<div id="comision_jefe"></div>
					</div>
				<?php } elseif(isset($_GET['cdetallado'])){?>
					<div class="">
						<div id="cdetallado"></div>
					</div>
				<?php } elseif(isset($_GET['historial_clientes'])){?>
					<div class="">
						<div id="historial_clientes"></div>
					</div>
				<?php } elseif(isset($_GET['mercancialiquidacion'])){?>
					<div class="">
						<div id="mercancialiquidacion"></div>
					</div>
					

					<?php } elseif(isset($_GET['TransaccionesDiariaspoVendedores'])){?>
					<div class="">
						<div id="TransaccionesDiariaspoVendedores"></div>
					</div>

					<?php } elseif(isset($_GET['reporte_de_compra_de_los_mil_productos'])){?>
					<div class="">
						<div id="reporte_de_compra_de_los_mil_productos"></div>
					</div>
						<?php } elseif(isset($_GET['resumen_de_mapeo_de_ventas'])){?>
					<div class="">
						<div id="resumen_de_mapeo_de_ventas"></div>
					</div>
					<?php } elseif(isset($_GET['proyeccionProyectos'])){?>
					<div class="">
						<div id="proyeccionProyectos"></div>
					</div>
					<?php } elseif(isset($_GET['Mapeo_ventas'])){?>
					<div class="">
						<div id="Mapeo_ventas"></div>
					</div>
					<?php } elseif(isset($_GET['Descontinuados_marca'])){?>
					<div class="">
						<div id="Descontinuados_marca"></div>
					</div>
					<?php } elseif(isset($_GET['Descontinuados_vendedor'])){?>
					<div class="">
						<div id="Descontinuados_vendedor"></div>
					</div>
					<?php } elseif(isset($_GET['Descontinuados_cliente'])){?>
					<div class="">
						<div id="Descontinuados_cliente"></div>
					</div>

					<?php } elseif(isset($_GET['nuevocomision'])){?>
					<div class="">
						<div id="nuevocomision"></div>
					</div>
					<?php } elseif(isset($_GET['Reporte_Catalogo_ferrepacifico'])){?>
					<div class="">
						<div id="Reporte_Catalogo_ferrepacifico"></div>
					</div>

					<?php } elseif(isset($_GET['Ultimos_movimientos_netsuite'])){?>
					<div class="">
						<div id="Ultimos_movimientos_netsuite"></div>
					</div>
					<?php } elseif(isset($_GET['Resumen_Item_proveedor'])){?>
					<div class="">
						<div id="Resumen_Item_proveedor"></div>
					</div>

					<?php } elseif(isset($_GET['consultaitems'])){?>
					<div class="">
						<div id="consultaitems"></div>
					</div>
						<?php } elseif(isset($_GET['nuevocomision'])){?>
					<div class="">
						<div id="consultaitems"></div>
					</div>

					<?php } elseif(isset($_GET['logistica'])){?>
					<div class="">
						<div id="consultaitems"></div>
					</div>

						
				<?php }?>
			
			
			
			
	</body>
	</html>

	<script type="text/javascript">
		$(document).ready(function(){
			<?php if(isset($_GET['desempeño'])){?>
				$('#tablaDesChofer').load('reportes/tablaDesempeñoChofer.php');
			<?php }elseif (isset($_GET['inventario'])) {?>
				$('#tablaMedLogistica').load('reportes/reporteinventario.php');
			<?php }elseif (isset($_GET['proyeccion'])) {?>
				$('#tablaMedLogisticas').load('reportes/proyeccion.php');
			<?php }elseif (isset($_GET['comparativocliente'])) {?>
				$('#tablaMedLogisticass').load('reportes/reportecomparativovendedorxcliente.php');
			<?php }elseif (isset($_GET['comparativoproveedor'])) {?>
				$('#tablaMedLogisticasss').load('reportes/reportecomparativovendedorxproveedor.php');
			<?php }elseif (isset($_GET['toplow'])) {?>
				$('#tablatoplow').load('reportes/reportetoplow.php');
			<?php }elseif (isset($_GET['devoluciones'])) {?>
				$('#devoluciones').load('reportes/reportedevoluciones.php');
			<?php }elseif (isset($_GET['descuentos'])) {?>
				$('#descuentos').load('reportes/reportedescuentos.php');
			<?php }elseif (isset($_GET['proyeccion_articulo'])) {?>
				$('#proyeccion_articulo').load('reportes/reporteproyeccionarticulo.php');
			<?php }elseif (isset($_GET['proyeccion_cliente'])) {?>
				$('#proyeccion_cliente').load('reportes/reporteproyeccionclientes.php');
			<?php }elseif (isset($_GET['articulos_clasificacion'])) {?>
				$('#articulos_clasificacion').load('reportes/reportearticulosclasificacion.php');
			<?php }elseif (isset($_GET['resumen_ventas'])) {?>
				$('#resumen_ventas').load('reportes/reporteresumenventas.php');
			<?php }elseif (isset($_GET['comision_jefe'])) {?>
				$('#comision_jefe').load('reportes/reportecomisionjefesucursal.php');
			<?php }elseif (isset($_GET['proyeccion_proveedores'])) {?>
				$('#proyeccion_proveedores').load('reportes/reporteproyeccionproveedores.php');
			<?php }elseif (isset($_GET['cdetallado'])) {?>
				$('#cdetallado').load('reportes/reportecdetallado.php');
			<?php }elseif (isset($_GET['historial_clientes'])) {?>
				$('#historial_clientes').load('reportes/reportehistorial_clientes.php');
			<?php }elseif (isset($_GET['mercancialiquidacion'])) {?>
				$('#mercancialiquidacion').load('reportes/reportemercancialiquidacion.php');

				<?php }elseif (isset($_GET['TransaccionesDiariaspoVendedores'])) {?>
					$('#TransaccionesDiariaspoVendedores').load('reportes/reporteTransaccionesDiariaspoVendedores.php');
					<?php }elseif (isset($_GET['reporte_de_compra_de_los_mil_productos'])) {?>
						$('#reporte_de_compra_de_los_mil_productos').load('reportes/reporte_de_compra_de_los_mil_productos.php');
	<?php }elseif (isset($_GET['resumen_de_mapeo_de_ventas'])) {?>
						$('#resumen_de_mapeo_de_ventas').load('reportes/resumen_de_mapeo_de_ventas.php');	
						<?php }elseif (isset($_GET['proyeccionProyectos'])) {?>
							$('#proyeccionProyectos').load('reportes/proyeccionProyectos.php');
							<?php }elseif (isset($_GET['Mapeo_ventas'])) {?>
								$('#Mapeo_ventas').load('reportes/Mapeo_ventas.php');
								<?php }elseif (isset($_GET['Descontinuados_marca'])) {?>
									$('#Descontinuados_marca').load('reportes/Descontinuados_marca.php');
									<?php }elseif (isset($_GET['Descontinuados_vendedor'])) {?>
										$('#Descontinuados_vendedor').load('reportes/Descontinuados_vendedor.php');
										<?php }elseif (isset($_GET['Descontinuados_cliente'])) {?>
											$('#Descontinuados_cliente').load('reportes/Descontinuados_cliente.php');
									
										
										<?php }elseif (isset($_GET['nuevocomision'])) {?>
										$('#nuevocomision').load('reportes/nuevocomision.php');
									
										<?php }elseif (isset($_GET['Reporte_Catalogo_ferrepacifico'])) {?>
										$('#Reporte_Catalogo_ferrepacifico').load('reportes/Reporte_Catalogo_ferrepacifico.php');


										<?php }elseif (isset($_GET['Ultimos_movimientos_netsuite'])) {?>
										$('#Ultimos_movimientos_netsuite').load('reportes/Ultimos_movimientos_netsuite.php');

										<?php }elseif (isset($_GET['Resumen_Item_proveedor'])) {?>
										$('#Resumen_Item_proveedor').load('reportes/Resumen_Item_proveedor.php');
	

										<?php }elseif (isset($_GET['consultaitems'])) {?>
										$('#consultaitems').load('reportes/consultaitems.php');
	<?php }elseif (isset($_GET['nuevocomision'])) {?>
										$('#nuevocomision').load('reportes/nuevocomision.php');

										
	<?php }elseif (isset($_GET['logistica'])) {?>
										$('#logistica').load('reportes/logistica.php');
	
										
													
										
			<?php }?>
			
			
			
			
		});
	</script>

	<?php 
}else{
	header("location:../index.php");
}
?>