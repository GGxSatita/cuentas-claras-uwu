<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $monto = floatval($_POST['monto']);
    $tipo = trim($_POST['tipo']);
    
    if ($monto > 0 && !empty($tipo)) {
        $sql = "UPDATE ingresos_adicionales SET monto = ?, tipo = ? WHERE id = ? AND id_usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$monto, $tipo, $id, $_SESSION['usuario_id']]);

        header("Location: extras.php?editado=1");
        exit();
    } else {
        header("Location: extras.php?error=1");
        exit();
    }
}
?>
