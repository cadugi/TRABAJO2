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

// Organizar productos por categoría
$productos_por_categoria = [];

while ($producto = mysqli_fetch_assoc($resultado)) {
    $categoria = $producto['categoria'] ? htmlspecialchars($producto['categoria']) : "Sin categoría";
    $productos_por_categoria[$categoria][] = $producto;
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
    <link rel="stylesheet" href="style-productos.css">
</head>
<body>
    <h1>Lista de Productos</h1>

    <?php foreach ($productos_por_categoria as $categoria => $productos) : ?>
        <h2><?php echo $categoria; ?></h2>
        <div class="producto-catalogo">
            <?php foreach ($productos as $producto) : ?>
                <div class="producto">
                    <a href="comprar.php?id_producto=<?php echo urlencode($producto['id_producto']); ?>">
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['producto_nombre']); ?>">
                        <h3><?php echo htmlspecialchars($producto['producto_nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p><strong>Precio: $<?php echo htmlspecialchars($producto['precio']); ?></strong></p>
                        <p>Vendedor: <?php echo $producto['vendedor_nombre'] ? htmlspecialchars($producto['vendedor_nombre']) : 'No especificado'; ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
