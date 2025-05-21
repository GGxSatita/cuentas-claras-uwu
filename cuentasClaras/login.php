<?php
session_start();
include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        // Redirigir según rol
        if ($usuario['rol'] === 'admin') {
            header("Location: admin/dashboard_admin.php");
            exit();
        } else {
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CuentasClaras - Iniciar sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
            background: linear-gradient(to right, #3f51b5, #5c6bc0);
            color: white;
        }

        .login-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 40px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .form-control {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .btn-login {
            background: #fbc02d;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
        }

        .btn-login:hover {
            background: #f9a825;
        }

        .icono-login {
            font-size: 4rem;
        }

        .footer {
            background: #3f51b5;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Navbar fija -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand fs-4" href="index.php">💰 CuentasClaras</a>
        </div>
    </nav>

    <!-- Sección de login -->
    <div class="login-container mt-5" data-aos="fade-up">
        <div class="text-center">
            <i class="bi bi-box-arrow-in-right icono-login text-warning"></i>
            <h2 class="mt-3">Iniciar sesión</h2>
        </div>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2" role="alert" data-aos="fade-down">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div><?php echo $error; ?></div>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <input type="email" name="correo" class="form-control" id="email" placeholder="Correo electrónico" required>
            </div>
            <div class="mb-3">
                <input type="password" name="contrasena" class="form-control" id="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-login">Iniciar sesión</button>
        </form>
        <p class="text-center mt-3">
            ¿No tienes cuenta? <a href="registro.php" class="text-warning">¡Regístrate aquí!</a>
        </p>
    </div>


    <!-- Footer -->
    <footer class="footer">
        &copy; <?php echo date("Y"); ?> CuentasClaras - Todos los derechos reservados.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>