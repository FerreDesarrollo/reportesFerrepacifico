<?php 
	
	require_once "../../clases/Conexion.php";
	$c= new Conect_MySql();

	$sql="SELECT usuario,usu_nombres from usuarios where id='".$_GET['id']."'";
	$result=$c->execute($sql);
	$result=mysqli_fetch_row($result);
 ?>


<div class="col-sm-6">
	<form id="frmRegistroU">
		<label>Usuario</label>
		<input type="hidden" class="form-control input-sm" name="id" id="id" value="<?php echo $_GET['id']?>">
		<input type="text" class="form-control input-sm" name="usuario" id="usuario" value="<?php echo $result[0]?>">
		<label>Nombre</label>
		<input type="text" class="form-control input-sm" name="nombres" id="nombres" value="<?php echo $result[1]?>">
		<label>Password</label>
		<input type="text" class="form-control input-sm" name="password" id="password">
		<p></p>
		<button id="btnActualizaUsuario" type="button" class="btn btn-warning">Actualiza Usuario</button>

	</form>
</div>
	<script type="text/javascript">
		$(document).ready(function(){
			
			$('#btnActualizaUsuario').click(function(){

				datos=$('#frmRegistroU').serialize();
				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/regLogin/actualizaUsuario.php",
					success:function(r){

						if(r==1){
							
							alertify.success("Actualizado con exito :D");
							alertify.success("").delay(800);
							location.href ="usuarios.php"
						}else{
							alertify.error("No se pudo actualizar :(");
						}
					}
				});
			});
			
		});
	</script>
