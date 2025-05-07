<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen'];

    // Validar que la imagen tiene un formato permitido
    $extensiones_permitidas = ['png', 'jpg', 'jpeg', 'webp'];
    $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $extensiones_permitidas)) {
        die("<p>Error: Solo se permiten imágenes PNG, JPG y WEBP.</p>");
    }

    // Verificar y crear el directorio 'images' si no existe
    if (!is_dir('images')) {
        mkdir('images', 0777, true);
    }

    // Mover la imagen a la carpeta 'images'
    $ruta_imagen = "images/" . basename($imagen['name']);
    if (!move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
        die("<p>Error al subir la imagen. Verifica los permisos del directorio.</p>");
    }

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tienda");

    if (!$conexion) {
        die("<p>Error al conectar: " . mysqli_connect_errno() . " " . mysqli_connect_error() . "</p>");
    }

    // Obtener el id_usuario del usuario autenticado
    $usuario_email = $_SESSION['usuario'];
    $sql_usuario = "SELECT id_usuario FROM usuarios WHERE email = ?";
    $stmt_usuario = mysqli_prepare($conexion, $sql_usuario);
    mysqli_stmt_bind_param($stmt_usuario, "s", $usuario_email);
    mysqli_stmt_execute($stmt_usuario);
    $resultado_usuario = mysqli_stmt_get_result($stmt_usuario);
    $usuario = mysqli_fetch_assoc($resultado_usuario);

    if ($usuario) {
        $id_vendedor = $usuario['id_usuario'];
    } else {
        die("<p>Error: No se pudo obtener el ID del usuario autenticado.</p>");
    }
    mysqli_stmt_close($stmt_usuario);

    // Insertar producto en la base de datos
    $sql = "INSERT INTO productos (nombre, categoria, descripcion, precio, imagen, id_vendedor) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_producto = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt_producto, "ssssss", $nombre, $categoria, $descripcion, $precio, $ruta_imagen, $id_vendedor);

    if (mysqli_stmt_execute($stmt_producto)) {
        echo "<p>Producto publicado con éxito.</p>";
        header("Location: productos.php"); // Redirección automática
        exit();
    } else {
        echo "<p>Error al publicar el producto: " . mysqli_error($conexion) . "</p>";
    }

    mysqli_stmt_close($stmt_producto);
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Producto</title>
    <link rel="stylesheet" href="style-publicar.css">
</head>
<body>
    <h1>Publicar un Nuevo Producto</h1>

    <form action="publicar.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <select name="categoria" required>
            <option value="Motor y accesorios">Motor y accesorios</option>
            <option value="Moda y accesorios">Moda y accesorios</option>
            <option value="Electrodomésticos">Electrodomésticos</option>
            <option value="Móviles y telefonía">Móviles y telefonía</option>
            <option value="Informática y electrónica">Informática y electrónica</option>
            <option value="Deporte y ocio">Deporte y ocio</option>
            <option value="TV, audio y fotografía">TV, audio y fotografía</option>
            <option value="Hogar y Jardín">Hogar y Jardín</option>
            <option value="Cine, libros y música">Cine, libros y música</option>
            <option value="Niños y bebés">Niños y bebés</option>
        </select>
        <textarea name="descripcion" placeholder="Descripción" required></textarea>
        <input type="number" name="precio" placeholder="Precio" required>
        <input type="file" name="imagen" id="imagenInput" accept=".png, .jpg, .jpeg, .webp" required>
        <img id="vistaPrevia" src="" alt="Vista previa de la imagen" style="display:none; max-width: 200px; margin-top: 10px;">
        <button type="submit">Publicar Producto</button>
    </form>

    <script>
        document.getElementById('imagenInput').addEventListener('change', function(event) {
            const vistaPrevia = document.getElementById('vistaPrevia');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    vistaPrevia.src = e.target.result;
                    vistaPrevia.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
