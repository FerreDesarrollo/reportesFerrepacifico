<?php 
	
	require_once "../../clases/Conexion.php";
	$c= new Conect_MySql();
	

	$sql="SELECT id, usuario,usu_nombres from usuarios";
	$result=$c->execute($sql);

 ?>


<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	<caption><label>Usuarios :)</label></caption>
	<tr>
		<td>Usuario</td>
		<td>Nombre</td>
		<td>Editar</td>
		<td>Eliminar</td>
	</tr>

	<?php while($ver=mysqli_fetch_row($result)): ?>

	<tr>
		<td><?php echo $ver[1]; ?></td>
		<td><?php echo $ver[2]; ?></td>
		
		<td>
			<span data-toggle="modal" data-target="#actualizaUsuarioModal" class="btn btn-warning btn-xs" onclick="agregaDatosUsuario('<?php echo $ver[0]; ?>')">
				<i class="fas fa-edit"></i>
			</span>
		</td>
		<td>
			<span class="btn btn-danger btn-xs" onclick="eliminarUsuario('<?php echo $ver[0]; ?>','<?php echo $ver[3]; ?>')">
				<i class="fas fa-user-times"></i>
			</span>
		</td>
	</tr>
<?php endwhile; ?>
</table>