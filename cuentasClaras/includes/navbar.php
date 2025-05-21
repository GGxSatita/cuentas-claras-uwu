<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">Cuentas Claras</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContenido">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gastos.php">Registrar Gasto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ver_gastos.php">Ver Gastos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="alacena.php">Alacena</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarPresupuesto" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Finanzas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarPresupuesto">
                        <li><a class="dropdown-item" href="presupuesto.php">Presupuesto</a></li>
                        <li><a class="dropdown-item" href="extras.php">Ingresos Extra</a></li>
                    </ul>
                </li>

            </ul>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-outline-light">Cerrar sesión</a>
            </div>
        </div>
    </div>
</nav>