<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

$directorio = 'img/productos_alacena/';
$imagenes = array_diff(scandir($directorio), array('..', '.'));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $imagen = $_POST['imagen'];
    $id_usuario = $_SESSION['usuario_id'];

    if (!empty($nombre) && !empty($imagen)) {
        $sql = "INSERT INTO catalogo_productos (id_usuario, nombre, imagen) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario, $nombre, $imagen]);

        $mensaje = "Producto agregado correctamente al catálogo.";
    } else {
        $error = "Debes ingresar el nombre y seleccionar una imagen.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Producto al Catálogo - CuentasClaras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'includes/navbar.php'; ?>

    <div class="container my-4">
        <h2 class="mb-4">Agregar Producto al Catálogo</h2>

        <?php if (isset($mensaje)) : ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php elseif (isset($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="agregar_producto.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ej: Tallarines" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Seleccionar Imagen</label>
                <div class="row">
                    <?php foreach ($imagenes as $imagen) : ?>
                        <div class="col-3 mb-3 text-center">
                            <label style="cursor: pointer;">
                                <input type="radio" name="imagen" value="<?php echo $imagen; ?>" style="display: none;" required>
                                <img src="img/productos_alacena/<?php echo $imagen; ?>" class="img-fluid rounded border" style="max-width: 100px; height: auto;">
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Agregar Producto</button>
            <a href="alacena.php" class="btn btn-secondary">Volver a la Alacena</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>