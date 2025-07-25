<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		require_once "../clases/Conexion.php";
	$c=new Conect_MySql();
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>inicio</title>
	<?php require_once "menu.php"; ?>
</head>
<body>
<div class="container">
	<div id="carouselExample" class="carousel slide">
	<div class="carousel-inner">
		<?php
		/*
			$a=0;
			$sql = "SELECT img from img_promocion ";
			$query = $c->execute($sql);
			while($datos=$db->fetch_row($query)){
				if($a==0){
						echo '<div class="carousel-item active"><center><img width=50%; height=50% src="data:image/jpeg;base64,'.base64_encode($datos['img']).'"/></center></div>';
				}
				else{
					echo '<div class="carousel-item"><center><img width=50%; height=50% src="data:image/jpeg;base64,'.base64_encode($datos['img']).'"/></center></div>';
				}
				$a++;
			}*/
			?>
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Previous</span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Next</span>
	</button>
	</div>
</div>

</body>
</html>
<?php 
	}else{
		header("location:../index.php");
	}
 ?>