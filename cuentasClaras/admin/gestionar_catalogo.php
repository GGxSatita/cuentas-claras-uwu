<?php
session_start();
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require '../includes/conexion.php';
include '../includes/admin_navbar.php';

// Registrar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    $nombre = trim($_POST['nombre']);
    $imagen = trim($_POST['imagen']);
    $unidad = trim($_POST['unidad']);

    if ($nombre !== '' && $imagen !== '' && $unidad !== '') {
        $stmt = $pdo->prepare("INSERT INTO catalogo_productos (nombre, imagen, unidad) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $imagen, $unidad]);
        $mensaje = "Producto agregado con éxito.";
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);
    $pdo->prepare("DELETE FROM catalogo_productos WHERE id = ?")->execute([$idEliminar]);
    header("Location: gestionar_catalogo.php");
    exit();
}

// Traer productos
$productos = $pdo->query("SELECT * FROM catalogo_productos ORDER BY nombre")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Catálogo | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>


<body style="background-color: #f0f0f0;">

    <div class="container mt-4">
        <h2 class="mb-4">Gestión de Catálogo de Productos</h2>

        <?php if (isset($mensaje)) : ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php elseif (isset($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Agregar Producto</h5>
                <form method="POST" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
                    </div>
                    <div class="col-md-4">
                        <select name="imagen" class="form-select" required>
                            <option value="">Seleccionar imagen</option>
                            <?php
                            $imagenes = scandir("../img/productos_alacena");
                            foreach ($imagenes as $img) {
                                if ($img !== '.' && $img !== '..') {
                                    echo "<option value='$img'>$img</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="unidad" class="form-select" required>
                            <option value="unidad">Unidad</option>
                            <option value="kilo">Kilo</option>
                            <option value="litro">Litro</option>
                            <option value="paquete">Paquete</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Listado -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Productos Actuales</h5>
                <?php if (count($productos)) : ?>
                    <table class="table table-hover align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Unidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $p) : ?>
                                <tr>
                                    <td><img src="../img/productos_alacena/<?php echo $p['imagen']; ?>" width="50"></td>
                                    <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                                    <td><?php echo $p['unidad']; ?></td>
                                    <td>
                                        <a href="?eliminar=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p class="text-muted">No hay productos en el catálogo.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>