<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Producto</title>
    <link rel="stylesheet" href="../style-compra.css"> <!-- Enlace a un archivo CSS opcional -->
</head>
<body>
    <h1>Comprar Producto</h1>
    <?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }

    $conexion = mysqli_connect("localhost", "root", "", "tienda");

    if (!$conexion) {
        die("Error al conectar: " . mysqli_connect_error());
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['producto_id'])) {
        // Registrar la compra
        $producto_id = intval($_GET['producto_id']);
        $usuario_email = $_SESSION['usuario'];

        // Obtener el ID del usuario
        $sql_usuario = "SELECT id FROM usuarios WHERE email = ?";
        $stmt_usuario = mysqli_prepare($conexion, $sql_usuario);
        mysqli_stmt_bind_param($stmt_usuario, "s", $usuario_email);
        mysqli_stmt_execute($stmt_usuario);
        $resultado_usuario = mysqli_stmt_get_result($stmt_usuario);
        $usuario = mysqli_fetch_assoc($resultado_usuario);
        $usuario_id = $usuario['id'];
        mysqli_stmt_close($stmt_usuario);

        // Generar código único de venta
        $codigo_venta = uniqid('VENTA_');
        $fecha_compra = date('Y-m-d H:i:s');

        // Registrar la compra en la base de datos
        $sql_venta = "INSERT INTO compras (id_producto, id_comprador, direccion, codigo_venta, fecha_compra) 
                      VALUES (?, ?, 'Dirección predeterminada', ?, ?)";
        $stmt_venta = mysqli_prepare($conexion, $sql_venta);
        mysqli_stmt_bind_param($stmt_venta, "iiss", $producto_id, $usuario_id, $codigo_venta, $fecha_compra);

        if (mysqli_stmt_execute($stmt_venta)) {
            echo "<p>Compra realizada con éxito. Código de la venta: $codigo_venta</p>";
            echo "<a href='productos.php'>Volver a la lista de productos</a>";
        } else {
            echo "<p>Error al registrar la compra.</p>";
        }

        mysqli_stmt_close($stmt_venta);

        // Eliminar el producto de la lista de productos disponibles
        $sql_eliminar_producto = "DELETE FROM productos WHERE id = ?";
        $stmt_eliminar = mysqli_prepare($conexion, $sql_eliminar_producto);
        mysqli_stmt_bind_param($stmt_eliminar, "i", $producto_id);

        if (mysqli_stmt_execute($stmt_eliminar)) {
            echo "<p>El producto ha sido eliminado del inventario.</p>";
        } else {
            echo "<p>Error al eliminar el producto.</p>";
        }

        mysqli_stmt_close($stmt_eliminar);
    } elseif (isset($_GET['producto_id'])) {
        // Mostrar los detalles del producto
        $producto_id = intval($_GET['producto_id']);

        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt_producto = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt_producto, "i", $producto_id);
        mysqli_stmt_execute($stmt_producto);
        $resultado = mysqli_stmt_get_result($stmt_producto);
        $producto = mysqli_fetch_assoc($resultado);

        if (!$producto) {
            die("Producto no encontrado.");
        }

        echo "<h2>Producto: " . htmlspecialchars($producto['nombre']) . "</h2>";
        echo "<p>Descripción: " . htmlspecialchars($producto['descripcion']) . "</p>";
        echo "<p>Precio: " . htmlspecialchars($producto['precio']) . "€</p>";
        echo "<img src='" . htmlspecialchars($producto['imagen']) . "' alt='Imagen del producto'>";
        echo "<form action='comprar.php?producto_id=$producto_id' method='POST'>";
        echo "<button type='submit'>Confirmar Compra</button>";
        echo "</form>";

        mysqli_stmt_close($stmt_producto);
    } else {
        echo "<p>Error: No se especificó un producto para comprar.</p>";
    }

    mysqli_close($conexion);
    ?>
</body>
</html>