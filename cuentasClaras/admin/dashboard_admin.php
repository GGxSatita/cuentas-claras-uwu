<?php
session_start();
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
require('../includes/conexion.php');
include '../includes/admin_navbar.php';


// Consultas rápidas para las cards
$totalUsuarios = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$totalProductos = $pdo->query("SELECT COUNT(*) FROM catalogo_productos")->fetchColumn();
$totalIngresos = $pdo->query("SELECT IFNULL(SUM(monto), 0) FROM ingresos")->fetchColumn();
$totalInventario = $pdo->query("SELECT COUNT(*) FROM inventario")->fetchColumn();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin | CuentasClaras</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (opcional si quieres íconos) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body style="background-color: #f0f0f0;">

    <div class="container mt-4">
        <h2 class="mb-4">Panel de Control</h2>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card text-white" style="background-color: #355070;">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text fs-4"><?php echo $totalUsuarios; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background-color: #6d597a;">
                    <div class="card-body">
                        <h5 class="card-title">Productos Catálogo</h5>
                        <p class="card-text fs-4"><?php echo $totalProductos; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background-color: #b56576;">
                    <div class="card-body">
                        <h5 class="card-title">Ingresos Mes</h5>
                        <p class="card-text fs-4">$<?php echo number_format($totalIngresos, 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background-color: #e56b6f;">
                    <div class="card-body">
                        <h5 class="card-title">Inventario Total</h5>
                        <p class="card-text fs-4"><?php echo $totalInventario; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4>Distribución de Productos en Inventario</h4>
            <canvas id="productosChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('productosChart').getContext('2d');
        const productosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tallarines', 'Arroz', 'Detergente', 'Azúcar', 'Café'],
                datasets: [{
                    label: 'Cantidad en Inventario',
                    data: [12, 9, 5, 8, 3],
                    backgroundColor: ['#355070', '#6d597a', '#b56576', '#e56b6f', '#eaac8b'],
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>