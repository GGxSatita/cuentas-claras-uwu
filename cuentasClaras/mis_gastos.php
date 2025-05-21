<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

$id_usuario = $_SESSION['usuario_id'];
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
<div class="container mt-5">
    <h1 class="mb-4">Mis Gastos Registrados</h1>

    <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar por categoría o descripción...">

    <div id="tabla-gastos"></div>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Volver al Dashboard</a>
</div>

<script src="js/gastos.js"></script>
</body>
</html>
