<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require '../conexion.php';
include 'includes/admin_navbar.php';

// Eliminar usuario si se envía desde formulario
if (isset($_GET['eliminar'])) {
    $idEliminar = $_GET['eliminar'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$idEliminar]);
    header('Location: gestionar_usuarios.php');
    exit();
}

// Obtener lista de usuarios
$usuarios = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios | CuentasClaras</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #f0f0f0;">

    <div class="container mt-4">
        <h2 class="mb-4">Usuarios Registrados</h2>

        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Correo</th>
                    <th>Nombre Usuario</th>
                    <th>Rol</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['correo']; ?></td>
                        <td><?php echo $usuario['usuario']; ?></td>
                        <td>
                            <?php if ($usuario['rol'] == 'admin'): ?>
                                <span class="badge bg-success">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Usuario</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $usuario['fecha_registro']; ?></td>
                        <td>
                            <?php if ($usuario['rol'] != 'admin'): ?>
                                <a href="gestionar_usuarios.php?eliminar=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar este usuario?')">Eliminar</a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="dashboard_admin.php" class="btn btn-secondary mt-3">Volver al Dashboard</a>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>