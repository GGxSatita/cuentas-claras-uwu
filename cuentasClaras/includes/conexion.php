<?php
$host = 'localhost'; // o tu IP de servidor
$dbname = 'cuentasclaras';
$username = 'root'; // o el nombre de usuario que uses
$password = ''; // si tienes una contraseña en tu base de datos

try {
    // Intentamos realizar la conexión
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Redirigimos al usuario a una página de error personalizada
    header("Location: error.php");
    exit();
}
?>
