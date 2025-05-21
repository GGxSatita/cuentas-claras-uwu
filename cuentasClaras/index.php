<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CuentasClaras - Administra tu dinero fácil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }

        .hero {
            background: linear-gradient(to right, #3f51b5, #5c6bc0);
            color: white;
            padding: 120px 0 80px;
            text-align: center;
        }

        .icono {
            width: 80px;
        }
    </style>
</head>

<body>

    <!-- Navbar fija -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand fs-4" href="#">💰 CuentasClaras</a>
            <div class="ms-auto">
                <a href="login.php" class="btn btn-outline-light me-2">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                </a>
                <a href="registro.php" class="btn btn-warning">
                    <i class="bi bi-person-plus-fill"></i> Registrarse
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="hero">
        <div class="container">
            <h1 class="display-4">Lleva el control de tus gastos de forma simple</h1>
            <p class="lead mt-3">Registra, clasifica y visualiza tus gastos mensuales con reportes y gráficas personalizadas.</p>
        </div>
    </div>

    <!-- Sección de características -->
    <div class="container my-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <img src="https://img.icons8.com/fluency/96/wallet.png" class="icono" alt="Gastos" />
                <h3 class="mt-3">Registra tus Gastos</h3>
                <p>Agrega y clasifica tus gastos diarios de forma rápida y sencilla desde cualquier dispositivo.</p>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <img src="https://img.icons8.com/fluency/96/combo-chart.png" class="icono" alt="Gráficos" />
                <h3 class="mt-3">Visualiza con Gráficos</h3>
                <p>Consulta tus estadísticas mensuales y anuales de forma clara y visual.</p>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <img src="https://img.icons8.com/fluency/96/secure-on.png" class="icono" alt="Seguridad" />
                <h3 class="mt-3">Acceso Seguro</h3>
                <p>Tus datos están protegidos. Solo tú puedes ver y modificar tus registros personales.</p>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">¿Por qué elegir <strong>CuentasClaras</strong>?</h2>
        <div class="row">

            <div class="col-md-4 mb-4" data-aos="zoom-in">
                <div class="card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-speedometer2 display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Rápido y Fácil</h5>
                        <p class="card-text">Registra tus gastos en segundos desde tu celular, tablet o PC sin complicaciones.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-bar-chart-fill display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Reportes Claros</h5>
                        <p class="card-text">Visualiza tus gastos por categoría, fechas y montos para tener el control total.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-lock-fill display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Seguridad Total</h5>
                        <p class="card-text">Tus datos personales y financieros siempre protegidos con encriptación y acceso seguro.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- CTA - Llamado a la acción -->
    <!-- CTA - Llamado a la acción con degradado -->
    <div style="background: linear-gradient(135deg, #3f51b5, #5c6bc0);" class="text-white text-center py-5" data-aos="fade-up">
        <div class="container">
            <h2 class="mb-3 fw-bold">¡Empieza a ordenar tus finanzas hoy!</h2>
            <p class="lead mb-4">Crea tu cuenta gratuita y lleva el control de tus gastos desde cualquier lugar.</p>
            <a href="registro.php" class="btn btn-warning btn-lg me-2">
                <i class="bi bi-person-plus-fill"></i> Crear Cuenta
            </a>
            <a href="login.php" class="btn btn-outline-light btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> Ya tengo cuenta
            </a>
        </div>
    </div>





    <!-- Footer -->
    <footer class="bg-primary text-white text-center p-3 mt-5">
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