<?php
session_start(); // Iniciamos la sesión para poder usar $_SESSION

// Verificamos si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigimos al login si no está autenticado
    exit(); // Terminamos el script
}

// Redirigimos al menú de administrador si el usuario es admin
if ($_SESSION['usuario'] == 'admin@tienda.com') {
    header("Location: menu_admin.php");
    exit();
}

// Determinar la imagen de perfil
if (isset($_SESSION['es_anonimo']) && $_SESSION['es_anonimo'] == true) {
    // Imagen si es un usuario anónimo
    $imagen_perfil = 'images/usuarios-prep/anonimo.png';
} elseif ($_SESSION['usuario'] == 'admin@tienda.com') {
    // Imagen del administrador (esto no debería pasar porque ya se redirige)
    $imagen_perfil = 'images/usuarios-prep/admin.png';
} else {
    // Para usuarios normales, seleccionamos una imagen aleatoria
    // Como no se puede usar glob() (no está en el temario), se hace manual
    $imagenes = array(
        'images/usuarios-prep/1.png',
        'images/usuarios-prep/2.png',
        'images/usuarios-prep/3.png',
        'images/usuarios-prep/4.png',
        'images/usuarios-prep/5.png',
        'images/usuarios-prep/6.png',
        'images/usuarios-prep/7.png',
        'images/usuarios-prep/8.png',
        'images/usuarios-prep/9.png',
    );

    $numero = rand(0, count($imagenes) - 1); // Número aleatorio para la imagen
    $imagen_perfil = $imagenes[$numero]; // Asignamos la imagen
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tienda General Fonsi</title>
    <link rel="shortcut icon" href="images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <style>
        .perfil-container {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            align-items: center;
        }
        .cerrar-sesion {
            margin-right: 10px;
            width: 40px;
            height: 40px;
            cursor: pointer;
        }
        .perfil {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
        }
        .perfil img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?> <!-- Incluimos el menú desde otro archivo -->

    <div class="perfil-container">
        <!-- Botón para cerrar sesión -->
        <a href="logout.php">
            <img src="images/apagado.png" alt="Cerrar sesión" class="cerrar-sesion">
        </a>
        <!-- Imagen de perfil del usuario -->
        <div class="perfil">
            <img src="<?php echo $imagen_perfil; ?>" alt="Foto de perfil">
        </div>
    </div>

    <main>
        <section class="descripcion">
            <h1>Bienvenido, <?php echo $_SESSION['nombre_completo']; ?>!</h1>
            <p>En nuestra tienda encontrarás una amplia variedad de productos de calidad, desde moda y accesorios hasta tecnología y electrodomésticos. Nuestro objetivo es ofrecerte los mejores productos al mejor precio, con un servicio excepcional.</p>
        </section>

        <section class="producto-banner">
            <a href="productos.php#motor">
                <div class="producto">
                    <img src="images/motor.png" alt="producto-banner 1">
                    <h3>Motor y accesorios</h3>
                    <p>pagina ideal para encontrar todo lo necesario para tu vehiculo a motor.</p>
                    <p><strong>Desde: $49.99</strong></p>
                </div>
            </a>
            <a href="productos.php#moda">
                <div class="producto">
                    <img src="images/ropa-limpia.png" alt="producto-banner 2">
                    <h3>Moda y accesorios</h3>
                    <p>encuentra tu propio estilo que te haga ver como una persona nueva.</p>
                    <p><strong>Desde: $89.99</strong></p>
                </div>
            </a>
            <a href="productos.php#electrodomesticos">
                <div class="producto">
                    <img src="images/lavadora.png" alt="producto-banner 3">
                    <h3>Electrodomésticos</h3>
                    <p>electrodomesticos indispensables para tu hogar.</p>
                    <p><strong>Desde: $29.99</strong></p>
                </div>
            </a>
            <a href="productos.php#moviles">
                <div class="producto">
                    <img src="images/telefono.png" alt="producto-banner 4">
                    <h3>Móviles y telefonía</h3>
                    <p>disponemos de todas las marcas en el mercado encuentra tu telefono ideal.</p>
                    <p><strong>Desde: $99.99</strong></p>
                </div>
            </a>
            <a href="productos.php#informatica">
                <div class="producto">
                    <img src="images/computadora.png" alt="producto-banner 5">
                    <h3>Informática y electrónica</h3>
                    <p>desde ordenadores portatiles hasta PC´s mas potentes que los de la NASA.</p>
                    <p><strong>Desde: $199.99</strong></p>
                </div>
            </a>
            <a href="productos.php#deportes">
                <div class="producto">
                    <img src="images/deporte.png" alt="producto-banner 6">
                    <h3>Deporte y ocio</h3>
                    <p>siempre es buen momento para empezar una nueva afición.</p>
                    <p><strong>Desde: $4.99</strong></p>
                </div>
            </a>
            <a href="productos.php#tv">
                <div class="producto">
                    <img src="images/camara.png" alt="producto-banner 7">
                    <h3>TV, audio y fotografía</h3>
                    <p>desde ver al madrid jugar hasta hacer fotos con tu familia en esta seccion todo te hara llorar.</p>
                    <p><strong>Desde: $99.99</strong></p>
                </div>
            </a>
            <a href="productos.php#jardin">
                <div class="producto">
                    <img src="images/flores.png" alt="producto-banner 8">
                    <h3>Hogar y Jardín</h3>
                    <p>siempre esta bien tener un jardin bonito o accesorios que haran tu vida mas facil.</p>
                    <p><strong>Desde: $9.99</strong></p>
                </div>
            </a>
            <a href="productos.php#libros">
                <div class="producto">
                    <img src="images/libro.png" alt="producto-banner 9">
                    <h3>Cine, libros y música</h3>
                    <p>desde el ultimo betseller hasta la mejor pelicula del mundo, encuentrala aqui.</p>
                    <p><strong>Desde: $19.99</strong></p>
                </div>
            </a>
            <a href="productos.php#niño">
                <div class="producto">
                    <img src="images/chico.png" alt="producto-banner 10">
                    <h3>Niños y bebés</h3>
                    <p>Sabemos lo dificil que es criar una criatura pero desde fonsishop te lo ponemso mas facil.</p>
                    <p><strong>Desde: $29.99</strong></p>
                </div>
            </a>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 tienda General Fonsi. Todos los derechos reservados. (bueno solo es para vaquero asique en realidad no hace falta)</p>
    </footer>
</body>
</html>
