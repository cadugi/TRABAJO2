<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tienda");

if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener todas las compras registradas
$sql_historial = "SELECT * FROM datos ORDER BY fecha_compra DESC";
$resultado = mysqli_query($conexion, $sql_historial);

?>

<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="style-historial.css">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Historial de Compras</h1>

    <table>
        <tr>
            <th>compra numero:</th>
            <th>Nombre del Producto</th>
            <th>Fecha de Compra</th>
        </tr>
        <?php
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila['id_compra'] . "</td>";
                echo "<td>" . htmlspecialchars($fila['nombre_producto']) . "</td>";
                echo "<td>" . $fila['fecha_compra'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay compras registradas.</td></tr>";
        }
        mysqli_close($conexion);
        ?>
    </table>

    <a href="index.php"><button>Volver al inicio</button></a>
</body>
</html>
