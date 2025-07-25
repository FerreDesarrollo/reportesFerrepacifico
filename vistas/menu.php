<?php
require_once "dependencias.php";
require_once "../clases/Conexion.php";
$db = new Conect_MySql();

$sql = "SELECT nombre FROM sucursales WHERE id='" . $_SESSION['sucu'] . "'";
$query = $db->execute($sql);
while ($datos = $db->fetch_row($query)) {
    $nom_sucursal = $datos['nombre'];
}
$sql = "SELECT puesto FROM usuarios WHERE usuario='" . $_SESSION["usuario"] . "'";
$query = $db->execute($sql);
while ($datos = $db->fetch_row($query)) {
    $puestos = $datos['puesto'];
}
date_default_timezone_set('America/Mexico_City');
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];
$mesActual = $meses[intval(date('n'))];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel de Reportes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            overflow: hidden;
            display: flex;
        }

        .sidebar {
            width: 260px;
            background-color: #343a40;
            color: #fff;
            transition: width 0.3s, left 0.3s;
            overflow-y: auto;
            flex-shrink: 0;
            height: 100vh;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #495057;
        }

        .sidebar .logo img {
            height: 50px;
            max-width: 100%;
            transition: all 0.3s;
        }

        .sidebar.collapsed .logo img {
            height: 40px;
        }

        .sidebar button, .sidebar a {
            color: #fff;
            text-decoration: none;
            background: none;
            border: none;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            width: 100%;
            font-size: 15px;
            gap: 10px;
        }

        .sidebar a:hover, .sidebar button:hover {
            background-color: #495057;
        }

        .sidebar .submenu {
            padding-left: 40px;
            display: none;
            flex-direction: column;
        }

        .sidebar .submenu.show {
            display: flex;
        }

        .sidebar.collapsed .text {
            display: none;
        }

        .toggle-btn {
            background-color: #212529;
            color: #fff;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 18px;
            text-align: left;
        }

        .toggle-btn:hover {
            background-color: #1d2124;
        }

        .user-info {
            padding: 15px 20px;
            font-size: 14px;
            background-color: #212529;
            border-bottom: 1px solid #495057;
        }

        .user-info div {
            margin-bottom: 5px;
        }

        .user-info a {
            color: #dc3545;
            display: block;
            margin-top: 10px;
        }

        .main-content {
            flex-grow: 1;
            background-color: #f8f9fa;
            overflow-y: auto;
            padding: 20px;
            margin-left: 260px;
            transition: margin-left 0.3s;
            width: 100%;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 70px;
            }

            .sidebar.collapsed ~ .main-content {
                margin-left: 70px;
            }

            .mobile-toggle-btn {
                display: block;
                position: fixed;
                top: 10px;
                left: 10px;
                background-color: #343a40;
                color: white;
                border: none;
                padding: 10px 15px;
                z-index: 1100;
                font-size: 18px;
                border-radius: 5px;
            }

            .toggle-btn {
                display: none;
            }
        }

        .mobile-toggle-btn {
            display: none;
        }
    </style>
</head>
<body>

<!-- Botón visible en móviles -->
<button class="mobile-toggle-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i> <span class="text">Menú</span>
    </button>
    <div class="logo">
        <a href="inicio.php"><img src="../img/logo-01-01.png" alt="Logo"></a>
    </div>
    <div class="user-info">
        <div><i class="fas fa-user"></i> <span class="text"><?php echo $_SESSION['usuario']; ?></span></div>
        <div><i class="fas fa-building"></i> <span class="text"><?php echo $nom_sucursal; ?></span></div>
        <div><i class="fas fa-calendar-alt"></i> <span class="text"><?php echo $mesActual; ?></span></div>
        <a href="../procesos/salir.php"><i class="fas fa-sign-out-alt"></i> <span class="text">Salir</span></a>
    </div>

    <?php if ($_SESSION['usuario'] == "admin"): ?>
        <button onclick="toggleSubmenu('menuUsuarios')">
            <i class="fas fa-users-cog"></i> <span class="text">Usuarios</span>
        </button>
        <div id="menuUsuarios" class="submenu">
            <a href="usuarios.php?agregar">Agregar</a>
            <a href="usuarios.php">Lista</a>
        </div>
    <?php endif; ?>

    <button onclick="toggleSubmenu('menuReportes')">
        <i class="fas fa-clipboard-list"></i> <span class="text">Reportes</span>
    </button>
    <div id="menuReportes" class="submenu">
        <a href="reporte.php?inventario">Inventario General</a>
        <a href="reporte.php?proyeccion">Proyección</a>
        <a href="reporte.php?comparativocliente">Comparativo vendedor</a>
        <a href="reporte.php?comparativoproveedor">Ventas por proveedor</a>
        <a href="reporte.php?toplow">TOPLOW</a>
        <a href="reporte.php?devoluciones">Devoluciones</a>
        <a href="reporte.php?descuentos">Descuentos</a>
        <a href="reporte.php?articulos_clasificacion">Artículos</a>
        <a href="reporte.php?resumen_ventas">Resumen Ventas</a>
        <a href="reporte.php?cdetallado">Cliente Detallado</a>
        <a href="reporte.php?historial_clientes">Historial Cliente</a>
        <a href="reporte.php?reporte_de_compra_de_los_mil_productos">Compra 1000</a>
        <a href="reporte.php?Descontinuados_marca">Desc. Marca</a>
        <a href="reporte.php?Descontinuados_vendedor">Desc. Vendedor</a>
        <a href="reporte.php?Descontinuados_cliente">Desc. Cliente</a>
        <a href="reporte.php?Reporte_Catalogo_ferrepacifico">Catálogo</a>
        <a href="reporte.php?Resumen_Item_proveedor">Resumen Items</a>
        <a href="reporte.php?consultaitems">Consulta Artículos</a>
        <a href="reporte.php?nuevocomision">Nueva Comisión</a>
        <a href="reporte.php?logistica">Logística</a>

        <?php if ($puestos == "Jefe de sucursal"): ?>
            <a href="reporte.php?proyeccion_articulo">Proy. Artículos</a>
            <a href="reporte.php?proyeccion_cliente">Proy. Clientes</a>
            <a href="reporte.php?proyeccion_proveedores">Proy. Proveedores</a>
            <a href="reporte.php?mercancialiquidacion">Liquidación</a>
            <a href="reporte.php?TransaccionesDiariaspoVendedores">Transacciones</a>
            <a href="reporte.php?proyeccionProyectos">Proy. Proyectos</a>
            <a href="reporte.php?Mapeo_ventas">Mapeo Ventas</a>
            <a href="reporte.php?Ultimos_movimientos_netsuite">Últimos Movimientos</a>
        <?php endif; ?>
    </div>

    <button onclick="toggleSubmenu('menuLogistica')">
        <i class="fas fa-truck"></i> <span class="text">Logística</span>
    </button>
    <div id="menuLogistica" class="submenu">
        <a href="reportes/logistica/bienvenida.php">Reporte logística</a>
    </div>
</div>

<div class="main-content">
    <?php include "reporte.php"; ?>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("collapsed");
        localStorage.setItem("sidebar-collapsed", sidebar.classList.contains("collapsed"));
    }

    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle("show");
        localStorage.setItem("submenu-" + id, submenu.classList.contains("show"));
    }

    window.onload = () => {
        const sidebar = document.getElementById("sidebar");
        if (localStorage.getItem("sidebar-collapsed") === "true") {
            sidebar.classList.add("collapsed");
        }

        ["menuUsuarios", "menuReportes", "menuLogistica"].forEach(id => {
            const submenu = document.getElementById(id);
            if (localStorage.getItem("submenu-" + id) === "true") {
                submenu.classList.add("show");
            }
        });
    };
</script>
</body>
</html>
