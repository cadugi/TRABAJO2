<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];

    if (!is_dir('images')) {
        mkdir('images', 0777, true);
    }

    $ruta_imagen = "images/" . $imagen;
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
        die("Error al subir la imagen.");
    }

    $conexion = mysqli_connect("localhost", "root", "", "tienda");

    if (!$conexion) {
        die("Error al conectar: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO productos (nombre, categoria, descripcion, precio, imagen, id_vendedor) 
            VALUES ('$nombre', '$categoria', '$descripcion', '$precio', '$ruta_imagen', 
            (SELECT id FROM usuarios WHERE email = '" . $_SESSION['usuario'] . "'))";

    if (mysqli_query($conexion, $sql)) {
        echo "Producto publicado con éxito.";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Producto</title>
    <link rel="stylesheet" href="../style-publicar.css"> <!-- Enlace a un archivo CSS opcional -->
</head>
<body>
    <h1>Publicar Producto</h1>
    <form action="publicar.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Introduce el nombre del producto" required>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
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

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" placeholder="Introduce una descripción del producto" required></textarea>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" placeholder="Introduce el precio" required>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" required>

        <button type="submit">Publicar Producto</button>
    </form>
</body>
</html>