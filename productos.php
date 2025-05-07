<?php
// Conexión clásica usando mysqli
$conexion = mysqli_connect("localhost", "root", "", "tienda");

if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_errno() . " " . mysqli_connect_error());
}

// Consulta de todos los productos con el nombre del vendedor
$sql = "SELECT p.id_producto, p.nombre AS producto_nombre, p.descripcion, p.precio, p.categoria, p.imagen, 
               u.nombre AS vendedor_nombre 
        FROM productos p
        LEFT JOIN usuarios u ON p.id_vendedor = u.id_usuario";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>tienda</title>
    <link rel="stylesheet" href="style-productos.css">
</head>
<body>
    <h1>Lista de Productos</h1>
    <div class="producto-catalogo">
        <?php
        // Mostrar todos los productos
        while ($producto = mysqli_fetch_assoc($resultado)) {
            echo '<div class="producto">';
            echo '<a href="comprar.php?id_producto=' . urlencode($producto['id_producto']) . '">'; // Usar urlencode para evitar problemas en la URL
            echo '<img src="' . htmlspecialchars($producto['imagen']) . '" alt="' . htmlspecialchars($producto['producto_nombre']) . '">';
            echo '<h3>' . htmlspecialchars($producto['producto_nombre']) . '</h3>';
            echo '<p>' . htmlspecialchars($producto['descripcion']) . '</p>';
            echo '<p><strong>Precio: $' . htmlspecialchars($producto['precio']) . '</strong></p>';
            echo '<p>Vendedor: ' . ($producto['vendedor_nombre'] ? htmlspecialchars($producto['vendedor_nombre']) : 'No especificado') . '</p>';
            echo '</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>

<?php
mysqli_close($conexion);
?>
