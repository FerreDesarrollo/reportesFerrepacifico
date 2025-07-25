<?php
include 'config.php';

// Nueva conexión para ferrepacificocom_bdlogistica
try {
    $dsn_logistica = "mysql:host=ferrepacifico.com.mx;dbname=ferrepacificocom_bdlogistica;charset=utf8mb4";
    $usuario_logistica = "ferrepacificocom_bdlogistica";
    $pass_logistica = "#(zr)9F{p$4A";

    $pdo_logistica = new PDO($dsn_logistica, $usuario_logistica, $pass_logistica, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error conexión BD logística: " . $e->getMessage());
}

// === AUTOCOMPLETE ENDPOINT ===
if (isset($_GET['autocomplete'])) {
    $term = trim($_GET['term'] ?? '');
    $campo = $_GET['autocomplete'];

    if (!in_array($campo, ['vendedor', 'cliente', 'chofer_nombre'])) {
        echo json_encode([]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT DISTINCT $campo FROM Envios_logistica2 WHERE $campo LIKE ? ORDER BY $campo LIMIT 15");
    $stmt->execute(["%$term%"]);
    $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($results);
    exit;
}

// === FILTROS INICIALES ===

$filtros = [
    'sucursal' => '', 'folio' => '', 'idprograma' => '', 'fecha_programa' => '',
    'fecha_documento' => '', 'vendedor' => '', 'estatus' => '', 'chofer_nombre' => '',
    'vehiculo_descripcion' => '', 'unidades' => '', 'total' => '', 'peso' => '',
    'ruta' => '', 'cliente' => '', 'ciudad_estado' => '', 'colonia' => '', 'calle' => '',
    'poblacion' => '', 'codigo_postal' => ''
];

// Nuevo filtro para facturas sin programación

$sin_programacion = isset($_GET['sin_programacion']) && $_GET['sin_programacion'] === '1';

foreach ($filtros as $campo => $valor) {
    if (isset($_GET[$campo])) {
        $filtros[$campo] = trim($_GET[$campo]);
    }
}

$por_pagina = 15;

$pagina_actual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $por_pagina;

$where = ["fecha_documento"];
$params = [];

$sucursal_prefixes = [
    'Fondeport' => ['F'], 'Cantamar' => ['C'], 'Tlaquepaque' => ['T'],
    'Villa' => ['V'], 'Lahuerta' => ['H'], 'Melaque' => ['MV'], 'Mayoreo' => ['MY', 'BV']
];

if (!empty($filtros['sucursal']) && isset($sucursal_prefixes[$filtros['sucursal']])) {
    $prefijos = $sucursal_prefixes[$filtros['sucursal']];
    $sucursal_where = [];
    foreach ($prefijos as $prefijo) {
        $sucursal_where[] = "UPPER(folio) LIKE ?";
        $params[] = strtoupper($prefijo) . '%';
    }
    $where[] = '(' . implode(' OR ', $sucursal_where) . ')';
}

foreach ($filtros as $campo => $valor) {
    if ($valor !== '' && $campo !== 'sucursal') {
        if (in_array($campo, ['fecha_programa', 'fecha_documento'])) {
            $fechaObj = DateTime::createFromFormat('Y-m-d', $valor);
            if ($fechaObj) {
                $fecha_formateada = $fechaObj->format('d/m/Y') . ' 12:00:00 a. m.';
                $where[] = "$campo = ?";
                $params[] = $fecha_formateada;
            }
        } elseif ($campo === 'estatus') {
            $where[] = "estatus = ?";
            $params[] = $valor;
        } else {
            $where[] = "$campo LIKE ?";
            $params[] = '%' . $valor . '%';
        }
    }
}

// Si el filtro sin_programacion está activo, agregar condición
if ($sin_programacion) {
    $where[] = "idprograma = 'sin dato'";
}

$sql = "SELECT DISTINCT folio, idprograma, fecha_programa, fecha_documento, hora_documento, vendedor, estatus, 
        fecha_salida, fecha_entrada, chofer_nombre, vehiculo_descripcion, unidades, total, peso, ruta, cliente,
        ciudad_estado, colonia, calle, poblacion, codigo_postal
        FROM Envios_logistica2";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY fecha_programa DESC LIMIT $por_pagina OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Conteo total para paginación
$count_sql = "SELECT COUNT(DISTINCT folio) FROM Envios_logistica2";
if (!empty($where)) {
    $count_sql .= " WHERE " . implode(" AND ", $where);
}
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute($params);
$total_registros = $count_stmt->fetchColumn();
$total_paginas = ceil($total_registros / $por_pagina);

// --- Ejecutar consulta en la BD logística para traer entregas ---
$sql_entregas = "
    SELECT 
        ee.id_programa, 
        ee.fecha_salida, 
        ee.fecha_entrada, 
        ee.estatus, 
        re.fecha_entrega, 
        re.ticket,
        re.estatus as entrega_estatus,
        re.observaciones
    FROM entregas_estatus AS ee
    LEFT JOIN rutas_estatus AS re ON ee.id_programa = re.id_programa
    ORDER BY ee.id_programa
";

$stmt_entregas = $pdo_logistica->query($sql_entregas);
$datos_entregas = $stmt_entregas->fetchAll();

// Organizar entregas por id_programa y ticket para búsqueda rápida
$entregas_por_programa_ticket = [];
foreach ($datos_entregas as $entrega) {
    $id_prog = $entrega['id_programa'];
    $ticket = $entrega['ticket'] ?? '';
    if (!isset($entregas_por_programa_ticket[$id_prog])) {
        $entregas_por_programa_ticket[$id_prog] = [];
    }
    $entregas_por_programa_ticket[$id_prog][$ticket] = $entrega;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Listado Envios Logística con Entregas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet" />
    <style>
        .campo-autocomplete {
            border: 2px solid #0d6efd;
            padding-right: 28px;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%230d6efd" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg"><path d="M11.742 10.344a6.5 6.5 0 111.397-1.398l3.85 3.85-1.397 1.397-3.85-3.85zm-5.242.656a5 5 0 100-10 5 5 0 000 10z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 16px 16px;
        }
        .fecha-roja {
            background-color: #f8d7da;
            color: #842029;
            font-weight: bold;
        }
        .fecha-naranja {
            background-color: #fff3cd;
            color: #664d03;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light p-4">
<div class="container">
    <h2 class="mb-4 text-center">Listado de Envíos Logística con Entregas</h2>
    <form method="GET" class="row g-3 mb-4 bg-white p-3 rounded shadow-sm">
        <div class="col-12 col-md-2">
            <label class="form-label" for="sucursal">Sucursal</label>
            <select name="sucursal" id="sucursal" class="form-select">
                <option value="">-- Todas --</option>
                <?php
                $sucursales = ['Fondeport', 'Cantamar', 'Tlaquepaque', 'Villa', 'Lahuerta', 'Melaque', 'Mayoreo'];
                foreach ($sucursales as $suc) {
                    $selected = $filtros['sucursal'] === $suc ? 'selected' : '';
                    echo "<option value=\"$suc\" $selected>$suc</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-12 col-md-2">
            <label class="form-label" for="sin_programacion">Facturas sin programación</label>
            <select name="sin_programacion" id="sin_programacion" class="form-select">
                <option value="">-- Todas --</option>
                <option value="1" <?php if(isset($_GET['sin_programacion']) && $_GET['sin_programacion']==='1') echo 'selected'; ?>>Solo sin programación</option>
            </select>
        </div>

        <?php
        $campos = [
            'folio' => 'Folio venta', 'idprograma' => 'Folio envío',
            'fecha_programa' => 'Fecha Programa', 'fecha_documento' => 'Fecha Documento',
            'vendedor' => 'Vendedor', 'estatus' => 'Estatus', 'chofer_nombre' => 'Chofer',
            'vehiculo_descripcion' => 'Vehículo', 'unidades' => 'Unidades', 'total' => 'Total',
            'peso' => 'Peso', 'ruta' => 'Ruta', 'cliente' => 'Cliente',
            'ciudad_estado' => 'Ciudad / Estado', 'colonia' => 'Colonia', 'calle' => 'Calle',
            'poblacion' => 'Población', 'codigo_postal' => 'Código Postal'
        ];

        foreach ($campos as $campo => $label) {
            echo '<div class="col-12 col-md-2">';
            echo "<label class='form-label' for='$campo'>$label</label>";

            if ($campo === 'estatus') {
                echo "<select name='$campo' id='$campo' class='form-select'>";
                echo "<option value=''>-- Todos --</option>";
                $opciones = ['TRANSITO', 'PROGRAMADO', 'SALDAR', 'ENTREGADO'];
                foreach ($opciones as $opcion) {
                    $selected = strtoupper($filtros[$campo]) === $opcion ? 'selected' : '';
                    echo "<option value=\"$opcion\" $selected>$opcion</option>";
                }
                echo "</select>";

            } elseif (in_array($campo, ['fecha_programa', 'fecha_documento'])) {
                echo "<input type='date' name='$campo' id='$campo' value=\"" . htmlspecialchars($filtros[$campo]) . "\" class='form-control'>";

            } elseif (in_array($campo, ['vendedor', 'cliente', 'chofer_nombre'])) {
                echo "<input type='text' name='$campo' id='$campo' value=\"" . htmlspecialchars($filtros[$campo]) . "\" class='form-control campo-autocomplete' autocomplete='off' title='Autocompletado activo'>";

            } else {
                echo "<input type='text' name='$campo' id='$campo' value=\"" . htmlspecialchars($filtros[$campo]) . "\" class='form-control'>";
            }
            echo '</div>';
        }
        ?>
        <div class="col-12 col-md-2 d-flex flex-column justify-content-end">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="filtroRojo" />
                <label class="form-check-label" for="filtroRojo">Mostrar solo Rojo</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="filtroNaranja" />
                <label class="form-check-label" for="filtroNaranja">Mostrar solo Naranja</label>
            </div>
        </div>
        <div class="col-12 col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </form>

    <div class="table-responsive shadow rounded">
        <h3>Registros <?php echo $total_registros?></h3>
        <table class="table table-bordered table-striped table-hover text-center align-middle mb-0" style="min-width:1400px;" id="table">
            <thead class="table-light">
                <tr>
                    <th>Folio venta</th><th>Folio envío</th><th>Fecha Programa</th><th>Fecha Documento</th>
                    <th>Hora Documento</th><th>Vendedor</th><th>Estatus</th><th>Fecha Salida</th><th>Fecha Entrada</th>
                    <th>Chofer</th><th>Vehículo</th><th>Unidades</th><th>Total</th><th>Peso</th><th>Ruta</th><th>Cliente</th>
                    <th>Ciudad / Estado</th><th>Colonia</th><th>Calle</th><th>Población</th><th>C.P.</th>
                    <th>Fecha Salida (Entrega)</th><th>Fecha Entrega (Entrega)</th><th>Observaciones (Entrega)</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($resultados)): ?>
                <tr><td colspan="23">No se encontraron registros.</td></tr>
            <?php else: ?>
                <?php
                if (!function_exists('formatearFechaISO')) {
                    function formatearFechaISO($fechaISO) {
                        if (!$fechaISO) return 'SN';
                        $fechaISO = rtrim($fechaISO, 'Z');
                        try {
                            $dt = new DateTime($fechaISO);
                            return $dt->format('d/m/Y H:i');
                        } catch (Exception $e) {
                            return 'SN';
                        }
                    }
                }

                $fecha_hoy = new DateTime();

                foreach ($resultados as $row):
                    $id_programa_row = $row['idprograma'];
                    $folio_row = $row['folio'];

                    // Variables para colorimetría
                    $fecha_salida_str = $row['fecha_salida'] ?? '';
                    $fecha_entrada_str = $row['fecha_entrada'] ?? '';

                    // Convertir fecha_salida a DateTime si posible (formato d/m/Y)
                    $fecha_salida_obj = DateTime::createFromFormat('d/m/Y', $fecha_salida_str);

                    // Ver si fecha_entrada está vacía o es "sin dato"
                    $fecha_entrada_vacia = $fecha_entrada_str === '' || strtolower($fecha_entrada_str) === 'sin dato';

                    $color_entrada = '';
                    if ($fecha_entrada_vacia && $fecha_salida_obj) {
                        if ($fecha_salida_obj < $fecha_hoy) {
                            $color_entrada = 'fecha-roja';
                        } elseif ($fecha_salida_obj->format('Y-m-d') === $fecha_hoy->format('Y-m-d')) {
                            $color_entrada = 'fecha-naranja';
                        }
                    }

                    // Buscar datos de entregas uniendo por idprograma y folio (ticket)
                    $entrega_extra = ['fecha_salida' => 'SN', 'fecha_entrega' => 'SN', 'observaciones' => 'SN'];
                    if (isset($entregas_por_programa_ticket[$id_programa_row][$folio_row])) {
                        $entrega = $entregas_por_programa_ticket[$id_programa_row][$folio_row];
                        // Si el dato viene vacío o null, poner SN
                        $entrega_extra['fecha_salida'] = !empty($entrega['fecha_salida']) ? $entrega['fecha_salida'] : 'SN';
                        $entrega_extra['fecha_entrega'] = !empty($entrega['fecha_entrega']) ? $entrega['fecha_entrega'] : 'SN';
                        $entrega_extra['observaciones'] = !empty($entrega['observaciones']) ? htmlspecialchars($entrega['observaciones']) : 'SN';
                    }

                    echo "<tr>";
                    foreach ($row as $columna => $valor) {
                        $valor = is_string($valor) ? trim($valor) : $valor;
                        if (is_string($valor) && !mb_detect_encoding($valor, 'UTF-8', true)) {
                            $valor = utf8_encode($valor);
                        }
                        if (in_array($columna, ['fecha_programa', 'fecha_documento'])) {
                            $valor = str_replace(' 12:00:00 a. m.', '', $valor);
                        }
                        if ($columna === 'hora_documento') {
                            $valor = preg_replace('/\.\d+$/', '', $valor);
                        }

                        if ($columna === 'fecha_entrada') {
                            echo "<td class=\"$color_entrada\">" . htmlspecialchars($valor) . "</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($valor) . "</td>";
                        }
                    }
                    // Mostrar columnas extra de entregas
                    echo "<td>" . htmlspecialchars($entrega_extra['fecha_salida']) . "</td>";
                    echo "<td>" . htmlspecialchars($entrega_extra['fecha_entrega']) . "</td>";
                    echo "<td>" . $entrega_extra['observaciones'] . "</td>";

                    echo "</tr>";
                endforeach;
                ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_paginas > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" crossorigin="anonymous"></script>
<script>
$(function(){
    function setupAutocomplete(id) {
        $("#" + id).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '?autocomplete=' + id,
                    dataType: 'json',
                    data: { term: request.term },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            delay: 300
        });
    }
    setupAutocomplete('vendedor');
    setupAutocomplete('cliente');
    setupAutocomplete('chofer_nombre');
});

document.addEventListener('DOMContentLoaded', function() {
    const tabla = document.getElementById('table');
    if (!tabla) return;

    function parseFecha(str) {
        const parts = str.split('/');
        if (parts.length !== 3) return null;
        const d = parseInt(parts[0], 10);
        const m = parseInt(parts[1], 10) - 1;
        const y = parseInt(parts[2], 10);
        if (isNaN(d) || isNaN(m) || isNaN(y)) return null;
        return new Date(y, m, d);
    }

    const fechaHoy = new Date();
    fechaHoy.setHours(0,0,0,0);

    const filtroRojo = document.getElementById('filtroRojo');
    const filtroNaranja = document.getElementById('filtroNaranja');

    function colorearYFiltrar() {
        const filas = tabla.querySelectorAll('tbody tr');
        const idxFechaSalida = 7;
        const idxFechaEntrada = 8;

        filas.forEach(fila => {
            const celdas = fila.querySelectorAll('td');
            if (celdas.length <= idxFechaEntrada) return;

            const fechaSalidaTxt = celdas[idxFechaSalida].textContent.trim();
            const fechaEntradaTxt = celdas[idxFechaEntrada].textContent.trim();

            const fechaSalida = parseFecha(fechaSalidaTxt);
            if (!fechaSalida) {
                celdas[idxFechaEntrada].style.backgroundColor = '';
                celdas[idxFechaEntrada].style.color = '';
                celdas[idxFechaEntrada].style.fontWeight = '';
                fila.style.display = '';
                return;
            }
            fechaSalida.setHours(0,0,0,0);

            celdas[idxFechaEntrada].style.backgroundColor = '';
            celdas[idxFechaEntrada].style.color = '';
            celdas[idxFechaEntrada].style.fontWeight = '';
            fila.style.display = '';

            let esRojo = false;
            let esNaranja = false;

            if (fechaEntradaTxt.toLowerCase() === 'sin dato') {
                if (fechaSalida < fechaHoy) {
                    celdas[idxFechaEntrada].style.backgroundColor = '#f8d7da';
                    celdas[idxFechaEntrada].style.color = '#842029';
                    celdas[idxFechaEntrada].style.fontWeight = 'bold';
                    esRojo = true;
                } else if (fechaSalida.getTime() === fechaHoy.getTime()) {
                    celdas[idxFechaEntrada].style.backgroundColor = '#fff3cd';
                    celdas[idxFechaEntrada].style.color = '#664d03';
                    celdas[idxFechaEntrada].style.fontWeight = 'bold';
                    esNaranja = true;
                }
            }

            if (filtroRojo.checked && filtroNaranja.checked) {
                if (!esRojo && !esNaranja) fila.style.display = 'none';
            } else if (filtroRojo.checked) {
                if (!esRojo) fila.style.display = 'none';
            } else if (filtroNaranja.checked) {
                if (!esNaranja) fila.style.display = 'none';
            }
        });
    }

    filtroRojo.addEventListener('change', colorearYFiltrar);
    filtroNaranja.addEventListener('change', colorearYFiltrar);

    colorearYFiltrar();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
