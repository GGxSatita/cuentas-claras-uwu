<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Gastos - CuentasClaras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container" style="margin-top: 90px;">
    <h1 class="mb-4">Mis Gastos Registrados</h1>

    <!-- Filtros -->
    <form id="filtroForm" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select">
                <option value="">Todas</option>
                <option value="Agua">Agua</option>
                <option value="Luz">Luz</option>
                <option value="Gas">Gas</option>
                <option value="Comida">Comida</option>
                <option value="Internet">Internet</option>
                <option value="Otros">Otros</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Desde</label>
            <input type="date" name="desde" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Hasta</label>
            <input type="date" name="hasta" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Buscar</label>
            <input type="text" name="busqueda" class="form-control" placeholder="Descripción">
        </div>
        <div class="col-md-2 d-grid">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <!-- Tabla -->
    <div id="tablaGastos"></div>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Volver al Dashboard</a>
</div>

<script>
$(document).ready(function(){
    cargarGastos();

    // Al enviar el formulario
    $("#filtroForm").on("submit", function(e){
        e.preventDefault();
        cargarGastos();
    });

    // Función para cargar gastos con AJAX
    function cargarGastos(ordenarPor='fecha', orden='DESC', pagina=1){
        $.ajax({
            url: "ajax_gastos.php",
            method: "GET",
            data: $("#filtroForm").serialize() + '&ordenarPor=' + ordenarPor + '&orden=' + orden + '&pagina=' + pagina,
            success: function(data){
                $("#tablaGastos").html(data);
            }
        });
    }

    // Delegado para ordenamiento y paginación
    $(document).on('click', '.ordenar', function(){
        let ordenarPor = $(this).data('columna');
        let orden = $(this).data('orden');
        cargarGastos(ordenarPor, orden);
    });

    $(document).on('click', '.pagina', function(e){
        e.preventDefault();
        let pagina = $(this).data('pagina');
        cargarGastos(undefined, undefined, pagina);
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
