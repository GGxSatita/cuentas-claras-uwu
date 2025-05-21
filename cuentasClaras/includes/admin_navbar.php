<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_admin.php">CuentasClaras Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido -->
<div class="container mt-4">
    <h1 class="mb-4">Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?> 👋</h1>

    <div class="row g-4">
        <!-- Resumen -->
        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Total usuarios</h5>
                    <h3>120</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h5>Total ingresos</h5>
                    <h3>$1.250.000</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h5>Productos en catálogo</h5>
                    <h3>36</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h5>Tickets pendientes</h5>
                    <h3>4</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="row mt-5">
        <div class="col-md-3">
            <a href="gestionar_usuarios.php" class="btn btn-primary w-100 p-3">👥 Gestionar Usuarios</a>
        </div>
        <div class="col-md-3">
            <a href="gestionar_catalogo.php" class="btn btn-primary w-100 p-3">📦 Gestionar Catálogo</a>
        </div>
        <div class="col-md-3">
            <a href="gestionar_inventario.php" class="btn btn-primary w-100 p-3">🏷️ Gestionar Inventario</a>
        </div>
        <div class="col-md-3">
            <a href="ver_ingresos.php" class="btn btn-primary w-100 p-3">💸 Ver Ingresos</a>
        </div>
    </div>
</div>