<?php
session_start(); // Iniciar sesión

// Verificar si el usuario está logueado
if (isset($_SESSION['nombre_completo'])) {
    $nombre_usuario = $_SESSION['nombre_completo'];
} else {
    $nombre_usuario = 'Usuario';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Confirmada</title>
    <link rel="shortcut icon" href="images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style-confirmacion.css">
    <style>
        body.confirmacion main {
            margin-left: 0 !important;
            transition: none !important;
        }
    </style>
</head>
<body class="confirmacion">
    <?php include 'menu.php'; ?>

    <div class="container">
        <div class="icon">✔️</div>
        <header>
            <h1>Compra Confirmada</h1>
        </header>
        <main>
            <?php
            // Obtener los datos desde la URL
            if (isset($_GET['nombre'])) {
                $nombre = $_GET['nombre'];
            } else {
                $nombre = "Producto desconocido";
            }

            if (isset($_GET['precio'])) {
                $precio = $_GET['precio'];
            } else {
                $precio = "0.00";
            }
            ?>

            <section class="confirmacion">
                <h2>¡Gracias por tu compra, <?php echo $nombre_usuario; ?>!</h2>
                <p>Has comprado: <strong><?php echo $nombre; ?></strong></p>
                <p>Precio: <strong>$<?php echo $precio; ?></strong></p>
                <a href="index.php" class="confirm-button">Volver al Inicio</a>
                <a href="productos.php" class="back-button">Seguir Comprando</a>
            </section>
        </main>
    </div>
</body>
</html>
