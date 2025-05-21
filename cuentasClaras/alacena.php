<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

// Obtener productos de la alacena del usuario
$id_usuario = $_SESSION['usuario_id'];

$sql = "SELECT * FROM alacena WHERE id_usuario = ? ORDER BY fecha_compra DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$productos = $stmt->fetchAll();

// Calcular total de productos y valor total
$totalProductos = count($productos);
$totalGastado = 0;
foreach ($productos as $prod) {
    $totalGastado += $prod['cantidad'] * $prod['precio_unitario'];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Alacena - CuentasClaras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-light">

<?php include 'includes/navbar.php'; ?>

<div class="container my-4">
    <h2 class="mb-4"><i class="bi bi-basket-fill me-2"></i>Alacena</h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-primary shadow-sm">
                <div class="card-body text-primary">
                    <h5 class="card-title"><i class="bi bi-box-seam"></i> Total de Productos</h5>
                    <p class="display-6"><?php echo $totalProductos; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-success shadow-sm">
                <div class="card-body text-success">
                    <h5 class="card-title"><i class="bi bi-currency-dollar"></i> Total Gastado</h5>
                    <p class="display-6">$<?php echo number_format($totalGastado, 0, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <a href="agregar_producto.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Agregar Producto</a>
        <a href="dashboard.php" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Volver al Dashboard</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Inventario de Alacena</h5>
            <?php if ($totalProductos > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Fecha Compra</th>
                                <th>Fecha Caducidad</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $prod) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($prod['nombre_producto']); ?></td>
                                    <td><?php echo htmlspecialchars($prod['categoria']); ?></td>
                                    <td><?php echo $prod['cantidad']; ?></td>
                                    <td>$<?php echo number_format($prod['precio_unitario'], 0, ',', '.'); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($prod['fecha_compra'])); ?></td>
                                    <td>
                                        <?php
                                        if ($prod['fecha_caducidad']) {
                                            echo date('d/m/Y', strtotime($prod['fecha_caducidad']));
                                        } else {
                                            echo "<span class='text-muted'>N/A</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo nl2br(htmlspecialchars($prod['notas'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-muted">Aún no has agregado productos a tu alacena.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
