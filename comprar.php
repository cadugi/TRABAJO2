<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del producto a comprar
if (isset($_GET['producto_id'])) {
    $producto_id = $_GET['producto_id'];

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tienda");

    if (!$conexion) {
        echo "Error al conectar: " . mysqli_connect_errno() . " " . mysqli_connect_error();
        exit();
    }

    // Obtener datos del producto
    $sql = "SELECT * FROM productos WHERE id = $producto_id";
    $resultado = mysqli_query($conexion, $sql);
    $producto = mysqli_fetch_assoc($resultado);

    // Verificar que el producto existe
    if (!$producto) {
        echo "Producto no encontrado.";
        exit();
    }

    // Verificar si el comprador es el mismo que el vendedor
    if ($producto['id_vendedor'] == $_SESSION['usuario_id']) {
        echo "No puedes comprar un producto que has publicado.";
        exit();
    }

    // Registrar la compra
    $sql_compra = "INSERT INTO compras (id_producto, id_comprador) VALUES ($producto_id, (SELECT id FROM usuarios WHERE correo = '" . $_SESSION['usuario'] . "'))";
    if (mysqli_query($conexion, $sql_compra)) {
        // Eliminar producto de la venta
        $sql_eliminar = "DELETE FROM productos WHERE id = $producto_id";
        mysqli_query($conexion, $sql_eliminar);
        echo "Compra realizada con éxito.";
    } else {
        echo "Error al registrar la compra.";
    }

    mysqli_close($conexion);
} else {
    echo "No se ha seleccionado ningún producto.";
}
?>
