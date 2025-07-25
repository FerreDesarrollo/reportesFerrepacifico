<?php 

	class usuarios{
		public function registroUsuario($datos){
			$c=new Conect_MySql();

			$fecha=date('Y-m-d');

			$sql="INSERT into usuarios (usu_nombres,usuario,password,sucursal,puesto) values ('$datos[2]','$datos[0]','$datos[1]','$datos[4]','$datos[3]')";
			return $query = $c->execute($sql);
		}
		public function loginUser($datos){
			$c=new Conect_MySql();
			$password=sha1($datos[1]);

			$_SESSION['usuario']=$datos[0];
			$_SESSION['iduser']=self::traeID($datos);
			

			$sql="SELECT * from usuarios where usuario='$datos[0]' and password='$password'";
			$query = $c->execute($sql);
			while($dato=$c->fetch_row($query)){
				
				$_SESSION['sucu']=$dato['sucursal'];
				
			}
			
			$result=$query ;
			if(mysqli_num_rows($result) > 0){
				return 1;
			}else{
				return 0;
			}
		}
		public function traeID($datos){
			$c=new Conect_MySql();

			$password=sha1($datos[1]);

			$sql="SELECT id from usuarios where usuario='$datos[0]' and password='$password'"; 
			$result=$query = $c->execute($sql);

			return mysqli_fetch_row($result)[0];
		}

		public function obtenDatosUsuario($idusuario){

			$c=new Conect_MySql();

			$sql="SELECT id, usuario from usuarios  where id='$idusuario'";
			$result=$query = $c->execute($sql);

			$ver=mysqli_fetch_row($result);

			$datos=array(
						'id' => $ver[0],
						'usuario' => $ver[1],
						);

			return $datos;
		}

		public function actualizaUsuario($datos){
			$c=new Conect_MySql();
			if($datos[2]=="")
				$sql="UPDATE usuarios set usuario='$datos[1]',usu_nombres='$datos[3]' where id='$datos[0]'";
			else
				$sql="UPDATE usuarios set usuario='$datos[1]',usu_nombres='$datos[3]',password='$datos[2]' where id='$datos[0]'";
			return $query = $c->execute($sql);	
		}

		public function eliminaUsuario($idusuario){
			$c=new Conect_MySql();

			$sql="DELETE from usuarios where id='$idusuario'";
			return $query = $c->execute($sql);
		}
	}

 ?>