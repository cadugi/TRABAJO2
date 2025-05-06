<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    die("Error: No hay una sesión iniciada.");
}

$usuario_email = $_SESSION['usuario'];

$conexion = mysqli_connect("localhost", "root", "", "tienda");

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error al conectar a la base de datos.");
}

// Obtener el ID del usuario de forma segura
$sql_usuario = "SELECT id FROM usuarios WHERE email = ?";
$stmt_usuario = mysqli_prepare($conexion, $sql_usuario);
mysqli_stmt_bind_param($stmt_usuario, "s", $usuario_email);
mysqli_stmt_execute($stmt_usuario);
$resultado_usuario = mysqli_stmt_get_result($stmt_usuario);
$usuario = mysqli_fetch_assoc($resultado_usuario);
$usuario_id = $usuario['id'];
mysqli_stmt_close($stmt_usuario);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar que los campos estén definidos
    if (!isset($_POST['producto_id'], $_POST['direccion'], $_POST['tarjeta'])) {
        die("Error: Faltan datos en el formulario.");
    }

    // Sanitizar los datos recibidos
    $producto_id = intval($_POST['producto_id']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $tarjeta = $_POST['tarjeta']; // No se almacena por seguridad

    // Generar código único de venta
    $codigo_venta = uniqid('VENTA_');

    // Obtener la fecha actual
    $fecha_compra = date('Y-m-d H:i:s');

    // Registrar la compra en la base de datos
    $sql_venta = "INSERT INTO compras (id_producto, id_comprador, direccion, codigo_venta, fecha_compra) 
                  VALUES (?, ?, ?, ?, ?)";
    $stmt_venta = mysqli_prepare($conexion, $sql_venta);
    mysqli_stmt_bind_param($stmt_venta, "iisss", $producto_id, $usuario_id, $direccion, $codigo_venta, $fecha_compra);

    if (!mysqli_stmt_execute($stmt_venta)) {
        die("Error al registrar la compra.");
    }
    mysqli_stmt_close($stmt_venta);

    // Eliminar el producto de la lista de productos disponibles
    $sql_eliminar_producto = "DELETE FROM productos WHERE id = ?";
    $stmt_eliminar = mysqli_prepare($conexion, $sql_eliminar_producto);
    mysqli_stmt_bind_param($stmt_eliminar, "i", $producto_id);

    if (!mysqli_stmt_execute($stmt_eliminar)) {
        die("Error al eliminar el producto.");
    }
    mysqli_stmt_close($stmt_eliminar);

    echo "<p>Compra realizada con éxito. Código de la venta: $codigo_venta</p>";
    echo "<a href='productos.php'>Volver a la lista de productos</a>";

    mysqli_close($conexion);
    exit;
} else {
    if (isset($_GET['producto_id'])) {
        $producto_id = intval($_GET['producto_id']);

        // Obtener detalles del producto de forma segura
        $sql_producto = "SELECT * FROM productos WHERE id = ?";
        $stmt_producto = mysqli_prepare($conexion, $sql_producto);
        mysqli_stmt_bind_param($stmt_producto, "i", $producto_id);
        mysqli_stmt_execute($stmt_producto);
        $resultado_producto = mysqli_stmt_get_result($stmt_producto);

        if (mysqli_num_rows($resultado_producto) == 0) {
            die("Error: Producto no encontrado.");
        }

        $producto = mysqli_fetch_assoc($resultado_producto);
        mysqli_stmt_close($stmt_producto);
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulario de Compra</title>
            <link rel="stylesheet" href="../style-compra.css">
        </head>
        <body>
            <header>Confirmar Compra</header>
            <main>
                <h1>Detalles de la Compra</h1>
                <form action="venta.php" method="POST">
                    <div class="producto-compra">
                        <div class="producto">
                            <img src="images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Producto">
                            <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                            <p>Categoría: <?php echo htmlspecialchars($producto['categoria']); ?></p>
                            <p>Precio: <?php echo htmlspecialchars($producto['precio']); ?> €</p>
                        </div>
                    </div>
                    <label for="direccion">Dirección de Envío:</label>
                    <input type="text" id="direccion" name="direccion" placeholder="Introduce tu dirección" required>

                    <label for="tarjeta">Número de Tarjeta de Crédito:</label>
                    <input type="text" id="tarjeta" name="tarjeta" placeholder="1234-5678-9012-3456" required>

                    <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto_id); ?>">

                    <button type="submit">Confirmar Compra</button>
                </form>
            </main>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Error: No se especificó un producto para comprar.</p>";
    }
}

mysqli_close($conexion);
?>
