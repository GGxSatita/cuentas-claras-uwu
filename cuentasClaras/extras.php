<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

// Registrar ingreso adicional
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['monto']) && isset($_POST['tipo'])) {
    $id_usuario = $_SESSION['usuario_id'];
    $monto = floatval($_POST['monto']);
    $tipo = trim($_POST['tipo']);
    $fecha = date('Y-m-d');
    $mes = date('n');
    $anio = date('Y');

    if ($monto > 0 && !empty($tipo)) {
        $sql = "INSERT INTO ingresos_adicionales (id_usuario, monto, tipo, fecha, mes, anio)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario, $monto, $tipo, $fecha, $mes, $anio]);

        $mensaje = "Ingreso adicional registrado correctamente.";
    } else {
        $error = "Debes ingresar un monto válido y seleccionar un tipo.";
    }
}

// Obtener ingresos adicionales del mes actual
$id_usuario = $_SESSION['usuario_id'];
$mes = date('n');
$anio = date('Y');

$sql = "SELECT * FROM ingresos_adicionales 
        WHERE id_usuario = ? AND mes = ? AND anio = ?
        ORDER BY fecha DESC, id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario, $mes, $anio]);
$extras = $stmt->fetchAll();

// Calcular total de ingresos adicionales
$totalExtras = array_sum(array_column($extras, 'monto'));
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ingresos Adicionales - CuentasClaras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <?php include 'includes/navbar.php'; ?>

    <div class="container my-4">
        <h2 class="mb-4">Ingresos Adicionales del Mes</h2>

        <?php if (isset($mensaje)) : ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php elseif (isset($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Agregar Ingreso Adicional</h5>
                <form action="extras.php" method="POST">
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto:</label>
                        <input type="number" name="monto" class="form-control" placeholder="Ej: 50000" min="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo:</label>
                        <select name="tipo" class="form-select" required>
                            <option value="">Seleccionar</option>
                            <option value="Gratificación">Gratificación</option>
                            <option value="Bono">Bono</option>
                            <option value="Reembolso">Reembolso</option>
                            <option value="Venta">Venta</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Ingreso</button>
                </form>
            </div>
        </div>

        <!-- Listado -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Historial de Ingresos Adicionales</h5>
                <?php if (count($extras) > 0) : ?>
                    <table class="table table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($extras as $extra) : ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($extra['fecha'])); ?></td>
                                    <td><?php echo htmlspecialchars($extra['tipo']); ?></td>
                                    <td>$<?php echo number_format($extra['monto'], 0, ',', '.'); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar<?php echo $extra['id']; ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="eliminar_extra.php?id=<?php echo $extra['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este ingreso?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3">Total del mes:</th>
                                <th>$<?php echo number_format($totalExtras, 0, ',', '.'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else : ?>
                    <p class="text-muted">No hay ingresos adicionales registrados este mes.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>

    <!-- Modales fuera de la tabla -->
    <?php foreach ($extras as $extra) : ?>
        <div class="modal fade" id="modalEditar<?php echo $extra['id']; ?>" tabindex="-1" aria-labelledby="labelEditar<?php echo $extra['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <form action="editar_extra.php" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="labelEditar<?php echo $extra['id']; ?>">Editar Ingreso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $extra['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Monto:</label>
                            <input type="number" name="monto" class="form-control" value="<?php echo $extra['monto']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo:</label>
                            <select name="tipo" class="form-select" required>
                                <?php
                                $tipos = ['Gratificación', 'Bono', 'Reembolso', 'Venta', 'Otro'];
                                foreach ($tipos as $tipo) {
                                    $selected = ($extra['tipo'] == $tipo) ? 'selected' : '';
                                    echo "<option value='$tipo' $selected>$tipo</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
