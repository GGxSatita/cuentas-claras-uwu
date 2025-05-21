<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "Acceso no autorizado.";
    exit();
}

include 'includes/conexion.php';

$id_usuario = $_SESSION['usuario_id'];

$categoria = $_GET['categoria'] ?? '';
$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';
$busqueda = $_GET['busqueda'] ?? '';

// Construir consulta dinámica
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

$sql .= "ORDER BY fecha DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$gastos = $stmt->fetchAll();

if (count($gastos) > 0) {
    echo '<div class="table-responsive">';
    echo '<table class="table table-hover table-bordered align-middle">';
    echo '<thead class="table-primary"><tr><th>Monto</th><th>Categoría</th><th>Fecha</th><th>Descripción</th></tr></thead><tbody>';
    foreach ($gastos as $gasto) {
        echo "<tr>";
        echo "<td>$" . number_format($gasto['monto'], 0, ',', '.') . "</td>";
        echo "<td>{$gasto['categoria']}</td>";
        echo "<td>" . date("d-m-Y", strtotime($gasto['fecha'])) . "</td>";
        echo "<td>{$gasto['descripcion']}</td>";
        echo "</tr>";
    }
    echo '</tbody></table></div>';
} else {
    echo '<div class="alert alert-warning">No se encontraron gastos con los criterios seleccionados.</div>';
}
?>
