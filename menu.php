<?php
// Solo iniciamos la sesión si la variable superglobal no está definida
if (!isset($_SESSION)) {
    session_start(); // Iniciar sesión
}
?>

<div class="menu" id="menu">
    <div class="menu-header">
        <h2>Menú</h2>
    </div>
    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="registro.php">Registro</a></li>
        <li><a href="productos.php">Catálogo de productos</a></li>
        <?php
        // Si el usuario NO es anónimo, puede ver el enlace para publicar
        if (!isset($_SESSION['es_anonimo']) || $_SESSION['es_anonimo'] != true) {
            echo '<li><a href="publicar.php">Publicar producto</a></li>';
        } else {
            echo '<li><a href="#" style="color: gray; pointer-events: none; cursor: default;">Publicar producto</a></li>';
        }
        ?>
    </ul>
</div>

<div class="menu-toggle" id="menu-toggle">
    ☰ <!-- Ícono de menú -->
</div>

<style>
/* Estilo del menú */
.menu {
    width: 250px;
    background-color: #005db4; /* Azul principal */
    color: white;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    height: 100vh; /* Altura completa de la pantalla */
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    transition: transform 0.3s ease;
}

.menu.hidden {
    transform: translateX(-100%);
}

.menu-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

.menu h2 {
    font-size: 1.5em;
    margin: 0;
}

.menu ul {
    list-style: none;
    padding: 0;
    margin: 20px 0 0 0;
}

.menu ul li {
    margin-bottom: 15px;
}

.menu ul li a {
    text-decoration: none;
    color: white;
    font-size: 1.2em;
    transition: color 0.3s ease;
}

.menu ul li a:hover {
    color: #ffcc00;
}

.menu ul li a[style*="pointer-events: none"] {
    color: gray;
}

.menu-toggle {
    position: fixed;
    top: 20px;
    left: 250px;
    background-color: rgb(0, 43, 83);
    color: white;
    font-size: 1.5em;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1100;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 70px;
    transition: left 0.3s ease;
}

.menu-toggle:hover {
    background-color: rgb(184, 147, 0);
    color: black;
}

.menu.hidden + .menu-toggle {
    left: 0;
}

main {
    margin-left: 270px;
    padding: 20px;
    flex: 1;
    margin-top: 20px;
    transition: margin-left 0.3s ease;
}

main.expanded {
    margin-left: 40px;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const menu = document.getElementById("menu");
    const menuToggle = document.getElementById("menu-toggle");
    const mainContent = document.querySelector("main");

    menuToggle.addEventListener("click", function () {
        menu.classList.toggle("hidden");
        if (mainContent) {
            mainContent.classList.toggle("expanded");
        }
    });
});
</script>