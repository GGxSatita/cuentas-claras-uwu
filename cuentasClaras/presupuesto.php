<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['usuario_id'];
    $ingreso_total = $_POST['ingreso_total'];
    $ahorro = $_POST['ahorro'];
    $emergencias = $_POST['emergencias'];
    $otros_ingresos = $_POST['otros_ingresos'];
    $mes = date('Y');
    $mes_numero = date('n');

    // Validar que ingreso_total sea mayor o igual a la suma de ahorro + emergencias
    if ($ingreso_total < ($ahorro + $emergencias)) {
        $mensaje = "El ingreso total no puede ser menor a la suma de ahorro y emergencias.";
    } else {
        // Verificar si ya existe presupuesto para este mes
        $check = $pdo->prepare("SELECT * FROM presupuestos WHERE id_usuario = ? AND mes = ? AND mes_numero = ?");
        $check->execute([$id_usuario, $mes, $mes_numero]);

        if ($check->rowCount() == 0) {
            $sql = "INSERT INTO presupuestos (id_usuario, ingreso_total, mes, mes_numero, ahorro, emergencias, otros_ingresos)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario, $ingreso_total, $mes, $mes_numero, $ahorro, $emergencias, $otros_ingresos]);

            $total_disponible = $ingreso_total + $otros_ingresos - ($ahorro + $emergencias);

            $mensaje = "✅ Presupuesto registrado correctamente.<br>
                        Ingreso mensual: $$ingreso_total<br>
                        Otros ingresos: $$otros_ingresos<br>
                        Ahorro: $$ahorro<br>
                        Emergencias: $$emergencias<br>
                        <strong>Total disponible para gastos: $$total_disponible</strong>";
        } else {
            $mensaje = "Ya tienes un presupuesto asignado para este mes.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asignar Presupuesto - CuentasClaras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Asignar Presupuesto Mensual</h3>

                        <?php if (isset($mensaje)) : ?>
                            <div class="alert alert-info">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php endif; ?>

                        <form action="presupuesto.php" method="POST">
                            <div class="mb-3">
                                <label for="ingreso_total" class="form-label">Ingreso mensual:</label>
                                <input type="number" name="ingreso_total" class="form-control" step="1000" required>
                            </div>

                            <div class="mb-3">
                                <label for="otros_ingresos" class="form-label">Otros ingresos (bonos, extras):</label>
                                <input type="number" name="otros_ingresos" class="form-control" step="1000" value="0">
                            </div>

                            <div class="mb-3">
                                <label for="ahorro" class="form-label">Asignado a ahorro:</label>
                                <input type="number" name="ahorro" class="form-control" step="1000" value="0">
                            </div>

                            <div class="mb-3">
                                <label for="emergencias" class="form-label">Asignado a emergencias:</label>
                                <input type="number" name="emergencias" class="form-control" step="1000" value="0">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Registrar presupuesto</button>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="dashboard.php" class="btn btn-link">Volver al Dashboard</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>