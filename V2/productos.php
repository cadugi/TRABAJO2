<?php
session_start();

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tienda");

if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

// Obtener filtros
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;

// Construcción dinámica de la consulta
$sql = "SELECT * FROM productos";

if ($categoria) {
    $sql .= " WHERE categoria = '$categoria'";
}

// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);

// Botón para publicar producto (siempre visible)
echo "<div style='margin-bottom: 20px; text-align: center;'>";
echo "<a href='publicar.php' style='display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;'>Publicar Producto</a>";
echo "</div>";

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    echo "<p>No hay productos disponibles.</p>";
} else {
    echo "<h1>Productos en Venta</h1>";

    echo "<div style='display: flex; flex-wrap: wrap;'>";

    while ($producto = mysqli_fetch_assoc($resultado)) {
        echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px; width: 200px;'>";
        echo "<h3>" . htmlspecialchars($producto['nombre']) . "</h3>";
        echo "<p>Categoría: " . htmlspecialchars($producto['categoria']) . "</p>";
        echo "<p>Precio: " . htmlspecialchars($producto['precio']) . " €</p>";
        echo "<p>" . htmlspecialchars($producto['descripcion']) . "</p>";

        if (!empty($producto['imagen'])) {
            echo "<img src='" . htmlspecialchars($producto['imagen']) . "' alt='" . htmlspecialchars($producto['nombre']) . "' style='width:100%;'>";
        } else {
            echo "<p>No hay imagen disponible.</p>";
        }

        // Botón para comprar producto
        echo "<a href='venta.php?producto_id=" . htmlspecialchars($producto['id']) . "' style='display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;'>Comprar</a>";

        echo "</div>";
    }

    echo "</div>";
}

// Cerrar conexión
mysqli_close($conexion);
?>
