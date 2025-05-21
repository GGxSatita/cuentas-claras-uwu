<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['usuario_id'];
    $monto = $_POST['monto'];
    $categoria = $_POST['categoria'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO gastos (id_usuario, monto, categoria, fecha, descripcion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario, $monto, $categoria, $fecha, $descripcion]);

    $mensaje = "Gasto registrado correctamente!";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Gasto - Cuentas Claras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-5">

        <h1 class="mb-4">Registrar nuevo gasto</h1>

        <?php if (isset($mensaje)) : ?>
            <div class="alert alert-success">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <form action="gastos.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input type="number" name="monto" step="0.01" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <select name="categoria" class="form-select" required>
                            <option value="Agua">Agua</option>
                            <option value="Luz">Luz</option>
                            <option value="Gas">Gas</option>
                            <option value="Comida">Comida</option>
                            <option value="Internet">Internet</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción (opcional)</label>
                        <input type="text" name="descripcion" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Registrar Gasto</button>
                    <a href="dashboard.php" class="btn btn-secondary ms-2">Volver al Dashboard</a>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            padding-top: 70px;
        }
    </style>

</body>

</html>
