<?php
session_start();

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    die("Error: El usuario no ha iniciado sesión.");
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tienda");

if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener el email del usuario desde la sesión/cookie
$usuario_email = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : $_COOKIE['usuario'];
echo "<script>console.log('Log: Email usuario obtenido: $usuario_email');</script>";

// Obtener el nombre del producto a comprar
if (!isset($_GET['id_producto'])) {
    die("<p>Error: No se ha seleccionado ningún producto.</p>");
}

$id_producto = intval($_GET['id_producto']);
echo "<script>console.log('Log: ID Producto recibido: $id_producto');</script>";

// Obtener el nombre del producto desde la base de datos
$sql_producto = "SELECT nombre FROM productos WHERE id_producto = ?";
$stmt_producto = mysqli_prepare($conexion, $sql_producto);
mysqli_stmt_bind_param($stmt_producto, "i", $id_producto);
mysqli_stmt_execute($stmt_producto);
$resultado_producto = mysqli_stmt_get_result($stmt_producto);
$producto = mysqli_fetch_assoc($resultado_producto);
mysqli_stmt_close($stmt_producto);

if (!$producto) {
    die("<p>Error: No se encontró el producto en la base de datos.</p>");
}

$nombre_producto = $producto['nombre'];
echo "<script>console.log('Log: Nombre del producto obtenido: $nombre_producto');</script>";

date_default_timezone_set('Europe/Madrid'); // Configura la zona horaria de Madrid-Bruselas
$fecha_compra = date('Y-m-d H:i:s');
echo "<script>console.log('Log: Fecha de compra generada: $fecha_compra');</script>";

// Registrar la compra en la tabla `datos`
$sql_compra = "INSERT INTO datos (nombre_producto, fecha_compra) VALUES (?, ?)";
$stmt_compra = mysqli_prepare($conexion, $sql_compra);
mysqli_stmt_bind_param($stmt_compra, "ss", $nombre_producto, $fecha_compra);

echo "<script>console.log('Log: Intentando registrar la compra...');</script>";

if (mysqli_stmt_execute($stmt_compra)) {
    echo "<script>console.log('Log: Compra registrada correctamente.');</script>";

    // **Eliminar el producto de la base de datos**
    $sql_eliminar = "DELETE FROM productos WHERE id_producto = ?";
    $stmt_eliminar = mysqli_prepare($conexion, $sql_eliminar);
    mysqli_stmt_bind_param($stmt_eliminar, "i", $id_producto);

    echo "<script>console.log('Log: Intentando eliminar el producto...');</script>";

    if (mysqli_stmt_execute($stmt_eliminar)) {
        echo "<script>console.log('Log: Producto eliminado correctamente.');</script>";
        echo "<h1>¡Compra realizada con éxito!</h1>";
        echo "<p>Gracias por tu compra. Ha sido añadida a nuestra lista de ventas</p>";
    } else {
        echo "<script>console.log('Error al eliminar el producto: " . mysqli_error($conexion) . "');</script>";
        echo "<p>Error al eliminar el producto.</p>";
    }

    mysqli_stmt_close($stmt_eliminar);
} else {
    echo "<script>console.log('Error al registrar la compra: " . mysqli_error($conexion) . "');</script>";
    echo "<p>Error al registrar la compra.</p>";
}

mysqli_stmt_close($stmt_compra);
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="style-compra.css">
<head>
    <meta charset="UTF-8">
    <title>Estado de la Compra</title>
</head>
<body>
    <a href="index.php"><button>Volver al inicio</button></a>
</body>
</html>
