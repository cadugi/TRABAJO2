<?php
session_start(); // Iniciar sesión

// Conexión a la base de datos (estilo clásico)
$conexion = mysqli_connect("localhost", "root", "", "tienda");

if (!$conexion) {
    echo "Error al conectar: " . mysqli_connect_errno() . " " . mysqli_connect_error();
    exit();
}

// Inicializar error
$error = "";

// Comprobar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Si se seleccionó el modo anónimo
    if (isset($_POST['anonimo']) && $_POST['anonimo'] == 'true') {
        $_SESSION['usuario'] = 'anonimo';
        $_SESSION['nombre_completo'] = 'Usuario Anónimo';
        $_SESSION['imagen_perfil'] = 'images/usuarios-prep/anonimo.png';
        $_SESSION['es_anonimo'] = true;

        header("Location: index.php");
        exit();
    }

    // Obtener valores del formulario
    $email_telefono = $_POST['email_telefono'];
    $contrasena = $_POST['contraseña'];

    // Si es el administrador
    if ($email_telefono == 'ADMINISTRADOR' && $contrasena == '4237') {
        $_SESSION['usuario'] = 'admin@tienda.com';
        $_SESSION['nombre_completo'] = 'Administrador';
        $_SESSION['imagen_perfil'] = 'images/usuarios-prep/admin.png';
        $_SESSION['es_anonimo'] = false;

        header("Location: menu_admin.php");
        exit();
    }

    // Consulta en la base de datos (usando SQL directa como en los apuntes)
    $sql = "SELECT nombre, apellidos, contraseña FROM Usuarios WHERE email = '$email_telefono' OR telefono = '$email_telefono';";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $contrasena_guardada = $fila['contraseña'];

        // Comparar contraseñas directamente (sin password_verify)
        if ($contrasena == $contrasena_guardada) {
            $_SESSION['usuario'] = $email_telefono;
            $_SESSION['nombre_completo'] = $fila['nombre'] . " " . $fila['apellidos'];
            $_SESSION['imagen_perfil'] = 'images/default-profile.png';
            $_SESSION['es_anonimo'] = false;

            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El usuario no existe.";
    }

    // Mostrar mensaje de error (no redirigimos por URL)
    echo "<p style='color:red; text-align:center;'>$error</p>";
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style-login.css">
    <title>Login</title>
    <script src="script.js"></script>
</head>
<body>
    <h1>Inicio de Sesión</h1>
    <form action="login.php" method="POST" class="login-form">
        <label for="email_telefono">Email o Teléfono:</label><br>
        <input type="text" id="email_telefono" name="email_telefono" required><br><br>
        
        <label for="contraseña">Contraseña:</label><br>
        <input type="password" id="contraseña" name="contraseña" required><br><br>
        
        <button type="submit" class="login-boton">Iniciar Sesión</button>
    </form>

    <div class="botones-contenedor">
        <button type="button" class="registro-boton" onclick="window.location.href='registro.php'">Registrarse</button>
        <form action="login.php" method="POST" class="anonimo-form">
            <input type="hidden" name="anonimo" value="true">
            <button type="submit" class="anonimo-boton">Modo Anónimo</button>
        </form>
    </div>

    <!-- Contenedor para el pop-up -->
    <div id="popup" class="popup" style="display: none;">
        <p id="popup-message"></p>
    </div>
</body>
</html>
