<?php 
require_once "../clases/Conexion.php";
$c = new Conect_MySql();
session_start();

if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'admin') {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar usuarios</title>
    <?php require_once "menu.php"; ?>
    <style>
        html, body {
            height: 100%;
            overflow-y: auto;
        }

        .container {
            margin-top: 20px;
            padding-bottom: 50px;
        }

        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Administrar usuarios</h1>

        <div class="row">
            <?php if (isset($_GET['agregar'])) { ?>
                <div class="col-sm-4">
                    <form id="frmRegistro">
                        <label>Usuario</label>
                        <input type="text" class="form-control input-sm" name="usuario" id="usuario">
                        <p></p>

                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombres" id="nombres">
                        <p></p>

                        <label>Password</label>
                        <input type="text" class="form-control input-sm" name="password" id="password">
                        <p></p>

                        <label>Sucursal</label>
                        <select class="form-control" id="sucursal" name="sucursal">
                            <?php
                            $sql = "SELECT id, nombre FROM sucursales";
                            $result = $c->execute($sql);
                            while ($ver = mysqli_fetch_row($result)) {
                                echo "<option value='$ver[0]'>$ver[1]</option>";
                            }
                            ?>
                        </select>
                        <p></p>

                        <label>Puesto</label>
                        <select class="form-control" id="puesto" name="puesto">
                            <option>Jefe de sucursal</option>
                            <option>Asesor de ventas</option>
                        </select>
                        <br><br>

                        <span class="btn btn-primary" id="registro">Registrar</span>
                    </form>
                </div>
            <?php } elseif (isset($_GET['editar'])) { ?>
                <div class="col-sm-7">
                    <div id="editarUsuarioLoad"></div>
                </div>
            <?php } else { ?>
                <div class="col-sm-7">
                    <div id="tablaUsuariosLoad"></div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <script type="text/javascript">
        function agregaDatosUsuario(idusuario) {
            location.href = "usuarios.php?editar=" + idusuario;
        }

        function eliminarUsuario(idusuario, nomusuario) {
            alertify.confirm('Eliminar Usuario', '¿Desea eliminar a ' + nomusuario + '?', function () {
                $.ajax({
                    type: "POST",
                    data: "idusuario=" + idusuario,
                    url: "../procesos/usuarios/eliminarUsuario.php",
                    success: function (r) {
                        if (r == 1) {
                            $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');
                            alertify.success("Eliminado con éxito");
                        } else {
                            alertify.error("No se pudo eliminar");
                        }
                    }
                });
            }, function () {
                alertify.error('Cancelado');
            });
        }

        $(document).ready(function () {
            <?php if (isset($_GET['editar'])) { ?>
                var a = <?php echo $_GET['editar'] ?>;
                $.get("usuarios/editarUsuarios.php", {id: a}, function (htmlexterno) {
                    $("#editarUsuarioLoad").html(htmlexterno);
                });
            <?php } ?>

            $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');

            $('#registro').click(function () {
                var vacios = validarFormVacio('frmRegistro');
                if (vacios > 0) {
                    alertify.alert("Debes llenar todos los campos");
                    return false;
                }

                var datos = $('#frmRegistro').serialize();
                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../procesos/regLogin/registrarUsuario.php",
                    success: function (r) {
                        if (r == 1) {
                            $('#frmRegistro')[0].reset();
                            alertify.success("Agregado con éxito");
                        } else {
                            alertify.error("Error: el usuario puede estar repetido");
                        }
                    }
                });
            });
        });

        function validarFormVacio(formularioID) {
            var camposVacios = 0;
            $('#' + formularioID + ' input, #' + formularioID + ' select').each(function () {
                if ($(this).val() === "") {
                    camposVacios++;
                }
            });
            return camposVacios;
        }
    </script>
</body>
</html>
<?php 
} else {
    header("location:../index.php");
}
?>
