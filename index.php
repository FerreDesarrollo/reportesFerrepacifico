<?php 
	
	require_once "clases/Conexion.php";
	$db=new Conect_MySql();
	//$conexion=$obj->conexion();

	$sql="SELECT * from usuarios where usuario='admin'";
	$query = $db->execute($sql);
	$validar=0;
	if(mysqli_num_rows($query) > 0){
		$validar=1;
	}
 ?>


<!DOCTYPE html>
<html>
	<head>
		<title>Login de usuario</title>
		<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
		<script src="librerias/jquery-3.2.1.min.js"></script>
		<script src="js/funciones.js"></script>
	</head>
	<body style="background-color: gray">
		<br><br><br>
		
		<div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
			
            <h5 class="card-title text-center mb-5 fw-light fs-5"><img src="img/logo-01-01.png" style="width:100%;"></h5>
            <form id="frmLogin">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="name@example.com">
                <label for="usuario">Usuario</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="password">Contraseña</label>
              </div>

              
              <div class="d-grid">
			  <span class="btn btn-primary btn-sm" id="entrarSistema">Entrar</span>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
	</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#entrarSistema').click(function(){

		vacios=validarFormVacio('frmLogin');

			if(vacios > 0){
				alert("Debes llenar todos los campos!!");
				return false;
			}

		datos=$('#frmLogin').serialize();
		$.ajax({
			type:"POST",
			data:datos,
			url:"login.php",
			success:function(r){

				if(r==1){
					window.location="vistas/inicio.php";
				}else{
					alert("No se pudo acceder :(");
				}
			}
		});
	});
	});
</script>