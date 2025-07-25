<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Usuarios.php";

	$obj= new usuarios();

	$pass=sha1($_POST['password']);
	$datos=array(
		$_POST['usuario'],
		$pass,
		$_POST['nombres'],
		$_POST['puesto'],
		$_POST['sucursal']
		
				);

	echo $obj->registroUsuario($datos);

 ?>