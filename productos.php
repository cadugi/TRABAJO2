<?php
// Conexión clásica usando mysqli
$conexion = mysqli_connect("localhost", "root", "", "tienda");

if (!$conexion) {
    echo "Error al conectar: " . mysqli_connect_errno() . " " . mysqli_connect_error();
    exit();
}

// Verificar si el usuario está autenticado
session_start();
$usuario_autenticado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;

// Consulta de productos
$sql1 = "SELECT id, nombre, descripcion, precio, categoria, imagen, id_vendedor FROM productos";
if ($usuario_autenticado) {
    // Si el usuario está autenticado, mostramos productos de todos, o solo los suyos
    if ($_SESSION['usuario'] != 'admin@tienda.com') {
        $sql1 .= " WHERE id_vendedor != (SELECT id FROM usuarios WHERE correo = '$usuario_autenticado')";
    }
}

$resultado = mysqli_query($conexion, $sql1);

// Agrupamos los productos por categoría
$productosPorCategoria = array();
while ($producto = mysqli_fetch_assoc($resultado)) {
    $categoria = $producto['categoria'];
    if (!isset($productosPorCategoria[$categoria])) {
        $productosPorCategoria[$categoria] = array();
    }
    $productosPorCategoria[$categoria][] = $producto;
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
    <link rel="stylesheet" href="style-productos.css">
    <style>
        /* Añadir los estilos aquí */
    </style>
</head>
<body>
    <?php include 'menu.php'; ?> <!-- Menú lateral -->

    <main>
        <?php
        // Mostrar productos agrupados por categoría
        foreach ($productosPorCategoria as $categoria => $lista) {
            echo "<section>";
            echo "<h2>$categoria</h2>";
            echo '<div class="producto-catalogo">';

            foreach ($lista as $producto) {
                echo '<div class="producto">';
                echo '<a href="comprar.php?producto_id=' . $producto['id'] . '">';
                echo '<img src="' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
                echo '<h3>' . $producto['nombre'] . '</h3>';
                echo '<p>' . $producto['descripcion'] . '</p>';
                echo '<p><strong>$' . $producto['precio'] . '</strong></p>';
                echo '</a>';
                echo '</div>';
            }

            echo '</div>';
            echo "</section>";
        }
        ?>
    </main>
</body>
</html>
