<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

$id_usuario = $_SESSION['usuario_id'];
$anio = date('Y');
$mes_numero = date('n');

// Presupuesto mensual
$stmt = $pdo->prepare("SELECT * FROM presupuestos WHERE id_usuario = ? AND mes = ? AND mes_numero = ?");
$stmt->execute([$id_usuario, $anio, $mes_numero]);
$presupuesto = $stmt->fetch();
$total_presupuesto = $presupuesto ? $presupuesto['total'] : 0;

// Gastos totales del mes
$stmt = $pdo->prepare("SELECT SUM(monto) as total_gastado FROM gastos WHERE id_usuario = ? AND YEAR(fecha) = ? AND MONTH(fecha) = ?");
$stmt->execute([$id_usuario, $anio, $mes_numero]);
$resultado = $stmt->fetch();
$total_gastado = $resultado['total_gastado'] ?? 0;

// Porcentaje gastado
$porcentaje = ($total_presupuesto > 0) ? ($total_gastado / $total_presupuesto) * 100 : 0;
if ($porcentaje > 100) $porcentaje = 100;

// Gastos por categoría
$stmt = $pdo->prepare("SELECT categoria, SUM(monto) as total_categoria 
                       FROM gastos 
                       WHERE id_usuario = ? AND YEAR(fecha) = ? AND MONTH(fecha) = ? 
                       GROUP BY categoria");
$stmt->execute([$id_usuario, $anio, $mes_numero]);
$gastos_por_categoria = $stmt->fetchAll();

// Gastos por mes en el año actual
$stmt = $pdo->prepare("SELECT MONTH(fecha) as mes, SUM(monto) as total_mes
                        FROM gastos
                        WHERE id_usuario = ? AND YEAR(fecha) = ?
                        GROUP BY MONTH(fecha)
                        ORDER BY mes");
$stmt->execute([$id_usuario, $anio]);
$gastos_por_mes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cuentas Claras - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            padding-top: 70px;
            /* para que el contenido no quede tapado por el navbar fijo */
        }
    </style>

</head>

<body class="bg-light">
    <?php include 'includes/navbar.php'; ?>


    <div class="container mt-5">
        <h1 class="mb-4">Bienvenido a <strong>Cuentas Claras</strong></h1>

        <!-- Primera fila: Resumen y Categorías -->
        <div class="row">
            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">Resumen del Mes</div>
                    <div class="card-body">
                        <?php if ($total_presupuesto > 0): ?>
                            <p><strong>Presupuesto:</strong> $<?php echo number_format($total_presupuesto, 0, ',', '.'); ?></p>
                            <p><strong>Gastado:</strong> $<?php echo number_format($total_gastado, 0, ',', '.'); ?></p>
                            <div class="progress mb-3" style="height: 25px;">
                                <div class="progress-bar <?php
                                                            if ($porcentaje < 70) echo 'bg-success';
                                                            elseif ($porcentaje < 90) echo 'bg-warning';
                                                            else echo 'bg-danger'; ?>"
                                    role="progressbar"
                                    style="width: <?php echo $porcentaje; ?>%;"
                                    aria-valuenow="<?php echo $porcentaje; ?>"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                    <?php echo round($porcentaje, 2); ?>%
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">No has asignado presupuesto este mes. <a href="presupuesto.php">Configúralo aquí</a>.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-secondary text-white">Gastos por Categoría</div>
                    <div class="card-body">
                        <?php if (count($gastos_por_categoria) > 0): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Categoría</th>
                                        <th>Total Gastado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($gastos_por_categoria as $gasto): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($gasto['categoria']); ?></td>
                                            <td>$<?php echo number_format($gasto['total_categoria'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info">No hay gastos registrados este mes.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda fila: Gráficos -->
        <div class="row">
            <?php if (count($gastos_por_categoria) > 0): ?>
                <div class="col-12 col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-dark text-white">Distribución de Gastos</div>
                        <div class="card-body">
                            <canvas id="graficoCategorias" height="200"></canvas>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-dark text-white">Gastos Mensuales (<?php echo $anio; ?>)</div>
                    <div class="card-body">
                        <canvas id="graficoMensual" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>



    <!-- Scripts de Gráficos -->
    <?php if (count($gastos_por_categoria) > 0): ?>
        <script>
            const labels = <?php echo json_encode(array_column($gastos_por_categoria, 'categoria')); ?>;
            const data = <?php echo json_encode(array_column($gastos_por_categoria, 'total_categoria')); ?>;

            const ctx = document.getElementById('graficoCategorias').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Gasto por categoría',
                        data: data,
                        backgroundColor: [
                            '#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6f42c1'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        </script>
        <script>
            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            const labelsMeses = meses;
            const dataMeses = new Array(12).fill(0);
            const datosPHP = <?php echo json_encode($gastos_por_mes); ?>;
            datosPHP.forEach(item => {
                let mes = item.mes - 1;
                dataMeses[mes] = item.total_mes;
            });
            const ctxMensual = document.getElementById('graficoMensual').getContext('2d');
            new Chart(ctxMensual, {
                type: 'bar',
                data: {
                    labels: labelsMeses,
                    datasets: [{
                        label: 'Gastos mensuales',
                        data: dataMeses,
                        backgroundColor: '#007bff',
                        borderColor: '#0056b3',
                        borderWidth: 1
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
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>