<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    exit("Acceso denegado.");
}

include 'includes/conexion.php';

$id_usuario = $_SESSION['usuario_id'];

// Parámetros GET
$categoria = $_GET['categoria'] ?? '';
$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';
$busqueda = $_GET['busqueda'] ?? '';
$ordenarPor = $_GET['ordenarPor'] ?? 'fecha';
$orden = $_GET['orden'] ?? 'DESC';
$pagina = $_GET['pagina'] ?? 1;
$limite = 5;
$offset = ($pagina - 1) * $limite;

// Consulta dinámica
$sql = "SELECT * FROM gastos WHERE id_usuario = ? ";
$params = [$id_usuario];

if (!empty($categoria)) {
    $sql .= "AND categoria = ? ";
    $params[] = $categoria;
}
if (!empty($desde)) {
    $sql .= "AND fecha >= ? ";
    $params[] = $desde;
}
if (!empty($hasta)) {
    $sql .= "AND fecha <= ? ";
    $params[] = $hasta;
}
if (!empty($busqueda)) {
    $sql .= "AND descripcion LIKE ? ";
    $params[] = "%$busqueda%";
}

$totalSql = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute($params);
$totalFilas = $totalStmt->fetch()['total'];

$sql .= "ORDER BY $ordenarPor $orden LIMIT $limite OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$gastos = $stmt->fetchAll();

// Tabla
if ($totalFilas > 0) {
    echo '<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-primary">
            <tr>
                <th><a href="#" class="ordenar" data-columna="monto" data-orden="'.($orden == 'ASC' ? 'DESC' : 'ASC').'">Monto</a></th>
                <th><a href="#" class="ordenar" data-columna="categoria" data-orden="'.($orden == 'ASC' ? 'DESC' : 'ASC').'">Categoría</a></th>
                <th><a href="#" class="ordenar" data-columna="fecha" data-orden="'.($orden == 'ASC' ? 'DESC' : 'ASC').'">Fecha</a></th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>';
    foreach ($gastos as $gasto) {
        echo '<tr>
            <td>$'.number_format($gasto['monto'], 0, ',', '.').'</td>
            <td>'.$gasto['categoria'].'</td>
            <td>'.date("d-m-Y", strtotime($gasto['fecha'])).'</td>
            <td>'.$gasto['descripcion'].'</td>
        </tr>';
    }
    echo '</tbody></table></div>';

    // Paginación
    $paginas = ceil($totalFilas / $limite);
    if ($paginas > 1) {
        echo '<nav><ul class="pagination">';
        for ($i = 1; $i <= $paginas; $i++) {
            echo '<li class="page-item '.($i == $pagina ? 'active' : '').'">
                <a href="#" class="page-link pagina" data-pagina="'.$i.'">'.$i.'</a>
            </li>';
        }
        echo '</ul></nav>';
    }

} else {
    echo '<div class="alert alert-warning">No se encontraron gastos con los criterios seleccionados.</div>';
}
?>
