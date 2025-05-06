<link rel="stylesheet" href="style-publicar.css">
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
    $imagen = $_FILES['imagen']['name'];

    // Verificar y crear el directorio 'images' si no existe
    if (!is_dir('images')) {
        mkdir('images', 0777, true);
    }

    // Mover la imagen a la carpeta 'images'
    $ruta_imagen = "images/" . $imagen;
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
        die("<p>Error al subir la imagen. Verifica los permisos del directorio.</p>");
    }

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tienda");

    if (!$conexion) {
        die("<p>Error al conectar: " . mysqli_connect_errno() . " " . mysqli_connect_error() . "</p>");
    }

    // Insertar producto en la base de datos
    $sql = "INSERT INTO productos (nombre, categoria, descripcion, precio, imagen, id_vendedor) 
            VALUES ('$nombre', '$categoria', '$descripcion', '$precio', '$ruta_imagen', 
            (SELECT id FROM usuarios WHERE correo = '" . $_SESSION['usuario'] . "'))";

    if (mysqli_query($conexion, $sql)) {
        echo "<p>Producto publicado con éxito.</p>";
    } else {
        echo "<p>Error al publicar el producto: " . mysqli_error($conexion) . "</p>";
    }

    mysqli_close($conexion);
}
?>

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
    <input type="file" name="imagen" required>
    <button type="submit">Publicar Producto</button>
</form>
